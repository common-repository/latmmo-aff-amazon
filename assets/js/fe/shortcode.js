;(function ($, window, document, undefined) {
	'use strict';

	let OS = window.OS || {};

	OS.ProductHistory = function () {
		$('.latmmoChart').each(function () {
			let $this	= $(this);
			let id		= $this.attr('id');
			let label	= $this.attr('data-date');
			let price	= $this.attr('data-price');
			let ctx		= document.getElementById(id).getContext('2d');

			let historyChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: label.split('%%'),
					datasets: [{
						label: '# of Price',
						data: price.split('%%'),
						borderColor: 'rgb(75, 192, 192)',
					}]
				},
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});
		});
	};

	$(document).ready(function () {
		OS.ProductHistory();
	});

})(jQuery, window, document);