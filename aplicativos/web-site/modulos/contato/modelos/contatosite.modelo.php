<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 18:02:20
 */

namespace Contato\Modelo;

use \Geral\Modelo as GeralM;

class ContatoSite extends GeralM\Principal{
    protected $id, $nome, $email, $telefone, $assunto, $mensagem, $delete = 0;

    public function __construct($id=null){
        parent::__construct('dl_site_contatos', 'contato_site_');

        if( empty($id) )
            $this->_selecionarPK((int)$id);
    } // Fim do método __construct



    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _nome($v=null){
        return $this->nome = \Funcoes::_ucwords(filter_var(is_null($v) ? $this->nome : $v, FILTER_SANITIZE_STRING), ['da', 'de', 'di', 'do', 'du', 'das', 'dos', 'e']);
    } // Fim do método _nome

    public function _email($v=null){
        return $this->email = strtolower(filter_var(is_null($v) ? $this->email : $v, FILTER_VALIDATE_EMAIL));
    } // Fim do método _email

    public function _telefone($v=null){
        return $this->telefone = filter_var(is_null($v) ? $this->telefone : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _telefone

    public function _assunto($v=null){
        return $this->assunto = filter_var(is_null($v) ? $this->assunto : $v, FILTER_VALIDATE_INT);
    } // Fim do método _assunto

    public function _mensagem($v=null){
        return $this->mensagem = filter_var(is_null($v) ? $this->mensagem : $v);
    } // Fim do método _mensagem



	/**
	 * Salvar determinado registro
	 *
	 * @param boolean $s   Define se o registro será salvo ou apenas será gerada a query de insert/update
	 * @param array   $ci  Vetor com os campos a serem considerados
	 * @param array   $ce  Vetor com os campos a serem desconsiderados
	 * @param bool    $ipk Define se o campo PK será considerado para inserção
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	protected function _salvar($s=true, $ci=null, $ce=null, $ipk=false){
        return !$this->reg_vazio ? 0 : parent::_salvar($s, $ci, $ce, $ipk);
    } // Fim do método _salvar



    /**
     * Não permitir a remoção desse registro
     */
    protected function _remover(){ return; } // Fim do método _remover
} // Fim do Modelo ContatoSite