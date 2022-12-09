<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Vertrag über die Weiterbildung</title>
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
				Gülhan Dündar - Bundesallee 86 - 12161 Berlin<br> Tel. 030/89640064
					- info@nextlevel-akademie.de - www.nextlevel-akademie.de 
			
			</td>
		</tr>
	</table>
	</footer>
	<main>
	<div class="page">
		<table width="520"
			style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">

			<tr>
				<td align="center" style="font-size: 20px;"><b>Vertrag über die
						Weiterbildung</b></td>
			</tr>

			<tr>
				<td><br />Zwischen</td>
			</tr>

			<tr>
				<td><br />Nextlevel Akademie</td>
			</tr>
			<tr>
				<td>Bundesallee 86</td>
			</tr>
			<tr>
				<td>12161 Berlin</td>
			</tr>
			<tr>
				<td>vertreten durch: Frau Gülhan Dündar (Geschäftsführung)</td>
			</tr>
			<tr>
				<td>(nachstehend NLA genannt)</td>
			</tr>
			<tr>
				<td style="padding: 10px 0;">und</td>
			</tr>

			<tr>
				<td>
					<table>
						<tr>
							<td>Name, Vorname:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['full_name'])) echo $personal_details['full_name']; ?></td>
						</tr>
						<tr>
							<td>Geburtsdatum(-ort):</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['dob'])) echo $personal_details['dob']; ?></td>
						</tr>
						<tr>
							<td>Anschrift/PLZ/Ort:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['address'])) echo $personal_details['address']; ?></td>
						</tr>
						<tr>
							<td>Telefon/Handy:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['phone'])) echo $personal_details['phone']; ?></td>
						</tr>
						<tr>
							<td>E-Mail:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['email'])) echo $personal_details['email']; ?></td>
						</tr>
						<tr>
							<td>Gesetzlicher Vertreter:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['parent_name'])) echo $personal_details['parent_name']; ?></td>
						</tr>
						<tr>
							<td>Anschrift/PLZ/Ort:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['parent_address'])) echo $personal_details['parent_address']; ?></td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr>
							<td>Fördergeldgeber:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['funding_source'])) echo $personal_details['funding_source']; ?></td>
						</tr>
						<tr>
							<td>Ansprechpartner:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['funding_source_name'])) echo $personal_details['funding_source_name']; ?></td>
						</tr>
						<tr>
							<td>Anschrift/PLZ/Ort:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['funding_source_address'])) echo $personal_details['funding_source_address']; ?></td>
						</tr>
						<tr>
							<td>Telefon/Durchwahl:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['funding_source_phone'])) echo $personal_details['funding_source_phone']; ?></td>
						</tr>
						<tr>
							<td>E-Mail:</td>
							<td style="padding-left: 30px;"><?php if(isset($personal_details['funding_source_email'])) echo $personal_details['funding_source_email']; ?></td>
						</tr>
					</table>


				</td>

			</tr>
			<tr>
				<td style="text-align: justify"><br /> <b>Voraussetzung für den
						Abschluss dieses Vertrages ist die Vorlegung eines aktuellen
						Bewilligungsbescheides des Fördergeldgebers, aus dem sich ergibt,
						dass der Fördergeldgeber die Kosten der Weiterbildung, die unter
						Ziffer 4 dieses Vertrages geregelt sind, übernehmen wird.<br />
				</b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>1. Gegenstand und Dauer der Ausbildung</b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;">1.1</td>
							<td style="text-align: justify;">Gegenstand dieses Vertrages ist
								eine Weiterbildung <b>– <?php if(isset($contract_details['lehrgang'])) echo $contract_details['lehrgang']; ?></b>
							</td>
						</tr>
					</table>
				</td>
			</tr>

		</table>
	</div>
	<div class="page">
		<br /> <br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">

			<tr>
				<td>
					<table>
						<tr>
							<td>Maßnahmennr.:</td>
							<td style="padding-left: 30px;"><?php if(isset($contract_details['auth_no'])) echo $contract_details['auth_no']; ?></td>
						</tr>
						<tr>
							<td>Beginn:</td>
							<td style="padding-left: 30px;"><?php if(isset($contract_details['begin'])) echo $contract_details['begin']; ?></td>
						</tr>
						<tr>
							<td>Ende:</td>
							<td style="padding-left: 30px;"><?php if(isset($contract_details['end'])) echo $contract_details['end']; ?></td>
						</tr>
						<tr>
							<td>Kundennummer:</td>
							<td style="padding-left: 30px;"><?php if(isset($contract_details['customer_no'])) echo $contract_details['customer_no']; ?></td>
						</tr>

					</table>

					<td>
			
			</tr>

			<tr>
				<td><br />Als Wahlqualifikation wird festgelegt:</td>
			</tr>
			<tr>
				<td style="padding-left: 20px">
					<table>
					<?php if(isset($contract_details['elective_qualification'])) echo $contract_details['elective_qualification']; ?>
				</table>
				</td>
			</tr>
			<tr>
				<td style="text-align: justify"><br />Der theoretische Unterricht
					findet in den Räumlichkeiten der NLA in der Bundesallee 86, 12161
					Berlin, statt. (ggf. auch an anderen Orten wie zum Bsp. Nähschule)<br /></td>
			</tr>

			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;">1.2</td>
							<td>Der Vertrag beginnt am <?php if(isset($contract_details['begin'])) echo $contract_details['begin']; ?> und endet am <?php if(isset($contract_details['end'])) echo $contract_details['end']; ?>.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
						
							<td style="padding-right: 10px;">1.3</td>
							<td style="text-align: justify;">Das Weiterbildungsverhältnis kann
								sich auf Verlangen des Teilnehmers um maximal ein Jahr gem. §
								21 Abs. 3 BBiG verlängern, wenn er die Abschlussprüfung nicht
								bestanden hat. Ein zusätzlicher Bildungsgutschein ist dann
								nötig.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">1.4</td>
							<td style="text-align: justify;">Der in der <b>Anlage 1</b> zu
								diesem Vertrag ersichtliche <b>Termin- und Lehrplan</b> sowie
								die in der <b>Anlage 2 beigefügte Aufteilung der
									Weiterbildungsphasen</b> stellen <b>einen Bestandteil dieses
									Vertrages</b> dar. Die als <b>Anlage 3</b> beigefügte
								Hausordnung der NLA, die als <b>Anlage 4</b> beigefügten
								Allgemeinen Geschäftsbedingungen der NLA stellen einen
								wesentlichen Bestandteil dieses Vertrages.
							</td>
						</tr>
					</table> <br />
			
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>2. Rechte und Pflichten der NLA </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;">2.1</td>
							<td style="text-align: justify;">Die NLA verpflichtet sich, die
								fachtheoretischen Weiterbildungsinhalte mit dem Ziel des Bestehens der
								Internet Prüfung durch den schulischen Weiterzubildenden (m/w) zu vermitteln.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.2</td>
							<td style="text-align: justify;">Die NLA erstellt den Termin-und
								Lehrplan für die Weiterbildung. Die NLA behält sich vor, den Stoff- und
								Terminplan zu ändern.</td>
						</tr>

					</table>
				</td>
			</tr>
		</table>
	</div>
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.3</td>
							<td style="text-align: justify;">Die NLA führt täglich eine
								Anwesenheitskontrolle durch und dokumentiert diese. Auf Anfrage
								des Fördergeldgebers oder des BAföG Amtes informiert sie die
								diese über die An- und Abwesenheiten des Teilnehmers (m/w).</td>
						</tr>

						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.4.</td>
							<td style="text-align: justify;">Die NLA erstellt bei
								erfolgreichem Abschluss ein Abschlusszeugnis und bei nicht
								erfolgreichem Beenden der Weiterbildung ein Abgangszeugnis, sowie
								eine Teilnahmebescheinigung mit Angaben zum Inhalt, zeitlichen Umfang, Ziel der Maßnahme und zusätzlich erworbenen Kompetenzen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.5.</td>
							<td style="text-align: justify;">Die NLA bestimmt den Weiterbildungsbeginn und die Unterrichtszeiten. Sie behält sich
								vor, den Weiterbildungsbeginn oder die Unterrichtszeiten aus
								begründetem Anlass und mit rechtzeitiger Ankündigung zu ändern.
								Die Änderungen werden an der Infotafel (und digital über
								Edupage) ausgehangen. Die NLA informiert den Teilnehmer (m/w) über
								die Änderung mit dem Aushang der Information.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.6.</td>
							<td style="text-align: justify;">Die fachpraktische Weiterbildung
								erfolgt in einem geeigneten Kooperationsunternehmen. Die NLA verpflichtet
								sich, den Teilnehmer (m/w) bei der Suche nach einem
								Kooperationsunternehmen zu unterstützen. Der Teilnehmer (m/w)
								ist aber ausdrücklich aufgefordert Eigeninitiative in der Suche
								zu zeigen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.7.</td>
							<td style="text-align: justify;">Das jeweilige
								Kooperationsunternehmen erstellt bei Abschluss der Praxisphase
								ein qualifiziertes Zeugnis. Die NLA hat keine Pflicht, das von
								dem Kooperationsunternehmen erstellte Zeugnis zu überprüfen. Die
								NLA hat keinen Einfluss auf das von dem jeweiligen
								Kooperationsunternehmen erstellte Zeugnis.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.8.</td>
							<td style="text-align: justify;">Unter der Leitung des
								Kooperationsunternehmens findet die fachpraktische Weiterbildung
								entsprechend in dem geigneten Unternehmen statt. Das Kooperationsunternehmen ist gegenüber dem
								Teilnehmer (m/w) in allen weiterbildungsplatzbezogenen Fragen weisungsberechtigt. Die
								disziplinarische Verantwortung für den Teilnehmer (m/w) verbleibt bei der NLA.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.9.</td>
							<td style="text-align: justify;">Die NLA ist berechtigt, den
							    Weiterbildungsverlauf beim Kooperationsunternehmen zu
								kontrollieren. Die NLA hat das Recht, während der
								fachpraktischen Phase der Weiterbildung Kontakt zu seinen
								Teilnehmern (m/w) aufzunehmen und sich über die
								Leistungen und das Verhalten im Kooperationsunternehmen zu
								informieren</td>
						</tr>

					</table>
				</td>
			</tr>
		</table>
	</div>
	<!---------------------------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.10.</td>
							<td style="text-align: justify;">Die regelmäßige wöchentliche
								Arbeitszeit des Teilnehmers (m/w) beträgt im
								Kooperationsunternehmen 37,5 Stunden exklusive Pausen und wird
								individuell mit dem Kooperationsunternehmen abgesprochen.</td>
						</tr>

						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.11.</td>
							<td style="text-align: justify;">Die ersten 3 Monate der
								Theoriephase gelten als Probezeit innerhalb der NextLevel
								Akademie. Der erste Monat der Weiterbildung 
								gelten als Probezeit im Kooperationsunternehmen. Am Ende der
								Probezeit wird in einem gemeinsamen Gespräch zwischen der NLA,
								dem Kooperationsunternehmen und dem Teilnehmer
								(m/w) über die Fortführung der Weiterbildung
								entschieden.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.12.</td>
							<td style="text-align: justify;">Dem Teilnehmer (m/w) steht
								während der praktischen Phase kein Vergütungsanspruch zu. Etwas
								anderes kann gelten, wenn der Teilnehmer (m/w) mit dem
								Kooperationsunternehmen eine Vergütungsvereinbarung geschlossen
								hat. Etwaige Ansprüche auf die Zahlung der Vergütung müssen ggf.
								gegen das Kooperationsunternehmen und nicht gegen die NLA
								gerichtet werden.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.13.</td>
							<td style="text-align: justify;">Dem Teilnehmer (m/w) erhält im Laufe der Weiterbildung Lehrmaterialien und Literatur im Wert von ca. 155,00&euro;, die in seinem Eigentum verbleiben.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>3. Rechte und Pflichten des Teilnehmers (m/w)</b></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.1.</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w)
								versichert, dass gegen seine Teilnahme an der Weiterbildung keine
								gesundheitlichen Bedenken bestehen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.2.</td>
							<td style="text-align: justify;">Ist der Teilnehmer (m/w)
								unter 16 Jahre bekommt er mindestens 30 Werktage Urlaub pro
								Jahr, unter 17 Jahre bekommt er mindestens 27 Werktage Urlaub
								pro Jahr, unter 18 Jahre bekommt er mindestens 25 Werktage
								Urlaub. Erwachsene Teilnehmer haben einen Anspruch auf 25
								Werktage Urlaub pro Jahr. Die Ferien bzw. Urlaubstage werden von
								der NLA vor Beginn der Maßnahme festgelegt (*Änderungen
								vorbehalten).</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.3.</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) ist
								verpflichtet, den Termin- und Lehrplan zu befolgen. Der
								Teilnehmer (m/w) verpflichtet sich zur ordnungsgemäßen Anwesenheit
								an dem in dem Termin- und Lehrplan ersichtlichen Unterricht. Der
								Teilnehmer (m/w) verpflichtet sich zum Führen des Berichtsheftes
								und zur aktiven Mitwirkung am Unterricht.</td>
						</tr>


					</table>
				</td>
			</tr>

		</table>
	</div>
	<!---------------------------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.4.</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) ist
								verpflichtet, bei Krankheit die NLA unverzüglich zu informieren.
								Der Teilnehmer (m/w) ist verpflichtet, jede Krankheitsmeldung mit
								einer Arbeitsunfähigkeitsbescheinigung zu belegen. Eine Kopie
								der Arbeitsunfähigkeitsbescheinigung hat bei der NLA
								allerspätestens innerhalb von 3 Werktagen seit der
								Krankheitsmeldung einzugehen. Für den Fall, dass bei der NLA
								innerhalb der vorgenannten Frist keine
								Arbeitsunfähigkeitsbescheinigung eingeht, gilt die Abwesenheit
								des Teilnehmers (m/w) als unentschuldigt.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.5.</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) ist
								verpflichtet, auf Verlangen der NLA an einem Auswertungs- und
								Zielvereinbarungsgespräch mit der NLA teilzunehmen. Das Gespräch
								findet in den Räumlichkeiten der NLA oder in den Räumlichkeiten
								des Kooperationsunternehmens, in dem der Teilnehmer (m/w) die
								praktische Weiterbildungsphase hat, statt. Den Ort und die Zeit des
								Gesprächs bestimmt die NLA. Die NLA hat dabei die Belange des
								Teilnehmers (m/w) zu berücksichtigen. Als Belange des
								Teilnehmers (m/w) gelten insb. Unterrichtszeiten und Termine des
								Teilnehmers (m/w) bei den Ämtern.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.6.</td>
							<td style="text-align: justify;">Im Falle, dass die Weiterbildung
								und/oder der Unterhalt des Teilnehmers (m/w) über einen
								Sozialleistungsträger/Fördergeldgeber finanziert wird, ist der
								Teilnehmer (m/w) zur Wahrnehmung von Terminen beim
								Sozialträger/Fördergeldgeber auch während der Unterrichtszeiten
								bzw. Praktikumszeiten bei dem Kooperationsunternehmen
								berechtigt. Der Teilnehmer (m/w) ist verpflichtet, die NLA (und
								während der praktischen Weiterbildungsphase auch das
								Kooperationsunternehmen) über den Termin unverzüglich
								schriftlich oder per E-Mail zu informieren. Unverzüglich
								bedeutet spätestens 3 Werktage nach dem Erhalt einer Information
								über den wahrzunehmenden Termin. Des Weiteren ist der
								Teilnehmer (m/w) verpflichtet, spätestens 3 Werktage nach dem
								wahrgenommenen Termin der NLA einen Nachweis für die
								tatsächliche Teilnahme an dem Termin vorzulegen. Für den Fall,
								dass der Teilnehmer (m/w) innerhalb der vorgenannten Frist keinen
								Nachweis vorlegt, gilt seine Abwesenheit als unentschuldigt.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.7.</td>
							<td style="text-align: justify;">Hat der Teilnehmer (m/w) mit dem
								Kooperationsunternehmen eine Vergütungsvereinbarung geschlossen,
								hat er darüber die NLA unverzüglich zu informieren.</td>
						</tr>



					</table>
				</td>
			</tr>
		</table>
	</div>

	<!---------------------------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.8.</td>
							<td style="text-align: justify;">Sollte der Teilnehmer (m/w) während
								der praktischen Phase das Kooperationsunternehmen wechseln
								wollen, muss er hierfür vorher eine schriftliche Zustimmung der
								NLA holen. Das Wechseln des Kooperationsunternehmens ohne
								vorherige schriftliche Zustimmung der NLA ist nicht zulässig.
								Die NLA ist verpflichtet, dem Wechsel des
								Kooperationsunternehmens nur im Notfall zuzustimmen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.9.</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w)s hat die NLA
								über sämtliche wichtigen Ereignisse, die im Zusammenhang mit
								seiner Tätigkeit (bzw. seiner ehemaligen Tätigkeit) für das
								Kooperationsunternehmen eingetreten sind, unverzüglich zu
								informieren. Zu diesen Ereignissen gehören insbesondere:
								Arbeitsangebot seitens des Kooperationsunternehmens,
								ausgesprochene Belobigungen Kündigung des
								Praktikumsverhältnisses, Abmahnungen seitens des
								Kooperationsunternehmens sowie alle etwaigen Streitigkeiten und
								Missverständnisse zwischen dem Teilnehmer (m/w) und dem
								Kooperationsunternehmen bzw. mit einem Mitarbeiter des
								Kooperationsunternehmens.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>

						<tr valign="top">
							<td style="padding-right: 10px;">3.10.</td>
							<td style="text-align: justify;">Sollte ein
								Kooperationsunternehmen während der praktischen Weiterbildungsphase
								das Praktikumsverhältnis kündigen, ist der Teilnehmer (m/w)
								verpflichtet, unverzüglich nach einem neuen geeigneten Betrieb
								zu suchen, in dem der Teilnehmer (m/w) die praktische
								Weiterbildungsphase absolvieren wird. Des Weiteren ist der
								Teilnehmer (m/w) verpflichtet, an dem Übergangsunterricht
								teilzunehmen. Der Teilnehmer (m/w) hat sich daher bei der NLA zu
								melden und nach den Zeiten des Übergangsunterrichts zu
								erkundigen.</td>
						</tr>


						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"></td>
							<td style="text-align: justify;">Etwaige
								Bewerbungsgesprächstermine dürfen nicht in den Unterrichtszeiten
								erfolgen. Sollte ein Bewerbungsgespräch während der Dauer des
								Unterrichts vereinbart werden, hat der Teilnehmer (m/w) darüber die
								NLA unverzüglich schriftlich oder per E-Mail informieren. Wenn
								der Teilnehmer die NLA über das Bewerbungsgespräch im Vorfeld
								nicht informiert und wenn er innerhalb von 3 Werktagen nach dem
								Bewerbungsgespräch der NLA keinen Nachweis, aus dem sich ergibt,
								dass der Teilnehmer (m/w) den Termin wahrgenommen hat und dass der
								Termin außerhalb der Unterrichtszeiten nicht stattfinden konnte,
								zukommen lässt, wird seine Abwesenheit unentschuldigt bleiben.</td>
						</tr>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.11.</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) hat die
								Anweisungen der NLA und ihres Personals zu folgen. Er hat die
								NLA und ihr Personal, das Kooperationsunternehmen sowie die
								anderen Teilnehmer (m/w) mit Respekt zu behandeln.</td>
						</tr>

					</table>
				</td>
			</tr>

		</table>
	</div>
	<!---------------------------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td><br /> </td>
			</tr>
			<tr>
				<td><table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.12.</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) verpflichtet
								sich, die Vertragsbedingungen der NLA, die
								Hausordnung der NLA und die Umfallverhütungsvorschriften der NLA
								zu befolgen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.13.</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) ist
								verpflichtet, sich selbst über etwaige Änderungen hinsichtlich
								des Termins- und Lehrplanes durch Info-Gespräche in der Gruppe
								bzw. auf Nachfrage in der Verwaltung.</td>
						</tr>

						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.14.</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) ist
								verpflichtet, die NLA über etwaige Aufhebung, Änderung oder
								Rücknahme des Bewilligungsbescheides durch den Fördergeldgeber
								zu informieren.</td>
						</tr>
					</table></td>
			</tr>
			<tr>
				<td><br /><b>4. Zahlungsbedingungen</b></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">4.1</td>
							<td style="text-align: justify;">Die Kosten der Weiterbildung
								belaufen sich auf <?php if(isset($contract_details['total_amount_words'])) echo $contract_details['total_amount_words']; ?> werden von dem
								Fördergeldgeber übernommen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">4.2</td>
							<td style="text-align: justify;">Ferienzeiten, Phasen der
								fachpraktischen Weiterbildung oder Krankheit des Teilnehmers (m/w) ändern an der Verpflichtung zur Zahlung der
								Gebühren der Weiterbildung nichts.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">4.3</td>
							<td style="text-align: justify;">Im Falle einer Kündigung wird
								der Fördergeldgeber weitere 3 monatliche Raten beginnend ab dem
								Zeitpunkt des Abbruches der Weiterbildung zahlen.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><br /><b>5. Rücktritt und Kündigung</b></td>
			</tr>

			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">5.1</td>
							<td style="text-align: justify;">Während der ersten 3 Monate
								(Probezeit) kann das Weiterbildungsverhältnis von beiden Seiten mit
								einer Kündigungsfrist von 6 Wochen zum Monatsende gekündigt
								werden, erstmals zum Ende der ersten 3 Monate, sodann jeweils zum Ende der nächsten 3 Monate. 
								Die Kündigung muss schriftlich erfolgen. Vor Stellung einer
								Kündigung muss der Fördergeldgeber in Kenntnis gesetzt werden
								und der Kündigung schriftlich zustimmen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">5.2</td>
							<td style="text-align: justify;">Ein kostenfreies Rücktrittsrecht
								besteht bis zum angegeben Starttermin. Bei einer nicht Förderung
								durch den/das Fördergeldgeber/Bafög Amt o.ä. besteht jederzeit
								ein kostenfreies Rücktrittsrecht.</td>
						</tr>

					</table>
				</td>
			</tr>
		</table>
	</div>
	<!---------------------------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">5.3</td>
							<td style="text-align: justify;">Die NLA und der Teilnehmer (m/w)
								können das Weiterbildungsverhältnis jederzeit fristlos kündigen,
								wenn ein wichtiger Grund vorliegt. Die Kündigung muss schriftlich erfolgen. Die NLA und
								der Teilnehmer sind sich einig, dass ein wichtiger Grund im
								u.a. auch dann vorliegt, wenn:</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<table>
									<tr valign="top">
										<td style="padding-right: 10px;">a.</td>
										<td style="text-align: justify;">der Teilnehmer trotz 2
											schriftlichen Abmahnungen ein Berichtsheft nicht
											ordnungsgemäß führt;</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">b.</td>
										<td style="text-align: justify;">der Teilnehmer seit dem
											Beginn des Weiterbildungsverhältnisses zu Unterricht in 30% der
											Fälle verspätet kommt,</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">c.</td>
										<td style="text-align: justify;">die unentschuldigten
											Abwesenheiten des Teilnehmers (m/w) seit dem Beginn des
											Semesters mehr als 5% des gesamten im jeweiligen Semester
											anwesenheitspflichtigen Unterrichts darstellen,</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">d.</td>
										<td style="text-align: justify;">der Teilnehmer (m/w) zum
											Auswertungs- und Zielvereinbarungsgespräch und zu zwei
											weiteren Ausweichterminen für das bereits seitens des
											Teilnehmers (m/w) versäumte Auswertungs- und
											Zielvereinbarungsgespräch unentschuldigt nicht kommt;</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">e.</td>
										<td style="text-align: justify;">der Teilnehmer zum dritten
											Mal gegen seine Mitteilungs- und Informationspflichten
											verstoßen hat, insbesondere nach Ziffer 3.8 dieses Vertrages;</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">f.</td>
										<td style="text-align: justify;">der Teilnehmer (m/w) trotz zwei
											erfolgten schriftlichen Abmahnungen die Anweisungen der NLA
											und ihres Personals nicht gefolgt hat;</td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">g.</td>
										<td style="text-align: justify;">der Teilnehmer (m/w) trotz zwei
											erfolgten schriftlichen Abmahnungen sich gegenüber der NLA
											und ihrem Personal, den anderen Teilnehmers oder den
											Kooperationsunternehmen respektlos benommen hat. Die
											Respektlosigkeit liegt u.a. vor, wenn der Teilnehmer (m/w)
											Schimpfwörter benutzt oder bei der Durchführung des
											Unterrichts stört;</td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">h.</td>
										<td style="text-align: justify;">der Teilnehmer (m/w) die anderen Teilnehmer gegen die NLA, das Personal der NLA oder die 
