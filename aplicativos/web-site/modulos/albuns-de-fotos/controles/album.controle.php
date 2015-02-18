<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace AlbunsDeFotos\Controle;

class Album extends \Geral\Controle\WebSite{
    public function __construct(){
        parent::__construct(new \AlbunsDeFotos\Modelo\Album(), 'albuns-de-fotos', TXT_MODELO_ALBUM);
    } // Fim do método __construct



    /**
     * Mostrar a lista de registros
     * -------------------------------------------------------------------------
     */
    public function _mostrarlista(){
        $this->_listapadrao('album_id, album_nome, log_registro_data_criacao, foto_album_imagem', 'log_registro_data_criacao DESC', 20,
                '_listar', false);

        # Visão
        $this->_carregarhtml('lista_albuns');
        $this->visao->titulo = TXT_TITULO_ALBUNS_FOTOS;

        # Parâmetros
        $this->visao->_adparam('campos', array(
            array('valor' => '', 'texto' => '')
        ));
    } // Fim do método _mostrarlista
} // Fim do Controle Controle