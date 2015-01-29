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

    # Templates
    private $tpl_topo = 'comum/visoes/topo', $tpl_rodape = 'comum/visoes/rodape';



    public function __construct($m, $nm, $nc){
        $this->visao    = new \Visao($nm);
        $this->modelo   = $m;
        $this->nome     = $nc;
    } // Fim do método __construct

    public function __call($n,$a){
        return call_user_func_array(
            array($this, $n),
            !empty($a) ? $a : array()
        );
    } // Fim do método __call



    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function __get($n){ return m_get($this, $n); } // Fim do método __get
    public function __set($n,$v){ return m_set($this, $n, $v); } // Fim do método __set

    public function _tpl_topo($v=null){
        return is_null($v) ? (string)$this->tpl_topo
        : $this->tpl_topo = (string)$v;
    } // Fim do método _tpl_topo

    public function _tpl_rodape($v=null){
        return is_null($v) ? (string)$this->tpl_rodape
        : $this->tpl_rodape = (string)$v;
    } // Fim do método _tpl_topo



    /**
     * Carregar conteúdo HTML através da classe Visao
     * -------------------------------------------------------------------------
     *
     * @param string $tpl - nome do template a ser carregado
     * @param string $tr  - define se devem ser carregado também o topo e o rodapé
     * @param int $o - define a ordem que a exibição deve ser organizada
     */
    protected function _carregarhtml($tpl, $tr = true, $o = 0){
        if( $tr ) $this->visao->_adtemplate($this->tpl_topo, true, 0);

        $this->visao->_adtemplate($tpl, true, $o);

        if( $tr ) $this->visao->_adtemplate($this->tpl_rodape, true, 99);
    } // Fim do método _carregarhtml



    /**
     * Salvar um registro através do modelo
     * -------------------------------------------------------------------------
     */
    protected function _salvar(){
        $this->modelo->_salvar();
        return \Funcoes::_retornar(sprintf(SUCESSO_PADRAO_REGISTRO_SALVO, $this->nome), 'msg-sucesso');
    } // Fim do método _salvar



    /**
     * Remover um ou mais registros
     * -------------------------------------------------------------------------
     */
    protected function _remover(){
        $tid = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        if( is_null($tid) )
            throw new \Exception(MSG_PADRAO_NENHUM_REGISTRO_SELECIONADO, 1404);

        # Quantidade total de registros e quantidade excluída
        $qt = count($tid);
        $qe = 0;

        foreach( $tid as $id ):
            $this->modelo->_selecionarID($id);
            $qe += (int)$this->modelo->_remover();
        endforeach;

        return \Funcoes::_retornar(
            !$qe ? ERRO_CONTROLEPRINCIPAL_REMOVER : sprintf($qe == 1 ? SUCESSO_CONTROLEPRINCIPAL_REMOVER_UM : SUCESSO_CONTROLEPRINCIPAL_REMOVER_VARIOS, $qe, $qt),
            !$qe ? 'msg-erro' : 'msg-sucesso'
        );
    } // Fim do método _remover



    /**
     * Selecionar dados para carregar um campo select
     * -------------------------------------------------------------------------
     *
     * @param bool $e - Define se o resultado da consulta será escrito
     *  ou retornado pela função
     */
    public function _carregarselect($e=true){

    } // Fim do método _carregarselect



    /**
     * Incluir informações e parâmetros padrões para os formulários
     * -------------------------------------------------------------------------
     *
     * @param string $form_id - ID do formulário
     * @param string $form_ia - ação do formulário a ser executado no caso
     *  de inclusào de registros
     * @param string $form_ea - ação do formulário a ser executado no caso
     *  de alteraçao de registros
     * @param string $url - URL para onde o formulário redicionará
     * @param int $id - ID do registro a ser selecionado
     * @param bool $ajax - define se o formulário será submetido via AJAX
     */
    protected function _formpadrao($form_id, $form_ia, $form_ea, $url=null, $id=null, $ajax=true){
        if( !empty($id) )
            $this->modelo->_selecionarID((int)$id);

        # Incluir o script AJAX
        if( $ajax )
            $this->_carregarhtml('comum/visoes/form_ajax', false, 98);

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
            // echo '<pre>', var_dump($this->modelo->mod_lr), '</pre>';
        endif;

        return $inc;
    } // Fim do método _formpadrao



    /**
     * Carregar informações e parâmetros padrões para uma lista de registros
     * -------------------------------------------------------------------------
     *
     * @param string $c - lista de campos a serem selecionados para criar
     *  a lista de registro
     * @param string $o - ordenção inicial
     * @param int $q - quantidade de registros a serem exibidos em modo de
     *  paginação
     * @param string $m - método do modelo a ser usado para gerar a lista
     * @param bool $a - define se a lista será editada via AJAX
     */
    protected function _listapadrao($c, $o = '', $q = 20, $m = '_listar', $a=true){
        # Verificar se o método informado existe
        if( !method_exists($this->modelo, $m) )
            throw new \Exception(sprintf(ERRO_PADRAO_METODO_NAO_ENCONTRADO, $m, getclass($this->modelo)), 1404);

        # Carregar o script AJAX
        if( $a ) $this->_carregarhtml ('comum/visoes/lista_ajax', false, 98);

        # Formulário de filtro
        $this->visao->_adparam('get-t', $get_t = filter_input(INPUT_GET, 't'));
        $this->visao->_adparam('get-c', $get_c = filter_input(INPUT_GET, 'c'));
        $this->visao->_adparam('get-o', $get_o = filter_input(INPUT_GET, 'o'));
        $this->visao->_adparam('get-pg', $get_pg = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT));

        # Filtro
        $f = !empty($get_t) && !empty($get_c) ? "{$get_c} LIKE '%{$get_t}%'" : null;

        # Quantidade de registros
        $qr = is_null($q) && session_status() === PHP_SESSION_ACTIVE ? $_SESSION['usuario_pref_num_registros'] : 2/* $q */;

        # Lista
        $l = $this->modelo->{$m}($f, !empty($get_o) ? $get_o : $o, $c, is_null($get_pg) ? 1 : $get_pg, $qr);

        # Nome da classe
        $cl = get_called_class();

        # Parâmetros
        $this->visao->_adparam('lista', $l);
        $this->visao->_adparam('total-pg', ceil($this->modelo->_qtde_registros($f)/$qr));
        $this->visao->_adparam('filtro?', !empty($get_c));
        $this->visao->_adparam('perm-inserir?', $pi = \DL3::$aut_o->_verificarperm($cl, '_mostrarform') && \DL3::$aut_o->_verificarperm($cl, '_salvar'));
        $this->visao->_adparam('perm-editar?', $pi);
        $this->visao->_adparam('perm-remover?', \DL3::$aut_o->_verificarperm($cl, '_remover'));
    } // Fim do método _listapadrao
} // Fim do controle Principal