Kooperationsunternehmen aufhetzt oder wenn er auf Social Media (u.a. Facebook, Twitter 
usw.) Inhalte postet, die dem Aufhetzten gegen die NLA und ihrem Personal sowie 
Kooperationsunternehmen dienen. Eine fristlose Kündigung ist berechtigt,</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!---------------------------------------------------------------->
	<div class="page">
		
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td><br />
					<table>
						<tr>
							<td><br></td>
							<td>
								<table>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">h.</td>
										<td style="text-align: justify;">wenn der Teilnehmer (m/w) Behauptungen über die NLA, ihr Personal und die Kooperationsunternehmen online sowie
											offline verbreitet, die nicht der Wahrheit entsprechen. Die
											Behauptungen gelten als wahr erst dann, wenn die Behauptungen
											über die NLA, ihr Personal und die Kooperationsunternehmen online sowie offline verbreitet, die nicht der Wahrheit entsprechen. Die Behauptungen gelten als wahr erste dann, wenn die Behauptungen in einem rechtskräftigen Urteil durch ein zuständiges Gericht für zutreffend erkannt wurden.</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">i.</td>
										<td style="text-align: justify;">der Teilnehmer (m/w) trotz zwei
											schriftlichen Abmahnungen gegen die Hausordnung, die
											Allgemeinen Geschäftsbedingungen und die
											Umfallverhütungsvorschriften der NLA verstoßen hat;</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">j.</td>
										<td style="text-align: justify;">der Teilnehmer (m/w) das
											Kooperationsunternehmen während der praktischen
											Weiterbildungsphase ohne vorherige schriftliche Zustimmung der
											NLA gewechselt hat;</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">k.</td>
										<td style="text-align: justify;">Der Fördergeldgeber den in
											der Präambel zu diesem Vertrag erwähnten Bewilligungsbescheid
											aufhebt oder zurücknimmt oder der Übernahme von weiteren
											Kosten, die aufgrund der Verlängerung der Umschuldungszeit
											entstehen, nicht zustimmt.</td>
									</tr>
									<tr>
										<td></td>
										<td><br /></td>
									</tr>
									<tr valign="top">
										<td style="padding-right: 10px;">l.</td>
										<td style="text-align: justify;">der Teilnehmer (m/w) besitzt ein Kündigungsrecht bei Arbeitsaufnahme.</td>
									</tr>
								</table>

							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">5.4</td>
							<td style="text-align: justify;">Kündigt das
								Kooperationsunternehmen das Praktikumsverhältnis mit dem
								Teilnehmer (m/w) aus den Gründen, die eine fristlose Kündigung
								nach Ziffer 5.4. dieses Vertrages berechtigen würden, ist die
								NLA zur fristlosen Kündigung dieses Vertrages berechtigt. Die
								Kündigung muss schriftlich erfolgen. Die Kündigung der NLA ist
								unwirksam, wenn die fristlose Kündigung durch das
								Kooperationsunternehmen der NLA länger als zwei Wochen bekannt
								ist.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">5.5</td>
							<td style="text-align: justify;">Wird das Praktikumsverhältnis
								durch ein Kooperationsunternehmen während der praktischen
								Weiterbildungsphase gekündigt oder will der Teilnehmer (m/w) das
								Kooperationsunternehmen mit der vorherigen Zustimmung der NLA
								wechseln und beginnt der Teilnehmer (m/w) innerhalb von drei
								Monaten nach der Beendigung des vorherigen praktischen
								Weiterbildungsverhältnisses bei dem Kooperationsunternehmen kein
								neues praktisches Weiterbildungsverhältnis bei einem anderen
								geeigneten Unternehmen, wird der erfolgreiche Abschluss dieser
								Weiterbildung in der vorgesehenen Zeit nicht mehr möglich sein.
								Daher ist dieser Vertrag mit Zustimmung des Fördergeldgebers
								schriftlich zum Ende des dann folgenden Monats aufzulösen.</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!---------------------------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			
			<tr>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>6. Haftung</b></td>
			</tr>
			<tr>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;">6.1</td>
							<td style="text-align: justify;">Die NLA haftet nicht für Körper-
								und Sachschäden des Teilnehmers (m/w), die von Dritten verursacht
								wurden. Die NLA haftet nicht für Verlust oder Diebstahl von
								persönlichem Eigentum des Teilnehmers (m/w).</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">6.2</td>
							<td style="text-align: justify;">Die NLA haftet dem
								Teilnehmer (m/w) gegenüber für eigenes grob fahrlässiges und
								vorsätzliches Verhalten.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">6.3</td>
							<td style="text-align: justify;">Die persönliche Haftung vom
								Personal der NLA das als Erfüllungsgehilfe tätig geworden ist,
								ist ausgeschlossen. Eine weitergehende Haftung ist
								ausgeschlossen, soweit dies gesetzlich zulässig ist.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">6.4</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) ist bei
								der Verwaltungsberufsgenossenschaft für die Dauer der Weiterbildung
								wegen gesetzlicher Unfallversicherung versichert.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">6.5</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) hat eine
								eigene Krankenversicherung und kann diese ggf. nachweisen.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>7. Verschwiegenheit und Datenschutz</b></td>
			</tr>
			<tr>
				<td>
					<table>

						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">7.1</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) ist
								verpflichtet, über alles, was er in der Weiterbildung, aus Anlass
								oder im Zusammenhang mit seiner Tätigkeit erfährt, gemäß §5 BDSG
								gegenüber Dritten Stillschweigen zu bewahren. Die
								Verschwiegenheitsverpflichtung ist auch nach Beendigung des
								Vertragsverhältnisses gültig.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">7.2</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) erklärt sich
								mit der Speicherung seiner persönlichen Daten in internen
								Systemen der NLA durch die NLA zur Durchführung der Ausbildung
								einverstanden. Der Teilnehmer (m/w) ist zudem mit der Übersendung
								der gespeicherten Daten durch die NLA an die zuständige
								Industrie- und Handelskammer sowie an das Jobcenter oder Bafög
								Amt zwecks der Durchführung der Ausbildung einverstanden.</td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">7.3</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) erklärt
								sich einverstanden, dass seine Bewerbungsunterlagen zum Zweck
								der Vermittlung in ein Kooperationsunternehmen im Rahmen der
								praktischen Ausbildungsphase von der NLA an interessierte
								Kooperationsunternehmen weitergegeben werden.</td>
						</tr>
					</table>
				</td>
			</tr>




		</table>
	</div>
	<!---------------------------------------------------------------->
	<div class="last-page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">

			<tr>
				<td><br /></td>
			</tr>
			
			<tr>
				<td><b>8. Schlussbestimmungen</b></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">8.1</td>
							<td style="text-align: justify;">Zusätzliche oder abweichende
								Vereinbarungen bedürfen der Schriftform. Mündliche Nebenabreden
								bestehen nicht.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">8.2</td>
							<td style="text-align: justify;">Sind oder werden einzelne
								Bestimmungen dieses Vertrages unwirksam, so wird dadurch die
								Gültigkeit der übrigen Bestimmungen nicht berührt. Der
								Vertragspartner wird in diesem Fall die ungültigen Bestimmungen
								durch eine andere ersetzen, die dem Zweck der weggefallenen
								Regelung in zulässiger Weise am nächsten kommt.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">8.3</td>
							<td style="text-align: justify;">Der Teilnehmer (m/w) erklärt, dass
								er folgende Unterlagen erhalten hat und zur Kenntnis genommen
								hat:</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"></td>
							<td style="text-align: justify;">- Anlage 1 Termin- und Lehrplan</td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"></td>
							<td style="text-align: justify;">- Anlage 2 Aufteilung der
								Weiterbildungsphasen</td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"></td>
							<td style="text-align: justify;">- Anlage 3 Hausordnung</td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"></td>
							<td style="text-align: justify;">- Anlage 4 Allgemeine
								Geschäftsbedingungen</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><br /></td>
			</tr>
			<tr>
				<td>Berlin, <?php echo date('d.m.Y');?></td>
			</tr>
			<tr>
				<td>
			<?php
if (isset($contract_details['signature']) && $contract_details['signature'] != "") {
    echo '<img src="signatures/' . $contract_details['signature'] . '" width="250px" height="auto" />';
} else
    echo "<br /> <br /> <br />  <br />";
?>
			
			
			</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td style="padding-right: 50px;">_______________________________<br />(schulische/r
								Teilnehmer:in) <br /></td>
							<td>_______________________________<br />(ggf. gesetzlicher
								Vertreter)<br /></td>
						</tr>
						<tr>
							<td><br /> <br /> <br />   <br /></td>
							<td><br /></td>
						</tr>
						<tr>
							<td style="padding-right: 50px;">_______________________________<br>(Nextlevel
									Akademie)</br></td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	</main>
</body>
</html>