<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 14/01/2015 16:08:22
 */

namespace Geral\Controle;

use \Desenvolvedor\Modelo as DevM;
use \Admin\Modelo as AdminM;

class PainelDL extends Principal{
    public function __construct($m, $nm, $nc){
        parent::__construct($m, $nm, $nc);

        # Selecionar os módulos e sub-módulos
        $mm = new DevM\Modulo();
        $lm = $mm->_listar('M.modulo_publicar = 1 AND M.modulo_pai IS NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_nome, M.modulo_descr, M.modulo_link');
        $ls = $_SESSION['usuario_id'] != -1 ?
            $mm->_listarmenu('M.modulo_publicar = 1 AND M.modulo_pai IS NOT NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome, M.modulo_descr, M.modulo_link, M.modulo_ordem')
            : $mm->_listar('M.modulo_publicar = 1 AND M.modulo_menu = 1 AND M.modulo_pai IS NOT NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome, M.modulo_descr, M.modulo_link, M.modulo_ordem');

        # Dados do usuário
        $mus = new AdminM\Usuario($_SESSION['usuario_id']);

        # Parâmetros
        $this->visao->_adparam('menu-modulos', $lm);
        $this->visao->_adparam('menu-submodulos', $ls);
        $this->visao->_adparam('usr-foto', $mus->_mostrarfoto(\DL3::$dir_relativo, 'p'));
        $this->visao->_adparam('perm-usr-senha?', \DL3::$aut_o->_verificarperm('Admin\Controle\Usuario', '_formalterarsenha') && $_SESSION['usuario_id'] > 0);
        $this->visao->_adparam('perm-usr-conta?', \DL3::$aut_o->_verificarperm('Admin\Controle\Usuario', '_minhaconta') && $_SESSION['usuario_id'] > 0);
        $this->visao->_adparam('mostrar-filtro-menu?', $_SESSION['usuario_pref_filtro_menu']);
    } // Fim do método __construct




    /**
     * Verificar o permissionamento do grupo antes de executar a ação
     *
     * @param string $n Nome da ação / método  a ser executada
     * @param array  $a Vetor com os valores dos argumentos a serem utilizados na chamada da ação
     *
     * @return bool|mixed
     */
    public function __call($n,$a){
        if( !\DL3::$aut_o->_verificarperm(get_called_class(), $n) ){
            $this->visao->_status_http(403);
            return false;
        } // Fim if( !\DL3::$aut_o->_verificarperm(get_called_class(),$n) )

        return call_user_func_array(
            [$this, $n],
            !empty($a) ? $a : []
        );
    } // Fim do método __call
} // Fim do Controle PainelDL