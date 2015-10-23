<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 17:12:57
 */

namespace Contato\Controle;

use \Geral\Controle as GeralM;
use \Contato\Modelo as ContatoM;

class ContatoSite extends GeralM\WebSite{
    public function __construct(){
        parent::__construct(new ContatoM\ContatoSite(), 'contato', TXT_MODELO_CONTATOSITE);
        $this->_carregar_post([
            'nome'      =>  FILTER_SANITIZE_STRING,
            'email'     =>  FILTER_VALIDATE_EMAIL,
            'telefone'  =>  FILTER_SANITIZE_STRING,
            'assunto'   =>  FILTER_VALIDATE_INT,
            'mensagem'  =>  FILTER_DEFAULT
        ]);
    } // Fim do método __construct




	/**
	 * Mostrar o formulário de contato
	 */
    public function _mostrarform(){
        $this->_formpadrao('contato', 'enviar', null, 'contato', null);

        # Visões
        $this->_carregarhtml('formulario');
        $this->visao->titulo = TXT_PAGINA_TITULO_CONTATO;

        # Selecionar os assuntos de contatos
        $ma = new ContatoM\AssuntoContato();
        $la = $ma->_carregarselect('assunto_contato_publicar = 1', false);

        # Parâmetros
        $this->visao->_adparam('mostrar-assunto?', (bool)$la);
        $this->visao->_adparam('assuntos', $la);
    } // Fim do método _mostrarform




	/**
	 * Salvar e enviar o registro de contato
	 */
    public function _enviar(){
        $this->_salvar();

        # Enviar por e-mail
        if( class_exists('Email') ){
	        if( $this->modelo->assunto > 0 ){
		        $ma = new ContatoM\AssuntoContato();
		        $la = end($ma->_listar("assunto_contato_id = {$this->modelo->assunto}", null, 'assunto_contato_descr, assunto_contato_email'));
		        $as = $la['assunto_contato_descr'];
		        $pa = $la['assunto_contato_email'];
	        } else {
		        $as = MSG_NAO_INFORMADO;
		        $pa = 'd_lepera@hotmail.com';
	        } // Fim if( class_exists('Email') )

	        $a = sprintf(TXT_EMAIL_ASSUNTO_CONTATOSITE, ($h = filter_input(INPUT_SERVER, 'HTTP_HOST')), $as);
	        $c = sprintf(TXT_EMAIL_CONTEUDO_CONTATOSITE, $h, $this->modelo->nome, $this->modelo->email, $this->modelo->telefone, $as, nl2br($this->modelo->mensagem));

	        $om = new \Email();
	        $e = $om->_enviar($pa, $a, $c);
	        $om->_gravarlog(__CLASS__, $this->modelo->bd_tabela, $this->modelo->id);

	        if( !$e )
		        throw new \Exception(sprintf(ERRO_CONTATOSITE_ENVIO_EMAIL, $om->_exibirlog()), 1500);
        } // if( class_exists('Email') )

        \Funcoes::_retornar(SUCESSO_CONTATOSITE_ENVIADO, '__msg-sucesso');
    } // Fim do método _enviar
} // Fim do Controle ContatoSite