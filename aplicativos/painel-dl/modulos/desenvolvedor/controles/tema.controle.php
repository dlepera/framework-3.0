<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/01/2015 13:30:33
 */

namespace Desenvolvedor\Controle;

class Tema extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \Desenvolvedor\Modelo\Tema(), 'desenvolvedor', TXT_MODELO_TEMA);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        => FILTER_VALIDATE_INT,
                'descr'     => FILTER_SANITIZE_STRING,
                'diretorio' => FILTER_SANITIZE_STRING,
                'padrao'    => FILTER_VALIDATE_BOOLEAN,
                'publicar'  => FILTER_VALIDATE_BOOLEAN
            ));

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarID($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        endif;
    } // Fim do método __construct



    /**
     * Mostrar a lista de temas
     * -------------------------------------------------------------------------
     */
    protected function _mostrarlista(){
        $this->_listapadrao('tema_id, tema_descr, ( CASE tema_padrao'
                . " WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim'"
                . ' END ) AS PADRAO,'
                . " ( CASE tema_publicar"
                . " WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim'"
                . ' END ) AS PUBLICADO', 'tema_descr', null);

        # Visão
        $this->_carregarhtml('lista_temas');
        $this->visao->titulo = TXT_PAGINA_TITULO_TEMAS;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => 'tema_desc', 'texto' => TXT_ROTULO_DESCRICAO),
            array('valor' => 'tema_diretorio', 'texto' => TXT_ROTULO_DIRETORIO)
        ));
    } // Fim do método _mostrartemas



    /**
     * Formulário de inclusão e edição do tema
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     * @param bool $tr - define se serão carregados o topo e rodapá da visão
     */
    protected function _mostrarform($id=null,$tr=true){
        $inc = $this->_formpadrao('tema', 'temas/instalar-tema', 'temas/atualizar-tema', 'desenvolvedor/temas', $id);

        # Visão
        $this->_carregarhtml('form_tema', is_null($tr) ? true : $tr);
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO_TEMA : TXT_PAGINA_TITULO_EDITAR_TEMA;
    } // Fim di método _mostrarform
} // Fim do Controle Tema