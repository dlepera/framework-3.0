<?php

/*
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: Framework MVC / Site
 * @Data	: 14/04/2014
 */

class Imagem{
    # Propriedades dessa imagem
    private $arquivo, $imagem, $largura, $altura, $tipo;

    # Parâmetros de edição
    private $qlde_jpeg = 100, $qlde_png = 9;

    public function __construct($arquivo = null){
        # Verificar se a bibilioteca GD foi inicializada
        if( !extension_loaded('GD') )
            throw new \Exception(ERRO_IMAGEM_CONSTRUCT_EXTENSAO_GD_NAO_CARREGADA, 1500);

        if( !is_null($arquivo) )
            self::__set('arquivo', $arquivo);
    } // Fim do método mágico de construção da classe

    /**
     * Exibir o valor de determinada propriedade
     *
     * @param string $n - nome da propriedade a ser exibida
     * @return mixed valor da propriedade definida em $nom
     */
    public function __get($n){ return m_get($this, $n); } // Fim do método mágico __get



	/**
	 * Editar as propriedades da classe
	 *
	 * @param string $n Nome da propriedade a ser editada
	 * @param mixed  $v Valor a ser atribuído a propriedade
	 *
	 * @throws Exception
	 */
    public function __set($n, $v){
        switch($n):
            case 'arquivo':
                if( empty($v) || !file_exists($v) )
                    throw new Exception(ERRO_IMAGEM_NAO_ENCONTRADA, 1500);

                $this->arquivo = filter_var($v, FILTER_SANITIZE_STRING);

                # Obter as dimensões do arquivo original
                list($this->largura, $this->altura, $this->tipo,) = getimagesize($this->arquivo);
                break;

            case 'qldejpeg':
	            $this->qlde_jpeg = filter_var($v, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100]]);
                break;

            case 'qldepng':
                $this->qlde_png = filter_var($v, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 9]]);
                break;
        endswitch;
    } // Fim do método mágico __set



    /**
     * Tranparência da imagem
     */
    public function _transparencia(){
        # Configurar transparência
        imagealphablending($this->imagem, false);
        imagesavealpha($this->imagem, true);
    } // Fim do método _transparencia



    /**
     * Preparar a imagem para ser exibida ou salva
     */
    public function _preparar(){
        # Recriar a imagem de acordo com o tipo
        switch($this->tipo):
            case 1: return imagecreatefromgif($this->arquivo);
            case 2: default: return imagecreatefromjpeg($this->arquivo);
            case 3: return imagecreatefrompng($this->arquivo);
            case 6: return imagecreatefrombmp($this->arquivo);
        endswitch;
    } // Fim do método _preparar



	/**
	 * Redimensionar a imagem
	 *
	 * PS.: Se um dos 2 parâmetros não forem informados a imagem usará tamanho relativo
	 *
	 * @param int $l Nova largura da imagem
	 * @param int $a Nova altura da imagem
	 *
	 * @return resource
	 * @throws Exception
	 */
    public function _redimensionar($l = null, $a = null){
        if( empty($l) && empty($a) )
            throw new Exception(ERRO_IMAGEM_REDIMENSIONAR_INFORME_ALTURA_X_LARGURA, 1500);

        # Definir os valores finais para largura e altura
        $l = empty($l) ? ($a * $this->largura)/$this->altura : $l;
        $a = empty($a) ? ($this->altura * $l)/$this->largura : $a;

        # Criar a nova imagem com as dimensões finais
        $this->imagem = imagecreatetruecolor($l, $a);

        $this->_transparencia();

        # Caso a imagem seja GIF ou PNG prepara para utilizar
        # a transparência
        if( $this->tipo == 1 || $this->tipo == 3 )
            imagecolortransparent($this->imagem);

        # Copiar a imagem original e colocá-la
        # redimensionada em $imagem
        imagecopyresampled($this->imagem, $this->_preparar(), 0, 0, 0, 0, $l, $a, $this->largura, $this->altura);

        return $this->imagem;
    } // Fim do método _redimensionar



	/**
	 * Recortar a imagem
	 *
	 * @param int $l Nova largura da imagem
	 * @param int $a Nova altura da imagem
	 * @param int  $coord_x Coordenada do eixo X para início do recorte
	 * @param int  $coord_y Coordenada do eixo Y para fim do recorte
	 *
	 * @return resource
	 * @throws Exception
	 */
    public function _recortar($l = null, $a = null, $coord_x=0, $coord_y=0){
        if( empty($l) && empty($a) )
            throw new Exception(ERRO_IMAGEM_REDIMENSIONAR_INFORME_ALTURA_X_LARGURA, 1500);

        # Definir os valores finais para largura e altura
        $l = empty($l) ? ($a * $this->largura)/$this->altura : $l;
        $a  = empty($a) ? ($this->altura * $l)/$this->largura : $a;

        # Criar uma imagem em branco que servirá
        # como base para a nova imagem redimensionada
        $this->imagem = imagecreatetruecolor($l, $a);

        $this->_transparencia();

        # Copiar a imagem original e colocá-la
        # redimensionada na $nova_imagem
        imagecopy($this->imagem, $this->_preparar(), 0, 0, $coord_x, $coord_y, $l, $a);

        return $this->imagem;
    } // Fim do método _recortar



	/**
	 * Rotacionar a imagem
	 *
	 * @param int $graus Quantidade de graus a rotacionar a imagem
	 *
	 * @return resource
	 * @throws Exception
	 */
    public function _rotacionar($graus){
        if( empty($graus) || !is_numeric($graus) )
            throw new Exception(ERRO_IMAGEM_ROTACIONAR_GRAUS_INVALIDOS, 1500);

        # Rotacionar a nova imagem com transparência
        $this->imagem = imagerotate(
            $this->_preparar(),
            $graus,
            imagecolorallocatealpha($this->_preparar(), 0, 0, 0, 127)
        );

        $this->_transparencia();

        return $this->imagem;
    } // Fim do método _rotacionar



	/**
	 * Salvar a imagem em um arquivo
	 *
	 * @param string $arquivo Nome do arquivo a ser salvo
	 *
	 * @return bool
	 * @throws Exception
	 */
    public function _salvar($arquivo){
        if( empty($arquivo) )
            throw new Exception(ERRO_IMAGEM_SALVAR_POR_FAVOR_INFORME_NOME_ARQUIVO, 1500);

        switch($this->tipo):
            /* IMAGEM GIF */
            case 1: imagegif($this->imagem, $arquivo); break;

            /* IMAGEM JPG */
            case 2: imagejpeg($this->imagem, $arquivo, $this->qlde_jpeg); break;

            /* IMAGEM PNG */
            case 3: imagepng($this->imagem, $arquivo, $this->qlde_png); break;

            /* IMAGEM BMP */
            case 6: imagewbmp($this->imagem, $arquivo); break;

            default: echo 'Tipo de imagem não suportado pelo sistema!'; break;
        endswitch;

        # Destruir essa imagem e liberar o espaço em memória
        return imagedestroy($this->imagem);
    } // Fim do método _salvar



    /**
     * Salvar a imagem em um arquivo
     */
    public function _mostrar(){
        switch($this->tipo):
            /* IMAGEM GIF */
            case 1:
                # Caso o nome do arquivo não seja informado
                # a imagem será exibida diretamente. Para isso
                # será alterado o content-type da página
                header('Content-type: image/gif');

                imagegif($this->imagem);
                break;

            /* IMAGEM JPG */
            case 2:
                # Caso o nome do arquivo não seja informado
                # a imagem será exibida diretamente. Para isso
                # será alterado o content-type da página
                header('Content-type: image/jpeg');

                imagejpeg($this->imagem, null, $this->qlde_jpeg);
                break;

            /* IMAGEM PNG */
            case 3:
                # Caso o nome do arquivo não seja informado
                # a imagem será exibida diretamente. Para isso
                # será alterado o content-type da página
                header('Content-type: image/png');

                imagepng($this->imagem, null, $this->qlde_png);
                break;

            /* IMAGEM BMP */
            case 6:
                # Caso o nome do arquivo não seja informado
                # a imagem será exibida diretamente. Para isso
                # será alterado o content-type da página
                header('Content-type: image/bmp');

                imagewbmp($this->imagem);
                break;

            default: echo 'Tipo de imagem não suportado pelo sistema!'; break;
        endswitch;

        # Destruir essa imagem e liberar o espaço em memória
        return imagedestroy($this->imagem);
    } // Fim do método _mostrar
} // Fim da classe Imagem