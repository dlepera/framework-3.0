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
        return is_null($v) ? (string)$this->descr
        : $this->descr = filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _email($v=null){
        return is_null($v) ? (string)$this->email
        : $this->email = filter_var($v, FILTER_VALIDATE_EMAIL);
    } // Fim do método _email

    public function _cor($v=null){
        if( is_null($v) ) return (string)$this->cor;

        # Validar o formato hexadecimal da cor
        if( !empty($v) && !preg_match('~^#[a-fA-F0-9]{3,6}$~', $v) )
            throw new Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, 'cor'), 1500);

        return $this->cor = filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _email



    public function __construct($id=null){
        parent::__construct('dl_site_assuntos_contato', 'assunto_contato_');

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct
} // Fim do Modelo AssuntoContato