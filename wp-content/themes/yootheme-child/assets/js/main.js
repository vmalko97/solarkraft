$(document).ready(function() {
	const paramsCalc = {
		4500: {
			title: 'Premium (11 panels) 5KW',
			saving: 720,
			info: {
				name: 'Premium 5KW',
				count: 11,
				kw: 4500
			},
			grid: {
				lifetime: ['240 000', '310 000'],
				annual: 8640,
				month: 720,
				size: '5KW (11 panels)'
			}
		},
		7200: {
			title: 'Premium (18 panels) 8KW',
			saving: 1152,
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
			title: 'Premium(22 panels) 10KW',
			saving: 1440,
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

		const dataValue = $('.types__btn--active').data('value');

		setSavingAndTitle(dataValue);
		breakPointsCalc(dataValue);
		setInfo(dataValue);
	}

	function activePackage () {
		if (!$('.types__btn').length) return;

		$('.types__btn').click(({ currentTarget }) => {
			const dataName = $(currentTarget).data('name');
			const dataValue = $(currentTarget).data('value');

			$('.types__btn').removeClass('types__btn--active');
			$('.types__img').fadeOut();

			$(currentTarget).addClass('types__btn--active');
			$(`.types__img[data-name=${dataName}]`).fadeIn();

			setSavingAndTitle(dataValue);
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
				for (let option in paramsCalc[point].info) {
					$(`.instruction__name[data-name=${option}]`).text(paramsCalc[point].info[option]);
				}

				break;
			}
		}
	}

	function setSavingAndTitle (value) {
		for (let point in paramsCalc) {
			if (value === parseInt(point)) {
				const { title, saving } = paramsCalc[point];

				$('.types__title-name').text(title);
				$('.sticky-footer__saving').text(saving);

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
