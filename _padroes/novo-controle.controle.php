<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace Modulo\Controle;

class Controle extends \Geral\Controle\Principal{
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
            $this->modelo->_selecionarID($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     * Mostrar a lista de registros
     * -------------------------------------------------------------------------
     */
    public function _mostrarlista(){
        $this->_listapadrao($c, $o, null);

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
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     * @param bool $tr - define se serão carregados o topo e rodapé da página
     */
    public function _mostrarform($id=null,$tr=true){
        $inc = $this->_formpadrao($form_id, $form_ia, $form_ea, $url, $id);

        # Visão
        $this->_carregarhtml('form_');
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO : TXT_PAGINA_TITULO_EDITAR;
    } // Fim do método _mostrarform
} // Fim do Controle Controle
