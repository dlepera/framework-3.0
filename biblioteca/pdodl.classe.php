<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/07/2014 10:05:19
 */

class PDODL extends PDO{
	# Identificar chaves primárias
	const MYSQL_IDENTIFICA_PK = "SELECT I.COLUMN_NAME AS NOME_COLUNA FROM information_schema.KEY_COLUMN_USAGE AS I WHERE I.CONSTRAINT_NAME LIKE 'PRIMARY' AND I.TABLE_SCHEMA LIKE :base AND I.TABLE_NAME LIKE :tbl";
	const MSSQL_IDENTIFICA_PK = "SELECT column_name AS NOME_COLUNA FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE OBJECTPROPERTY(OBJECT_ID(constraint_name), 'IsPrimaryKey') = 1 AND :base <> '' AND table_name LIKE :tbl";
	const DBLIB_IDENTIFICA_PK = self::MSSQL_IDENTIFICA_PK;

	# Obter informações dos campos
	const MYSQL_INFO_CAMPOS = 'SHOW COLUMNS FROM :tbl LIKE :cpo';
	const MSSQL_INFO_CAMPOS = "SELECT CAST(C.name AS TEXT) AS Field, CAST(T.name +'('+ CONVERT(VARCHAR(5), T.max_length) +')' AS TEXT) AS Type, CAST(( CASE C.is_nullable WHEN 0 THEN 'NO' WHEN 1 THEN 'YES' END ) AS TEXT) AS 'Null', CAST(( CASE I.is_primary_key WHEN 1 THEN 'PRI' ELSE '' END ) AS TEXT) AS 'Key', CAST(object_definition(C.default_object_id) AS TEXT) AS 'Default', CAST(( CASE C.is_identity WHEN 1 THEN 'auto_increment' ELSE '' END ) AS TEXT) AS Extra FROM sys.columns AS C INNER JOIN sys.types AS T ON( T.user_type_id = C.user_type_id ) INNER JOIN sysobjects AS O ON( O.id = C.object_id ) LEFT JOIN sys.index_columns AS IC ON( IC.column_id = C.column_id AND IC.object_id = O.id )  LEFT JOIN sys.indexes AS I ON( I.index_id = IC.index_id AND I.object_id = O.id ) WHERE O.xtype = 'U' AND O.name = ':tbl'  AND C.name LIKE :cpo ORDER BY C.column_id";
	const DBLIB_INFO_CAMPOS = self::MSSQL_INFO_CAMPOS;

	protected $driver, $host, $porta, $bd;



    public function __construct($dsn, $username, $passwd, $options = null){
        parent::__construct($dsn, $username, $passwd, $options);
	    $this->_infos_dsn($dsn);
    } // Fim do método mágico __construct



	/**
	 * Identificar as informações de conexão através da string de conexão DSN
	 *
	 * @param $dsn String DSN de conexão
	 */
	public function _infos_dsn($dsn){
		preg_match('~^([a-z]+):host=([a-z0-9\.\-]+);port=([0-9]{1,6});dbname=([a-z0-9_]+)~', $dsn, $dados);
		list(, $this->driver, $this->host, $this->porta, $this->bd) = $dados;
		$this->driver = strtoupper($this->driver);
	} // Fim do método _infos_dsn




