<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace Desenvolvedor\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;
use \Admin\Modelo as AdminM;

class ModuloFunc extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new DevM\ModuloFunc(), 'desenvolvedor', TXT_MODELO_MODULOFUNC);
	    $this->_carregar_post([
		    'id' => FILTER_VALIDATE_INT,
		    'func_modulo' => FILTER_VALIDATE_INT,
		    'descr' => FILTER_SANITIZE_STRING,
		    'classe' => FILTER_SANITIZE_STRING,
		    'metodos' =>  ['filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_REQUIRE_ARRAY | FILTER_FLAG_EMPTY_STRING_NULL],
		    'grupos' => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]
	    ]);
    } // Fim do método __construct




	/**
	 * Mostrar a lista de registros
	 */
    public function _mostrarlista(){
        $this->_listapadrao('func_modulo_id AS ' . TXT_LISTA_TITULO_ID . ", CONCAT(func_modulo_descr, '<br/>', func_modulo_classe) AS " . TXT_LISTA_TITULO_DESCR,
	        null, null);

        # Visão
        $this->_carregarhtml('comum/visoes/lista_padrao');
        $this->visao->titulo = TXT_PAGINA_TITULO_FUNCIONALIDADES;

        # Parâmetros
        $this->visao->_adparam('dir-lista', 'desenvolvedor/modulos/funcionalidades');
        $this->visao->_adparam('campos', [
            ['valor' => 'func_modulo_descr', 'texto' => TXT_ROTULO_DESCR],
            ['valor' => 'func_modulo_classe', 'texto' => TXT_ROTULO_CLASSE]
        ]);
    } // Fim do método _mostrarlista




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 *
	 * @param int|null  $md  ID do módulo dessa funcionalidade
	 * @param bool|null $mst Nome da página mestra a ser carregada
	 * @param int|null  $pk  Valor da PK do registro a ser selecionado
	 */
    public function _mostrarform($pk = null, $md = null, $mst = null){
        $inc = $this->_formpadrao('func', 'modulos/funcionalidades/salvar', 'modulos/funcionalidades/salvar', null, $pk);

        # Visão
	    $this->_carregarhtml('comum/visoes/titulo_h2');
        $this->_carregarhtml('form_funcs', $mst);
	    $this->visao->titulo = $inc ? sprintf(TXT_PAGINA_TITULO_CADASTRAR_NOVA, $this->nome) : sprintf(TXT_PAGINA_TITULO_EDITAR_ESSA, $this->nome);

        # Grupos de usuários
	    $mgu = new AdminM\GrupoUsuario();
	    $lgu = $mgu->_carregarselect('grupo_usuario_publicar = 1', false);

	    # Parâmetros
	    $this->visao->_adparam('grupos', $lgu);
	    $this->visao->_adparam('modulo', $md);

	    if( $inc ){
		    # Módulos
		    $mf = new DevM\Modulo($md);
		    $mp = new DevM\Modulo($mf->pai);

		    $this->visao->_adparam('modulo-classe', \Funcoes::_removeracentuacao(str_replace(' ', '', $mp->nome)) . '\\Controle\\'
		        # Remover os espaçoes e hífens
			    . preg_replace('~[\s\-]~', '',
			        # Formatar as primeiras letras de cada palavra
				    ucwords(
				        # Remover as preposições
					    preg_replace('~\s+(da|de|di|do|du|das|del|dos|na|no|em)~', ' ',
					        # Remover as acentuações
						    \Funcoes::_removeracentuacao(
						        # Remover os 's' ao final das palavras
							    preg_replace('~s(\s+|$)~', '', $mf->nome)
						    )
					    )
				    )
			    )
		    );
	    } // Fim if( $this->modelo->reg_vazio )
    } // Fim do método _mostrarform
} // Fim do Controle ModuloFunc
