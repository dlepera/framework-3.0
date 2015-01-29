<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 17:12:57
 */

namespace Contato\Controle;

class ContatoSite extends \Geral\Controle\WebSite{
    public function __construct(){
        parent::__construct(new \Contato\Modelo\ContatoSite(), 'contato', TXT_MODELO_CONTATOSITE);

        # Tratar dados do _POST
        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'nome'      =>  FILTER_SANITIZE_STRING,
                'email'     =>  FILTER_SANITIZE_EMAIL,
                'telefone'  =>  FILTER_SANITIZE_STRING,
                'assunto'   =>  array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'mensagem'  =>  FILTER_DEFAULT
            ));

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     * Mostrar o formulário de contato
     * -------------------------------------------------------------------------
     */
    public function _mostrarform(){
        $this->_carregarhtml('formulario');
        $this->visao->titulo = TXT_TITULO_CONTATO;

        # Selecionar os assuntos de contatos
        $ma = new \Contato\Modelo\AssuntoContato();
        $la = $ma->_carregarselect('assunto_contato_publicar = 1', false);

        # Parâmetros
        $this->visao->_adparam('mostrar-assunto?', (bool)$la);
        $this->visao->_adparam('assuntos', $la);
    } // Fim do método _mostrarform



    /**
     * Salvar e enviar o registro de contato
     * -------------------------------------------------------------------------
     */
    public function _enviar(){
        $this->_salvar();

        # Enviar por e-mail
        if( class_exists('Email') ):
            if( !empty($this->modelo->assunto) ):
                $ma = new Contato\Modelo\AssuntoContato();
                $la = end($ma->_listar("assunto_contato_id = {$this->modelo->assunto}", null, 'assunto_contato_descr, assunto_contato_email'));
                $as = $la['assunto_contato_descr'];
                $pa = $la['assunto_contato_email'];
            else:
                $as = MSG_NAO_INFORMADO;
                $pa = 'd_lepera@hotmail.com';
            endif;

            $a = sprintf(TXT_EMAIL_ASSUNTO_CONTATOSITE, ($h = filter_input(INPUT_SERVER, 'HTTP_HOST')), $as);
            $c = sprintf(TXT_EMAIL_CONTEUDO_CONTATOSITE, $h,
                    $this->modelo->nome, $this->modelo->email, $this->modelo->telefone,
                    $as, nl2br($this->modelo->mensagem));

            $om = new \Email();
            $e  = $om->_enviar($pa, $a, $c);
            $om->_gravarlog(__CLASS__, $this->modelo->bd_tabela, $this->modelo->id);

            if( !$e )
                throw new \Exception(sprintf(ERRO_CONTATOSITE_ENVIO_EMAIL, $om->_exibirlog()), 1500);
        endif;

        return \Funcoes::_retornar(SUCESSO_CONTATOSITE_ENVIADO, 'msg-sucesso');
    } // Fim do método _enviar
} // Fim do Controle ContatoSite