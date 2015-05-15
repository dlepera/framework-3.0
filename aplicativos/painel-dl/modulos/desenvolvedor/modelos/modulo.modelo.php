<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 07/01/2015 16:27:37
 */

namespace Desenvolvedor\Modelo;

class Modulo extends \Geral\Modelo\Principal{
    protected $id, $pai, $nome, $descr, $menu = 1, $link, $ordem = 0, $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _pai($v=null){
        return $this->pai = filter_var(is_null($v) ? $this->pai : $v, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    } // Fim do método _pai

    public function _nome($v=null){
        return $this->nome = filter_var(is_null($v) ? $this->nome : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _nome

    public function _descr($v=null){
        return $this->descr = filter_var(is_null($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _menu($v=null){
        return $this->menu = filter_var(is_null($v) ? $this->menu : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _menu

    public function _link($v=null){
        return $this->link = trim(filter_var(is_null($v) ? $this->link : $v, FILTER_SANITIZE_STRING), '/') .'/';
    } // Fim do método _link

    public function _ordem($v=null){
        return $this->ordem = filter_var(is_null($v) ? $this->ordem : $v, FILTER_VALIDATE_INT);
    } // Fim do método _ordem



    public function __construct($id=null){
        parent::__construct('dl_painel_modulos', 'modulo_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS M'
                . " LEFT JOIN {$this->bd_tabela} AS S ON( S.{$this->bd_prefixo}id = M.{$this->bd_prefixo}pai )"
                . " WHERE M.%sdelete = 0";

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Selecionar um registro pelo ID informado
     * -------------------------------------------------------------------------
     *
     * Substituir o método _selecionarID para informar o alias de forma
     * automática. Assim não é necessário informar a cada chamada do método
     *
     * @param int $id - ID do registro a ser selecionado
     */
    protected function _selecionarID($id){
        return parent::_selecionarID($id, 'M');
    } // Fim do método _selecionarID



    /**
     * Selcionar Menu
     * -------------------------------------------------------------------------
     *
     * Selecionar apenas os itens que devem aparecer no menu
     */
    public function _listarmenu($filtro=null, $ordem=null, $campos='*', $pagina=0, $qtde=20){
        $q = $this->bd_select;

        $this->bd_select = 'SELECT DISTINCT %s'
                . ' FROM dl_painel_grupos_funcs AS GF'
                . ' INNER JOIN dl_painel_modulos_funcs AS FM ON( FM.func_modulo_id = GF.func_modulo_id )'
                . " INNER JOIN %s AS M ON( M.{$this->bd_prefixo}id = FM.func_modulo )"
                . " INNER JOIN dl_painel_funcs_metodos AS MF ON( MF.metodo_func = FM.func_modulo_id AND MF.metodo_func_descr = '_mostrarlista' )"
                . " WHERE M.%sdelete = 0 AND M.{$this->bd_prefixo}menu = 1 AND GF.grupo_usuario_id = {$_SESSION['usuario_info_grupo']}";

        $l = $this->_listar($filtro, $ordem, $campos, $pagina, $qtde);

        $this->bd_select = $q;

        return $l;
    } // Fim do método _listarmenu
} // Fim do Modelo Modulo