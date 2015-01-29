<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 18:02:20
 */

namespace Contato\Modelo;

class ContatoSite extends \Geral\Modelo\Principal{
    protected $id, $nome, $email, $telefone, $assunto, $mensagem, $delete = 0;

    public function __construct($id=null){
        parent::__construct('dl_site_contatos', 'contato_site_');

        if( empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _nome($v=null){
        return is_null($v) ? (string)$this->nome
        : $this->nome = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _nome

    public function _email($v=null){
        return is_null($v) ? (string)$this->email
        : $this->email = (string)filter_var($v, FILTER_SANITIZE_EMAIL);
    } // Fim do método _email

    public function _telefone($v=null){
        return is_null($v) ? (string)$this->telefone
        : $this->telefone = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _telefone

    public function _assunto($v=null){
        return is_null($v) ? (int)$this->assunto
        : $this->assunto = (int)filter_var($v, FILTER_SANITIZE_NUMBER_INT);
    } // Fim do método _assunto

    public function _mensagem($v=null){
        return is_null($v) ? (string)$this->mensagem
        : $this->mensagem = (string)filter_var($v, FILTER_DEFAULT);
    } // Fim do método _mensagem



    /**
     * Salvar o registro
     * -------------------------------------------------------------------------
     *
     * Obs.: Esse modelo permite apenas a inclusão do registro
     *
     * @param bool $s - Define se o registro será automaticamente salvo ou
     *  se será retornada apenas a query
     */
    protected function _salvar($s=true){
        $query = $this->_criar_insert();

        if( !$s ) return $query;

        if( ($exec = \DL3::$bd_conex->exec($query)) === false )
            throw new \Exception(
                    sprintf(ERRO_PADRAO_SALVAR_REGISTRO,
                        '<b>'. $this->bd_tabela .':</b><br><br>'. $query .'<br><br>'. \DL3::$bd_conex->errorInfo()[2]
                    ),
                1500);

        # Carregar o ID gerado
        $this->id = \DL3::$bd_conex->lastInsertID("{$this->bd_prefixo}id");

        return $this->id;
    } // Fim do método _salvar



    /**
     * Não permitir a remoção desse registro
     * -------------------------------------------------------------------------
     */
    protected function _remover(){
        return false;
    } // Fim do método _remover
} // Fim do Modelo ContatoSite