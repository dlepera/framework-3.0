<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace AlbunsDeFotos\Modelo;

use \Geral\Modelo as GeralM;

class Album extends GeralM\Principal{
    protected $id, $nome, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _nome(){ return filter_var($this->nome, FILTER_SANITIZE_STRING); } // Fim do método _nome


    public function __construct($pk = null){
        parent::__construct('dl_site_albuns', 'album_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS A'
                . " LEFT JOIN {$this->bd_tabela}_fotos AS FC ON ( FC.foto_album = A.album_id AND FC.foto_album_capa = 1 )"
                . " LEFT JOIN dl_painel_registros_logs AS LR ON( LR.log_registro_idreg = A.album_id AND LR.log_registro_tabela = '{$this->bd_tabela}' )"
                . ' WHERE A.%sdelete = 0';

        $this->_selecionarPK($pk);
    } // Fim do método __construct




	/*
	 *  Desativar os método _salvar e _remover
	 */
    public function _salvar($s = true, array $ci = null, array $ce = null, $ipk = false){ return; } // Fim do método _salvar
    public function _remover(){ return; } // Fim do método _remover
} // Fim do Modelo Album