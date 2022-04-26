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
				// breakPointsCalc(value);
			}
		});
		$("#amount").val($("#slider").slider("value"));
		$('.calc__value--min').text(`${min} kr`);
		$('.calc__value--max').text(`${max} kr`);
	}

	function breakPointsCalc (value) {
		const paramsCalc = {
			4500: {
				lifetime: ['240', '310'],
				annual: 8640,
				month: 720,
				size: '5KW (11 panels)'
			},
			7200: {
				lifetime: ['420', '500'],
				annual: 13824,
				month: 1152,
				size: '8KW (18 panels)'
			},
			9000: {
				lifetime: ['520', '600'],
				annual: 17280,
				month: 1440,
				size: '10KW (22 panels)'
			}
		}

		for (let point in paramsCalc) {
			if (value <= point) {
				for (let option in paramsCalc[point]) {
					if (option === 'lifetime') {
						[from, to] = paramsCalc[point][option];

						$(`.grid__name[data-name=${option}]`).find('.grid__count--from').text(from);
						$(`.grid__name[data-name=${option}]`).find('.grid__count--to').text(to);
					} else {
						$(`.grid__name[data-name=${option}]`).find('.grid__count').text(paramsCalc[point][option]);
					}
				}
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
