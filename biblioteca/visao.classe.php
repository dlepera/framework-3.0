<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 13:40:18
 */

class Visao{
    # Configurações
    const CONF_EXTENSAO_TPL = 'phtml';

    private $dir_visoes, $templates = array(), $conteudo;

    # Parâmetros da página
    private $params = array();

    # Configurações da página
    private $titulo;



    public function __construct($nm){
        $this->dir_visoes = sprintf(\DL3::DIR_MODULOS, DL3_APLICATIVO, $nm) . \DL3::DIR_VISOES;
    } // Fim do método __construct

    public function __destruct(){
        $this->_mostrarconteudo();
    } // Fim do método __destruct



    /**
     * 'Gets'e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function __get($n){
        $g = "_{$n}";

        if( property_exists($this, $n) && method_exists($this, $g) )
            return $this->{$g}();
    } // Fim do método __get

    public function __set($n,$v){
        $g = "_{$n}";

        if( property_exists($this, $n) && method_exists($this, $g) )
            return $this->{$g}(filter_var($v, FILTER_DEFAULT));
    } // Fim do método __set

    public function _titulo($v=null){
        return is_null($v) ? (string)$this->titulo
        : $this->titulo = (string)$v;
    } // Fim do método _titulo



    /**
     * Incluir template para compor a visão
     * -------------------------------------------------------------------------
     *
     * @param string $tpl - nome do template a ser carregado
     * @param bool $p - Define se o teplate será procurado níveis acima
     * @param int $o - Ordenação do template
     */
    public function _adtemplate($tpl, $p=false, $o = 0){
        # Definir a ordenação
        $ch = array_keys($this->templates);

        while( in_array($o, $ch) ) $o++;

        $tpl_a = "{$tpl}.". self::CONF_EXTENSAO_TPL;
        $this->templates[$o] = $p ? $this->_procurartemplate($tpl_a) : "{$this->dir_visoes}{$tpl_a}";
    } // Fim do método _adtemplate



    /**
     * Carregar o conteúdo do template em buffer
     * -------------------------------------------------------------------------
     *
     * O conteúdo é lido e armazenado em buffer. Em seguida o conteúdo que está
     * no buffer é transferido para a propriedade $this->conteudo que poderá
     * ser lida posteriormente e assim o buffer pode ser liberado.
     */
    private function _carregarconteudo(/* $p=false */){
        if( empty($this->templates) ) return;

        # Ordenar os templates
        ksort($this->templates);

        # Incluir parâmetros padrões
        $this->_adparam('titulo', $this->titulo);

        # Iniciar buffer
        ob_start();

        foreach( $this->templates as $t )
            include_once $t;

        # Armazenar o conteúdo obtido
        $this->conteudo = ob_get_contents();

        # Finalizar o buffer
        ob_end_clean();
    } // Fim do método _carregarconteudo



    /**
     * Mostrar o conteúdo obtido
     * -------------------------------------------------------------------------
     */
    public function _mostrarconteudo(){
        if( empty($this->conteudo) )
            $this->_carregarconteudo();

        echo $this->conteudo;
    } // Fim do método _mostrarconteudo



    /**
     * Adicionar um parâmetro para ser mostrado na visão
     * -------------------------------------------------------------------------
     * O parâmetro á adicionado a um vetor e a visão pode acessá-lo através
     * do método $this->_obterparams()
     *
     * @param string $n - nome do parâmetro
     * @param mixed $v - valor atribuído ao parâmetro
     */
    public function _adparam($n,$v){
        $this->params[$n] = is_scalar($v) ?
            filter_var($v, FILTER_DEFAULT)
        : $v;
    } // Fim do método _adparam



    /**
     * Obter um ou todos os parâmetros
     * -------------------------------------------------------------------------
     * @param string $n - nome do parâmetro a ser obtido. Quando nulo ou em branco
     *  retorna um vetor associativo com todos os parâmetros configurados
     *
     * @return mixed - Retorna o valor do parâmetro solicitado ou um vetor com
     *  todos os parâmetros
     */
    public function _obterparams($n=null){
        if( is_null($n) ) return (array)$this->params;

        # Verificar se o parâmetro solicitado existe
        if( !array_key_exists($n, $this->params) )
            return '<span style="color:red;">Parâmetro não encontrado!</span>';

        return $this->params[$n];
    } // Fim do método _obterparams



    /**
     * Procurar determinado template até $num níveis acima
     * -------------------------------------------------------------------------
     *
     * @param string $tpl - nome do template a ser procurado
     * @param string $num - qtde de níveis a subir durante a procura
     *
     * @return mixed - Retorna a string com o caminho para o template ou false
     *  caso o template não seja localizado
     */
    public function _procurartemplate($tpl, $num = 5){
        $qtde = 0;

        while( !file_exists("{$this->dir_visoes}{$tpl}") && $qtde < $num ):
            $tpl = "../{$tpl}";
            $qtde++;
        endwhile;

        $tpl_r = "{$this->dir_visoes}{$tpl}";

        return !file_exists($tpl_r) ? false : $tpl_r;
    } // Fim do método _procurartemplate
} // Fim da classe Visao