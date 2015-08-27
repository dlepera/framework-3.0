<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 14:54:28
 */

namespace Geral\Modelo;

abstract class Principal{
	const LOG_REGISTRO = 'Geral\Modelo\LogRegistro';

    protected $bd_tabela, $bd_prefixo, $bd_select = 'SELECT %s FROM %s WHERE %sdelete = 0';

    # Gravar logs do registro
    protected $mod_lr;

    # Define se o registro encontra-se vazio
    protected $reg_vazio = true;




    public function __construct($tbl, $pfx = ''){
        $this->_bd_tabela($tbl);
        $this->_bd_prefixo($pfx);

        get_called_class() !== 'Geral\Modelo\LogRegistro'
        and $this->mod_lr = new LogRegistro();
    } // Fim do método mágico de construção




    /**
     * Ações padrões a serem executadas quando um determinado método é acionado
     *
     * @param string $n Nome do método a ser executado
     * @param array  $a Vetor contendo os argumentos a serem passados para o método
     *
     * @return int|mixed
     * @throws \Exception
     */
    public function __call($n, $a = []){
        switch($n){
            # Gravar log de inserção e alteração do registro
            case '_salvar':
                $s = call_user_func_array([$this, '_salvar'], $a);

                if( class_exists(self::LOG_REGISTRO) && $s > 0 && isset($this->id) ){
                    $this->mod_lr->_selecionarPK([$this->bd_tabela, $this->id]);

                    if( $this->mod_lr->reg_vazio ){
                        $this->mod_lr->tabela = $this->bd_tabela;
                        $this->mod_lr->idreg = $this->id;
                    } // Fim if( $this->mod_lr->reg_vazio )

                    $this->mod_lr->_salvar();
                } // Fim if( class_exists($mod_registro) && $s > 0 && isset($this->id) )

                return $s;

            # Gravar log de remoção
            case '_remover':
                if( ($rem = $this->_remover()) !== false && class_exists(self::LOG_REGISTRO) ){
                    $this->mod_lr->_selecionarPK([$this->bd_tabela, $this->id]);
                    $this->mod_lr->_salvar(true);
                } // Fim if( ($rem = $this->_remover()) !== false && class_exists($mod_registro) )

                return $rem;
        } // Fim switch($n)
    } // Fim do método mágico __call



    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function __get($n){ return m_get($this, $n); } // Fim do método __get
    public function __set($n,$v){ return m_set($this, $n, $v); } // Fim do método __set

