<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 09:54:50
 */

namespace Admin\Modelo;

use \Geral\Modelo as GeralM;

class GrupoUsuario extends GeralM\Principal{
    protected $id, $descr, $funcs = [], $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _descr($v = null){
        return $this->descr = filter_var(!isset($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _funcs($v = null){
        return $this->funcs = filter_var(!isset($v) ? $this->funcs : $v, FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY | FILTER_FORCE_ARRAY);
    } // Fim do método _funcs



    public function __construct($pk = null){
        parent::__construct('dl_painel_grupos_usuarios', 'grupo_usuario_');
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

	    # Salvar o permissionamento atual e remover o antigo
        if( $s && $this->id != $_SESSION['usuario_info_grupo'] ){
            if( !$this->reg_vazio ){
	            $sql = \DL3::$bd_conex->prepare("DELETE FROM dl_painel_grupos_funcs WHERE {$this->bd_prefixo}id = :id");
	            $sql->execute([':id' => $this->id]);
            } // Fim if( !$this->reg_vazio )

	        $sql = \DL3::$bd_conex->prepare("INSERT INTO dl_painel_grupos_funcs VALUES (:id, :func)");
	        foreach( $this->funcs as $f ) $sql->execute([':id' => $this->id, ':func' => $f]);
        } // Fim if( $s && $this->id != $_SESSION['usuario_info_grupo'] )

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
    public function _selecionarPK($v, $a = null){
	    if( parent::_selecionarPK($v, $a) ){
		    $sql = \DL3::$bd_conex->prepare("SELECT func_modulo_id FROM dl_painel_grupos_funcs WHERE {$this->bd_prefixo}id = :id");
		    $sql->execute([':id' => $this->id]);

		    if( $sql === false ) return true;

		    $this->funcs = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);

		    return true;
	    } // Fim if( parent::_selecionarPK($v, $a) )

	    return false;
    } // Fim do método _selecionarPK




	/**
	 * Verificar a permissão desse grupo para executar determinada ação
	 *
	 * @param string $c Nome da classe
	 * @param string $m Nome do método / ação a ser executada
	 *
	 * @return bool true se a o grupo possui permissão para executar a ação ou false se não tem
	 */
    public function _verificarperm($c, $m){
        $q = "SELECT COUNT(DISTINCT MF.metodo_func_descr) AS PERM"
                . " FROM dl_painel_grupos_funcs AS GF"
                . " INNER JOIN dl_painel_modulos_funcs FM ON( FM.func_modulo_id = GF.func_modulo_id )"
                . " LEFT JOIN dl_painel_funcs_metodos MF ON( MF.metodo_func = FM.func_modulo_id )"
                . " WHERE GF.{$this->bd_prefixo}id = :id"
                . " AND FM.func_modulo_classe = :classe"
                . " AND MF.metodo_func_descr = :metodo";

        $sql = \DL3::$bd_conex->prepare($q);
	    $sql->execute([':id' => $this->id, ':classe' => $c, ':metodo' => $m]);

        return (bool)$sql->fetchColumn(0);
    } // Fim do método _verificarperm
} // Fim do Modelo GrupoUsuario