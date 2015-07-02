<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 14:52:19
 */

namespace Geral\Modelo;

class LogEmail extends Principal{
    # Propriedades do modelo
    protected $id, $config, $ip, $classe, $tabela, $idreg, $mensagem, $status = 'S';

	/*
     * 'Gets' e 'Sets' das propriedades
     */
	public function _config($v=null){
		return $this->config = filter_var(is_null($v) ? $this->config : $v, FILTER_VALIDATE_INT);
	} // Fim do método _config

	public function _ip($v=null){
		return $this->ip = filter_var(is_null($v) ? $this->ip : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _ip

	public function _classe($v=null){
		return $this->classe = filter_var(is_null($v) ? $this->classe : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _classe

	public function _tabela($v=null){
		return $this->tabela = filter_var(is_null($v) ? $this->tabela : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _tabela

	public function _idreg($v=null){
		return $this->idreg = filter_var(is_null($v) ? $this->idreg : $v, FILTER_VALIDATE_INT);
	} // Fim do método _idreg



    public function __construct($tbl=null, $id=null){
        parent::__construct('dl_painel_email_logs', 'log_email_');

        $this->bd_select = "SELECT %s FROM %s";

        $this->_selecionarPK(array($tbl, $id));
    } // Fim do método mágico de construção da classe





    /**
     * Obter ou editar o valor da propriedade $status
     *
     * Os status aceitos são:
     * S: solicitado
     * E: enviado
     * F: falha
     *
     * @param string $v - string contendo o valor a ser atribuído à $this->status
     *
     * @return string - valor da propriedade $status
     */
    public function _status($v=null){
        return $this->status = filter_var(is_null($v) ? $this->status : $v, FILTER_VALIDATE_REGEXP,
                array('options' => array('regexp' => '~^[SEF]{1}$~')));
    } // Fim do método _status

    public function _mensagem($v=null){
        return $this->mensagem = filter_var(is_null($v) ? $this->mensagem : $v);
    } // Fim do método _status
} // Fim do modelo LogEmail
