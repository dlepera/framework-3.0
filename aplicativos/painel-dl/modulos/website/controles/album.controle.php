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
        $this->_carregar_post([
            'id'        => FILTER_VALIDATE_INT,
            'nome'      => FILTER_SANITIZE_STRING,
            'publicar'  => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




	/**
	 * Mostrar a lista de registros
	 */
    protected function _mostrarlista(){
        $this->_listapadrao('album_id AS ' . TXT_LISTA_TITULO_ID . ','
	        . " CONCAT('<img src=\"" . \DL3::$dir_relativo . "', foto_album_imagem, '\" class=\"tbl-imagem capa-album\" alt=\"\"/>') AS " . TXT_LISTA_TITULO_CAPA . ','
            . ' album_nome AS ' . TXT_LISTA_TITULO_NOME . ','
            . " ( CASE album_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
            'album_nome', null);

        # Visão
        $this->_carregarhtml('comum/visoes/form_filtro');
        $this->_carregarhtml('lista_albuns');
        $this->visao->titulo = TXT_PAGINA_TITULO_ALBUNS_FOTOS;

	    # Contar a quantiade de fotos de cada álbum
	    $la = $this->visao->_obterparams('lista');
	    $qt = [];

	    foreach( $la as $a )
		    $qt[$a[TXT_LISTA_TITULO_ID]] = $this->modelo->_qtde_fotos($a[TXT_LISTA_TITULO_ID]);

        # Parâmetros
        $this->visao->_adparam('dir-lista', 'website/albuns-de-fotos/');
        $this->visao->_adparam('form-acao', 'website/albuns-de-fotos/excluir-albuns');
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
        $this->_carregarhtml('comum/visoes/titulo_h2');
        $this->_carregarhtml('form_album');

	    # Fotos
	    $mf = new WebM\FotoAlbum();

	    # Parâmetros
	    $this->visao->_adparam('extensoes', implode(', ', $mf->conf_extensoes_imagem));

        if( $inc ) return;

        # Lista de fotos
        $mf = new WebM\FotoAlbum();
        $lf = $mf->_listar("foto_album = {$this->modelo->id} AND foto_album_publicar = 1", 'foto_album_capa DESC, foto_album_id DESC', 'foto_album_id, foto_album_titulo, foto_album_descr, foto_album_capa, foto_album_imagem');

        # Mais parâmetros
        $this->visao->_adparam('fotos', $lf);
	    $this->visao->_adparam('qtde-fotos', $this->modelo->_qtde_fotos());
    } // Fim do método _mostrarform
} // Fim do Controle Controle