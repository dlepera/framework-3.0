<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class LeituraContato extends GeralM\Principal{
    protected $leitura_contato, $id, $usuario, $data;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _leitura_contato($v = null){
        return $this->leitura_contato = filter_var(!isset($v) ? $this->leitura_contato : $v, FILTER_VALIDATE_INT);
    } // Fim do método _leitura_contato

    public function _usuario($v = null){
        return $this->usuario = filter_var(!isset($v) ? $this->usuario : $v, FILTER_VALIDATE_INT);
    } // Fim do método _usuario

    public function _data($v = null){
        return $this->data = \Funcoes::_formatardatahora(filter_var(!isset($v) ? $this->data : $v, FILTER_SANITIZE_STRING), \DL3::$bd_dh_formato_completo);
    } // Fim do método _data



    public function __construct($pk = null){
        parent::__construct('dl_site_contatos_leitura', 'leitura_contato_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS LC'
                . " INNER JOIN dl_site_contatos AS CS ON( CS.contato_site_id = LC.leitura_contato )"
                . " LEFT JOIN dl_painel_usuarios AS U ON ( U.usuario_id = LC.{$this->bd_prefixo}usuario )";

        $this->_selecionarPK($pk);
    } // Fim do método __construct




    /**
     * Salvar determinado registro
     *
     * @param boolean $s   Define se o registro será salvo ou apenas será gerada a query de insert/update
     * @param array   $ci  Vetor com os campos a serem considerados
     * @param array   $ce  Vetor com os campos a serem desconsiderados
     * @param bool    $ipk Define se o campo PK será considerado para inserção
     *
     * @return mixed
     * @throws \Exception
     */
    protected function _salvar($s = true, array $ci = null, array $ce = null, $ipk = false){
        if( !$this->reg_vazio || $this->_verificarleitura() ) return 0;

        # Obter a data atual
        $this->_data(date(\DL3::$bd_dh_formato_completo));

        return parent::_salvar($s, $ci, $ce, $ipk);
    } // Fim do método _salvar




	/**
	 *  Verificar se determinado usuário já leu o contato
	 *
	 * @param int $c - ID do contato
	 * @param int $u - ID do usuário
	 *
	 * @return bool - retorna true caso o usuário já tenha lido o contato ou false caso contrário
	 */
    public function _verificarleitura($c = null,$u = null){
        $this->_leitura_contato($c);
        $this->_usuario($u);

        return (bool)$this->_qtde_registros("leitura_contato = {$this->leitura_contato} AND leitura_contato_usuario = {$this->usuario}");
    } // Fim do método _verificarleitura
} // Fim do Modelo LeituraContato