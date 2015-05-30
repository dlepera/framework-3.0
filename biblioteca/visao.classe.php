<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 13:40:18
 */

class Visao{
    # Configurações
    const CONF_EXTENSAO_MESTRA  = 'mestra';
    const CONF_EXTENSAO_TPL     = 'phtml';

    private $diretorio, $pg_mestra = 'padrao', $templates = array(), $conteudo, $dl3_areas = array('DL3-HEAD', 'DL3-CONTEUDO', 'DL3-RODAPE', 'DL3-SCRIPTS');

    # Parâmetros da página
    private $params = array(), $exibir_auto = true;

    # Configurações da página
    private $titulo, $cont_mestra;



    public function __construct($nm, $pgm=null){
        $this->_diretorio(sprintf(\DL3::DIR_MODULOS, DL3_APLICATIVO, $nm) . \DL3::DIR_VISOES);
        $this->_pg_mestra($pgm);
    } // Fim do método __construct

    public function __destruct(){
        $this->_mostrarconteudo(!$this->exibir_auto);
    } // Fim do método __destruct



    /**
     * 'Gets'e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function __get($n){ return m_get($this,$n); } // Fim do método __get
    public function __set($n,$v){ return m_set($this, $n, $v); } // Fim do método __set

    public function _diretorio($v=null){
        return $this->diretorio = filter_var(is_null($v) ? $this->diretorio : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _diretorio

    public function _pg_mestra($v=null){
        return $this->pg_mestra = filter_var(is_null($v) ? $this->pg_mestra : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _pg_mestra

    public function _titulo($v=null){
        $this->titulo = filter_var(is_null($v) ? $this->titulo : $v, FILTER_SANITIZE_STRING);

        if( !is_null($v) ):
            # Incluir parâmetros padrões
            $this->_adparam('titulo', $this->titulo);
        endif;

        return $this->titulo;
    } // Fim do método _titulo

    public function _exibir_auto($v=null){
        return $this->exibir_auto = filter_var(is_null($v) ? $this->exibir_auto : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _exibir_auto



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
     * Carregar conteúdo de uma página mestra
     * -------------------------------------------------------------------------
     *
     * @return mixed Conteúdo da página mestra carregada
     * @throws \Exception
     */
    private function _carregarmestra(){
        $d = 'aplicativos/'. DL3_APLICATIVO ."/mestras/{$this->pg_mestra}.". self::CONF_EXTENSAO_MESTRA;

        if( !file_exists($d) )
            throw new \Exception("Página mestra <b>{$d}</b> não encontrada!", 1404);

        ob_start();

        include_once $d;

        $this->cont_mestra = ob_get_contents();

        return ob_end_clean();
    } // Fim do método _carregarmestra



    private function _area_dl3($c, $a='DL3-CONTEUDO'){
        preg_match_all(
                "~(?s)\[{$a}\](.*?)\[/{$a}\]~",
                $c, $html
            );

        return implode("\n", $html[1]);
    } // Fim do método _area_dl3



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

        # Iniciar buffer
        ob_start();

        echo "[DL3-HEAD]<script>\n"
            . " // Configurações para o JS\n"
            . " var dir_relativo = '". \DL3::$dir_relativo ."';\n"
            . '</script>[/DL3-HEAD]';
        foreach( $this->templates as $t ) include $t;

        # Armazenar o conteúdo obtido
        $this->conteudo = ob_get_contents();

        # Finalizar o buffer
        ob_end_clean();
    } // Fim do método _carregarconteudo



    /**
     * Mostrar o conteúdo obtido
     * -------------------------------------------------------------------------
     */
    public function _mostrarconteudo($r=false){
        # Carregar o conteúdo da página
        if( empty($this->conteudo) ) $this->_carregarconteudo();

        if( !empty($this->conteudo) ):
            # Carregar a página mestra
            if( empty($this->cont_mestra) ) $this->_carregarmestra();

            $mst = $this->cont_mestra;

            foreach( $this->dl3_areas as $a )
                $mst = str_replace("[{$a}/]", $this->_area_dl3($this->conteudo, $a), $mst);
        endif;

        if( $r ) return $mst;
        echo $mst;
    } // Fim do método _mostrarconteudo



    /**
     * Adicionar um parâmetro para ser mostrado na visão
     * -------------------------------------------------------------------------
     * O parâmetro á adicionado a um vetor e a visão pode acessá-lo através
     * do método $this->_obterparams()
     *
     * @param string $n Nome do parâmetro
     * @param mixed $v Valor atribuído ao parâmetro
     */
    public function _adparam($n,$v){
        $this->params[$n] = is_scalar($v) && !is_bool($v) ?
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

        while( !file_exists("{$this->diretorio}{$tpl}") && $qtde < $num ):
            $tpl = "../{$tpl}";
            $qtde++;
        endwhile;

        $tpl_r = "{$this->diretorio}{$tpl}";

        return !file_exists($tpl_r) ? false : $tpl_r;
    } // Fim do método _procurartemplate
} // Fim da classe Visao