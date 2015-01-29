<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 07/01/2015 16:37:18
 */

namespace Desenvolvedor\Controle;

class Modulo extends \Geral\Controle\PainelDL{
    public function __construct() {
        parent::__construct(new \Desenvolvedor\Modelo\Modulo(), 'desenvolvedor', TXT_MODELO_MODULO);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => FILTER_VALIDATE_INT,
                'pai'       => FILTER_VALIDATE_INT,
                'nome'      => FILTER_SANITIZE_STRING,
                'descr'     => FILTER_DEFAULT,
                'menu'      => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'options' => array('min_range' => 0, 'max_range' => 1)),
                'link'      => FILTER_SANITIZE_STRING,
                'ordem'     => FILTER_SANITIZE_NUMBER_INT,
                'publicar'  => array('filter' => FILTER_SANITIZE_NUMBER_INT, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarID($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     * Mostrar a lista de registros
     * -------------------------------------------------------------------------
     */
    protected function _mostrarlista(){
        $this->_listapadrao("M.modulo_id, ( CASE IFNULL(M.modulo_pai, 0)"
                . " WHEN 0 THEN M.modulo_nome"
                . " ELSE CONCAT(S.modulo_nome, ' > ', M.modulo_nome) "
                . " END ) AS NOME_COMPLETO, M.modulo_link, ( CASE M.modulo_publicar"
                . " WHEN 0 THEN 'Não'"
                . " WHEN 1 THEN 'Sim'"
                . " END ) AS PUBLICADO", 'NOME_COMPLETO', null);

        # Visão
        $this->_carregarhtml('lista_modulos');
        $this->visao->titulo = TXT_TITULO_MODULOS;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => 'M.modulo_nome', 'texto' => TXT_LABEL_NOME),
            array('valor' => 'M.modulo_link', 'texto' => TXT_LABEL_LINK)
        ));
    } // Fim do método _mostrarlista



    /**
     * Mostrar o formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     */
    protected function _mostrarform($id=null){
        $inc = $this->_formpadrao('modulo', 'modulos/instalar-modulo',  'modulos/atualizar-modulo', 'desenvolvedor/modulos', $id);

        # Visão
        $this->_carregarhtml('form_modulo');
        $this->visao->titulo = $inc ? TXT_TITULO_NOVO_MODULO : TXT_TITULO_EDITAR_MODULO;

        # Lista de módulos 'pai'
        $l_mp = $this->modelo->_listar('M.modulo_pai IS NULL'.
                (!$inc && $this->modelo->pai == 0 ? " AND M.modulo_id <> {$this->modelo->id}" : ''),
                'M.modulo_nome', 'M.modulo_id AS VALOR, M.modulo_nome AS TEXTO');

        # Parâmetros
        $this->visao->_adparam('modulos-pai', $l_mp);
        $this->visao->_adparam('mostrar-funcs?', !$inc && $this->modelo->pai > 0);

        if( !$inc ):
            # Funcionalidades
            $m_mf = new \Desenvolvedor\Modelo\ModuloFunc();
            $l_mf = $m_mf->_carregarselect("func_modulo = {$this->modelo->id}", false);

            if( !is_null($this->modelo->pai) ):
                # Módulo pai
                $mp = end($this->modelo->_listar("M.modulo_id = {$this->modelo->pai}", null, 'M.modulo_nome'));

                $this->visao->_adparam('modulo-pai', $mp['modulo_nome']);
            endif;

            $this->visao->_adparam('funcs', $l_mf);
        endif;
    } // Fim do método _mostrarform



    /**
     * Incluir uma nova funcionalidade
     * -------------------------------------------------------------------------
     */
    protected function _novafunc(){
        $of = new \Desenvolvedor\Modelo\ModuloFunc();

        $post = filter_input_array(INPUT_POST, array(
            'id'            =>  FILTER_VALIDATE_INT,
            'func_modulo'   =>  FILTER_VALIDATE_INT,
            'descr'         =>  FILTER_SANITIZE_STRING,
            'classe'        =>  FILTER_SANITIZE_STRING,
            'metodos'       =>  array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_REQUIRE_ARRAY)
        ));

        # Converter o encode
        \Funcoes::_converterencode($post, \DL3::$ap_charset);

        \Funcoes::_vetor2objeto($post, $of);

        $of->_salvar();

        return \Funcoes::_retornar(SUCESSO_MODULO_NOVAFUNC, 'msg-sucesso');
    } // Fim do método _novafunc



    /**
     * Remover uma funcionalidade
     * -------------------------------------------------------------------------
     */
    protected function _removerfunc(){
        $of = new \Desenvolvedor\Modelo\ModuloFunc();

        $ids = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        # Controlar qtde removida
        $qt = count($ids);
        $qe = 0;

        foreach( $ids as $id ):
            $of->_selecionarID($id);
            $qe += $of->_remover();
        endforeach;

        return \Funcoes::_retornar(
            !$qe ? ERRO_CONTROLEPRINCIPAL_REMOVER : sprintf($qe == 1 ? SUCESSO_CONTROLEPRINCIPAL_REMOVER_UM : SUCESSO_CONTROLEPRINCIPAL_REMOVER_VARIOS, $qe, $qt),
            !$qe ? 'msg-erro' : 'msg-sucesso'
        );
    } // Fim do método _removerfunc
} // Fim do Controle Modulo