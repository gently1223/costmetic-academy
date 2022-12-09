<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Rahmenvertrag</title>
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
				<td align="center" style="font-size: 20px;"><b>Rahmenvertrag</b></td>
			</tr>

			<tr>
				<td><br />zwischen der NextLevel Akademie, Bundesallee 86, 12161
					Berlin</td>
			</tr>
			<tr>
				<td align="right">im Folgenden: Auftraggeber</td>
			</tr>
			<tr>
				<td style="padding: 10px 0;">und</td>
			</tr>
			<tr>
				<td><?php if(isset($personal_details['salutation'])) echo $personal_details['salutation']; ?> <?php if(isset($personal_details['full_name'])) echo $personal_details['full_name']; ?> <?php if(isset($personal_details['address'])) echo $personal_details['address']; ?></td>
			</tr>
			<tr>
				<td align="right">im Folgenden: Auftragnehmer</td>
			</tr>
			<tr>
				<td align="center"><b><br />§ 1 Keine Pflicht zur Erteilung und
						Annahme von Aufträgen</b></td>
			</tr>
			<tr>
				<td style="text-align: justify"><br />Der Auftragnehmer erklärt sich grundsätzlich bereit, ab dem <?php if(isset($contract_details['begin_date'])) echo $contract_details['begin_date']; ?>
				Aufträge für den Auftraggeber zu den nachfolgenden Vereinbarungen zu übernehmen. Dieser Vertrag verpflichtet allerdings den Auftragnehmer 
				ausdrücklich nicht, einzelne vom Auftraggeber angebotene Aufträge anzunehmen, 
				verpflichtet aber auch den Auftraggeber nicht, dem Auftragnehmer solche Aufträge 
				anzubieten. Er regelt allein die Grundsätze für die Geschäftsbeziehung.
				</td>
			</tr>
			<tr>
				<td align="center"><br /> <b>§ 2 Tätigkeit</b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>1.</b></td>
							<td style="text-align: justify;">Die Thematik, der zeitliche
								Umfang, die Terminierung und der Durchführungsort eines
								Auftrages werden zwischen den Vertragsparteien miteinander
								einvernehmlich abgestimmt und in einer separaten schriftlichen
								Vereinbarung festgehalten.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>2.</b></td>
							<td>Eine solche schriftliche Vereinbarung ist Voraussetzung für
								das Zustandekommen eines einzelnen Auftrages.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>3.</b></td>
							<td style="text-align: justify;">Über die im vereinbarten Auftrag
								genannten Aufgaben inklusive deren Vor und Nachbereitung hinaus
								sind keine anderweitigen Nebenarbeiten geschuldet. Insbe-
								sondere ist der Auftragnehmer nicht verpflichtet, anderweitige
								Vertretungen durchzuführen, an Konferenzen teilzunehmen oder an
								sonstigen zentralen Veranstaltungen des Auftraggebers
								teilzunehmen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>4.</b></td>
							<td style="text-align: justify;">Der Auftragnehmer führt den
								vereinbarten Auftrag mit der Sorgfalt eines ordentlichen
								Kaufmannes in eigener unternehmerischer Verantwortung unter
								Berücksichtigung der Interessen des Auftraggebers durch.</td>
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
				<td align="center"><b>§ 3 Weisungsfreiheit </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>1.</b></td>
							<td style="text-align: justify;">Der Auftragnehmer unterliegt bei
								der Durchführung eines vereinbarten Auftrages keinem Weisungs-
								oder Direktionsrechts des Auftraggebers und ist in Bezug auf
								Zeit, Dauer, Art, Weise und Ort der Ausübung seiner Tätigkeit im
								Rahmen der Regelungen des § 2 unter Berücksichtigung der
								Auftragsvereinbarung frei.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>2.</b></td>
							<td style="text-align: justify;">Er ist frei von Weisungen zur
								Vorgehensweise zum Aufbau und Ablauf der Auftragsausführung. Er
								ist insbesondere methodisch und didaktisch frei. Die für die
								Erfüllung seines Auftrages notwendigen Mittel, insbesondere
								Lehrmittel, wählt er selbstständig aus. Die beim Auftraggeber
								vorhandenen Mittel, insbesondere Lehrmittel, stehen nach näherer
								Absprache zur Verfügung.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>3.</b></td>
							<td style="text-align: justify;">Der Auftragnehmer ist nicht in
								die Arbeitsorganisation des Auftraggebers eingebunden.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 4 Arbeitsaufwand/Keine Höchstpersönlichkeit
				</b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>1.</b></td>
							<td style="text-align: justify;">Der Umfang der nach § 2
								übertragenen Aufgaben ergibt sich aus der separaten
								Auftragsvereinbarung. Deren Inhalte sind hinsichtlich der
								vereinbarten Termine und Zeiten verbindlich. Darüber hinaus
								unterliegt der Auftragnehmer in der inhaltlichen Ausgestaltung
								und der zeitlichen Festlegung seiner Tätigkeitszeit keinen
								Einschränkungen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>2.</b></td>
							<td style="text-align: justify;">Der Auftragnehmer ist nicht zur
								höchstpersönlichen Durchführung eines vereinbarten Auftrages
								verpflichtet, sondern kann sich auch der Hilfe von Dritten als
								Erfüllungsgehilfen bedienen, wenn er deren persönliche,
								fachliche und pädagogische Eignung zur Erfüllung des Auftrages
								gegenüber dem Auftraggeber nachweist.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>3.</b></td>
							<td style="text-align: justify;">Der Auftragnehmer garantiert,
								dass er während der Laufzeit dieses Vertrages sämtliche
								Verpflichtungen des Mindestlohngesetzes, insbesondere die aus
								diesem Gesetz folgenden Dokumentationspflichten und die
								Zahlungspflichten gegenüber dem jeweiligen Berechtigten erfüllt.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td style="text-align: justify;">Er wird für den Fall, dass er
					Dritte bei der Erfüllung dieses Vertrages einsetzt, die sich
					ihrerseits zur Erfüllung ihrer Pflichten Erfüllungsgehilfen
					bedienen, zusichern lassen, dass die Dritten die Verpflichtungen
					nach dem Mindestlohngesetz in seiner jeweils gültigen Fassung
					erfüllen.</td>
			</tr>
		</table>
	</div>
	<!------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td style="text-align: justify;">Der Auftragnehmer verpflichtet
					sich, alle Anfragen des Auftraggebers zur Einhaltung des
					Bestimmungen des Mindestlohngesetzes wahrheitsgemäß und umfassend
					zu beantworten und hierzu vom Auftraggeber angeforderte Unterlagen
					unverzüglich vorzunehmen. Er verpflichtet sich insbesondere, dem
					Auftraggeber auf dessen Anforderung die Arbeitszeitaufzeichnungen
					der zur Erfüllung des Auftrags ggf. eingesetzten Arbeitnehmer sowie
					die Lohnund Gehaltsabrechnungen vollständig zur Einsichtnahme in
					anonymisierter Form unter Beachtung der datenschutzrechtlichen
					Grundsätze zur Verfügung zu stellen. Er ist ebenso verpflichtet,
					auf Anforderung vom Auf- traggeber die fristgerechte Zahlung des
					Mindestlohns nachzuweisen. Für den Fall, dass er sich der Hilfe
					Dritter bedient, die ihrerseits Erfüllungsgehilfen zur Erfüllung
					ihrer Aufgaben nach diesem Vertrag einsetzen, ist er verpflichtet,
					beim Dritten die Einhaltung des Mindestlohngesetzes entsprechend zu
					überprüfen und gegenüber dem Auftraggeber auf Anforderung
					nachzuweisen, dass er diese Überprüfungen vorgenommen hat und bei
					den Überprüfungen kein Verstoß gegen das Mindestlohngesetz
					festgestellt wurde.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 5 Konkurrenztätigkeit </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>Der Auftragnehmer darf ausdrücklich auch für andere
					Auftraggeber, die im Wettbewerb mit dem Auftraggeber stehen, tätig
					sein. Eine vorherige Zustimmung des Auftraggebers ist ausdrücklich
					nicht erforderlich.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>

				<td align="center"><b>§ 6 Verschwiegenheit/Aufbewahrung </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>1.</b></td>
							<td style="text-align: justify;">Der Auftragnehmer verpflichtet
								sich, über alle ihm während seiner Tätigkeit für den
								Auftraggeber anvertrauten oder bekannt gewordenen Geschäftsund
								Betriebsgeheimnisse und alle ihm bekannt werdenden sonstigen
								geschäftlichen und betrieblichen Tatsachen Stillschweigen zu
								bewahren, soweit er nicht aufgrund zwingender gesetzlicher
								Vorschriften zur Auskunftserteilung verpflichtet ist. Dies gilt
								auch über den Fortbestand dieses Vertrages hinaus.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>2.</b></td>
							<td style="text-align: justify;">Der Auftragnehmer ist ferner
								verpflichtet, alle ihm zur Verfügung gestellten Geschäfts und
								Betriebsunterlagen sowie mittels EDV gespeicherte Daten
								ordnungsgemäß aufzubewahren und dafür zu sorgen, dass unbefugte
								Dritte nicht Einsicht nehmen können.</td>
						</tr>
					</table>
				</td>
			</tr>


		</table>
	</div>
	<!------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 7 Rückgabeverpflichtungen </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="justify">Die zur Verfügung gestellten Unterlagen und
					Daten sowie sonstige dem Auftragnehmer im Rahmen eines einzelnen
					Auftrages zur Verfügung gestellten Gegenstände sind während der
					Dauer dieses Vertragsverhältnisses auf Anforderung und nach Be-
					endigung des Vertragsverhältnisses unverzüglich ohne Aufforderung
					durch den Auftraggeber an diesen zurückzugeben. Gleiches gilt für
					eventuell gefertigte Kopien, Abschriften, Duplikate oder sonstige
					Vervielfältigungen und Reproduktionen, insbesondere im Wege
					elektronischer Datenverarbeitung. Ein Zurückbehaltungsrecht steht
					dem Auftragnehmer nicht zu.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 8 Datenschutz </b></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>1.</b></td>
							<td style="text-align: justify;">Der Auftragnehmer verpflichtet
								sich, sämtliche datenschutzrechtlichen Bestimmungen, Gesetze und
								Verordnungen, insbesondere die Vorschriften zum Sozialda-
								tenschutz einzuhalten und diese Verpflichtung zur Einhaltung
								aller datenschutzrechtlichen Regelungen an etwaige, von ihm
								eingesetzte Erfüllungsgehilfen nachweisbar weiterzugeben.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>2.</b></td>
							<td style="text-align: justify;">Er ist gegenüber dem
								Auftraggeber verpflichtet, von ihm zur Erfüllung dieses Ver-
								trages eingesetzte Personen entsprechend § 5 BDSG auf die
								Einhaltung des Datengeheimnisses zu verpflichten und nur solche
								Personen im Rahmen der Erfüllung dieses Vertrages einzusetzen,
								die nachgewiesen auf die Einhaltung des Datengeheimnisses nach §
								5 BDSG verpflichtet sind.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>3.</b></td>
							<td style="text-align: justify;">Die Verpflichtung erfolgt auf
								Basis der als <b>Anlage 1</b> beigefügten
								Verpflichtungserklärung, die Bestandteil dieses Vertrages ist.
							</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>4.</b></td>
							<td style="text-align: justify;">Der Auftraggeber hat das Recht,
								die Einhaltung der hier eingegangenen Verpflichtung des
								Auftragnehmers zu prüfen und die Vorlage von Nachweisen zu
								verlangen.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 9 Honorar </b></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>1.</b></td>
							<td style="text-align: justify;">Der Auftraggeber zahlt an den
								Auftragnehmer ein Honorar, welches im Zuge der einzelnen
								Auftragsvereinbarung individuell verhandelt wird.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>2.</b></td>
							<td style="text-align: justify;">Mit dem vereinbarten Honorar
								sind alle Aufwände des Auftragnehmers, insbesondere Fahrtkosten,
								Vorund Nachbereitungsaufwand abgegolten.</td>
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
				<td>
					<table>

						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>3.</b></td>
							<td style="text-align: justify;">Ein Honoraranspruch besteht nur
								für tatsächlich geleistete Tätigkeiten. Im Falle der
								Verhinderung des Auftragnehmers nicht geleistete Tätigkeiten, z.
								B. im Falle von Urlaub, Feiertagen oder Erkrankung, werden nicht
								vergütet. Gleiches gilt für die eventuelle freiwillige Teilnahme
								an Besprechungen mit dem Auftraggeber.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>4.</b></td>
							<td style="text-align: justify;">Die Auszahlung des Honorars
								erfolgt nachträglich nach Einreichung einer entsprechenden
								Honorarrechnung des Auftragnehmers, aus der sich die Berechnung
								der Höhe des Honorars nachvollziehbar ergibt.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td style="text-align: justify;">Rechnungen stellt der Auftragnehmer
					jeweils bis zum 5. Kalendertag des auf die Leistungserbringung
					folgenden Monats. Sie sind 25 Tage nach Rechnungseingang beim
					Auftraggeber zur Zahlung fällig. Die Auszahlung erfolgt durch
					Überweisung auf das Konto:</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>IBAN: <?php if(isset($contract_details['iban'])) echo '<b>' . $contract_details['iban'] . '</b>'; else echo "_______________________________________" ?> </td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>BIC: <?php if(isset($contract_details['bic'])) echo '<b>' . $contract_details['bic']. '</b>'; else echo "_______________________________________" ?> </td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>Kreditinstitut: <?php if(isset($contract_details['bank_name'])) echo '<b>' .$contract_details['bank_name']. '</b>'; else echo "_______________________________________" ?></td>
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
							<td style="text-align: justify;">Für die Versteuerung der
								Vergütung hat der Auftragnehmer selbst zu sorgen.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 10 Leistungsverhinderungen des
						Auftragnehmers </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="justify">Im Falle von Leistungsverhinderungen, unabhängig
					auf welchem Grund sie beruhen, ist der Auftragnehmer verpflichtet,
					dem Auftraggeber unverzüglich die Informationen zur Verfügung zu
					stellen, die notwendig sind, um, soweit erforderlich, die im Rahmen
					des Auftrages betreuten Teilnehmer betreuen zu können.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="justify">Ausgefallene Leistungen können in Absprache mit
					dem Auftraggeber nachgeholt werden.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 11 Befristung des Rahmenvertrages </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="justify">Dieser Rahmenvertrag ist unbefristet gültig.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
		</table>
	</div>
	<!------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td></td>
				<td><br /></td>
			</tr>

			<tr>
				<td align="center"><b>§ 12 Beendigung durch Kündigung </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>1.</b></td>
							<td style="text-align: justify;">Das Vertragsverhältnis kann
								sowohl vom Auftragnehmer als auch vom Auftraggeber jederzeit mit
								einer Frist von 2 Wochen ordentlich gekündigt werden</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>2.</b></td>
							<td style="text-align: justify;">Jede Vertragspartei ist darüber
								hinaus berechtigt, auch einen separat vereinbarten Auftrag
								vorzeitig mit einer Frist von 2 Wochen zu kündigen, sofern im
								Rahmen dieses Auftrages nicht schriftlich eine andere
								Kündigungsfrist vereinbart ist.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>3.</b></td>
							<td style="text-align: justify;">Das Recht zur außerordentlichen
								Kündigung mit sofortiger Wirkung bleibt unberührt</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="justify">Der Auftraggeber ist insbesondere berechtigt,
					den Vertrag und etwaig separat vereinbarte Aufträge außerordentlich
					und fristlos zu kündigen, wenn der Auftragnehmer die nach diesem
					Vertrag bestehenden Verpflichtungen zur Einhaltung des
					Mindestlohngesetzes nicht erfüllt.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>Der Auftragnehmer erklärt ausdrücklich,</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 25px;"></td>
							<td style="text-align: justify;"><b>a)</b> dass er oder sein
								Unternehmen die Technologie von L. Ron Hubbard nicht anwendet
								oder verbreitet.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 25px;"></td>
							</td>
							<td style="text-align: justify;"><b>b) </b>dass er oder sein
								Unternehmen nicht Mitglied der International Association of
								Scientologist oder einer anderen Organisation, die nach den
								Methoden von L. Ron Hubbard arbeitet, ist.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 25px;"></td>
							</td>
							<td style="text-align: justify;"><b>c)</b> dass er die Methoden
								von L. Ron Hubbard zur Durchführung von Schulungen, Seminaren,
								Lehrgängen etc. ablehnt.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 25px;"></td>
							</td>
							<td style="text-align: justify;"><b>d) </b>dass weder er noch
								seine Mitarbeiter nach den Methoden von L. Ron Hubbard geschult
								wurden oder werden bzw. keine Kurse und/oder Seminare nach der
								Methode L. Ron Hubbard besuchen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 25px;"></td>
							</td>
							<td style="text-align: justify;"><b> e) </b>dass weder er oder
								seine Mitarbeiter rechtskräftig wegen einer Straftat nach den §§
								171, 174 bis 174c, 176 bis 180a, 181a, 182 bis 184f, 225, 232
								bis 233a, 234, 235 oder 236 des Strafgesetzbuchs verurteilt
								worden sind.</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!------------------------------------------->
	<div class="page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="justify">Bei einem Verstoß gegen eine oder mehrere
					Erklärungen der Buchstaben a) bis einschließlich e) ist der
					Auftraggeber jederzeit berechtigt, diesen Vertrag und eventuell
					bereits vereinbarte Aufträge aus wichtigem Grund ohne Einhaltung
					einer Frist zu kündigen. Weitergehende Rechte bleiben unberührt.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>4.</b></td>
							<td style="text-align: justify;">Jede Kündigungserklärung bedarf
								der Schriftform.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 13 Haftung des Auftragnehmers </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="justify">Sollte der Auftraggeber durch die Durchführung
					und Abwicklung dieses Vertrages und/oder eines Auftrages,
					insbesondere dadurch, dass der Auftragnehmer seine sich aus diesem
					Vertrag oder einem Auftrag ergebenden Pflichten verletzt, Nachteile
					erleiden, stellte der Auftragnehmer den Auftraggeber von diesen
					Nachteilen frei.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 14 Versicherungen </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>1.</b></td>
							<td style="text-align: justify;">Der Auftraggeber empfiehlt dem
								Auftragnehmer zur Absicherung etwaiger Risiken eine eigene
								Haftpflicht bzw. Unfallversicherung abzuschließen. Der
								Auftragnehmer stimmt ausdrücklich zu, dass er für den
								Unfallversicherungsschutz selbst zu sorgen hat, da ein
								Unfallversicherungsschutz durch den Auftraggeber nicht besteht.
								Eine Erstattung der zu leistenden Versicherungsprämien durch den
								Auftraggeber erfolgt nicht.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>2.</b></td>
							<td style="text-align: justify;">Zwischen den Parteien besteht
								ferner Einigkeit, dass kein sozialversicherungsrechtliches
								Beschäftigungsverhältnis besteht. Für den Fall der Krankheit,
								des Alters, der Pflegebedürftigkeit und der
								Beschäftigungslosigkeit wird der Auftragnehmer selbstständig
								vorsorgen.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 15 Aufhebung etwaig anderer Vereinbarungen </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="justify">Mit Abschluss dieses Rahmenvertrages wird bzw.
					werden eventuell bereits geschlossene oder noch bestehende
					Rahmenverträge über freie Mitarbeit aufgehoben. Hinsichtlich
					eventuell noch laufender Aufträge wird der aufgehobene
					Rahmenvertrag durch diesen Rahmenvertrag mit Abschluss dieses
					Rahmenvertrages ersetzt.</td>
			</tr>
		</table>
	</div>

	<!------------------------------------------->
	<div class="last-page">
		<br />
		<table width="520"
			style="padding-left: 10px; padding-right: 10px; font-size: 14px;">

			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="center"><b>§ 16 Schriftform </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>1.</b></td>
							<td style="text-align: justify;">Ergänzungen und Änderungen
								dieses Vertrages bedürfen zu ihrer Wirksamkeit der Schriftform,
								es sei denn, sie beruhen auf einer ausdrücklichen oder
								individuellen Vertragsabrede.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>2.</b></td>
							<td style="text-align: justify;">Auch dieses Formerfordernis kann
								nur schriftlich außer Kraft gesetzt werden, es sei denn die
								Aufhebung des Schriftformerfordernisses beruht auf einer
								ausdrücklichen oder individuellen Vertragsabrede.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center"><b>§ 17 Salvatorische Klausel </b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td align="justify">Sollten einzelne Bestimmungen dieses Vertrages
					ganz oder teilweise rechtsunwirksam sein oder werden, berührt dies
					nicht die Gültigkeit der übrigen Bestimmungen. Anstelle des
					rechtsunwirksamen Teils gilt sodann als vereinbart, was dem in
					gesetzlich zulässiger Weise am nächsten kommt, was die
					Vertragsparteien vereinbart hätten, wenn ihnen die Unwirksamkeit
					bekannt gewesen wäre. Dies gilt entsprechend für den Fall, dass
					dieser Vertrag eine Lücke aufweisen sollte. Beruht die Ungültigkeit
					auf einer Leistungs oder Zeitbestimmung, so tritt an ihre Stelle
					das gesetzlich zulässige Maß.</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right:80px;">Berlin, <?php if(isset($contract_details['begin_date'])) echo $contract_details['begin_date']; ?></td>
							<td style="padding-left: 80px;">Berlin, <?php if(isset($contract_details['begin_date'])) echo $contract_details['begin_date']; ?></td>
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
</main></body></html>