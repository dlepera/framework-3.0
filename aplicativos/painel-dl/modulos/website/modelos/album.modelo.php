<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

class Album extends \Geral\Modelo\Principal{
    protected $id, $nome, $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _nome($v=null){
        return $this->nome = filter_var(is_null($v) ? $this->nome : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _nome


    public function __construct($id=null){
        parent::__construct('dl_site_albuns', 'album_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS A'
                . " LEFT JOIN {$this->bd_tabela}_fotos AS FC ON ( FC.foto_album = A.album_id AND FC.foto_album_capa = 1 )"
                . ' WHERE A.%sdelete = 0';

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Salvar o registro no banco de dados
     * -------------------------------------------------------------------------
     *
     * @param int $s - define se o registro será salvo automaticamente ou se deve
     *  ser retornado a string da consulta SQL
     */
    protected function _salvar($s=true){
        $r = parent::_salvar($s);

        # Criar diretório do álbum
        if( !is_null($this->id) && $s ):
            $d = "aplicacao/uploads/albuns/{$this->id}";

            if( !file_exists($d) )
                mkdir($d);
        endif;

        return $r;
    } // Fim do método _salvar



    /**
     * Remover o registro do banco de dados
     * -------------------------------------------------------------------------
     */
    protected function _remover(){
        $r = parent::_remover();

        # Excluir o diretório e todo
        if( $r )
            unlink("aplicacao/uploads/{$this->id}");

        return $r;
    } // Fim do método _remover
} // Fim do Modelo Album