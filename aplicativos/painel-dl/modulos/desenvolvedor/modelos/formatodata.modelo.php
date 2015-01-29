<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 11:33:42
 */

namespace Desenvolvedor\Modelo;

class FormatoData extends \Geral\Modelo\Principal{
    protected $id, $descr, $completo, $data, $hora, $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _descr($v=null){
        return is_null($v) ? (string)$this->descr
        : $this->descr = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _completo($v=null){
        return is_null($v) ? (string)$this->completo
        : $this->completo = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _completo

    public function _data($v=null){
        return is_null($v) ? (string)$this->data
        : $this->data = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _data

    public function _hora($v=null){
        return is_null($v) ? (string)$this->hora
        : $this->hora = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _hora



    public function __construct(){
        parent::__construct('dl_painel_formatos_data', 'formato_data_');
    } // fim do método __construct
} // Fim do Modelo FormatoData