    public function _bd_tabela($v = null){
        return $this->bd_tabela = filter_var(!isset($v) ? $this->bd_tabela : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _bd_tabela

    public function _bd_prefixo($v = null){
        return $this->bd_prefixo = filter_var(!isset($v) ? $this->bd_prefixo : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _bd_tabela

    public function _bd_select($v = null){
        return $this->bd_select = filter_var(!isset($v) ? $this->bd_select : $v);
    } // Fim do método _bd_select

    public function _mod_lr(){
        return $this->mod_lr;
    } // Fim do método _bd_tabela

    public function _id($v = null){
        if( !property_exists($this, 'id') || (is_null($this->id) && is_null($v)) ) return null;
        return $this->id = filter_var(!isset($v) ? $this->id : $v);
    } // Fim do método _id

    public function _publicar($v = null){
        if( !property_exists($this, 'publicar') )
            return null;

        return $this->publicar = filter_var(!isset($v) ? $this->publicar : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _id

    public function _delete(){
        if( !property_exists($this, 'delete') )
            return null;

        return $this->bd_delete = filter_var($this->delete, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _id




    /**
     * Listar registros de uma tabela
     *
     * @param string $flt  Filtro a ser aplicado na listagem
     * @param string $ord  Ordenação a ser aplicada na listagem
     * @param string $cpos Campos a serem mostrados na listagem
     * @param int    $pgn  Número da página, para casos de paginação
     * @param int    $qtde Quantidade de registros a serem exibidos durante a paginação
     * @param int    $pos  Posição do registro a ser retornado. Quando null, retorna todos os registros encontrados
     *
     * @return array
     */
    public function _listar($flt = null, $ord = null, $cpos = '*', $pgn = 0, $qtde = 20, $pos = null){
        $query = substr_count($this->bd_select, '%s') == 2 ?
            sprintf($this->bd_select, $cpos, $this->bd_tabela)
            : sprintf($this->bd_select, $cpos, $this->bd_tabela, $this->bd_prefixo);

        !empty($flt) and $query .= stripos($query, 'WHERE') > -1 ? " AND {$flt}" : " WHERE {$flt}";

        !empty($ord) and $query .= " ORDER BY {$ord}";

        // echo $query, '<br>--<br>';

        $sql = $pgn > 0 ?
            \DL3::$bd_conex->_paginacao($query, $pgn, $qtde)
            : \DL3::$bd_conex->query($query);

        if( !$sql ) return false;

        # Resultados da consulta
        $rs = $sql->fetchAll();

        return isset($pos) && !empty($rs) ? $rs[$pos < 0 ? count($rs) + $pos : $pos] : $rs;
    } // Fim do método _listar




    /**
     * Obter a quantidade de registro de uma determinada consulta
     *
     * @param string $flt Filtro a ser aplicado na consulta
     *
     * @return int  Quantidade de registros referente à consulta
     */
    public function _qtde_registros($flt = ''){
        $rs = $this->_listar($flt, null, 'COUNT(*) AS QTDE', 0, 1, 0);
        return (int)$rs['QTDE'];
    } // Fim do método _qtde_registros




    /**
     * Selecionar um registro através da chave primária (PK - Primary Key)
     *
     * @param mixed  $v Valor a ser pesquisado na PK
     * @param string $a Alias da tabela principal configurado na consulta
     *
     * @return bool
     * @throws \Exception
     */
    public function _selecionarPK($v, $a = null){
        if( !isset($v) ) return false;

        $pk = array_map(
            function($v){ return preg_replace("~^{$this->bd_prefixo}~", '', $v); },
            \DL3::$bd_conex->_identifica_pk($this->bd_tabela)
        );

        $pku = count($pk) < 2 ? $pk[0] : $pk;

        return $this->_selecionarUK($pku, $v, $a);
    } // Fim do método _selecionarPK




    /**
     * Selecionar um registro através da chave primária (UK - Unique Key)
     *
     * @param mixed  $c Nome do campos a ser pesquisado
     * @param mixed  $v Valor a ser pesquisado na PK
     * @param string $a Alias da tabela principal configurado na consulta
     *
     * @return bool
     * @throws \Exception
     */
    public function _selecionarUK($c, $v, $a = null){
        if( !method_exists($this, '_listar') )
            throw new \Exception(printf(ERRO_PADRAO_METODO_NAO_EXISTE, '_listar'), 1500);

        $al = !isset($a) ? '' : "{$a}.";

        if( is_array($c) ){
            $cv = array_combine($c, $v);
            $tf = [];

            foreach( $cv as $k => $t ) $tf[] = "{$al}{$this->bd_prefixo}{$k} = ". var_export($t, true);

            $flt = implode(' AND ', $tf);
        } else $flt = "{$al}{$this->bd_prefixo}{$c} = ". var_export($v, true);

        $ls = $this->_listar($flt, null, "{$al}*", 0, 1, 0);

        $dd = array_combine(array_map(function($v){ return preg_replace("~^{$this->bd_prefixo}~", '', $v); }, array_keys($ls)), array_values($ls));

        \Funcoes::_vetor2objeto($dd, $this);

        # Selecionar o LOG desse registro
	    isset($this->id) && get_called_class() !== self::LOG_REGISTRO
	        and $this->mod_lr->_selecionarPK([$this->bd_tabela, $this->id]);

        # Indicar que o registro foi selecionado
        return !($this->reg_vazio = !(bool)$ls);
    } // Fim do método _selecionarUK




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
        $query = $this->reg_vazio ? $this->_criar_insert($ipk, $ci,$ce) : $this->_criar_update($ci,$ce);

        if( !$s ) return $query;

        if( ($exec = \DL3::$bd_conex->exec($query)) === false )
            throw new \Exception(
                sprintf(ERRO_PADRAO_SALVAR_REGISTRO,
                    '<b>'. $this->bd_tabela .':</b><br><br>'. $query .'<br><br>'. \DL3::$bd_conex->errorInfo()[2]
                ),
                1500);

        # Se a ação executada foi um insert, carregar o ID gerado
        if( preg_match('~^(INSERT)~', $query) ){
	        $this->id = \DL3::$bd_conex->lastInsertID("{$this->bd_prefixo}id");
	        return $this->id;
        } else return $exec;
    } // Fim do método _salvar




    /**
     * Remover os registros do banco de dados
     *
     * Caso o registro não possa ser removido por alguma restrição, a FLAG delete é marcada para que não fique visível
     * ao sistema
     *
     * @return int Quantidade de registros removidos
     */
    protected function _remover(){
        if( $this->delete == 1 ) return 1;

        $sql = \DL3::$bd_conex->prepare("DELETE FROM {$this->bd_tabela} WHERE {$this->bd_prefixo}id = :id");
        $rem = $sql->execute([':id' => $this->id]);

        if( $rem === false && property_exists($this, 'delete') ){
            $sql = \DL3::$bd_conex->prepare("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}delete = 1 WHERE {$this->bd_prefixo}id = :id");
            $rem = $sql->execute([':id' => $this->id]);
        } // Fim if( $rem === false && property_exists($this, 'delete') )

        return (int)$rem;
    } // Fim do método _remover




    /**
     * Gerar dinâmicamente o comando SQL INSERT
     *
     * @param bool  $ipk Se true, monta a query considerando a PK para inserção mesmo em caso de IDENTITY /
     *                   AUTO_INCREMENT
     * @param array $ci  Vetor com os nomes dos campos a serem considerados para a geração da consulta
     * @param array $ce  Vetor com os nomes dos campos a serem DESconsiderados para a geração da consulta
     *
     * @return string       String da query gerada
     * @throws \Exception
     */
    public function _criar_insert($ipk = false, array $ci = null, array $ce = null){
        # Informações dos campos
        $cpos = \DL3::$bd_conex->_campos($this->bd_tabela);

        // $v_campos   = [];
        // $v_valores  = [];

	    $campos = [];

        foreach( $cpos as $c ){
	        # Garantir que o campos não esteja sendo incluído na query repetidamente
	        # Obs: Muito necessário pro MSSQL
	        if( array_key_exists($c['Field'], $campos) ) continue;

	        # Nome da propriedade
	        $p = preg_replace("~^{$this->bd_prefixo}~", '', $c['Field']);

	        # Ignorar o campo de marcação da deleção de um registro
	        # Ignorar campos que NAO estejam no vetor $ci, caso o mesmo não seja nulo
	        # Ignorar campos que estejam no vetor $ce, caso o mesmo não seja nulo
	        if( $p === 'delete' || (isset($ci) && !in_array($c['Field'], $ci)) || (isset($ce) && in_array($c['Field'], $ce)) ) continue;

	        # Obter as informações do campos
	        $pk = $c['Key'] === 'PRI';
	        $obr = $c['Null'] === 'NO';

	        if( !isset($this->{$p}) && $obr && !$pk )
		        throw new \Exception(sprintf(ERRO_MODELOPRINCIPAL_CRIARINSERT_CAMPO_OBRIGATORIO_NULO, $c['Field']), 1500);

	        isset($this->{$p}) && (($ipk && $pk) || !$pk)
		        and $campos[$c['Field']] = \Funcoes::_var_export_bd($this->{$p});
        } // Fim foreach( $c )

        return "INSERT INTO {$this->bd_tabela} (". implode(', ', array_keys($campos)) .") VALUES  (". implode(', ', $campos) .")";
    } // Fim do modelo _criar_insert




    /**
     * Criar dinamicamente o comando SQL UPDATE
     *
     * @param array $ci Vetor com os nomes dos campos a serem considerados para a geração da consulta
     * @param array $ce Vetor com os nomes dos campos a serem DESconsiderados para a geração da consulta
     *
     * @return string
     * @throws \Exception
     */
    public function _criar_update(array $ci = null, array $ce = null){
        # Informações dos campos
        $cpos = \DL3::$bd_conex->_campos($this->bd_tabela);

        $alterar  = [];
        $where    = [];

        foreach( $cpos as $c ){
	        # Garantir que o campos não esteja sendo incluído na query repetidamente
	        # Obs: Muito necessário pro MSSQL
	        if( array_key_exists($c['Field'], $alterar) ) continue;

            # Nome da propriedade
            $p = preg_replace("~^{$this->bd_prefixo}~", '', $c['Field']);

            # Ignorar o campo de marcação da deleção de um registro
            # Ignorar campos que NAO estejam no vetor $ci, caso o mesmo não seja nulo
            # Ignorar campos que estejam no vetor $ce, caso o mesmo não seja nulo
            if( $p === 'delete' || (isset($ci) && !in_array($c['Field'], $ci)) ||
	            (isset($ce) && in_array($c['Field'], $ce)) ) continue;

            # Obter as informações do campos
            $pk = $c['Key'] === 'PRI';
            $obr = $c['Null'] === 'NO';

            if( !isset($this->{$p}) ){
                if( $obr && !$pk )
                    throw new \Exception(sprintf(ERRO_MODELOPRINCIPAL_CRIARUPDATE_CAMPO_OBRIGATORIO_NULO, $c['Field']), 1500);
                else continue;
            } // Fim if( !isset($this->{$p}) )

            if( $pk ) $where[$c['Field']] = \Funcoes::_var_export_bd($this->{$p});
            else $alterar[$c['Field']] = \Funcoes::_var_export_bd($this->{$p});
        } // Fim foreach($c)

        return  "UPDATE {$this->bd_tabela} SET ". \Funcoes::_array_serialize($alterar) ." WHERE ". \Funcoes::_array_serialize($where, ' AND ');
    } // Fim do método _criar_update



    /**
     * Carregar um 'select' com VALOR e TEXTO
     *
     * @param string $f     Filtro a ser aplicado na query
     * @param boolean $e    Define se o resultado será escrito no formato json ou retornado
     * @param string $v     Nome do campo identificado como 'value' (sem prefixo)
     * @param string $t     Nome do campo identificado como 'label' (sem prefixo)
     *
     * @return array
     */
    public function _carregarselect($f = null, $e = true, $v = 'id', $t = 'descr'){
        $lis = $this->_listar($f, "{$this->bd_prefixo}{$t}", "{$this->bd_prefixo}{$v} AS VALOR, {$this->bd_prefixo}{$t} AS TEXTO");

        $e and print(json_encode($lis));
        return $lis;
    } // Fim _carregarselect



    /**
     * Alternar a publicação
     */
    public function _alternarpublicacao(){
        if( !property_exists($this, 'publicar') )
            throw new \Exception(ERRO_PRINCIPAL_ALTERNARPUBLICACAO_PROPRIEDADE_NAO_EXISTE, 1404);

        $this->publicar = !$this->publicar;
        return $this->_salvar();
    } // Fim do método _alternarpublicacao
} // Fim do modelo Principal