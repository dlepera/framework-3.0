<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 15:11:14
 */

namespace Admin\Modelo;

class Usuario extends \Geral\Modelo\Principal{
    protected $id, $info_grupo, $info_nome, $info_email, $info_telefone, $info_sexo, $info_login, $info_senha,
            $pref_idioma = 1, $pref_tema = 1, $pref_formato_data = 1, $pref_num_registros = 20,
            $conf_bloq = 0, $conf_reset = 1, $perfil_foto = '/aplicacao/imgs/usuario-sem-foto.png', $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _info_grupo($v=null){
        return $this->info_grupo = filter_var(is_null($v) ? $this->info_grupo : $v, FILTER_VALIDATE_INT);
    } // Fim do método _info_grupo

    public function _info_nome($v=null){
        return $this->info_nome = filter_var(is_null($v) ? $this->info_nome : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _info_nome

    public function _info_email($v=null){
        return $this->info_email = filter_var(is_null($v) ? $this->info_email : $v, FILTER_VALIDATE_EMAIL);
    } // Fim do método _info_email

    public function _info_telefone($v=null){
        return $this->info_telefone = filter_var(is_null($v) ? $this->info_telefone : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _info_telefone

    public function _info_sexo($v=null){
        if( is_null($v) ) return (string)$this->info_sexo;

        if( !empty($v) && (strlen($v) > 1 || !in_array($v, array('M', 'F'))) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, 'info_sexo'), 1500);

        return $this->info_sexo = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _info_sexo

    public function _info_login($v=null){
        return $this->info_login = filter_var(is_null($v) ? $this->info_login : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _info_login

    public function _info_senha($v=null){
        return $this->info_senha = md5(md5(filter_var(is_null($v) ? $this->info_senha : $v, FILTER_DEFAULT)));
    } // Fim do método _info_senha

    public function _pref_idioma($v=null){
        return $this->pref_idioma = filter_var(is_null($v) ? $this->pref_idioma : $v, FILTER_VALIDATE_INT);
    } // Fim do método _pref_idioma

    public function _pref_tema($v=null){
        return $this->pref_tema = filter_var(is_null($v) ? $this->pref_tema : $v, FILTER_VALIDATE_INT);
    } // Fim do método _pref_tema

    public function _pref_formato_data($v=null){
        return $this->pref_formato_data = filter_var(is_null($v) ? $this->pref_formato_data : $v, FILTER_VALIDATE_INT);
    } // Fim do método _pref_formato_data

    public function _pref_num_registros($v=null){
        return $this->pref_num_registros = filter_var(is_null($v) ? $this->pref_num_registros : $v, FILTER_VALIDATE_INT);
    } // Fim do método _pref_num_registros

    public function _conf_bloq($v=null){
        return $this->conf_bloq = filter_var(is_null($v) ? $this->conf_bloq : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _conf_bloq

    public function _conf_reset($v=null){
        return $this->conf_reset = filter_var(is_null($v) ? $this->conf_reset : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _conf_reset

    public function _perfil_foto($v=null){
        return $this->perfil_foto = filter_var(is_null($v) ? $this->perfil_foto : $v);
    } // Fim do método _perfil_foto



    public function __construct($id=null){
        parent::__construct('dl_painel_usuarios', 'usuario_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS U'
                . ' INNER JOIN dl_painel_grupos_usuarios AS G ON( G.grupo_usuario_id = U.usuario_info_grupo )'
                . ' INNER JOIN dl_painel_idiomas AS I ON( I.idioma_id = U.usuario_pref_idioma )'
                . ' INNER JOIN dl_painel_temas AS T ON( T.tema_id = U.usuario_pref_tema )'
                . ' INNER JOIN dl_painel_formatos_data FD ON( FD.formato_data_id = U.usuario_pref_formato_data )'
                . ' WHERE %sdelete = 0';

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Salvar o registro no banco de dados
     * -------------------------------------------------------------------------
     *
     * @params int $s - define se o registro será salvo no banco de dados ou
     *  deverá ser retornada a consulta SQL
     */
    protected function _salvar($s=true){
        $and_id = !$this->id ? '' : " AND {$this->bd_prefixo}id <> {$this->id}";

        # Aplicar validações
        if( $s ):
            # Verificar se o login já está cadastrado
            if( $this->_qtde_registros("{$this->bd_prefixo}info_login = '{$this->info_login}'{$and_id}") > 0 )
                throw new \Exception(ERRO_USUARIO_SALVAR_LOGIN_JA_CADASTRADO, 1500);

            # Verificar se o login já está cadastrado
            if( $this->_qtde_registros("{$this->bd_prefixo}info_email = '{$this->info_email}'{$and_id}") > 0 )
                throw new \Exception(ERRO_USUARIO_SALVAR_EMAIL_JA_CADASTRADO, 1500);

            # Salvar a foto do usuário
            if( file_exists($_FILES['perfil_foto']['tmp_name']) && $this->id == $_SESSION['usuario_id'] ):
                $oup = new \Upload('/aplicacao/uploads/usuarios');
                $oup->_extensoes(array('jpg', 'jpeg', 'gif', 'png'));

                if( $oup->_salvar(\Funcoes::_removeracentuacao(strtolower(str_replace(' ', '-', $this->info_nome)))) ):
                    $this->_perfil_foto(preg_replace('~^.~', '', $oup->arquivos_salvos[0]));

                    # Recortar a foto
                    $tim = 200;
                    $oim = new \Imagem($oup->arquivos_salvos[0]);
                    $oim->_redimensionar($tim);
                    $oim->_redimensionar(null, $tim);
                    $oim->_recortar($tim, $tim);
                    $oim->_salvar($oup->arquivos_salvos[0]);
                endif;
            endif;
        endif;

        return parent::_salvar($s,null,!$this->id ? null : array('usuario_info_login','usuario_info_senha'));
    } // Fim do método _salvar



    /**
     * Alterar a senha do usuário logado
     * -------------------------------------------------------------------------
     *
     * @param bool $r - define se a senha está sendo redefinida por reset ou
     *  não
     */
    public function _alterarsenha($r=false){
        if( !$r ):
            # Verificar se a sessão foi iniciada
            if( session_status() !== PHP_SESSION_ACTIVE )
                throw new \Exception(ERRO_PADRAO_SESSAO_NAO_INICIADA, 1403);

            $this->_selecionarID($_SESSION['usuario_id']);
        endif;

        if( is_null($this->id) )
            throw new \Exception(ERRO_USUARIO_ALTERARSENHA_USUARIO_NAO_ENCONTRADO, 1404);

        # Obter as senhas informadas
        $sa = md5(md5(filter_input(INPUT_POST, 'senha_atual')));
        $sn = filter_input(INPUT_POST, 'senha_nova');
        $sc = filter_input(INPUT_POST, 'senha_nova_conf');

        # Comparar a senha atual
        if( $sa != $this->info_senha && !$r )
            throw new \Exception(ERRO_USUARIO_ALTERARSENHA_SENHA_ATUAL_INCORRETA, 1000);

        # Comparar as senhas infromadas
        if( $sn != $sc )
            throw new \Exception(ERRO_USUARIO_ALTERSENHA_SENHAS_NAO_COINCIDEM, 1000);

        # Criptografar a senha
        $sn_c = md5(md5($sn));

        # Alterar a senha no banco de dados
        \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}info_senha = '{$sn_c}' WHERE {$this->bd_prefixo}id = {$this->id}");
    } // Fim do método _alterarsenha



    /**
     * Bloquear ou desbloquear o acesso ao sistema desse usuário
     * -------------------------------------------------------------------------
     *
     * @param int $vlr - Valor que define se o usuário será bloqueado ou desbloquado
     */
    protected function _bloquear($vlr){
        $this->_conf_bloq($vlr);
        $this->_salvar();
    } // Fim do método _bloquear



    /**
     * Selecionar um usuário de acordo com o usuário e senha
     * -------------------------------------------------------------------------
     *
     * @param string $u - nome de usuário
     * @param string $s - senha do usuário
     * @param string $c - campos a serem selecionados para a sessão
     *
     * @return array - vetor associativo com as informações do usuário
     */
    public function _fazerlogin($u,$s,$c='*'){
        $this->_info_login($u);
        $this->_info_senha($s);

        $d = end($this->_listar(
                "usuario_info_login = '{$this->info_login}' AND usuario_info_senha = '{$this->info_senha}'",
                null, $c
            ));

        if( $d === false )
            throw new \Exception(ERRO_USUARIO_FAZERLOGIN_USUARIO_OU_SENHA_INVALIDOS, 1403);

        return $d;
    } // Fim do método _fazerlogin



    /**
     *  Mostrar a foto de perfil do usuário
     * -------------------------------------------------------------------------
     *
     * @param string $dr - diretório relativo da foto
     * @param string $tm - tamanho da foto
     */
    public function _mostrarfoto($dr = '.', $tm = 'm'){
        $pf = "{$dr}{$this->perfil_foto}";

        return '<span class="usr-perfil-foto tam-'. $tm .'">'
            . "<img src='{$pf}' class='foto' alt='{$this->info_nome}'/>"
            . '</span>';
    } // Fim do método _mostrarfoto
} // Fim do Modelo Usuario