<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 17:11:54
 */

namespace WebSite\Controle;

class GoogleAnalytics extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \WebSite\Modelo\GoogleAnalytics(), 'website', TXT_MODELO_GOOGLEANALYTICS);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        =>  FILTER_VALIDATE_INT,
                'apelido'   =>  FILTER_SANITIZE_STRING,
                'usuario'   =>  FILTER_VALIDATE_EMAIL,
                'senha'     =>  FILTER_SANITIZE_STRING,
                'perfil_id' =>  FILTER_VALIDATE_INT,
                'codigo_ua' =>  FILTER_SANITIZE_STRING,
                'principal' =>  FILTER_VALIDATE_BOOLEAN,
                'publicar'  =>  FILTER_VALIDATE_BOOLEAN
            ));

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarID($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     * Mostrar lista de registros
     * -------------------------------------------------------------------------
     */
    protected function _mostrarlista(){
        $this->_listapadrao('ga_id, ga_apelido, ga_usuario, ga_perfil_id, ( CASE ga_principal'
                . " WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim'"
                . ' END ) AS PRINCIPAL, ( CASE ga_publicar'
                . " WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim'"
                . ' END ) AS PUBLICADO', 'ga_perfil_id', null);

        # Visão
        $this->_carregarhtml('lista_ga');
        $this->visao->titulo = TXT_TITULO_CONFIGURACOES_GA;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => 'ga_usuario', 'texto' => TXT_ROTULO_USUARIO),
            array('valor' => 'ga_perfil_id', 'texto' => TXT_ROTULO_PERFIL)
        ));
    } // Fim do método _mostrarlista



    /**
     * Mostrar formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     */
    protected function _mostrarform($id=null){
        $inc = $this->_formpadrao('ga', 'google-analytics/salvar', 'google-analytics/salvar', 'website/google-analytics', $id);

        # Visão
        $this->_carregarhtml('form_ga');
        $this->visao->titulo = $inc ? TXT_TITULO_NOVO_GA : TXT_TITULO_EDITAR_GA;
    } // Fim do método _mostrarform
} // Fim do Controle GoogleAnalytics