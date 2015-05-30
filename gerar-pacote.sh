!#/bin/bash

# 
# Gerar pacote de nova instalação
# ----------------------------------------------------------------------------------------------------
# No pacote de instalção são inclusos apenas os arquivos necessários para um projeto.
# Alguns diretórios são ignorados, como .git e o bkp.
#


#
# Mapeamento de argumentos
# ----------------------------------------------------------------------------------------------------
#
# $1: número da versão. É utilizado para a geração do arquivo
#

if [ "$1" = "" ] 
then
 	echo "Por favor informe o número da versão"
	exit 0
fi

echo "Criando pacote "$1
echo "Incluindo os diretórios..."

tar -cf fw-dl-$1.tar _auto
tar -rf fw-dl-$1.tar _padroes
tar -rf fw-dl-$1.tar aplicacao
tar -rf fw-dl-$1.tar bd
tar -rf fw-dl-$1.tar biblioteca
tar -rf fw-dl-$1.tar config
echo "ok"

echo "Incluindo os arquivos..."

tar -rf fw-dl-$1.tar index.php robots.txt .htaccess .gitignore
echo "ok"

echo "Comprimindo o pacote com BZIP2..."
bzip2 -z fw-dl-$1.tar.bz2 fw-dl-$1.tar

echo "Finalizado!"
