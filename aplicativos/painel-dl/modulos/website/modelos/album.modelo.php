<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class Album extends GeralM\Principal{
	# Diretório onde serão salvos as fotos desse álbum
	const DIR_UPLOAD = 'aplicacao/uploads/albuns/%d';
    protected $id, $nome, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _nome($v=null){
        return $this->nome = \Funcoes::_ucwords(filter_var(is_null($v) ? $this->nome : $v, FILTER_SANITIZE_STRING), ['da', 'de', 'di', 'do', 'du', 'das', 'dos', 'del']);
    } // Fim do método _nome



    public function __construct($pk = null){
        parent::__construct('dl_site_albuns', 'album_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS A'
                . " LEFT JOIN {$this->bd_tabela}_fotos AS FC ON ( FC.foto_album = A.album_id AND FC.foto_album_capa = 1 )"
                . ' WHERE A.%sdelete = 0';

        $this->_selecionarPK($pk);
    } // Fim do método __construct



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
	protected function _salvar($s=true, $ci=null, $ce=null, $ipk=false){
        $r = parent::_salvar($s, $ci, $ce, $ipk);

        # Criar diretório do álbum
        if( !is_null($this->id) && $s ):
            $d = sprintf(self::DIR_UPLOAD, $this->id);
            !file_exists($d) AND mkdir($d);
        endif;

		# Salvar as fotos enviadas
		$mfa = new FotoAlbum();
		$mfa->foto_album = $this->id;
		$mfa->_upload();

        return $r;
    } // Fim do método _salvar



    /**
     * Remover o registro do banco de dados
     */
    protected function _remover(){
		return \Arquivos::_removerdir(sprintf(self::DIR_UPLOAD, $this->id), true) AND parent::_remover();
    } // Fim do método _remover
} // Fim do Modelo Album