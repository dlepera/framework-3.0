<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 19:24:27
 */

namespace WebSite\Modelo;

class AssuntoContato extends \Geral\Modelo\Principal{
    protected $id, $descr, $email, $cor = '#000', $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _descr($v=null){
        return $this->descr = filter_var(is_null($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _email($v=null){
        return $this->email = filter_var(is_null($v) ? $this->email : $v, FILTER_VALIDATE_EMAIL);
    } // Fim do método _email

    public function _cor($v=null){
        return $this->cor = filter_var(is_null($v) ? $this->cor : $v, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => EXPREG_COR_HEXA)));
    } // Fim do método _email



    public function __construct($id=null){
        parent::__construct('dl_site_assuntos_contato', 'assunto_contato_');

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct
} // Fim do Modelo AssuntoContato