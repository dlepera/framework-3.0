#!/bin/sh

tar -cjvf atualizar.tar.bz2 $( git diff --name-only $1 );
