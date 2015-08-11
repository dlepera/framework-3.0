<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;
use \Desenvolvedor\Modelo as DevM;

class ConfiguracaoSite extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\ConfiguracaoSite(), 'website', TXT_MODELO_CONFIGURACAOSITE);

        if( filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' ){
            $post = filter_input_array(INPUT_POST, [
                'id' => FILTER_VALIDATE_INT,
                'tema' => FILTER_VALIDATE_INT,
                'formato_data' => FILTER_VALIDATE_INT
            ]);

            # Converter o encode
            \Funcoes::_converterencode($post, \DL3::$ap_charset);

            # Selecionar as informações atuais
            $this->modelo->_selecionarPK($post['id']);

            \Funcoes::_vetor2objeto($post, $this->modelo);
        } // Fim if( filter_input(INPUT_SERVER, 'REQUEST_METHOD')
    } // Fim do método __construct




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 */
    public function _mostrarform(){
        $this->_formpadrao('config', null, 'configuracoes/salvar', 'website/configuracoes', 1);

        # Visão
        $this->_carregarhtml('form_configuracao');
        $this->visao->titulo = TXT_PAGINA_TITULO_CONFIGURACAOSITE;

        # Selecionar os temas
        $mtm = new DevM\Tema();
        $ltm = $mtm->_carregarselect('tema_publicar = 1', false);

        # Selecionar os formatos de datas
        $mfd = new DevM\FormatoData();
        $lfd = $mfd->_carregarselect('formato_data_publicar = 1', false);

        # Parâmetros
        $this->visao->_adparam('temas', $ltm);
        $this->visao->_adparam('formatos-data', $lfd);
    } // Fim do método _mostrarform
} // Fim do Controle ConfiguracaoSite