<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 04/08/15
 * Time: 14:36
 */

namespace Geral\Apoio;

class Lista{
	// Células ------------------------------------------------------------------------------------------------------ //
	public function _th_id($texto){
		return 'th-' . preg_replace(
			'~[^0-9a-z]~', '',
			strtolower(
				str_replace(
					'_', '-',
					\Funcoes::_removeracentuacao($texto)
				)
			)
		);
	} // Fim do método _th_id




	/**
	 * Criar títulos no cabeçalho da tabela
	 *
	 * @param string $id    ID a ser atribuído ao título
	 * @param string $texto Texto a ser exibido como título da coluna
	 * @param array  $ou    Outras opções a serem atribuídas
	 *
	 * @return string
	 */
	public function _celula_titulo($id, $texto, array $ou = []){
		$atr = !empty($ou) ? ' ' . \Funcoes::_array_serialize($ou, ' ', '"') : '';
		$th = "<th id=\"{$id}\"{$atr}>{$texto}</th>";

		return $th;
	} // Fim do método _celula_titulo




	/**
	 * Criar uma célula
	 *
	 * @param string $th    ID do título
	 * @param string $texto Texto a ser exibido na célula
	 * @param array  $ou    Outras opções a serem atribuídas
	 *
	 * @return string
	 */
	public function _celula_comum($th, $texto, array $ou = []){
		$atr = !empty($ou) ? ' ' . \Funcoes::_array_serialize($ou, ' ', '"') : '';
		$td = "<td headers=\"{$th}\"{$atr}><span class=\"tbl-celula-conteudo\">{$texto}</span></td>";

		return $td;
	} // Fim do método _celula_comum
} // Fim da classe Lista