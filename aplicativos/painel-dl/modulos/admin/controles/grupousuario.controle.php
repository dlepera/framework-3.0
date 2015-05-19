<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 09:58:33
 */

namespace Admin\Controle;

class GrupoUsuario extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \Admin\Modelo\GrupoUsuario(), 'admin', TXT_MODELO_GRUPOUSUARIO);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        =>  FILTER_VALIDATE_INT,
                'descr'     =>  FILTER_SANITIZE_STRING,
                'funcs'     =>  array('filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY),
                'publicar'  =>  FILTER_VALIDATE_BOOLEAN
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
        $this->_listapadrao('grupo_usuario_id, grupo_usuario_descr, ( CASE grupo_usuario_publicar'
                . " WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim'"
                . " END ) AS PUBLICADO", 'grupo_usuario_descr', null);

        # Visão
        $this->_carregarhtml('lista_grupos');
        $this->visao->titulo = TXT_PAGINA_TITULO_GRUPOS_USUARIOS;

        # Parâmetro
        $this->visao->_adparam('campos', array(
            array('valor' => 'grupo_usuario_descr', 'texto' => TXT_ROTULO_DESCR)
        ));
    } // Fim do método _mostrarlista



    /**
     * Mostrar o formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     * @param bool $tr - define se serão carregados o topo e rodapá da visão
     */
    protected function _mostrarform($id=null,$tr=true){
        $inc = $this->_formpadrao('grupo', 'grupos-de-usuarios/salvar', 'grupos-de-usuarios/salvar', 'admin/grupos-de-usuarios',  $id);

        # Visão
        $this->_carregarhtml('form_grupo', is_null($tr) ? true : $tr);
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO_GRUPOUSUARIO : TXT_PAGINA_TITULO_EDITAR_GRUPOUSUARIO;

        # Sub-módulos
        $mm = new \Desenvolvedor\Modelo\Modulo();
        $ls = $mm->_listar('M.modulo_publicar = 1 AND M.modulo_pai IS NOT NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome, M.modulo_descr, M.modulo_link');

        # Funcionalidades
        $mf = new \Desenvolvedor\Modelo\ModuloFunc();
        $lf = $mf->_listar(null, 'func_modulo, func_modulo_descr', 'func_modulo, func_modulo_id, func_modulo_descr');

        # Parâmetros
        $this->visao->_adparam('sub-modulos', $ls);
        $this->visao->_adparam('funcs', $lf);

        # Usuário que está logado não pode alterar as permissões do seu próprio
        # grupo, exceção apenas para o root
        $this->visao->_adparam('mostrar-perms?', $inc || ($this->modelo->id != $_SESSION['usuario_info_grupo'] || $_SESSION['usuario_id'] == -1));

        if( !$inc ):
            # Membros do grupo
            $mu = new \Admin\Modelo\Usuario();
            $lu = $mu->_listar("usuario_info_grupo = {$this->modelo->id}", 'usuario_info_nome', 'usuario_info_nome');

            # Parâmetros
            $this->visao->_adparam('membros', $lu);
        endif;
    } // Fim do método _mostrarform
} // Fim do Controle GrupoUsuario