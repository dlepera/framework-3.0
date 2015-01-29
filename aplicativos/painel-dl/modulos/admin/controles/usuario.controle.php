<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 15:33:07
 */

namespace Admin\Controle;

class Usuario extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \Admin\Modelo\Usuario(), 'admin', TXT_MODELO_USUARIO);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'                =>  FILTER_VALIDATE_INT,
                'info_grupo'        =>  array('filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'info_nome'         =>  FILTER_SANITIZE_STRING,
                'info_email'        =>  FILTER_VALIDATE_EMAIL,
                'info_telefone'     =>  FILTER_SANITIZE_STRING,
                'info_sexo'         =>  FILTER_SANITIZE_STRING,
                'info_login'        =>  /* array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_NULL_ON_FAILURE) */ FILTER_SANITIZE_STRING,
                'info_senha'        =>  FILTER_DEFAULT,
                'pref_idioma'       =>  array('filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'pref_tema'         =>  array('filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'pref_formato_data' =>  array('filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_NULL_ON_FAILURE),
                'pref_num_registros'=>  FILTER_SANITIZE_NUMBER_INT,
                'conf_reset'        =>  array('filter' => FILTER_SANITIZE_STRING, 'options' => array('min_range' => 0, 'max_range' => 1)),
                'conf_bloq'         =>  array('filter' => FILTER_SANITIZE_STRING, 'options' => array('min_range' => 0, 'max_range' => 1))
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
        $this->_listapadrao('usuario_id, usuario_info_nome, usuario_info_email, grupo_usuario_descr, usuario_conf_bloq+0 AS usuario_conf_bloq',
                'usuario_info_nome, usuario_info_sexo', null);

        # Visão
        $this->_carregarhtml('lista_usuarios');
        $this->visao->titulo = TXT_TITULO_USUARIOS;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => 'grupo_usuario_descr', 'texto' => TXT_LABEL_GRUPO),
            array('valor' => 'usuario_info_nome', 'texto' => TXT_LABEL_NOME),
            array('valor' => 'usuario_info_email', 'texto' => TXT_LABEL_EMAIL)
        ));
        $this->visao->_adparam('perm-bloquear?', \DL3::$aut_o->_verificarperm(get_called_class(), '_bloquear'));
    } // Fim do método _mostrarlista



    /**
     * Mostrar o formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     */
    protected function _mostrarform($id=null){
        $inc = $this->_formpadrao('usuario', 'usuarios/salvar', 'usuarios/salvar', 'admin/usuarios', $id);

        # Visão
        $this->_carregarhtml('form_usuario');
        $this->visao->titulo = $inc ? TXT_TITULO_NOVO_USUARIO : TXT_TITULO_EDITAR_USUARIO;

        $m_gu = new \Admin\Modelo\GrupoUsuario();
        $l_gu = $m_gu->_carregarselect('grupo_usuario_publicar = 1', false);

        $m_id = new \Desenvolvedor\Modelo\Idioma();
        $l_id = $m_id->_carregarselect('idioma_publicar = 1', false);

        $m_te = new \Desenvolvedor\Modelo\Tema();
        $l_te = $m_te->_carregarselect('tema_publicar = 1', false);

        $m_fd = new \Desenvolvedor\Modelo\FormatoData();
        $l_fd = $m_fd->_carregarselect('formato_data_publicar = 1', false);

        if( !$inc ):
            # Grupo de usuário
            $mgu = new \Admin\Modelo\GrupoUsuario($this->modelo->id);
            $this->visao->_adparam('grupo-descr', $mgu->descr);
        endif;

        # Parâmetros
        $this->visao->_adparam('grupos-usuarios', $l_gu);
        $this->visao->_adparam('idiomas', $l_id);
        $this->visao->_adparam('temas', $l_te);
        $this->visao->_adparam('formatos-data', $l_fd);
        $this->visao->_adparam('novo-idioma?', \DL3::$aut_o->_verificarperm('Desenvolvedor\Controle\Idioma', '_mostrarform'));
        $this->visao->_adparam('novo-tema?', \DL3::$aut_o->_verificarperm('Desenvolvedor\Controle\Tema', '_mostrarform'));
        $this->visao->_adparam('novo-grupo?', \DL3::$aut_o->_verificarperm('Admin\Controle\GrupoUsuario', '_mostrarform'));
        $this->visao->_adparam('msg-usuario-bloq?', !$inc && $this->modelo->conf_bloq);
        $this->visao->_adparam('usuario-logado?', $this->modelo->id == $_SESSION['usuario_id']);
    } // Fim do método _mostrarform



    /**
     * Minha conta
     * -------------------------------------------------------------------------
     *
     * Mostrar as informações do usuário logado
     */
    protected function _minhaconta(){
        return $this->_mostrarform($_SESSION['usuario_id']);
    } // Fim do método _minhaconta



    /**
     * Mostrar o formulário para alteração de senhas desse usuário
     * -------------------------------------------------------------------------
     */
    protected function _formalterarsenha(){
        $this->_formpadrao('senha', null, 'usuarios/alterar-senha-usuario', 'admin/usuarios/minha-conta', $_SESSION['usuario_id']);

        # Visão
        $this->_carregarhtml('form_trocar_senha');
        $this->visao->titulo = TXT_TITULO_TROCAR_MINHA_SENHA;
    } // Fim do método _formalterarsenha



    /**
     * Executar a ação de alterar a senha do usuário
     * -------------------------------------------------------------------------
     */
    protected function _alterarsenha(){
        $this->modelo->_selecionarID($_SESSION['usuario_id']);
        $this->modelo->_alterarsenha();
        return \Funcoes::_retornar(SUCESSO_USUARIO_ALTERARSENHA, 'msg-sucesso');
    } // Fim do método _alterarsenha



    /**
     * Bloquear ou desbloquear os usuários selecionados
     * -------------------------------------------------------------------------
     *
     * @param int $vlr - define se os usuário serão bloqueados ou desbloqueados
     */
    protected function _bloquear($vlr){
        $tid = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        if( is_null($tid) )
            throw new \Exception(MSG_PADRAO_NENHUM_REGISTRO_SELECIONADO, 1404);

        # Quantidade total de registros e quantidade excluída
        $qt = count($tid);
        $qe = 0;

        foreach( $tid as $id ):
            $this->modelo->_selecionarID($id);
            $this->modelo->conf_bloq = $vlr;
            $qe = $this->modelo->_salvar();
        endforeach;

        if( $vlr == 1 ):
            return \Funcoes::_retornar(
                !$qe ? ERRO_USUARIO_BLOQUEAR : sprintf($qe == 1 ? SUCESSO_USUARIO_BLOQUEAR_UM : SUCESSO_USUARIO_BLOQUEAR_VARIOS, $qe, $qt),
                !$qe ? 'msg-erro' : 'msg-sucesso'
            );
        else:
            return \Funcoes::_retornar(
                !$qe ? ERRO_USUARIO_DESBLOQUEAR : sprintf($qe == 1 ? SUCESSO_USUARIO_DESBLOQUEAR_UM : SUCESSO_USUARIO_DESBLOQUEAR_VARIOS, $qe, $qt),
                !$qe ? 'msg-erro' : 'msg-sucesso'
            );
        endif;
    } // Fim do método _bloquear
} // Fim do Controle Usuario