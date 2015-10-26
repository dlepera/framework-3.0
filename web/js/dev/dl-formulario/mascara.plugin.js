/**
 * Created by dlepera on 23/10/15.
 */

(function($){
	// Funções ------------------------------------------------------------------------------------------------------ //
	/**
	 * Converter um formato de máscara para um formato humano
	 *
	 * @param {String} msk Máscara a ser convertida
	 * @returns {void|string|XML}
	 * @private
	 */
	function convMask(msk){ return msk.replace(/#/g, '_'); }


	/**
	 * Obter os elementos presentes na máscara
	 *
	 * @param {string} msk Máscara a ser analisada
	 * @returns {RegExp}
	 * @private
	 */
	function elemMask(msk){
		var e_msk = msk.replace(/[#_]/g, '');
		e_msk = /[a-zA-Z]/.test(msk) ? '('+ e_msk +')' : '['+ e_msk +']';

		return new RegExp(e_msk, 'g');
	} // function ElemMask(msk)


	/**
	 * Limpar o valor
	 *
	 * @param {string} v Valor a ser tratado
	 * @param {string} m Máscara a ser considerada para a limpeza
	 * @returns {string|XML}
	 * @private
	 */
	function limparVlr(v, m){ return v.replace(elemMask(m), '').replace(/_/g, ''); }


	/**
	 * Aplicar uma máscara em uma string
	 *
	 * @param {string} v String a ser mascarada
	 * @param {string} m Máscara a ser aplicada
	 * @returns {*}
	 * @private
	 */
	function aplicarMascara(v, m){
		var s_msk = limparVlr(v, m);
		var c_msk = m;
		var qt_sm = s_msk.length;

		for(var i = 0; i < qt_sm; i++){
			c_msk = c_msk.replace('_', s_msk[i]);
		} // Fim for( i )

		return c_msk;
	} // Fim do método aplicarMascara

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
		var msk_c = convMask(msk);

		$th.off('.' + evt_ns).on(evt_on + '.' + evt_ns, function(evt){
			var _this = evt.target;
			var kc = evt.keyCode || evt.charCode || evt.which;
			var mod = evt.metaKey || evt.ctrlKey;

			if( !mod && kc > 47 && kc < 90 ){
				_this.value = aplicarMascara(_this.value + String.fromCharCode(kc), msk_c);
			} // Fim if( !mod && kc > 47 && kc < 90 )

			var pos_ = this.value.indexOf('_');

			if( pos_ > -1 && typeof moverCursor === 'function' ){ moverCursor(_this, pos_); }
		})
			.on('focus.' + evt_ns, { mask: msk }, function(evt){
				var _this = evt.target;
				_this.value = aplicarMascara(_this.value, convMask(evt.data.mask));
			})

			.on('blur.' + evt_ns, { mask: msk, mask_c: msk_c }, function(evt){
				var _this = evt.target;
				_this.value = _this.value === evt.data.mask_c ? '' : aplicarMascara(_this.value, evt.data.mask_c);
			})

			.on('paste.' + evt_ns, { mask: msk }, function(evt){
				var _this = evt.target;
				_this.value = limparVlr(_this.value, evt.data.mask);
			})

			.attr('maxlength', msk.length).prop('autocomplete', false);

		return $th;
	}; // Fim do plugin _mascara
})(jQuery);