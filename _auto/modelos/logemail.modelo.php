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

    public function __construct($tabela=null, $id=null){
        parent::__construct('dl_painel_email_logs', 'log_email_');

        $this->bd_select = "SELECT %s FROM %s";

        if( !is_null($tabela) && !is_null($id) )
            $this->_selecionarID((string)$tabela, (int)$id);
    } // Fim do método mágico de construção da classe

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _config($v=null){
        return is_null($v) ? (int)$this->config
        : $this->config = (int)$v;
    } // Fim do método _config

    public function _ip($v=null){
        return is_null($v) ? (string)$this->ip
        : $this->ip = (string)$v;
    } // Fim do método _ip

    public function _classe($v=null){
        return is_null($v) ? (string)$this->classe
        : $this->classe = (string)$v;
    } // Fim do método _classe

    public function _tabela($v=null){
        return is_null($v) ? (string)$this->tabela
        : $this->tabela = (string)$v;
    } // Fim do método _tabela

    public function _idreg($v=null){
        return is_null($v) ? (string)$this->idreg
        : $this->idreg = (int)$v;
    } // Fim do método _idreg



    /**
     * Obter ou editar o valor da propriedade $status
     * -------------------------------------------------------------------------
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
        if( is_null($v) )
            return $this->status;

        if( !in_array($v, array('S', 'E', 'F')) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);

        return $this->status = (string)$v;
    } // Fim do método _status

    public function _mensagem($v=null){
        return is_null($v) ? (string)$this->mensagem
        : $this->mensagem = (string)$v;
    } // Fim do método _status



    /**
     * Selecionar um registro desse modelo pelo ID
     * -------------------------------------------------------------------------
     *
     * @param int $id - ID do registro a ser selecionado
     *
     * @return void
     */
    protected function _selecionarID($tabela, $idreg){
        if( !method_exists($this, '_listar') )
            throw new \Exception(printf(ERRO_PADRAO_METODO_NAO_EXISTE, '_listar'), 1500);

        $lis_m = end($this->_listar("{$this->bd_prefixo}tabela = '{$tabela}' AND {$this->bd_prefixo}idreg = {$idreg}"));

        # Carregar os dados obtidos do banco de dados
        # nas propriedades da classe
        foreach( $lis_m as $c => $m ):
            $p = preg_replace("~^{$this->bd_prefixo}~", '', $c);

            if( property_exists($this, $p) )
               $this->{$p} = $m;
        endforeach;

        # Carregar as informações de LOG de Registro
        $this->mod_lr = new \Geral\Modelo\LogRegistro($this->bd_tabela, $this->id);
    } // Fim do método _selecionarID
} // Fim do modelo LogEmail
