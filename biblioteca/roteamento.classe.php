<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 01:46:34
 */

class Roteamento{
    # Configurações
    const CONF_SEPARADOR_DIR = '/';

    # Rotas configuradas
    private $rotas = [];

    # URL recebida, home do sistema e diretório a serem analizados
    private $url, $dir, $home, $modulo;

    public function __construct(array $r, $d, $m){
        # Configurar as rotas
        $this->rotas    = $r;
        $this->dir      = $d;
        $this->modulo   = $m;
        $this->home     = trim(str_replace(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT'), '', getcwd()), '/');

        # Configurar a URL
        $this->url = trim(preg_replace(
                    "~^/?{$this->modulo}~", '',
                    preg_replace(
                        '~^/?'. DL3_APLICATIVO .'~', '',
                        preg_replace(
                            "~^{$this->home}~", '',
                            trim(filter_input(INPUT_SERVER, 'REDIRECT_URL'), self::CONF_SEPARADOR_DIR)
                        )
                    )
                ), self::CONF_SEPARADOR_DIR);

        // echo '<pre>', var_dump($this->url), '</pre>'; die();
    } // Fim do método __construct




	/**
	 * Validar as rotas configuradas
	 *
	 * Verificar se a propriedade $this->rotas é um vetor se há pelo menos mais de uma rota configurada
	 *
	 * @return bool true se a propriedade $this->rotas é válida e false se não
	 */
    private function _validarrotas(){
        return is_array($this->rotas) || (bool)(count($this->rotas));
    } // Fim do método _validarrotas




	/**
	 * Obter os parâmetros da rota
	 *
	 * @param string $r Rota a ser analizada
	 *
	 * @return mixed  Retorna um array associativo com os parâmetros localizados ou null se nenhum parâmetro foi
	 *               configurado para a rota
	 */
    private function _obterparams($r){
        # Verificar se a rota passada é um array
	    $ev = isset($r) && is_array($r);

        # String de parâmetros
        $sp = !$ev ? $r : array_key_exists('params', $r) ? $r['params'] : '';

        # Verificar se foram passados outros parâmetros
        $op = $ev ? preg_grep('~(controle|acao|params)~', array_keys($r), PREG_GREP_INVERT) : false;

        # Verificar se os parâmetros foram configurados na rota
        if( !preg_match('~/\:[a-z_]+~', $sp) && !$op ) return [];

        # Vetor a ser retornado
        $vp = [];

        # Obter os outros parâmetros
        foreach( $op as $p ) $vp[$p] = $r[$p];

        # Separar apenas os parâmetros da string
        $sop = preg_grep('~^:~', explode('/', trim($sp, '/')));
        $url = explode('/', $this->url);

        foreach( $sop as $c => $p ){
	        if( array_key_exists($c, $url) )
	            $vp[preg_replace('~^:~', '', $p)] = $url[$c];
        } // Fim foreach

        return $vp;
    } // Fim do método _obterparams




	/**
	 * Obter a rota atual e indicar qual será o controle, a ação e os parâmetros utilizados
	 *
	 * @return bool|Controle
	 * @throws Exception
	 */
    public function _obterrota(){
        if( !$this->_validarrotas() )
            throw new Exception('Nenhuma rota foi configurada!', 1404);

        foreach( $this->rotas as $r => $v ){
	        if( preg_match("~{$r}~", $this->url) ){
		        $p = $this->_obterparams($v);

		        if( is_array($v) ){
			        !array_key_exists('controle', $p) && array_key_exists('controle', $v) and
		                $p['controle'] = $v['controle'];

			        !array_key_exists('acao', $p) && array_key_exists('acao', $v) and
			            $p['acao'] = $v['acao'];
		        } // Fim if( is_array($v) )

		        $c = $p['controle'];
		        unset($p['controle']);
		        $a = $p['acao'];
		        unset($p['acao']);

		        return new Controle($this->modulo, $c, $a, $p);
	        } // Fim if( preg_match("~{$r}~", $this->url) )
        } // Fim foreach

        return false;
    } // Fim do método _obterrota
} // Fim da classe Roteamento