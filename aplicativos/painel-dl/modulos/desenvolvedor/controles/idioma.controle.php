<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/01/2015 18:20:35
 */

namespace Desenvolvedor\Controle;

class Idioma extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \Desenvolvedor\Modelo\Idioma(), 'desenvolvedor', TXT_MODELO_IDIOMA);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        =>  FILTER_VALIDATE_INT,
                'descr'     =>  FILTER_SANITIZE_STRING,
                'sigla'     =>  FILTER_SANITIZE_STRING,
                'publicar'  =>  array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array('min_range' => 0, 'max_range' => 1))
            ));

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     * Mostrar a lista de registros
     * -------------------------------------------------------------------------
     */
    protected function _mostrarlista(){
        $this->_listapadrao('idioma_id, idioma_descr, idioma_sigla, ( CASE idioma_publicar'
                . " WHEN 0 THEN 'Não'"
                . " WHEN 1 THEN 'Sim'"
                . " END ) AS PUBLICADO", 'idioma_descr', null);

        # Visão
        $this->_carregarhtml('lista_idiomas');
        $this->visao->titulo = TXT_TITULO_IDIOMAS;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => 'idioma_descr', 'texto' => TXT_LABEL_DESCRICAO),
            array('valor' => 'idioma_sigla', 'texto' => TXT_LABEL_SIGLA)
        ));
    } // Fim do método _mostrarlista



    /**
     * Mostrar o formulário de inclusão e edição
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     * @param bool $tr - define se serão carregados o topo e rodapá da visão
     */
    protected function _mostrarform($id=null,$tr=true){
        $inc = $this->_formpadrao('idioma', 'idiomas/salvar', 'idiomas/salvar', 'desenvolvedor/idiomas', $id);

        # Visão
        $this->_carregarhtml('form_idioma', is_null($tr) ? true : $tr);
        $this->visao->titulo = $inc ? TXT_TITULO_NOVO_IDIOMA : TXT_TITULO_EDITAR_IDIOMA;
    } // Fim do método _mostrarform
} // Fim do Controle Tema