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

class Album extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\Album(), 'website', TXT_MODELO_ALBUM);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ){
	        $post = filter_input_array(INPUT_POST, [
		        'id'        => FILTER_VALIDATE_INT,
		        'nome'      => FILTER_SANITIZE_STRING,
		        'publicar'  => FILTER_VALIDATE_BOOLEAN
	        ]);

	        # Converter o encode
	        \Funcoes::_converterencode($post, \DL3::$ap_charset);

	        # Selecionar as informações atuais
	        $this->modelo->_selecionarPK($post['id']);

	        \Funcoes::_vetor2objeto($post, $this->modelo);
        } // Fim if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' )
    } // Fim do método __construct




	/**
	 * Mostrar a lista de registros
	 */
    protected function _mostrarlista(){
        $this->_listapadrao('album_id, album_nome, foto_album_imagem, ( CASE album_publicar'
                . " WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim'"
                . ' END ) AS PUBLICADO', 'album_nome', null);

        # Visão
        $this->_carregarhtml('lista_albuns');
        $this->visao->titulo = TXT_PAGINA_TITULO_ALBUNS_FOTOS;

	    # Contar a quantiade de fotos de cada álbum
	    $la = $this->visao->_obterparams('lista');
	    $qt = [];

	    foreach( $la as $a )
		    $qt[$a['album_id']] = $this->modelo->_qtde_fotos($a['album_id']);


        # Parâmetros
        $this->visao->_adparam('campos', [
            ['valor' => 'album_nome', 'texto' => TXT_ROTULO_NOME]
        ]);
	    $this->visao->_adparam('qtdes-fotos', $qt);
    } // Fim do método _mostrarlista




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 *
	 * @param int $pk Valor da PK do registro a ser selecionado
	 */
    public function _mostrarform($pk = null){
        $inc = $this->_formpadrao('album', 'albuns-de-fotos/salvar', 'albuns-de-fotos/salvar', 'website/albuns-de-fotos', $pk);

        # Visão
        $this->_carregarhtml('form_album');
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO_ALBUM : TXT_PAGINA_TITULO_EDITAR_ALBUM;

        if( $inc ) return;

        # Lista de fotos
        $mf = new WebM\FotoAlbum();
        $lf = $mf->_listar("foto_album = {$this->modelo->id} AND foto_album_publicar", 'foto_album_capa DESC, foto_album_id DESC', 'foto_album_id, foto_album_titulo, foto_album_descr, foto_album_capa, foto_album_imagem');

        # Parâmetros
        $this->visao->_adparam('fotos', $lf);
	    $this->visao->_adparam('qtde-fotos', $this->modelo->_qtde_fotos());
    } // Fim do método _mostrarform
} // Fim do Controle Controle