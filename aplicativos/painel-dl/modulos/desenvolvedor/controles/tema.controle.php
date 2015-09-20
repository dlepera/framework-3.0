<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/01/2015 13:30:33
 */

namespace Desenvolvedor\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;

class Tema extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new DevM\Tema(), 'desenvolvedor', TXT_MODELO_TEMA);
        $this->_carregar_post([
            'id' => FILTER_VALIDATE_INT,
            'descr' => FILTER_SANITIZE_STRING,
            'diretorio' => FILTER_SANITIZE_STRING,
            'padrao' => FILTER_VALIDATE_BOOLEAN,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




    /**
     * Mostrar a lista de temas
     */
    protected function _mostrarlista(){
        $this->_listapadrao('tema_id AS ' . TXT_LISTA_TITULO_ID . ", CONCAT(tema_descr, '<br/>', tema_diretorio) AS " . TXT_LISTA_TITULO_DESCR . ','
            . " ( CASE tema_padrao WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PADRAO . "',"
            . " ( CASE tema_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
            'tema_descr', null);

        # Visão
        $this->_carregarhtml('comum/visoes/form_filtro', null, 1);
        $this->_carregarhtml('comum/visoes/lista_padrao', null, 2);
        $this->visao->titulo = TXT_PAGINA_TITULO_TEMAS;

        # Parâmetros
        $this->visao->_adparam('dir-lista', 'desenvolvedor/temas/');
        $this->visao->_adparam('form-acao', 'desenvolvedor/temas/desinstalar-tema');
        $this->visao->_adparam('campos', [
            ['valor' => 'tema_descr', 'texto' => TXT_ROTULO_DESCRICAO],
            ['valor' => 'tema_diretorio', 'texto' => TXT_ROTULO_DIRETORIO]
        ]);
    } // Fim do método _mostrartemas




    /**
     * Formulário de inclusão e edição do tema
     *
     * @param int  $pk  PK do registro a ser selecionado
     * @param bool $mst Nome da página mestra a ser carregada
     */
    protected function _mostrarform($pk = null, $mst = null){
        $this->_formpadrao('tema', 'temas/instalar-tema', 'temas/atualizar-tema', 'desenvolvedor/temas', $pk);

        # Visão
        $this->_carregarhtml('comum/visoes/titulo_h2');
        $this->_carregarhtml('form_tema', $mst);
    } // Fim di método _mostrarform
} // Fim do Controle Tema