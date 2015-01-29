<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 20:35:31
 */

namespace WebSite\Controle;

class DadoContato extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \WebSite\Modelo\DadoContato(), 'website', TXT_MODELO_DADOCONTATO);

        $post = filter_input_array(INPUT_POST, array(
            'id'        =>  FILTER_VALIDATE_INT,
            'tipo'      =>  FILTER_VALIDATE_INT,
            'descr'     =>  FILTER_SANITIZE_STRING,
            'publicar'  =>  array('filter' => FILTER_SANITIZE_STRING, 'options' => array('min_range' => 0, 'max_range' => 1))
        ));

        # Converter o encode
        \Funcoes::_converterencode($post, \DL3::$ap_charset);

        # Selecionar as informações atuais
        $this->modelo->_selecionarID($post['id']);

        \Funcoes::_vetor2objeto($post, $this->modelo);
    } // Fim do método __construct



    /**
     * Mostrar a lista de registros
     * -------------------------------------------------------------------------
     */
    protected function _mostrarlista(){
        $this->_listapadrao('dado_contato_id, dado_contato_descr, tipo_dado_descr, ( CASE dado_contato_publicar'
                . " WHEN 0 THEN 'Não'"
                . " WHEN 1 THEN 'Sim'"
                . ' END ) AS PUBLICADO', 'tipo_dado_descr, dado_contato_descr', null);

        # Visão
        $this->_carregarhtml('lista_dados');
        $this->visao->titulo = TXT_TITULO_DADOS_CONTATO;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => 'dado_contato_descr', 'texto' => TXT_LABEL_DESCR),
            array('valor' => 'tipo_dado_descr', 'texto' => TXT_LABEL_TIPO)
        ));
    } // Fim do método _mostrarlista



    /**
     * Mostrar formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     */
    protected function _mostrarform($id=null){
        $inc = $this->_formpadrao('dado', 'dados-para-contato/salvar', 'dados-para-contato/salvar', 'website/dados-para-contato', $id);

        # Visão
        $this->_carregarhtml('form_dado');
        $this->visao->titulo = $inc ? TXT_TITULO_NOVO_DADOCONTATO : TXT_TITULO_EDITAR_DADOCONTATO;

        $m_td = new \WebSite\Modelo\TipoDadoContato();
        $l_td = $m_td->_carregarselect('tipo_dado_publicar = 1', false);

        # Parâmetros
        $this->visao->_adparam('tipos', $l_td);
        $this->visao->_adparam('novo-tipo?', \DL3::$aut_o->_verificarperm('WebSite\Controle\TipoDadoContato', '_mostrarform'));
    } // Fim do método _mostrarform
} // Fim do Controle DadoContato