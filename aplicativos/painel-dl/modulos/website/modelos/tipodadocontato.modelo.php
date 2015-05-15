<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 12:03:30
 */

namespace WebSite\Modelo;

class TipoDadoContato extends \Geral\Modelo\Principal{
    protected $id, $descr, $icone, $rede_social = 0, $mascara, $expreg, $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _descr($v=null){
        return $this->descr = filter_var(is_null($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _icone($v=null){
        return $this->icone = filter_var(is_null($v) ? $this->icone : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _icone

    public function _rede_social($v=null){
        return $this->rede_social = filter_var(is_null($v) ? $this->rede_social : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _rede_social

    public function _mascara($v=null){
        return $this->mascara = filter_var(is_null($v) ? $this->mascara : $v);
    } // Fim do método _mascara

    public function _expreg($v=null){
        return $this->expreg = filter_var(is_null($v) ? $this->expreg : $v);
    } // Fim do método _expreg



    public function __construct($id=null){
        parent::__construct('dl_site_dados_contato_tipos', 'tipo_dado_');

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Salvar o registro em banco de dados
     * -------------------------------------------------------------------------
     *
     * Antes de salvar o arquivo será salvo
     *
     * @param bool $s - Define se o registro será salvo automaticamente no banco
     *  de dados ou se será retornada uma string com a instrção SQL
     */
    protected function _salvar($s=true){
        if( file_exists($_FILES['icone']['tmp_name']) ):
            # Em caso de edição do registro, remover o ícone anterior
            if( !is_null($this->id) )
                unlink(".{$this->icone}");

            $o_up = new \Upload('/aplicacao/uploads/contatos');

            if( $o_up->_salvar(\Funcoes::_removeracentuacao(str_replace('-', '', strtolower($this->nome)))) )
                $this->icone = preg_replace('~^\.~', '', $o_up->arquivos_salvos[0]);
        endif;

        return parent::_salvar($s);
    } // Fim do método _salvar



    /**
     * Remover registro do banco de dados
     * -------------------------------------------------------------------------
     */
    protected function _remover(){
        # Remover o ícone
        if( !empty($this->icone) )
            unlink(".{$this->icone}");

        return parent::_remover();
    } // Fim do método _remover
} // Fim do Modelo TipoDadoContato