/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 11:43:08
 */

var plugin_formulario_tema = 'painel-dl';

/**
 * Carregar arquivo CSS
 * 
 * @param {string} arquivo_css Caminho do arquivo CSS a ser carregado
 *
 * @returns {bool}
 */
function CarregarCSS(arquivo_css){
    if( /null.css$/.test(arquivo_css) ) return true;
    
    // Tratar o nome do arquivo CSS
    arquivo_css = dir_relativo + arquivo_css.replace(/^\//, '');
    
    $(document).ready(function(){
        // Verificar se o arquivo CSS já não foi carregado
        var $css_carregado = $('link[rel="stylesheet"][href="'+ arquivo_css +'"]');

        if( $css_carregado.length > 0 )
            return true; // Arquivo já carregado

        // - Criar o novo link de ligação ao CSS
        // - Incluir a TAG na sessão HEAD da página
        // Obs.: Para manter organizado a folha de estilo será adicionada
        // em seguida à última
        $(document.createElement('link')).attr({
            rel     : 'stylesheet',
            media   : 'all',
            href    : arquivo_css
        }).insertAfter('html head link:last-of-type');
    });

    return true;
} // Fim function CarregarCSS



/**
 * Mover o cursor para uma posição 'p'
 *
 * @param {object} o Objeto DOM
 * @param {int} p    Novo posicionamento do cursor
 * @returns {*}
 * @constructor
 */
function MoverCursor(o, p){ return o.setSelectionRange(p, p); } // Fim AlterarCursor(objeto, posicao)


/**
 * Selecionar uma linha em uma lista de resultados
 *
 * @param {object} obj Objeto que está dentro da linha ou a linha própriamente dita
 * @param {bool} u Define se essa é a única linha que deve ser selecionada
 * @returns {boolean}
 * @constructor
 */
function SelecionarLinha(obj, u){
    var tag = obj.tagName;
    var $linha = tag === 'TR' ? $(obj)
            : $(obj).parents('tr');

    // Alterar o estilo da linha
    $linha.addClass('tr-selec');
    
    // Remover a seleção das outras linhas
    console.log(u);
    if( u === true )
        $linha.parents('tbody').find(':checkbox').prop('checked', false);
    
    if( obj.type !== 'checkbox' ){
        // Selecionar o checkbox dentro da linha
        $linha.find('td:first-child :checkbox').each(function() {
            $(this).prop('checked', true);
            return true;
        });
    } // Fim if( obj.type != 'checkbox' )

    return true;
} // Fim function SelecionaLinha(obj)



/**
 * Carregar trecho HTML
 * 
 * @param {string} controle Caminho para o HTML a ser carregado
 * @param {string} id_html ID a ser atribuído ao HTML
 *
 * @returns {jQuery|CarregarHTML.$html}
 */
function CarregarHTML(controle, id_html){
    // Definir valores padrão
    var id  = id_html || 'html-'+ ($('.sobre-tela').length-1);
    var mst = 'conteudo';
    
    // Criar a DIV
    var $html = $(document.createElement('div')).addClass('sobre-tela').attr('id', id);
    
    $.ajax({
        url     : controle.replace(/^\/+|\/+$/g, '') +'/'+ mst,
        dataType: 'html',
        async   : false, // Essa requisição precisa ser SÍNCRONA para impedir que a função retorne o jQuery sem o conteúdo HTML
        success : function(html){
            // Carregar o conteúdo HTML
           	$html.html(html).appendTo($('body'));
            
            // Configurar a tecla ESC para remover o $html
            $(window).on('keyup', function(e){
                var kc = e.keyCode || e.charCode || e.which;
                
                if( kc === 27 ){
                    $('#btn-'+ id_html).trigger('click');
                } // Fim if( kc === 27 )
            });
        }
    });
    
    // Criar o botão para fechar
    $(document.createElement('button')).text('x').attr({ id: 'btn-'+ id_html }).on('click', function(){
        $html.fadeOut('fast', function(){
            $(this).remove();
        });
    }).addClass('btn-fechar').appendTo($html);
    
    return $html;
} // Fim de function CarregarHTML(controle, id_html)



/**
 * Carregar um formulário
 * 
 * @param {string} form - caminho para o FORM a ser carregado
 * @param {string} id_html - ID a ser atribuído ao HTML
 * @param {function} func_depois - função a ser executada após o submit do formulário
 * @returns {jQuery|CarregarForm.$form|CarregarHTML.$html}
 */
function CarregarForm(form, id_html, func_depois){
    var $form = CarregarHTML(form, id_html);
    
    // Alterar algumas propriedades do formulário
    $form.find('form')._formulario({
        depois      : function(){
            $form.find('form').trigger('reset');
            if( typeof func_depois === 'function' ) func_depois();
        },
        aparencia   : { tema: plugin_formulario_tema, estilo: 'formulario' }
    }).on('reset', function(){
        $form.fadeOut('fast', function(){
            $form.remove();
        });
    });
    
    return $form;
} // Fim function CarregarForm(form, id_html)


function MsgStatus(msg){
	$('body')._mostrarmsg({
		mensagem: msg,
		tipo: ['alerta', 'msg-erro'],
		aparencia: { tema: 'painel-dl', estilo: 'mensagem' }
	});
} // Fim CarregarConteudo ($dom, html)



/**
 * Carregar informações para popular <select>
 * 
 * @param {jQuery} $s - instância jQuery do select a ser populado
 * @param {type} c - controle a ser executado para obter os dados
 * @returns {void}
 */
function CarregarSelect($s, c){
    $.ajax({
        url     : c,
        dataType: 'json',
        success : function(json){
            var qtde = json.length;

            if( qtde > 0 ){
                // Remover todos as opções do select
                // com excessão do primeiro
                $s.find('option:not(:first-child)').remove();

                for(var i=0; i < qtde; i++)
                    $(document.createElement('option')).val(json[i].VALOR).text(json[i].TEXTO).appendTo($s);
            } // Fim if( qtde > 0 )
        } // Fim success
    });
} // Fim function CarregarSelect($select, controle)



/**
 * Mostrar ou ocultar um determinado campo de acordo com a seleção de um checkbox
 *
 * @param {object} cbx Checkbox a ser testado
 * @param {jQuery} $j Campo(s) a ser(em) exibido(s) ou escondido(s)
 * @returns {void}
 */
function MostrarCampo(cbx, $j){
	$j.each(function(){
		var $th = $(this);
		var tag = this.tagName;

		if( cbx.checked ){
			$th.fadeIn('fast');

			if( tag === 'input' ) $th.focus();
		} else {
			$th.fadeOut('fast');

			if( tag === 'input' ) $th.val('');
		} // Fim if( cbx.checked )
	});
} // Fim function MostrarCampo(cbx, $j)



// Adicionar o suporte ao trim
// Necessário para o IE (óbvio!!) 8 ou mais antigo
if( typeof String.prototype.trim !== 'function' ){
    String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, ''); 
    };
}


