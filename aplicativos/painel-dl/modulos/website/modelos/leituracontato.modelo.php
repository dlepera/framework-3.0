<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

class LeituraContato extends \Geral\Modelo\Principal{
    protected $leitura_contato, $id, $usuario, $data;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _leitura_contato($v=null){
        return is_null($v) ? (int)$this->leitura_contato
        : $this->leitura_contato = (int)filter_var($v, FILTER_VALIDATE_INT);
    } // Fim do método _leitura_contato

    public function _usuario($v=null){
        return is_null($v) ? (int)$this->usuario
        : $this->usuario = (int)filter_var($v, FILTER_VALIDATE_INT);
    } // Fim do método _usuario

    public function _data($v=null){
        return is_null($v) ? \Funcoes::_formatardatahora($this->data, $_SESSION['formato_data_completo'])
        : $this->data = \Funcoes::_formatardatahora($v, \DL3::$bd_dh_formato_completo);
    } // Fim do método _data



    public function __construct($id=null){
        parent::__construct('dl_site_contatos_leitura', 'leitura_contato_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS LC'
                . " INNER JOIN dl_site_contatos AS CS ON( CS.contato_site_id = LC.leitura_contato )"
                . " LEFT JOIN dl_painel_usuarios AS U ON ( U.usuario_id = LC.{$this->bd_prefixo}usuario )";

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     *  Salvar registro no banco de dados
     * -------------------------------------------------------------------------
     *
     * Só será permitido a inclusão de registros
     *
     * @param bool $s - define se o registro será salvo no BD ou se será retornada a consulta SQL
     * @param array $ci - vetor com os campos a serem considerados
     * @param array $ce - vetor com os campos a serem desconsiderados
     */
    protected function _salvar($s=true, $ci=null, $ce=null){
        if( !is_null($this->id) || $this->_verificarleitura() ) return 0;

        # Obter a data atual
        $this->_data(date(\DL3::$bd_dh_formato_completo));

        return parent::_salvar($s, $ci, $ce);
    } // Fim do método _salvar



    /**
     *  Verificar se determinado usuário já leu o contato
     * -------------------------------------------------------------------------
     * @param int $c - ID do contato
     * @param int $u - ID do usuário
     *
     * @return bool - retorna true caso o usuário já tenha lido o contato ou false caso contrário
     */
    public function _verificarleitura($c=null,$u=null){
        $this->_leitura_contato($c);
        $this->_usuario($u);

        return (bool)$this->_qtde_registros("leitura_contato = {$this->leitura_contato} AND leitura_contato_usuario = {$this->usuario}");
    } // Fim do método _verificarleitura
} // Fim do Modelo LeituraContato