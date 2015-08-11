<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 18:02:20
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class ContatoSite extends GeralM\Principal{
    protected $id, $nome, $email, $telefone, $assunto, $mensagem, $delete = 0;

    public function __construct($pk = null){
        parent::__construct('dl_site_contatos', 'contato_site_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS CS'
                . ' LEFT JOIN dl_site_assuntos_contato AS AC ON( AC.assunto_contato_id = CS.contato_site_assunto )'
                . " INNER JOIN dl_painel_registros_logs AS LR ON( LR.log_registro_idreg = CS.contato_site_id AND LR.log_registro_tabela = '{$this->bd_tabela}' )"
                . ' WHERE CS.%sdelete = 0';

        $this->_selecionarPK($pk);
    } // Fim do método __construct



    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _nome($v = null){
        return $this->nome = filter_var(!isset($v) ? $this->nome : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _nome

    public function _email($v = null){
        return $this->email = filter_var(!isset($v) ? $this->email : $v, FILTER_VALIDATE_EMAIL);
    } // Fim do método _email

    public function _telefone($v = null){
        return $this->telefone = filter_var(!isset($v) ? $this->telefone : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _telefone

    public function _assunto($v = null){
        return $this->assunto = filter_var(!isset($v) ? $this->assunto : $v, FILTER_VALIDATE_INT);
    } // Fim do método _assunto

    public function _mensagem($v = null){
        return $this->mensagem = filter_var(!isset($v) ? $this->mensagem : $v);
    } // Fim do método _mensagem




	/**
	 * Impedir que o contato recebido do site seja alterado
     */
    protected function _salvar(){ return; } // Fim do método _salvar




	/**
	 * Relatório de contatos recebidos por assunto
	 *
	 * Gerar um relatório simples para mostrar quantos contatos foram recebidos
	 * para cada assunto
	 *
	 * @return string Trecho HTML demosntrando o resultado do relatório
	 */
    public function _rel_contar_por_assuntos(){
        $num = $this->_qtde_registros();

        $lis = $this->_listar(
            '1=1 GROUP BY assunto_contato_id', 'assunto_contato_descr',
            "COUNT({$this->bd_prefixo}id) AS QTDE, COALESCE(assunto_contato_descr, '". MSG_ASSUNTO_NAO_INFORMADO ."') AS DESCR, COALESCE(assunto_contato_cor, '#000') AS COR"
        );

        $tabela = '<table class="wg-conteudo"><tbody>';

        foreach($lis as $d):
            $p100 = round(($d['QTDE']*100)/$num);

            $tabela .= "<tr style='color: {$d['COR']}'>"
                . "<td>{$d['DESCR']}</td>"
                . "<td>{$d['QTDE']} ({$p100}%)</td>"
                . '</tr>';
        endforeach;

        $tabela .= '</tbody><tfoot>'
                . '<tr style="color: #000">'
                . '<td>'. TXT_ROTULO_TOTAL .'</td>'
                . "<td>{$num} (100%)</td>"
                . '</tr></tfoot></table>';
                
        return $tabela;
    } // Fim do método _rel_contar_por_assuntos
} // Fim do Modelo ContatoSite