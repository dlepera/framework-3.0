<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace Desenvolvedor\Modelo;

class ModuloFunc extends \Geral\Modelo\Principal{
    protected $id, $func_modulo, $descr, $classe, $metodos, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _func_modulo($v=null){
        return $this->func_modulo = filter_var(is_null($v) ? $this->func_modulo : $v, FILTER_VALIDATE_INT);
    } // Fim do método _func_modulo

    public function _descr($v=null){
        return $this->descr = filter_var(is_null($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _classe($v=null){
        return $this->classe = filter_var(is_null($v) ? $this->classe : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _metodos($v=null){
        return $this->metodos = filter_var(is_null($v) ? $this->metodos : $v, FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
    } // Fim do método _metodos



    public function __construct($id=null){
        parent::__construct('dl_painel_modulos_funcs', 'func_modulo_');

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Salvar o registro no banco de dados
     * -------------------------------------------------------------------------
     *
     * @param bool $s - define se o registro será salvo ou deve ser retornada a
     *  consulta SQL
     */
    protected function _salvar($s=true){
        $r = parent::_salvar($s);

        if( $r && $s ):
            foreach( $this->metodos as $m ):
                \DL3::$bd_conex->exec("INSERT INTO dl_painel_funcs_metodos (metodo_func, metodo_func_descr)"
                    . " VALUES ({$this->id}, '{$m}')");
            endforeach;
        endif;

        return $r;
    } // Fim do método _salvar



    /**
     * Selecionar um registro pelo ID
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     * @param string $alias - alias a ser aplicada na consulta
     */
    protected function _selecionarID($id, $alias=null){
        parent::_selecionarID($id, $alias);

        if( !is_null($this->id) ):
            $sql = \DL3::$bd_conex->query("SELECT metodo_func_descr FROM dl_painel_funcs_metodos WHERE func_modulo = {$this->id}");

            if( $sql === false ) return;

            while( $rs = $sql->fetch(\PDO::FETCH_ASSOC) )
                $this->metodos[] = $rs['metodo_func_descr'];
        endif;
    } // Fim do método _selecionarID
} // Fim do Modelo ModuloFunc