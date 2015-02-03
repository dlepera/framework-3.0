<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace AlbunsDeFotos\Modelo;

class FotoAlbum extends \Geral\Modelo\Principal{
    protected $foto_album, $id, $titulo, $descr, $imagem, $capa = 0,
            $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _foto_album(){ return (int)$this->foto_album; } // Fim do método _foto_album
    public function _titulo(){ return (string)$this->titulo; } // Fim do método _titulo
    public function _descr(){ return (string)$this->descr; } // Fim do método _descr
    public function _imagem(){ return (string)$this->imagem; } // Fim do método _imagem
    public function _capa(){ return (int)$this->capa; } // Fim do método _capa



    public function __construct($id=null){
        parent::__construct('dl_site_albuns_fotos', 'foto_album_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS F'
                . ' INNER JOIN dl_site_albuns AS A ON( A.album_id = F.foto_album )'
                . ' WHERE F.%sdelete = 0';

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     *  Desativar os método _salvar e _remover
     * -------------------------------------------------------------------------
     */
    public function _salvar(){ return; } // Fim do método _salvar
    public function _remover(){ return; } // Fim do método _remover
} // Fim do Modelo FotoAlbum