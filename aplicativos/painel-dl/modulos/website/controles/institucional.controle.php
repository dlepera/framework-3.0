<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class Institucional extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\Institucional(), 'website', TXT_MODELO_SOBRE);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, [
                'id'        =>  FILTER_VALIDATE_INT,
                'historia'  =>  FILTER_DEFAULT,
                'missao'    =>  FILTER_DEFAULT,
                'visao'     =>  FILTER_DEFAULT,
                'valores'   =>  FILTER_DEFAULT,
                'publicar'  =>  FILTER_VALIDATE_BOOLEAN
            ]);

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarPK($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     *  Mostrar as informações institucionais do site
     */
    protected function _mostrarinfos(){
        # Visão
        $this->_carregarhtml('det_instit');
        $this->visao->titulo = TXT_PAGINA_TITULO_INFOS_INSTITUCIONAIS;

        # Obter o ID das informações
        $id = $this->modelo->_listar(null, null, 'MAX(instit_id) AS ID', 0, 1, 0);
        $this->modelo->_selecionarPK($id['ID']);

        # Parâmetros
        $this->visao->_adparam('modelo', $this->modelo);
    } // Fim do método _mostrarinfos



    /**
     * Mostrar o formulário de inclusão e edição do registro
     */
    protected function _mostrarform(){
        $id = $this->modelo->_listar(null, null, 'MAX(instit_id) AS ID', 0, 1, 0);

        $this->_formpadrao('instit', 'institucional/salvar', 'institucional/salvar', 'website/institucional', $id['ID']);

        # Visão
        $this->_carregarhtml('form_instit');
        $this->visao->titulo = TXT_PAGINA_TITULO_EDITAR_INSTITUCIONAL;
    } // Fim do método _mostrarform
} // Fim do Controle Institucional