<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/01/2015 18:20:35
 */

namespace Desenvolvedor\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;

class Idioma extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new DevM\Idioma(), 'desenvolvedor', TXT_MODELO_IDIOMA);
        $this->_carregar_post([
            'id'        => FILTER_VALIDATE_INT,
            'descr'     => FILTER_SANITIZE_STRING,
            'sigla'     => FILTER_SANITIZE_STRING,
            'publicar'  => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




    /**
     * Mostrar a lista de registros
     */
    protected function _mostrarlista(){
        $this->_listapadrao('idioma_id AS '. TXT_LISTA_TITULO_ID .', idioma_descr AS '. TXT_LISTA_TITULO_DESCR .', idioma_sigla AS '. TXT_LISTA_TITULO_SIGLA .','
            . " ( CASE idioma_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '". TXT_LISTA_TITULO_PUBLICADO ."'",
            'idioma_descr', null);

        # Visão
	    $this->_carregarhtml('comum/visoes/form_filtro', null, 1);
	    $this->_carregarhtml('comum/visoes/lista_padrao', null, 2);
        $this->visao->titulo = TXT_PAGINA_TITULO_IDIOMAS;

        # Parâmetros
        $this->visao->_adparam('dir-lista', 'desenvolvedor/idiomas/');
        $this->visao->_adparam('form-acao', 'desenvolvedor/idiomas/remover-idioma');
        $this->visao->_adparam('campos', [
            ['valor' => 'idioma_descr', 'texto' => TXT_ROTULO_DESCRICAO],
            ['valor' => 'idioma_sigla', 'texto' => TXT_ROTULO_SIGLA]
        ]);
    } // Fim do método _mostrarlista




	/**
	 * Mostrar o formulário de inclusão e edição
	 *
	 * @param int    $pk  PK do registro a ser selecionado
	 * @param string $mst Nome da página mestra a ser carregada
	 */
    protected function _mostrarform($pk = null, $mst = 'padrao'){
        $this->_formpadrao('idioma', 'idiomas/salvar', 'idiomas/salvar', 'desenvolvedor/idiomas', $pk);

        # Visão
        $this->_carregarhtml('comum/visoes/titulo_h2');
        $this->_carregarhtml('form_idioma', $mst);
    } // Fim do método _mostrarform
} // Fim do Controle Tema