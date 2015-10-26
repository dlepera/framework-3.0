/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 19/08/2014 15:12:11
 */

(function($){
    /**
     * Criar efeito de auto completar
     * 
     * @returns {undefined}
     */
    $.fn._dlautocompletar = function(opcoes){
        // Opções padrão
        var padrao = {
            // @optionTexto a ser exibido no campo de busca para auxiliar
            // a utilização
            dica: "Digite...",
            
            // Aparência do formulário e dos seus elementos,
            // que serão definidos por uma classe
            aparencia: { tema: "dl-autocompletar", estilo: "auto-completar" }
        };
        
        // Carregar as opções e mesclá-las com as opções padrao
        opcoes = $.extend({}, padrao, opcoes);
        
        // Carregar o tema para o formulário e seus elementos
        if( opcoes.aparencia !== null ){
            if( typeof(carregarCSS) === "function" )
                carregarCSS('web/js/dl-autocompletar/css/'+ opcoes.aparencia.tema +'/'+ opcoes.aparencia.estilo +'.css');
        } // if( opcoes.aparencia !== null )
        
        return this.each(function(){
            var $this = $(this);
            
            // Configurar a aparência desse auto completar
            $this.addClass(opcoes.aparencia.tema +" "+ opcoes.aparencia.estilo); 
            
            // Criar um campo de busca para filtrar os radios
            var $p = $(document.createElement("p"));
                    
            if( $this.find(":radio").length < 1 )
                $p.appendTo($this);
            else
                $p.insertBefore($this.find(":radio:first-of-type"));
            
            $(document.createElement("input")).attr({
                type: "search"
            }).attr({ placeholder: opcoes.dica }).on("keyup", function(){
                var valor = $(this).val();
                
                // Esconder todos
                $this.find(":radio,label").css({ display: "none" });
                
                // Exibir apenas os que contém o texto digitado
                $this.find("label:contains('"+ valor +"')").css({ display: "block" });
            }).on("blur", function(){
                // Esconder os radios / labels não selecionados
                $this.find(":radio:not(:checked) + label").fadeOut("fast");
                
                // Forçar a exibição da opção selecionada
                $this.find(":radio:checked + label").fadeIn("fast");
            }).appendTo($p);
        });
    };
})(jQuery);