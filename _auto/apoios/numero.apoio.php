<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 04/08/15
 * Time: 14:36
 */

namespace Geral\Apoio;

class Numero{
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

	public function _moeda($v, $cm = 'BRL'){
		$m = $this->moedas[$cm];

		return str_replace(
			'[simbolo]', $m['simbolo'],
			str_replace(
				'[valor]', number_format($v, $m['decimais'], $m['sep-decimal'], $m['sep-milhar']),
				$m['formato']
			)
		);
	} // Fim do método _moeda
} // Fim da classe Número