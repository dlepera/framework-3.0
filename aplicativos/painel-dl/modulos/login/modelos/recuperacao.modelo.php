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
        return is_null($valor) ? (int)$this->usuario
        : $this->usuario = (int)$valor;
    } // Fim do método _usuario

    public function _hash($valor=null){
        return is_null($valor) ? (string)$this->hash
        : $this->hash = (string)md5(crypt($valor));
    } // Fim do método _hash

    public function _status($valor=null){
        if( is_null($valor) )
            return $this->status;

        if( !empty($valor) && !in_array($valor, array('E', 'C', 'R', 'X')) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1404);

        return $this->status = (string)$valor;
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
