<?php

/*
 * DL-Sites @ 2013
 * Projeto	: Framework MVC
 * Programador e idealizador: Diego Lepera
 * Descrição: Framework para facilitar o trabalho de criar sites e sistemas web
 * 				armazenando ações comuns para todos os sites
 */

require_once 'phpmailer/class.phpmailer.php';
require_once 'phpmailer/class.smtp.php';

class Email{
    # Instâncias utilizadas
    private $obj_pm, $mod_ce, $mod_le;

    public function __construct(){
        # Instanciar o PHP-Mailer
        $this->obj_pm = new PHPMailer();
        $this->obj_pm->SetLanguage('br');

        # Instanciar o modelo ConfigEmail
        $this->mod_ce = new \Geral\Modelo\ConfigEmail();

        # Instanciar o modelo LogEmail
        $this->mod_le = new \Geral\Modelo\LogEmail();
    } // Fim do método mágico __construct



    /**
     * Carregar as configurações
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID da configuração a ser carregada. Se não for informado
     *  será carregada a configuração flagada como 'Principal'
     */
    public function _carregarconf($id=null){
        # Selecionar as configurações principais ou definida pelo ID
        is_null($id) ? $this->mod_ce->_selecionarprincipal() : $this->mod_ce->_selecionarPK($id);

        # Definir servidor como SMTP
        $this->obj_pm->IsSMTP();

        # Dados do servidor
        $this->obj_pm->Host         = $this->mod_ce->host;
        $this->obj_pm->Port         = $this->mod_ce->porta;
        $this->obj_pm->SMTPAuth     = (bool)$this->mod_ce->autent;
        $this->obj_pm->SMTPSecure   = $this->mod_ce->cripto;
        $this->obj_pm->Username     = $this->mod_ce->conta;
        $this->obj_pm->Password     = $this->mod_ce->senha;
        $this->obj_pm->From         = $this->mod_ce->de_email;
        $this->obj_pm->FromName     = $this->mod_ce->de_nome;
        $this->obj_pm->AddReplyTo($this->mod_ce->responder_para);
        $this->obj_pm->IsHTML((bool)$this->mod_ce->html);
    } // Fim do método _carregarconf



    /**
     * Enviar o e-mail
     * -------------------------------------------------------------------------
     *
     * @param string $dest - email ou emails do destinatário separados por ; (ponto e vírgula)
     * @param string $assunto - assunto do e-mail
     * @param string $corpo - corpo do e-mail
     * @param int $config - ID da configuração a ser carregada
     *
     * @return boolean - false em caso de falha e true em caso de sucesso
     */
    public function _enviar($dest, $assunto, $corpo, $config = null){
        # Carregar as configurações
        $this->_carregarconf($config);

        # Corpo do e-mail
        $this->obj_pm->Subject = utf8_decode($assunto);
        $this->obj_pm->Body    = utf8_decode($corpo);

        # Incluir os destinatários
        $dests = explode(';', $dest);

        foreach( $dests as $d )
            $this->obj_pm->AddAddress($d);

        # Enviar o e-mail
        if( !$this->obj_pm->Send() ):
            $this->mod_le->mensagem   = $this->obj_pm->ErrorInfo;
            $this->mod_le->status     = 'F';
            return false;
        endif;

        $this->mod_le->status = 'E';

        return true;
    } // Fim do método _enviar



    /**
     * Gravar o log da tentativa/envio do e-mail
     * -------------------------------------------------------------------------
     *
     * @param string $classe - nome da classe que fez o envio do e-mail
     * @param string $tabela - nome da tabela que contém o registro referenciado
     * pelo envio do e-mail
     * @param int $idreg - ID do registro, contido em $tabela que referencia esse envio de
     * e-mail
     */
    public function _gravarlog($classe = null, $tabela = null, $idreg = null){
        # Informações do Log
        $this->mod_le->config         = $this->mod_ce->id;
        $this->mod_le->ip             = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        $this->mod_le->classe         = $classe;
        $this->mod_le->tabela         = $tabela;
        $this->mod_le->idreg          = $idreg;

        return $this->mod_le->_salvar();
    } // Fim do método _gravarlog




    /**
     * Exibir o log caso haja
     * -------------------------------------------------------------------------
     */
    public function _exibirlog(){
        return (
            "<p style='text-align: left !important;'><b>Data:</b> {$this->mod_le->data_criacao}<br>"
            . "<b>Status:</b> {$this->mod_le->status}<br>"
            . "<b>Mensagem:</b> {$this->mod_le->mensagem}</p>"
        );
    } // Fim do método _exibirlog
} // Fim da classe Email