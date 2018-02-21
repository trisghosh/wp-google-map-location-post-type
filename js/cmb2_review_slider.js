jQuery( document ).ready(function($) {

	"use strict";
	// Loop through all cmb-type-slider-field instances and instantiate the slider UI
	$( '.cmb-type-review-slider' ).each(function() {
		var $this       = $( this );
		var $value      = $this.find( '.numeric-slider-field-value' );
		var $slider     = $this.find( '.numeric-slider-field' );
		var $text       = $this.find( '.numeric-slider-field-value-text' );
		var slider_data = $value.data();

		$slider.slider({
			range : 'min',
			value : slider_data.start,
			min   : slider_data.min,
			max   : slider_data.max,
			
			slide : function( event, ui ) {
				$value.val( ui.value );
				var txt=ui.value;				
				$text.text(txt);
			}
		});
		// Initiate the display
		$value.val( $slider.slider( 'value' ) );
		$text.text( $slider.slider( 'value' ));

	});

});
