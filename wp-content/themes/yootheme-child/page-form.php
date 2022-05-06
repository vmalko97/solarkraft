<?php
/*
Template Name: Form
 */

if(isset($_POST['address'])){
get_header('calc');

$fields = get_fields();

$paramsCalc = [];
$solar_list = [];
$index = 1;
foreach ($fields['solars'] as $solar){
	$paramsCalc[$solar['annual_production']] = [
			'title' => $solar['title'],
			'saving' => $solar['projected_monthly_saving'],
			'info' => [
				  'name' => $solar['info']['name'],
				  'count' => $solar['info']['panels_count'],
				  'kw' => $solar['info']['power'],
			],
			'grid' => [
					'lifetime' => [ $solar['grid']['lifetime_estimated_return']['min'], $solar['grid']['lifetime_estimated_return']['max'] ],
					'annual' => $solar['grid']['projected_annual_saving_on_electric_bill'],
					'month' => $solar['grid']['projected_monthly_saving'],
					'size' => $solar['grid']['size']
			],
	];
	$solar_list[$index] =  $solar;
	$index++;
}
$index = 1;
?>
<script>
    const paramsCalc = <?=json_encode($paramsCalc);?>;
    var address = "<?=$_POST['address']; ?>";
</script>

<div class="wrap">
	<div id="form-page" class="container">
		<section class="info">
			<address class="info__address">
				<figure class="info__icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
						<circle cx="12" cy="10" r="3"></circle>
					</svg>
				</figure>
				<small class="info__address-name"><?=$_POST['address'];?></small>
			</address>
			<div class="info__title-block">
				<h1 class="info__title"><?=$fields['title']; ?></h1>
			</div>
		</section>

		<section class="instruction">
			<div class="instruction__item">
				<img class="instruction__img" src="<?=$fields['top_first_icon']; ?>" alt="buy">
				<div class="instruction__info">
					<h3 class="instruction__title">
						<span class="instruction__name" data-name="name">Standard - 360W</span>
					</h3>
					<span class="instruction__desc" data-name="name"></span>
				</div>
			</div>
			<div class="instruction__item">
				<img class="instruction__img" src="<?=$fields['top_second_icon']; ?>" alt="panel">
				<div class="instruction__info">
					<h3 class="instruction__title">Starter -
						<span class="instruction__name" data-name="count">10</span>
					</h3>
					<span class="instruction__desc"><?=$fields['second_icon_description']; ?></span>
				</div>
			</div>
			<div class="instruction__item">
				<img class="instruction__img" src="<?=$fields['top_third_icon']; ?>" alt="house">
				<div class="instruction__info">
					<h3 class="instruction__title">
						<span class="instruction__name" data-name="kw">1000</span>
					 kWh</h3>
					<span class="instruction__desc"><?=$fields['third_icon_description']; ?></span>
				</div>
			</div>
		</section>

		<section class="calc">
			<h2 class="calc__title"><?=$fields['calc_title']; ?></h2>
			<div class="calc__section">
				<div class="calc__control">
					<h3 class="calc__subtitle"><?=$fields['calc_subtitle']; ?></h3>
					<p class="calc__desc"><?=$fields['calc_description']; ?></p>
					<input type="text" class="calc__num" value="2000" id="amount" data-min="1000" data-max="9000" readonly>
					<div class="calc__range">
						<div class="calc__range-line" id="slider"></div>
						<div class="calc__values">
							<span class="calc__value calc__value--min">1500 kr</span>
							<span class="calc__value calc__value--max">5000 kr</span>
						</div>
					</div>
					<label class="calc__switch" for="switch">
						<input type="checkbox" name="switch" id="switch">
						<span class="calc__name">Inkludera batterier</span>
					</label>
				</div>
				<div class="grid">
					<div class="grid__item">
						<img class="grid__icon" src="<?=$fields['grid_first_item_icon']; ?>" alt="grid-1">
						<div class="grid__name" data-name='lifetime'>
							<span class="grid__value">
								<small class="grid__count grid__count--from">240 000</small>
								kr
							</span>
							<small class="grid__separ">-</small>
							<span class="grid__value">
								<small class="grid__count grid__count--to">310 000</small>
								kr
							</span>
						</div>
						<span class="grid__desc"><?=$fields['grid_first_item_description']; ?></span>
					</div>
					<div class="grid__item">
						<img class="grid__icon" src="<?=$fields['grid_second_item_icon']; ?>" alt="grid-2">
						<div class="grid__name" data-name='annual'>
							<span class="grid__value">
								<small class="grid__count">8640</small>
								kr
							</span>
							<!-- <small class="grid__separ">-</small>
							<span class="grid__value">
								<small class="grid__count">9 000</small>
								kr
							</span> -->
						</div>
						<span class="grid__desc"><?=$fields['grid_second_item_description']; ?></span>
					</div>
					<div class="grid__item">
						<img class="grid__icon" src="<?=$fields['grid_third_item_icon']; ?>" alt="grid-3">
						<div class="grid__name" data-name='month'>
							<span class="grid__value">
								<small class="grid__count">720</small>
								kr
							</span>
							<!-- <small class="grid__separ">-</small>
							<span class="grid__value">
								<small class="grid__count">600</small>
								kr
							</span> -->
						</div>
						<span class="grid__desc"><?=$fields['grid_third_item_description']; ?></span>
					</div>
					<div class="grid__item">
						<img class="grid__icon" src="<?=$fields['grid_fourth_item_icon']; ?>" alt="grid-4">
						<div class="grid__name" data-name='size'>
							<span class="grid__value">
								<small class="grid__count">5KW (11 panels)</small>
							</span>
						</div>
						<span class="grid__desc"><?=$fields['grid_fourth_item_description']; ?></span>
					</div>
				</div>
			</div>
		</section>

		<section class="types" id="types">
			<h2 class="types__title"><?=$fields['solar_types_title']; ?></h2>
			<div class="types__wrap">
				<div class="types__btns">
					<?php
					foreach ($solar_list as $index => $solar){ ?>
					<button class="types__btn <?php if($index == 1){
						echo "types__btn--active";
					}?>" type="button" name="button" data-value="<?=$solar['annual_production'];?>" data-name="<?=$index;?>">
						<span class="types__name"><?=$solar['title']?></span>
						<span class="types__value"></span>
					</button>
					<?php } ?>
				</div>
				<div class="types__details">
					<h3 class="types__subtitle"><?=$fields['solar_types_subtitle']; ?></h3>
					<div class="types__content">
						<h4 class="types__curr">
							<img class="warranty__icon" src="/wp-content/themes/yootheme-child/assets/images/check-blue.svg" alt="check" />
							<span class="types__title-name"></span>
						</h4>
						<div class="types__desc">
							<?=$fields['solar_types_description']; ?>
						</div>
					</div>
				</div>
				<picture class="types__picture">
					<?php
					foreach ($solar_list as $index => $solar){ ?>
					<img class="types__img" data-name="<?=$index;?>" src="<?=$solar['photo']?>" alt="standart panel">
					<?php } ?>
				</picture>
			</div>
		</section>

		<section class="warranty">
			<div class="graph">
				<div class="graph__item">
					<h3 class="graph__title">Branschnorm (5 år)</h3>
					<small class="graph__line graph__line--1"></small>
				</div>
				<div class="graph__item">
					<h3 class="graph__title">Med direktköp</h3>
					<small class="graph__line graph__line--2"></small>
				</div>
				<div class="graph__item">
					<h3 class="graph__title">För leasingkunder</h3>
					<small class="graph__line graph__line--3"></small>
				</div>
				<div class="graph__scale">
					<span class="graph__point">0 år</span>
					<span class="graph__point">10 år</span>
					<span class="graph__point">20 år</span>
				</div>
			</div>
			<div class="warranty__info">
				<h3 class="warranty__title">
					<mark class="warranty__mark"><?=$fields['warranty_mark']; ?></mark>
					<?=$fields['waranry_title']; ?>
				</h3>
				<p class="warranty__desc"><?=$fields['warranty_description']; ?></p>
				<?php foreach ($fields['warranty_description'] as $field){ ?>
				<p class="warranty__item">
					<img class="warranty__icon" src="/wp-content/themes/yootheme-child/assets/images/check.svg" alt="check" />
					<?=$field['description']; ?>
				</p>
				<?php } ?>

				<a href="<?=$fields['warranty_link'];?>" class="warranty__link" target="_blank"><?=$fields['warranty_link_title']; ?><img class="warranty__link-icon" src="/wp-content/themes/yootheme-child/assets/images/link.svg" alt="link" /></a>
			</div>
		</section>

		<div class="sticky-footer">
			<div class="sticky-footer__wrap">
				<div class="sticky-footer__data">
					<div class="sticky-footer__block">
						<h4 class="sticky-footer__title">Pris</h4>
						<span class="sticky-footer__count"><small class="sticky-footer__saving">525</small> kr/mnd</span>
					</div>
					<div class="sticky-footer__block">
						<h4 class="sticky-footer__title">Uppskattad besparing</h4>
						<span id="savingPanel" class="sticky-footer__count">200 000 kr-270 000 kr</span>
					</div>
				</div>
				<button class="sticky-footer__btn" id="openModal" type="button" name="button">
					<span class="sticky-footer__btn-text">Få erbjudande</span>
					<img class="sticky-footer__icon" src="/wp-content/themes/yootheme-child/assets/images/arrow.svg" alt="arrow">
				</button>
			</div>
		</div>
	</div>

	<div class="modal-bg"></div>
	<div class="modal">
		<div class="modal__content">
			<h2 class="modal__title"><?=$fields['modal_title']; ?></h2>
			<!-- <p class="modal__subtext"><?=$fields['modal_subtitle']; ?></p> -->
			<p class="modal__text"><?=$fields['modal_text']; ?></p>
			<form class="form" id="solar_order" method="post">
				<input type="hidden" name="action" value="solar_order" />
				<input type="hidden" name="latitude">
				<input type="hidden" name="longitude">
				<input type="hidden" name="address">
				<div class="form__field-wrap">
					<label class="form__label" for="nameField">Förnamn och efternamn</label>
					<input class="form__field" id="nameField" type="text" name="name">
				</div>
				<div class="form__field-wrap">
					<label class="form__label" for="phoneField">Telefon</label>
					<div class="form__wrap">
						<input class="form__field" id="phoneField" type="text" maxlength="11" name="phoneField">
					</div>
				</div>
				<div class="form__field-wrap">
					<label class="form__label" for="emailField">E-post</label>
					<input class="form__field" id="emailField" type="email" name="email">
				</div>
				<label class="form__agree">
					<input class="form__checkbox" type="checkbox">
					<p class="form__agree-text"><?=$fields['modal_agree_text']; ?></p>
				</label>
				<p class="form__desc"><?=$fields['modal_description']; ?></p>
				<button class="form__submit" type="submit">Skicka</button>
			</form>
		</div>
		<button class="modal__close" type="button" name="button">
			<img class="modal__icon" src="/wp-content/themes/yootheme-child/assets/images/cancel.svg" alt="cancel">
		</button>
	</div>

	<div class="address-page">
		<div class="address-page__map" id="map"></div>
		<form class="address-page__form" id="solar_order" method="post">
			<button type="button" class="address-page__btn map_to_form">
				Fortsätt
				<img class="address-page__icon" src="/wp-content/themes/yootheme-child/assets/images/arrow.svg" alt="arrow">
			</button>
		</form>
		<p class="address-page__text">Var vänlig och markera i vilket tak panelerna ska installeras.</p>
	</div>
</div>
<?php

get_footer('calc');
}else{
	?>
	<script>location.href = "<?=home_url();?>";</script>
<?php
}
