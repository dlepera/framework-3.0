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
     * @param array $vetor - vetor com os valore a serem incluídos em $obj.
     * As chaves devem conter os nomes das propriedades
     * @param object $obj - objeto já instanciado que receberá os valores
     * do $vetor
     * @param string $prefixo - prefixo dos nomes de propriedades
     */
    public static function _vetor2objeto($vetor, &$obj, $prefixo = ''){
        foreach( $vetor as $p => $v ):
            $p = "{$prefixo}{$p}";

            if( property_exists($obj, $p) && !is_null($v) )
                $obj->{$p} = $v;
        endforeach;
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
        if( empty($formato) )
            return $data_hora;

        # Essas strings não serão aceitas, por se tratarem de datas
        # e / ou horas inválidas
        $nao_aceito = array(
            '0000-00-00',
            '0000-00-00 00:00:00'
        );

        if( empty($data_hora) || in_array($data_hora, $nao_aceito) )
            return '';

        # A função strtotime() não aceita a string da data no formato brasileiro
        # com a '/' barra separando dia, mês e ano. Portanto, caso a data seja
        # informada dessa forma substituir a '/' barra pelo '-' hifém
        if( strpos($data_hora, '/') > -1 )
            $data_hora = str_replace('/', '-', $data_hora);

        return date_format(date_create($data_hora), $formato);
    } // Fim do método _formatardatahora



    /**
     * Exibir o conteúdo em formato JSON para que o sistema possa exibi-lo
     * ao usuário
     *
     * @param string $msg Mensagem a ser exibida na tela
     * @param string $tipo Define parte da aparência da mensagens exibida
     */
    public static function _retornar($msg, $tipo){
        \DL3::$tmp_buffer_resposta[] = array(
            'mensagem'  =>  strtoupper(\DL3::$ap_charset) !== 'UTF-8' ? utf8_encode($msg) : $msg,
            'tipo'      =>  $tipo
        );
    } // Fim do método _retornar




	/**
	 * Converter o encoding de uma variável
	 *
	 * @param var    $var         Variável a ser convertida
	 * @param string $para_encode Novo encode a ser utilizado
	 * @param string $de_encode   Encode atual da variável
	 */
    public static function _converterencode(&$var, $para_encode, $de_encode = 'UTF-8'){
        if( is_null($var) ) return;

        if( !is_array($var) ):
            if( mb_check_encoding($var, $de_encode) ):
                $var = mb_convert_encoding($var, $para_encode, $de_encode);
            endif;
        else:
            foreach( $var as &$v )
                self::_converterencode($v, $para_encode, $de_encode);
        endif;
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
        $acentuacao = array();

        # Acentuação na letra 'a' minúscula
        $acentuacao['a'] = array('á', 'Ã ', 'â', 'ã');

        # Acentuação na letra 'e' minúscula
        $acentuacao['e'] = array('é', 'Ã¨', 'ê');

        # Acentuação na letra 'i' minúscula
        $acentuacao['i'] = array('í', 'Ã¬', 'Ã®');

        # Acentuação na letra 'o' minúscula
        $acentuacao['o'] = array('ó', 'Ã²', 'Ã´', 'õ');

        # Acentuação na letra 'u' minúscula
        $acentuacao['u'] = array('ú', 'Ã¹', 'Ã»');

        # Acentuação na letra 'ç' minúscula
        $acentuacao['c'] = array('ç');

        # Acentuação na letra 'A' MAIÃSCULA
        $acentuacao['A'] = array('Ã', 'Ã', 'Ã', 'Ã');

        # Acentuação na letra 'E' MAIÃSCULA
        $acentuacao['E'] = array('Ã', 'Ã', 'Ã');

        # Acentuação na letra 'I' MAIÃSCULA
        $acentuacao['I'] = array('Ã', 'Ã', 'Ã');

        # Acentuação na letra 'O' MAIÃSCULA
        $acentuacao['O'] = array('Ã', 'Ã', 'Ã', 'Ã');

        # Acentuação na letra 'U' MAIÃSCULA
        $acentuacao['U'] = array('Ã', 'Ã', 'Ã');

        # Acentuação na letra 'Ã' MAIÃSCULA
        $acentuacao['C'] = array('Ã');

        # Verificar se o encoding precisa ser ajustado
        if( $content_type != 'multipart/form-data' && !empty($encode) )
            $ajustar_encode = true;

        $string = ( $ajustar_encode && mb_detect_encoding($string) != $encode )?
            mb_convert_encoding($string, $encode)
        : $string;

        foreach( $acentuacao as $chave=>$acento ):
            foreach( $acento as $letra ):
                $letra = ( $ajustar_encode )?
                    mb_convert_encoding($letra, $encode)
                : $letra;

                if( strpos($string, $letra) !== false )
                    $string = str_replace($letra, $chave, $string);
            endforeach;
        endforeach;

        return $string;
    } // Fim do método _removeracentuacao

    /**
     * Aplicar máscara de dados a uma string
     * -------------------------------------------------------------------------
     *
     * @param string $string - string onde será aplicada a máscara
     * @param string $mask - máscara a ser aplicada
     * @return string
     */
    public static function _mascara($string, $mask){
        define('MASK', '#');

        while( ($pos = strpos($mask, MASK)) !== false ):
            # Aplicar a máscara
            $mask = preg_replace('~'. MASK .'{1}~', $string[0], $mask, 1);

            # Remover o primeiro caractere da $string
            $string = substr($string, 1);
        endwhile;

        return $mask;
    } // Fim do método _mascara

    /**
     * Converter as primeiras letras de cada palavra para maiúscula e as demais para minúsculas
     * @param string $string - string a ser convertida
     * @param array $exceto - vetor contendo strings que não devem ser convertidas
     * @param string $idioma - sigla do idioma a ser considerado para a conversão
     * @return string
     */
    public static function _ucwords($string, array $exceto = array(), $idioma = 'pt_BR'){
        # Alterar o idioma (locale) para o pt_BR para
        # evitar problemas com acentuação
        if( mb_internal_encoding() == 'UTF-8' )
            setlocale(LC_CTYPE, $idioma);

        # Esse trecho foi inspirado numa função postada por Paulo Freitas
        # em: http://forum.wmonline.com.br/topic/188764-transformar-primeira-letra-de-cada-palavra-em-maiuscula/
        return implode(' ',
            array_map(
                create_function('$s', 'return !in_array($s, '. var_export($exceto, true) .') ? ucfirst($s) : $s;'),
                explode(' ', strtolower($string))
            )
        );
    } // Fim do método _ucwords



    /**
     *  Transformar um valor booleano em valor compreensível para os humanos
     * -------------------------------------------------------------------------
     *
     * @param bool $v - valor booleano a ser testado
     * @param string $i - sigla do idioma a ser utilizado para a tradução
     *
     * @return string - String contendo o valor traduzido para a linguagem humana
     */
    public static function _bool2humano($v,$i='pt_BR'){
        $idiomas = array(
            'pt_BR' => array('Não', 'Sim'),
            'en_US' => array('No', 'Yes'),
            'es_ES' => array('No', 'Sí')
        );

        return $idiomas[$i][(int)$v];
    } // Fim do método _bool2humano
} // Fim da classe Funções
