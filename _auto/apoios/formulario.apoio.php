<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 04/08/15
 * Time: 14:36
 */

namespace Geral\Apoio;

class Formulario{
	const ROTULO = <<<HTML
<label for="%s" class="form-rotulo">%s:</label><br/>\n
HTML;


	const DICA = <<<HTML
<span class="form-dica">%s</span><br/>\n
HTML;


	const CHK_SIM_NAO = <<<HTML
<input type="checkbox" name="%s" id="%s" class="form-alternar" %s/>\n
<label for="%s"></label>\n
HTML;


	const COMBO_SELECT = <<<HTML
<select name="%s" id="%s" class="form-controle form-controle-select" %s>\n
HTML;


	const COMBO_OPCAO = <<<HTML
<option value="%s"%s>%s</option>\n
HTML;


	const FONE_ALT_MASK = <<<HTML
<span class="form-dica">
<input type="checkbox" id="alt-mask-%s" data-telefone="#%s" class="alt-mask-fone"%s/>
<label for="alt-mask-%s">%s</label><br/>
</span><br/>\n
HTML;



	/**
	 * Configurações de cada campo
	 * @var array
	 */
	private $conf_input = [
		'arquivo' => [
			'type' => 'file',
			'name' => '',
			'id' => 'arq-',
			'class' => 'form-controle form-controle-arquivo'
		],

		'busca' => [
			'type' => 'search',
			'name' => '',
			'id' => 'bus-',
			'value' => '',
			'class' => 'form-controle form-controle-busca'
		],

		'cor' => [
			'type' => 'color',
			'name' => '',
			'id' => 'cor-',
			'value' => '',
			'class' => 'form-controle form-controle-cor'
		],

		'data' => [
			'type' => 'date',
			'name' => '',
			'id' => 'dt-',
			'value' => '',
			'class' => 'form-controle form-controle-data'
		],

		'data-hora' => [
			'type' => 'datetime',
			'name' => '',
			'id' => 'dh-',
			'value' => '',
			'class' => 'form-controle form-controle-data'
		],

		'email' => [
			'type' => 'email',
			'name' => '',
			'id' => 'mail-',
			'value' => '',
			'class' => 'form-controle form-controle-email'
		],

		'numero' => [
			'type' => 'number',
			'name' => '',
			'id' => 'num-',
			'value' => '',
			'class' => 'form-controle form-controle-numero'
		],

		'range' => [
			'type' => 'range',
			'name' => '',
			'id' => 'num-',
			'value' => '',
			'class' => 'form-controle form-controle-range'
		],

		'senha' => [
			'type' => 'password',
			'name' => '',
			'id' => 'sen-',
			'value' => '',
			'class' => 'form-controle form-controle-senha'
		],

		'fone' => [
			'type' => 'tel',
			'name' => '',
			'id' => 'tel-',
			'value' => '',
			'class' => 'form-controle form-controle-fone'
		],

		'texto' => [
			'type' => 'text',
			'name' => '',
			'id' => 'txt-',
			'value' => '',
			'class' => 'form-controle form-controle-texto'
		],

		'url' => [
			'type' => 'url',
			'name' => '',
			'id' => 'txt-',
			'value' => '',
			'class' => 'form-controle form-controle-url'
		],

		# Campos personalizados
		'cpf' => [
			'type' => 'text',
			'name' => '',
			'id' => 'txt-',
			'value' => '',
			'data-vld-func' => 'ValidaCPF',
			'data-vld-msg' => TXT_VALIDACAO_CPF_INVALIDO,
			'pattern' => EXPREG_CPF,
			'class' => 'form-controle form-controle-cpf'
		],

		'cnpj' => [
			'type' => 'text',
			'name' => '',
			'id' => 'txt-',
			'data-vld-func' => 'ValidaCNPJ',
			'data-vld-msg' => TXT_VALIDACAO_CNPJ_INVALIDO,
			'pattern' => EXPREG_CNPJ,
			'class' => 'form-controle form-controle-cnpj'
		],

		'gtin' => [
			'type' => 'text',
			'name' => '',
			'id' => 'txt-',
			'data-vld-func' => 'ValidaEAN',
			'data-vld-msg' => TXT_VALIDACAO_GTIN,
			'class' => 'form-controle form-controle-gtin'
		],

		'moeda' => [
			'type' => 'number',
			'name' => '',
			'id' => 'num-',
			'step' => '0.01',
			'placeholder' => TXT_EXEMPLO_MOEDA_BRL,
			'class' => 'form-controle form-controle-moeda'
		]
	];