	/**
	 * Paginação de resultados
	 *
	 * @param string $q     Consulta a ser executada
	 * @param int $pgn      Número da página a ser considerada para o cálculo
	 * @param int $qtde     Quantidade de registros a ser exibido nessa página
	 *
	 * @return PDOStatement
	 */
    public function _paginacao($q, $pgn = 1, $qtde = 20){
        if( $qtde > 0 ):
            switch( $this->driver ):
                case 'MYSQL':
                    $inicio = $pgn == 1 ? 0 : ($pgn-1)*$qtde;

                    # Verificar se a query foi passada com o LIMIT
                    if( strpos("LIMIT", $q) > -1 )
                        $q = preg_replace('~LIMIT\s+[\d\w,]+~i', '', $q);

                    # Realizar a paginação dos resultados
                    $q .= " LIMIT {$inicio},{$qtde}";
                break;

                case 'DBLIB':
                case 'MSSQL':
                    $inicio = $pgn == 1 ? 1 : (($pgn-1)*$qtde)+1;
                    $fim    = $inicio == 1 ? $qtde : $pgn*$qtde;

                    $expreg = '~^(SELECT){1}\s+(.+)\s+(FROM){1}\s+(.+)';
                        $expreg .= stripos($q, " WHERE ") === false ? '' : '\s+(WHERE){1}\s+(.+)';
                        $expreg .= stripos($q, " GROUP ") === false ? '' : '\s+(GROUP\s+BY){1}\s+(.+)';
                        $expreg .= stripos($q, " ORDER ") === false ? '' : '\s+(ORDER\s+BY){1}\s+(.+)';
                        $expreg .= '~i';
                    preg_match($expreg, $q, $string);

                    $clausula = array_search("ORDER BY", $string);
                    if( $clausula === false ) $order = $string[2];
                    else {
                        $order = $string[$clausula+1];

                        # Remover a cláusula ORDER BY do vetor string
                        unset($string[$clausula], $string[$clausula+1]);
                    } // Fim if( $clausula === false )

                    $clausulas = implode(' ', array_slice($string, 2));

                    # Adicionar o número da linha na query principal

                    $q = "{$string[1]} ROW_NUMBER() OVER (ORDER BY ". trim($order) .") AS linha, {$clausulas}";

                    # Realizar a paginação dos resultados
                    $q = "WITH paginacao AS ({$q}) SELECT * FROM paginacao WHERE linha BETWEEN {$inicio} AND {$fim}";
                break;
            endswitch;
        endif; // Fim if( $qtde > 0 )

        return $this->query($q);
    } // Fim do método _paginacao



    /**
     * Verificar se uma determnada tabela existe no banco de dados
     *
     * @param string $tbl - nome da tabela a ser verificada
     * @return boolean
     */
    public function _tabela_existe($tbl){
        return (bool)$this->query("SELECT 1 FROM {$tbl}");
    } // Fim do método _tabela_existe



    public function _campos($tbl, $cpo = '%%'){
        if( !$this->_tabela_existe($tbl) ) return;

	    $c = 'self::'. $this->driver .'_INFO_CAMPOS';

	    if( !defined($c) ) throw new \Exception(ERRO_PDODL_SGBD_NAO_SUPORTADO);

	    $q = constant($c);

	    $sql = $this->prepare($this->driver == 'MYSQL' ? str_replace(':tbl', $tbl, $q) : $q);

	    if( !$sql->execute([':cpo' => $cpo]) )
		    var_dump($sql->errorInfo());
		    // throw new \Exception($sql->errorInfo(), 1500);

        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } // Fim do método _campos




	/**
	 * Identificar a chave primária de uma tabela
	 *
	 * @param string $tbl Nome da tabela a ser pesquisada
	 *
	 * @return string|array|void  String com o nome do campo PK ou um vetor com os nomes (chaves compostas) ou void se
	 *                             não encontrar
	 * @throws Exception
	 */
	public function _identifica_pk($tbl){
		if( !$this->_tabela_existe($tbl) ) return;

		$c = 'self::'. $this->driver .'_IDENTIFICA_PK';

		if( !defined($c) ) throw new \Exception(ERRO_PDODL_SGBD_NAO_SUPORTADO);

		$sql = $this->prepare(constant($c), [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
		$sql->execute([':base' => $this->bd,  ':tbl' => $tbl]);

		return array_column($sql->fetchAll(\PDO::FETCH_ASSOC), 'NOME_COLUNA');
	} // Fim do método _identifica_pk



	public function _alterar_tipos_campos($tbls = [], $tp1, $tp2){
		# Query para alterar tipo do campo
		$qa = 'ALTER TABLE %s MODIFY %s %s';

		# Contar quantidade de campos alterados
		$qt = 0;

		$sql = $this->query("SHOW TABLES");

		while( $tb = $sql->fetchColumn(0) ){
			if( !empty($tbls) && !in_array($tb, $tbls) ) continue;

			# Todos os campos da tabela
			$tcs = $this->_campos($tb);

			# Campos a serem alteradas
			$cps = array_intersect_key($tcs, preg_grep("~{$tp1}~i", array_column($tcs, 'Type')));

			foreach( $cps as $c ){
				$o = [
					strtoupper($c['Null']) == 'NO' ? ' NULL' : ' NOT NULL',
					!is_null($c['Default']) ? "DEFAULT {$c['Default']}" : ''
				];

				$qt += $this->exec(sprintf($qa, $tb, $c['Field'], $tp2) . implode(' ', $o));
			} // Fim foreach

		} // Fim while

		return $qt;
	} // Fim do método _alterarcampos
} // Fim da classe PDODL
