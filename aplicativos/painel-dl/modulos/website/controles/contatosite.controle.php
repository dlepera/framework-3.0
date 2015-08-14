<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 12:08:58
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \Geral\Modelo as GeralM;
use \WebSite\Modelo as WebM;

class ContatoSite extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\ContatoSite(), 'website', TXT_MODELO_CONTATOSITE);
    } // Fim do método __construct




    /**
     * Mostrar a lista de registros
     */
    protected function _mostrarlista(){
        $this->_listapadrao('contato_site_id, contato_site_nome, contato_site_email, log_registro_data_criacao,'
                . " ( CASE COALESCE(contato_site_assunto, 0) WHEN 0 THEN 'Não informado' ELSE assunto_contato_descr END ) AS ASSUNTO",
                'log_registro_data_criacao DESC', null);

        # Visão
        $this->_carregarhtml('lista_contatos');
        $this->visao->titulo = TXT_PAGINA_TITULO_CONTATOS_RECEBIDOS;

        # Parâmetros
        $this->visao->_adparam('dir-lista', 'website/contatos-recebidos/');
        $this->visao->_adparam('campos', [
            ['valor' => 'contato_site_nome', 'texto' => TXT_ROTULO_NOME],
            ['valor' => 'contato_site_email', 'texto' => TXT_ROTULO_EMAIL],
            ['valor' => 'assunto_contato_descr', 'texto' => TXT_ROTULO_ASSUNTO],
            ['valor' => 'log_registro_data_criacao', 'texto' => TXT_ROTULO_DATA]
        ]);
        $this->visao->_adparam('perm-detalhes?', \DL3::$aut_o->_verificarperm(get_called_class(), '_mostrardetalhes'));
    } // Fim do método _mostrarlista




    /**
     * Mostrar detalhes do registro
     *
     * @param int $pk Valor da PK do registro a ser selecionado
     *
     * @throws \Exception
     */
    protected function _mostrardetalhes($pk){
        $this->modelo->_selecionarPK($pk);

        if( $this->modelo->reg_vazio )
            throw new \Exception(ERRO_CONTATOSITE_MOSTRADETALHES_NAO_ENCONTRADO, 1404);

        # Visão
        $this->_carregarhtml('det_contato');
        $this->visao->titulo = TXT_PAGINA_TITULO_DETALHES_CONTATO;

        # Assunto do contato
        if( isset($this->modelo->assunto) ){
	        $ma = new WebM\AssuntoContato($this->modelo->assunto);

	        $this->visao->_adparam('assunto-descr', $ma->descr);
	        $this->visao->_adparam('assunto-cor', $ma->cor);
        } // Fim if( isset($this->modelo->assunto) )

        # Registrar a leitura desse contato e obter a lista de quem já leu
        $mlc = new WebM\LeituraContato();
        $mlc->leitura_contato   = $this->modelo->id;
        $mlc->usuario           = $_SESSION['usuario_id'];
        $mlc->_salvar();
        $llc = $mlc->_listar("leitura_contato = {$this->modelo->id}", 'leitura_contato_data DESC', "leitura_contato_data, COALESCE(usuario_info_nome, 'Super Admin') AS USUARIO");

        # Parâmetro
        $this->visao->_adparam('modelo', $this->modelo);
        $this->visao->_adparam('log-email', new GeralM\LogEmail($this->modelo->bd_tabela, $pk));
        $this->visao->_adparam('leituras', $llc);
    } // Fim do método _mostrardetalhes
} // Fim do Controle ContatoSite