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
    private $rotas = array();

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
	 * @param string $r - Rota a ser analizada
	 *
	 * @return mixed - Retorna um array associativo com os parâmetros localizados ou null se nenhum parâmetro foi
	 *               configurado para a rota
	 */
    private function _obterparams($r){
        # String de parâmetros
        $sp = is_array($r) ? $r['params'] : $r;

        # Verificar se foram passados outros parâmetros
        $op = is_array($r) ? preg_grep('~(controle|acao|params)~', array_keys($r), PREG_GREP_INVERT) : false;

        # Verificar se os parâmetros foram configurados na rota
        if( !preg_match('~/\:[a-z_]+~', $sp) && !$op ) return null;

        # Vetor a ser retornado
        $vp = array();

        # Obter os outros parâmetros
        foreach( $op as $p )
            $vp[$p] = $r[$p];

        # Separar apenas os parâmetros da string
        $sop = preg_grep('~^:~', explode('/', trim($sp, '/')));
        $url = explode('/', $this->url);

        foreach( $sop as $c => $p )
            $vp[preg_replace('~^:~', '', $p)] = $url[$c];

        return $vp;
    } // Fim do método $r



	/**
	 * Obter a rota atual e indicar qual será o controle, a ação e os parâmetros utilizados
	 *
	 * @return bool|Controle
	 * @throws Exception
	 */
    public function _obterrota(){
        if( !$this->_validarrotas() )
            throw new Exception('Nenhuma rota foi configurada!', 1404);

        foreach( $this->rotas as $r => $v ):
            if( preg_match("~{$r}~", $this->url) ):
                $p = $this->_obterparams($v);

                if( is_array($v) ):
                    if( !array_key_exists('controle', $p) && array_key_exists('controle', $v) ):
                        $p['controle'] = $v['controle'];
                    endif;

                    if( !array_key_exists('acao', $p) && array_key_exists('acao', $v) ):
                        $p['acao'] = $v['acao'];
                    endif;
                endif;
                
                $c = $p['controle']; unset($p['controle']);
                $a = $p['acao']; unset($p['acao']);

                return new Controle($this->modulo, $c, $a, $p);
            endif;
        endforeach;

        return false;
    } // Fim do método _obterrota
} // Fim da classe Roteamento