<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 14:54:28
 */

namespace Geral\Modelo;

abstract class Principal{
    protected $bd_tabela, $bd_prefixo, $bd_select = 'SELECT %s FROM %s WHERE %sdelete = 0';

    # Gravar logs do registro
    protected $mod_lr;

    public function __construct($tabela, $prefixo = ''){
        $this->_bd_tabela($tabela);
        $this->_bd_prefixo($prefixo);

        if( get_called_class() !== 'Geral\Modelo\LogRegistro' )
            $this->mod_lr = new LogRegistro();
    } // Fim do método mágico de construção



    /**
     * Ações padrões a serem executadas quando um determinado método é acionado
     * -------------------------------------------------------------------------
     *
     * @param string $nome - Nome do método a ser executado
     * @param array $args - vetor contendo os argumentos a serem passados para o método
     */
    public function __call($nome, $args){
        $mod_registro = 'Geral\Modelo\LogRegistro';

        switch($nome):
            # Gravar log de inserção e alteração do registro
            case '_salvar':
                $s = call_user_func_array(array($this, '_salvar'), $args);

                if( class_exists($mod_registro) && $s > 0 && !is_null($this->id) ):
                    $this->mod_lr->tabela  = $this->bd_tabela;
                    $this->mod_lr->idreg   = $this->id;

                    $this->mod_lr->_salvar();
                endif;

                return $s;

            # Gravar log de remoção
            case '_remover':
                if( ($rem = $this->_remover()) !== false && class_exists($mod_registro) ):
                    $this->mod_lr->tabela  = $this->bd_tabela;
                    $this->mod_lr->idreg   = $this->id;

                    $this->mod_lr->_salvar(true);
                endif;

                return $rem;

            # Selecionar as informações de inclusão e alteração do registro
            case '_selecionarID':
                call_user_func_array(array($this, '_selecionarID'), $args);

                if( !is_null($this->id) && get_called_class() != $mod_registro )
                    $this->mod_lr->_selecionarID($this->bd_tabela, $this->id);
                break;
        endswitch;
    } // Fim do método mágico __call






    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function __get($n){ return m_get($this, $n); } // Fim do método __get
    public function __set($n,$v){ return m_set($this, $n, $v); } // Fim do método __set

    public function _bd_tabela($v=null){
        return is_null($v) ? (string)$this->bd_tabela
        : $this->bd_tabela = (string)$v;
    } // Fim do método _bd_tabela

    public function _bd_prefixo($v=null){
        return is_null($v) ? (string)$this->bd_prefixo
        : $this->bd_prefixo = (string)$v;
    } // Fim do método _bd_tabela

    public function _bd_select($v=null){
        return is_null($v) ? (string)$this->bd_select
        : $this->bd_select = (string)$v;
    } // Fim do método _bd_tabela

    public function _mod_lr(){
        return $this->mod_lr;
    } // Fim do método _bd_tabela

    public function _id($v){
        if( !property_exists($this, 'id') )
            return null;

        return is_null($v) ? $this->id
        : $this->id = filter_var($v);
    } // Fim do método _id

    public function _publicar($v){
        if( !property_exists($this, 'publicar') )
            return null;

        if( (int)$v < 0 || (int)$v > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);

        return is_null($v) ? (int)$this->publicar
        : $this->publicar = (int)filter_var($v, FILTER_SANITIZE_NUMBER_INT);
    } // Fim do método _id

    public function _delete(){
        if( !property_exists($this, 'delete') )
            return null;

        return (int)$this->delete;
    } // Fim do método _id



    /**
     * Listar registros desse modelos de acordo com o filtro e ordenação
     * -------------------------------------------------------------------------
     *
     * @param string $filtro - parte da string referente à clausula WHERE da consulta SQL
     * @param string $ordem - parte da string referente à clausula ORDER BY da consulta SQL
     * @param string $campos - lista de campos a serem selecionados
     * @param int $pagina - página a ser considerada durante uma paginação de resultados.<br>Se definida como 0 (zero) a paginação não é realizada
     * @param int $qtde - quantidade de registros a serem exibidos caso a paginação seja ativada
     *
     * @return array: array associativo contendo o recordset da consulta
     */
    public function _listar($filtro=null, $ordem=null, $campos='*', $pagina=0, $qtde=20){
        $query = substr_count($this->bd_select, '%s') == 2 ?
            sprintf($this->bd_select, $campos, $this->bd_tabela)
        : sprintf($this->bd_select, $campos, $this->bd_tabela, $this->bd_prefixo);

        if( !empty($filtro) )
            $query .= stripos($query, "WHERE") > -1 ? " AND {$filtro}" : " WHERE {$filtro}";

        if( !empty($ordem) )
            $query .= " ORDER BY {$ordem}";
        // echo $query, '<br>--<br>';
        $sql = $pagina > 0 ?
            \DL3::$bd_conex->_paginacao($query, $pagina, $qtde)
        : \DL3::$bd_conex->query($query);

        if( !$sql )
            return false;

        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } // Fim do método _listar



