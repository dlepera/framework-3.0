<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace Desenvolvedor\Modelo;

use \Geral\Modelo as GeralM;

class ModuloFunc extends GeralM\Principal{
    protected $id, $func_modulo, $descr, $classe, $metodos, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
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



    public function __construct($pk = null){
        parent::__construct('dl_painel_modulos_funcs', 'func_modulo_');

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

        if( $r && $s ):
            foreach( $this->metodos as $m ):
                $sql = \DL3::$bd_conex->prepare("INSERT INTO dl_painel_funcs_metodos (metodo_func, metodo_func_descr) VALUES (:id, :metodo)");
                $sql->execute([':id' => $this->id, ':metodo' => $m]);
            endforeach;
        endif;

        return $r;
    } // Fim do método _salvar



	/**
	 * Selecionar um registro através da chave primária (PK - Primary Key)
	 *
	 * @param string $v Valor a ser pesquisado na PK
	 * @param string $a Alias da tabela principal configurado na consulta
	 *
	 * @return bool
	 * @throws \Exception
	 */
	protected function _selecionarPK($v, $a = null){
        parent::_selecionarPK($v, $a);

        if( !$this->reg_vazio ):
            $sql = \DL3::$bd_conex->prepare("SELECT metodo_func_descr FROM dl_painel_funcs_metodos WHERE func_modulo = :id");
	        $sql->execute([':id' => $this->id]);

            if( $sql === false ) return;

            while( $rs = $sql->fetch(\PDO::FETCH_ASSOC) )
                $this->metodos[] = $rs['metodo_func_descr'];
        endif;
    } // Fim do método _selecionarPK
} // Fim do Modelo ModuloFunc