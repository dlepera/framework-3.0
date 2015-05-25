/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 26/08/2014 11:53:56
 */

// Receber os arquivo para upload e gravar os nomes dos
// campos para não perder a referência
var up_nomes    = new Array();
var up_arquivos = new Array();

// Gravar o tempo de exibição da mensagem
var tempo_msg   = new Object();
var tempo_cont  = new Object();



/**
 * Função que será utilizada para tratar a resposta
 * -----------------------------------------------------------------------------
 * 
 * @param {string} r resposta do servidor após o envio da
 * requisição
 */
function TratarResposta(r){
    // Remover espaços em branco
    var r = r.trim();
    
    // Verificar se a resposta é um conteúdo JSON
    if( /^[?\[{]{1,}(.+)[}\]{1,}]?$/.test(r) ){
        var json = $.parseJSON(r);
            json = /^\[/.test(r) ? json[json.length-1] : json;
            
        var mensagem = json.mensagem;
        var retorno  = json.tipo;
    } else {
        var mensagem = r;
        var retorno  = 'atencao';
    } // Fim if( expreg.test(r) )
    
    return { msg: mensagem, ret: retorno };
} // Fim function TratarResposta(r)



(function($){
    $.fn._serialize = function(){
        var s = new Array();
        
        $(this).find('input, select, textarea').each(function(){
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
    
    $.fn._dlformulario = function(opcoes){
        // Valores padrão para as opções desse plugin
        var padrao = {
            // @option {string} controle - controle (action) a ser utilizado no submit do formulário
            controle: '',
            
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
                CarregarCSS(dir_raiz +'/aplicacao/js/dl-formulario/css/'+ opcoes.aparencia.tema +'/'+ opcoes.aparencia.estilo +'.css');
        } // if( opcoes.aparencia !== null )
        
        return this.each(function(){
            var $this = $(this);
            
            // Aplicar o tema ai formulário
            // $this.addClass(opcoes.aparencia.tema).addClass(opcoes.aparencia.estilo);
            
            // Definir o controle a ser executado
            if( opcoes.controle == '' )
                opcoes.controle = $this.attr('action');
                
            // Verificar se será feito algum upload com esse formulário
            var upload = $this.attr('enctype') === 'multipart/form-data' && $this.find(':file');
            
            // Organizar a navegação pela tecla SAP
            $this.find('input:not(:hidden):not([readonly]), select, textarea').each(function(i){
                $(this).attr({
                    tabindex: i+1
                });
            });
            
            //
            if( opcoes.cktodos[0] ){
               $selecionador   = $(opcoes.cktodos[1]);
               $selecionaveis  = $(opcoes.cktodos[2]);

               $selecionador.click(function(){
                    $selecionaveis.each(function(){
                        this.checked = $selecionador[0].checked;
                    });
                });
            } // Fim if( cktodos[0] )

            if( upload ){
                $this.find(':file').on('change', function(event){
                    var nome = this.name;
                    
                    $.each(event.target.files, function(k,v){
                        up_nomes.push(nome);
                        up_arquivos.push(v);
                    });
                });
            } // Fim if( upload )
            
            this.onsubmit = function(event, controle, antes, depois){
                // Parar os eventos em execução
                event.stopPropagation();
                event.preventDefault();
                
                // Simular o evento 'onsubmit'
                if( !opcoes.antes() || (typeof antes === 'function' && !antes()) ) return false;
                
                if( upload ){
                    var obj_fd = new FormData();
                    
                    // Incluir os arquivos
                    $.each(up_arquivos, function(k,v){
                        obj_fd.append(up_nomes[k],v);
                    });
                    
                    $this.find('input:not(:checkbox):not(:radio):not(:file), select, textarea, :checkbox:checked, :radio:checked').each(function(){
                        obj_fd.append(this.name,this.value);
                    });
                } // Fim if( upload )
                
                $.ajax({
                    url         : controle || opcoes.controle,
                    type        : 'post',
                    data        : obj_fd || $this._serialize(),
                    cache       : false,
                    processData : !upload,
                    contentType : upload ? false : 'application/x-www-form-urlencoded',
                    success     : function(dados){
                        var resp = TratarResposta(dados);
                        
                        $('body')._dlmostrarmsg({
                            mensagem    : resp.msg,
                            tipo        : ['alerta', resp.ret],
                            botao       : { texto: 'x', funcao: resp.ret === 'msg-sucesso' ? depois || opcoes.depois : function(){ return false; } },
                            aparencia   : { tema: opcoes.aparencia.tema, estilo: 'mensagem' }
                        });
                    }
                });
            };
            
            return false;
        });
    };
    
    $.fn.executar = function(controle, antes, depois){
        return this.each(function(){
            $(this).trigger('submit', [controle, antes, depois]);
        });
    };
    
    $.fn._dlmostrarmsg = function(opcoes){
        var $this = $(this);
        
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
            aparencia: { tema: 'dl-formulario', estilo: 'mensagem' },
            
            // Animação que fará a mensagem aparecer
            animacao: { mostrar: 'fadein', ocultar: 'fadeout', tempo: '1s' }
        };
        
        // Carregar as opções e mesclá-las com as opções padrao
        opcoes = $.extend({}, padrao, opcoes);
        
        // Carregar o tema para o formulário e seus elementos
        if( typeof(CarregarCSS) === 'function' ){
            CarregarCSS(dir_raiz +'aplicacao/js/dl-formulario/css/'+ opcoes.aparencia.tema +'/'+ opcoes.aparencia.estilo +'.css');
            CarregarCSS(dir_raiz +'aplicacao/js/dl-formulario/css/'+ opcoes.aparencia.tema +'/animacoes.css');
        } // Fim if( typeof(CarregarCSS) === 'function' )
        
        // Incluir a classe para o formulário
        $this.addClass(opcoes.aparencia.tema);
        
        /** 
         * Não permitir várias mensagens para o mesmo campo
         */
        if( $.inArray('campo', opcoes.tipo) > -1 ){
            $('#msg-'+ $this.attr('name')).fadeOut('fast', function(){ $(this).remove(); });
        } // Fim if( $.inArray('campo', opcoes.tipo) > -1 )
        
        // ID único para controlar o timeout
        var id_unico = $('div.dl-formulario-mensagem').length;
        
        /**
         * Criar a DIV de exibição da mensagem
         */
        var $div = $(document.createElement('div')).addClass('dl-formulario-mensagem '+ opcoes.aparencia.tema +' '+ opcoes.tipo.join(' ')).css({
            '-webkit-animation-name'        : opcoes.animacao.mostrar,
            '-webkit-animation-duration'    :  opcoes.animacao.tempo,
            '-webkit-animation-fill-mode'   : 'forwards'
        }).attr({
            id: $.inArray('campo', opcoes.tipo) > -1 ? 'msg-'+ $this.attr('name') : id_unico
        });
        
        /**
         * Para campos, colocar a mensagem logo após o elemento.
         * Para outros elementos, colocar a mensagem dentro do mesmo
         */
        var campos = ['INPUT', 'TEXTAREA', 'SELECT', 'BUTTON'];
        $.inArray(this[0].tagName, campos) > -1 ? $div.insertAfter($this) : $div.appendTo($this);
        
        /**
         * Criar um parágrafo (p) que irá receber o texto e
         * colocá-lo dentro da div
         */
        var $p = $(document.createElement('p')).html(opcoes.mensagem).appendTo($div);
        
        // Criar o botão de fechamento da mensagem
        var $botao = $(document.createElement('button')).attr({
            type: 'button'
        }).on('click', function() {
            // Remover o 'timeout' dessa mensagem
            window.clearTimeout(tempo_msg[id_unico]);
            
            if( typeof tempo_cont[id_unico] !== 'undefined' )
                window.clearInterval(tempo_cont[id_unico]);
            
            // Remover essa mensagem
            $div.css({
                '-webkit-animation-name'        : opcoes.animacao.ocultar,
                '-webkit-animation-duration'    : opcoes.animacao.tempo,
                '-webkit-animation-fill-mode'   : 'forwards'
            });
            
            // Remover a mensagem
            setTimeout(
                function(){ return $div.remove(); },
                
                // Converter os segundos em milesegundos
                opcoes.animacao.tempo.replace(/[^0-9]/g, '')*1000
            );
            
            // Reabilitar o botão submit
            $('button[type="submit"]:disabled').removeAttr('disabled');
            
            return opcoes.botao.funcao !== undefined ?
                opcoes.botao.funcao()
            : true;
        }).text(opcoes.botao.texto).appendTo($p);
        
        // Mostrar contagem regressiva para a mensagem sumir
        if( opcoes.tempo.exibir ){
            var $span = $(document.createElement('span')).addClass('cont-regressiva').html('Esta mensagem sumirá automaticamente em <b>'+ opcoes.tempo.num/1000 +'</b> segundos').appendTo($div);
            
            tempo_cont[id_unico] = window.setInterval(function(){
                var $b = $span.find('b');
                var na = $b.text();
                
                if( na == 1 )
                    window.clearTimeout(tempo_cont[id_unico]);
                
                $b.text(na-1);
            }, 1000);
        } // Fim if( opcoes.tempo.exibir )
        
        // Configurar a tecla Enter para disparar o evento click do botão Ok
        $(window).on('keyup', function(){ 
            var kc = event.keyCode || event.charCode;
            if( kc == 27 ) $botao.trigger('click');
        });
        
        // Configurar o tempo para que a mensagem suma
        tempo_msg[id_unico] = window.setTimeout(function(){
            return $botao.trigger('click');
        }, opcoes.tempo.num);
        
        return $this;
    }; // Fim $.fn._dlmostrarmsg
    
    
    
    /**
     * Aplicar uma máscara em um campo
     * -------------------------------------------------------------------------
     * 
     * @param {string} mascara - string contendo o formato a ser aplicado
     * @returns {dl-formulario-2.0.plugin_L63.$.fn@call;each}
     */
    $.fn._mascara = function(mascara){
        return this.each(function(){
            var $this = $(this);
            
            // Mostrar formato da máscara
            var mask_f = mascara.replace(/#/g, '_');
            
            // Elementos que compõe, a máscara
            var mask_e = mascara.replace(/#/g, '');
                mask_e = /[a-zA-Z]/.test(mascara) ? '('+ mask_e +')' : '['+ mask_e +']';
            
            // Configurar os eventos do campo
            // Obs: primeiro o evento é removido para evitar que seja executado
            // várias funções repetidas
            $this.unbind('keypress').on('keypress', function(event){
                var kc = event.keyCode > 0 ? event.keyCode : event.charCode;
                
                if( kc > 47 && kc < 123 ){
                    // var sem_mask    = $this.val().replace(new RegExp('['+ mask_e +']', 'g'), '').replace(/_/g, '') + String.fromCharCode(kc);
                    var sem_mask    = $this.val().replace(new RegExp(mask_e, 'g'), '').replace(/_/g, '') + String.fromCharCode(kc);;
                    var com_mask    = mask_f;
                    var qtde_sm     = sem_mask.length;
                    
                    for(var i = 0; i < qtde_sm; i++)
                        com_mask = com_mask.replace('_', sem_mask[i]);

                    $this.val(com_mask);

                    // Mover o cursor
                    if( com_mask.indexOf('_') > -1 )
                        MoverCursor(this, com_mask.indexOf('_'));
                } // Fim if( kc )
            }).on('focus', function(){
                if( this.value == '' )
                    this.value = mask_f;
            }).on('blur', function(){
                if( this.value == mask_f )
                    this.value = '';
            }).attr({
                maxlength: mask_f.length
            });
            
            return $this;
        });
    };
    
    
    
    $.fn._select = function(o){
        // Configurações padrão
        var p = {
            nome    : 'nome',
            filtro  : true,
            opcoes  : [{ vlr: '', txt: '', sel: false, html: '' }]
        };
        
        // Carregar as opções e mesclá-las com as opções padrao
        o = $.extend({}, p, o);
        
        return $(this).each(function(){
            var $th = $(this).addClass('form-controle').addClass('select-dl').css({
                /* Tamanho */
                height: 'auto',
                
                /* Posicionamento */
                position    : 'relative',
                'z-index'   : 5
            });
            var qto = o.opcoes.length;
            
            // Opção selecionada
            $(document.createElement('span')).addClass('select-selecionada').appendTo($th);
            
            // Busca de opções
            $(document.createElement('input')).attr({
                type: 'search'
            }).on('input', function(){
                var $th = $(this);
                var vlr = $th.val();
                var $op = $th.parents('.select-dl').find('.select-opcoes');

                if( vlr !== (false || '') )
                    $op.slideDown('fast');
                else
                    $op.slideUp('fast');

                $op.find('> *').css({ display: 'none' });
                $op.find(':contains('+ vlr +')').parents('.select-opcao').css({ display: 'block' });
            }).addClass('select-filtro').appendTo($th);
            
            // Todas as opções
            var $ul = $(document.createElement('ul')).addClass('sem-marcadores').addClass('select-opcoes').css({ display: 'none' }).appendTo($th);
            
            // Botão para exibir/ocultar as opções
            $(document.createElement('button')).addClass('select-botao').attr({ type: 'button' }).html('+').on('click', function(){
                var $op = $(this).parents('.select-dl').find('.select-opcoes');
                    $op.find('> *').css({ display: 'block' });
                    $op.slideToggle('fast');
            }).appendTo($th);
            
            // Incluir as opções
            for(var i=0; i<qto; i++){
                var opc = o.opcoes[i];
                var id  = 'sel'+ o.nome.replace(/_/g, '-') + opc.vlr.replace(/\s/g, '-').toLowerCase();
                var $li = $(document.createElement('li')).addClass('select-opcao').css({ display: 'none' }).appendTo($ul);
                
                // Controle
                $(document.createElement('input')).attr({
                    type    : 'radio',
                    name    : o.nome,
                    id      : id,
                    value   : opc.vlr
                }).appendTo($li);
                
                // Label
                $(document.createElement('label')).attr({
                    'for': id
                }).html(opc.txt).appendTo($li);
            } // Fim for(i)
        });
    };
})(jQuery);