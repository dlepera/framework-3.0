<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/01/2015 13:33:06
 */

namespace Desenvolvedor\Modelo;

class Tema extends \Geral\Modelo\Principal{
    protected $id, $descr, $diretorio, $padrao = 0, $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _descr($v=null){
        return is_null($v) ? (string)$this->descr
        : $this->descr = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do módulo _descr

    public function _diretorio($v=null){
        return is_null($v) ? (string)$this->diretorio
        : $this->diretorio = (string)filter_var(trim($v, '/'), FILTER_SANITIZE_STRING) .'/';
    } // Fim do módulo _diretorio

    public function _padrao($v=null){
        if( is_null($v) ) return (int)$this->padrao;

        if( !empty($v) && ($v < 0 || $v > 1) )
            throw new Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, 'padrao'), 1500);

        return $this->padrao = (int)$v;
    } // Fim do método _padrao



    public function __construct(){
        parent::__construct('dl_painel_temas', 'tema_');
    } // Fim do método __construct



    /**
     * Salvar o registro em banco de dados
     * -------------------------------------------------------------------------
     *
     * @param bool $s - define se o registro será salvo no banco de dados ou se
     *  a consulta deve ser retornada em forma de string
     */
    protected function _salvar($s=true){
        # Apenas um registro pode ter a flag 'padrao' marcada. Por tanto, caso
        # o registro atual tenha essa flag a mesma deve ser desmarcados do
        # outro registro, se houver
        if( $this->padrao == 1 )
            \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}padrao = 0");

        return parent::_salvar($s);
    } // Fim do método _salvar
} // Fim do Modelo Tema