<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 12:46:40
 */

namespace Home\Controle;

class WebSite extends \Geral\Controle\PainelDL{
    public function __construct($m=null) {
        parent::__construct($m, 'home', '');
    } // Fim do método __construct

    public function _index(){
        # Visao
        $this->_carregarhtml('home');
        $this->visao->titulo = TXT_TITULO_PAINELDL_HOME;

        # Carregar informações sobre contatos recebidos
        $mc = new \WebSite\Modelo\ContatoSite();

        # Parâmetros
        $this->visao->_adparam('rel-contatos', $mc->_rel_contar_por_assuntos());
    } // Fim do método _index



    /**
     * Obter informações do Google Analytics
     * -------------------------------------------------------------------------
     */
    public function _ganalytics($dt_inicio, $dt_fim, $dimensao = 'day', $metricas = array('visits')){
        # Selecionar as configurações do Google Analytics
        $m_ga = new \WebSite\Modelo\GoogleAnalytics();
        $m_ga->_selecionar_principal();

        # Conectar ao Google Analytics
        $o_ga = new \gapi($m_ga->usuario, $m_ga->senha);

        # Retornar as informações
        $o_ga->requestReportData(
            $m_ga->perfil_id, $dimensao, $metricas, null, null,
            \Funcoes::_formatardatahora($dt_inicio, 'Y-m-d'), \Funcoes::_formatardatahora($dt_fim, 'Y-m-d')
        );

        # Visitas
        $infos = array();

        foreach( $o_ga->getResults() as $info ):
            $infos[] = array('dimensao' => (string)$info, 'visitas' => $info->getVisits());
        endforeach;

        echo json_encode($infos);
    } // Fim do método _ganalytics
} // Fim da classe WebSite