/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/08/2014 11:53:56
 */

document.write('<script src="' + dir_relativo + 'web/js/min/dl-formulario/mostrarmsg.plugin-min.js"></script>');
document.write('<script src="' + dir_relativo + 'web/js/min/dl-formulario/mascara.plugin-min.js"></script>');

(function($){
	// Variáveis ---------------------------------------------------------------------------------------------------- //
	// Receber os arquivo para upload e gravar os nomes dos
	// campos para não perder a referência
	var up_n = [];
	var up_a = [];

	// Funçoes ------------------------------------------------------------------------------------------------------ //
	// _formulario -------------------------------------------------------------------------------------------------- //
	/**
	 * Função que será utilizada para tratar a resposta
	 *
	 * @param {string} rt Resposta do servidor após o envio da requisição
	 * @returns {{msg: *, ret: *}}
	 */
	function tratarResposta(rt){
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
	} // Fim function tratarResposta(r)


	/**
	 * Submeter o formulário
	 *
	 * @param {jQuery} $form Instância jQuery do formulário
	 * @param {String} controle Controle a ser executado
	 * @param {Boolean} upload Informa se está sendo feito upload de arquivos
	 * @param {Function} depois Função a ser executada após o submit
	 */
	function formSubmit($form, controle, upload, depois){
		// Incluir os arquivos
		if( upload ){
			var ofd = new FormData();
			$.each(up_a, function(k, v){ ofd.append(up_n[k], v); });

			// Incluir os arquivos normais
			$.each($form._serialize().split('&'), function(k, v){
				var er = /^([\w\-\[\]]+)=(.+)?$/;

				if( er.test(v) ){
					var dd = er.exec(v);
					ofd.append(dd[1], dd[2] || '');
				} // Fim if( er.test(v) )
			});
		} // Fim if( upload )

		$.ajax({
			url: controle,
			type: 'post',
			data: ofd || $form._serialize(),
			cache: false,
			processData: !upload,
			contentType: upload ? false : 'application/x-www-form-urlencoded',
			success: function(dados){
				var resp = tratarResposta(dados);

				$('body')._mostrarmsg({
					mensagem: resp.msg,
					tipo: ['__msg-alerta', resp.ret],
					botoes: [{
						texto: 'x',
						classe: 'btn-principal',
						funcao: resp.ret === '__msg-sucesso' ? depois
							: function(){ return false; }
					}]
				});
			}
		});
	} // Fim function formSubmit($form, controle, upload, depois)


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
			var v = encodeURIComponent(this.value);

			switch(t){
				case 'checkbox':
					if( v === 'on' ){ v = this.checked ? 'on' : 'off'; }
					else if( !this.checked ){ return; }
					break;

				case 'radio':
					if( !this.checked ){ return; }
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
	$.fn._formulario = function(opcoes){
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
		/* if( opcoes.aparencia !== null ){
			if( typeof(carregarCSS) === 'function' )
				carregarCSS('web/js/dl-formulario/css/'+ opcoes.aparencia.tema +'/'+ opcoes.aparencia.estilo +'.css');
		} // if( opcoes.aparencia !== null ) */

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
			if( opcoes.controle === '' ){
				opcoes.controle = $th.attr('action');
			} // Fim if( opcoes.controle === '' )

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

			/*
			 * CORRIGIR: Quando uma máscara é aplicada no campo o evento change deixa de funcionar
			 */
			// Realizar a verificação adicional dos campos
			$th.find('[data-vld-func]').off('.' + opcoes.namespace)
				.on('change.' + opcoes.namespace +' blur.'+ opcoes.namespace, function(evt){
					var $th = $(this);
					var _this = evt.target;
					var fnc = window[$th.data('vld-func')];
					var msg = $th.data('vld-msg');
					var vlr = this.type === 'file' ?
					{ arq: _this.files, exts: $th.data('vld-exts'), max: $th.data('vld-max') }
						: $th.val();

					// Verificar se a função informada existe e se é mesmo uma função
					if( typeof fnc !== 'function' ){
						console.error('A função ' + fnc + ' não existe ou não pode ser acessada!');
						return false;
					} // Fim if( typeof fnc !== 'function' )

					return formValidacao(vlr !== '' && !fnc(vlr), _this, msg);
				}).trigger('change.' + opcoes.namespace);

			$th.find(':submit').on('click.' + opcoes.namespace, function(){
				var $form = $(this).parents('form');
				var $invi = $form.find('[required]:not(:visible)');

				// Desabilitar os campos que não podem ser focalizados
				$invi.prop('disabled', true);

				// Executar a validação HTML5
				if( !$form[0].checkValidity() ){
					// Reabilitar os campos que não podem ser visualizados
					$invi.prop('disabled', false);
				} // Fim if( !$form[0].checkValidity() )
			});

			$th.off('.' + opcoes.namespace)
				.on('submit.' + opcoes.namespace, function(evt, controle, antes, depois){
					// Evitar o submit comum do form
					evt.stopPropagation();
					evt.preventDefault();

					// Simular o evento 'onsubmit'
					if( !opcoes.antes() || (typeof antes === 'function' && !antes()) ){ return false; }

					// Verificar campos que foram marcados para alteração
					var $nao_alterados = $th.find('[data-verificar-alteracao="1"][data-alterado="0"]');

					if( $nao_alterados.length > 0 ){
						$('body')._msgconfirmacao({
							titulo: 'Alteração de informações',
							mensagem: 'Você não alterou algum(ns) campo(s) necessários.<br/><br/>Deseja continuar assim mesmo?',
							botao_sim: { texto: 'Sim', classe: 'btn-sim', funcao: function(){ formSubmit($th, controle || opcoes.controle, upload, depois || opcoes.depois); } },
							botao_nao: { texto: 'Não', classe: 'btn-nao btn-principal', funcao: function(){ return false; } }
						});
					} else { formSubmit($th, controle || opcoes.controle, upload, depois || opcoes.depois); }
					// Fim if( $th.find('[data-verificar-alteracao="1"][data-alterado="0"]').length )
				});

			return $th;
		});
	};

	$.fn._executar = function(controle, antes, depois, validacao){
		return this.each(function(){
			if( !validacao || (this.validity && this.checkValidity()) ){
				$(this).trigger('submit', [controle, antes, depois]);
			} // Fim if( !validacao || (this.validity && this.checkValidity()) )
		});
	};
})(jQuery);