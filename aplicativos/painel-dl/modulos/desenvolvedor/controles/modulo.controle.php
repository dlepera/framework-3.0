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

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ){
            $post = filter_input_array(INPUT_POST, [
                'id'        => FILTER_VALIDATE_INT,
                'pai'       => FILTER_VALIDATE_INT,
                'nome'      => FILTER_SANITIZE_STRING,
                'descr'     => FILTER_DEFAULT,
                'menu'      => FILTER_VALIDATE_BOOLEAN,
                'link'      => FILTER_SANITIZE_STRING,
                'ordem'     => FILTER_VALIDATE_INT,
                'publicar'  => FILTER_VALIDATE_BOOLEAN
            ]);

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarPK($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        } // Fim if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' )
    } // Fim do método __construct




    /**
     * Mostrar a lista de registros
     */
    protected function _mostrarlista(){
        $this->_listapadrao('M.modulo_id, M.modulo_nome AS MODULO, S.modulo_nome AS MODULO_PAI, M.modulo_link,'
            . " ( CASE M.modulo_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS PUBLICADO",
	        'S.modulo_nome, M.modulo_nome', null);

        # Visão
        $this->_carregarhtml('lista_modulos');
        $this->visao->titulo = TXT_PAGINA_TITULO_MODULOS;

        # Parâmetros
	    $this->visao->_adparam('dir-lista', 'desenvolvedor/modulos/');
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
        $this->_carregarhtml('form_modulo');
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO_MODULO : TXT_PAGINA_TITULO_EDITAR_MODULO;

        # Lista de módulos 'pai'
        $l_mp = $this->modelo->_listar('M.modulo_pai IS NULL'.
                (!$inc && $this->modelo->pai == 0 ? " AND M.modulo_id <> {$this->modelo->id}" : ''),
                'M.modulo_nome', 'M.modulo_id AS VALOR, M.modulo_nome AS TEXTO');

        # Parâmetros
        $this->visao->_adparam('modulos-pai', $l_mp);

        if( !$inc ){
	        # Funcionalidades
	        $m_mf = new DevM\ModuloFunc();
	        $l_mf = $m_mf->_carregarselect("func_modulo = {$this->modelo->id}", false);

	        if( $this->modelo->pai > 0 ){
		        # Visoes
		        $this->_carregarhtml('form_funcs');
		        $this->_carregarhtml('lista_funcs');

		        # Módulo pai
		        $mp = $this->modelo->_listar("M.modulo_id = {$this->modelo->pai}", null, 'M.modulo_nome', 0, 1, 0);

		        # Grupos para inclusão das funcionalidades
		        $mgu = new AdminM\GrupoUsuario();
		        $lgu = $mgu->_carregarselect('grupo_usuario_publicar = 1', false);

		        # Informar a classe e os grupos
		        $this->visao->_adparam('grupos', $lgu);
		        $this->visao->_adparam('modulo-classe',
			        \Funcoes::_removeracentuacao(str_replace(' ', '', $mp['modulo_nome']))
			        . '\\Controle\\'
			        # Remover os espaçoes e hífens
			        . preg_replace(
				        '~[\s\-]~', '',
			            # Formatar as primeiras letras de cada palavra
				        ucwords(
					        # Remover as preposições
					        preg_replace(
						        '~\s+(da|de|di|do|du|das|del|dos|na|no|em)~', ' ',
						        # Remover as acentuações
						        \Funcoes::_removeracentuacao(
							        # Remover os 's' ao final das palavras
							        preg_replace('~s(\s+|$)~', '', $this->modelo->nome)
						        )
					        )
				        )
			        )
		        );
	        } // Fim if( isset($this->modelo->pai) )

	        $this->visao->_adparam('funcs', $l_mf);
        } // Fim if( !$inc )
    } // Fim do método _mostrarform




    /**
     * Incluir uma nova funcionalidade
     */
    protected function _novafunc(){
        $of = new DevM\ModuloFunc();

        $post = filter_input_array(INPUT_POST, [
	        'id' => FILTER_VALIDATE_INT,
	        'func_modulo' => FILTER_VALIDATE_INT,
	        'descr' => FILTER_SANITIZE_STRING,
            'classe' => FILTER_SANITIZE_STRING,
            'metodos' =>  ['filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_REQUIRE_ARRAY],
            'grupos' => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]
        ]);

        # Converter o encode
        \Funcoes::_converterencode($post, \DL3::$ap_charset);

        \Funcoes::_vetor2objeto($post, $of);

        $of->_salvar();

        \Funcoes::_retornar(SUCESSO_MODULO_NOVAFUNC, 'msg-sucesso');
    } // Fim do método _novafunc




	/**
	 * Remover uma funcionalidade
	 */
    protected function _removerfunc(){
        $of = new DevM\ModuloFunc();

        $ids = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        # Controlar qtde removida
        $qt = count($ids);
        $qe = 0;

        foreach( $ids as $id ):
            $of->_selecionarPK($id);
            $qe += $of->_remover();
        endforeach;

        \Funcoes::_retornar(
            !$qe ? ERRO_CONTROLEPRINCIPAL_REMOVER : sprintf($qe == 1 ? SUCESSO_CONTROLEPRINCIPAL_REMOVER_UM : SUCESSO_CONTROLEPRINCIPAL_REMOVER_VARIOS, $qe, $qt),
            !$qe ? 'msg-erro' : 'msg-sucesso'
        );
    } // Fim do método _removerfunc




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