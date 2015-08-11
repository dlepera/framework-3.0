<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 04/08/15
 * Time: 14:36
 */

namespace Geral\Apoio;

class Numero{
	private $porcent = [
		'pt_BR' => [
			'formato' => '[valor][simbolo]',
			'simbolo' => '%',
			'decimais' => 2,
			'sep-decimal' => ',',
			'sep-milhar' => ''
		],

		'en_US' => [
			'formato' => '[valor][simbolo]',
			'simbolo' => '%',
			'decimais' => 2,
			'sep-decimal' => '.',
			'sep-milhar' => ','
		]
	];

	private $moedas = [
		'BRL' => [
			'formato' => '[simbolo] [valor]',
			'simbolo' => 'R$',
			'decimais' => 2,
			'sep-decimal' => ',',
			'sep-milhar' => ''
		],

		'USD' => [
			'formato' => '[simbolo] [valor]',
			'simbolo' => 'U$',
			'decimais' => 2,
			'sep-decimal' => '.',
			'sep-milhar' => ','
		],

		'EUR' => [
			'formato' => '[valor] [simbolo]',
			'simbolo' => '€',
			'decimais' => 2,
			'sep-decimal' => ',',
			'sep-milhar' => ' '
		]
	];




	/**
	 * Formatar valor monetário para ser exibido de acordo com o código da moeda
	 *
	 * @param float  $v  Valor a ser formatado
	 * @param string $cm Código da moeda a ser utilizado
	 *
	 * @return mixed
	 */
	public function _moeda($v, $cm = 'BRL'){
		return $this->_formatar_num($v, $this->moedas, $cm);
	} // Fim do método _moeda




	/**
	 * Formatar números em porcentagem
	 *
	 * @param float  $v  Valor a ser formatado
	 * @param string $ci Código de idioma a ser utilizado
	 *
	 * @return mixed
	 */
	public function _porcentagem($v, $ci = 'pt_BR'){
		return $this->_formatar_num($v, $this->porcent, $ci);
	} // Fim do método __porcentagem




	/**
	 * Formatar o número de acordo com a configuração
	 *
	 * @param float  $vl Valor a ser formatado
	 * @param array  $cf Configuração a ser utilizada
	 * @param string $cd Código da configuração a ser utilizada
	 *
	 * @return mixed
	 */
	private function _formatar_num($vl, array $cf, $cd){
		$f = $cf[$cd];

		return str_replace(
			'[simbolo]', $f['simbolo'],
			str_replace(
				'[valor]', number_format($vl, $f['decimais'], $f['sep-decimal'], $f['sep-milhar']),
				$f['formato']
			)
		);
	} // Fim do método _formatar_num
} // Fim da classe Número