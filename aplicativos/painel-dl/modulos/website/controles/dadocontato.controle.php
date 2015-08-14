<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 20:35:31
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class DadoContato extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\DadoContato(), 'website', TXT_MODELO_DADOCONTATO);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ){
            $post = filter_input_array(INPUT_POST, [
	            'id' => FILTER_VALIDATE_INT,
	            'tipo' => FILTER_VALIDATE_INT,
	            'descr' => FILTER_SANITIZE_STRING,
	            'publicar' => FILTER_VALIDATE_BOOLEAN
            ]);

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarPK($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        } // Fim if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' )
    } // Fim do método __construct




	/**
	 * Mostrar a lista de registros
	 */
    protected function _mostrarlista(){
        $this->_listapadrao('dado_contato_id, dado_contato_descr, tipo_dado_descr,'
            . " ( CASE dado_contato_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS PUBLICADO",
            'tipo_dado_descr, dado_contato_descr', null);

        # Visão
        $this->_carregarhtml('lista_dados');
        $this->visao->titulo = TXT_PAGINA_TITULO_DADOS_CONTATO;

        # Parâmetros
        $this->visao->_adparam('dir-lista', 'website/dados-para-contato/');
        $this->visao->_adparam('campos', [
            ['valor' => 'dado_contato_descr', 'texto' => TXT_ROTULO_DESCR],
            ['valor' => 'tipo_dado_descr', 'texto' => TXT_ROTULO_TIPO]
        ]);
    } // Fim do método _mostrarlista




    /**
     * Mostrar formulário de inclusão e edição do registro
     *
     * @param int    $pk  Valor da PK do registro a ser selecionado
     * @param string $mst Nome da página mestra a ser carregada
     */
    protected function _mostrarform($pk = null, $mst = null){
        $inc = $this->_formpadrao('dado', 'dados-para-contato/salvar', 'dados-para-contato/salvar', 'website/dados-para-contato', $pk);

        # Visão
        $this->_carregarhtml('form_dado', $mst);
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO_DADOCONTATO : TXT_PAGINA_TITULO_EDITAR_DADOCONTATO;

        $m_td = new WebM\TipoDadoContato();
        $l_td = $m_td->_carregarselect('tipo_dado_publicar = 1', false);

        if( isset($this->modelo->id) ){
	        $m_td->_selecionarPK($this->modelo->tipo);
	        $this->visao->_adparam('macara', $m_td->mascara);
	        $this->visao->_adparam('expreg', $m_td->expreg);
        } // Fim if( isset($this->modelo->id) )

        # Parâmetros
        $this->visao->_adparam('tipos', $l_td);
        $this->visao->_adparam('novo-tipo?', \DL3::$aut_o->_verificarperm('WebSite\Controle\TipoDadoContato', '_mostrarform'));
    } // Fim do método _mostrarform
} // Fim do Controle DadoContato