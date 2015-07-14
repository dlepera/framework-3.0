<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/01/2015 16:05:12
 */

namespace Login\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;
use \Admin\Modelo as AdminM;
use \Login\Modelo as LoginM;

class Login extends GeralC\Principal{
    public function __construct() {
        parent::__construct(null, 'login', null);
    } // Fim do método __construct



    /**
     * Mostrar o formulário de login
     */
    public function _mostrarform(){
        $this->_formpadrao('login', 'fazer-login', null, filter_input(INPUT_GET, 'url'));

        $this->_carregarhtml('form_login', 'login');
        $this->visao->titulo = TXT_PAGINA_TITULO_LOGIN;

        # Selecionar o tema padrão
        $mtm = new DevM\Tema();
        $ltm = $mtm->_listar('tema_padrao', null, 'tema_diretorio', 0, 1, 0);

        /* Parâmetros */
        $this->visao->_adparam('tema', $ltm['tema_diretorio']);
    } // Fim do método _mostrarform



    /**
     * Mostrar o formulário para recuperação da senha
     */
    public function _mostraresqueci(){
        $this->_formpadrao('login', 'recuperar-senha', null);

        $this->_carregarhtml('form_esqueci', 'login');
        $this->visao->titulo = TXT_PAGINA_TITULO_ESQUECI_MINHA_SENHA;

        # Selecionar o tema padrão
        $mtm = new DevM\Tema();
	    $ltm = $mtm->_listar('tema_padrao', null, 'tema_diretorio', 0, 1, 0);

        /* Parâmetros */
        $this->visao->_adparam('tema', $ltm['tema_diretorio']);
    } // Fim do método _mostraresqueci




	/**
	 * Recuperar senha
	 *
	 * Enviar um e-mail ao usuário com um link para resetar a senha
	 */
    public function _recuperarsenha(){
        $le = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);

        $mu = new AdminM\Usuario();
        $lu = $mu->_listar("usuario_info_login = '{$le}' OR usuario_info_email = '{$le}'", null, 'usuario_id, usuario_info_nome, usuario_info_email', 0, 1, 0);

        if( $lu === false )
            throw new \Exception(ERRO_LOGIN_RECUPERARSENHA_USUARIO_NAO_LOCALIZADO, 1404);

        $mr = new LoginM\Recuperacao();

        # Verificar se o usuário solicitou recentemente a alteração da senha,
        # pois em caso positivo será usada a mesma hash
        $lr = $mr->_listar("recuperacao_usuario = {$lu['usuario_id']} AND recuperacao_status = 'E'", null, 'recuperacao_id', 0, 1, 0);
		// var_dump($lr);
        if( is_null($lr) ){
	        $mr->usuario    = $lu['usuario_id'];
	        $mr->hash       = date(\DL3::$bd_dh_formato_completo);
	        $mr->_salvar();
        } else $mr->_selecionarPK($lr['recuperacao_id']);

        # Link de recuperação da senha
        $lk = strtolower(
                preg_replace('~\/[0-9\.]+$~', '', filter_input(INPUT_SERVER, 'SERVER_PROTOCOL'))) .
                filter_input(INPUT_SERVER, 'HTTP_PROTOCOL') .'://'.
                filter_input(INPUT_SERVER, 'HTTP_HOST') .
                \DL3::$ap_base_html ."login/recuperar-senha/{$mr->hash}";

        # Enviar o e-mail
        $obj_e = new \Email();
        $obj_e->_enviar($lu['usuario_info_email'], TXT_EMAIL_ASSUNTO_RECUPERACAO_SENHA, sprintf(MSG_EMAIL_CORPO_RECUPERAR_SENHA, $lu['usuario_info_nome'], $lk, $lk));
        $obj_e->_gravarlog(__CLASS__, 'dl_painel_usuarios_recuperacoes', $mr->id);

        return \Funcoes::_retornar(sprintf(SUCESSO_LOGIN_RECUPERARSENHA, $lu['usuario_info_email']), 'msg-sucesso');
    } // Fim do método _recuperarsenha



	/**
	 * Mostrar formulário para reset de senha
	 *
	 * @param string $h Hash MD5 da recuperação
	 *
	 * @throws \Exception
	 */
    public function _mostrarresetsenha($h){
        $hs = filter_var($h, FILTER_DEFAULT);

        # Selecionar a recuperação
        $mr = new LoginM\Recuperacao();
        $lr = $mr->_listar("recuperacao_hash = '{$hs}' AND recuperacao_status = 'E'", null, 'recuperacao_id, usuario_info_nome', 0, 1, 0);

        if( $lr === false )
            throw new \Exception(ERRO_LOGIN_MOSTRARRESETSENHA, 1404);

        $this->_formpadrao('login', 'resetar-senha-usuario', null, \DL3::$ap_base_html);

        # Visão
        $this->_carregarhtml('form_reset', 'login');
        $this->visao->titulo = TXT_PAGINA_TITULO_MOSTRARRESETSENHA;

	    # Selecionar o tema padrão
	    $mtm = new DevM\Tema();
	    $ltm = $mtm->_listar('tema_padrao', null, 'tema_diretorio', 0, 1, 0);

	    # Parâmetros
	    $this->visao->_adparam('tema', $ltm['tema_diretorio']);
        $this->visao->_adparam('id', $lr['recuperacao_id']);
        $this->visao->_adparam('nome-usuario', $lr['usuario_info_nome']);
    } // Fim do método _mostrarresetsenha



    /**
     * Realizar o reset da senha
     */
    public function _resetarsenha(){
        # Tratar os dados
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
	    $sn = filter_input(INPUT_POST, 'senha_nova');
	    $sc = filter_input(INPUT_POST, 'senha_nova_conf');

        $mr = new LoginM\Recuperacao($id);
        $mu = new AdminM\Usuario($mr->usuario);

        # Alterar a senha do usuário
        $mu->_alterarsenha($sn, $sc, null, true);

        # Alterar o status
        $mr->status = 'R';
        $mr->_salvar();

        return \Funcoes::_retornar(SUCESSO_LOGIN_RESETARSENHA, 'msg-sucesso');
    } // Fim do método _resetarsenha



    /**
     * Realizar o login no sistema
     */
    public function _fazerlogin(){
        $u = filter_input(INPUT_POST, 'login');
        $s = filter_input(INPUT_POST, 'senha');

        return \DL3::$aut_o->_fazerlogin($u,$s) ?
            \Funcoes::_retornar(SUCESSO_LOGIN_FAZERLOGIN, 'msg-sucesso')
        : \Funcoes::_retornar(ERRO_LOGIN_FAZERLOGIN, 'msg-erro');
    } // Fim do método _fazerlogin



    /**
     * Realozar o logout do sistema
     */
    public function _fazerlogout(){
        return \DL3::$aut_o->_fazerlogout() ?
            \Funcoes::_retornar(SUCESSO_LOGIN_FAZERLOGOUT, 'msg-sucesso')
        : \Funcoes::_retornar(ERRO_LOGIN_FAZERLOGOUT, 'msg-erro');
    } // Fim do método _fazerlogout
} // Fim do Controle Login