<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 14/01/2015 16:08:22
 */

namespace Geral\Controle;

class PainelDL extends \Geral\Controle\Principal{
    public function __construct($m, $nm, $nc){
        parent::__construct($m, $nm, $nc);

        # Selecionar os módulos e sub-módulos
        $mm = new \Desenvolvedor\Modelo\Modulo();
        $lm = $mm->_listar('M.modulo_publicar = 1 AND M.modulo_pai IS NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_nome, M.modulo_descr, M.modulo_link');
        $ls = $_SESSION['usuario_id'] != -1 ?
            $mm->_listarmenu('M.modulo_publicar = 1 AND M.modulo_pai IS NOT NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome, M.modulo_descr, M.modulo_link')
        : $mm->_listar('M.modulo_publicar = 1 AND M.modulo_menu = 1 AND M.modulo_pai IS NOT NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome, M.modulo_descr, M.modulo_link');

        # Dados do usuário
        $mus = new \Admin\Modelo\Usuario($_SESSION['usuario_id']);

        # Parâmetros
        $this->visao->_adparam('menu-modulos', $lm);
        $this->visao->_adparam('menu-submodulos', $ls);
        $this->visao->_adparam('usr-foto', $mus->_mostrarfoto('..', 'p'));
        $this->visao->_adparam('perm-usr-senha?', \DL3::$aut_o->_verificarperm('Admin\Controle\Usuario', '_formalterarsenha') && $_SESSION['usuario_id'] > 0);
        $this->visao->_adparam('perm-usr-conta?', \DL3::$aut_o->_verificarperm('Admin\Controle\Usuario', '_minhaconta') && $_SESSION['usuario_id'] > 0);
    } // Fim do método __construct



    /**
     * Verificar o permissionamento
     * -------------------------------------------------------------------------
     */
    public function __call($n,$a){
        if( !\DL3::$aut_o->_verificarperm(get_called_class(),$n) ):
            echo '<h1>Você não pode executar essa ação!</h1>'
                . '<p>Você não tem permissão para acessar essa página, diretório ou funcionalidade.</p>';

            return false;
        endif;

        return call_user_func_array(
            array($this, $n),
            !empty($a) ? $a : array()
        );
    } // Fim do método __call
} // Fim do Controle PainelDL