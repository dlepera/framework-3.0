<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 19:28:28
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class AssuntoContato extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\AssuntoContato(), 'website', TXT_MODELO_ASSUNTOCONTATO);
        $this->_carregar_post([
            'id' => FILTER_VALIDATE_INT,
            'descr' => FILTER_SANITIZE_STRING,
            'email' => FILTER_VALIDATE_EMAIL,
            'cor' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => EXPREG_COR_HEXA]],
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




    /**
     * Mostrar a lista de registros
     */
    protected function _mostrarlista(){
        $this->_listapadrao('assunto_contato_id AS ' . TXT_LISTA_TITULO_ID . ','
	        . " CONCAT('<span class=\"mostrar-cor\" style=\"background-color: ', assunto_contato_cor,'\" data-cor=\"', assunto_contato_cor, '\"></span>', assunto_contato_descr) AS " . TXT_LISTA_TITULO_DESCR . ','
            . " assunto_contato_email AS '" . TXT_LISTA_TITULO_EMAIL . "',"
            . " ( CASE assunto_contato_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
            'assunto_contato_descr', null);

        # Visão
	    $this->_carregarhtml('comum/visoes/form_filtro');
        $this->_carregarhtml('comum/visoes/lista_padrao');
        $this->visao->titulo = TXT_PAGINA_TITULO_ASSUNTOS_CONTATO;

        # Parâmetros
        $this->visao->_adparam('dir-lista', 'website/assuntos-contato/');
        $this->visao->_adparam('form-acao', 'website/assuntos-contato/remover-assunto');
        $this->visao->_adparam('campos', [
            ['valor' => 'assunto_contato_descr', 'texto' => TXT_ROTULO_DESCR],
            ['valor' => 'assunto_contato_email', 'texto' => TXT_ROTULO_EMAIL]
        ]);
    } // Fim do método _mostrarlista




	/**
	 * Mostrar formulário de inclusão e edição do registro
	 *
	 * @param int $pk PK do registro a ser selecionado
	 */
    protected function _mostrarform($pk = null){
        $this->_formpadrao('assunto', 'assuntos-contato/salvar', 'assuntos-contato/salvar', 'website/assuntos-contato', $pk);

        # Visão
        $this->_carregarhtml('comum/visoes/titulo_h2');
        $this->_carregarhtml('form_assunto');
    } // Fim do método _mostrarform
} // Fim do Controle AssuntoContato