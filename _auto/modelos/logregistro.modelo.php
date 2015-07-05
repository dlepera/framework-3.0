<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 22/05/2014 16:52:19
 */

namespace Geral\Modelo;

class LogRegistro extends Principal{
    # Propriedades do modelo
    protected $tabela, $idreg, $data_criacao, $data_alteracao, $data_exclusao, $usuario_criacao, $usuario_nome_criacao,
            $usuario_alteracao, $usuario_nome_alteracao, $usuario_exclusao, $usuario_nome_exclusao, $ip_criacao,
            $ip_alteracao, $ip_exclusao;

	/*
     * 'Gets' e 'Sets' das propriedades
     */
	public function _tabela($v=null){
		return $this->tabela = filter_var(is_null($v) ? $this->tabela : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _tabela

	public function _idreg($v=null){
		return $this->idreg = filter_var(is_null($v) ? $this->idreg : $v);
	} // Fim do método _idreg

	public function _data_criacao($v=null){
		return is_null($v) ? \Funcoes::_formatardatahora($this->data_criacao, $_SESSION['formato_data_completo'])
			: $this->data_criacao = \Funcoes::_formatardatahora($v, \DL3::$bd_dh_formato_completo);
	} // Fim do método _data_criacao

	public function _data_alteracao($v=null){
		return is_null($v) ? \Funcoes::_formatardatahora($this->data_alteracao, $_SESSION['formato_data_completo'])
			: $this->data_alteracao = \Funcoes::_formatardatahora($v, \DL3::$bd_dh_formato_completo);
	} // Fim do método _data_alteracao

	public function _data_exclusao($v=null){
		return is_null($v) ? \Funcoes::_formatardatahora($this->data_exclusao, $_SESSION['formato_data_completo'])
			: $this->data_exclusao = \Funcoes::_formatardatahora($v, \DL3::$bd_dh_formato_completo);
	} // Fim do método _data_exclusao

	public function _usuario_criacao($v=null){
		return $this->usuario_criacao = filter_var(is_null($v) ? $this->usuario_criacao : $v, FILTER_VALIDATE_INT);
	} // Fim do método _usuario_criacao

	public function _usuario_nome_criacao($v=null){
		return $this->usuario_nome_criacao = filter_var(is_null($v) ? $this->usuario_nome_criacao : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _usuario_nome_criacao

	public function _usuario_alteracao($v=null){
		return $this->usuario_alteracao = filter_var(is_null($v) ? $this->usuario_alteracao : $v, FILTER_VALIDATE_INT);
	} // Fim do método _usuario_alteracao

	public function _usuario_nome_alteracao($v=null){
		return $this->usuario_nome_alteracao = filter_var(is_null($v) ? $this->usuario_nome_alteracao : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _usuario_nome_alteracao

	public function _usuario_exclusao($v=null){
		return $this->usuario_exclusao = filter_var(is_null($v) ? $this->usuario_exclusao : $v, FILTER_VALIDATE_INT);
	} // Fim do método _usuario_exclusao

	public function _usuario_nome_exclusao($v=null){
		return $this->usuario_nome_exclusao = filter_var(is_null($v) ? $this->usuario_nome_exclusao : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _usuario_nome_exclusao



    public function __construct($tbl = null, $idreg = null){
        parent::__construct('dl_painel_registros_logs', 'log_registro_');

        # Query de seleção
        $this->bd_select = 'SELECT %s FROM %s';

        $this->_selecionarPK([$tbl, $idreg]);
    } // Fim do método mágico de construção da classe



	/**
	 * Salvar registro no banco de dados
	 *
	 * @param bool $r Se true, registra a remoção do registro
	 * @param bool $s Se true, salva o registro no banco de dados. Se false, retorna a string da consulta gerada
	 *
	 * @return string
	 * @throws \Exception
	 */
    public function _salvar($r = false, $s = true){
        $this->_selecionarPK([$this->tabela, $this->idreg]);

        # Obter o ID do usuário
        $vl     = \DL3::$aut_o instanceof \Autenticacao ? \DL3::$aut_o->_verificarlogin(false) : false;
        $id_u   = $vl ? $_SESSION['usuario_id'] : 0;
        $nm_u   = $vl ? $_SESSION['usuario_info_nome'] : null;

        if( $this->reg_vazio ):
            # Complementar informações de inserção
            $this->usuario_criacao      = $id_u;
            $this->usuario_nome_criacao = $nm_u;
            $this->data_criacao         = date(\DL3::$bd_dh_formato_completo);
            $this->ip_criacao           = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

            $query = "INSERT INTO {$this->bd_tabela} ("
                    . " {$this->bd_prefixo}usuario_criacao, {$this->bd_prefixo}usuario_nome_criacao, {$this->bd_prefixo}data_criacao, {$this->bd_prefixo}ip_criacao,"
                    . " {$this->bd_prefixo}idreg, {$this->bd_prefixo}tabela) VALUES ("
                    . " {$this->usuario_criacao}, '{$this->usuario_nome_criacao}', '{$this->data_criacao}', '{$this->ip_criacao}', {$this->idreg}, '{$this->tabela}')";
        else:
            if( !$r ):
                # Complementar os dados de atualização
                $this->usuario_alteracao        = $id_u;
                $this->usuario_nome_alteracao   = $nm_u;
                $this->data_alteracao           = date(\DL3::$bd_dh_formato_completo);
                $this->ip_alteracao             = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

                $query = "UPDATE {$this->bd_tabela} SET"
                        . " {$this->bd_prefixo}usuario_alteracao = {$this->usuario_alteracao},"
                        . " {$this->bd_prefixo}usuario_nome_alteracao = '{$this->usuario_nome_alteracao}',"
                        . " {$this->bd_prefixo}data_alteracao = '{$this->data_alteracao}',"
                        . " {$this->bd_prefixo}ip_alteracao = '{$this->ip_alteracao}'"
                        . " WHERE {$this->bd_prefixo}idreg = {$this->idreg} AND {$this->bd_prefixo}tabela = '{$this->tabela}'";
            else:
                # Complementar os dados de remoção
                $this->usuario_exclusao         = $id_u;
                $this->usuario_nome_exclusao    = $nm_u;
                $this->data_exclusao            = date(\DL3::$bd_dh_formato_completo);
                $this->ip_exclusao              = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

                $query = "UPDATE {$this->bd_tabela} SET"
                        . " {$this->bd_prefixo}usuario_exclusao = {$this->usuario_exclusao},"
                        . " {$this->bd_prefixo}usuario_nome_exclusao = '{$this->usuario_nome_exclusao}',"
                        . " {$this->bd_prefixo}data_exclusao = '{$this->data_exclusao}',"
                        . " {$this->bd_prefixo}ip_exclusao = '{$this->ip_exclusao}'"
                        . " WHERE {$this->bd_prefixo}idreg = {$this->idreg} AND {$this->bd_prefixo}tabela = '{$this->tabela}'";
            endif;
        endif;

        if( !$s ) return $query;

        if( ($exec = \DL3::$bd_conex->exec($query)) === false )
            throw new \Exception(
                sprintf(ERRO_PADRAO_SALVAR_REGISTRO,
                        '<b>'. $this->bd_tabela .':</b><br><br>'. $query .'<br><br>'. \DL3::$bd_conex->errorInfo()[2]),
                1500);

        return $exec;
    } // Fim do método _salvar
} // Fim do modelo LogRegistro
