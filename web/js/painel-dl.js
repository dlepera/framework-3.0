/**
 * Created by dlepera on 16/09/15.
 */


// Funções ---------------------------------------------------------------------------------------------------------- //
/**
 * Pedir uma confirmação antes de executar uma ação
 *
 * @param {String} msg Mensagem que solicita a confirmação
 * @param {Function} acao Função a ser executada em caso de confirmação positiva
 * @returns {*}
 * @constructor
 */
function ExecutarConfirm(msg, acao){
	if( confirm(msg) ) return acao();
	return true;
} // Fim ExecutarComfirm


// Encerrar a sessão do sistema ------------------------------------------------------------------------------------- //
$('#dl3-logout').on('click', function(){
	$logout === undefined
		? console.warn('Formulário de logout não localizado!')
	 	: $logout.trigger('submit');
});


// Publicar ou ocultar um registro ---------------------------------------------------------------------------------- //
$('[data-acao="publicar-registro"], [data-acao="ocultar-registro"]').on('click', function(){
		var $th = $(this);

		// Selecionar a linha atual
		SelecionarLinha(this, true);
		AlternarPublicacao($th.data('acao-param-dir'));
});


// Excluir um registro ---------------------------------------------------------------------------------------------- //
$('[data-acao="excluir-registro"]').on('click', function(){
	var obj = this;

	return ExecutarConfirm('Deseja realmente excluir esse(s) registro(s)?', function(){
		// Selecionar a linha atual
		SelecionarLinha(obj, true);
		$el.submit();
	});
});


// Testar configuração de e-mail ------------------------------------------------------------------------------------ //
$('[data-acao="testar-email"]').on('click', function(){
	var $th = $(this);
	$el._executar($th.data('acao-param-dir'), null, function(){ return null; });
});


// Bloquear / Desbloquear usuários ---------------------------------------------------------------------------------- //
$('[data-acao="bloquear-usuarios"], [data-acao="desbloquear-usuarios"]').on('click', function(){
	var $th = $(this);

	// Selecionar a linha atual
	SelecionarLinha(this, true);
	$el._executar($th.data('acao-param-dir'), null, function(){ window.location.reload(); }, false);
});



// Carregar conteúdo HTML ------------------------------------------------------------------------------------------- //
$('[data-acao="carregar-html"]').on('click', function(){
	var $th = $(this);
	CarregarHTML($th.data('acao-param-html'), 'html');
});

$('[data-acao="carregar-form"]').on('click', function(){
	var $th = $(this);
	var func = $th.data('acao-param-func') || 'window.location.reload()';

	CarregarForm($th.data('acao-param-html'), 'form', function(){ eval('(' + func + ')'); });
});