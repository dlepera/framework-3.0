<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 17/07/15
 * Time: 15:37
 */

/*
$hri = microtime(true);
const NOME_CONSTANTE2 = 'VALOR_CONSTANTE';
$hrf = microtime(true);

echo 'const: ', $hrf - $hri, '<br/>';

$hri = microtime(true);
define('NOME_CONSTANTE', 'VALOR_CONSTANTE');
$hrf = microtime(true);

echo 'define: ', $hrf - $hri, '<br/>';
*/

function is_null_vs_isset(){
	$vazio = '';
	$nulo = null;
	$bool = true;
	$vetor = [];

	$vars = get_defined_vars();

	foreach( $vars as $n => &$v ){
		echo "\${$n}: <br/><p>";

		$hri = microtime(true);
		is_null($v);
		$hrf = microtime(true);

		echo 'is_null(): ', $hrf - $hri, '<br/>';


		$hri = microtime(true);
		isset($v);
		$hrf = microtime(true);

		echo 'isset(): ', $hrf - $hri, '</p>';
	}
} // Fim function is_null_vs_isset()

function ifsimples_vs_and(){
	$hri = microtime(true);
	if( true ) print('Teste');
	$hrf = microtime(true);

	echo 'if( true ) print(Teste): ', $hrf - $hri, '<br/>';

	$hri = microtime(true);
	if( false ) print('Teste');
	$hrf = microtime(true);

	echo 'if( false ) print(Teste): ', $hrf - $hri, '<br/>';

	$hri = microtime(true);
	true and print('Teste');
	$hrf = microtime(true);

	echo 'true and print(Teste): ', $hrf - $hri, '<br/>';

	$hri = microtime(true);
	true and print('Teste');
	$hrf = microtime(true);

	echo 'false and print(Teste): ', $hrf - $hri, '<br/>';
} // Fim ifsimples_vs_and

function file_exists_vs_is_file(){
	$n_existe = 'arquivo/nao/existe';
	$existe = 'index.php';

	$vars = get_defined_vars();

	foreach( $vars as $n => &$v ){
		$hri = microtime(true);
		$f = file_exists($v);
		$hrf = microtime(true);

		echo "file_exsits(\${$n}) = ",  var_export($f, true),': ', $hrf - $hri, '<br/>';

		$hri = microtime(true);
		$f = is_file($v);
		$hrf = microtime(true);

		echo "is_file(\${$n}) = ",  var_export($f, true),': ', $hrf - $hri, '<br/><br/>';
	} // Fim foreach
} // Fim function file_exists_vs_is_file()



// is_null_vs_isset();
// ifsimples_vs_and();
// file_exists_vs_is_file();