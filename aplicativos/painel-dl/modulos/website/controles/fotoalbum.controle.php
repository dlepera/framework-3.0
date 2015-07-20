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

class FotoAlbum extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\FotoAlbum(), 'website', TXT_MODELO_FOTO);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, [
                'id'            =>  FILTER_VALIDATE_INT,
                'foto_album'    =>  FILTER_VALIDATE_INT,
                'titulo'        =>  FILTER_SANITIZE_STRING,
                'descr'         =>  FILTER_SANITIZE_STRING,
                'capa'          =>  FILTER_VALIDATE_BOOLEAN,
                'publicar'      =>  FILTER_VALIDATE_BOOLEAN
            ]);

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarPK($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 *
	 * @param int  $pk  Valor da PK do registro a ser selecionado
	 * @param bool $mst Nome da página mestra a ser carregada
	 */
    protected function _mostrarform($pk = null, $mst = null){
        $this->_formpadrao('foto', 'albuns-de-fotos/salvar-foto', 'albuns-de-fotos/salvar-foto', 'website/albuns-de-fotos', $pk);

        # Visão
        $this->_carregarhtml('form_foto', $mst);
        $this->visao->titulo = TXT_PAGINA_TITULO_EDITAR_FOTO;
    } // Fim do método _mostrarform




	/**
	 * Realizar o upload das fotos
	 */
    protected function _upload(){
        $this->modelo->_upload();
        return \Funcoes::_retornar(SUCESSO_FOTOALBUM_UPLOAD, 'msg-sucesso');
    } // Fim do método _upload
} // Fim do Controle Controle