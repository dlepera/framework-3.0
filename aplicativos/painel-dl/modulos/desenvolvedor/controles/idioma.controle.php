<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/01/2015 18:20:35
 */

namespace Desenvolvedor\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;

class Idioma extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new DevM\Idioma(), 'desenvolvedor', TXT_MODELO_IDIOMA);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, [
                'id'        =>  FILTER_VALIDATE_INT,
                'descr'     =>  FILTER_SANITIZE_STRING,
                'sigla'     =>  FILTER_SANITIZE_STRING,
                'publicar'  =>  FILTER_VALIDATE_BOOLEAN
            ]);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct




	/**
	 * Mostrar a lista de registros
	 */
    protected function _mostrarlista(){
        $this->_listapadrao('idioma_id, idioma_descr, idioma_sigla,'
            . " ( CASE idioma_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS PUBLICADO",
            'idioma_descr', null);

        # Visão
        $this->_carregarhtml('lista_idiomas');
        $this->visao->titulo = TXT_PAGINA_TITULO_IDIOMAS;

        # Parâmetros
        $this->visao->_adparam('campos', [
            ['valor' => 'idioma_descr', 'texto' => TXT_ROTULO_DESCRICAO],
            ['valor' => 'idioma_sigla', 'texto' => TXT_ROTULO_SIGLA]
        ]);
    } // Fim do método _mostrarlista




	/**
	 * Mostrar o formulário de inclusão e edição
	 *
	 * @param int    $pk  PK do registro a ser selecionado
	 * @param string $mst Nome da página mestra a ser carregada
	 */
    protected function _mostrarform($pk = null, $mst = 'padrao'){
        $inc = $this->_formpadrao('idioma', 'idiomas/salvar', 'idiomas/salvar', 'desenvolvedor/idiomas', $pk);

        # Visão
        $this->_carregarhtml('form_idioma', $mst);
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO_IDIOMA : TXT_PAGINA_TITULO_EDITAR_IDIOMA;
    } // Fim do método _mostrarform
} // Fim do Controle Tema