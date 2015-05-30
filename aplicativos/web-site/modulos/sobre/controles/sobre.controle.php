<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 07/01/2015 14:14:07
 */

namespace Sobre\Controle;

class Sobre extends \Geral\Controle\WebSite{
    public function __construct(){
        parent::__construct(new \Sobre\Modelo\Institucional(), 'sobre', TXT_MODELO_SOBRE);
    } // Fim do método __construct



    /**
     * Mostrar a história da empresa
     * -------------------------------------------------------------------------
     */
    public function _historia(){
        $this->_carregarhtml('sobre');
        $this->visao->titulo = TXT_PAGINA_TITULO_SOBRE;

        $id = $this->modelo->_listar(null, null, 'MAX(instit_id) AS ID', 0, 1, 0);
        $this->modelo->_selecionarID($id['ID']);
        
        /* Parâmetros */
        $this->visao->_adparam('modelo', $this->modelo);
    } // Fim do método _historia
} // Fim do método Sobre