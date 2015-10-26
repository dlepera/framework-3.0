/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: Jul 28, 2014 10:33:24 AM
 */

/*global carregarCSS*/

(function($){
	// Variáveis ---------------------------------------------------------------------------------------------------- //
	var seletor_foto = '[class$="-fotos"] > [class$="-foto"]';
	var seletor_indic = '[class$="-fotos"] > [class$="-indic"]';

	// Funções ------------------------------------------------------------------------------------------------------ //
	function trocarFoto($galeria, foto, loop){
		var $foto = $galeria.find(seletor_foto);
		var $indic = $galeria.find(seletor_indic);
		var ultima = $foto.length - 1;
		var display = $foto.filter(':visible').css('display');

		if( foto < 0 || foto > ultima ){
			if( loop ){
				if( foto < 0 ){ foto = ultima; }
				else if( foto === ultima ){ foto = 0; }
			} else {
				return null;
			} // Fim if( loop )
		} // Fim if( foto < 0 || foto > ultima )

		// Mostrar a nova foto
		$foto.css('display', 'none')
			.filter(':eq(' + foto + ')').css('display', display);

		// Marcar o indicador da foto atual
		$indic.find('.link-atual').removeClass('link-atual');
		$indic.find('[class$="-link"]:eq(' + foto + ')').addClass('link-atual');
	} // Fim function trocarFoto($galeria, foto)


	// Plugin ------------------------------------------------------------------------------------------------------- //
	/**
	 * Iniciar e configurar a galeria de fotos
	 *
	 * @param {object} opcoes
	 * @returns {object} instância jquery do objeto selecionado
	 */
	$.fn._galeria = function(opcoes){
		var $th = $(this);

		// Definir os valores padrão para as opções / configurações do plugin
		var padrao = {
			// Definir se haverão as miniaturas das fotos
			minis: false,

			// Definir se haverão botões para controlar a navegação
			naveg: false,

			// Definir se será exibido o indicador
			indicador: false,

			// Objeto que contenha as informações (json) das fotos
			// src (obrigatório): caminho para a fotos
			// titulo (opcional): título a ser exibido da foto
			// descr (opcional): descrição a ser exibida juntamente com a foto
			// ir (opcional): link para onde a imagem deve direcionar ao ser clicada
			fotos: [],

			// Definir as informações de aparência do plugin
			// tema (obrigatório): nome do tema a ser utilizado
			// estilo (obrigatório): nome da folha de estilo que pertence ao
			// tema selecionado que deverá ser aplicada nessa galeria
			aparencia: { tema: 'galeria-2', estilo: 'galeria' },

			// Definir a auto troca de imagens, como numa apresentação de slides
			// ativar (obrigatório): ativar ou desativar a opção
			// tempo (obrigatório): tempo que a imagem será exibida antes de ser alterada
			// para a próxima
			autotroca: { ativar: false, tempo: 10000 },

			// Configurar a tecla ESC para remover (esconder) a galeria
			// Obs.: Utilizado para galerias no estilo LightBox
			teclaesc: false,

			// Criar um botão para fechar a galeria
			// Obs.: Utilizado para galerias no estilo LightBox
			botaofechar: false
		};

		// Unir os valores de configuração do usuário com os valores padrão
		opcoes = $.extend({}, padrao, opcoes);

		// Aplicar o tema do plugin
		if( typeof(carregarCSS) === 'function' ){
			carregarCSS('web/js/min/dl-galeria/temas/' + opcoes.aparencia.tema + '/css/' + opcoes.aparencia.estilo + '.css');
		} // Fim if( typeof(carregarCSS) === 'function' )

		$th.addClass('__fotos-plugin ' + opcoes.aparencia.tema + ' ' + opcoes.aparencia.estilo);

		/**
		 * Quantidade de fotos a serem incluídas na galeria
		 * @type {Number}
		 */
		var qtde_f = opcoes.fotos.length;

		/**
		 * Nome do namespace a ser aplicado nos eventos
		 * @type {string}
		 */
		var evt_ns = '__fotos';

		var tema_pfx = opcoes.aparencia.tema;

		// Fotos ---------------------------------------------------------------------------------------------------- //
		var i, foto, $foto, $infos;
		var $fotos = $(document.createElement('div')).addClass(tema_pfx + '-fotos').appendTo($th);

		// Criar as fotos
		for(i = 0; i < qtde_f; i++){
			foto = opcoes.fotos[i];

			$foto = $(document.createElement('figure')).addClass(tema_pfx + '-foto').appendTo($fotos);
			$(document.createElement('img')).addClass(tema_pfx + '-img')
				.attr({
					src: foto.src, title: foto.titulo
				})
				.appendTo($foto);

			if( foto.titulo || foto.descr ){
				$infos = $(document.createElement('figcaption')).addClass(tema_pfx + '-infos').appendTo($foto);

				if( foto.titulo ){
					$(document.createElement('p')).addClass(tema_pfx + '-titulo').text(foto.titulo).appendTo($infos);
				} // if( foto.titulo )

				if( foto.descr ){
					$(document.createElement('p')).addClass(tema_pfx + '-descr').text(foto.descr).appendTo($infos);
				} // Fim if( foto.descr )
			} // Fim if( foto.titulo || foto.descr )
		} // Fim for( i )

		var $minis = $fotos.clone().removeClass(tema_pfx + '-fotos').addClass(tema_pfx + '-minis');

		if( opcoes.naveg || opcoes.indicador ){
			var $links = $(document.createElement('a')).attr('href', 'javascript:').addClass(tema_pfx + '-link');

			// Navegação -------------------------------------------------------------------------------------------- //
			if( opcoes.naveg ){
				var $naveg = $(document.createElement('nav')).addClass(tema_pfx + '-naveg').appendTo($fotos);

				// Botão: Primeira foto
				$links.clone().addClass('link-primeira').text('|<').on('click.' + evt_ns, { DOM: $th }, function(evt){
					trocarFoto(evt.data.DOM, 0, false);
				}).appendTo($naveg);

				// Botão: Foto anterior
				$links.clone().addClass('link-anterior').text('<<').on('click.' + evt_ns, { DOM: $th }, function(evt){
					trocarFoto(
						evt.data.DOM,
						evt.data.DOM.find(seletor_foto + ':visible').index() - 1,
						false
					);
				}).appendTo($naveg);

				// Botão: Próxima foto
				$links.clone().addClass('link-proxima').text('>>').on('click.' + evt_ns, { DOM: $th }, function(evt){
					trocarFoto(
						evt.data.DOM,
						evt.data.DOM.find(seletor_foto + ':visible').index() + 1
					);
				}).appendTo($naveg);

				// Botão: Última foto
				$links.clone().addClass('link-ultima').text('>|').on('click.' + evt_ns, {
					DOM: $th,
					ultima: qtde_f - 1
				}, function(evt){
					trocarFoto(evt.data.DOM, evt.data.ultima, false);
				}).appendTo($naveg);
			} // Fim if( opcoes.naveg )


			// Indicadores ------------------------------------------------------------------------------------------ //
			if( opcoes.indicador ){
				var num;
				var $indic = $(document.createElement('nav')).addClass(tema_pfx + '-indic').appendTo($fotos);

				for(i = 0; i < qtde_f; i++ ){
					num = i + 1;
					$links.clone().addClass(num === 1 ? 'link-atual' : '').text(num).on('click.' + evt_ns, { DOM: $th, pos: num - 1 }, function(evt){
						trocarFoto(evt.data.DOM, evt.data.pos, false);
					}).appendTo($indic);
				} // Fim for( i )
			} // Fim if( opcoes.indicador )
		} // Fim if( opcoes.naveg || opcoes.indicador )


		// Miniaturas ----------------------------------------------------------------------------------------------- //
		if( opcoes.minis ){
			$minis.appendTo($th).find('> .' + tema_pfx + '-foto')
				.on('click.' + evt_ns, { DOM: $th }, function(evt){
					trocarFoto(evt.data.DOM, $(this).index(), false);
				}).each(function(){
					$(this).find('> .' + tema_pfx + '-infos').remove();
				});
		} // Fim if( opcoes.minis )


		// Tecla ESC ------------------------------------------------------------------------------------------------ //
		if( opcoes.teclaesc ){
			$(window).on('keyup.' + evt_ns, { DOM: $th }, function(evt){
				var kc = evt.keyCode || evt.charCode || evt.which;

				if( kc === 27 ){
					evt.data.DOM.fadeOut('fast');
				} // Fim if( kc === 27 )
			});
		} // Fim if( opcoes.teclaesc )


		// Botão fechar --------------------------------------------------------------------------------------------- //
		if( opcoes.botaofechar ){
			$(document.createElement('button')).attr('type', 'button').text('x fechar')
				.on('click.' + evt_ns, { DOM: $th }, function(evt){
					evt.data.DOM.fadeOut('fast');
				}).appendTo($th);
		} // Fim if( opcoes.botaofechar )


		// Configurar a auto-troca ---------------------------------------------------------------------------------- //
		if( opcoes.autotroca.ativar ){
			window.setInterval(function(){
				trocarFoto($th, $th.find(seletor_foto + ':visible').index() + 1, true);
			}, opcoes.autotroca.tempo);
		} // Fim if( opcoes.autotroca.ativar )
	};
})(jQuery);
