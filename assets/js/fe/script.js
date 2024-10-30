;(function ($, window, document, undefined) {
	'use strict';

	let OAC = window.OAC || {};

	var $body		= $('body'),
		$window		= $(window);

	OAC.Slide = function() {
		let slick = $('.latmmo-slick');
		if (slick.length) {
			slick.slick();
		}
	};

	OAC.Fancybox = function() {
		let fancybox = $('.latmmo-fancybox');
		if (fancybox.length) {
			fancybox.fancybox();
		}
	};

	OAC.PriceFilter = function () {
		let date = $('.item-price-filter');

		if (date.length) {
			date.datepicker({
				dateFormat: 'mm/dd/yy',
				changeMonth: true,
				changeYear: true,
				onSelect: function(dateText, inst) {
					let parent	= date.parent('.item-date');
					let from	= parent.find('.item-date-from').val();
					let to		= parent.find('.item-date-to').val();
					let pid		= parent.find('.item-p').val();
					let output	= parent.siblings('.item-history');

					if (from === '' || to === '') {
						return;
					}

					let data = {
						'action': 'latmmo_ajax_price_history',
						'from': from,
						'to': to,
						'p': pid
					}

					$.ajax({
						method: 'POST',
						url: latmmo_script.ajax_url,
						data: data,
						dataType: 'json',
						beforeSend: function() {
						},
						success: function(response) {
							output.empty();
							output.append('<canvas id="latmmoChart' + pid + '" width="400" height="300"></canvas>');

							let id	= 'latmmoChart' + pid;
							let ctx	= document.getElementById(id).getContext('2d');
							new Chart(ctx, {
								type: 'line',
								data: {
									labels: response.date,
									datasets: [{
										label: '# of Price',
										data: response.price,
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
						}
					});
				}
			});
		}
	}

	OAC.ShowHelper = function () {
		$('.item-score .h').on('click', function () {
			let target	= $(this).find('.hp');
			let c		= target.hasClass('active');

			$('.item-score').find('.hp').removeClass('active');

			if (c) {
				target.removeClass('active');
			} else {
				target.addClass('active');
			}
		});
	};

	$(document).ready(function () {
		OAC.Slide();
		OAC.Fancybox();
		OAC.PriceFilter();
		OAC.ShowHelper();
	});

})(jQuery, window, document);