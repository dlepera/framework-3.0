<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 09:58:33
 */

namespace Admin\Controle;

use \Geral\Controle as GeralC;
use \Admin\Modelo as AdminM;
use \Desenvolvedor\Modelo as DevM;

class GrupoUsuario extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new AdminM\GrupoUsuario(), 'admin', TXT_MODELO_GRUPOUSUARIO);
		$this->_carregar_post([
            'id'        => FILTER_VALIDATE_INT,
            'descr'     => FILTER_SANITIZE_STRING,
            'funcs'     => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'publicar'  => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




    /**
     * Mostrar a lista de registros
     */
    protected function _mostrarlista(){
        $this->_listapadrao('grupo_usuario_id AS ' . TXT_LISTA_TITULO_ID . ', grupo_usuario_descr AS ' . TXT_LISTA_TITULO_DESCR . ','
            . " ( CASE grupo_usuario_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
	        'grupo_usuario_descr', null);

        # Visão
	    $this->_carregarhtml('comum/visoes/form_filtro', null, 1);
	    $this->_carregarhtml('comum/visoes/lista_padrao', null, 2);
        $this->visao->titulo = TXT_PAGINA_TITULO_GRUPOS_USUARIOS;

        # Parâmetro
	    $this->visao->_adparam('dir-lista', 'admin/grupos-de-usuarios/');
        $this->visao->_adparam('form-acao', 'admin/grupos-de-usuarios/excluir-grupo');
        $this->visao->_adparam('campos',[
            ['valor' => 'grupo_usuario_descr', 'texto' => TXT_ROTULO_DESCR]
        ]);
    } // Fim do método _mostrarlista




    /**
     * Mostrar o formulário de inclusão e edição do registro
     *
     * @param int  $pk  ID do registro a ser selecionado
     * @param bool $mst Nome da página mestra a ser carregada
     */
    protected function _mostrarform($pk = null, $mst = null){
        $inc = $this->_formpadrao('grupo', 'grupos-de-usuarios/salvar', 'grupos-de-usuarios/salvar', 'admin/grupos-de-usuarios',  $pk);

        # Visão
        $this->_carregarhtml('comum/visoes/titulo_h2');
        $this->_carregarhtml('form_grupo', $mst);

        # Sub-módulos
        $mm = new DevM\Modulo();
        $ls = $mm->_listar('M.modulo_publicar = 1 AND M.modulo_pai IS NOT NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome, M.modulo_descr, M.modulo_link');

        # Funcionalidades
        $mf = new DevM\ModuloFunc();
        $lf = $mf->_listar(null, 'func_modulo, func_modulo_descr', 'func_modulo, func_modulo_id, func_modulo_descr');

        # Parâmetros
        $this->visao->_adparam('sub-modulos', $ls);
        $this->visao->_adparam('funcs', $lf);

        # Usuário que está logado não pode alterar as permissões do seu próprio grupo, exceção apenas para o root
        $this->visao->_adparam('mostrar-perms?', $inc || ($this->modelo->id != $_SESSION['usuario_info_grupo'] || $_SESSION['usuario_id'] == -1));

        if( !$inc ){
	        # Membros do grupo
	        $mu = new AdminM\Usuario();
	        $lu = $mu->_listar("usuario_info_grupo = {$this->modelo->id}", 'usuario_info_nome', 'usuario_info_nome');

	        # Parâmetros
	        $this->visao->_adparam('membros', $lu);
        } // Fim if( !$inc )
    } // Fim do método _mostrarform
} // Fim do Controle GrupoUsuario