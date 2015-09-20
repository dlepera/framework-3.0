<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 01/07/2014 13:38:07
 */

namespace Login\Modelo;

use \Geral\Modelo as GeralM;

class Recuperacao extends GeralM\Principal{
    # Propriedades desse modelo
    protected $id, $usuario, $hash, $status = 'E';

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _usuario($v = null){
        return $this->usuario = filter_var(!isset($v) ? $this->usuario : $v, FILTER_VALIDATE_INT);
    } // Fim do método _usuario

    public function _hash($v = null){
	    $v = $this->reg_vazio ? md5(crypt($v)) : $v;
        return $this->hash = filter_var(!isset($v) ? $this->hash : $v);
    } // Fim do método _hash

    public function _status($v = null){
        return $this->status = filter_var(!isset($v) ? $this->status : $v, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '~^[ACRX]{1}$~']]);
    } // Fim do método _status




    public function __construct($pk = null){
        parent::__construct('dl_painel_usuarios_recuperacoes', 'recuperacao_');

        # Query de seleção
        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS R'
                . ' INNER JOIN dl_painel_usuarios AS U ON( U.usuario_id = R.recuperacao_usuario )';

        $this->_selecionarPK($pk);
    } // Fim do método mágico __construct
} // Fim do modelo Recuperacao
