<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/05/2014 11:38:28
 */

class Funcoes{
    /**
     * Converter vetor para as propriedades de um objeto
     *
     * @param array  $vetor   Vetor com os valore a serem incluídos em $obj. As chaves devem conter os nomes das
     *                        propriedades
     * @param object $obj     Objeto já instanciado que receberá os valores do $vetor
     * @param string $prefixo Prefixo dos nomes de propriedades
     *
     * @return null|void
     */
    public static function _vetor2objeto($vetor, &$obj, $prefixo = ''){
        if( !isset($vetor) ) return null;

        foreach( $vetor as $p => $v ){
            $p = "{$prefixo}{$p}";
            property_exists($obj, $p) && isset($v) and $obj->{$p} = $v;
        } // Fim foreach
    } // Fim do método _post2objeto




    /**
     * Formatar data e hora
     *
     * @param string $data_hora string contendo uma representação de data ou hora
     * @param string $formato   string contendo o formtado da data e/ou hora desejado. O farmato deve ser aceito pela
     *                          função date();
     *
     * @return bool|mixed|string
     */
    public static function _formatardatahora($data_hora, $formato){
        # Se $formato estiver em branco retornar a data sem nenhum alteração
        if( empty($formato) ) return $data_hora;

        # Essas strings não serão aceitas, por se tratarem de datas
        # e / ou horas inválidas
        $nao_aceito = ['0000-00-00', '0000-00-00 00:00:00'];

        if( empty($data_hora) || in_array($data_hora, $nao_aceito) )
            return '';

        # Se a string de data não foi válida para a conversão retorná-la com uma mensagem de erro
        if( !strtotime($data_hora) ) return "{$data_hora} - Data informada inválida";

        # A função strtotime() não aceita a string da data no formato brasileiro
        # com a '/' barra separando dia, mês e ano. Portanto, caso a data seja
        # informada dessa forma substituir a '/' barra pelo '-' hifém
        strpos($data_hora, '/') > -1 and $data_hora = str_replace('/', '-', $data_hora);

        return date_format(date_create($data_hora), $formato);
    } // Fim do método _formatardatahora




    /**
     * Exibir o conteúdo em formato JSON para que o sistema possa exibi-lo ao usuário
     *
     * @param string $msg  Mensagem a ser exibida na tela
     * @param string $tipo Define parte da aparência da mensagens exibida
     */
    public static function _retornar($msg, $tipo){
        \DL3::$tmp_buffer_resposta[] = [
            'mensagem'  =>  strtoupper(\DL3::$ap_charset) !== 'UTF-8' ? utf8_encode($msg) : $msg,
            'tipo'      =>  $tipo
        ];
    } // Fim do método _retornar




    /**
     * Converter o encoding de uma variável
     *
     * @param var    $var         Variável a ser convertida
     * @param string $para_encode Novo encode a ser utilizado
     * @param string $de_encode   Encode atual da variável
     */
    public static function _converterencode(&$var, $para_encode, $de_encode = 'UTF-8'){
        if( !isset($var) ) return;

        if( !is_array($var) ){
            if( mb_check_encoding($var, $de_encode) )
                $var = mb_convert_encoding($var, $para_encode, $de_encode);
        } else {
            foreach( $var as &$v )
                self::_converterencode($v, $para_encode, $de_encode);
        } // Fim if( !is_array($var) )
    } // Fim do método _converterencode




    /**
     * Remover acentuação de uma string
     *
     * @param string $string string a ter a acentuação removida
     *
     * @returns string string com a acentuação removida
     */
    public static function _removeracentuacao($string){
        # Obter o encoding interno do submit do form
        preg_match("#^(.+);\s.+\=(.+)$#", filter_input(INPUT_SERVER, 'CONTENT_TYPE'), $content_type);
        list(, $content_type, $encode) = $content_type;

        # Caracteres que deverão ser substituídos
        $acentuacao = [];

        # Acentuação na letra 'a' minúscula
        $acentuacao['a'] = ['á', 'Ã ', 'â', 'ã'];

        # Acentuação na letra 'e' minúscula
        $acentuacao['e'] = ['é', 'Ã¨', 'ê'];

        # Acentuação na letra 'i' minúscula
        $acentuacao['i'] = ['í', 'Ã¬', 'Ã®'];

        # Acentuação na letra 'o' minúscula
        $acentuacao['o'] = ['ó', 'Ã²', 'Ã´', 'õ'];

        # Acentuação na letra 'u' minúscula
        $acentuacao['u'] = ['ú', 'Ã¹', 'Ã»'];

        # Acentuação na letra 'ç' minúscula
        $acentuacao['c'] = ['ç'];

        # Acentuação na letra 'A' MAIÃSCULA
        $acentuacao['A'] = ['Ã', 'Ã', 'Ã', 'Ã'];

        # Acentuação na letra 'E' MAIÃSCULA
        $acentuacao['E'] = ['Ã', 'Ã', 'Ã'];

        # Acentuação na letra 'I' MAIÃSCULA
        $acentuacao['I'] = ['Ã', 'Ã', 'Ã'];

        # Acentuação na letra 'O' MAIÃSCULA
        $acentuacao['O'] = ['Ã', 'Ã', 'Ã', 'Ã'];

        # Acentuação na letra 'U' MAIÃSCULA
        $acentuacao['U'] = ['Ã', 'Ã', 'Ã'];

        # Acentuação na letra 'Ã' MAIÃSCULA
        $acentuacao['C'] = ['Ã'];

        # Verificar se o encoding precisa ser ajustado
        $content_type != 'multipart/form-data' && !empty($encode) and $ajustar_encode = true;

        $string = $ajustar_encode && mb_detect_encoding($string) != $encode ?
            mb_convert_encoding($string, $encode) : $string;

        foreach( $acentuacao as $chave => $acento ){
            foreach( $acento as $letra ){
                $letra = ($ajustar_encode) ? mb_convert_encoding($letra, $encode) : $letra;

                strpos($string, $letra) !== false and $string = str_replace($letra, $chave, $string);
            } // Fim foreach
        } // Fim foreach

        return $string;
    } // Fim do método _removeracentuacao




