/**
 * Created by dlepera on 16/09/15.
 */

/*global console, selecionarLinha, alternarPublicacao, $logout, $el, carregarForm, carregarHTML*/

// Funções ---------------------------------------------------------------------------------------------------------- //
/**
 * Pedir uma confirmação antes de executar uma ação
 *
 * @param {String} msg Mensagem que solicita a confirmação
 * @param {Function} acao Função a ser executada em caso de confirmação positiva
 * @param {String} titulo Título a ser exibido na tela de confirmação
 * @returns {*}
 */
function executarConfirm(msg, acao, titulo){
	$('body')._msgconfirmacao({
		titulo: titulo || 'Confirmação',
		mensagem: msg,
		botao_sim: { texto: 'Sim', classe: 'btn-sim', funcao: function(){ return acao(); } },
		botao_nao: { texto: 'Não', classe: 'btn-nao btn-principal', funcao: function(){ return false; } }
	});

	return true;
} // Fim executarComfirm


function verificarAlteracao(campo){
	var $th = $(campo);
	var vlr_original = $th.attr('value');
	var vlr_atual = $th.val();

	$th.attr('data-alterado', (vlr_original !== vlr_atual) + 0);
} // Fim verificarAlteracao


// Encerrar a sessão do sistema ------------------------------------------------------------------------------------- //
$('#dl3-logout').on('click', function(){
	$logout === undefined ? console.warn('Formulário de logout não localizado!')
	 	: $logout.trigger('submit');
});


// Publicar ou ocultar um registro ---------------------------------------------------------------------------------- //
$('[data-acao="publicar-registro"], [data-acao="ocultar-registro"]').on('click.__acao', function(){
		var $th = $(this);

		// Selecionar a linha atual
		selecionarLinha(this, true);
		alternarPublicacao($th.data('acao-param-dir'));
});


// Excluir um registro ---------------------------------------------------------------------------------------------- //
$('[data-acao="excluir-registro"]').on('click.__acao', function(){
	var obj = this;

	return executarConfirm('Deseja realmente excluir esse(s) registro(s)?', function(){
		// Selecionar a linha atual
		selecionarLinha(obj, true);
		$el.submit();
	}, 'Confirmar exclusão');
});


// Testar configuração de e-mail ------------------------------------------------------------------------------------ //
$('[data-acao="testar-email"]').on('click.__acao', function(){
	var $th = $(this);
	$el._executar($th.data('acao-param-dir'), null, function(){ return null; });
});


// Bloquear / Desbloquear usuários ---------------------------------------------------------------------------------- //
$('[data-acao="bloquear-usuarios"], [data-acao="desbloquear-usuarios"]').on('click', function(){
	var $th = $(this);

	// Selecionar a linha atual
	selecionarLinha(this, true);
	$el._executar($th.data('acao-param-dir'), null, function(){ window.location.reload(); }, false);
});



// Carregar conteúdo HTML ------------------------------------------------------------------------------------------- //
$('[data-acao="carregar-html"]').on('click.__acao', function(){
	var $th = $(this);
	carregarHTML($th.data('acao-param-html'), 'html');
});

$('[data-acao="carregar-form"]').on('click.__acao', function(){
	var $th = $(this);
	var func = $th.data('acao-param-func') || 'window.location.reload()';

	carregarForm($th.data('acao-param-html'), 'form', function(){ eval('(' + func + ')'); });
});



// Verificar a alteração dos campos --------------------------------------------------------------------------------- //
$('[data-verificar-alteracao="1"]').on('change.__acao', function(){
	verificarAlteracao(this);
});



// Solicitar confirmação para submeter um formulário ---------------------------------------------------------------- //
function confirmarSubmit(dom, evt){
	var $th = $(dom);
	var $form = $th.parents('form');
	var msg = $th.data('acao-param-msg');

	if( $form[0].checkValidity() ){
		evt.stopPropagation();
		evt.preventDefault();

		executarConfirm(msg, function(){
			$form.find(':submit').off('.__acao').trigger('click')
				.on('click.__acao', function(evt){ confirmarSubmit(this, evt); });
		}, 'Confirmar ação');
	} // Fim if( $form[0].checkValidity() )
} // Fim function confirmarSubmit

$('[data-acao="confirmar-submit"]').on('click.__acao', function(evt){ confirmarSubmit(this, evt); });


// Aplicar máscaras automaticamente --------------------------------------------------------------------------------- //
$('[data-mask]').each(function(){
	var $th = $(this);
	$th._mascara($th.data('mask'));
});