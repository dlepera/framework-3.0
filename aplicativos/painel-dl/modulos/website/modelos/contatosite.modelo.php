<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 18:02:20
 */

namespace WebSite\Modelo;

class ContatoSite extends \Geral\Modelo\Principal{
    protected $id, $nome, $email, $telefone, $assunto, $mensagem, $delete = 0;

    public function __construct($id=null){
        parent::__construct('dl_site_contatos', 'contato_site_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS CS'
                . ' LEFT JOIN dl_site_assuntos_contato AS AC ON( AC.assunto_contato_id = CS.contato_site_assunto )'
                . " INNER JOIN dl_painel_registros_logs AS LR ON( LR.log_registro_idreg = CS.contato_site_id AND LR.log_registro_tabela = '{$this->bd_tabela}' )"
                . ' WHERE CS.%sdelete = 0';

        if( empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _nome(){
        return (string)$this->nome;
    } // Fim do método _nome

    public function _email(){
        return (string)$this->email;
    } // Fim do método _email

    public function _telefone(){
        return (string)$this->telefone;
    } // Fim do método _telefone

    public function _assunto(){
        return (int)$this->assunto;
    } // Fim do método _assunto

    public function _mensagem(){
        return (string)$this->mensagem;
    } // Fim do método _mensagem



    /**
     * Salvar o registro
     * -------------------------------------------------------------------------
     *
     * Impedir que o contato recebido do site seja alterado
     */
    protected function _salvar(){
        throw new \Exception(ERRO_PADRAO_ACAO_NAO_PERMITIDA, 1403);
    } // Fim do método _salvar



    /**
     * Relatório de contatos recebidos por assunto
     * -------------------------------------------------------------------------
     * Gerar um relatório simples para mostrar quantos contatos foram recebidos
     * para cada assunto
     *
     * @return string [HTML] tabela demosntrando o resultado do relatório
     */
    public function _rel_contar_por_assuntos(){
        $num = $this->_qtde_registros();

        $lis = $this->_listar(
            '1=1 GROUP BY assunto_contato_id', 'assunto_contato_descr',
            "COUNT({$this->bd_prefixo}id) AS QTDE, IFNULL(assunto_contato_descr, '". MSG_ASSUNTO_NAO_INFORMADO ."') AS DESCR, IFNULL(assunto_contato_cor, '#000') AS COR"
        );

        $tabela = '<table class="conteudo"><tbody>';

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