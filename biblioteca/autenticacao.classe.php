<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/01/2015 15:13:37
 */

class Autenticacao{
    protected $sessao_prefixo, $sessao_nome = 'PHPSESSID', $sessao_id = 11;
    protected $usuario;

    # Configurações do usuário root
    private $root = array(
        'usuario_id'            =>  -1,
        'usuario_info_grupo'    =>  1,
        'usuario_info_nome'     =>  'Super Admin',
        'usuario_info_email'    =>  'd_lepera@hotmail.com',
        'usuario_info_telefone' =>  '',
        'usuario_info_sexo'     =>  'M',
        'usuario_info_login'    =>  'root',
        'usuario_info_senha'    =>  '64eedda5e60fdb52fc29aa903ce9002a', /* MD5 x 2 */
        'idioma_sigla'          =>  'pt_BR',
        'tema_diretorio'        =>  'painel-dl/',
        'formato_data_completo' =>  'd/m/Y H:i',
        'formato_data_data'     =>  'd/m/Y',
        'formato_data_hora'     =>  'H:i',
        'usuario_pref_num_registros'    => 2,
        'usuario_conf_reset'    =>  0,
        'usuario_conf_bloq'     =>  0
    );

    # Informações dos usuários a serem carregados no login
    private $usr_infos = array(
        'usuario_id', 'usuario_info_grupo', 'usuario_info_nome', 'usuario_info_email', 'usuario_info_telefone',
        'usuario_info_login', 'idioma_sigla', 'tema_diretorio', 'formato_data_completo', 'formato_data_data',
        'formato_data_hora', 'usuario_pref_num_registros', 'usuario_conf_reset', 'usuario_conf_bloq'
    );

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _sessao_prefixo($v=null){
        return is_null($v) ? (string)$this->sessao_prefixo
        : $this->sessao_prefixo = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _sessao_prefixo

    public function _sessao_nome($v=null){
        return is_null($v) ? (string)$this->sessao_nome
        : $this->sessao_nome = (string)'sess-'. filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _sessao_nome

    public function _sessao_id($v=null){
        return is_null($v) ? (string)$this->sessao_id
        : $this->sessao_id = (string)"{$this->sessao_prefixo}-". md5(filter_var($v, FILTER_SANITIZE_STRING));
    } // Fim do método _sessao_id

    public function _form_login($v=null){
        return is_null($v) ? (string)$this->form_login
        : $this->form_login = (string)trim(filter_var($v, FILTER_SANITIZE_STRING), '/');
    } // Fim do método _form_login



    public function __construct($sp, $sn, $fl){
        # Configurações da sessão
        $this->_sessao_prefixo($sp);
        $this->_sessao_nome($sn);
        $this->_form_login($fl);

        # Verificar o status do login
        $this->_verificarlogin( !preg_match('~/?login~', DL3_URL) );

        # Iniciar o modelo de usuário
        $this->usuario = new \Admin\Modelo\Usuario();
    } // Fim do método __construct



    /**
     * Verificar pelo status da sessão se o login foi realizado
     * -------------------------------------------------------------------------
     * @param bool $r - define se a página será redirecionada ou não
     *
     * @return bool - retorna true se a sessão foi iniciada ou false caso não
     */
    public function _verificarlogin($r=true){
        # Status da sessão
        $s = phpversion() < '5.4' ? (bool)session_id() : session_status() === PHP_SESSION_ACTIVE;

        # Obter valor do cookie
        $c = filter_input(INPUT_COOKIE, $this->sessao_nome, FILTER_SANITIZE_STRING);

        # Verificar se o arquivo de armazenamento existe
        $a = file_exists(session_save_path() .'/sess_'. $c);

        if( (!$s && empty($c)) || !$a ):
            if( $r ): goto redir;
            else: return false; endif;
        elseif( !$r && $s ):
            return true;
        endif;

        # Iniciar a sessão
        session_name($this->sessao_nome);
        session_id($c);
        session_start();

        return true;

        redir:
            $this->_formlogin();
            return false;
    } // Fim do método _verificarlogin



    /**
     * Mostrar o formulário de login
     * -------------------------------------------------------------------------
     */
    public function _formlogin(){
        echo file_get_contents(strtolower(
                preg_replace('~\/[0-9\.]+$~', '', filter_input(INPUT_SERVER, 'SERVER_PROTOCOL'))) .
                filter_input(INPUT_SERVER, 'HTTP_PROTOCOL') .'://'.
                filter_input(INPUT_SERVER, 'HTTP_HOST') .
                \DL3::$ap_base_html .'login?url='. filter_input(INPUT_SERVER, 'REDIRECT_URL')); die();
    } // Fim do método _formlogin



    /**
     * Realizar o login no sistema
     * -------------------------------------------------------------------------
     *
     * @param string $u - nome de usuário
     * @param string $s - senha do usuário
     */
    public function _fazerlogin($u,$s){
        # Login do Super Admin ou login de usuário do sistema
        if( $u == $this->root['usuario_info_login'] && md5(md5($s)) == $this->root['usuario_info_senha'] ):
            $i = $this->usr_infos;
            $d = [];

            array_walk($this->root, function($vr,$ch) use ($i,&$d){
                if( in_array($ch, $i) ) $d[$ch] = $vr;
            });
        else:
            $d = $this->usuario->_fazerlogin($u,$s,implode(',', $this->usr_infos));
        endif;

        $this->_sessao_id($d['usuario_id']);

        # Configurar a sessão
        session_name($this->sessao_nome);
        session_id($this->sessao_id);
        session_start();

        # Carregar os dados na sessão
        foreach( $d as $ch => $vr )
            $_SESSION[$ch] = $vr;

        return /* $this->_verificarlogin(false) */ true;
    } // Fim do método _fazerlogin



    /**
     * Realizar o logout
     * -------------------------------------------------------------------------
     *
     * Remover todos os dados de sessão e sair do sistema
     */
    public function _fazerlogout(){
        if( !$this->_verificarlogin(false) )
            return true;

        # Remover o cookie com o ID da sessão
        setcookie($this->sessao_nome, '', time()-360, '/');

        # Destruir a sessão
        if( !session_destroy() ) return false;

        return true;
    } // Fim do método _fazerlogout



    /**
     * Verificar o permissionamento do usuário logado
     * -------------------------------------------------------------------------
     *
     * @params string $m - nome da classe que está sendo executada
     * @params string $a - nome da ação que será executada
     */
    public function _verificarperm($m,$a){
        # Permitir para o Super Admin
        if( $_SESSION['usuario_id'] == -1 ) return true;

        $mgu = new \Admin\Modelo\GrupoUsuario($_SESSION['usuario_info_grupo']);
        return (bool)$mgu->_verificarperm($m,$a);
    } // Fim do método _verificarperm
} // Fim da classe Autenticacao