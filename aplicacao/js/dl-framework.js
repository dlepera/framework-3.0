/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 11:43:08
 */

var dir_raiz                    = '/framework-3.0/';
var plugin_formulario_tema      = 'painel-dl';

function CarregarCSS(arquivo_css){
    if( /null.css$/.test(arquivo_css) ) return true;
    
    // Tratar o nome do arquivo CSS
    arquivo_css = dir_raiz.replace(/\/$/, '') +'/'+ arquivo_css.replace(dir_raiz, '').replace(/^\//, '');
    
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
            type    : 'text/css',
            media   : 'all',
            href    : arquivo_css
        }).insertAfter('html head link:last-of-type');
    });

    return true;
} // Fim function CarregarCSS

function MarcarValidCampo($c, v){
    $c.find('+ span').remove();
    $c.removeClass('sucesso').removeClass('erro').addClass(v).after('<span class="valid-campo '+ v +'"></span>');
} // Fim function MarcarValidCampo

function RemoverRegistro(controle, mensagem){
    $el.executar(controle, function(){
        return confirm(mensagem);
    }, function(){
        $('.lista :checkbox:checked').parents('tr').remove();
    });
} // Fim function RemoverRegistro

function MoverCursor(objeto, posicao){
    return objeto.setSelectionRange(posicao, posicao);
} // Fim AlterarCursor(objeto, posicao)

/**
 * Selecionar uma linha em uma lista de resultados
 * -----------------------------------------------------------------------------
 * 
 * @param {DOM} obj - objeto que está dentro da linha ou a linha própriamente dita
 * @param {bool} u - define se essa é a única linha que deve ser selecionada
 */
function SelecionarLinha(obj,u){
    var tag = obj.tagName;
    var $linha = tag === 'TR' ? $(obj)
            : $(obj).parents('tr');

    // Alterar o estilo da linha
    $linha.addClass('tr-selec');
    
    /* Remover a seleção das outras linhas
    if( u ){
        $linha.parents('tbody').find(':checkbox').each(function(){
            this.checked = false;
        });
    } // Fim if( u ) */
    
    if( obj.type !== 'checkbox' ){
        // Selecionar o checkbox dentro da linha
        $linha.find('td:first-child :checkbox').each(function() {
            this.checked = true;

            return true;
        });
    } // Fim if( obj.type != 'checkbox' )

    return true;
} // Fim function SelecionaLinha(obj)

/**
 * Carregar trecho HTML
 * 
 * @param {string} controle - caminho para o HTML a ser carregado
 * @param {string} id_html - ID a ser atribuído ao HTML
 * @returns {jQuery|CarregarHTML.$html}
 */
function CarregarHTML(controle, id_html){
    // Definir o ID
    var id = id_html || 'html-'+ ($('.sobre-tela').length-1);
    
    // Criar a DIV
    var $html = $(document.createElement('div')).addClass('sobre-tela').attr('id', id).appendTo($('body'));
    
    $.ajax({
        url     : controle.replace(/^\/+|\/+$/g, '') + '/0',
        dataType: 'html',
        async   : false, // Essa requisição precisa ser SÍNCRONA para impedir que a função retorne o jQuery sem o conteúdo HTML
        success : function(html){
            // Carregar o conteúdo HTML
            $html.html(html);
            
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
    $form.find('form')._dlformulario({
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



/**
 * Carregar informações para popular <select>
 * -----------------------------------------------------------------------------
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

// Adicionar o suporte ao trim
// Necessário para o IE (óbvio!!) 8 ou mais antigo
if( typeof String.prototype.trim !== 'function' ){
    String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, ''); 
    };
}



/**
 * Alternar a publicação de um registro
 * -----------------------------------------------------------------------------
 * 
 * @param {string} url - URL do controle a ser executado
 * @param {bool} chk - define se os registros serão marcados ou não
 * @returns {void}
 */
function AlternarPublicacao(url){
    $el.executar(
        url,
        function(){ return true; },
        function(){ window.location.reload(); }
    );
};


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
    
    complete    : function(){
        $('#carregando').fadeOut('fast', function(){
            $(this).remove();
        });
    }
});

$(document).ready(function(){
    if( window.location.toString().indexOf('/painel-dl') > -1 ){
        // Configurar o menu fixo
        /* $(window).on('scroll', function(){
            var $topo       = $('header.dl');
            var pos_y       = window.scrollY;
            var fim_topo    = $('section.dl').position().top - $('nav.dl').height();
            
            if( pos_y >= fim_topo ) $topo.addClass('fixo');
            else $topo.removeClass('fixo');
        }); */
        
        // Configurar o evento 'reset' dos formulários
        $('form').on('reset', function(){
            history.back();
        });
    } // Fim if( window.location.toString().indexOf('/painel-dl') > -1 )
});

/**
 * Validação de CPF
 *  - Dígitos verificadores e tamanho
 *  
 * @param {string} cpf_sujo - Pode receber o CPF puro (apenas números) ou com máscara
 * @returns {Boolean}
 */
function ValidaCPF(cpf_sujo){
    var soma = 0, mod, dv_1, dv_2;
    var cpf = cpf_sujo.replace(/[\.\-]/g, '');
    
    // Validar o tamanho da string recebida após a limpeza dos
    // caracteres
    if( cpf.length != 11 ){
        console.log('Esse CPF possui muitos caracteres!');
        return false;
    }
    
    // Primeiro dígito
    for(var i = 10; i > 1; i--){
        soma += parseInt(cpf[(10-i)]) * i;
    }
    
    // Calcular o MOD 11 da soma para o primeiro DV
    mod = soma%11;
    
    // Se o MOD for menor ou igual a 2 então o DV é 0;
    // senão contrário o DV é igual a 11-MOD
    dv_1 = mod < 3 ? 0 : 11-mod;
    
    soma = 0;
    
    // Segundo dígito
    for(var i = 11; i > 1; i--){
        soma += parseInt(cpf[(11-i)]) * i;
    }
    
    mod   = soma%11;
    dv_2  = mod < 3 ? 0 : 11-mod;
    
    if( cpf[cpf.length-2] != dv_1 || cpf[cpf.length-1] != dv_2 ){
        console.log('CPF invávlido!');
        return false;
    } else {
        console.log('CPF válido!');
        return true;
    }
}
