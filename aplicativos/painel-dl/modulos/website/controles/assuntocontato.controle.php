<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 19:28:28
 */

namespace WebSite\Controle;

class AssuntoContato extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \WebSite\Modelo\AssuntoContato(), 'website', TXT_MODELO_ASSUNTOCONTATO);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        =>  FILTER_VALIDATE_INT,
                'descr'     =>  FILTER_SANITIZE_STRING,
                'email'     =>  FILTER_VALIDATE_EMAIL,
                'cor'       =>  FILTER_DEFAULT,
                'publicar'  =>  array('filter' => FILTER_SANITIZE_STRING, 'options' => array('min_range' => 0, 'max_range' => 1))
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
        $this->_listapadrao('assunto_contato_id, assunto_contato_descr, assunto_contato_email, assunto_contato_cor, ( CASE assunto_contato_publicar'
                . " WHEN 0 THEN 'Não'"
                . " WHEN 1 THEN 'Sim'"
                . ' END ) AS PUBLICADO', 'assunto_contato_descr', null);

        # Visão
        $this->_carregarhtml('lista_assuntos');
        $this->visao->titulo = TXT_TITULO_ASSUNTOS_CONTATO;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => 'assunto_contato_descr', 'texto' => TXT_ROTULO_DESCR),
            array('valor' => 'assunto_contato_email', 'texto' => TXT_ROTULO_EMAIL)
        ));
    } // Fim do método _mostrarlista



    /**
     * Mostrar formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     */
    protected function _mostrarform($id=null){
        $inc = $this->_formpadrao('assunto', 'assuntos-contato/salvar', 'assuntos-contato/salvar', 'website/assuntos-contato', $id);

        # Visão
        $this->_carregarhtml('form_assunto');
        $this->visao->titulo = $inc ? TXT_TITULO_NOVO_ASSUNTO : TXT_TITULO_EDITAR_ASSUNTO;
    } // Fim do método _mostrarform
} // Fim do Controle AssuntoContato