<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 12:03:30
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class TipoDadoContato extends GeralM\Principal{
    protected $id, $descr, $icone, $rede_social = 0, $mascara, $expreg, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _descr($v=null){
        return $this->descr = filter_var(is_null($v) ? $this->descr : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _descr

    public function _icone($v=null){
        return $this->icone = filter_var(is_null($v) ? $this->icone : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _icone

    public function _rede_social($v=null){
        return $this->rede_social = filter_var(is_null($v) ? $this->rede_social : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _rede_social

    public function _mascara($v=null){
        return $this->mascara = filter_var(is_null($v) ? $this->mascara : $v);
    } // Fim do método _mascara

    public function _expreg($v=null){
        return $this->expreg = filter_var(is_null($v) ? $this->expreg : $v);
    } // Fim do método _expreg



    public function __construct($pk = null){
        parent::__construct('dl_site_dados_contato_tipos', 'tipo_dado_');

        $this->_selecionarPK($pk);
    } // Fim do método __construct



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
		# Fazer upload da imagem
        $oup = new \Upload('aplicacao/uploads/contatos', 'icone');
		$oup->_salvar($this->descr, true) AND $this->icone = preg_replace('~^\.~', '', $oup->salvos[0]);

		# Salvar registro
        return parent::_salvar($s, $ci, $ce, $ipk);
    } // Fim do método _salvar



    /**
     * Remover registro do banco de dados
     */
    protected function _remover(){
        # Remover o ícone
        !empty($this->icone) AND unlink(".{$this->icone}");

        return parent::_remover();
    } // Fim do método _remover
} // Fim do Modelo TipoDadoContato