    /**
     * Obter apenas a quantidade de registros
     * -------------------------------------------------------------------------
     *
     * @param string $filtro - filtro a ser aplicado na consuta
     */
    public function _qtde_registros($filtro=''){
        $rs = end($this->_listar($filtro, null, 'COUNT(*) AS QTDE'));
        return $rs['QTDE'];
    } // Fim do método _qtde_registros



    /**
     * Selecionar um registro desse modelo pelo ID
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     * @param string $alias - alias da tabela principal
     *
     * @return void
     */
    protected function _selecionarID($id, $alias=null){
        if( !method_exists($this, '_listar') )
            throw new \Exception(printf(ERRO_PADRAO_METODO_NAO_EXISTE, '_listar'), 1500);

        # Garantir que o ID seja um número inteiro
        $id     = (int)$id;
        $alias  = is_null($alias) ? '' : (string)"{$alias}.";

        # Armazenar string com campos BIT
        $bit = '';

        if( \DL3::$bd_conex->getAttribute(\PDO::ATTR_DRIVER_NAME) === 'mysql' ):
            $campos     = \DL3::$bd_conex->_campos($this->bd_tabela);
            $c_bits     = array_keys(preg_grep('~^bit~', array_column($campos, 'Type')));
            $c_nomes    = array_column($campos, 'Field');

            foreach( $c_bits as $k )
                $bit .= ", {$alias}{$c_nomes[$k]}+0 AS {$c_nomes[$k]}";
        endif;

        $lis_m = end($this->_listar("{$alias}{$this->bd_prefixo}id = {$id}", null, "{$alias}*{$bit}"));

        # Carregar os dados obtidos do banco de dados
        # nas propriedades da classe
        foreach( $lis_m as $c => $m ):
            $p = preg_replace("~^{$this->bd_prefixo}~", '', $c);

            if( property_exists($this, $p) )
               $this->{$p} = $m;
        endforeach;
    } // Fim do método _selecionarID



