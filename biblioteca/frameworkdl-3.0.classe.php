<?php

/**
 * @Autor   : Diego Lepera
 * @E-mail  : d_lepera@hotmail.com
 * @Projeto : FrameworkDL 3.0
 * @Data    : 04/01/2015 22:26:00
 */

/*
 * TAREFA: melhorar a exibição de páginas de erros
 */

/**
 * Auto carregar classes
 *
 * @param string $c Nome da classe a ser carregada
 */
function carregar_classe($c){
    list($m, $t, $n) = explode('\\', $c);

    $md = preg_replace('~^\-~', '', preg_replace_callback('~[A-Z]+~', function($m){
        return '-'. strtolower($m[0]);
    }, $m));

    $tl = strtolower($t);
    $nl = strtolower($n);

    # Diretório da classe
    !file_exists($dc = sprintf(DL3::DIR_MODULOS, DL3_APLICATIVO, $md) . "{$tl}s/")
        and $dc = sprintf(DL3::DIR_MODULOS, DL3_APLICATIVO, str_replace('-', '', $md)) . "{$tl}s/";

    # Gerar o nome do arquivo
    $na = "{$dc}{$nl}.{$tl}.php";

    if( !file_exists($na) ):
        echo '<h1>Desculpe, não consegui executar a ação que você pediu! :(</h1>',
            '<p>Tem certeza que o caminho digitado aqui em cima está correto?</p>',
            '<details>',
            '  <summary>Detalhes</summary>',
            '  <p>',
            '    <b>Módulo: </b>', $md, '<br/>',
            '    <b>', $t,': </b>', $n, '<br/>',
            '    <b>Arquivo:</b> ', $na,
            '  </p>',
            '</details>';
    endif;

    require_once $na;
} // Fim da função __autoload

spl_autoload_register('carregar_classe');

/**
 * 'Get' e 'Set' padrão
 *
 * @param object $o Objeto a ser reflexionado
 * @param string $p Nome da propriedade a ser obtida ou alterada
 */
function m_get($o, $p){
    $g = "_{$p}";

    if( property_exists($o, $p) && method_exists($o, $g) )
        return $o->{$g}();
} // Fim da função m_get



/**
 * 'Get' e 'Set' padrão
 *
 * @param object $o Objeto a ser reflexionado
 * @param string $p Nome da propriedade a ser obtida ou alterada
 * @param mixed $v  Valor a ser atribuído à propriedade
 */
function m_set($o,$p,$v){
    $s = "_{$p}";

    if( property_exists($o, $p) && method_exists($o, $s) )
        return $o->{$s}($v);
} // Fim da função m_set



/**
 * FrameworkDL3.0
 * Classe que fará o processamento do sistema
 *
 * - Configurações de bancos de dados são definidas como private por segurança
 *
 * - Configurações gerais serão definidas como estáticas para facilitar o acesso
 */

class FrameworkDL3{
    # Diretórios da aplicação
    # Alguns deles não deverão ser alterados, portanto são definidos como
    # constantes
    const DIR_CONFIG = 'config/', DIR_IDIOMAS = 'web/idiomas/', DIR_BIBL = 'biblioteca/', DIR_ROTAS = 'web/rotas/',
            DIR_MODULOS = 'aplicativos/%s/modulos/%s/', DIR_TEMAS = 'web/temas/', DIR_VISOES = 'visoes/', DIR_AUTO = '_auto/',
            DIR_CONTROLES = 'controles/', DIR_MODELOS = 'modelos/';

    private $dir_modulo; // Armazenar o diretório do módulo atual

    # Armazenar o módulo atual e disponibilizar para acesso externo
    public static $modulo_atual;

    # Arquivo de configuração
    private $a_config = ['diretorio' => '', 'arquivo' => ''];

    # Prefixos de extensão de arquivos
    const PRFIX_CONFIG = 'conf', PRFIX_ROTAS = 'rota', PRFIX_IDIOMAS = 'idioma', PRFIX_MODELOS = 'modelo',
            PRFIX_BIBL = 'classe', PRFIX_TEMAS = 'tema', PRFIX_CONTROLES = 'controle';

    # Configurações da aplicação
    private $ap_raiz, $ap_nome, $ap_modulo, $ap_idioma = 'pt_BR', $ap_rotas = [], $ap_timezone = 'America/Sao_Paulo';
    public static $ap_titulo, $ap_home, $ap_content_type = 'text/html', $ap_charset = 'utf-8', $ap_http,
            $ap_base_html = '/', $ap_versao_jquery = '2.1.4', $ap_favicon = 'favicon.ico', $ap_versao = '1.0';

