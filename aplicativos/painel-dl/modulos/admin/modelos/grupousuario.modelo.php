<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 09:54:50
 */

namespace Admin\Modelo;

class GrupoUsuario extends \Geral\Modelo\Principal{
    protected $id, $descr, $funcs = array(), $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _descr($v=null){
        return is_null($v) ? (string)$this->descr
        : $this->descr = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _funcs($v=null){
        return is_null($v) ? $this->funcs
        : $this->funcs = filter_var($v, FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
    } // Fim do método _funcs



    public function __construct($id=null){
        parent::__construct('dl_painel_grupos_usuarios', 'grupo_usuario_');

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Salvar o registro do banco de dados
     * -------------------------------------------------------------------------
     *
     * @param bool $s - define se o registro será salvo no banco de dados ou
     *  se seráo retornada a consulta SQL
     */
    protected function _salvar($s=true){
        $r = parent::_salvar($s);

        if( $s && $this->id != $_SESSION['usuario_info_grupo'] ):
            # Salvar o permissionamento atual e remover o antigo
            \DL3::$bd_conex->exec("DELETE FROM dl_painel_grupos_funcs WHERE {$this->bd_prefixo}id = {$this->id}");

            foreach( $this->funcs as $f )
                \DL3::$bd_conex->exec("INSERT INTO dl_painel_grupos_funcs VALUES ({$this->id}, $f)");
        endif;

        return $r;
    } // Fim do método _salvar



    /**
     * Selecionar um registro pelo ID
     * -------------------------------------------------------------------------
     *
     * @params int $id - ID do registro a ser selecionado
     * @params string $alias - alias configurado na consulta do registro a ser
     *  selecionado
     */
    protected function _selecionarID($id,$alias=null){
        parent::_selecionarID($id, $alias);

        $sql = \DL3::$bd_conex->query("SELECT func_modulo_id FROM dl_painel_grupos_funcs WHERE {$this->bd_prefixo}id = {$this->id}");

        if( $sql === false ) return;

        while( $rs = $sql->fetch(\PDO::FETCH_ASSOC) )
            $this->funcs[] = $rs['func_modulo_id'];
    } // Fim do método _selecionarID



    /**
     * Verificar permissionamento do grupo
     * -------------------------------------------------------------------------
     */
    public function _verificarperm($m,$a){
        $q = "SELECT COUNT(DISTINCT MF.metodo_func_descr) AS PERM"
                . " FROM dl_painel_grupos_funcs AS GF"
                . " INNER JOIN dl_painel_modulos_funcs FM ON( FM.func_modulo_id = GF.func_modulo_id )"
                . " LEFT JOIN dl_painel_funcs_metodos MF ON( MF.metodo_func = FM.func_modulo_id )"
                . " WHERE GF.{$this->bd_prefixo}id = {$this->id}"
                . " AND FM.func_modulo_classe = '". addslashes($m) ."'"
                . " AND MF.metodo_func_descr = '{$a}'";

        $sql = \DL3::$bd_conex->query($q);
        $rs  = $sql->fetch(\PDO::FETCH_ASSOC);

        return (bool)$rs['PERM'];
    } // Fim do método _verificarperm
} // Fim do Modelo GrupoUsuario