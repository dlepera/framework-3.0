<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace AlbunsDeFotos\Controle;

use \Geral\Controle as GeralM;
use \AlbunsDeFotos\Modelo as AlbumM;

class Foto extends GeralM\WebSite{
    public function __construct(){
        parent::__construct(new AlbumM\FotoAlbum(), 'albuns-de-fotos', TXT_MODELO_FOTO);
    } // Fim do método __construct




	/**
	 *  Mostrar a lista de fotos de um determinado álbum
	 *
	 * @param int $a - ID do álbum a ser exibido
	 */
    public function _mostrarfotos($a){
        # Lista de fotos
        $l = $this->modelo->_listar("foto_album_publicar AND foto_album = {$a}", 'foto_album_capa DESC, foto_album_titulo',
                'foto_album_titulo, foto_album_descr, foto_album_capa, foto_album_imagem, album_nome');

        # Visão
        $this->_carregarhtml('lista_fotos');
        $this->visao->titulo = $l[0]['album_nome'];

        # Parâmetros
        $this->visao->_adparam('fotos', $l);
    } // Fim do método _mostrarlista
} // Fim do Controle Foto