    # Diretórios usados para montar as páginas HTML
    public static $dir_temas = 'web/temas/', $dir_js = 'web/js/', $dir_imgs = 'web/imgs/', $dir_relativo = '';

    # Configurações do banco de dados
    private $bd_ativar = false, $bd_driver = 'mysql', $bd_host = 'localhost', $bd_porta = 3306,
            $bd_usuario = 'root', $bd_senha = 'root', $bd_base, $bd_encoding = 'utf8';
    public static $bd_dh_formato_completo = 'Y-m-d H:i:s', $bd_dh_formato_data = 'Y-m-d', $bd_dh_formato_hora = 'H:i:s';

    public static $bd_conex;

    # Configurações de autenticação
    private $aut_ativar = false, $aut_sessao = DL3_APLICATIVO, $aut_prefixo = 'dl';
    public static $aut_o;

    # Configurações de plugins
    public static $plugin_formulario_tema = 'painel-dl', $plugin_paginacao_tema = 'painel-dl', $plugin_galeria_tema;

    # Armazenar informações temporárias
    public static $tmp_buffer_resposta;



    public function __construct(){
        # Carregar o arquivo de configuração
        $this->_carregarconfig();

        # Alterar o cabeçalho da solicitação
        header('Content-type: '. self::$ap_content_type .'; charset='. self::$ap_charset);

        # Carregar os arquivos da biblioteca
        $this->_carregarbibl();

        # Carregar as rotas
        $this->_carregarrotas();

        # Alterar o diretório atual
        self::$ap_base_html = ( $this->ap_raiz != '/' ? "/{$this->ap_raiz}" : '/' ) . ($h = trim(self::$ap_home, '/')) . ( empty($h) ? '' : '/' );
        chdir(($this->ap_raiz != '/' ? $this->ap_raiz : DL3_ABSPATH). self::$ap_home);


	    self::$ap_http = strtolower(
		    preg_replace('~\/[0-9\.]+$~', '', filter_input(INPUT_SERVER, 'SERVER_PROTOCOL'))) .
		    filter_input(INPUT_SERVER, 'HTTP_PROTOCOL') .'://'.
		    filter_input(INPUT_SERVER, 'HTTP_HOST') .
		    \DL3::$ap_base_html;

        # Definir o timezone
        date_default_timezone_set($this->ap_timezone);

        # Obter o diretório relativo
        $this->_caminhorelativo();

	    # Conectar ao banco de dados se for necessário
	    $this->_conectarbd();

        # Se o sistema requer autenticação, iniciar a classe de autenticação e
        # utilizar preferências pós login
        if( $this->aut_ativar ){
	        self::$aut_o = new \Autenticacao($this->aut_prefixo, $this->aut_sessao);

	        # Alterar a configuração do idioma
	        self::$aut_o->_verificarlogin(false) and $this->_ap_idioma($_SESSION['idioma_sigla']);
        } // Fim if( $this->aut_ativar )

        # Carregar o pacote de idiomas
        $this->_carregaridioma();
	    /*
	     * TAREFA: Verificar o funcionamento do locale
	     */
	    setlocale(LC_ALL, $this->ap_idioma);

        # Carregamento automático de controles e modelos
        $this->_carregarauto();
        $this->_carregarauto(null, true);

        # Carregar módulo atual
        $this->_carregarmodulo();

        # Carregar o conteúdo
        $this->_carregarconteudo();
    } // Fim do método __construct

    public function __destruct(){
        # Exibir a mensagem ao usuário
        !empty(self::$tmp_buffer_resposta) and print(json_encode(self::$tmp_buffer_resposta));
    } // Fim do método __destruct



    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function __get($n){ return m_get($this, $n); } // Fim do método __get
    public function __set($n, $v){ return m_set($this, $n, $v); } // Fim do método __set

    public function _ap_raiz($v = null){
        return $this->ap_raiz = trim(filter_var(!isset($v) ? $this->ap_raiz : $v, FILTER_SANITIZE_STRING), '/') .'/';
    } // Fim do método _ap_raiz

