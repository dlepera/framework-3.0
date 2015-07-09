<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 13:52:51
 */

namespace Geral\Controle;

abstract class Principal{
    protected $modelo, $visao, $nome;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function __get($n){ return m_get($this, $n); } // Fim do método __get
    public function __set($n,$v){ return m_set($this, $n, $v); } // Fim do método __set



    public function __construct($m, $nm, $nc){
        $this->visao    = new \Visao($nm);
        $this->modelo   = $m;
        $this->nome     = $nc;
    } // Fim do método __construct

    public function __call($n,$a){
        return call_user_func_array(
            [$this, $n],
            !empty($a) ? $a : []
        );
    } // Fim do método __call



	/**
	 * Carregar conteúdo HTML através da classe Visao
	 *
	 * @param string $tpl Nome do template a ser carregado
	 * @param string $mst Nome da página mestra a ser utilizada
	 * @param int    $o   Ordem de exibição do template na compilação final
	 */
    protected function _carregarhtml($tpl, $mst=null, $o=0){
        $this->visao->_adtemplate($tpl, true, $o);
        $this->visao->pg_mestra = !$mst ? null : $mst;
    } // Fim do método _carregarhtml



    /**
     * Salvar um registro através do modelo
     */
    protected function _salvar(){
        $this->modelo->_salvar();
        return \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_REGISTRO_SALVO, $this->nome), 'msg-sucesso');
    } // Fim do método _salvar



    /**
     * Remover um ou mais registros
     */
    protected function _remover(){
        $qt = $this->_executaremlote('_remover');

        return \Funcoes::_retornar(
            !$qt->e ? ERRO_CONTROLEPRINCIPAL_REMOVER : sprintf($qt->e == 1 ? SUCESSO_CONTROLEPRINCIPAL_REMOVER_UM : SUCESSO_CONTROLEPRINCIPAL_REMOVER_VARIOS, $qt->e, $qt->t),
            !$qt->e ? 'msg-erro' : 'msg-sucesso'
        );
    } // Fim do método _remover




	/**
	 * Selecionar dados para carregar um campo select
	 *
	 * @param string $f Filtro a ser aplicado
	 * @param bool   $e Define se o resultado da consulta será escrito ou retornado pela função
	 */
    public function _carregarselect($f=null,$e=true){
        return $this->modelo->_carregarselect($f,$e);
    } // Fim do método _carregarselect



	/**
	 * Incluir informações e parâmetros padrões para os formulários
	 *
	 * @param string $form_id ID do formulário
	 * @param string $form_ia Ação do formulário a ser executado no caso de inclusão de registros
	 * @param string $form_ea Ação do formulário a ser executado no caso de edição de registros
	 * @param string $url     URL de redirecionamento após o submit do formulário
	 * @param mixed  $pk      Valor a ser pesquisado na PK para selecionar o registro
	 * @param bool   $ajax    Se true, faz o formulário ser submetido via ajax (jQuery). Se false, submete da forma
	 *                        tradicional
	 *
	 * @return bool
	 */
    protected function _formpadrao($form_id, $form_ia, $form_ea, $url = null, $pk = null, $ajax = true){
        is_object($this->modelo) AND $this->modelo->_selecionarPK($pk);

        # Incluir o script AJAX
        $ajax AND $this->_carregarhtml('comum/visoes/form_ajax', false, 98);

        # Verificar se o registro será alterado ou incluído
        $inc = is_null($this->modelo->id);

        # Parâmetros
        $this->visao->_adparam('incluindo', $inc);
        $this->visao->_adparam('modelo', $this->modelo);
        $this->visao->_adparam('form-id', $form_id);
        $this->visao->_adparam('form-action', \DL3::$modulo_atual .'/'. ($inc ? $form_ia : $form_ea));
        $this->visao->_adparam('url-depois', $url);

        if( !$inc ):
            $this->visao->_adparam('u-inc', $this->modelo->mod_lr->usuario_nome_criacao);
            $this->visao->_adparam('dt-inc', $this->modelo->mod_lr->data_criacao);

            $this->visao->_adparam('u-alt', $this->modelo->mod_lr->usuario_nome_alteracao);
            $this->visao->_adparam('dt-alt', $this->modelo->mod_lr->data_alteracao);
        endif;

        return $inc;
    } // Fim do método _formpadrao




	/**
	 * Carregar informações e parâmetros padrões para uma lista de registros
	 *
	 * @param string $c  Lista de campos a serem selecionados para criar a lista de registro
	 * @param string $o  Ordenção inicial
	 * @param int    $q  Quantidade de registros a serem exibidos em modo de paginação
	 * @param string $m  Método do modelo a ser usado para gerar a lista
	 * @param bool   $a  Define se a lista será editada via AJAX
	 * @param string $fa Filtro alternativo a ser aplicado na consulta
	 *
	 * @throws \Exception
	 */
    protected function _listapadrao($c, $o = '', $q = 20, $m = '_listar', $a=true, $fa=''){
        # Verificar se o método informado existe
        if( !method_exists($this->modelo, $m) )
            throw new \Exception(sprintf(ERRO_PADRAO_METODO_NAO_ENCONTRADO, $m, get_class($this->modelo)), 1404);

        # Carregar o script AJAX
        if( $a ) $this->_carregarhtml ('comum/visoes/lista_ajax', false, 98);

        # Formulário de filtro
        $this->visao->_adparam('get-t', $get_t = filter_input(INPUT_GET, 't'));
        $this->visao->_adparam('get-c', $get_c = filter_input(INPUT_GET, 'c'));
        $this->visao->_adparam('get-o', $get_o = filter_input(INPUT_GET, 'o'));
        $this->visao->_adparam('get-pg', $get_pg = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT));

        # Filtro
        $fl = [];

        if( !empty($fa) ) $fl[] = $fa;
        if( !empty($get_t) && !empty($get_c) ) $fl[] = "{$get_c} LIKE '%{$get_t}%'";

        # Considerar dados de sessão
        $dsess = is_null($q) && session_status() === PHP_SESSION_ACTIVE;

        # Quantidade de registros
        $qr = $dsess ? $_SESSION['usuario_pref_num_registros'] : 20;

        # Exibir o ID do registro ou não
        $eid = $dsess ? $_SESSION['usuario_pref_exibir_id'] : false;

        # Lista
        $l = $this->modelo->{$m}($f = implode(' AND ', $fl), !empty($get_o) ? $get_o : $o, $c, is_null($get_pg) ? 1 : $get_pg, $qr);

        # Nome da classe
        $cl = get_called_class();

        # Parâmetros
        $this->visao->_adparam('lista', $l);
        $this->visao->_adparam('total-pg', ceil($this->modelo->_qtde_registros($f)/$qr));
        $this->visao->_adparam('filtro?', !empty($get_c));
        $this->visao->_adparam('exibir-id', $eid);

        if( \DL3::$aut_o instanceof \Autenticacao ):
            $this->visao->_adparam('perm-inserir?', $pi = \DL3::$aut_o->_verificarperm($cl, '_mostrarform') && \DL3::$aut_o->_verificarperm($cl, '_salvar'));
            $this->visao->_adparam('perm-editar?', $pi);
            $this->visao->_adparam('perm-remover?', \DL3::$aut_o->_verificarperm($cl, '_remover'));
        endif;
    } // Fim do método _listapadrao




	/**
	 * Alternar a FLAG publicar do registro (se houver)
	 *
	 * @param string $a Ação realizada: 'publicar' => publica o registro | 'ocultar' => oculta o registro
	 *
	 * @throws \Exception
	 */
	protected function _alternarpublicacao($a){
        $qt = $this->_executaremlote('_alternarpublicacao');

        $msg = [
            'publicar'  =>  [ERRO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_PUBLICAR, SUCESSO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_UM_PUBLICAR, SUCESSO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_VARIOS_PUBLICAR],
            'ocultar'   =>  [ERRO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_OCULTAR, SUCESSO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_UM_OCULTAR, SUCESSO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_VARIOS_OCULTAR]
        ];

        return \Funcoes::_retornar(
            !$qt->e ? $msg[$a][0] : $qt->e == 1 ? $msg[$a][1] : sprintf($msg[$a][2], $qt->e, $qt->t),
            !$qt->e ? 'msg-erro' : 'msg-sucesso'
        );
    } // Fim do método _alternarpublicacao



	/**
	 * Executar uma ação em lote através das PKs dos registros
	 *
	 * @param string $m Nome do método presente no modelo referente a esse controle a ser executado
	 *
	 * @return object
	 * @throws \Exception
	 */
    protected function _executaremlote($m){
	    $tid = filter_input(INPUT_POST, 'id', FILTER_CALLBACK, ['options' => function($v){
		    return is_array($v) ? filter_var($v, FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY) : [filter_var($v, FILTER_VALIDATE_INT)];
	    }]);

        if( is_null($tid) )
            throw new \Exception(MSG_PADRAO_NENHUM_REGISTRO_SELECIONADO, 1404);

        # Quantidade total de registros e quantidade excluída
	    $qt = (object)'';
        $qt->t = count($tid);
        $qt->e = 0;

        foreach( $tid as $id ):
            $this->modelo->_selecionarPK($id);
            $qt->e += (int)$this->modelo->{$m}();
        endforeach;

        return $qt;
    } // Fim do método _executaremlote
} // Fim do controle Principal
