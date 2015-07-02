<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 11:33:42
 */

namespace Desenvolvedor\Modelo;

use \Geral\Modelo as GeralM;

class FormatoData extends GeralM\Principal{
    protected $id, $descr, $completo, $data, $hora, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _descr($v=null){
        return $this->descr = filter_var(is_null($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _completo($v=null){
        return $this->completo = filter_var(is_null($v) ? $this->completo : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _completo

    public function _data($v=null){
        return $this->data = filter_var(is_null($v) ? $this->data : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _data

    public function _hora($v=null){
        return $this->hora = filter_var(is_null($v) ? $this->hora : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _hora



    public function __construct(){
        parent::__construct('dl_painel_formatos_data', 'formato_data_');
    } // fim do método __construct
} // Fim do Modelo FormatoData