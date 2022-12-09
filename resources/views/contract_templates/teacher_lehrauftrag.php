<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Lehrauftrag</title>
<link rel="stylesheet" type="text/css"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
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

h1, h4 {
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
		url(https://app.nextlevel-akademie.de/cosmetic-school/vendor/dompdf/dompdf/lib/fonts/GOTHIC.TTF)
		format('truetype');
}

@font-face {
	font-family: 'GOTHICB';
	font-style: normal;
	font-weight: 700;
	src:
		url(https://app.nextlevel-akademie.de/cosmetic-school/vendor/dompdf/dompdf/lib/fonts/GOTHICB.TTF)
		format('truetype');
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
<body
	style="padding-left: 50px; padding-right: 50px; padding-bottom: 50px; padding-top: 50px">
	<header>
	<table width="520"
		style="padding-left: 50px; padding-right: 10px; font-size: 14px;">
		<tr>
			<td><img src="images/logo.png" width="250px" height="auto" /></td>
		</tr>
	</table>
	</header>
	<footer>
	<table width="520"
		style="padding-left: 150px; padding-right: 50px; font-size: 12px;">
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
			<table width="520"
				style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
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
						<br />Zwischen 
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
						<b>im Folgenden: Auftraggeber </b>
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
				<tr>
					<td>
						<?php if(isset($personal_details['salutation'])) echo $personal_details['salutation']; ?> <?php if(isset($personal_details['full_name'])) echo $personal_details['full_name']; ?> <?php if(isset($personal_details['address'])) echo $personal_details['address']; ?> 
					</td>
				</tr>
				<tr>
					<td align="right">
						<b>im Folgenden: Auftraggeber </b>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						<table>
							<tr valign="top">
								<td><b>1.</b></td>
								<td>Auftragsinhalt:</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px; color:#fff;">1.</td>
								<td style="text-align: justify;">Der Auftragnehmer wird für den Auftraggeber im 
								Rahmen des Aufbau-/Ausbildungs-/Umschulungslehrgang als freier Dozent/Trainer 
								für Mode-/Parfümeriefachverkäufer/in, Kaufmann/frau im Einzelhandel, Drogist/in 
								mit Zulassung zur IHK Externenprüfung vom Auftraggeber gebucht. Die Lehrinhalte 
								beinhalten die Thematiken <u><?php if(isset($contract_details['m_items'])) echo $contract_details['m_items']; ?></u>.</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px;"><b>2.</b></td>
								<td style="text-align: justify;">Dieser Lehrauftrag ist befristet für die Zeit vom <?php if(isset($contract_details['begin'])) echo $contract_details['begin']; ?> bis <?php if(isset($contract_details['end'])) echo $contract_details['end']; ?></td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px;"><b>3.</b></td>
								<td style="text-align: justify;">Als Ort und Zeit für den Lehrauftrag sind vereinbart:</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px;">Zeit: </td>
								<td style="text-align: justify;">je nach vereinbartem Einzeltermin (Bestätigung per Mail/Kalenderausdruck)
									08.30 – 15.30 Uhr (8 UE/Tag) inkl. Vor-/Nachbereitung_
								</td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px;">Ort:</td>
								<td style="text-align: justify;">NextLevel Akademie, Bundesallee 86, 12161 Berlin</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px;"><b>4.</b></td>
								<td style="text-align: justify;">
									Die Parteien haben sich über folgende Thematik des Lehrauftrags verständigt. Im Rahmen 
									dieser Thematik ist der Auftragnehmer in der Erfüllung des Lehrauftrages an den IHK 
									Rahmenlehrplan gebunden (s. Anhang). Der Auftragnehmer verpflichtet sich, sich über 
									die aktuellen Lehrpläne der IHK selbstständig zu informieren.
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>Ziel für o.g. Maßnahmen ist die Wissensvermittlung um die IHK Abschlussprüfung erfolgreich zu bestehen.</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						<table>
							<tr valign="top">
								<td style="padding-right: 10px;"><b>5.</b></td>
								<td style="text-align: justify;">
									Das Honorar pro tatsächlich nachgewiesenem Unterrichtstag beträgt 170 €/Tag. 
									Ein Unterrichtstag wird mit 8 Unterrichtseinheiten berechnet. Als Abrechnungseinheit 
									ist eine Unterrichtseinheit zu 45 Minuten definiert. Mit dem vereinbarten Honorar sind 
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
<!--------------------------------------------------------->
		<div class="last-page">
			<table width="520"
				style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
				<tr>
					<td>
						alle Aufwände des Auftragnehmers, insbesondere Fahrtkosten, Vor- und Nachbereitungsaufwand, 
						abgegolten.
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						Der Auftrag umfasst folgende Aufgaben, die Anteilig das Honorar bestimmen. Sollten ein oder 
						mehrere Auftragsteile nicht bearbeitet werden, verringert sich das Honorar entsprechend. 
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						<table>
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">a.</td>
								<td>a.	Unterrichtsvorbereitung / Nachbereitung (10%=17Euro)</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">b.</td>
								<td>Unterrichtsdurchführung im Fachgebiet mit an die Schüler angepasster Methodenvielfalt (60%=102Euro)</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">c.</td>
								<td>
									Pro Lernfeld und Teilnehmer müssen folgende Noten vergeben werden: 1 Klausur, 
									1 mündliche Note, 1 benoteter Test oder Projektarbeit, Selbstlerntage müssen 
									immer bewertet werden. (10%=17Euro)
								</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">d.</td>
								<td>
									Ausführliche, dem Lernfeld und jeweiligen Block zugeordnete Unterrichtsdokumentation 
									im digitalen Klassenbuch edupage.  (10%=17Euro)
								</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px; padding-left:20px;">e.</td>
								<td>
									Individuelle Teilnehmerdokumentation bei besonderen Ereignissen (Gespräche, Beschwerden, 
									Auffälliges Verhalten) (10%=17Euro)
								</td>
							</tr>
						
						</table>
						
					</td>
				</tr>
				<tr>
					<td></td>
					<td><br /></td>
				</tr>
				<tr>
					<td>
						<table>
							<tr valign="top">
								<td style="padding-right: 10px;"><b>7.</b></td>
								<td style="text-align: justify;">
									Ansprechpartner für die Mitteilung von Leistungsverhinderungen sind Susann Böldicke 
									und Katja Moewe telefonisch unter 030/896 400 64 oder per Mail info@nextlevel-akademie.de
								</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px;"><b>8.</b></td>
								<td style="text-align: justify;">
									Aller beiderseitigen Ansprüche aus diesem Vertrag mit Ausnahme von Ansprüchen, 
									die aus der Verletzung des Lebens, des Körpers und der Gesundheit sowie aus 
									vorsätzlichen oder grob fahrlässigen Pflichtverletzungen resultieren, müssen 
									innerhalb von drei Monaten nach Fälligkeit schriftlich geltend gemacht werden. 
									Der Fristlauf beginnt nicht, bevor der Gläubiger von den den Anspruch begründenden 
									Umständen Kenntnis erlangt hat oder ohne grobe Fahrlässigkeit hätte erlangen müssen. 
									Wird ein Anspruch nicht formgemäß innerhalb der Fristen geltend gemacht, so führt dies 
									zu seinem endgültigen Erlöschen. 
								</td>
							</tr>
							<tr>
								<td></td>
								<td><br /></td>
							</tr>
							<tr valign="top">
								<td style="padding-right: 10px;"><b>9.</b></td>
								<td style="text-align: justify;">
									Im Übrigen gelten die Regelungen des Rahmenvertrages.
								</td>
							</tr>
						</table>
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
								<td style="padding-right:50px;">Berlin, <?php if(isset($contract_details['begin_date'])) echo $contract_details['begin_date']; ?>	</td>
								<td>Berlin, <?php if(isset($contract_details['begin_date'])) echo $contract_details['begin_date']; ?></td>
							</tr>
							<tr>
							<td style="padding-right:80px;"><br /> <br /> <br /><br /> <br /> <br /></td>
							<td style="padding-left: 80px;"><?php 
							if(isset($contract_details['coach_signature']) && $contract_details['coach_signature'] != "") {					    
							    echo '<img src="signatures/' . $contract_details['coach_signature'] . '" width="250px" height="auto" />';
							} else
							echo "<br /> <br /> <br /><br /> <br /> <br />";
							?></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 80px;">_________________________________<br>NextLevel
									Akademie </td>
							</td>
							<td style="padding-left: 80px;">_________________________________<br> Auftragnehmer </td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</main>		
</body>
</html>