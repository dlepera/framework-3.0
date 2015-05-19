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
     * @param string $q - consulta a ser utilizada na paginação
     * @param int $pgn - número da página atual
     * @param int $qtde - quantidade de registros a ser exibida na paginação
     */
    public function _paginacao($q, $pgn = 1, $qtde = 20){
        if( $qtde > 0 ):
            $bd = \DL3::$bd_conex->getAttribute(PDO::ATTR_DRIVER_NAME);

            switch( $bd ):
                case 'mysql':
                    $inicio = $pgn == 1 ? 0 : ($pgn-1)*$qtde;

                    # Verificar se a query foi passada com o LIMIT
                    if( strpos("LIMIT", $q) > -1 )
                        $q = preg_replace('~LIMIT\s+[\d\w,]+~i', '', $q);

                    # Realizar a paginação dos resultados
                    $q .= " LIMIT {$inicio},{$qtde}";
                    break;

                case 'dblib':
                case 'mssql':
                    $inicio = $pgn == 1 ? 1 : (($pgn-1)*$qtde)+1;
                    $fim    = $inicio == 1 ? $qtde : $pgn*$qtde;

                    $expreg = '~^(SELECT){1}\s+(.+)\s+(FROM){1}\s+(.+)';
                        $expreg .= stripos($q, " WHERE ") === false ? '' : '\s+(WHERE){1}\s+(.+)';
                        $expreg .= stripos($q, " GROUP ") === false ? '' : '\s+(GROUP\s+BY){1}\s+(.+)';
                        $expreg .= stripos($q, " ORDER ") === false ? '' : '\s+(ORDER\s+BY){1}\s+(.+)';
                        $expreg .= '~i';
                    preg_match($expreg, $q, $string);

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
        try{
            $sql = $this->query("SELECT 1 FROM {$tbl}");
        } catch(PDOException $e){
            return false;
        } // Fim do bloco try / catch

        return $sql;
    } // Fim do método _tabela_existe

    public function _campos($tbl, $cpo = null){
        if( !$this->_tabela_existe($tbl) ) return;

        switch(\DL3::$bd_conex->getAttribute(PDO::ATTR_DRIVER_NAME)):
            case 'mysql':
                $q      = "SHOW COLUMNS FROM {$tbl}". ( !is_null($cpo) ? " LIKE '{$cpo}'" : '');
                $sql    = $this->query($q);
                break;

            case 'mssql':
            case 'dblib':
                $q = "SELECT"
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
                        . " WHERE O.xtype = 'U' AND O.name = '{$tbl}'"
                        . ( !is_null($cpo) ? " AND C.name = '{$cpo}'" : '' )
                        . " ORDER BY C.column_id";
                $sql = $this->query($q);
                break;
        endswitch;

        if( $sql === false )
            throw new \Exception(
                    sprintf(ERRO_PDODL_CAMPOS,
                        '<b>'. $tbl .':</b><br><br>'. $q .'<br><br>'. \DL3::$bd_conex->errorInfo()[2]
                    ),
                1500);

        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } // Fim do método _campos
} // Fim da classe PDODL