	/**
	 * Montar campo geral <input type="?"/>
	 *
	 * @param string $tp  Tipo de campo a ser criado
	 * @param string $nm  Nome do campo
	 * @param string $id  ID atribuído a esse campo
	 * @param mixed  $vl  Valor inicial do campo
	 * @param string $rtl Rótulo de referência do campo
	 * @param string $dc  Dica vinculada a esse campo
	 * @param array  $ou  Outras configurações do campo
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function _campo_geral($tp, $nm, $id, $vl = null, $rtl = null, $dc = null, array $ou = []){
		# Verificar se o tipo de campo existe
		if( !array_key_exists($tp, $this->conf_input) )
			throw new \Exception(ERRO_FORMULARO_TIPO_DE_CAMPO_DESCONHECIDO);

		$cf = array_merge($this->conf_input[$tp], $ou);
		$cf['name'] = $nm;
		$cf['id'] .= $id;
		$cf['value'] = $vl;
		$in = '';

		isset($rtl) and $in .= sprintf(self::ROTULO, $cf['id'], $rtl);
		isset($dc) and $in .= sprintf(self::DICA, $dc);
		$in .= "<input ". $this->_vetor2string($cf) ."/>\n";

		return $in;
	} // Fim do método _campo_geral




	/**
	 * Montar campo pra upload de arquivos <input type="file"/>
	 *
	 * @param string $nm  Nome do campo
	 * @param string $id  ID atribuído a esse campo
	 * @param string $rtl Rótulo de referência do campo
	 * @param array  $ou  Outras configurações do campo
	 * @param string $ex  Extensões aceitas para upload
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function _arquivo_upload($nm, $id, $rtl = null, array $ou = [], $ex = 'Qualquer uma'){
		$mx = ini_get('upload_max_filesize');

		return $this->_campo_geral('arquivo', $nm, $id, '', $rtl, sprintf(TXT_DICA_INFO_UPLOAD, $ex, $mx),
			array_merge([
				'data-vld-func' => 'ValidaUpload',
				'data-vld-msg' => sprintf(TXT_VALIDACAO_ARQUIVO_UPLOAD, $ex, $mx),
				'data-vld-exts' => $ex,
				'data-vld-max' => $mx
			], $ou)
		);
	} // Fim do método _arquivo_upload




	/**
	 * Montar campo de alternação entre sim e não
	 *
	 * @param string $nm  Nome do campo
	 * @param string $id  ID do campo
	 * @param string $rtl Rótulo de exibição do campo
	 * @param string $dc  Dica de campo
	 * @param string $ou  Outras configurações do campo
	 *
	 * @return string
	 */
	public function _chk_sim_nao($nm, $id, $rtl = null, $dc = null, $ou = ''){
		$chk = '';

		isset($rtl) and $chk .= '<span class="form-rotulo">'. $rtl .'</span><br/>';
		isset($dc) and $chk .= sprintf(self::DICA, $dc);
		
		return $chk . sprintf(self::CHK_SIM_NAO, $nm, $id, $ou, $id);
	} // Fim do método _chk_sim_nao




	/**
	 * Montar uma caixa de seleção
	 *
	 * @param string $nm  Nome do campo
	 * @param string $id  ID atribuído a esse campo
	 * @param mixed  $vl  Valor inicial do campo
	 * @param string $rtl Rótulo de referência do campo
	 * @param string $dc  Dica vinculada a esse campo
	 * @param array  $ou  Outras configurações do campo
	 * @param array  $op  Vetor com as opções do caixa de seleção
	 *
	 * @return string
	 */
	public function _combo_select($nm, $id, $vl = null, $rtl = null, $dc = null, array $ou = [], array $op = []){
		$cbo = '';

		isset($rtl) and $cbo .= sprintf(self::ROTULO, $id, $rtl);
		isset($dc) and $cbo .= sprintf(self::DICA, $dc);

		$cbo .= sprintf(self::COMBO_SELECT, $nm, "sel-{$id}", $this->_vetor2string($ou));

		# Incluir as opções
		foreach( $op as $o ){
			$o = array_change_key_case($o, CASE_UPPER);
			$cbo .= sprintf(self::COMBO_OPCAO, $o['VALOR'], $o['VALOR'] == $vl ? ' SELECTED' : '', $o['TEXTO']);
		} // Fim foreach

		return "{$cbo}</select>\n";
	} // Fim do método _combo_select




	/**
	 * Montar campo de telefone com flag para 8 ou 9 dígitos
	 *
	 * @param string $nm  Nome do campo
	 * @param string $id  ID atribuído a esse campo
	 * @param mixed  $vl  Valor inicial do campo
	 * @param string $rtl Rótulo de referência do campo
	 * @param string $dc  Dica vinculada a esse campo
	 * @param array  $ou  Outras configurações do campo
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function _campo_telefone($nm, $id, $vl = null, $rtl = null, $dc = null, array $ou = []){
		$in = '';
		$id_c = "tel-{$id}";

		isset($rtl) and $in .= sprintf(self::ROTULO, $id_c, $rtl);
		isset($dc) and $in .= sprintf(self::DICA, $dc);

		# Incluir trecho para alternar as máscara
		$in .= sprintf(self::FONE_ALT_MASK, $id_c, $id_c, strlen($vl) > 14 ? ' CHECKED' : '', $id_c, TXT_ROTULO_ALT_MASK_FONE);

		return $in . $this->_campo_geral('fone', $nm, $id, $vl, null, null, $ou);
	} // Fim do método _campo_telefone



	/**
	 * Converter um vetor em uma string de pares de chaves e valores
	 *
	 * @param array $vt Vetor a ser convertido
	 *
	 * @return string|null
	 */
	private function _vetor2string(array $vt){
		return implode(' ', array_map(function($k) use ($vt){
			$vl = $k === 'pattern' ? \Funcoes::_expreg_form($vt[$k]) : $vt[$k];
			return isset($vl) ? "{$k}=\"{$vl}\"" : null;
		}, array_keys($vt)));
	} // Fim do método _vetor2string
} // Fim da classe Apoio