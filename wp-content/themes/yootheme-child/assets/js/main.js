$(document).ready(function() {
	const paramsCalc = {
		4500: {
			info: {
				name: 'Premium 5KW',
				count: 11,
				kw: 5000
			},
			grid: {
				lifetime: ['240 000', '310 000'],
				annual: 8640,
				month: 720,
				size: '5KW (11 panels)'
			}
		},
		7200: {
			info: {
				name: 'Premium 8KW',
				count: 18,
				kw: 8000
			},
			grid: {
				lifetime: ['420 000', '500 000'],
				annual: 13824,
				month: 1152,
				size: '8KW (18 panels)'
			}
		},
		9000: {
			info: {
				name: 'Premium 10KW',
				count: 22,
				kw: 10000
			},
			grid: {
				lifetime: ['520 000', '600 000'],
				annual: 17280,
				month: 1440,
				size: '10KW (22 panels)'
			}
		}
	}

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

		const dataSaving = $('.types__btn--active').data('saving');
		const dataValue = $('.types__btn--active').data('value');

		$('.sticky-footer__saving').text(dataSaving);
		breakPointsCalc(dataValue);
		setInfo(dataValue);
	}

	function activePackage () {
		if (!$('.types__btn').length) return;

		$('.types__btn').click(({ currentTarget }) => {
			const dataName = $(currentTarget).data('name');
			const dataValue = $(currentTarget).data('value');
			const dataSaving = $(currentTarget).data('saving');

			$('.types__btn').removeClass('types__btn--active');
			$('.types__content').hide();
			$('.types__img').fadeOut();

			$(currentTarget).addClass('types__btn--active');
			$(`.types__content[data-content=${dataName}]`).fadeIn();
			$(`.types__img[data-name=${dataName}]`).fadeIn();

			$('.sticky-footer__saving').text(dataSaving);
			breakPointsCalc(dataValue);
			setInfo(dataValue);
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
		for (let point in paramsCalc) {
			if (value === parseInt(point)) {
				console.log(paramsCalc[point].grid);
				for (let option in paramsCalc[point].grid) {
					if (option === 'lifetime') {
						[from, to] = paramsCalc[point].grid[option];

						$(`.grid__name[data-name=${option}]`).find('.grid__count--from').text(from);
						$(`.grid__name[data-name=${option}]`).find('.grid__count--to').text(to);
					} else {
						$(`.grid__name[data-name=${option}]`).find('.grid__count').text(paramsCalc[point].grid[option]);
					}
				}

				break;
			}
		}
	}

	function setInfo (value) {
		for (let point in paramsCalc) {
			if (value === parseInt(point)) {
				console.log(paramsCalc[point].info);
				for (let option in paramsCalc[point].info) {
					$(`.instruction__name[data-name=${option}]`).text(paramsCalc[point].info[option]);
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
