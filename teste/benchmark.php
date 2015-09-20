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

function _array_serialize(){
	$a = ['var1' => 'teste1', 'variavle' => 'teste2', 'Teste 03'];

	echo '<p><b>http_build_query</b>:<br/>';

	$hri = microtime(true);
	$ret = urldecode(http_build_query($a, null, ' '));
	$hrf = microtime(true);

	echo $ret, '<br/>', $hrf - $hri, '</p>';

	echo '<p><b>array_map</b>:<br/>';

	$hri = microtime(true);
	$ret = implode(' ', array_map(function($k) use ($a){
		$vl = $k === 'pattern' ? \Funcoes::_expreg_form($a[$k]) : $a[$k];
		return isset($a) ? "{$k}=\"{$vl}\"" : null;
	}, array_keys($a)));
	$hrf = microtime(true);

	echo $ret, '<br/>', $hrf - $hri, '</p>';
} // Fim function _array_serialize()

function _concatenacao(){
	echo '<p><b>Concatenando</b>:<br/>';

	$hri = microtime(true);
	echo 'String' . ' ' . 'concatenada';
	$hrf = microtime(true);

	echo ' ', $hrf - $hri, '</p>';

	echo '<p><b>Sem concatenar</b>:<br/>';

	$hri = microtime(true);
	echo 'String', ' sem ', 'concatenar';
	$hrf = microtime(true);

	echo ' ', $hrf - $hri, '</p>';

	echo '<p><b>Concatenando</b>:<br/>';

	$var = 'Variavel';

	$hri = microtime(true);
	echo $var . ' ' . 'concatenada';
	$hrf = microtime(true);

	echo ' ', $hrf - $hri, '</p>';

	echo '<p><b>Sem concatenar</b>:<br/>';

	$hri = microtime(true);
	echo $var, ' sem ', 'concatenar';
	$hrf = microtime(true);

	echo ' ', $hrf - $hri, '</p>';
} // Fim function _concatencao()

function _echo_vs_print(){
	$var = 'TESTE';

	echo '<p><b>echo</b>:<br/>';
	$hri = microtime(true);
	echo 'STRING';
	$hrf = microtime(true);
	echo ' ', $hrf - $hri, '</p>';

	echo '<p><b>print()</b>:<br/>';
	$hri = microtime(true);
	print 'STRING';
	$hrf = microtime(true);
	echo ' ', $hrf - $hri, '</p>';


	echo '<p><b>echo</b>:<br/>';
	$hri = microtime(true);
	echo $var;
	$hrf = microtime(true);
	echo ' ', $hrf - $hri, '</p>';

	echo '<p><b>print()</b>:<br/>';
	$hri = microtime(true);
	print $var;
	$hrf = microtime(true);
	echo ' ', $hrf - $hri, '</p>';
} // Fim _echo_vs_print

// is_null_vs_isset();
// ifsimples_vs_and();
// file_exists_vs_is_file();
// _array_serialize();
// _concatenacao();
_echo_vs_print();