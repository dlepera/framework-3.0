<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 22:17:04
 */

namespace Admin\Controle;

use \Geral\Controle as GeralC;
use \Admin\Modelo as AdminM;

class ConfigEmail extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new AdminM\ConfigEmail(), 'admin', TXT_MODELO_CONFIGEMAIL);
		$this->_carregar_post([
            'id' => FILTER_VALIDATE_INT,
            'titulo' => FILTER_SANITIZE_STRING,
            'host' => FILTER_SANITIZE_STRING,
            'porta' => FILTER_SANITIZE_NUMBER_INT,
            'autent' => FILTER_VALIDATE_BOOLEAN,
            'cripto' => FILTER_SANITIZE_STRING,
            'conta' => FILTER_SANITIZE_STRING,
            'senha' => FILTER_SANITIZE_STRING,
            'de_email' => FILTER_VALIDATE_EMAIL,
            'de_nome' => FILTER_SANITIZE_STRING,
            'responder_para' => FILTER_VALIDATE_EMAIL,
            'html' => FILTER_VALIDATE_BOOLEAN,
            'principal' => FILTER_VALIDATE_BOOLEAN,
            'debug' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




    /**
     * Mostrar a lista de registros
     */
    protected function _mostrarlista(){
        $this->_listapadrao('config_email_id AS ' . TXT_LISTA_TITULO_ID . ', config_email_titulo AS '. TXT_LISTA_TITULO . ','
	        . ' config_email_host AS ' . TXT_LISTA_TITULO_HOST . ','
            . " ( CASE config_email_principal WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim ' END ) AS '" . TXT_LISTA_TITULO_PRINCIPAL . "'",
	        'config_email_titulo', null);

        # Visão
	    $this->_carregarhtml('comum/visoes/form_filtro', null, 1);
        $this->_carregarhtml('lista_emails', null, 2);
        $this->visao->titulo = TXT_PAGINA_TITULO_CONFIGURACOES_ENVIO_EMAIL;

        # Parâmetros
	    $this->visao->_adparam('dir-lista', 'admin/envio-de-emails/');
        $this->visao->_adparam('form-acao', 'admin/envio-de-emails/excluir-configuracao');
        $this->visao->_adparam('link-inserir', sprintf(TXT_LINK_NOVA, $this->nome));
        $this->visao->_adparam('campos', [
            ['valor' => 'config_email_titulo', 'texto' => TXT_ROTULO_TITULO],
            ['valor' => 'config_email_host', 'texto' => TXT_ROTULO_HOST]
        ]);
        $this->visao->_adparam('perm-testar?', \DL3::$aut_o->_verificarperm(get_called_class(), '_testar'));
    } // Fim do método _mostrarlista




	/**
	 * Mostrar formulário de inclusão e edição do registro
	 *
	 * @param int $pk PK do registro a ser selecionado
	 */
    protected function _mostrarform($pk = null){
        $inc = $this->_formpadrao('email', 'envio-de-emails/salvar', 'envio-de-emails/salvar', 'admin/envio-de-emails', $pk);

        # Visão
        $this->_carregarhtml('comum/visoes/titulo_h2');
        $this->_carregarhtml('form_email');
        $this->visao->titulo = $inc ? sprintf(TXT_PAGINA_TITULO_CADASTRAR_NOVA, $this->nome) : sprintf(TXT_PAGINA_TITULO_EDITAR_ESSA, $this->nome);

        # Parâmetros
        $this->visao->_adparam('perm-testar?', \DL3::$aut_o->_verificarperm(get_called_class(), '_testar'));
    } // Fim do método _mostrarform




    /**
     * Testar uma determinada configuração de envio de e-mail]
     *
     * @param int $pk ID da configuração a ser testada
     *
     * @return mixed
     * @throws \Exception
     */
    protected function _testar($pk){
        if( !class_exists('Email') )
            throw new \Exception(sprintf(ERRO_PADRAO_CLASSE_NAO_ENCONTRADA, 'Email'), 1500);

	    $this->modelo->_selecionarPK($pk);

        $oe = new \Email();
        $te = $oe->_enviar(
	        session_status() === PHP_SESSION_ACTIVE ? $_SESSION['usuario_info_email'] : $_SESSION['usuario_info_email'],
	        TXT_EMAIL_ASSUNTO_TESTE,
	        sprintf(TXT_EMAIL_CONTEUDO_TESTE, $this->modelo->titulo, $this->modelo->host, $this->modelo->porta, filter_input(INPUT_SERVER, 'HTTP_HOST')),
	        $pk
        );

		$oe->_gravarlog(__CLASS__, $this->modelo->bd_tabela, $this->modelo->id);

        if( !$te )
            throw new \Exception(sprintf(ERRO_CONFIGEMAIL_TESTAR, $oe->_exibirlog()), 1500);

        \Funcoes::_retornar(SUCESSO_CONFIGEMAIL_TESTAR, 'msg-sucesso');
    } // Fim do método _testar
} // Fim do Controle ConfigEmail