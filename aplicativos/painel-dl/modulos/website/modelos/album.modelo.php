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
	const DIR_UPLOAD = 'web/uploads/albuns/%d';
    protected $id, $nome, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _nome($v = null){
        return $this->nome = \Funcoes::_ucwords(filter_var(!isset($v) ? $this->nome : $v, FILTER_SANITIZE_STRING), ['da', 'de', 'di', 'do', 'du', 'das', 'dos', 'del']);
    } // Fim do método _nome



    public function __construct($pk = null){
        parent::__construct('dl_site_albuns', 'album_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS A'
                . " LEFT JOIN {$this->bd_tabela}_fotos AS FC ON ( FC.foto_album = A.album_id AND FC.foto_album_capa )"
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
	protected function _salvar($s = true, array $ci = null, array $ce = null, $ipk = false){
        $r = parent::_salvar($s, $ci, $ce, $ipk);

		if( $s && $r ){
			# Criar diretório do álbum
			if( isset($this->id) ){
				$d = sprintf(self::DIR_UPLOAD, $this->id);
				!file_exists($d) and mkdir($d);
			} // Fim if( isset($this->id) )

			# Durante a inclusão do registro, fotos podem ser incluídas
			if( $this->reg_vazio ){
				# Salvar as fotos enviadas
				$mfa = new FotoAlbum();
				$mfa->foto_album = $this->id;
				$mfa->_upload();
			} // Fim if( $this->reg_vazio )
		} // Fim if( $s )

        return $r;
    } // Fim do método _salvar




	/**
	 * Remover o registro do banco de dados
	 */
    protected function _remover(){
		return \Arquivos::_removerdir(sprintf(self::DIR_UPLOAD, $this->id), true) and parent::_remover();
    } // Fim do método _remover




	/**
	 * Contar quantidade e fotos de um álbum
	 *
	 * @param int $id ID do álbum de fotos. Quando esse parâmetro não é passado, é utilizado o ID do álbum carregado no
	 *                modelo
	 *
	 * @return int Quantidade de fotos do álbum especificado
	 */
	public function _qtde_fotos($id = null){
		$id  = isset($id) ? $id : $this->id;
		$mft = new FotoAlbum();
		return (int)$mft->_qtde_registros("foto_album = {$id}");
	} // Fim metódo _qtde_fotos
} // Fim do Modelo Album