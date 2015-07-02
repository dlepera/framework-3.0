<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace AlbunsDeFotos\Modelo;

use \Geral\Modelo as GeralM;

class FotoAlbum extends GeralM\Principal{
    protected $foto_album, $id, $titulo, $descr, $imagem, $capa = 0, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _foto_album(){ return filter_var($this->foto_album, FILTER_VALIDATE_INT); } // Fim do método _foto_album
    public function _titulo(){ return filter_var($this->titulo, FILTER_SANITIZE_STRING); } // Fim do método _titulo
    public function _descr(){ return filter_var($this->descr, FILTER_SANITIZE_STRING); } // Fim do método _descr
    public function _imagem(){ return filter_var($this->imagem, FILTER_SANITIZE_STRING); } // Fim do método _imagem
    public function _capa(){ return filter_var($this->capa, FILTER_VALIDATE_BOOLEAN); } // Fim do método _capa



    public function __construct($pk = null){
        parent::__construct('dl_site_albuns_fotos', 'foto_album_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS F'
                . ' INNER JOIN dl_site_albuns AS A ON( A.album_id = F.foto_album )'
                . ' WHERE F.%sdelete = 0';

	    $this->_selecionarPK($pk);
    } // Fim do método __construct



    /**
     *  Desativar os método _salvar e _remover
     */
    public function _salvar(){ return; } // Fim do método _salvar
    public function _remover(){ return; } // Fim do método _remover
} // Fim do Modelo FotoAlbum