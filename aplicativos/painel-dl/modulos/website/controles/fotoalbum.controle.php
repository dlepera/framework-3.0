<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace WebSite\Controle;

class FotoAlbum extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \WebSite\Modelo\FotoAlbum(), 'website', TXT_MODELO_FOTO);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'            =>  FILTER_VALIDATE_INT,
                'foto_album'    =>  FILTER_VALIDATE_INT,
                'titulo'        =>  FILTER_SANITIZE_STRING,
                'descr'         =>  FILTER_SANITIZE_STRING,
                'capa'          =>  FILTER_VALIDATE_BOOLEAN,
                'publicar'      =>  FILTER_VALIDATE_BOOLEAN
            ));

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarID($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     * Mostrar o formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     * @param bool $mst - página mestra a ser carregada
     */
    protected function _mostrarform($id=null, $mst=null){
        $this->_formpadrao('foto', 'albuns-de-fotos/salvar-foto', 'albuns-de-fotos/salvar-foto', 'website/albuns-de-fotos', $id);

        # Visão
        $this->_carregarhtml('form_foto', $mst);
        $this->visao->titulo = TXT_PAGINA_TITULO_EDITAR_FOTO;
    } // Fim do método _mostrarform



    /**
     * Realizar o upload das fotos
     * -------------------------------------------------------------------------
     */
    protected function _upload(){
        $this->modelo->_upload();
        return \Funcoes::_retornar(SUCESSO_FOTOALBUM_UPLOAD, 'msg-sucesso');
    } // Fim do método _upload
} // Fim do Controle Controle