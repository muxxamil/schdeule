/*
Name: 			Dashboard - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	2.1.1
*/

(function($) {

	'use strict';

	/*
	Liquid Meter
	*/
	if( $('.meterSales').get(0) ) {
		$('.meterSales').liquidMeter({
			shape: 'circle',
			color: '#0088cc',
			background: '#F9F9F9',
			fontSize: '24px',
			fontWeight: '600',
			stroke: '#F2F2F2',
			textColor: '#333',
			liquidOpacity: 0.9,
			liquidPalette: ['#333'],
			speed: 3000,
			animate: !$.browser.mobile
		});
	}

	if( $('.meterSalesSel').get(0) ) {
		$('.meterSalesSel a').on('click', function( ev ) {
			ev.preventDefault();

			var val = $(this).data("val"),
				selector = $(this).parent(),
				items = selector.find('a');

			items.removeClass('active');
			$(this).addClass('active');

			// Update Meter Value
			$('.meterSales').liquidMeter('set', val);
		});

	}


}).apply(this, [jQuery]);