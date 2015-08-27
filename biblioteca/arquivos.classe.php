<?php

/*
 * DL-Sites @ 2013
 * Projeto	: Framework MVC
 * Programador e idealizador: Diego Lepera
 * Descrição: Framework para facilitar o trabalho de criar sites e sistemas web
 * 				armazenando ações comuns para todos os sites
 */

class Arquivos{
	public static $extensoes = [
        /* Arquivos de imagens */
        'image/png' => 'png', 'image/jpeg' => 'jpg', 'image/pjpeg' => 'jpg', 'image/gif' => 'gif', 'image/bmp' => 'bmp',
        'image/x-windows-bmp' => 'bmp', 'image/fif' => 'fif', 'image/florian' => 'flo', 'image/x-icon' => 'ico', 'image/x-jps' => 'jps',

        /* Arquivos de vídeo */
        'application/x-troff-msvideo' => 'avi', 'video/avi' => 'avi', 'video/msvideo' => 'avi', 'video/x-msvideo' => 'avi', 'video/avs-video' => 'avs',
        'video/fli' => 'fli', 'video/x-fli' => 'fli', 'video/x-motion-jpeg' => 'mpeg', 'video/quicktime' => 'mov', 'video/x-sgi-movie' => 'movie',

        /* Arquivos de áudio */
        'application/x-midi'=>'mid', 'audio/midi'=>'mid', 'audio/x-mid'=>'mid', 'audio/x-midi'=>'mid', 'music/crescendo'=>'mid', 'x-music/x-midi'=>'midi',
        'audio/mod'=>'mod', 'audio/x-mod'=>'mod', 'audio/mpeg'=>'mp2', 'audio/x-mpeg'=>'mp2', 'video/mpeg'=>'mp3', 'video/x-mpeg'=>'mp3', 'video/x-mpeq2a'=>'mp2',
        'audio/mpeg3'=>'mp3', 'audio/x-mpeg-3'=>'mp3', 'audio/wav'=>'wav', 'audio/x-wav'=>'wav',

        /* Arquivos Compactados */
        'application/x-bzip'=>'bz', 'application/x-bzip2'=>'bz2', 'application/x-compressed'=>'gz', 'application/x-gzip'=>'gzip',
        'multipart/x-gzip'=>'gzip', 'application/x-tar' => 'tar', 'application/gnutar' => 'tgz',
        'image/x-tiff'=>'tif', 'application/x-zip-compressed' => 'zip', 'application/zip' => 'zip', 'multipart/x-zip'=>'zip',

        /* Pacote Office < 2007 */
        'application/msword' => 'doc', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template' => 'dotx', 'application/vnd.ms-word.document.macroEnabled.12' => 'docm',
        'application/vnd.ms-word.template.macroEnabled.12' => 'dotm', 'application/vnd.ms-excel' => 'xls',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.template' => 'xltx',
		'application/vnd.ms-excel.sheet.macroEnabled.12' => 'xlsm', 'application/vnd.ms-excel.template.macroEnabled.12' => 'xltm',
		'application/vnd.ms-excel.addin.macroEnabled.12' => 'xlam', 'application/vnd.ms-excel.sheet.binary.macroEnabled.12' => 'xlsb',
		'application/vnd.ms-powerpoint' => 'ppt', 'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
		'application/vnd.ms-powerpoint.addin.macroEnabled.12' => 'ppam', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12' => 'pptm',
		'application/vnd.ms-powerpoint.slideshow.macroEnabled.12' => 'ppsm',

		/* Open Office */
		'application/vnd.oasis.opendocument.text' => 'odt', 'application/vnd.oasis.opendocument.text-template' => 'ott',
		'application/vnd.oasis.opendocument.text-web' => 'oth', 'application/vnd.oasis.opendocument.text-master' => 'odm',
		'application/vnd.oasis.opendocument.graphics' => 'odg', 'application/vnd.oasis.opendocument.graphics-template' => 'otg',
		'application/vnd.oasis.opendocument.presentation' => 'odp', 'application/vnd.oasis.opendocument.presentation-template' => 'otp',
		'application/vnd.oasis.opendocument.spreadsheet' => 'ods', 'application/vnd.oasis.opendocument.spreadsheet-template' => 'ots',
		'application/vnd.oasis.opendocument.chart' => 'odc', 'application/vnd.oasis.opendocument.formula' => 'odf',
		'application/vnd.oasis.opendocument.database' => 'odb', 'application/vnd.oasis.opendocument.image' => 'odi',
		'application/vnd.openofficeorg.extension' => 'oxt',

		/* PDF */
		'application/pdf' => 'pdf',

        /* Desenvolvimento */
        'text/x-java-source' => 'java',

        /* Aplicações */
        'application/x-navimap' => 'map',

        /* Web */
        'text/html'=>'html', 'text/asp'=>'asp', 'application/php'=>'php', 'application/x-javascript'=>'js', 'application/x-httpd-imap'=>'imap', 'message/rfc822'=>'mht'
    ];
   	



