<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 15:33:07
 */

/*
 * TAREFA: melhorar o algorítmo de salvamento da foto de perfil
 */

namespace Admin\Controle;

use \Geral\Controle as GeralC;
use \Admin\Modelo as AdminM;
use \Desenvolvedor\Modelo as DevM;

class Usuario extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new AdminM\Usuario(), 'admin', TXT_MODELO_USUARIO);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, [
                'id'                =>  FILTER_VALIDATE_INT,
                'info_grupo'        =>  FILTER_VALIDATE_INT,
                'info_nome'         =>  FILTER_SANITIZE_STRING,
                'info_email'        =>  FILTER_VALIDATE_EMAIL,
                'info_telefone'     =>  FILTER_SANITIZE_STRING,
                'info_sexo'         =>  FILTER_SANITIZE_STRING,
                'info_login'        =>  FILTER_SANITIZE_STRING,
                'info_senha'        =>  FILTER_DEFAULT,
                'pref_idioma'       =>  FILTER_VALIDATE_INT,
                'pref_tema'         =>  FILTER_VALIDATE_INT,
                'pref_formato_data' =>  FILTER_VALIDATE_INT,
                'pref_num_registros'=>  FILTER_SANITIZE_NUMBER_INT,
                'pref_exibir_id'    =>  FILTER_VALIDATE_BOOLEAN,
                'pref_filtro_menu'  =>  FILTER_VALIDATE_BOOLEAN,
                'conf_reset'        =>  FILTER_VALIDATE_BOOLEAN,
                'conf_bloq'         =>  FILTER_VALIDATE_BOOLEAN
            ]);

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarPK($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     * Mostrar a lista de registros
     */
    protected function _mostrarlista(){
        $this->_listapadrao('usuario_id, usuario_info_nome, usuario_info_email, grupo_usuario_descr, usuario_conf_bloq',
                'usuario_info_nome, usuario_info_sexo', null);

        # Visão
        $this->_carregarhtml('lista_usuarios');
        $this->visao->titulo = TXT_PAGINA_TITULO_USUARIOS;

        # Parâmetros
        $this->visao->_adparam('campos', [
            ['valor' => 'grupo_usuario_descr', 'texto' => TXT_ROTULO_GRUPO],
            ['valor' => 'usuario_info_nome', 'texto' => TXT_ROTULO_NOME],
            ['valor' => 'usuario_info_email', 'texto' => TXT_ROTULO_EMAIL]
        ]);
        $this->visao->_adparam('perm-bloquear?', \DL3::$aut_o->_verificarperm(get_called_class(), '_bloquear'));
    } // Fim do método _mostrarlista




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 *
	 * @param int    $pk PK do registro a ser selecionado
	 * @param string $rd URL para onde será redirecionado depois do salvamento do registro
	 */
    protected function _mostrarform($pk = null, $rd = 'admin/usuarios'){
        $inc = $this->_formpadrao('usuario', 'usuarios/salvar', 'usuarios/salvar', $rd, $pk);

        # Visão
        $this->_carregarhtml('form_usuario');
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO_USUARIO : TXT_PAGINA_TITULO_EDITAR_USUARIO;

        $m_gu = new AdminM\GrupoUsuario();
        $l_gu = $m_gu->_carregarselect('grupo_usuario_publicar', false);

        $m_id = new DevM\Idioma();
        $l_id = $m_id->_carregarselect('idioma_publicar', false);

        $m_te = new DevM\Tema();
        $l_te = $m_te->_listar('tema_publicar', 'tema_descr', 'tema_id AS VALOR, tema_descr AS TEXTO, tema_padrao');

        $m_fd = new DevM\FormatoData();
        $l_fd = $m_fd->_carregarselect('formato_data_publicar', false);

        if( !$inc ):
            # Grupo de usuário
            $mgu = new AdminM\GrupoUsuario($this->modelo->info_grupo);
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
     *
     * Mostrar as informações do usuário logado
     */
    protected function _minhaconta(){
        return $this->_mostrarform($_SESSION['usuario_id'], '');
    } // Fim do método _minhaconta



    /**
     * Mostrar o formulário para alteração de senhas desse usuário
     */
    protected function _formalterarsenha(){
        $this->_formpadrao('senha', null, 'usuarios/alterar-senha-usuario', 'admin/usuarios/minha-conta', $_SESSION['usuario_id']);

        # Visão
        $this->_carregarhtml('form_trocar_senha');
        $this->visao->titulo = TXT_PAGINA_TITULO_TROCAR_MINHA_SENHA;

        # Parâmetros
        $this->visao->_adparam('msg-reset?', (bool)$_SESSION['usuario_conf_reset']);
    } // Fim do método _formalterarsenha



    /**
     * Executar a ação de alterar a senha do usuário
     */
    protected function _alterarsenha(){
        # Obter as senhas informadas
        $sa = md5(md5(filter_input(INPUT_POST, 'senha_atual')));
        $sn = filter_input(INPUT_POST, 'senha_nova');
        $sc = filter_input(INPUT_POST, 'senha_nova_conf');

        $this->modelo->_selecionarPK($_SESSION['usuario_id']);
        $this->modelo->_alterarsenha($sn, $sc, $sa);
        return \Funcoes::_retornar(SUCESSO_USUARIO_ALTERARSENHA, 'msg-sucesso');
    } // Fim do método _alterarsenha



	/**
	 * Bloquear ou desbloquear os usuários selecionado
	 *
	 * @param int $vlr 0 => bloqueia o(s) usuário(2) | 1 => desbloqueia o(s) usuário(s)
	 *
	 * @throws \Exception
	 */
    protected function _bloquear($vlr){
        $tid = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        if( is_null($tid) )
            throw new \Exception(MSG_PADRAO_NENHUM_REGISTRO_SELECIONADO, 1404);

        # Quantidade total de registros e quantidade excluída
        $qt = count($tid);
        $qe = 0;

        foreach( $tid as $id ):
            $this->modelo->_selecionarPK($id);
            $this->modelo->conf_bloq = $vlr;
            $qe = $this->modelo->_salvar();
        endforeach;

	    return $vlr == 1 ? \Funcoes::_retornar( !$qe ? ERRO_USUARIO_BLOQUEAR : sprintf( $qe == 1 ? SUCESSO_USUARIO_BLOQUEAR_UM : SUCESSO_USUARIO_BLOQUEAR_VARIOS, $qe, $qt ), !$qe ? 'msg-erro' : 'msg-sucesso' ) : \Funcoes::_retornar( !$qe ? ERRO_USUARIO_DESBLOQUEAR : sprintf( $qe == 1 ? SUCESSO_USUARIO_DESBLOQUEAR_UM : SUCESSO_USUARIO_DESBLOQUEAR_VARIOS, $qe, $qt ), !$qe ? 'msg-erro' : 'msg-sucesso' );
    } // Fim do método _bloquear



	protected function _salvar_foto(){
		$this->modelo->_salvar_foto();
		\Funcoes::_retornar(SUCESSO_USUARIOS_SALVAR_FOTO, 'msg-sucesso');
	} // Fim do método _salvar_foto
} // Fim do Controle Usuario