    public function _ap_nome($v = null){
        return $this->ap_nome = filter_var(!isset($v) ? $this->ap_nome : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _ap_nome

    public function _ap_modulo($v = null){
        return $this->ap_modulo = self::$modulo_atual = filter_var(!isset($v) ? $this->ap_modulo : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _ap_modulo

    public function _ap_idioma($v = null){
        if( !isset($v) ) return (string)$this->ap_idioma;

        # Validar o idioma informado
        if( strlen($v) != 5 || strpos($v, '_') != 2 )
            throw new Exception('<p>O formato do idioma informado é inválido!<br/>'
                    . 'Por favor, inclua um idioma no formato seguinte: aa_BB, onde <em>aa</em> é a sigla do idioma e <em>BB</em>'
                    . ' é a sigla do país de origem.</p>'
                    . '<p>Ex: pt_BR (Português do Brasil), en_US (Inglês EUA).</p>');

        return $this->ap_idioma = (string)$v;
    } // Fim do método _ap_modulo

    public function _aut_ativar($v = null){
        return $this->aut_ativar = filter_var(!isset($v) ? $this->aut_ativar : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _aut_ativar

    public function _aut_prefixo($v = null){
        return $this->aut_prefixo = strtolower(filter_var(!isset($v) ? $this->aut_prefixo : $v, FILTER_SANITIZE_STRING));
    } // Fim do método _aut_prefixo

	public function _aut_sessao($v = null){
		return $this->aut_sessao = strtolower(filter_var(!isset($v) ? $this->aut_sessao : $v, FILTER_SANITIZE_STRING));
	} // Fim do método _aut_sessao

    public function _bd_ativar($v = null){
        return $this->bd_ativar = filter_var(!isset($v) ? $this->bd_ativar : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _bd_ativar

    public function _bd_driver($v = null){
        return $this->bd_driver = filter_var(!isset($v) ? $this->bd_driver : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _bd_driver

    public function _bd_host($v = null){
        return $this->bd_host = filter_var(!isset($v) ? $this->bd_host : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _bd_host

    public function _bd_porta($v = null){
        return $this->bd_porta = filter_var(!isset($v) ? $this->bd_porta : $v, FILTER_VALIDATE_INT);
    } // Fim do método _bd_porta

    public function _bd_usuario($v = null){
        return $this->bd_usuario = filter_var(!isset($v) ? $this->bd_usuario : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _bd_usuario

    public function _bd_senha($v = null){
        return $this->bd_senha = filter_var(!isset($v) ? $this->bd_senha : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _bd_senha

    public function _bd_base($v = null){
        return $this->bd_base = filter_var(!isset($v) ? $this->bd_base : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _bd_base




    /**
     * Verificar se o ambiente solicitado foi criado
     *
     * É verificado se o ambiente foi informado e se o diretório existe dentro do diretório que contém os arquivos de
     * configuração (definido por self::DIR_CONFIG) foi criado o diretório do ambiente
     *
     * @throws Exception
     */
    private function _validarambiente(){
        if( empty(DL3_AMBIENTE) )
            throw new Exception('Por favor, informe qual ambiente será utilizado!', 1500);

        $dc = self::DIR_CONFIG . DL3_AMBIENTE;
        $nc = count($this->_filtrarprefixo($dc, self::PRFIX_CONFIG));

        if( !is_dir($dc) || !$nc )
            throw new Exception('<p>O ambiente <b>'. DL3_AMBIENTE .'</b> não foi encontrado ou não contém arquivos de configuração válidos!<br/>Por favor crie o ambiente dentro do diretório <b>'. self::DIR_CONFIG .'</b>.</p>', 1404);

        $this->a_config['diretorio'] = $dc;
    } // Fim do método _validarambiente




    /**
     * Verificar o arquivo de configuração
     *
     * É verificado se o arquivo de configuração solicitado existe
     */
    private function _validarconfig(){
        empty($this->a_config['diretorio']) and $this->_validarambiente();

        if( empty(DL3_APLICATIVO) )
            throw new Exception('Por favor, informe qual arquivo de configuração será utilizado!', 1500);

        $ac = DL3_APLICATIVO .'.'. self::PRFIX_CONFIG .'.php';

        if( !file_exists($ac_c = $this->a_config['diretorio'] .'/'. $ac) )
            throw new Exception("<p>O arquivo de configuração <b>{$ac_c}</b> não foi encontrado!<br/>Por favor, crie-o ambiente dentro do diretório <b>{$ac}</b>.</p>", 1404);

        $this->a_config['arquivo'] = $ac;
    } // Fim do método _validarconfig




	/**
	 * Carregar o arquivo de configuração
	 *
	 * Verifica e carrega o arquivo de configuração e sobrepõe a configuração padrão da classe
	 */
    private function _carregarconfig(){
        $this->_validarconfig();

        require_once implode('/', $this->a_config);

        $dv = get_defined_vars();

        foreach( $dv as $c => $v ){
	        if( property_exists(get_class(), $c) ){
		        $obj_c = new ReflectionClass($this);
		        $obj_p = $obj_c->getProperty($c);

		        if( $obj_p->isPrivate() ){
			        $obj_m = $obj_c->getMethod("_{$c}");
			        $obj_m->invoke($this, $v);
		        } else $obj_p->setValue($this, $v);
	        } // Fim if( property_exists(get_class(), $c) )
        } // Fim foreach
    } // Fim do método _carregarconfig




	/**
	 * Carregar as classes da biblioteca
	 *
	 * Carregar todos os arquivos contidos no diretório de bibliotecas.
	 * São classes que poderão ser utilizadas a qualquer momento por qualquer classe, página, aplicação, etc.
	 *
	 * Obs.: O diretório de bibliotecas pode ser definido por self::DIR_BIBL
	 */
    public function _carregarbibl(){
        $ab = $this->_filtrarprefixo(self::DIR_BIBL, self::PRFIX_BIBL);

        foreach( $ab as $a )
            require_once self::DIR_BIBL . $a;
    } // Fim do método _carregarbibl



    /**
     * Carregar o pacote de idioma de acordo com o módulo informado
     *
     * @param string $m - nome do módulo onde será procurado o pacote de idiomas. Quando vazio será carregado o pacote de idiomas padrão do sistema
     */
    public function _carregaridioma($m = ''){
        $di = (empty($m) ? '' : $this->dir_modulo) . self::DIR_IDIOMAS . $this->ap_idioma;
        $ai = $this->_filtrarprefixo($di, self::PRFIX_IDIOMAS);

        foreach( $ai as $a )
            require_once "{$di}/{$a}";
    } // Fim do método _carregaridioma




	/**
	 * Carregar rotas de acordo com o módulo informado
	 *
	 * @param string $m Nome do módulo onde serão procurados os arquivos de rotas. Quando vazio serão carregados os
	 *                  arquivos de rota do sistema
	 */
    public function _carregarrotas($m = ''){
        $dr = (empty($m) ? '' : $this->dir_modulo) . self::DIR_ROTAS;
        $ar = $this->_filtrarprefixo($dr, self::PRFIX_ROTAS);

        foreach( $ar as $a )
            require_once "{$dr}/{$a}";

        // $this->ap_rotas += $rotas;
        isset($rotas) and $this->ap_rotas = array_merge($this->ap_rotas, $rotas);
    } // Fim do método _carregarrotas




	/**
	 * Conectar ao banco de dados
	 *
	 * Conectar ao banco de dados via PDO e disponibilizar a conexão para
	 * que outras classes a utilizem
	 */
    private function _conectarbd(){
        if( $this->bd_ativar ){
	        try{
		        self::$bd_conex = new PDODL("{$this->bd_driver}:host={$this->bd_host};port={$this->bd_porta};dbname={$this->bd_base};charset={$this->bd_encoding}", $this->bd_usuario, $this->bd_senha);
		        self::$bd_conex->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	        } catch( PDOException $e ){
		        var_dump($e);
	        } // Fim try catch
        } // Fim if( $this->bd_ativar )
    } // Fim do método _conectarbd




	/**
	 * Identificar o módulo atual
	 *
	 * O módulo atual será informado na URL logo após a 'home' do aplicativo
	 * Ex: framewrok3.0/admin/ => módulo 'admin'
	 */
    private function _identificarmodulo(){
        $r_url = filter_input(INPUT_SERVER, 'REDIRECT_URL');
        $h_url = trim($this->ap_raiz . self::$ap_home, '/');

        if( !isset($r_url) || trim($r_url, '/') == $h_url ){
	        $this->_ap_modulo('home');

	        return;
        } // Fim if( !isset($r_url) || trim($r_url, '/') == $h_url )

        if( !preg_match("~/{$h_url}/?([a-z\-_0-9]+)~", $r_url, $modulo) )
            throw new Exception('Não foi possível identificar o módulo atual!', 1500);

        $this->_ap_modulo(end($modulo));
    } // Fim do método _identificarmodulo




	/**
	 * Carregar módulo
	 *
	 * Serão carregados o pacote de idiomas e as rotas do módulo atual
	 */
    private function _carregarmodulo(){
        empty($this->modulo) and $this->_identificarmodulo();

        $this->dir_modulo = sprintf(self::DIR_MODULOS, $this->ap_nome, $this->ap_modulo);

        # Carregar as rotas desse módulo
        $this->_carregarrotas($this->ap_modulo);

        # Carregar o pacote de idiomas desse módulo
        $this->_carregaridioma($this->ap_modulo);

        # Carregamento automático
        $this->_carregarauto($this->ap_modulo);
    } // Fim do método _carregarmodulo




	/**
	 * Carregar o conteúdo
	 *
	 * Carregar o conteúdo a ser exibido de acordo com a rota identificada através da URL
	 */
    private function _carregarconteudo(){
        $obj_r = new Roteamento($this->ap_rotas, $this->dir_modulo, $this->ap_modulo);
        $obj_c = $obj_r->_obterrota();

        $obj_c !== false and $obj_c->_executar();
    } // Fim do método _carregarconteudo




	/**
	 * Carregar automaticamente os controles e modelos que estiverem dentro do diretório _auto (que pode ser definido
	 * através de self::DIR_AUTO)
	 *
	 * @param string $m Módulo a ser considerado para o carregamento
	 * @param bool   $a Define se o diretório _auto a ser carregado é do aplicativo e não de um módulo
	 */
    private function _carregarauto($m = '', $a = false){
        $a ? $da = 'aplicativos/'. DL3_APLICATIVO . '/' . self::DIR_AUTO
        : $da = (empty($m) ? '' : $this->dir_modulo) . self::DIR_AUTO;

        if( !is_dir($da) ) return;

        # Lista de diretórios a serem inclusos automaticamente
        $dir = [
            self::PRFIX_CONTROLES => $da . self::DIR_CONTROLES,
            self::PRFIX_MODELOS => $da . self::DIR_MODELOS,
            self::PRFIX_IDIOMAS => $da . self::DIR_IDIOMAS,
            self::PRFIX_ROTAS => $da . self::DIR_ROTAS
        ];

        foreach( $dir as $ch => $d ){
	        $ch == self::PRFIX_IDIOMAS and $d = "{$d}{$this->ap_idioma}/";

	        if( !is_dir($d) ) continue;

	        $as = $this->_filtrarprefixo($d, $ch);

	        foreach( $as as $a )
		        require_once "{$d}{$a}";
        } // Fim foreach
    } // Fim do método _carregarauto




	/**
	 * Obter todos os arquivos de um diretório de acordo com o seu prefixo
	 *
	 * @param string $d Diretório a ser escaneado
	 * @param string $p Prefixo de filtro dos arquivos
	 *
	 * @return array    Vetor contendo apenas os arquivos que correspondem ao prefixo informado
	 * @throws Exception
	 */
    private function _filtrarprefixo($d, $p){
        if( !is_dir($d) )
            throw new Exception("O diretório <b>{$d}</b> não foi encontrado!", 1404);

        return preg_grep(
                "~\.{$p}\.php$~",
                preg_grep(
                    '~^[^\.]~',
                    scandir($d)
                )
            );
    } // Fim do método _filtrarprefixo




	/**
	 * @param string $d Parte do diretório do tema a ser carregado
	 *
	 * @return string   Trecho HTML responsável pela inclusão dos arquvios CSS
	 */
	public static function _carregartema($d){
        $dcss = self::$dir_temas . trim($d, '/') .'/css/';
        $acss = preg_grep('~^[^\.]~', scandir($dcss));
        $tema = '';

        foreach( $acss as $a ){
	        $css = "{$dcss}{$a}";

	        is_file("./{$css}") and
	            $tema .= '<link rel="stylesheet" media="all" href="'. self::$dir_relativo . $css .'"/>';
        } // Fim foreach;

        return $tema;
    } // Fim do método _carregartema



    public function _caminhorelativo(){
        return self::$dir_relativo = (!empty(self::$ap_home) ? '../' : './') . str_repeat('../', count(explode('/', self::$ap_home))-1);
    } // Fim do método _caminho relativo
} // Fim da classe FrameworkDL3

# Simular um alias para a classe FrameworkDL3
class DL3 extends FrameworkDL3{}