    /**
     * Salvar determinado registro
     * -------------------------------------------------------------------------
     *
     * @param boolean $s - define se o registro será salvo ou apenas
     * será gerada a query de insert/update
     * @param array $ci - vetor com os campos a serem considerados
     * @param array $ce - vetor com os campos a serem desconsiderados
     * @param bool $ipk - define se o campo PK será considerado para inserção
     */
    protected function _salvar($s=true, $ci=null, $ce=null, $ipk=false){
        $query = !$this->id ? $this->_criar_insert($ipk, $ci,$ce) : $this->_criar_update($ci,$ce);

        if( !$s ) return $query;

        if( ($exec = \DL3::$bd_conex->exec($query)) === false )
            throw new \Exception(
                    sprintf(ERRO_PADRAO_SALVAR_REGISTRO,
                        '<b>'. $this->bd_tabela .':</b><br><br>'. $query .'<br><br>'. \DL3::$bd_conex->errorInfo()[2]
                    ),
                1500);

        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) ):
            $this->id = \DL3::$bd_conex->lastInsertID("{$this->bd_prefixo}id");
            return $this->id;
        else:
            return $exec;
        endif;
    } // Fim do método _salvar



    /**
     * Remover o registro
     * -------------------------------------------------------------------------
     */
    protected function _remover(){
        if( $this->delete == 1 ) return 1;

        $rem = \DL3::$bd_conex->exec("DELETE FROM {$this->bd_tabela} WHERE {$this->bd_prefixo}id = {$this->id}");

        if( $rem === false && property_exists($this, 'delete') )
            $rem = \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}delete = 1 WHERE {$this->bd_prefixo}id = {$this->id}");

        return (int)$rem;
    } // Fim do método _remover



    /**
     * Criar dinamicamente a consulta INSERT de acordo com os
     * dados do modelo
     * -------------------------------------------------------------------------
     *
     * @params bool $inserir_id - Define se a query será montada considerando a inserção
     *  de ID's com IDENTITY ou AUTO_INCREMENT
     *
     * @return string
     */
    public function _criar_insert($inserir_id = false, array $apenas_campos = null, array $excluir_campos = null){
        # Informações dos campos
        array_shift($campos = \DL3::$bd_conex->_campos($this->bd_tabela));

        $v_campos   = array();
        $v_valores  = array();

        foreach( $campos as $c ):
            # Nome da propriedade
            $p = preg_replace("~^{$this->bd_prefixo}~", '', $c['Field']);

            # Ignorar o campo de marcação da deleção de um registro
            # Ignorar campos que NAO estejam no vetor $apenas_campos, caso o mesmo não seja nulo
            # Ignorar campos que estejam no vetor $excluir_campos, caso o mesmo não seja nulo
            if( $p === 'delete' ||
                    (!is_null($apenas_campos) && !in_array($c['Field'], $apenas_campos)) ||
                    (!is_null($excluir_campos) && in_array($c['Field'], $excluir_campos)) ) continue;

            # Obter as informações do campos
            $pk     = $c['Key'] == 'PRI';
            $obr    = $c['Null'] == 'NO';

            if( is_null($this->{$p}) && $obr && !$pk )
                throw new \Exception(sprintf(ERRO_MODELOPRINCIPAL_CRIARINSERT_CAMPO_OBRIGATORIO_NULO, $c['Field']), 1500);

            if( !is_null($this->{$p}) && (($inserir_id && $pk) || !$pk) ):
                $v_campos[]     = "{$c['Field']}";
                $v_valores[]    = var_export($this->{$p}, true);
            endif;
        endforeach;

        return "INSERT INTO {$this->bd_tabela} (". implode(', ', $v_campos) .") VALUES"
            . " (". implode(', ', $v_valores) .")";
    } // Fim do modelo _criar_insert



    /**
     * Criar dinamicamente a consulta UPDATE de acordo com os
     * dados do modelo
     * -------------------------------------------------------------------------
     *
     * @return string
     */
    public function _criar_update(array $apenas_campos = null, array $excluir_campos = null){
        # Informações dos campos
        array_shift($campos = \DL3::$bd_conex->_campos($this->bd_tabela));

        $v_alterar  = array();
        $v_where    = array();

        foreach( $campos as $c ):
            # Nome da propriedade
            $p = preg_replace("~^{$this->bd_prefixo}~", '', $c['Field']);

            # Ignorar o campo de marcação da deleção de um registro
            # Ignorar campos que NAO estejam no vetor $apenas_campos, caso o mesmo não seja nulo
            # Ignorar campos que estejam no vetor $excluir_campos, caso o mesmo não seja nulo
            if( $p === 'delete' ||
                    (!is_null($apenas_campos) && !in_array($c['Field'], $apenas_campos)) ||
                    (!is_null($excluir_campos) && in_array($c['Field'], $excluir_campos)) ) continue;

            # Obter as informações do campos
            $pk     = $c['Key'] == 'PRI';
            $obr    = $c['Null'] == 'NO';

            if( is_null($this->{$p}) && $obr && !$pk )
                throw new \Exception(sprintf(ERRO_MODELOPRINCIPAL_CRIARUPDATE_CAMPO_OBRIGATORIO_NULO, $c['Field']), 1500);

            if( $pk )
                $v_where[] = "{$c['Field']} = ". var_export($this->{$p}, true);
            else
                $v_alterar[] = "{$c['Field']} = ". var_export($this->{$p}, true);
        endforeach;

        return "UPDATE {$this->bd_tabela} SET ". implode(', ', $v_alterar) ." WHERE ". implode(' AND ', $v_where);
    } // Fim do método _criar_update

    /**
     * Carregar um 'select' com VALOR e TEXTO
     * -------------------------------------------------------------------------
     *
     * @param string $filtro - filtro a ser aplicado na query
     * @param boolen $escrever - define se o resultado será escrito no formato json ou retornado
     * @param string $id - nome do campo identificado como 'value' (sem prefixo)
     * @param string $label - nome do campo identificado como 'label' (sem prefixo)
     */
    public function _carregarselect($filtro = null, $escrever = true, $id = 'id', $label = 'descr'){
        $lis = $this->_listar($filtro, "{$this->bd_prefixo}{$label}", "{$this->bd_prefixo}{$id} AS VALOR, {$this->bd_prefixo}{$label} AS TEXTO");

        if( $escrever ) echo json_encode($lis); else return $lis;
    } // Fim _carregarselect
} // Fim do modelo Principal