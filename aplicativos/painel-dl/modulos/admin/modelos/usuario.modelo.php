<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 15:11:14
 */

namespace Admin\Modelo;

use \Geral\Modelo as GeralM;

class Usuario extends GeralM\Principal{
    protected $id, $info_grupo, $info_nome, $info_email, $info_telefone, $info_sexo = 'M', $info_login, $info_senha, $info_senha_conf,
            $pref_idioma = 1, $pref_tema = 1, $pref_formato_data = 1, $pref_num_registros = 20, $pref_exibir_id = 1,
            $pref_filtro_menu = 0, $conf_bloq = 0, $conf_reset = 1, $perfil_foto = '/web/imgs/usuario-sem-foto.png',
            $ultimo_login, $delete = 0;

	/**
	 * Vetor com todas as extensões aceitas para upload da foto de perfil
	 *
	 * @var array
	 */
	public $conf_extensoes_foto_perfil = ['jpg', 'jpeg', 'gif', 'png'];

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _info_grupo($v = null){
        return $this->info_grupo = filter_var(!isset($v) ? $this->info_grupo : $v, FILTER_VALIDATE_INT);
    } // Fim do método _info_grupo

    public function _info_nome($v = null){
        return $this->info_nome = filter_var(!isset($v) ? $this->info_nome : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _info_nome

    public function _info_email($v = null){
        return $this->info_email = filter_var(!isset($v) ? $this->info_email : $v, FILTER_VALIDATE_EMAIL);
    } // Fim do método _info_email

    public function _info_telefone($v = null){
        return $this->info_telefone = filter_var(!isset($v) ? $this->info_telefone : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _info_telefone

    public function _info_sexo($v = null){
        return $this->info_sexo = filter_var(!isset($v) ? $this->info_sexo : $v, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '~^[MF]{1}$~']]);
    } // Fim do método _info_sexo

    public function _info_login($v = null){
        return $this->info_login = filter_var(!isset($v) ? $this->info_login : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _info_login

    public function _info_senha($v = null){
        return $this->info_senha = filter_var(!isset($v) ? $this->info_senha : $this->_cripto_md5($v));
    } // Fim do método _info_senha

	public function _info_senha_conf($v = null){
		return $this->info_senha_conf = filter_var(!isset($v) ? $this->info_senha_conf : $this->_cripto_md5($v));
	} // Fim do método _info_senha_conf

    public function _pref_idioma($v = null){
        return $this->pref_idioma = filter_var(!isset($v) ? $this->pref_idioma : $v, FILTER_VALIDATE_INT);
    } // Fim do método _pref_idioma

    public function _pref_tema($v = null){
        return $this->pref_tema = filter_var(!isset($v) ? $this->pref_tema : $v, FILTER_VALIDATE_INT);
    } // Fim do método _pref_tema

    public function _pref_formato_data($v = null){
        return $this->pref_formato_data = filter_var(!isset($v) ? $this->pref_formato_data : $v, FILTER_VALIDATE_INT);
    } // Fim do método _pref_formato_data

    public function _pref_num_registros($v = null){
        return $this->pref_num_registros = filter_var(!isset($v) ? $this->pref_num_registros : $v, FILTER_VALIDATE_INT);
    } // Fim do método _pref_num_registros

    public function _pref_exibir_id($v = null){
        return $this->pref_exibir_id = filter_var(!isset($v) ? $this->pref_exibir_id : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _pref_exibir_id

    public function _pref_filtro_menu($v = null){
        return $this->pref_filtro_menu = filter_var(!isset($v) ? $this->pref_filtro_menu : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _pref_filtro_menu

    public function _conf_bloq($v = null){
        return $this->conf_bloq = filter_var(!isset($v) ? $this->conf_bloq : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _conf_bloq

    public function _conf_reset($v = null){
        return $this->conf_reset = filter_var(!isset($v) ? $this->conf_reset : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _conf_reset

    public function _perfil_foto($v = null){
        return $this->perfil_foto = filter_var(!isset($v) ? $this->perfil_foto : $v);
    } // Fim do método _perfil_foto

    public function _ultimo_login($v = null){
        return $this->ultimo_login = \Funcoes::_formatardatahora(filter_var(!isset($v) ? $this->ultimo_login : $v), \DL3::$bd_dh_formato_completo);
    } // Fim do método _ultimo_login



    public function __construct($pk = null){
        parent::__construct('dl_painel_usuarios', 'usuario_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS U'
                . ' INNER JOIN dl_painel_grupos_usuarios AS G ON( G.grupo_usuario_id = U.usuario_info_grupo )'
                . ' INNER JOIN dl_painel_idiomas AS I ON( I.idioma_id = U.usuario_pref_idioma )'
                . ' INNER JOIN dl_painel_temas AS T ON( T.tema_id = U.usuario_pref_tema )'
                . ' INNER JOIN dl_painel_formatos_data FD ON( FD.formato_data_id = U.usuario_pref_formato_data )'
                . ' WHERE %sdelete = 0';

        $this->_selecionarPK($pk);
    } // Fim do método __construct




	/**
	 * Salvar determinado registro
	 *
	 * @param boolean $s   Define se o registro será salvo ou apenas será gerada a query de insert/update
	 * @param array   $ci  Vetor com os campos a serem considerados
	 * @param array   $ce  Vetor com os campos a serem desconsiderados
	 * @param bool    $ipk Define se o campo PK será considerado para inserção
	 *
	 * @return mixed
	 * @throws \Exception
	 */
    protected function _salvar($s = true, $ci = null, $ce = null, $ipk = false){
	    # Aplicar validações
	    if( $s ){
		    $and_id = $this->reg_vazio ? '' : " AND {$this->bd_prefixo}id <> {$this->id}";

		    # Validar a senha informada
		    if( $this->reg_vazio ){
			    if( $this->info_senha !== $this->info_senha_conf )
				    throw new \Exception(ERRO_USUARIO_ALTERSENHA_SENHAS_NAO_COINCIDEM, 1500);

			    $this->_validar_senha($this->info_senha, true);
		    } // Fim if( $this->reg_vazio )

		    # Verificar se o login já está cadastrado
		    if( $this->_qtde_registros( "{$this->bd_prefixo}info_login = '{$this->info_login}'{$and_id}" ) > 0 )
			    throw new \Exception( ERRO_USUARIO_SALVAR_LOGIN_JA_CADASTRADO, 1500 );

		    # Verificar se o login já está cadastrado
		    if( $this->_qtde_registros( "{$this->bd_prefixo}info_email = '{$this->info_email}'{$and_id}" ) > 0 )
			    throw new \Exception( ERRO_USUARIO_SALVAR_EMAIL_JA_CADASTRADO, 1500 );
	    } // Fim if( $s )

        $r = parent::_salvar($s, $ci, $this->reg_vazio ? $ce : ['usuario_info_login','usuario_info_senha'], $ipk);

        if( $this->id == $_SESSION['usuario_id'] && $r && $s )
            \DL3::$aut_o->_carregarsessao($this->_listar("usuario_id = {$this->id}", null, implode(',', \DL3::$aut_o->usr_infos), 0, 1, 0));

        return $r;
    } // Fim do método _salvar




	/**
	 * Alterar a senha do usuário logado
	 *
	 * @param string $sn Senha nova, escolhida pelo usuário
	 * @param string $sc Confirmação da senha nova
	 * @param string $sa Senha atual informada pelo usuário
	 * @param bool   $rt Se true, permite que o usuário altere a senha sem estar autenticado. É utilizado para resets
	 *                   de senhas
	 *
	 * @throws \Exception
	 */
    public function _alterarsenha($sn, $sc, $sa = null, $rt = false){
        if( !$rt ){
	        # Verificar se a sessão foi iniciada
	        if( session_status() !== PHP_SESSION_ACTIVE )
		        throw new \Exception(ERRO_PADRAO_SESSAO_NAO_INICIADA, 1403);

	        $this->_selecionarPK($_SESSION['usuario_id']);
        } // Fim if( !$rt )

        if( is_null($this->id) )
            throw new \Exception(ERRO_USUARIO_ALTERARSENHA_USUARIO_NAO_ENCONTRADO, 1404);

        # Comparar a senha atual
        if( !(bool)$this->_qtde_registros("usuario_info_login = '{$_SESSION['usuario_info_login']}' AND usuario_info_senha = '{$sa}'") && !$rt )
            throw new \Exception(ERRO_USUARIO_ALTERARSENHA_SENHA_ATUAL_INCORRETA, 1000);

        # Comparar as senhas infromadas
        if( $sn !== $sc )
            throw new \Exception(ERRO_USUARIO_ALTERSENHA_SENHAS_NAO_COINCIDEM, 1000);

	    # Validar a senha informada
	    $this->_validar_senha($sn);

        # Criptografar a senha
        $sn_c = $this->_cripto_md5($sn);

        # Alterar a senha no banco de dados
        $sql = \DL3::$bd_conex->prepare("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}info_senha = :senha, {$this->bd_prefixo}conf_reset = 0 WHERE {$this->bd_prefixo}id = :id");
	    $sql->execute([':senha' => $sn_c, ':id' => $this->id]);

        $_SESSION['usuario_conf_reset'] = 0;
    } // Fim do método _alterarsenha




    /**
     * Validar a senha
     *
     * @param string     $sn  Senha a ser analisada
     * @param bool|false $md5 Se true, faz a comparação usando a hash MD5 dupla do valores a serem verificados
     *
     * @return bool
     * @throws \Exception
     */
    public function _validar_senha($sn, $md5 = false){
	    $lg = $md5 ? $this->_cripto_md5($this->info_login) : $this->info_login;

	    if( $sn === $lg )
		    throw new \Exception(ERRO_USUARIO_VALIDAR_SENHA_IGUAL_LOGIN, 1403);

	    return true;
    } // Fim do método _validar_senha




	/**
	 * Criptografar em MD5 na quantidade de vezes definida por $qt
	 *
	 * @param string $st String a ser criptografada
	 * @param int    $qt Quantidade de vezes que a string deve ser passada na função md5()
	 *
	 * @return string
	 */
	public function _cripto_md5($st, $qt = 2){
		$md5 = $st;
		for($i = $qt; $i > 0; $i--) $md5 = md5($md5);
		return $md5;
	} // Fim do método _cripto_md5




	/**
	 * Bloquear ou desbloquear o acesso ao sistema desse usuário
	 *
	 * @param int $vlr Valor que define se o usuário será bloqueado ou desbloquado
	 */
    protected function _bloquear($vlr){
        $this->_conf_bloq($vlr);
        $this->_salvar();
    } // Fim do método _bloquear




	/**
	 * Selecionar um usuário pelo usuário e senha
	 *
	 * @param string $u Nome de usuário
	 * @param string $s Senha do usuário
	 * @param string $c Campos a serem selecionados para a sessão
	 * @param bool   $m Se true, a senha passará pela rotina de criptografia MD5
	 *
	 * @return array Vetor associativo com as informações do usuário
	 * @throws \Exception
	 */
    public function _fazerlogin($u, $s, $c = '*', $m = true){
        $this->_info_login($u);
	    $this->_info_email($u);
        $m ? $this->_info_senha($s) : $this->info_senha = $s;

        $d = $this->_listar(
                "(usuario_info_login = '{$this->info_login}' OR usuario_info_email = '{$this->info_email}') AND usuario_info_senha = '{$this->info_senha}'",
                null, $c, 0, 1, 0
            );

        if( (bool)$d === false )
            throw new \Exception(ERRO_USUARIO_FAZERLOGIN_USUARIO_OU_SENHA_INVALIDOS, 1403);

        if( (bool)$d['usuario_conf_bloq'] )
            throw new \Exception(ERRO_USUARIO_FAZERLOGIN_USUARIO_BLOQUEADO, 1403);

        if( $m ){
	        # Registrar a data desse login
	        $this->_selecionarPK($d['usuario_id']);
	        $this->ultimo_login = date(\DL3::$bd_dh_formato_completo);
	        $this->_salvar();
        } // Fim if( $m )

        return $d;
    } // Fim do método _fazerlogin




	/**
	 * Mostrar a foto de perfil do usuário
	 *
	 * @param string $dr Diretório relativo da foto
	 * @param string $tm Tamanho da foto
	 *
	 * @return string Trecho HTML para exibir a foto de perfil
	 */
    public function _mostrarfoto($dr = '.', $tm = 'm'){
        $pf = "{$dr}{$this->perfil_foto}";

        return '<span class="usr-perfil-foto tam-'. $tm .'">'
            . "<img src='{$pf}' class='foto' alt='{$this->info_nome}'/>"
            . '</span>';
    } // Fim do método _mostrarfoto



    public function _resumo(){
        return '<table class="usr-resumo">'
                . '<tbody class="tbl-conteudo">'
                . '<tr>'
                . '  <td class="usr-resumo-rotulo">'. TXT_ROTULO_NOME .'</td>'
                . '  <td class="usr-resumo-info">'. $this->info_nome .'</td>'
                . '</tr>'
                . '<tr>'
                . '  <td class="usr-resumo-rotulo">'. TXT_ROTULO_EMAIL .'</td>'
                . '  <td class="usr-resumo-info">'. $this->info_email .'</td>'
                . '</tr>'
                . '<tr>'
                . '  <td class="usr-resumo-rotulo">'. TXT_ROTULO_GRUPO .'</td>'
                . '  <td class="usr-resumo-info">'. $this->info_grupo .'</td>'
                . '</tr>'
                . '</tbody>'
                . '</table>';
    } // Fim do método _resumo



	public function _salvar_foto(){
		# Salvar a foto do usuário
		if( $this->id != $_SESSION['usuario_id'] )
			throw new \Exception(ERRO_USUARIO_SALVAR_FOTO_OUTRO_USUARIO, 1403);

		$oup = new \Upload('web/uploads/usuarios', 'perfil_foto');
		$oup->_extensoes($this->conf_extensoes_foto_perfil);
		$oup->conf_bloq_extensao = true;

		if( $oup->_salvar($this->info_nome, true) ){
			$this->perfil_foto = preg_replace('~^.~', '', $oup->salvos[0]);

			# Recortar a foto
			$tim = 200;
			$oim = new \Imagem($oup->salvos[0]);
			$oim->_redimensionar($tim);
			$oim->_redimensionar(null, $tim);
			$oim->_recortar($tim, $tim);
			$oim->_salvar($oup->salvos[0]);

			$this->_salvar();
		} // Fim if( $oup->_salvar( $this->info_nome, true ) )
	}// Fim do método _salvar_foto
} // Fim do Modelo Usuario