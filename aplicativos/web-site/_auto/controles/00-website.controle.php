<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 28/01/2015 23:49:46
 */

namespace Geral\Controle;

class WebSite extends \Geral\Controle\Principal{
    public function __construct($m, $nm, $nc){
        parent::__construct($m, $nm, $nc);

        # Selecionar a configuração do Google Analytics ativa
        $mga = new \Home\Modelo\GoogleAnalytics();
        $mga->_selecionar_ativa();

        # Parâmetros
        $this->visao->_adparam('ga-codigo-ua', $mga->codigo_ua);
    } // Fim do método __construct
} // Fim do Controle WebSite