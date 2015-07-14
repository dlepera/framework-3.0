<?php

/*
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 15/04/2014
 */


class Upload{
	# Propriedades do upload
	private $diretorio, $extensoes = [], $campo;

	# Registro dos arquivos que foram salvos e que não foram salvos
	public $salvos = [], $nao_salvos = [];

	# Configurações
	/**
	 * Se for definido como true, interrompe o upload quando um arquivo for removido pelo filtro de extensao.
	 * Se for definido como false, apenas remove o arquivo e continua o upload normalmente
	 *
	 * @var bool
	 */
	public $conf_bloq_extensao = false;

	/*
	 * 'Gets' e 'Sets' das propriedades
	 */
	public function _diretorio($v = null){
		return $this->diretorio = '/'. trim(filter_var(is_null($v) ? $this->diretorio : $v, FILTER_SANITIZE_STRING), '/');
	} // Fim do método _diretorio

	public function _extensoes($v = null){
		return $this->extensoes = filter_var(is_null($v) ? $this->extensoes : $v, FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
	} // Fim do método _extensoes

	public function _campo($v = null){
		return $this->campo = filter_var(is_null($v) ? $this->campo : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _campo




	public function __construct($dir = '', $cmp = null){
		$this->_diretorio($dir);
		$this->_campo($cmp);
	} // Fim do método de construção da classe



	private function _obter_arquivos(){
		foreach( $_FILES as $k => $a ){
			if( !empty($this->campo) && $k != $this->campo ) continue;

			if( is_array($a['tmp_name']) ){
				foreach( $a['tmp_name'] as $k2 => $a2 )
					yield ['tmp' => $a2, 'nome' => $a['name'][$k2], 'erro' => $a['error'][$k2]];
			} else yield ['tmp' => $a['tmp_name'], 'nome' => $a['name'], 'erro' => $a['error']];
		} // Fim foreach
	} // Fim do método _obter_arquivos




	/**
	 * Definir o nome do arquivo a ser salvo
	 *
	 * @param array  $o Nome original do arquivo
	 * @param string $n Nome a ser utilizado para salvar o arquivo. Caso null, será usado o nome original do arquivo
	 *
	 * @return string Nome do arquivo sem a extensão
	 */
	private function _definir_nome($o, $n = null){
		return preg_replace('~\.[a-z0-9]{1,4}$~', '',
			\Funcoes::_removeracentuacao(
				strtolower(str_replace(' ', '-',
						is_null($n) ? $o : $n)
				)
			)
		);
	} // Fim do método _definir_nome




	/**
	 * Salvar os arquivos carregados
	 *
	 * @param string $nm Nome do arquivo a ser salvo
	 * @param bool   $se Se true, sobrescreve o arquivo atual, se existir
	 *
	 * @return int Quantidade de arquivos salvos
	 * @throws \Exception
	 */
	public function _salvar($nm = null, $se = false){
		# Diretório onde os arquivos serão salvos
		$d  = ".{$this->diretorio}";
		$qt = 0;

		foreach( $this->_obter_arquivos() as $a ){
			if( $a['erro'] != 0 || !file_exists($a['tmp']) ) continue;

			# Contar a quantidade de arquivos enviados
			$qt++;

			# Obter as informações desse arquivo
			$i = arquivos::_obterinfos($a['tmp']);

			# Verificar se a extensão do arquivo deve ser aceita ou se não há
			# limitação das extensões
			if( count($this->extensoes) > 0 && !in_array($i['extensao'], $this->extensoes) ):
				# Remover o arquivo temporário para não ter o risco de sobrecarregar o servidor
				unlink($a['tmp']);

				# Incluir o nome do arquivo no vetor $nao_salvos
				$this->nao_salvos['extensao'][] = $a['nome'];

				if( $this->conf_bloq_extensao )
					throw new \Exception(sprintf(ERRO_UPLOAD_SALVAR_BLOQ_EXTENSAO, $a['nome'], implode(', ', $this->extensoes)), 1403);

				# Passar para o próximo passo do laço
				continue;
			endif;

			$n = $this->_definir_nome($i['nome'], $nm);
			$c = "{$d}/{$n}.{$i['extensao']}";

			if( !$se ){
				$q = 0;
				while( file_exists( $c ) ) $c = "{$d}/{$n}-{$q}.{$i['extensao']}" AND $q++;
			} // Fim if( !$se )

			move_uploaded_file($a['tmp'], $c) AND $this->salvos[] = $c;
		} // Fim foreach

		return count($this->salvos);
	} // Fim do método _salvar
} // Fim da classe Upload