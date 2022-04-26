$(document).ready(function() {
	getCoords ();
	activePackage();
	transferToTypes();
	rangeCalc();
	toggleModal();
	openModalAfterLoadPage();
	countryCode();

	function getCoords () {
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

	function toggleModal () {
		$('.modal__close').click(() => {
			$('.modal').removeClass('modal--active');
			$('.modal-bg').removeClass('modal-bg--active');
		});

		$('#openModal').click(() => {
			openModal();
		});
	}

	function openModal () {
		$('.modal').addClass('modal--active');
		$('.modal-bg').addClass('modal-bg--active');
	}

	function openModalAfterLoadPage () {
		setTimeout(() => {
			openModal();
		}, 2000);
	}

	function countryCode () {
		// ne po
		$.get("https://ipinfo.io", (response) => {
			const countryUser = response.country.toLowerCase();

			console.log(countryUser);

			return;

			$.ajax({
				dataType: 'json',
				url: "./js/data.json",
				type: 'get',
				async: false,
				success: function (data) {
					[...data].forEach((item) => {
						if (response.country == item.code) {
							$("#country_ip").text(item.countryName);
						}
					});
				}
			});

			let registerPhone = $("#registr-phone");

			if (registerPhone.length) {
				registerPhone.CcPicker({"countryCode":contryUser});
			}
		}, "jsonp");
	}

});
