<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 22:17:04
 */

namespace Admin\Controle;

class ConfigEmail extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \Admin\Modelo\ConfigEmail(), 'admin', TXT_MODELO_CONFIGEMAIL);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'                =>  FILTER_VALIDATE_INT,
                'titulo'            =>  FILTER_SANITIZE_STRING,
                'host'              =>  FILTER_SANITIZE_STRING,
                'porta'             =>  FILTER_SANITIZE_NUMBER_INT,
                'autent'            =>  array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1)),
                'cripto'            =>  FILTER_SANITIZE_STRING,
                'conta'             =>  FILTER_SANITIZE_STRING,
                'senha'             =>  FILTER_SANITIZE_STRING,
                'de_email'          =>  FILTER_VALIDATE_EMAIL,
                'de_nome'           =>  FILTER_SANITIZE_STRING,
                'responder_para'    =>  FILTER_VALIDATE_EMAIL,
                'html'              =>  array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1)),
                'principal'         =>  array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarID($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     * Mostrar a lista de registros
     * -------------------------------------------------------------------------
     */
    protected function _mostrarlista(){
        $this->_listapadrao('config_email_id, config_email_titulo, config_email_host, ( CASE config_email_principal'
                . " WHEN 0 THEN 'Não'"
                . " WHEN 1 THEN 'Sim'"
                . " END ) AS PRINCIPAL", 'config_email_titulo', null);

        # Visão
        $this->_carregarhtml('lista_emails');
        $this->visao->titulo = TXT_TITULO_CONFIGURACOES_ENVIO_EMAIL;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => 'config_email_titulo', 'texto' => TXT_LABEL_TITULO),
            array('valor' => 'config_email_host', 'texto' => TXT_LABEL_HOST)
        ));
        $this->visao->_adparam('perm-testar?', \DL3::$aut_o->_verificarperm(get_called_class(), '_testar'));
    } // Fim do método _mostrarlista



    /**
     * Mostrar formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     */
    protected function _mostrarform($id=null){
        $inc = $this->_formpadrao('email', 'envio-de-emails/salvar', 'envio-de-emails/salvar', 'admin/envio-de-emails', $id);

        # Visão
        $this->_carregarhtml('form_email');
        $this->visao->titulo = $inc ? TXT_TITULO_NOVO_CONFIGEMAIL : TXT_TITULO_EDITAR_CONFIGEMAIL;

        # Parâmetros
        $this->visao->_adparam('perm-testar?', \DL3::$aut_o->_verificarperm(get_called_class(), '_testar'));
    } // Fim do método _mostrarform



    /**
     * Testar uma determinada configuração de envio de e-mail
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID da configuração a ser testada
     */
    protected function _testar($id){
        if( !class_exists('Email') )
            throw new \Exception(sprintf(ERRO_PADRAO_CLASSE_NAO_ENCONTRADA, 'Email'), 1500);

        $oe = new \Email();
        $te = $oe->_enviar(session_status() === PHP_SESSION_ACTIVE ? $_SESSION['usuario_info_email'] : $_SESSION['usuario_info_email'], TXT_EMAIL_ASSUNTO_TESTE, TXT_EMAIL_CONTEUDO_TESTE, $id);

        if( !$te )
            throw new \Exception(sprintf(ERRO_CONFIGEMAIL_TESTAR, $oe->_exibirlog()), 1500);

        return \Funcoes::_retornar(SUCESSO_CONFIGEMAIL_TESTAR, 'msg-sucesso');
    } // Fim do método _testar
} // Fim do Controle ConfigEmail