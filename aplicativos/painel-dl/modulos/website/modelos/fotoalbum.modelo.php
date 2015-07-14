<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;
use \WebSite\Modelo as WebM;

class FotoAlbum extends GeralM\Principal{
    protected $foto_album, $id, $titulo, $descr, $imagem, $capa = 0, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _foto_album($v=null){
        return $this->foto_album = filter_var(is_null($v) ? $this->foto_album : $v, FILTER_VALIDATE_INT);
    } // Fim do método _foto_album

    public function _titulo($v=null){
        return $this->titulo = \Funcoes::_ucwords(filter_var(is_null($v) ? $this->titulo : $v, FILTER_SANITIZE_STRING), ['da', 'de', 'di', 'do', 'du', 'das', 'dos', 'del', 'na', 'no']);
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



    public function __construct($pk = null){
        parent::__construct('dl_site_albuns_fotos', 'foto_album_');

        $this->_selecionarPK($pk);
    } // Fim do método __construct



    /**
     * Fazer o upload das fotos e salvá-las no diretório do álbum
     *
     * É feito o upload das fotos e as salva no diretório de fotos do álbum.
     * Depois é criado o registro das fotos salvas na base de dados.
     */
    public function _upload(){
	    # Informações do álbum
	    $maf = new WebM\Album($this->foto_album);

	    # Fazer o upload das fotos
        $oup = new \Upload(sprintf($maf::DIR_UPLOAD, $this->foto_album), 'fotos');
        $oup->_extensoes(['png', 'jpg', 'jpeg', 'gif']);

        if( !$oup->_salvar($maf->nome) )
            throw new \Exception(ERRO_FOTOALBUM_UPLOAD_SALVAR, 1500);

        foreach( $oup->salvos as $f ):
            $this->id       = null;
            $this->imagem   = preg_replace('~^\.~', '', $f);
            $this->publicar = 1;
            // $this->_salvar();
	        $this->__call('_salvar');
        endforeach;
    } // Fim do método _upload



	/**
	 * Salvar determinado registro
	 *
	 * @param boolean $s   Define se o registro será salvo ou apenas será gerada a query de insert/update
	 * @param array   $ci  Vetor com os campos a serem considerados
	 * @param array   $ce  Vetor com os campos a serem desconsiderados
	 * @param bool    $ipk Define se o campo PK será considerado para inserção
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	protected function _salvar($s = true, $ci = null, $ce = null, $ipk = false){
        # Apenas uma foto pode ser definida como capa de um álbum, portanto, caso
        # o registro atual esteja sendo definido como capa, a flag deve ser
        # desmarcada nas demais fotos
        $this->capa == 1 AND \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}capa = 0 WHERE foto_album = {$this->foto_album}");

        return parent::_salvar($s, $ci, $ce, $ipk);
    } // Fim do método _salvar



    /**
     * Remover o registro e a foto vinculada a ele
     */
    protected function _remover(){
        # Excluir a foto vinculada
        return unlink(".{$this->imagem}") AND parent::_remover();
    } // Fim do método _remover
} // Fim do Modelo FotoAlbum