/**
 * Identificar o navegador e a versão
 *
 * @returns {{nome: *, versao: Number}}
 * @constructor
 */
function Navegador(){
    var n, v, cf;
    var ua = navigator.userAgent;
    var ie = /(MSIE|Trident)/.test(ua);
    var ff = /Firefox/.test(ua);
    var op = /OPR/.test(ua);
    // var gc = /Chrome/.test(ua);
    // var sf = /Safari/.test(ua) && !gc;

    // IE ou Edge
    if( ie ){
        cf = /MSIE\s([0-9]+)/.exec(ua) || /rv:([0-9\.]+)/.exec(ua);
        v = cf[1];
        n = v < 12 ? 'Internet Explorer' : 'Microsoft Edge';

        // Firefox ou Opera
    } else if( ff || op ){
        cf = /(Firefox|OPR)\/([0-9\.]+)/.exec(ua);
        n = cf[1];
        v = cf[2];

        // Safari ou Chrome
    } else {
        cf = /(Safari|Chrome)\/([0-9\.]+)/.exec(ua);
        n = cf[1];
        v = cf[2];
    } // Fim if( ie ) ( ff || op )

    return { nome: n, versao: parseFloat(v) }
} // Fim da função Navegador


/**
 * Alternar a publicação de um registro
 * 
 * @param {string} url URL do controle a ser executado
 * @returns {void}
 */
function AlternarPublicacao(url){
    $el._executar(
        url,
        function(){ return true; },
        function(){ window.location.reload(); }
    );
}


function AlternarMaskFone(evt){
	var $th = $(evt.target);
	var tel = $th.data('telefone');

	$(tel)._mascara(this.checked ? evt.data.msk9 : evt.data.msk8).trigger('focus');
}


// Alterar o selector 'contains' do jQuery para que seja
// case insensitive
$.expr[':'].contains = $.expr.createPseudo(function(arg){
    return function(elem){
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});



/**
 * Configuração da execução do AJAX
 */
$.ajaxSetup({
    beforeSend  : function(){
        $(document.createElement('div')).attr('id', 'carregando').html(
            '<p class="carregando">Processando, por favor aguarde...</p>'
        ).appendTo($('body')).fadeIn('fast');
    },

	statusCode: {
		403: function(x){ MsgStatus(x.responseText); },
		404: function(x){ MsgStatus(x.responseText); },
		500: function(x){ MsgStatus(x.responseText); }
	},

    complete    : function(){
        $('#carregando').fadeOut('fast', function(){
            $(this).remove();
        });
    }
});

$(document).ready(function(){
	// Alterar o comportamento dos campos do tipo 'number'
	// Substituir a ',' por '.' automaticamente
	$('[type="number"]').on('keydown', function(){
		var $th = $(this);
		var kc 	= event.keyCode || event.charCode || event.which;
		var vl 	= $th.val().replace('.', '');

		if( kc == 188 ){
			$th.val(vl +'.');
			return false;
		} // Fim if( kc == 188 )

		return true;
	});
});
