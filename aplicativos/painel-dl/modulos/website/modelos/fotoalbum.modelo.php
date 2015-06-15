<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

class FotoAlbum extends \Geral\Modelo\Principal{
    protected $foto_album, $id, $titulo, $descr, $imagem, $capa = 0,
            $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _foto_album($v=null){
        return $this->foto_album = filter_var(is_null($v) ? $this->foto_album : $v, FILTER_VALIDATE_INT);
    } // Fim do método _foto_album

    public function _titulo($v=null){
        return $this->titulo = filter_var(is_null($v) ? $this->titulo : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _titulo

    public function _descr($v=null){
        return $this->descr = filter_var(is_null($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _imagem($v=null){
        return $this->imagem = filter_var(is_null($v) ? $this->imagem : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _imagem

    public function _capa($v=null){
        return $this->capa = filter_var(is_null($v) ? $this->capa : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _capa



    public function __construct($id=null){
        parent::__construct('dl_site_albuns_fotos', 'foto_album_');

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Fazer o upload das fotos e salvá-las no diretório do álbum
     * -------------------------------------------------------------------------
     *
     * É feito o upload das fotos e as salva no diretório de fotos do álbum.
     * Depois é criado o registro das fotos salvas na base de dados.
     */
    public function _upload(){
        # Fotos enviadas
        $fs = $_FILES['fotos'];
        
        if( !file_exists(is_array($fs['tmp_name']) ? $fs['tmp_name'][0] : $fs['tmp_name']) )
            throw new \Exception(ERRO_FOTOALBUM_UPLOAD_NENHUM_ARQUIVO_ENVIADO, 1404);

        $o_up = new \Upload("/aplicacao/uploads/albuns/{$this->foto_album}");
        $o_up->_extensoes(array('png', 'jpg', 'jpeg', 'gif'));

        if( !$o_up->_salvar('foto') )
            throw new \Exception(ERRO_FOTOALBUM_UPLOAD_SALVAR, 1500);

        foreach( $o_up->arquivos_salvos as $f ):
            $this->id       = null;
            $this->imagem   = preg_replace('~^\.~', '', $f);
            $this->publicar = 1;
            $this->_salvar();
        endforeach;
    } // Fim do método _upload



    /**
     * Salvar o registro no banco de dados
     * -------------------------------------------------------------------------
     *
     * @param bool $s - define se o registro será salvo automaticamente ou se
     *  será retornada a consulta SQL
     */
    protected function _salvar($s=true){
        # Apenas uma foto pode ser definida como capa de um álbum, portanto, caso
        # o registro atual esteja sendo definido como capa, a flag deve ser
        # desmarcada nas demais fotos
        if( $this->capa == 1 )
            \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}capa = 0");

        return parent::_salvar($s);
    } // Fim do método _salvar



    /**
     * Remover o registro e a foto vinculada a ele
     * -------------------------------------------------------------------------
     */
    protected function _remover(){
        # Excluir a foto vinculada
        unlink(".{$this->imagem}");

        return parent::_remover();
    } // Fim do método _remover
} // Fim do Modelo FotoAlbum