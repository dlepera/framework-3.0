<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 12:46:40
 */

namespace Home\Controle;

use \Geral\Controle as Geral;
use \Website\Modelo as WebM;

class WebSite extends Geral\PainelDL{
    public function __construct($m = null) {
        parent::__construct($m, 'home', '');
    } // Fim do método __construct

    public function _index(){
        # Visao
        $this->_carregarhtml('home');
        $this->visao->titulo = TXT_PAGINA_TITULO_PAINELDL_HOME;

        # Carregar informações sobre contatos recebidos
        $mc = new WebM\ContatoSite();

        # Parâmetros
        $this->visao->_adparam('rel-contatos', $mc->_rel_contar_por_assuntos());
    } // Fim do método _index


    public function _sobre(){
	    # Visao
	    $this->_carregarhtml('sobre_sistema');
	    $this->visao->titulo = TXT_PAGINA_TITULO_PAINELDL_SOBRE;
    } // Fim do método _sobre




	/**
	 * Obter informações do Google Analytics
	 *
	 * @param        $dt_inicio
	 * @param        $dt_fim
	 * @param string $dimensao
	 * @param array  $metricas
	 *
	 * @throws \Exception
	 */
    public function _ganalytics($dt_inicio, $dt_fim, $dimensao = 'day', $metricas = ['visits']){
        # Selecionar as configurações do Google Analytics
        $m_ga = new WebM\GoogleAnalytics();
        $m_ga->_selecionar_principal();

        # Conectar ao Google Analytics
        $o_ga = new \gapi($m_ga->_conta_completa(), $m_ga->p12);

        # Retornar as informações
        $o_ga->requestReportData(
            $m_ga->perfil_id, $dimensao, !isset($metricas) ? ['visits'] : $metricas, null, null,
            \Funcoes::_formatardatahora($dt_inicio, 'Y-m-d'), \Funcoes::_formatardatahora($dt_fim, 'Y-m-d')
        );

        # Visitas
        $infos = [];

        foreach( $o_ga->getResults() as $info ):
            $infos[] = ['dimensao' => (string)$info, 'visitas' => $info->getVisits()];
        endforeach;

        echo json_encode($infos);
    } // Fim do método _ganalytics
} // Fim da classe WebSite