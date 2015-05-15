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
        return $this->descr = filter_var(is_null($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do módulo _descr

    public function _diretorio($v=null){
        return $this->diretorio = trim(filter_var(is_null($v) ? $this->diretorio : $v, FILTER_SANITIZE_STRING), '/') .'/';
    } // Fim do módulo _diretorio

    public function _padrao($v=null){
        return $this->padrao = filter_var(is_null($v) ? $this->padrao : $v, FILTER_VALIDATE_BOOLEAN);
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