<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace Modulo\Controle;

use \Geral\Controle as GeralC;

class Controle extends GeralC\Principal{
    public function __construct(){
        parent::__construct(new \Modelo, '', TXT_MODELO_);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        =>  FILTER_VALIDATE_INT,
                'publicar'  =>  FILTER_VALIDATE_BOOLEAN
            ));

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
    public function _mostrarlista(){
        $this->_listapadrao('[campos]', '[ordem]', null);

        # Visão
        $this->_carregarhtml('lista_');
        $this->visao->titulo = TXT_PAGINA_TITULO_;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => '', 'texto' => '')
        ));
    } // Fim do método _mostrarlista



	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 *
	 * @param int  $pk  Valor da PK do registro a ser selecionado
	 * @param bool $mst Nome da página mestra a ser carregada
	 */
    public function _mostrarform($pk = null, $mst = null){
        $inc = $this->_formpadrao('[id formulario]', '[acao de inclusao]', '[acao de edicao]', '[url de redirecionamento]', $pk);

        # Visão
        $this->_carregarhtml('form_', $mst);
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO : TXT_PAGINA_TITULO_EDITAR;
    } // Fim do método _mostrarform
} // Fim do Controle Controle
