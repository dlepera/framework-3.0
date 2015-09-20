<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 07/01/2015 16:37:18
 */

namespace Desenvolvedor\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;
use \Admin\Modelo as AdminM;

class Modulo extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new DevM\Modulo(), 'desenvolvedor', TXT_MODELO_MODULO);
        $this->_carregar_post([
            'id'        => FILTER_VALIDATE_INT,
            'pai'       => FILTER_VALIDATE_INT,
            'nome'      => FILTER_SANITIZE_STRING,
            'descr'     => FILTER_DEFAULT,
            'menu'      => FILTER_VALIDATE_BOOLEAN,
            'link'      => FILTER_SANITIZE_STRING,
            'ordem'     => FILTER_VALIDATE_INT,
            'publicar'  => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




    /**
     * Mostrar a lista de registros
     */
    protected function _mostrarlista(){
        $this->_listapadrao('M.modulo_id AS '. TXT_LISTA_TITULO_ID .", CONCAT(M.modulo_nome, '<br/>', COALESCE(S.modulo_nome, '')) AS " . TXT_LISTA_TITULO_NOME . ','
            . ' M.modulo_link AS '. TXT_LISTA_TITULO_LINK . ','
            . " ( CASE M.modulo_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
	        'S.modulo_nome, M.modulo_nome', null);

        # Visão
	    $this->_carregarhtml('comum/visoes/form_filtro', null, 1);
	    $this->_carregarhtml('comum/visoes/lista_padrao', null, 2);
        $this->visao->titulo = TXT_PAGINA_TITULO_MODULOS;

        # Parâmetros
	    $this->visao->_adparam('dir-lista', 'desenvolvedor/modulos/');
	    $this->visao->_adparam('form-acao', 'desenvolvedor/modulos/desinstalar-modulo');
        $this->visao->_adparam('campos', [
            ['valor' => 'M.modulo_nome', 'texto' => TXT_ROTULO_NOME],
            ['valor' => 'M.modulo_link', 'texto' => TXT_ROTULO_LINK]
        ]);
    } // Fim do método _mostrarlista




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 *
	 * @param int $pk PK do registro a ser selecionado
	 */
    protected function _mostrarform($pk = null){
        $inc = $this->_formpadrao('modulo', 'modulos/instalar-modulo',  'modulos/atualizar-modulo', 'desenvolvedor/modulos', $pk);

        # Visão
        $this->_carregarhtml('comum/visoes/titulo_h2');
        $this->_carregarhtml('form_modulo');

        # Lista de módulos 'pai'
        $l_mp = $this->modelo->_listar('M.modulo_pai IS NULL'.
                (!$inc && $this->modelo->pai === 0 ? " AND M.modulo_id <> {$this->modelo->id}" : ''),
                'M.modulo_nome', 'M.modulo_id AS VALOR, M.modulo_nome AS TEXTO');

        # Parâmetros
        $this->visao->_adparam('modulos-pai', $l_mp);

        if( !$inc ){
	        # Funcionalidades
	        $m_mf = new DevM\ModuloFunc();
	        $l_mf = $m_mf->_carregarselect("func_modulo = {$this->modelo->id}", false);

	        if( $this->modelo->pai > 0 )
		        $this->_carregarhtml('lista_funcs');

	        $this->visao->_adparam('funcs', $l_mf);
        } // Fim if( !$inc )
    } // Fim do método _mostrarform




    /**
     *  Filtrar menu
     *
     * @param string  $bm Termo a ser buscado no cadastro de modulos
     * @param boolean $e  Define se a pesquisa retornada será escrita ou será retornada
     *
     * @return array
     */
    public function _filtromenu($bm, $e = true){
        $r = json_encode($this->modelo->_listarmenu("M.modulo_nome LIKE '%{$bm}%' OR M.modulo_descr LIKE '%{$bm}%'", 'M.modulo_nome', 'M.modulo_nome, M.modulo_descr'));

	    $e and print($r);
	    return $r;
    } // Fim do método _filtromenu
} // Fim do Controle Modulo