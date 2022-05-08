$(document).ready(function() {
	activePackage();
	transferToTypes();
	rangeCalc();
	toggleModal();
	countryCode();
	savingValue();
	showFormPage();

	function closeModal () {
		if (!$('.form__submit').length) return;

		$('.form__submit').click((e) => {
			const regEmail = /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/gi;
			const emailVal = $('#emailField').val();
			const formFields = $('#solar_order').find('.form__field');
			const result = regEmail.test(emailVal);
			const data = $(e.currentTarget).parent().serialize();

			if (result) {
				console.log('Success');

				$.post(
					wp_ajax.url,
					data
				);

				$('.modal').removeClass('modal--active');
				$('.modal-bg').removeClass('modal-bg--active');

				[...formFields].forEach((field) => $(field).val(''));
				$('.form__checkbox').prop('checked', false);
			} else {
				console.log('Error');
				e.preventDefault();

				return;
			}
		});
	}

	function savingValue () {
		if (!$('.tabs__btn--active').length) return;

		const dataValue = $('.tabs__btn--active').data('value');

		setSavingAndTitle(dataValue);
		breakPointsCalc(dataValue);
		setInfo(dataValue);
	}

	function activePackage () {
		if (!$('.tabs__btn').length) return;

		$('.tabs__btn').click(({ currentTarget }) => {
			const dataName = $(currentTarget).data('name');
			const dataValue = $(currentTarget).data('value');

			$('.tabs__btn').removeClass('tabs__btn--active');
			$('.types__img').fadeOut();

			$(currentTarget).addClass('tabs__btn--active');
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
					$(`.instruction__desc[data-name=${option}]`).text(paramsCalc[point].sumWatts);
				}

				break;
			}
		}
	}

	function setSavingAndTitle (value) {
		for (let point in paramsCalc) {
			if (value === parseInt(point)) {
				const { title, saving } = paramsCalc[point];
				const lifetime = paramsCalc[point].grid.lifetime.reduce((context, value, i) => context+= text = i === 0 ? value : ` - ${value}`, '');

				$('.types__title-name').text(title);
				$('.sticky-footer__saving').text(saving);
				$('#savingPanel').text(lifetime);

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
			const countries = ['se', 'no', 'de', 'fo', 'is', 'fi', 'gb'];
			let contryUser;

			for (let countryItem of countries) {
				if (country === countryItem) {
					contryUser = country;

					break;
				} else if (country === 'gb') {
					contryUser = 'gb';

					break;
				} else {
					contryUser = 'se';
				}
			}

			if ($('#phoneField').length) {
				$('#phoneField').CcPicker({
					dataUrl: '/wp-content/themes/yootheme-child/assets/js/data.json',
					countryCode: contryUser
				});
			}
		});
	}

	function showFormPage () {
		$('.map_to_form').click(() => {
			$('.address-page').hide();
			$('#form-page').show();

			openModalAfterLoadPage();
			closeModal();
		});
	}
});
