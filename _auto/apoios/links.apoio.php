<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 04/08/15
 * Time: 14:36
 */

namespace Geral\Apoio;

class Link{
	// Configurações ------------------------------------------------------------------------------------------------ //
	private $conf_links = [
		'inserir' => [
			'class' => 'com-icone ico-inserir'
		],

		'editar' => [
			'class' => 'com-icone ico-editar'
		],

		'remover' => [
			'data-ajax' => true,
			'data-ajax-msg' => TXT_AJAX_EXCLUINDO_REGISTROS,
			'data-acao' => 'excluir-registro',
			'class' => 'com-icone ico-remover'
		]
	];




	// Métodos ------------------------------------------------------------------------------------------------------ //
	/**
	 * Criar um link
	 *
	 * @param string      $tipo          Tipo de link
	 * @param string      $href          Destino do link
	 * @param string      $texto         Texto de exibição do link
	 * @param string|null $title         Texto a ser atribuído no atributo 'title'
	 * @param bool        $mostrar_texto Se definido como true, exibe o texto do link. Se false exibe apenas o ícone
	 * @param array       $ou            outros atributos a serem aplicados no link
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function _link($tipo, $href, $texto, $title = null, $mostrar_texto = true, array $ou = []){
		if( !array_key_exists($tipo, $this->conf_links) )
			throw new \Exception(ERRO_LINKS_TIPO_DESCONHECIDO, 1404);

		$atributos_vetor = array_merge($this->conf_links[$tipo], $ou);

		# Definir classes a serem usadas para mostrar ou não o texto
		$this->_definir_classe(
			$atributos_vetor,
			$mostrar_texto ? 'so-icone' : 'com-icone',
			$mostrar_texto ? 'com-icone' : 'so-icone'
		);

		$atributos_string = !empty($atributos_vetor)
			? ' ' . \Funcoes::_array_serialize($atributos_vetor, ' ', '"')
			: '';

		return "<a href=\"{$href}\" title=\"{$title}\"{$atributos_string}>{$texto}</a>";
	} // Fim do método _link




	/**
	 * Adicionar um novo link padrão
	 *
	 * @param string $nome Nome do link a ser
	 * @param array $link
	 *
	 * @throws \Exception
	 */
	public function _novo_link($nome, array $link = []){
		if( array_key_exists($nome, $this->conf_links) )
			throw new \Exception(ERRO_LINKS_TIPO_JA_EXISTE, 1403);

		$this->conf_links[$nome] = $link;
	} // Fim do método _novo_link




	/**
	 * Remover um link padrão
	 *
	 * @param string $nome Nome do link a ser removido
	 */
	public function _excluir_link($nome){
		unset($this->conf_links[$nome]);
	} // Fim do método _excluir_link




	// Métodos segundários ------------------------------------------------------------------------------------------ //
	/**
	 * Definir qual será a classe usada para exibir ou ocultar o texto do link
	 *
	 * @param array  $vetor Vetor com lista de atributos a ser analisado
	 * @param string $de    Classe de origem
	 * @param string $para  Nova classe
	 */
	private function _definir_classe(array &$vetor, $de, $para){
		if( array_key_exists('class', $vetor) ){
			$vetor['class'] = preg_match("~\s+({$de}|{$para})\s+~", $vetor['class'])
				? str_replace($de, $para, $vetor['class'])
				: $vetor['class'] .= " {$para}";
		} else $vetor['class'] = $para;
	} // Fim _definir_classe
} // Fim da classe Link