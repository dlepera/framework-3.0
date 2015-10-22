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




	/**
	 * Instanciar a classe
	 *
	 * @param object $m  Instância do modelo referente a esse controle
	 * @param string $nm Nome do diretório a ser considerado para a visão
	 * @param string $nc Nome do modelo / controle
	 */
    public function __construct($m, $nm, $nc){
        $this->visao    = new \Visao($nm);
        $this->modelo   = $m;
        $this->nome     = $nc;
    } // Fim do método __construct




    public function __call($n, $a){
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
    protected function _carregarhtml($tpl, $mst = null, $o=0){
        $this->visao->_adtemplate($tpl, true, $o);
        $this->visao->pg_mestra = !$mst ? null : $mst;
    } // Fim do método _carregarhtml




    /**
     * Salvar um registro através do modelo
     */
    protected function _salvar(){
        $this->modelo->_salvar();
        \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_REGISTRO_SALVO, $this->nome), '__msg-sucesso');
    } // Fim do método _salvar




    /**
     * Remover um ou mais registros
     */
    protected function _remover(){
        $qt = $this->_executaremlote('_remover');

        \Funcoes::_retornar(
            !$qt->e ? ERRO_CONTROLEPRINCIPAL_REMOVER : sprintf($qt->e == 1 ? SUCESSO_CONTROLEPRINCIPAL_REMOVER_UM : SUCESSO_CONTROLEPRINCIPAL_REMOVER_VARIOS, $qt->e, $qt->t),
            !$qt->e ? '__msg-erro' : '__msg-sucesso'
        );
    } // Fim do método _remover




    /**
     * Selecionar dados para carregar um campo select
     *
     * @param string $f Filtro a ser aplicado
     * @param bool   $e Define se o resultado da consulta será escrito ou retornado pela função
     */
    public function _carregarselect($f = null,$e = true){
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
	    $inc = true;

        if( is_object($this->modelo) ){
	        # Selecionar o registro do modelo pela PK
	        $this->modelo->_selecionarPK($pk);

	        # Verificar se o registro será alterado ou incluído
	        $inc = is_null($this->modelo->id);

	        # Parâmetros
	        $this->visao->_adparam('incluindo', $inc);
	        $this->visao->_adparam('modelo', $this->modelo);

	        if( !$inc ){
		        $this->visao->_adparam('u-inc', $this->modelo->mod_lr->usuario_nome_criacao);
		        $this->visao->_adparam('dt-inc', $this->modelo->mod_lr->data_criacao);

		        $this->visao->_adparam('u-alt', $this->modelo->mod_lr->usuario_nome_alteracao);
		        $this->visao->_adparam('dt-alt', $this->modelo->mod_lr->data_alteracao);
	        } // Fim if( !$inc )
        } // Fim if( is_object($this->modelo) )

        # Incluir o script AJAX
        $ajax and $this->_carregarhtml('comum/visoes/form_ajax', false, 98);

	    # Título da página
	    $this->visao->titulo = $inc
		    ? sprintf(TXT_PAGINA_TITULO_CADASTRAR_NOVO, $this->nome)
		    : sprintf(TXT_PAGINA_TITULO_EDITAR_ESSE, $this->nome);

        # Parâmetros
        $this->visao->_adparam('form-id', $form_id);
        $this->visao->_adparam('form-action', \DL3::$modulo_atual .'/'. ($inc ? $form_ia : $form_ea));
        $this->visao->_adparam('url-depois', $url);

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
    protected function _listapadrao($c, $o = '', $q = 20, $m = '_listar', $a = true, $fa = ''){
        # Verificar se o método informado existe
        if( !method_exists($this->modelo, $m) )
            throw new \Exception(sprintf(ERRO_PADRAO_METODO_NAO_ENCONTRADO, $m, get_class($this->modelo)), 1404);

        # Carregar o script AJAX
        $a and $this->_carregarhtml('comum/visoes/lista_ajax', false, 98);

        # Formulário de filtro
        $this->visao->_adparam('get-t', $get_t = filter_input(INPUT_GET, 't'));
        $this->visao->_adparam('get-c', $get_c = filter_input(INPUT_GET, 'c'));
        $this->visao->_adparam('get-o', $get_o = filter_input(INPUT_GET, 'o'));
        $this->visao->_adparam('get-pg', $get_pg = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT));

        # Filtro
        $fl = [];

        !empty($fa) and $fl[] = $fa;
        !empty($get_t) && !empty($get_c) and $fl[] = "{$get_c} LIKE '%{$get_t}%'";

        # Considerar dados de sessão
        $dsess = !isset($q) && session_status() === PHP_SESSION_ACTIVE;

        # Quantidade de registros
        $qr = $dsess ? $_SESSION['usuario_pref_num_registros'] : 20;

        # Exibir o ID do registro ou não
        $eid = $dsess ? $_SESSION['usuario_pref_exibir_id'] : false;

        # Lista
        $l = $this->modelo->{$m}($f = implode(' AND ', $fl), !empty($get_o) ? $get_o : $o, $c, !isset($get_pg) ? 1 : $get_pg, $qr);

	    # Quantidade total de registros
	    $qtr = $this->modelo->_qtde_registros($f);

        # Nome da classe
        $classe = get_called_class();
	    $autent = \DL3::$aut_o instanceof \Autenticacao;

        # Parâmetros
        $this->visao->_adparam('lista', $l);
	    $this->visao->_adparam('qtde-registros', $qtr);
	    $this->visao->_adparam('total-pg', ceil($qtr / $qr));
        $this->visao->_adparam('filtro?', !empty($get_c));
        $this->visao->_adparam('exibir-id?', $eid);
        $this->visao->_adparam('link-inserir', sprintf(TXT_LINK_NOVO, $this->nome));
        $this->visao->_adparam('opcoes', [
	        'inserir?' => $pi = $autent && \DL3::$aut_o->_verificarperm($classe, '_mostrarform') && \DL3::$aut_o->_verificarperm($classe, '_salvar'),
	        'editar?'  => $autent && $pi,
	        'remover?' => $autent && \DL3::$aut_o->_verificarperm($classe, '_remover'),
	        'publicar?' => $autent && property_exists($this->modelo, 'publicar') && $pi
        ]);
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

        \Funcoes::_retornar(
            !$qt->e ? $msg[$a][0] : $qt->e == 1 ? $msg[$a][1] : sprintf($msg[$a][2], $qt->e, $qt->t),
            !$qt->e ? '__msg-erro' : '__msg-sucesso'
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
        $tid = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_FORCE_ARRAY | FILTER_NULL_ON_FAILURE);

        if( !isset($tid) )
            throw new \Exception(MSG_PADRAO_NENHUM_REGISTRO_SELECIONADO, 1404);

        # Quantidade total de registros e quantidade excluída
        $qt = (object)'';
        $qt->t = count($tid);
        $qt->e = 0;

        foreach( $tid as $id ){
	        $this->modelo->_selecionarPK($id);
	        $qt->e += (int)$this->modelo->{$m}();
        } // Fim foreach

        return $qt;
    } // Fim do método _executaremlote




    /**
     * Receber dados do _POST, tratá-los e carregá-los no modelo
     *
     * @param array $dados Vetor com as informações referentes aos filtros a serem aplicados
     *
     * @return array Retorna vetor de dados já tratados
     */
    protected function _carregar_post(array $dados = []){
        !filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' and exit(0);

        $post = filter_input_array(INPUT_POST, $dados);
	    $igual = true;
	    $pk_cpo = filter_var(\DL3::$bd_conex->_identifica_pk($this->modelo->bd_tabela, $this->modelo->bd_prefixo), FILTER_SANITIZE_STRING, FILTER_FORCE_ARRAY);
	    $pk_val = [];

        # Converter o encode
        \Funcoes::_converterencode($post, \DL3::$ap_charset);

	    /*
	     * Considerar tanto chaves compostas como simples como vetor para evitar fazer muitas verificações "if".
	     */
	    foreach( $pk_cpo as $c ){
		    $val = $post[$c];
		    $pk_val[] = $val;
		    $this->modelo->{$c} != $val and $igual = false;
	    } // Fim foreach

	    !$igual || $this->modelo->reg_vazio and $this->modelo->_selecionarPK($pk_val);

        # Carregar o modelo com as informações recebidas
        \Funcoes::_vetor2objeto($post, $this->modelo);

        return $post;
    } // Fim do método _carregarpost
} // Fim do controle Principal
