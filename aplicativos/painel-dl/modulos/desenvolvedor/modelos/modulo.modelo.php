<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 07/01/2015 16:27:37
 */

namespace Desenvolvedor\Modelo;

use \Geral\Modelo as GeralM;

class Modulo extends GeralM\Principal{
    protected $id, $pai, $nome, $descr, $menu = 1, $link, $ordem = 0, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _pai($v = null){
        return $this->pai = filter_var(!isset($v) ? $this->pai : $v, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    } // Fim do método _pai

    public function _nome($v = null){
        return $this->nome = filter_var(!isset($v) ? $this->nome : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _nome

    public function _descr($v = null){
        return $this->descr = filter_var(!isset($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _menu($v = null){
        return $this->menu = filter_var(!isset($v) ? $this->menu : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _menu

    public function _link($v = null){
        return $this->link = trim(filter_var(!isset($v) ? $this->link : $v, FILTER_SANITIZE_STRING), '/');
    } // Fim do método _link

    public function _ordem($v = null){
        return $this->ordem = filter_var(!isset($v) ? $this->ordem : $v, FILTER_VALIDATE_INT);
    } // Fim do método _ordem




    public function __construct($pk = null){
        parent::__construct('dl_painel_modulos', 'modulo_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS M'
                . " LEFT JOIN {$this->bd_tabela} AS S ON( S.{$this->bd_prefixo}id = M.{$this->bd_prefixo}pai )"
                . ' WHERE M.%sdelete = 0';

        $this->_selecionarPK($pk);
    } // Fim do método __construct




	/**
	 * Selecionar um registro através da chave primária (PK - Primary Key)
	 *
	 * @param string $v Valor a ser pesquisado na PK
	 * @param string $a Alias da tabela principal configurado na consulta
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function _selecionarPK($v, $a = 'M'){
        return parent::_selecionarPK($v, $a);
    } // Fim do método _selecionarPK




    /**
     * Selecionar apenas os itens que devem aparecer no menu
     *
     * @param string $flt Parte do filtro a ser aplicado na consulta
     * @param string $ord Ordenação dos registros a ser aplicada na consulta
     * @param string $cmp Lista de campos a ser retornada
     * @param int    $pgn Número da página de registros
     * @param int    $qtd Quantidade de registros a serem exibidos na paginação
     *
     * @return array
     */
    public function _listarmenu($flt = null, $ord = null, $cmp = '*', $pgn = 0, $qtd = 20){
        $q = $this->bd_select;

        $this->bd_select = 'SELECT DISTINCT %s'
                . ' FROM dl_painel_grupos_funcs AS GF'
                . ' INNER JOIN dl_painel_modulos_funcs AS FM ON( FM.func_modulo_id = GF.func_modulo_id )'
                . " INNER JOIN %s AS M ON( M.{$this->bd_prefixo}id = FM.func_modulo )"
                . " INNER JOIN dl_painel_funcs_metodos AS MF ON( MF.metodo_func = FM.func_modulo_id AND (MF.metodo_func_descr = '_mostrarlista' OR MF.metodo_func_descr = '_mostrarmenu')  )"
                . " WHERE M.%sdelete = 0 AND M.{$this->bd_prefixo}menu = 1 AND GF.grupo_usuario_id = {$_SESSION['usuario_info_grupo']}";

        $l = $this->_listar($flt, $ord, $cmp, $pgn, $qtd);

        $this->bd_select = $q;

        return $l;
    } // Fim do método _listarmenu
} // Fim do Modelo Modulo