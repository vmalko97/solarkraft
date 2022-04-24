$(document).ready(function() {

		$('#solar_order').submit(function(e){
				var data = $(this).serialize();
				e.preventDefault();
				$.post(
						wp_ajax.url,
						data,
						function (response) {
								console.log(response);
								$('#map').hide();
						})
		});

	activePackage();
	transferToTypes();
	rangeCalc();

	function activePackage () {
		if (!$('.types__btn').length) return;

		$('.types__btn').click(({ currentTarget }) => {
			const dataName = $(currentTarget).data('name');

			$('.types__btn').removeClass('types__btn--active');
			$('.types__content').hide();
			$('.types__img').fadeOut();

			$(currentTarget).addClass('types__btn--active');
			$(`.types__content[data-content=${dataName}]`).fadeIn();
			$(`.types__img[data-name=${dataName}]`).fadeIn();
		});
	}

	function transferToTypes () {
		if (!$('.info__btn-calc').length) return;

		$('.info__btn-calc').click(({ currentTarget }) => {
			const topTypesSection = $('#types').offset().top;

			$('html, body').animate({ scrollTop : topTypesSection - 40 }, 1000);
		});
	}

	function rangeCalc () {
		const min = $('#amount').data('min');
		const max = $('#amount').data('max');

		$("#slider").slider({
			value: 0,
			min,
			max,
			step: 50,
			slide: (event, { value }) => {
				$("#amount").val(value);
				breakPointsCalc(value);
			}
		});
		$( "#amount" ).val($("#slider").slider("value"));
		$('.calc__value--min').text(`${min} kr`);
		$('.calc__value--max').text(`${max} kr`);
	}

	function breakPointsCalc (value) {
		const paramsCalc = {
			4500: {
				bill: 8640,
				month: 720,
				cash: 90.000,
				finance: 708
			},
			7200: {
				bill: 13824,
				month: 1152,
				cash: 130.000,
				finance: 1022
			},
			9000: {
				bill: 17280,
				month: 1440,
				cash: 145.000,
				finance: 1140
			}
		}

		for (let point in paramsCalc) {
			if (value <= point) {
				console.log(paramsCalc[point]);
				break;
			}
		}
	}

});
