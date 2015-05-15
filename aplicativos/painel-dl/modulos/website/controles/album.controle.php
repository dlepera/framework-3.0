<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace WebSite\Controle;

class Album extends \Geral\Controle\PainelDL{
    public function __construct(){
        parent::__construct(new \WebSite\Modelo\Album(), 'website', TXT_MODELO_ALBUM);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ):
            $post = filter_input_array(INPUT_POST, array(
                'id'        =>  FILTER_VALIDATE_INT,
                'nome'      =>  FILTER_SANITIZE_STRING,
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
    protected function _mostrarlista(){
        $this->_listapadrao('album_id, album_nome, foto_album_imagem, ( CASE album_publicar'
                . " WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim'"
                . ' END ) AS PUBLICADO', 'album_nome', null);

        # Visão
        $this->_carregarhtml('lista_albuns');
        $this->visao->titulo = TXT_PAGINA_TITULO_ALBUNS_FOTOS;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => 'album_nome', 'texto' => TXT_ROTULO_NOME)
        ));
    } // Fim do método _mostrarlista



    /**
     * Mostrar o formulário de inclusão e edição do registro
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     */
    public function _mostrarform($id=null){
        $inc = $this->_formpadrao('album', 'albuns-de-fotos/salvar', 'albuns-de-fotos/salvar', 'website/albuns-de-fotos', $id);

        # Visão
        $this->_carregarhtml('form_album');
        $this->visao->titulo = $inc ? TXT_PAGINA_TITULO_NOVO_ALBUM : TXT_PAGINA_TITULO_EDITAR_ALBUM;

        if( !$inc ):
            # Lista de fotos
            $mf = new \WebSite\Modelo\FotoAlbum();
            $lf = $mf->_listar("foto_album = {$this->modelo->id} AND foto_album_publicar = 1", 'foto_album_capa DESC, foto_album_id DESC',
                    'foto_album_id, foto_album_titulo, foto_album_descr, foto_album_capa+0 AS foto_album_capa, foto_album_imagem');

            # Parâmetros
            $this->visao->_adparam('fotos', $lf);
        endif;
    } // Fim do método _mostrarform
} // Fim do Controle Controle