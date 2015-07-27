
(function($){
	// Funçoes ------------------------------------------------------------------------------------------------------ //
	// Encontrar a página atual
	function $_PAGINA(){
		// Obter a busca da URL atual
		var URL = window.location.search;

		// Expressão regular para identificar a página atual
		var er = /(pg){1}\=([\d]*)*/i;
		var rt = er.exec(URL);

		// Retornar o valor da variável
		return rt === null ? 1 : parseInt(rt[rt.length - 1]);
	} // Fim function $_PAGINA()


	// Direcionar a uma página de resultados específica
	function $_IRPARA(pg){
		// Obter a hash e a busca da URL atual
		var URL 	= window.location.toString();
		var busca 	= window.location.search;

		// Verificar se dentro da busca atual já está sendo especificada
		// alguma página e em caso positivo remover
		if( URL.indexOf('pg=') > -1 )
			URL = URL.replace(/pg=\d+/, 'pg='+ pg);
		else
			URL += busca === '' ? '?pg='+ pg : '&pg='+ pg;

		window.location = URL;
	} // Fim function $_IRPARA(pg)


	// Plugins ------------------------------------------------------------------------------------------------------ //
    /**
     * Plugin jQuery para criar os botões de paginação de resultados
     * 
     * @param {Object} opcoes
     * @returns {Object|$}
     */
    $.fn._paginacao = function(opcoes){
        // Armazenar o objeto
        var $th = $(this);
        
        // Definir os padrões
        var padroes = {
            pgatual     : $_PAGINA(),
            pgtotal     : 10,
            exibir      : 5,
            loop		: true,
            mostrar		: 0, // 0 => mostrar todas as páginas
            btn_numeros	: true,
            btn_primeira: true,
            btn_ultima	: true,
            btn_proxima	: true,
            btn_anterior: true,
            tema 		: 'painel-dl'
        };

        // Sobrescrever
        opcoes = $.extend({}, padroes, opcoes);
        
        // Carregar o tema para o formulário e seus elementos
        if( opcoes.aparencia !== null ){
            if( typeof CarregarCSS === 'function' )
                CarregarCSS('web/js/dl-paginacao/temas/'+ opcoes.tema +'/css/'+ opcoes.tema +'.css');

            // Incluir a classe para o formulário
            $th.addClass(opcoes.tema);
        } // if( opcoes.aparencia !== null )


		/**
		 * Prefixo das classes utilizadas para aplicar o tema
		 * @type {string}
		 */
		var c_pfx = opcoes.tema.replace('.', '-');

		var classes = {
			primeiro: c_pfx +'-btn-prim',
			anterior: c_pfx +'-btn-ant',
			proximo	: c_pfx +'-btn-prox',
			ultimo	: c_pfx +'-btn-ult',
			numerico: c_pfx +'-btn-num',
			atual	: c_pfx +'-pg-atual'
		};


		/**
		 * Nome do name space a ser utilizado
		 * @type {string}
		 */
		var evt_ns = '__pgn';


        // Não é necessário exibir paginação de a quantidade de páginas é menor que 2
        if( opcoes.pgtotal < 2 ) return false;
        
        /* --------------------------------------------------------------------------------------------------------------------
         * Criar e configurar os botões de navegação
         * 
         * Obs.: Os itens são inseridos na mesma ordem que devem aparecer por padrão
         * ----------------------------------------------------------------------------------------------------------------- */
        if( opcoes.btn_primeira )
            $(document.createElement('a')).attr('href', 'javascript:;').addClass(classes.primeiro)
				.on('click.'+ evt_ns, function(){ $_IRPARA(1); }).text("|<<").appendTo($th);


        if( opcoes.btn_anterior )
            $(document.createElement('a')).attr('href', 'javascript:;').addClass(classes.anterior).on('click.'+ evt_ns, function(){
                if( opcoes.pgatual === 1 ){
                    if( opcoes.loop ) $_IRPARA(opcoes.pgtotal);
                    else return false;
                } else $_IRPARA(opcoes.pgatual - 1);
            }).text("<<").appendTo($th);


        /* --------------------------------------------------------------------------------------------------------------------
         * Criar e configurar os botões numéricos
         * ----------------------------------------------------------------------------------------------------------------- */
        if( opcoes.btn_numeros ){
            // Definir quantos botões numéricos serão mostrados
			var mm = Math.floor(opcoes.mostrar / 2);
			var mi = opcoes.pgatual - mm;
				mi = mi < 1 ? 1 : mi;
			var mf = opcoes.pgatual + ((opcoes.mostrar - mm) - 1);
				mf = (mf - mi) < opcoes.mostrar ? ((opcoes.mostrar - (mf - mi)) + mf) - 1 : mf;
				mf = mf > opcoes.pgtotal ? opcoes.pgtotal : mf;
				mf = mf < mi ? opcoes.pgtotal : mf;
				mi = mi == mf ? 1 : mi;
                
            while( mi <= mf ){
                $(document.createElement('a')).addClass(classes.numerico +' '+ (mi === opcoes.pgatual ? classes.atual : '')).attr({
                    href  : 'javascript:;'
                }).text(mi++).on('click.'+ evt_ns, function(){
                    var ir = parseInt($(this).text());
					return opcoes.pgatual != ir ? $_IRPARA(ir) : false;
                }).appendTo($th);
            } // Fim while( mi < mf )
        } // Fim if( opcoes.btn_numeros )


        if( opcoes.btn_proxima )
            $(document.createElement('a')).attr('href', 'javascript:;').addClass(classes.proximo).on('click.'+ evt_ns, function(){
                if( opcoes.pgatual === opcoes.pgtotal ){
                    if( opcoes.loop ) $_IRPARA(1);
                    else return false;
                } else $_IRPARA(opcoes.pgatual + 1);
            }).text(">>").appendTo($th);


        if( opcoes.btn_ultima )
            $(document.createElement('a')).attr('href', 'javascript:;').addClass(classes.ultimo)
				.on('click.'+ evt_ns, function(){ $_IRPARA(opcoes.pgtotal); }).text(">>|").appendTo($th);
        
        // Retornar o objeto
        return $th;
    };
})(jQuery);