	/**
	 * Criar um arquivo e inserir o conteúdo
	 *
	 * @param string $arquivo Diretório e nome onde o arquivo será salvo
	 * @param string $conteudo Conteúdo a ser inserido no arquivo
	 *
	 * @return bool
	 */
    public static function _criartxt($arquivo, $conteudo){
        # Verificar se o diretório informado tem permissão para
        # escrita
        // if( !Arquivos::_permissao(dirname($arquivo)) )
        //    return true;

        # Criar e abrir o arquivo para escrita
        $a = fopen($arquivo, 'w+');

        # Escrever o conteúdo no arquivo
        $e = fwrite($a, $conteudo);

        # Fechar o arquivo
        fclose($a);

        return !$e ? false : true;
    } // Fim do método _criartxt




	/**
	 * Obter informações sobre um arquivo específico
	 *
	 * @param string $caminho Caminho para o arquivo
	 *
	 * @return array
	 */
    public static function _obterinfos($caminho=''){
        # Obter nome
        $nome = end(explode('.', basename($caminho)));
        
        if( extension_loaded('fileinfo') ):
            $fo = finfo_open();
            
            $mimetype   = finfo_file($fo, $caminho, FILEINFO_MIME_TYPE);
            $mimeencode = finfo_file($fo, $caminho, FILEINFO_MIME_ENCODING);
        else:
            # Obter o Mime-Type
            $mimetype = mime_content_type($caminho);

            # Obter o encode
            # ** Sem o finfo não foi possível encontrar o ENCODE do arquivo
            $mimeencode = '';
        endif;

        # Obter a extensão
        $extensao = self::$extensoes[$mimetype];

        # Obter o tamanho do arquivo
        $tamanho = sprintf('%u', filesize($caminho)); // Previnindo para arquivos com tamanho maior que 2GB

        return [
            'nome'	=> $nome,
            'mime-type'	=> $mimetype,
            'encoding'	=> $mimeencode,
            'extensao'	=> $extensao,
            'tamanho'	=> $tamanho
        ];
    } // Fim do método _obterinfos
	



	/**
	 * Remover diretórios, com a opção de remover os arquivos dentro dos
	 * diretórios de maneira recursiva. Semelhante ao rm -r do linux
	 *
	 * @param string $diretorio        Caminho para o diretório a ser removido
	 * @param bool   $remover_conteudo Define se o conteúdo do diretório será removido
	 *
	 * @return bool
	 */
    public static function _removerdir($diretorio, $remover_conteudo = false){
        # Ler os arquivos dentro do diretório
        $ls = scandir($diretorio);

        if( $ls > 0 && !$remover_conteudo )
            return false;

        if( $ls > 0 ):
            # Filtrar diretórios ocultos
            $ls = preg_grep('#^[^\.]#', $ls);

            # Percorrer arquivo a arquivo para remover
            foreach( $ls as $linha ):
                $arquivo = "{$diretorio}/{$linha}";

                if( is_file($arquivo) )
                    unlink($arquivo);
                elseif( is_dir($arquivo) )
                    self::_removerdir($arquivo, true);
            endforeach;
        endif;

        return rmdir($diretorio);
    } // Fim do método _removerdir
} // Fim da classe Arquivos
