<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Lehrauftrag</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<style>
		@page {
			margin: 0px;
			font-family: GOTHIC;
		}

		html {
			margin: 0px
		}

		body {
			margin: 0px;
			font-family: GOTHIC;
		}

		h1,
		h4 {
			font-family: GOTHIC;
		}

		table {
			border-collapse: collapse;
		}

		@font-face {
			font-family: 'GOTHIC';
			font-style: normal;
			font-weight: normal;
			src:
				url(https://app.nextlevel-akademie.de/cosmetic-school/vendor/dompdf/dompdf/lib/fonts/GOTHIC.TTF) format('truetype');
		}

		@font-face {
			font-family: 'GOTHICB';
			font-style: normal;
			font-weight: 700;
			src:
				url(https://app.nextlevel-akademie.de/cosmetic-school/vendor/dompdf/dompdf/lib/fonts/GOTHICB.TTF) format('truetype');
		}

		table thead tr th {
			font-family: 'GOTHICB';
		}

		b {
			font-family: 'GOTHICB';
		}

		table tbody tr td {
			font-family: 'GOTHIC';
		}

		header {
			position: fixed;
			top: 25px;
			left: 0px;
			right: 0px;
			height: 50px;
		}

		footer {
			position: fixed;
			bottom: 10px;
			left: 0px;
			right: 0px;
			height: 50px;
		}

		.page {
			page-break-after: always;
			overflow: hidden;
		}

		.last-page {
			page-break-after: never;
			overflow: hidden;
		}
	</style>
</head>

<body style="padding-left: 50px; padding-right: 50px; padding-bottom: 50px; padding-top: 50px">
	<header>
		<table width="520" style="padding-left: 50px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td><img src="images/logo.png" width="250px" height="auto" /></td>
			</tr>
		</table>
	</header>
	<footer>
		<table width="520" style="padding-left: 150px; padding-right: 50px; font-size: 12px;">
			<tr>
				<td align="center" style="color: #9B9B9B;">NextLevel Akademie – Inh.
					Gülhan Dündar - Bundesallee 86 - 12161 Berlin <br /> Tel. 030/89640064
					- info@nextlevel-akademie.de - www.nextlevel-akademie.de

				</td>
			</tr>
		</table>
	</footer>
	<main>

		<!-------------------------------------------------------->
		<div class="page">
			<table width="520" style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
				<tr>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						Hallo <b><?php echo $coach_detail->name; ?>,</b>
					</td>
				</tr>
				<tr>
					<td><br /></td>
				</tr>
				<tr>
					<td style="text-align: justify;">vielen Dank für dein abgegebenes Angebot für das coaching <b><?= $course_detail->title ?></b>. Dein Angebot wurde angenommen und du bist somit fest gebucht.
					</td>
				</tr>
				<tr>
					<td><br /></td>
				</tr>
				<tr>
					<td style="text-align: justify;">Wir freuen uns, mit dir als NextLevel-Wegbegleiter unsere Kunden auf seiner Reise zu begleifen.
					</td>
				</tr>

			</table>
			<table width="520" style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
				<tr>
					<td align="center" style="font-size: 20px;">
						<b>
							Vereinbarung eines Auftrages
						</b>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						<br />zwischen
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						der NextLevel Akademie, Bundesallee 86, 12161 Berlin
					</td>
				</tr>
				<tr>
					<td align="right">
						<b>Im Folgenden: Auftraggeber </b>
					</td>
				</tr>
				<tr>
					<td>
						<br />und
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<?php $gender = $coach_detail->gender == 'Female' ? 'Frau' : 'Herr'; ?>
				<tr>
					<td>
						<?php echo $coach_detail->name; ?> <?php echo $coach_detail->address; ?> <?php echo $coach_detail->door_no; ?> <?php if (isset($coach_detail->zip_code)) echo $coach_detail->zip_code; ?> <?php if (isset($coach_detail->city)) echo $coach_detail->city; ?> <?php echo $gender; ?>
					</td>
				</tr>
				<tr>
					<td align="right">
						<b>Im Folgenden: Auftragnehmer </b>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td align="left">
						<b>1. Einsatzdetails/Coachingauftrag: </b>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<?php if (count($product_details)) { ?>
					<?php foreach ($product_details as $key => $value) { ?>
						<tr>
							<td>
								<table>
									<tr valign="top">
										<td>Produkf:</td>
										<td style="padding-left: 20px;"> <?php echo $key ?></td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr>
										<td></td>
										<td style="text-align: justify;padding-left:20px;">Ggf. Erweiterung auf andere Produkte gemäß §45 SGB II</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<?php foreach($value as $key1 => $value1) { ?>
										<tr valign="top">
											<td></td>
											<td style="text-align: justify;padding-left: 20px;"><?php echo $key1 ?></td>
										</tr>
										<?php $i=1;foreach($value1 as $key2 => $value2) { ?>
											<tr valign="top">
												<td></td>
												<td style="text-align: justify;padding-left: 40px;">- <?php echo $value2 ?></td>
											</tr>
										<?php $i++;} ?>	
									<?php } ?>	
									
									<tr>
										<td></td>
										<td><br /></td>
									</tr>

								</table>
							</td>
						</tr>
				<?php }
				} ?>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						<table>
							<tr valign="top">
								<td>Zeitraum:</td>
								<td style="text-align: justify;padding-left:0px;">Dieser Auftrag ist befristet für die Zeit vom <?php echo date('d.m.Y',strtotime($offer_detail->begin_date))?> bis <?php echo date('d.m.Y',strtotime($offer_detail->end_date))?> je nach vereinbartem Einzelterminen.
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="page">	
			<?php $implode_products = [];
			      foreach($product_details as $key => $value) { 
                     $implode_products[] = $key;
				  }
				  $implode = implode(",",$implode_products); 
			?>	  	 
			<table width="520" style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
				<tr>
					<td>Einsatzort:</td>
					<td>NextLevel Akademie</td>
				</tr>
				<tr>
					<td></td>
					<td style="padding-left: 30px;">
				    <?php foreach($rooms as $key => $value) { ?>
						<?php echo $value; ?><br>
					<?php } ?>	
				   </td>
				</tr>
				<tr>
					<td><br /></td>
				</tr>
				<tr>
					<td>Ziel:</td>
					<td style="text-align: justify;">Die Parteien haben sich über folgende Thematik des Auftrags verständigt. Rahmen dieser Thematik İst der Auftragnehmer in der Erfüllung des Auftrages frei. Rahmen des Jobcoachings <b><?php echo $implode;?></b> werden in den Modulen 1-3, persönliche, soziale und berufliche Kompetenzen behandelt. Ziel für jedes Modul İst die Heranführung des Coachee in den. 1. Arbeitsmarkt.</td>
				</tr>
			</table>
			<table width="520" style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<?php $price = $coach_detail->price_ue != '' ? $coach_detail->price_ue : 25; ?>
				<tr>
					<td>
						<b>2. Dokumentation</b>
					</td>
				</tr>
				<tr>
					<td>
					  Der Auftragnehmer wird die Erfüllung des Auftrages geeignet dokumentieren und dem Auftraggeber auf Anforderung eine derartige Dokumentation zur Verfügung stellen
					</td>
				</tr>
				<tr>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						<b>3. Abrechnung/Honorar/Auftragsinhalt</b>
					</td>
				</tr>
				<tr>
					<td>
					 Das Honorar pro tatsachlich nachgewiesener Abrechnungseinheit betragt <?php echo $price; ?> &euro;. Als Abrechnungseinheit ist eine Abrechnungseinheit ZU 45 Minuten definiert. Mit dem vereinbarten Honorar Sind aile Aufwande des Auftragnehmers, insbesondere Fahrtkosten, Vor- und Nachbereitungsaufwand, abgegolten.
					</td>
				</tr>
				<tr>
					<td><br /></td>
				</tr>
				<tr>
					<td style="text-align: justify;"> 3.1 Der Auftrag umfasst folgende Tatigkeiten, die das Tageshonorar und die Abrechnung definieren:</td>
				</tr>
				<tr>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						<table>
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">a.</td>
								<td>Coachingvorbereitung / digitale Terminierung über das NextLevel Buchungsportal.</td>
							</tr>
							
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">b.</td>
								<td>Coachingdurchführung im Fachgebiet mit an die/den Teilnehmer angepasster Methodenvielfalt</td>
							</tr>
							
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">c.</td>
								<td>Erfüllung der o.g. Zielvereinbarung (wie in Tagesdokumentation vorgegeben)</td>
							</tr>
							
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">d.</td>
								<td>Coaching-Dokumentation inklusive Unterschriften als Nachweis bei jedem Termin.</td>
							</tr>
							
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">e.</td>
								<td>
								Mitteilungspflicht bei besonderen Ereignissen:<br>
									-Beschwerden<br>
									-auffallige Situationen/Verhalten<br>
									-Krankheit (Meldepflicht)<br>
									-Urlaubsplanung (Meldepflicht)<br>
									-Sonstiges
								</td>
							</tr>

						</table>
					</td>
				</tr>

			</table>
		</div>
		<!--------------------------------------------------------->
		<div class="last-page">
			<table width="520" style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
				<tr>
					<td style="text-align: justify;">
					3.2   Die Abrechnung kann erst erfolgen, wenn alle im Auftrag definierten Tatigkeiten und Zielvereinbarungen durchgetuhrt, eingereicht und durch den Auttraggeber gepruft wurden.
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td style="text-align: justify;">
					3.3   Storno/Krankheiten/Verhinderungen:
					</td>
				</tr>
				<tr>
					<td style="text-align: justify;">
					Ausgefallene Leistungstermine mussen in Absprache mit dem Auftraggeber und dem Kunden/Coachee neu vereinbart, nachgeholt und uber das digitale Buchungssystem durch den Coaching-Koordinator neu nachgeptlegt werden.
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td style="text-align: justify;">
					Ansprechpartner fur die Mitteilung von Leistungsverhinderungen sind Aleksandra Marszalek und Marc Rau telefonisch unter 030/89 64 00 64 Oder per Mail info@nextlevel-akademie.de
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td style="text-align: justify;">
					<b>4. Anspruche/Fristen</b>
					</td>
				</tr>
				<tr>
					<td style="text-align: justify;">
					Aller beiderseitigen Anspruche aus diesem Vertrag mit Ausnahme von Anspruchen, die aus der Verletzung des Lebens, des Korpers und der Gesundheit sowie aus vorsatzlichen Oder grob fahrlassigen Pflichtverletzungen resultieren, mussen innerhalb von drei Monaten nach Falligkeit schriftlich geltend gemacht werden. Der Fristlauf beginnt nicht, bevor der Glaubiger von dem Anspruch begrundenden Umstanden Kenntnis erlangt hat Oder ohne grobe Fahrlassigkeit hatte erlangen mussen. Wird ein Anspruch nicht formgemaB innerhalb der Fristen geltend gemacht, so fuhrt dies zu seinem endgultigen Erldschen.
					</td>
				</tr>
				
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td style="text-align: justify;">
					<b>5.</b> Im Ubrigen gelten die Regelungen des Rahmenvertrages.
					</td>
				</tr>
			
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td style="padding-right:50px;">Berlin, </td>
								<td>Berlin, </td>
							</tr>
							<tr>
								<td style="padding-right:80px;"><br /> <br /> <br /><br /> <br /> <br /></td>
								<td style="padding-left: 80px;"><?php
																echo "<br /> <br /> <br /><br /> <br /> <br />";
																?></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 80px;">_________________________________<br>Auftragnehmer </td>
					</td>
					<td style="padding-left: 80px;">_________________________________<br> NextLevel
									Akademie</td>
				</tr>
			</table>
			</td>
			</tr>
			</table>
		</div>
	</main>
</body>

</html>