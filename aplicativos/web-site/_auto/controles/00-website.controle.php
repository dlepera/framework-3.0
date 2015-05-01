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
        $lga = $mga->_listar('ga_publicar = 1', null, 'ga_codigo_ua');

        # Informações para contato
        $mdc = new \Contato\Modelo\DadoContato();

        # Listar as redes sociais
        $lrs = $mdc->_listar('tipo_dado_rede_social = 1', 'tipo_dado_descr', 'tipo_dado_descr, tipo_dado_icone, dado_contato_descr');

        # Listar dados para contato
        $ldc = $mdc->_listar('tipo_dado_rede_social = 0', 'tipo_dado_descr', 'tipo_dado_descr, tipo_dado_icone, dado_contato_descr');

        # Parâmetros
        $this->visao->_adparam('ga-configs', $lga);
        $this->visao->_adparam('dados-contato', $ldc);
        $this->visao->_adparam('redes-sociais', $lrs);
    } // Fim do método __construct
} // Fim do Controle WebSite