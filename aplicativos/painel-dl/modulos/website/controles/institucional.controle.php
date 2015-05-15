<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace WebSite\Controle;

class Institucional extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \WebSite\Modelo\Institucional(), 'website', TXT_MODELO_SOBRE);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        =>  FILTER_VALIDATE_INT,
                'historia'  =>  FILTER_DEFAULT,
                'missao'    =>  FILTER_DEFAULT,
                'visao'     =>  FILTER_DEFAULT,
                'valores'   =>  FILTER_DEFAULT,
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
     *  Mostrar as informações institucionais do site
     * -------------------------------------------------------------------------
     */
    protected function _mostrarinfos(){
        # Visão
        $this->_carregarhtml('det_instit');
        $this->visao->titulo = TXT_PAGINA_TITULO_INFOS_INSTITUCIONAIS;

        # Obter o ID das informações
        $id = end($this->modelo->_listar(null, null, 'MAX(instit_id) AS ID'));
        $this->modelo->_selecionarID($id['ID']);

        # Parâmetros
        $this->visao->_adparam('modelo', $this->modelo);
    } // Fim do método _mostrarinfos



    /**
     * Mostrar o formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     */
    protected function _mostrarform(){
        $id = end($this->modelo->_listar(null, null, 'MAX(instit_id) AS ID'));

        $this->_formpadrao('instit', 'institucional/salvar', 'institucional/salvar', 'website/institucional', $id['ID']);

        # Visão
        $this->_carregarhtml('form_instit');
        $this->visao->titulo = TXT_PAGINA_TITULO_EDITAR_INSTITUCIONAL;
    } // Fim do método _mostrarform
} // Fim do Controle Institucional