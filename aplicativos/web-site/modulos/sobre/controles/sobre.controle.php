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
        parent::__construct(null, 'sobre', TXT_MODELO_SOBRE);
    } // Fim do método __construct



    /**
     * Mostrar a história da empresa
     * -------------------------------------------------------------------------
     */
    public function _historia(){
        $this->_carregarhtml('historia');
        $this->visao->titulo = TXT_TITULO_SOBRE;
    } // Fim do método _historia
} // Fim do método Sobre