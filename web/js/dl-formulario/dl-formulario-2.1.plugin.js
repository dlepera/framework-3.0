/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/08/2014 11:53:56
 */

(function($){
	// Variáveis ---------------------------------------------------------------------------------------------------- //

	// Receber os arquivo para upload e gravar os nomes dos
	// campos para não perder a referência
	var up_n = [];
	var up_a = [];


	// Gravar o tempo de exibição da mensagem
	// var msg_t = [];
	var msg_c = {};

	// Funçoes ------------------------------------------------------------------------------------------------------ //
	// _formulario -------------------------------------------------------------------------------------------------- //

	/**
	 * Função que será utilizada para tratar a resposta
	 *
	 * @param {string} rt Resposta do servidor após o envio da requisição
	 */
	function TratarResposta(rt){
		// Remover espaços em branco
		var r = rt.trim();
		var msg, ret;

		// Verificar se a resposta é um conteúdo JSON
		if( /^[?\[{]{1,}(.+)[}\]{1,}]?$/.test(r) ){
			var json = $.parseJSON(r);
			json = /^\[/.test(r) ? json[json.length - 1] : json;

			msg = json.mensagem;
			ret = json.tipo;
		} else {
			msg = r;
			ret = 'atencao';
		} // Fim if( expreg.test(r) )

		return { msg: msg, ret: ret };
	} // Fim function TratarResposta(r)


	// _mascara ----------------------------------------------------------------------------------------------------- //

	/**
	 * Converter um formato de máscara para um formato humano
	 *
	 * @param {string} msk Máscara a ser convertida
	 * @returns {XML|string|*|void}
	 * @constructor
	 */
	function ConvMask(msk){ return msk.replace(/#/g, '_'); }


	/**
	 * Obter os elementos presentes na máscara
	 *
	 * @param {string} msk Máscara a ser analisada
	 * @returns {XML|string|*|void}
	 * @constructor
	 */
	function ElemMask(msk){
		var e_msk = msk.replace(/[#_]/g, '');
			e_msk = /[a-zA-Z]/.test(msk) ? '('+ e_msk +')' : '['+ e_msk +']';

		return new RegExp(e_msk, 'g');
	} // function ElemMask(msk)


	/**
	 * Limpar o valor
	 *
	 * @param {string} v Valor a ser tratado
	 * @param {string} m Máscara a ser considerada para a limpeza
	 *
	 * @returns {string}
	 * @constructor
	 */
	function LimparVlr(v, m){ return v.replace(ElemMask(m), '').replace(/_/g, ''); }


	/**
	 * Aplicar uma máscara em uma string
	 *
	 * @param {string} v String a ser mascarada
	 * @param {string} m Máscara a ser aplicada
	 * @returns {string}
	 * @constructor
	 */
	function AplicarMascara(v, m){
		var s_msk = LimparVlr(v, m);
		var c_msk = m;
		var qt_sm = s_msk.length;

		for(var i = 0; i < qt_sm; i++)
			c_msk = c_msk.replace('_', s_msk[i]);

		return c_msk;
	} // Fim do método _AplicarMascara


	// Plugins ------------------------------------------------------------------------------------------------------ //
	/**
	 * Serialize personalizado
	 *
	 * @returns {string} String serializada com o & para envio de dados via formulário
	 * @private
	 */
	$.fn._serialize = function(){
		/**
		 * Selector dos elementos do formulário
		 * @type {string}
		 */
		var elem = 'input:not(:file), select, textarea';

		var s = [];

		var $th = $(this);
		var $it = $.merge($th.filter('form').find(elem), $th.filter(elem));

		$it.each(function(){
			var n = this.name;
			var t = this.type;
			var v = this.value;

			switch(t){
				case 'checkbox':
					if( v === 'on' )
						v = this.checked ? 'on' : 'off';
					else if( !this.checked ) return;
					break;

				case 'radio':
					if( !this.checked ) return;
					break;
			} // Fim switch(t)

			s.push(n +'='+ v);
		});

		return s.join('&');
	}; // Fim plugin $.fn._serialize = function()


	/**
	 * Submeter formulário via AJAX e realizar validações adicionais
	 *
	 * @param {object} opcoes Objeto com as configurações desejadas para aplicar
	 * @returns {*}
	 * @private
	 */
	$.fn._formulario 	= function(opcoes){
		// Valores padrão para as opções desse plugin
		var padrao = {
			// @option {string} controle - controle (action) a ser utilizado no submit do formulário
			controle: '',

			// @option {string} namespace Nome do namespace utilizado para configurar eventos
			namespace: '__form',

			// @option {function} antes - função a ser executada antes do submit do formulário, simulando
			// o evento 'onsubmit' original
			antes: function(){ return true; },

			// @option {function} depois - função a ser executada APÓS o submit
			depois: function(){ return true; },

			// Aparência do formulário e dos seus elementos,
			// que serão definidos por uma classe
			aparencia: { tema: 'dl-formulario', estilo: 'formulario' },

			// Definir um checkbox para selecionar os demais
			cktodos: [false, ':checkbox:first', ':checkbox[name^="[]"]']
		};

		// Carregar as opções e mesclá-las com as opções padrao
		opcoes = $.extend({}, padrao, opcoes);

		// Carregar o tema para o formulário e seus elementos
		if( opcoes.aparencia !== null ){
			if( typeof(CarregarCSS) === 'function' )
				CarregarCSS('web/js/dl-formulario/css/'+ opcoes.aparencia.tema +'/'+ opcoes.aparencia.estilo +'.css');
		} // if( opcoes.aparencia !== null )

		// Configurar a funcionalidade "Selecionar todos"
		if( opcoes.cktodos[0] ){
			var $slc = $(opcoes.cktodos[1]);
			var $slv = $(opcoes.cktodos[2]);

			$slc.click(function(){
				$slv.each(function(){ this.checked = $slc.prop('checked'); });
			});
		} // Fim if( cktodos[0] )

		return $(this).each(function(){
			var $th = $(this);

			// Organizar a navegação pela tecla TAB
			$th.find('input:not(:hidden):not([readonly]), select, textarea')
				.each(function(i){ $(this).attr({ tabindex: i + 1 }); });

			// Definir o controle a ser executado
			if( opcoes.controle === '' )
				opcoes.controle = $th.attr('action');

			// Verificar se será feito algum upload com esse formulário
			var upload = $th.attr('enctype') === 'multipart/form-data' && $th.find(':file').length > 0;

			// Adicionar os arquivos para upload
			if( upload ){
				$th.find(':file').on('change', function(evt){
					var nome = this.name;

					$.each(evt.target.files, function(k, v){
						up_n.push(nome);
						up_a.push(v);
					});
				});
			} // Fim if( upload )

			// Realizar a verificação adicional dos campos
			$th.find('[data-vld-func]').on('change', function(){
				var $th = $(this);
				var fnc = window[$th.data('vld-func')];
				var msg = $th.data('vld-msg');
				var vlr = $th.val();

				// Verificar se a função informada existe e se é mesmo uma função
				if( typeof fnc !== 'function' ){
					console.error('A função '+ fnc +' não existe ou não pode ser acessada!');
					return false;
				} // Fim if( typeof fnc !== 'function' )

				if( vlr !== '' ){
					if( !fnc(vlr) ) this.setCustomValidity(msg);
					else this.setCustomValidity('');
				} else this.setCustomValidity('');
				// Fim if( this.value != '' )
			}).trigger('change');

			$th.unbind('.'+ opcoes.namespace)
				.on('submit.'+ opcoes.namespace, function(evt, controle, antes, depois){
				// Evitar o submit comum do form
				evt.stopPropagation();
				evt.preventDefault();

				// Simular o evento 'onsubmit'
				if( !opcoes.antes() || (typeof antes === 'function' && !antes()) ) return false;

				// Incluir os arquivos
				if( upload ){
					var ofd = new FormData();
					$.each(up_a, function(k, v){ ofd.append(up_n[k], v); });

					// Incluir os arquivos normais
					$.each($th._serialize().split('&'), function(k, v){
						var er = /^([\w\-]+)=(.+)?$/;

						if( er.test(v) ){
							var dd = er.exec(v);
							ofd.append(dd[1], dd[2]);
						} // Fim if( er.test(v) )
					});
				} // Fim if( upload )

				$.ajax({
					url         : controle || opcoes.controle,
					type        : 'post',
					data        : ofd || $th._serialize(),
					cache       : false,
					processData : !upload,
					contentType : upload ? false : 'application/x-www-form-urlencoded',
					success     : function(dados){
						var resp = TratarResposta(dados);

						$('body')._mostrarmsg({
							mensagem    : resp.msg,
							tipo        : ['alerta', resp.ret],
							botao       : { texto: 'x', funcao: resp.ret === 'msg-sucesso' ? depois || opcoes.depois : function(){ return false; } },
							aparencia   : { tema: opcoes.aparencia.tema, estilo: 'mensagem' }
						});
					}
				});
			});

			return $th;
		});
	};

	$.fn._executar 		= function(controle, antes, depois){
		return this.each(function(){
			$(this).trigger('submit', [controle, antes, depois]);
		});
	};


	/**
	 * Aplicar máscara em um campo de formulário
	 *
	 * @param {string} msk Máscara
	 * @returns {*|HTMLElement}
	 * @private
	 */
	$.fn._mascara = function(msk){
		var $th = $(this);

		/**
		 * Evento a ser usado para aplicar a máscara
		 * @type {string}
		 */
		var evt_on = 'keydown';

		/**
		 * Nome do name space a ser utilizado
		 * @type {string}
		 */
		var evt_ns = '__msk';

		/**
		 * Máscara convertida para exibição
		 * @type {string}
		 */
		var msk_c = ConvMask(msk);

		$th.unbind('.'+ evt_ns).on(evt_on +'.'+ evt_ns, function(){
			var evt	= window.event || event;
			var kc  = evt.keyCode || evt.charCode || evt.which;
			var mod = evt.metaKey || evt.ctrlKey;

			if( !mod && kc > 47 && kc < 90 )
				this.value = AplicarMascara(this.value + String.fromCharCode(kc), msk_c);

			var pos_ = this.value.indexOf('_');

			if( pos_ > -1 ) MoverCursor(this, pos_);
		})
			.on('focus.'+ evt_ns, function(){ this.value = AplicarMascara(this.value, ConvMask(msk)); })
			.on('blur.'+ evt_ns, function(){
				var msk_c = ConvMask(msk);
				this.value = this.value === msk_c ? '' : AplicarMascara(this.value, msk_c);
			})
			.on('paste.'+ evt_ns, function(){ this.value = LimparVlr(this.value, msk); })
			.attr('maxlength', msk.length).prop('autocomplete', false);

		return $th;
	}; // Fim do plugin _dlmascara


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
			tipo: ['alerta', 'atencao'],

			// Tempo que a mensagem deverá ser exibida em ms
			// @option int num - qntd de tempo em ms
			// @option bool exibir - define se será mostrado o tempo restante
			// para fechar a mensagem
			tempo: { num: 8000, exibir: true },

			// Texto a ser exibido no botão
			botao: { texto: 'Ok', funcao: function(){ return true; } },

			// Aparência
			aparencia: { tema: 'dl-formulario', estilo: 'mensagem' }

			// Animação que fará a mensagem aparecer
			// animacao: { mostrar: 'fadein', ocultar: 'fadeout', tempo: '1s' }
		};

		// Carregar as opções e mesclá-las com as opções padrao
		opcoes = $.extend({}, padrao, opcoes);

		// Carregar o tema para o formulário e seus elementos
		if( typeof(CarregarCSS) === 'function' ){
			CarregarCSS('web/js/dl-formulario/temas/'+ opcoes.aparencia.tema +'/css/'+ opcoes.aparencia.estilo +'.css');
			CarregarCSS('web/js/dl-formulario/temas/'+ opcoes.aparencia.tema +'/css/animacoes.css');
		} // Fim if( typeof(CarregarCSS) === 'function' )

		// Incluir a classe para o formulário
		$th.addClass(opcoes.aparencia.tema);

		/**
		 * Prefixo das classes utilizadas para aplicar o tema
		 * @type {string}
		 */
		var c_pfx = opcoes.aparencia.tema.replace('.', '-');

		var classes = {
			div 	: c_pfx +'-div '+ opcoes.tipo.join(' '),
			paragr 	: c_pfx +'-paragr',
			botao	: c_pfx +'-botao',
			tempo	: c_pfx +'-tempo'
		};


		/**
		 * Nome do name space a ser utilizado
		 * @type {string}
		 */
		var evt_ns = '__msg';


		// Criar uma div para exibir a mensagem
		var $div = $(document.createElement('div')).addClass(classes.div).appendTo($th);

		// Criar o parágrafo que conterá a mensagem
		var $p = $(document.createElement('p')).addClass(classes.paragr).html(opcoes.mensagem).appendTo($div);

		// Criar o botão
		var $btn = $(document.createElement('button')).addClass(classes.botao).text(opcoes.botao.texto).attr('type', 'button')
			.on('click.'+ evt_ns, function(){
				// Esconder a mensagem
				$(this).parents('div').fadeOut('fast', function(){
					$(this).remove();
					$th.removeClass(opcoes.aparencia.tema);

					if( typeof opcoes.botao.funcao === 'function' )
						opcoes.botao.funcao();
				});
			}).appendTo($p);

		// Configurar o tempo de exibição dessa mensagem
		setTimeout(function(){ $btn.trigger('click'); }, opcoes.tempo.num);

		// Mostrar o tempo de exibição em contagem regressiva
		if( opcoes.tempo.exibir ){
			var $tmp = $(document.createElement('span')).addClass(classes.tempo)
				.html('Esta mensagem sumirá automaticamente em <b>'+ opcoes.tempo.num / 1000 +'</b> segundos')
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

		return $th;
	};
})(jQuery);