    /**
     * Aplicar máscara de dados a uma string
     *
     * @param string $string String onde será aplicada a máscara
     * @param string $mask   Máscara a ser aplicada
     *
     * @return string
     */
    public static function _mascara($string, $mask){
        define('MASK', '#');

        while( ($pos = strpos($mask, MASK)) !== false ){
            # Aplicar a máscara
            $mask = preg_replace('~' . MASK . '{1}~', $string[0], $mask, 1);

            # Remover o primeiro caractere da $string
            $string = substr($string, 1);
        } // Fim while

        return $mask;
    } // Fim do método _mascara




    /**
     * Converter as primeiras letras de cada palavra para maiúscula e as demais para minúsculas
     *
     * @param string $string String a ser convertida
     * @param array  $exceto Vetor contendo strings que não devem ser convertidas
     * @param string $idioma Sigla do idioma a ser considerado para a conversão
     *
     * @return string
     */
    public static function _ucwords($string, array $exceto = [], $idioma = 'pt_BR'){
        # Alterar o idioma (locale) para o pt_BR para
        # evitar problemas com acentuação
        mb_internal_encoding() == 'UTF-8' and setlocale(LC_CTYPE, $idioma);

        # Esse trecho foi inspirado numa função postada por Paulo Freitas
        # em: http://forum.wmonline.com.br/topic/188764-transformar-primeira-letra-de-cada-palavra-em-maiuscula/
        return implode(' ',
            array_map(
                create_function('$s', 'return !in_array($s, '. var_export($exceto, true) .') ? ucfirst($s) : $s;'),
                explode(' ', mb_strtolower($string, mb_detect_encoding($string)))
            )
        );
    } // Fim do método _ucwords




    /**
     *  Transformar um valor booleano em valor compreensível para os humanos
     *
     * @param bool   $v Valor booleano a ser testado
     * @param string $i Sigla do idioma a ser utilizado para a tradução
     *
     * @return string String contendo o valor traduzido para a linguagem humana
     */
    public static function _bool2humano($v, $i = 'pt_BR'){
        $idiomas = [
            'pt_BR' => ['Não', 'Sim'],
            'en_US' => ['No', 'Yes'],
            'es_ES' => ['No', 'Sí']
        ];

        return $idiomas[$i][(int)$v];
    } // Fim do método _bool2humano




    /**
     * Converter string no formato de expressão regular em um formato aceito para validação HTML5
     *
     * @param string $er String no formato de expressão regular para ser convertida
     * @param string $dl Delimitador utilizado na expressão regular
     *
     * @return mixed
     */
    public static function _expreg_form($er, $dl = '~'){
        return preg_replace("#(^{$dl}|{$dl}$)#", '', $er);
    } // Fim do método _expreg_form




    /**
     * Preparar dados para inclusão no banco de dados
     *
     * @param mixed $v
     *
     * @return mixed
     */
    public static function _var_export_bd($v){
        return is_bool($v) ? filter_var(intval($v), FILTER_VALIDATE_INT) : var_export($v, true);
    } // Fim do método _var_export_bd




    /**
     * Remover uma determinada coluna de um array multi-dimensional
     *
     * @param array $v Vetor multi-dimensional a ser verificado
     * @param mixed $c Nome ou índice da coluna a ser removida
     *
     * @return array
     */
    public static function _remover_coluna($v, $c){
        return array_map(function ($v) use ($c){
            if( isset($v) && is_array($v) ) unset($v[$c]);
            return $v;
        }, $v);
    } // Fim do método _remover_coluna




	/**
	 * Serializar um vetor, podendo escolher se ele será codificado para URL ou não
	 *
	 * @param array      $v   Vetor a ser seializado
	 * @param string     $s   Separador das informações
	 * @param bool|false $url Se true, a string será retornada codificada para URL, caso contrário não
	 *
	 * @return string
	 */
    public static function _array_serialize($v, $s = ', ', $url = false){
	    $vs = http_build_query($v, null, $s);
	    return $url ? $vs : urldecode($vs);
    } // Fim do método _array_serialize
} // Fim da classe Funções
