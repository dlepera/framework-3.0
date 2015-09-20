<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 15:14:07
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class TipoDadoContato extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\TipoDadoContato(), 'website', TXT_MODELO_TIPODADOCONTATO);
        $this->_carregar_post([
            'id' => FILTER_VALIDATE_INT,
            'descr' => FILTER_SANITIZE_STRING,
            'rede_social' => FILTER_VALIDATE_BOOLEAN,
            'mascara' => FILTER_DEFAULT,
            'expreg' => FILTER_DEFAULT,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




	/**
	 * Mostrar a lista de registros
	 */
    protected function _mostrarlista(){
        $this->_listapadrao('tipo_dado_id AS ' . TXT_LISTA_TITULO_ID . ','
	        . " CONCAT('<img src=\"" . \DL3::$dir_relativo . "', tipo_dado_icone, '\" class=\"tbl-imagem\" alt/>') AS " . TXT_LISTA_TITULO_ICONE . ','
            . ' tipo_dado_descr AS ' . TXT_LISTA_TITULO_DESCR . ','
            . " ( CASE tipo_dado_rede_social WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) '" . TXT_LISTA_TITULO_REDE_SOCIAL . "',"
            . " ( CASE tipo_dado_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
            'tipo_dado_rede_social, tipo_dado_descr', null);

        # Visão
        $this->_carregarhtml('comum/visoes/form_filtro');
        $this->_carregarhtml('comum/visoes/lista_padrao');
        $this->visao->titulo = TXT_PAGINA_TITULO_TIPOS_DADO_CONTATO;

        # Parâmetros
        $this->visao->_adparam('dir-lista', 'website/tipos-de-dados/');
        $this->visao->_adparam('form-acao', 'website/tipos-de-dados/remover-tipo-de-dado');
        $this->visao->_adparam('campos', [
            ['valor' => 'tipo_dado_descr', 'texto' => TXT_ROTULO_DESCR]
        ]);
    } // Fim do método _mostrarlista




	/**
	 * Mostrar formulário de inclusão e edição do registro
	 *
	 * @param int    $pk  PK do registro a ser selecionado
	 * @param string $mst Nome da página mestra a ser carregada
	 */
    protected function _mostrarform($pk = null, $mst = null){
        $this->_formpadrao('tipo-dado', 'tipos-de-dados/salvar', 'tipos-de-dados/salvar', 'website/tipos-de-dados', $pk);

        # Visão
        $this->_carregarhtml('comum/visoes/titulo_h2');
        $this->_carregarhtml('form_tipo_dado', $mst);
    } // Fim do método _mostrarform




	/**
	 * Obter as opções avançadas desse tipo de dado
	 */
    public function _opcoesavancadas(){
        $this->modelo->_selecionarPK(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));

        echo json_encode([
            'mascara'   =>  $this->modelo->mascara,
            'expreg'    =>  $this->modelo->expreg
        ]);
    } // Fim do método _opcoesavancadas
} // Fim do Controle TipoDadoContato