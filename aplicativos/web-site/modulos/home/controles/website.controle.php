<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 12:46:40
 */

namespace Home\Controle;

use \Geral\Controle as GeralC;

class WebSite extends GeralC\WebSite{
    public function __construct($m=null) {
        parent::__construct($m, 'home', '');
    } // Fim do método __construct

    public function _index(){
        $this->_carregarhtml('home');
        $this->visao->titulo = \DL3::$ap_titulo;
    } // Fim do método _index

    public function _institucional($n){
        echo "O número informado foi: {$n}";
    } // Fim do método _teste
} // Fim da classe WebSite