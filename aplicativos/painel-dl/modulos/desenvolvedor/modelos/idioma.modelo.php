<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/01/2015 18:14:07
 */

namespace Desenvolvedor\Modelo;

class Idioma extends \Geral\Modelo\Principal{
    protected $id, $descr, $sigla, $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _descr($v=null){
        return is_null($v) ? (string)$this->descr
        : $this->descr = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _sigla($v=null){
        if( is_null($v) ) return (string)$this->sigla;

        # Validar o idioma informado
        if( strlen($v) != 5 || strpos($v, '_') != 2 )
            throw new Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, 'silga'), 1500);

        return $this->sigla = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _sigla



    public function __construct(){
        parent::__construct('dl_painel_idiomas', 'idioma_');
    } // Fim do método __construct
} // Fim do Modelo Idioma