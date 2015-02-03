<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 03/02/2015 11:00:17
 */

/**
 * Mostrar todos os álbuns de fotos
 * -----------------------------------------------------------------------------
 */
$rotas['^(home|index|)$'] = array(
    'controle'  =>  'Album',
    'acao'      =>  'mostrarlista'
);



/**
 * Mostrar as fotos de um determinado álbum
 * -----------------------------------------------------------------------------
 */
$rotas['^fotos/\d+$'] = array(
    'controle'  =>  'Foto',
    'acao'      =>  'mostrarfotos',
    'params'    =>  '/-/:a'
);