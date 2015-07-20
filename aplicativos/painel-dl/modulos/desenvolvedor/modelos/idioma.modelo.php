<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/01/2015 18:14:07
 */

namespace Desenvolvedor\Modelo;

use \Geral\Modelo as GeralM;

class Idioma extends GeralM\Principal{
    protected $id, $descr, $sigla, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _descr($v = null){
        return $this->descr = filter_var(!isset($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _sigla($v = null){
        return $this->sigla = filter_var(!isset($v) ? $this->sigla : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _sigla



    public function __construct(){
        parent::__construct('dl_painel_idiomas', 'idioma_');
    } // Fim do método __construct
} // Fim do Modelo Idioma