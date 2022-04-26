$(document).ready(function() {
	getCoords ();
	activePackage();
	transferToTypes();
	rangeCalc();
	toggleModal();
	openModalAfterLoadPage();
	countryCode();
	savingValue();

	function getCoords () {
		if (!$('#solar_order').length) return;

		$('#solar_order').submit((e) => {
			e.preventDefault();

			const data = $(this).serialize();

			$.post(
				wp_ajax.url,
				data,
				(response) => {
					$('#map').hide();
					$('.map-form').removeClass('map-form--active');
				}
			);
		});
	}

	function savingValue () {
		if (!$('.types__btn--active').length) return;

		const dataValue = $('.types__btn--active').data('value');

		$('.sticky-footer__saving').text(dataValue);
	}

	function activePackage () {
		if (!$('.types__btn').length) return;

		$('.types__btn').click(({ currentTarget }) => {
			const dataName = $(currentTarget).data('name');
			const dataValue = $(currentTarget).data('value');

			$('.types__btn').removeClass('types__btn--active');
			$('.types__content').hide();
			$('.types__img').fadeOut();

			$(currentTarget).addClass('types__btn--active');
			$(`.types__content[data-content=${dataName}]`).fadeIn();
			$(`.types__img[data-name=${dataName}]`).fadeIn();

			$('.sticky-footer__saving').text(dataValue);
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
		if (!$('#amount').length) return;

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
		$("#amount").val($("#slider").slider("value"));
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

	function toggleModal () {
		if (!$('.modal').length) return;

		$('.modal__close').click(() => {
			$('.modal').removeClass('modal--active');
			$('.modal-bg').removeClass('modal-bg--active');
		});

		$('#openModal').click(() => {
			openModal();
		});
	}

	function openModal () {
		if (!$('.modal').length) return;

		$('.modal').addClass('modal--active');
		$('.modal-bg').addClass('modal-bg--active');
	}

	function openModalAfterLoadPage () {
		setTimeout(() => {
			openModal();
		}, 2000);
	}

	function countryCode () {
		new Promise((resolve, reject) => {
			$.get("https://ipinfo.io", ({ country }) => {
				resolve(country.toLowerCase());
			}, "jsonp");
		})
		.then((country) => {
			const countries = ['se', 'no', 'fi', 'uk'];
			let contryUser;

			for (let countryItem of countries) {
				contryUser = countryItem === country ? countryItem : 'se';
			}

			if ($('#phoneField').length) {
				$('#phoneField').CcPicker({
					dataUrl: './wp-content/themes/yootheme-child/assets/js/data.json',
					countryCode: contryUser
				});
			}
		});
	}
});
