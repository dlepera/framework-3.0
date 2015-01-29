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
    public function _descr(){ return (string)$this->descr; } // Fim do método _descr
    public function _email(){ return (string)$this->email; } // Fim do método _email
    public function _cor(){ return (string)$this->cor; } // Fim do método _email


    public function __construct($id=null){
        parent::__construct('dl_site_assuntos_contato', 'assunto_contato_');

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Impedir a alteração e exclusão dos registros
     * -------------------------------------------------------------------------
     */
    public function _salvar(){ return false; }
    public function _remover(){ return false; }
} // Fim do Modelo AssuntoContato