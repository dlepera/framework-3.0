/**
 * Created by dlepera on 21/10/15.
 */

(function($){
	// Variáveis ---------------------------------------------------------------------------------------------------- //
	/**
	 * Armazenar as contagens de tempos das mensagens
	 * @type {Object}
	 */
	var msg_c = {};

	// Funções ------------------------------------------------------------------------------------------------------ //
	function esconderMsg(botao, funcao){
		var retorno = null;

		$(botao).parents('.__msg-plugin').fadeOut('fast', function(){
			$(this).remove();
			if( typeof funcao === 'function' ){ retorno = funcao(); }
		});

		return retorno;
	} // Fim function esconderMsg(botao)


	/**
	 * Mostrar mensagens para o usuário
	 *
	 * @param {object} opcoes Objeto com as configurações desejadas para aplicar
	 * @returns {*}
	 * @private
	 */
	$.fn._mostrarmsg = function(opcoes){
		var $th = $(this);

		// Opções padrão
		var padrao = {
			// Mensagem a ser mostrada
			mensagem: 'Português: Mensagem padrão!\nEnglish: Default menssage!',

			// Tipo de mensagem a ser mostrada
			// Obs: Também pode interferir na aparência da mensagem
			tipo: ['__msg-alerta', '__msg-atencao'],

			// Tempo que a mensagem deverá ser exibida em ms
			// @option int num - qntd de tempo em ms
			// @option bool exibir - define se será mostrado o tempo restante
			// para fechar a mensagem
			tempo: { num: 8000, exibir: true },

			// Botões adicionais
			// {
			// 	tipo: Tipo do botão: BUTTON, RESET, SUBMIT,
			//  texto: Texto a ser exibido no botão,
			// 	classe: Classe para definir o visual do botão,
			//  funcao: Função a ser executada pelo clique do botão
			// }
			botoes: [ { texto: 'Ok', classe: 'btn-principal', funcao: function(){ return true; } } ],

			// Aparência
			aparencia: { tema: plugin_formulario_tema || 'dl-formulario', estilo: 'mensagem' }

			// Animação que fará a mensagem aparecer
			// animacao: { mostrar: 'fadein', ocultar: 'fadeout', tempo: '1s' }
		};

		// Carregar as opções e mesclá-las com as opções padrao
		opcoes = $.extend({}, padrao, opcoes);

		// Carregar o tema para o formulário e seus elementos
		if( typeof(carregarCSS) === 'function' ){
			carregarCSS('web/js/min/dl-formulario/temas/' + opcoes.aparencia.tema + '/css/' + opcoes.aparencia.estilo + '.css');
		} // Fim if( typeof(carregarCSS) === 'function' )

		/**
		 * @var string evt_ns Nome do NAMESPACE a ser utilizado nos eventos
		 */
		var evt_ns = '__msg';

		/**
		 * @var string tema_pfx Prefixo a ser utilizado para aplicar o tema
		 */
		var tema_pfx = opcoes.aparencia.tema;


		// Criar os elementos da mensagem --------------------------------------------------------------------------- //
		// Recipiente da mensagem
		var $div = $(document.createElement('div')).addClass('__msg-plugin ' + tema_pfx + ' ' + opcoes.tipo.join(' ')).appendTo($th);

		// Parágrafo que conterá a mensagem
		var $paragr = $(document.createElement('p')).addClass(tema_pfx + '-paragr').appendTo($div);

		// Span que receberá o texto
		$(document.createElement('span')).addClass(tema_pfx + '-texto').html(opcoes.mensagem).appendTo($paragr);

		// Recipiente de botões
		var $botoes = $(document.createElement('div')).addClass(tema_pfx + '-botoes').appendTo($paragr);


		// Criar os botões ------------------------------------------------------------------------------------------ //
		var qtde_btn = opcoes.botoes.length, btn;

		for(var i = 0; i < qtde_btn; i++){
			btn = opcoes.botoes[i];

			$(document.createElement('button')).attr('type', 'button').text(btn.texto).addClass(tema_pfx + '-botao ' + (btn.classe || ''))
				.on('click.' + evt_ns, { funcao: btn.funcao }, function(evt){
					esconderMsg(this, evt.data.funcao);
				}).appendTo($botoes);
		} // Fim for


		// Tempo de exibição da mensagem ---------------------------------------------------------------------------- //
		// Configurar o tempo de exibição dessa mensagem
		setTimeout(function(){ $th.find('.btn-principal').trigger('click.' + evt_ns); }, opcoes.tempo.num);

		// Mostrar o tempo de exibição em contagem regressiva
		if( opcoes.tempo.exibir ){
			var $tmp = $(document.createElement('span')).addClass(tema_pfx + '-tempo')
				.html('Esta mensagem sumirá automaticamente em <b>' + opcoes.tempo.num / 1000 + '</b> segundos')
				.appendTo($div);

			var tmp_i = msg_c.length + 1;

			msg_c[tmp_i] = window.setInterval(function(){
				var $b = $tmp.find('b');
				var na = $b.text();

				if( na == 1 )
					window.clearTimeout(msg_c[tmp_i]);

				$b.text(na - 1);
			}, 1000);
		} // Fim if( opcoes.tempo.exibir )

		// Configurar a tecla ESC ----------------------------------------------------------------------------------- //
		$(window).on('keyup.' + evt_ns, function(evt){
			var kc = evt.keyCode || evt.charCode || evt.which;

			/*
			 * CORRIGIR: Tecla ENTER não funciona da maneira adequada
			 */
			if( /* kc === 13 || */kc === 27 )
				$th.find('.btn-principal').trigger('click.' + evt_ns);
		});

		return $div;
	};


	/**
	 * Exibir uma mensagem pedindo confirmação de uma ação
	 */
	$.fn._msgconfirmacao = function(opcoes){
		var $th = $(this);

		// Opções padrão
		var padrao = {
			// Título
			titulo: 'Confirmação',

			// Mensagem a ser mostrada
			mensagem: 'Português: Mensagem padrão!\nEnglish: Default menssage!',

			// Tipo de mensagem a ser mostrada
			// Obs: Também pode interferir na aparência da mensagem
			tipo: ['__msg-confirmacao'],

			// Botão confirmar / sim
			botao_sim: { texto: 'Sim', classe: 'btn-sim', funcao: function(){ return true; } },

			// Botão cancelar / não
			botao_nao: { texto: 'Não', classe: 'btn-nao btn-principal', funcao: function(){ return false; } },

			// Aparência
			aparencia: { tema: plugin_formulario_tema || 'dl-formulario', estilo: 'mensagem' }
		};

		// Carregar as opções e mesclá-las com as opções padrao
		opcoes = $.extend({}, padrao, opcoes);


		// Exibir a mensagem
		return $th._mostrarmsg({
			mensagem: '<span class="' + opcoes.aparencia.tema + '-titulo">' + opcoes.titulo + '</span>' + opcoes.mensagem,
			tipo: opcoes.tipo,
			botoes: [ opcoes.botao_sim, opcoes.botao_nao ],
			tempo: { num: 9999999999, exibir: false },
			aparencia: opcoes.aparencia
		});
	};
})(jQuery);
