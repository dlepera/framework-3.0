<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/07/2014 10:05:19
 */

class PDODL extends PDO{
    public function __construct($dsn, $username, $passwd, $options = null){
        parent::__construct($dsn, $username, $passwd, $options);
    } // Fim do método mágico __construct

    /**
     * Realizar a paginação de resultados
     *
     * @param string $query - consulta a ser utilizada na paginação
     * @param int $pagina - número da página atual
     * @param int $qtde - quantidade de registros a ser exibida na paginação
     */
    public function _paginacao($query, $pagina = 1, $qtde = 20){
        if( $qtde > 0 ):
            $bd = \DL3::$bd_conex->getAttribute(PDO::ATTR_DRIVER_NAME);

            switch( $bd ):
                case 'mysql':
                    $inicio = $pagina == 1 ? 0 : ($pagina-1)*$qtde;

                    # Verificar se a query foi passada com o LIMIT
                    if( strpos("LIMIT", $query) > -1 )
                        $query = preg_replace('~LIMIT\s+[\d\w,]+~i', '', $query);

                    # Realizar a paginação dos resultados
                    $query .= " LIMIT {$inicio},{$qtde}";
                    break;

                case 'dblib':
                case 'mssql':
                    $inicio = $pagina == 1 ? 1 : (($pagina-1)*$qtde)+1;
                    $fim    = $inicio == 1 ? $qtde : $pagina*$qtde;

                    $expreg = '~^(SELECT){1}\s+(.+)\s+(FROM){1}\s+(.+)';
                        $expreg .= stripos($query, " WHERE ") === false ? '' : '\s+(WHERE){1}\s+(.+)';
                        $expreg .= stripos($query, " GROUP ") === false ? '' : '\s+(GROUP\s+BY){1}\s+(.+)';
                        $expreg .= stripos($query, " ORDER ") === false ? '' : '\s+(ORDER\s+BY){1}\s+(.+)';
                        $expreg .= '~i';
                    preg_match($expreg, $query, $string);

                    /* =========================================================
                     * 	SEPARAR A CLÃUSULA 'ORDER BY'
                     * ====================================================== */
                        $clausula   = array_search("ORDER BY", $string);
                        if( $clausula === false ) $order = $string[2];
                        else {
                            $order = $string[$clausula+1];

                            # Remover a cláusula ORDER BY do vetor string
                            unset($string[$clausula], $string[$clausula+1]);
                        } // Fim if( $clausula === false )

                    $clausulas = implode(' ', array_slice($string, 2));

                    # Adicionar o número da linha na query principal

                    $query = "{$string[1]} ROW_NUMBER() OVER (ORDER BY ". trim($order) .") AS linha, {$clausulas}";

                    # Realizar a paginação dos resultados
                    $query = "WITH paginacao AS ({$query}) SELECT * FROM paginacao WHERE linha BETWEEN {$inicio} AND {$fim}";
                    break;
            endswitch;
        endif; // Fim if( $qtde > 0 )

        return $this->query($query);
    } // Fim do método _paginacao

    /**
     * Verificar se uma determnada tabela existe no banco de dados
     *
     * @param string $tabela - nome da tabela a ser verificada
     * @return boolean
     */
    public function _LISTA_existe($tabela){
        try{
            $sql = $this->query("SELECT 1 FROM {$tabela}");
        } catch(PDOException $e){
            return false;
        } // Fim do bloco try / catch

        return $sql;
    } // Fim do método _LISTA_existe

    public function _campos($tabela, $campo = null){
        switch(\DL3::$bd_conex->getAttribute(PDO::ATTR_DRIVER_NAME)):
            case 'mysql':
                $sql = $this->query("SHOW COLUMNS FROM {$tabela}". ( !is_null($campo) ? " LIKE '{$campo}'" : ''));
                break;

            case 'mssql':
            case 'dblib':
                $query = "SELECT"
                        . " CAST(C.name AS TEXT) AS Field, CAST(T.name +'('+ CONVERT(VARCHAR(5), T.max_length) +')' AS TEXT) AS Type,"
                        . " CAST(( CASE C.is_nullable WHEN 0 THEN 'NO' WHEN 1 THEN 'YES' END ) AS TEXT) AS 'Null',"
                        . " CAST(( CASE I.is_primary_key WHEN 1 THEN 'PRI' ELSE '' END ) AS TEXT) AS 'Key',"
                        . " CAST(object_definition(C.default_object_id) AS TEXT) AS 'Default',"
                        . " CAST(( CASE C.is_identity WHEN 1 THEN 'auto_increment'"
                        . " ELSE '' END ) AS TEXT) AS Extra"
                        . " FROM sys.columns AS C"
                        . " INNER JOIN sys.types AS T ON( T.user_type_id = C.user_type_id )"
                        . " INNER JOIN sysobjects AS O ON( O.id = C.object_id )"
                        . " LEFT JOIN sys.index_columns AS IC ON( IC.column_id = C.column_id AND IC.object_id = O.id )"
                        . " LEFT JOIN sys.indexes AS I ON( I.index_id = IC.index_id AND I.object_id = O.id )"
                        . " WHERE O.xtype = 'U' AND O.name = '{$tabela}'"
                        . ( !is_null($campo) ? " AND C.name = '{$campo}'" : '' )
                        . " ORDER BY C.column_id";
                $sql = $this->query($query);
                break;
        endswitch;

        if( $sql === false )
            throw new \Exception(
                    sprintf(ERRO_PDODL_CAMPOS,
                        '<b>'. $this->bd_tabela .':</b><br><br>'. $query .'<br><br>'. \DL3::$bd_conex->errorInfo()[2]
                    ),
                1500);

        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } // Fim do método _campos
} // Fim da classe PDODL
