<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace Contato\Modelo;

class AssuntoContato extends \Geral\Modelo\Principal{
    protected $id, $descr, $email, $cor = '#000', $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _descr(){ return filter_var($this->descr, FILTER_SANITIZE_STRING); } // Fim do método _descr
    public function _email(){ return filter_var($this->email, FILTER_VALIDATE_EMAIL); } // Fim do método _email
    public function _cor(){
        return filter_var($this->cor, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => EXPREG_COR_HEXA)));
    } // Fim do método _email


    public function __construct($id=null){
        parent::__construct('dl_site_assuntos_contato', 'assunto_contato_');

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Impedir a alteração e exclusão dos registros
     * -------------------------------------------------------------------------
     */
    public function _salvar(){ return; }
    public function _remover(){ return; }
} // Fim do Modelo AssuntoContato