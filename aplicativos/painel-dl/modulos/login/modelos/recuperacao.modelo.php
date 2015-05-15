<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 01/07/2014 13:38:07
 */

namespace Login\Modelo;

class Recuperacao extends \Geral\Modelo\Principal{
    # Propriedades desse modelo
    protected $id, $usuario, $hash, $status = 'E';

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _usuario($valor=null){
        return $this->usuario = filter_var(is_null($v) ? $this->usuario : $v, FILTER_VALIDATE_INT);
    } // Fim do método _usuario

    public function _hash($valor=null){
        return is_null($valor) ? (string)$this->hash
        : $this->hash = (string)md5(crypt($valor));
    } // Fim do método _hash

    public function _status($valor=null){
        return $this->status = filter_var(is_null($v) ? $this->status : $v, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '~^[ACRX]{1}$~')));
    } // Fim do método _status




    public function __construct($id=0){
        parent::__construct('dl_painel_usuarios_recuperacoes', 'recuperacao_');

        # Query de seleção
        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS R'
                . ' INNER JOIN dl_painel_usuarios AS U ON( U.usuario_id = R.recuperacao_usuario )';

        if( !empty($id) )
            $this->_selecionarID($id);
    } // Fim do método mágico __construct
} // Fim do modelo Recuperacao
