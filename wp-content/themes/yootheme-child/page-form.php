<?php
/*
Template Name: Form
 */

get_header('calc');

?>
<div class="wrap">
	<div class="container">
		<section class="info">
			<address class="info__address">
				<figure class="info__icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
						<circle cx="12" cy="10" r="3"></circle>
					</svg>
				</figure>
				<small class="info__address-name">Agda Helins Väg 10, 43351 Öjersjö</small>
			</address>
			<div class="info__title-block">
				<h1 class="info__title">Här är ditt kostnadsförslag för solpaneler</h1>
				<p class="info__subtitle">Våra robotar har beräknat dina solpanelsalternativ och gjort det här paketet personligt för dig. <span class="info__subtitle-second"> Skrolla ned eller <button class="info__btn-calc" type="button"> klicka här</button> för att sätta samman ditt paket.</span></p>
			</div>
		</section>

		<section class="instruction">
			<div class="instruction__item">
				<img class="instruction__img" src="/wp-content/themes/yootheme-child/assets/images/panel.png" alt="panel">
				<div class="instruction__info">
					<h3 class="instruction__title">Standard - 360W</h3>
					<span class="instruction__desc">Vald paneltyp</span>
				</div>
			</div>
			<div class="instruction__item">
				<img class="instruction__img" src="/wp-content/themes/yootheme-child/assets/images/buy.png" alt="buy">
				<div class="instruction__info">
					<h3 class="instruction__title">Starter - 10</h3>
					<span class="instruction__desc">Valt antal paneler</span>
				</div>
			</div>
			<div class="instruction__item">
				<img class="instruction__img" src="/wp-content/themes/yootheme-child/assets/images/house.png" alt="house">
				<div class="instruction__info">
					<h3 class="instruction__title">3 400 kWh</h3>
					<span class="instruction__desc">Uppskattad årsproduktion</span>
				</div>
			</div>
		</section>

		<section class="calc">
			<h2 class="calc__title">Hur mycket pengar kommer jag att spara?</h2>
			<div class="calc__section">
				<div class="calc__control">
					<h3 class="calc__subtitle">Vad är din månadsräkning?</h3>
					<p class="calc__desc">Din månadsräkning används för att beräkna mer exakta besparingar</p>
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
						<img class="grid__icon" src="/wp-content/themes/yootheme-child/assets/images/grid-1.svg" alt="grid-1">
						<div class="grid__name">
							<span class="grid__value">
								<small class="grid__count">200 000</small>
								kr
							</span>
							<small class="grid__separ">-</small>
							<span class="grid__value">
								<small class="grid__count">270 000</small>
								kr
							</span>
						</div>
						<span class="grid__desc">Total besparing</span>
					</div>
					<div class="grid__item">
						<img class="grid__icon" src="/wp-content/themes/yootheme-child/assets/images/grid-2.svg" alt="grid-2">
						<div class="grid__name">
							<span class="grid__value">
								<small class="grid__count">7 000</small>
								kr
							</span>
							<small class="grid__separ">-</small>
							<span class="grid__value">
								<small class="grid__count">9 000</small>
								kr
							</span>
						</div>
						<span class="grid__desc">Genomsnittligt årligt sparande</span>
					</div>
					<div class="grid__item">
						<img class="grid__icon" src="/wp-content/themes/yootheme-child/assets/images/grid-3.svg" alt="grid-3">
						<div class="grid__name">
							<span class="grid__value">
								<small class="grid__count">400</small>
								kr
							</span>
							<small class="grid__separ">-</small>
							<span class="grid__value">
								<small class="grid__count">600</small>
								kr
							</span>
						</div>
						<span class="grid__desc">Besparing per månad</span>
					</div>
					<div class="grid__item">
						<img class="grid__icon" src="/wp-content/themes/yootheme-child/assets/images/grid-4.svg" alt="grid-4">
						<div class="grid__name">
							<span class="grid__value">
								<small class="grid__count">1367</small>
								kr
							</span>
						</div>
						<span class="grid__desc">Besparad CO2/år</span>
					</div>
				</div>
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
					<mark class="warranty__mark">Ny!</mark>
					Utökad garanti från Otovo ingår
				</h3>
				<p class="warranty__desc">Vi säkerställer kvalitet i allt vi gör. Att vår utökade garanti ingår i priset är bevis på detta. Medan de flesta av våra konkurrenter väljer att endast erbjuda minimala 5 år, går vi ett steg längre:</p>
				<p class="warranty__item">
					<img class="warranty__icon" src="/wp-content/themes/yootheme-child/assets/images/check.svg" alt="check" />
					Hela leasingperioden, upp till 20 år.
				</p>
				<p class="warranty__item">
					<img class="warranty__icon" src="/wp-content/themes/yootheme-child/assets/images/check.svg" alt="check" />
					10 år för direktköp.
				</p>
				<a href="#" class="warranty__link" target="_blank">Lär dig mer om våra garantier<img class="warranty__link-icon" src="/wp-content/themes/yootheme-child/assets/images/link.svg" alt="link" /></a>
			</div>
		</section>

		<section class="types" id="types">
			<h2 class="types__title">Välj typ av solpanel</h2>
			<div class="types__wrap">
				<div class="types__btns">
					<button class="types__btn types__btn--active" type="button" name="button" data-value="360" data-name="standart">
						<span class="types__name">Standard</span>
						<span class="types__value">360W</span>
					</button>
					<button class="types__btn" type="button" name="button" data-value="390" data-name="premium">
						<span class="types__name">Premium</span>
						<span class="types__value">390W</span>
					</button>
					<button class="types__btn" type="button" name="button" data-value="400" data-name="performance">
						<span class="types__name">Performance</span>
						<span class="types__value">400KW</span>
					</button>
				</div>
				<div class="types__details">
					<h3 class="types__subtitle">Standardpaneler</h3>
					<div class="types__content types__content--active" data-content="standart">
						<p class="types__curr">
							<img class="warranty__icon" src="/wp-content/themes/yootheme-child/assets/images/check-blue.svg" alt="check" />
							365 watt per panel
						</p>
						<p class="types__desc">Otovos standardpaneler är högkvalitativa solpaneler till ett rimligt pris, tillverkade av de största och högst ansedda tillverkarna på marknaden. Passar de som vill prisvärda kvalitativa solpaneler.</p>
					</div>
					<div class="types__content" data-content="premium">
						<p class="types__curr">
							<img class="warranty__icon" src="/wp-content/themes/yootheme-child/assets/images/check-blue.svg" alt="check" />
							390 watt per panel
						</p>
						<p class="types__desc">Otovos premiumpaneler är bland de bästa solpanelerna valda från de största tillverkarna. Premiumpaneler ger den bästa avvägningen mellan prestanda och pris, och är den panelen som de flesta av våra kunde väljer.</p>
					</div>
					<div class="types__content" data-content="performance">
						<p class="types__curr">
							<img class="warranty__icon" src="/wp-content/themes/yootheme-child/assets/images/check-blue.svg" alt="check" />
							400 watt per panel
						</p>
						<p class="types__desc">Med norskproducerade "wafers" har Otovos performancepanel världens lägsta koldioxidavtryck och den högsta möjliga prestandan på marknaden. När bara det allra bästa är bra nog.</p>
					</div>
				</div>
				<picture class="types__picture">
					<img class="types__img" data-name="standart" src="/wp-content/themes/yootheme-child/assets/images/standart.png" alt="standart panel">
					<img class="types__img" data-name="premium" src="/wp-content/themes/yootheme-child/assets/images/premium.png" alt="premium panel">
					<img class="types__img" data-name="performance" src="/wp-content/themes/yootheme-child/assets/images/performance.png" alt="performance panel">
				</picture>
			</div>
		</section>

		<div class="sticky-footer">
			<div class="sticky-footer__wrap">
				<div class="sticky-footer__data">
					<div class="sticky-footer__block">
						<h4 class="sticky-footer__title">Pris</h4>
						<span class="sticky-footer__count">525 kr/mnd</span>
					</div>
					<div class="sticky-footer__block">
						<h4 class="sticky-footer__title">Uppskattad besparing</h4>
						<span class="sticky-footer__count">200 000 kr-270 000 kr</span>
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
		<h2 class="modal__title">Få erbjudande</h2>
		<p class="modal__subtext">Priserna du såg gäller till lördag 7 maj.</p>
		<p class="modal__text">Lämna dina uppgifter, så ringer vi dig för att diskutera detaljerna i ditt erbjudande och svara på alla dina frågor.</p>
		<form class="form" action="index.html" method="post">
			<div class="form__field-wrap">
				<label class="form__label" for="">Förnamn och efternamn</label>
				<input class="form__field" type="text">
			</div>
			<div class="form__field-wrap">
				<label class="form__label" for="">Telefon</label>
				<input class="form__field" type="text">
			</div>
			<div class="form__field-wrap">
				<label class="form__label" for="">E-post</label>
				<input class="form__field" type="email">
			</div>
			<label class="form__agree">
				<input class="form__checkbox" type="checkbox">
				<p class="form__agree-text">Jag vill lära mig mer om solceller och solenergi</p>
			</label>
			<p class="form__desc">Lär dig mer om solenergi, stödsystem, produktnyheter och andra erbjudanden</p>
			<button class="form__submit" type="submit">Skicka</button>
		</form>
	</div>
	<button class="modal__close" type="button" name="button">
		<img class="modal__icon" src="/wp-content/themes/yootheme-child/assets/images/cancel.svg" alt="cancel">
	</button>
</div>
</div>
<?php

get_footer('calc');
