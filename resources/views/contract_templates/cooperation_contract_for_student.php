<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Kooperationsvertrag für das Betriebspraktikum</title>
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
				<td align="center" style="font-size: 20px;"><b> Kooperationsvertrag
						für das Betriebspraktikum zum/zur <br /><?php if(isset($contract_details['job_title'])) echo $contract_details['job_title']; ?><br />
						5 – 22 Monate möglich
				</b></td>
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
				<td style="padding: 10px 0;">und dem Kooperationsunternehmen für die
					praktische Ausbildungsphase</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr valign="top">
							<td>Unternehmen:</td>
							<td><?php if(isset($contract_details['internship_company_name'])) echo $contract_details['internship_company_name']; ?></td>
						</tr>
						<tr valign="top">
							<td>Straße, Hausnr., PLZ, Ort: (Zentrale)</td>
							<td><?php if(isset($contract_details['internship_company_mainaddress'])) echo $contract_details['internship_company_mainaddress']; ?></td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr>
							<td>Einsatzort:</td>
							<td><?php if(isset($contract_details['internship_company_worklocation'])) echo $contract_details['internship_company_worklocation']; ?></td>
						</tr>
						<tr>
							<td>Telefon:</td>
							<td><?php if(isset($contract_details['internship_company_telephone'])) echo $contract_details['internship_company_telephone']; ?></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><?php if(isset($contract_details['internship_company_email'])) echo $contract_details['internship_company_email']; ?></td>
						</tr>
						<tr>
							<td>Vertreten durch:</td>
							<td><?php if(isset($contract_details['internship_company_contact'])) echo $contract_details['internship_company_contact']; ?></td>
						</tr>

					</table>
				</td>
			</tr>
			<tr>
				<td>(nachstehend Kooperationsunternehmen genannt)</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>wird folgender Vertrag geschlossen:</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>Gegenstand</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>Dieser Vertrag regelt das Kooperationsverhältnis bzgl. der
					Durchführung der Ausbildung von<br><br />
				
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr valign="top">
							<td>Auszubildende/r:</td>
							<td><?php if(isset($personal_details['full_name'])) echo $personal_details['full_name']; ?></td>
						</tr>
						<tr valign="top">
							<td>In dem IHK Ausbildungsberuf</td>
							<td><?php if(isset($contract_details['job_title'])) echo $contract_details['job_title']; ?></td>
						</tr>
					</table>
				</td>
			</tr>

		</table>
	</div>
	<!--------------------------------------------------------->
	<div class="page">
		<table width="520"
			style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td>im Zeitraum von</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr valign="top">
							<td>Betriebsphase Teil 1:</td>
							<td><?php if(isset($contract_details['phase1'])) echo $contract_details['phase1']; ?></td>
						</tr>
						<tr valign="top">
							<td>Betriebsphase Teil 2:</td>
							<td><?php if(isset($contract_details['phase2'])) echo $contract_details['phase2']; ?></td>
						</tr>
						<tr valign="top">
							<td>Prüfungsvorbereitung schriftl. Teil 1:</td>
							<td><?php if(isset($contract_details['test1'])) echo $contract_details['test1']; ?></td>
						</tr>
						<tr valign="top">
							<td>Prüfungsvorbereitung mündl. Teil 2:</td>
							<td><?php if(isset($contract_details['test2'])) echo $contract_details['test2']; else { ?> <span
								style="color: red;">(Termine werden ca. 2 Wochen nach
									schriftlicher Prüfung mitgeteilt</span><?php } ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>1. Rechte und Pflichten von NLA</b></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">1.</td>
							<td style="text-align: justify;">NLA trifft eine Vorauswahl der
								schulischen Auszubildenden (m/w).</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.</td>
							<td style="text-align: justify;">NLA schließt mit dem/der
								schulischen Auszubildenden (m/w) einen Vertrag über die
								schulische Ausbildung ab. Jährlich erhalten die schulischen
								Auszubildenden (m/w) 2 Tage monatlich Ferien/Urlaub nach
								Absprache der Weisungsberechtigten des Kooperationsbetriebes.
								Die Aufteilung der Ausbildungsphasen zwischen NLA und
								Kooperationsunternehmen sind dem beiliegenden Zeitplan zu
								entnehmen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.</td>
							<td style="text-align: justify;">NLA verpflichtet sich, die
								fachtheoretischen Ausbildungsinhalte gemäß gültiger
								Ausbildungsverordnung mit dem Ziel des Bestehens der externen
								Abschlussprüfung vor der IHK zu vermitteln.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">4.</td>
							<td style="text-align: justify;">NLA meldet den schulischen
								Auszubildenden (m/w) zu der Abschlussprüfung bei der IHK an.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">5.</td>
							<td style="text-align: justify;">NLA obliegt die Kontrolle des
								Ausbildungsverlaufs beim Kooperationsunternehmen, NLA betreut
								die schulischen Auszubildenden gegebenenfalls sozialpädagogisch
								zusätzlich.</td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">6.</td>
							<td style="text-align: justify;">NLA hat das Recht, Kontakt zu
								seinen schulischen Auszubildenden (m/w) aufzunehmen und sich
								über die Leistungen und das Verhalten im Kooperationsunternehmen
								zu informieren.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">7.</td>
							<td style="text-align: justify;">Die disziplinarische
								Verantwortung für den schulischen Auszubildenden (m/w) verbleibt
								bei NLA.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">8.</td>
							<td style="text-align: justify;">Die schulischen Auszubildenden
								sind für die Dauer der Ausbildung durch NLA bei der zuständigen
								Berufsgenossenschaft unfallversichert.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">9.</td>
							<td style="text-align: justify;">Die schulischen Auszubildenden
								haben eine eigene Krankenversicherung und können diese ggf.
								nachweisen.</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<!--------------------------------------------------------->
	<div class="page">
		<table width="520"
			style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;">10.</td>
							<td style="text-align: justify;">Die NLA erhält das Recht Foto-
								und Videoaufnahmen in den Geschäften des Kooperationspartners,
								unter Wahrung der Persönlichkeitsrechte, zu erstellen und diese
								zu Marketingzwecken in unseren Social Media Foren (Instagram,
								Facebook, Youtube, Website usw.) zu nutzen. Dieser Zustimmung
								kann schriftlich widersprochen werden.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>2. Rechte und Pflichten des Kooperationsunternehmens</b></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">1.</td>
							<td style="text-align: justify;">Das Kooperationsunternehmen hat
								das Recht, sich am Auswahlverfahren für den schulischen
								Auszubildenden (m/w) zu beteiligen.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.</td>
							<td style="text-align: justify;">Unter seiner Leitung findet die
								praktische Ausbildungsphase entsprechend des gültigen
								Ausbildungsrahmenplans in seinem Unternehmen statt. Bei der
								fachpraktischen Ausbildungsphase im Kooperationsunternehmen
								handelt es sich um ein echtes Praktikum, welches nach der
								Ausbildungsordnung einen zwingend vorgeschriebenen begleitenden
								Praxisteil darstellt und Voraussetzung für die Zulassung der
								Auszubildenden (m/w) zur IHK-Abschlussprüfung ist. Für die
								Auszubildende (m/w) besteht kein arbeitsrechtlicher oder
								ausbildungsrechtlicher Vergütungsanspruch gegen das
								Kooperationsunternehmen. Eine individuelle
								Vergütungsvereinbarung kann zwischen dem Kooperationsunternehmen
								und der Auszubildenden (m/w) vereinbart werden, soweit eine
								solche individuelle Regelung den Klauseln dieses Vertrages nicht
								zuwiderläuft.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">3.</td>
							<td style="text-align: justify;">Die regelmäßige wöchentliche
								Arbeitszeit des schulischen Auszubildenden (m/w) beträgt 38
								Stunden (netto). Die konkrete wöchentliche Arbeitszeit richtet
								sich, unter Berücksichtigung der Regelungen des
								Berufsbildungsgesetzes nach den Arbeitszeitregelungen des
								Kooperationsunternehmens.
								<td>
						
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">4.</td>
							<td style="text-align: justify;">Das Kooperationsunternehmen
								verpflichtet sich zur Freistellung des schulischen
								Auszubildenden (m/w) für die fachtheoretischen Ausbildungsteile
								bei NLA</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">5.</td>
							<td style="text-align: justify;">Das Kooperationsunternehmen ist
								verpflichtet, bei Krankheit oder Ausfall des Auszubildenden NLA
								umgehend zu informieren (Mitarbeiterzeiterfassung).</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">6.</td>
							<td style="text-align: justify;">Das Kooperationsunternehmen
								stellt für die Ausbildung verantwortliches Fachpersonal,
								Betriebseinrichtungen und Betriebsmittel zur Verfügung.</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<!--------------------------------------------------------->
	<div class="page">
		<table width="520"
			style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;">7.</td>
							<td style="text-align: justify;">Das Kooperationsunternehmen ist
								gegenüber dem schulischen Auszubildenden (m/w) in allen
								ausbildungsplatzbezogenen Fragen weisungsberechtigt.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">8.</td>
							<td style="text-align: justify;">Bei Disziplinverstößen,
								Verletzungen der Sicherheitsvorschriften und unentschuldigtem
								Fehlen ist NLA unverzüglich zu informieren.</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">9.</td>
							<td style="text-align: justify;">Die ersten 3 Monate der
								praktischen Ausbildung gelten als Probezeit im
								Kooperationsunternehmen. Am Ende der Probezeit wird in einem
								gemeinsamen Gespräch zwischen NLA, Kooperationsunternehmen und
								dem schulischen Auszubildenden (m/w) über die Fortführung der
								fachpraktischen Ausbildung entschieden. Neben den regelmäßigen
								Praktikumsbesuchen in der gemeinsamen Ausbildungszeit erfolgt
								mindestens einmal jährlich ein gemeinsames persönliches
								Auswertungs- und Zielvereinbarungsgespräch mit dem schulischen
								Auszubildenden (m/w).</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;"><b>10.</b></td>
							<td style="text-align: justify;">Zusätzlich zu den durch die
								Ausbildungs- und Prüfungsordnung vorgeschriebenen Lehrinhalten
								bietet NLA der Auszubildenden (m/w) im Rahmen der
								fachtheoretischen Ausbildungsphase Qualifizierungen <b>in den
									Bereichen: Mode- & Textilkunde, Kassenschein, Markenkunde,
									Workshop Änderungsschneiderei, Verkaufstraining sowie ein
									Kompetenztraining im Bereich persönliche und soziale
									Kompetenzen</b> an. <br><br /> Die diesbezüglichen
									Schulungsphasen finden zusätzlich zum bzw. getrennt vom
									regulären nach der Ausbildungsordnung vorgeschriebenen
									fachtheoretischen Unterricht statt. Hat die Auszubildende (m/w)
									eine der benannten zusätzlichen Qualifizierungen durchlaufen,
									erhält sie als Nachweis ein entsprechendes Zertifikat von NLA.
									Diese Schulungen sind für die Auszubildenden (m/w) freiwillig
									und kostenlos. <br><br /> Bei Nachweis eines Zertifikats
										leistet das Kooperationsunternehmen für die Dauer der
										fachpraktischen Ausbildungsphase zum Zwecke der Refinanzierung
										eine <b><span style="color: #008000;">Aufwandsbeteiligung in
												Höhe von 449,00 € </span></b>monatlich an NLA. <br><br /> <span
											style="text-decoration: underline;">Zahlungsmöglichkeiten:</span>
											Die Zahlungen sind jeweils zum 3. des jeweiligen
											Kalendermonats fällig. Das Kooperationsunternehmen erteilt
											NLA eine 
							
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<!--------------------------------------------------------->
	<div class="page">
		<table width="520"
			style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;">10.</td>
							<td style="text-align: justify;">Einzugsermächtigung, in
								Absprache per Rechnung oder richtet einen Dauerauftrag zur
								Zahlung an NLA ein. <br><br /> Die Aufwandsbeteiligung dient dem
									teilweisen Ausgleich für Aufwendungen der NLA zur Durchführung
									der zusätzlichen Qualifizierung. Dies betrifft den Einsatz von
									Personal, Schulungsmaterialien, Räumlichkeiten und sonstigen
									erforderlichen Aufwendungen. <br><br /> Die Vertragsparteien
										stellen insofern klar, dass die Aufwandsbeteiligung keine
										Vergütung der Auszubildenden (m/w) für etwaige Leistungen im
										Rahmen der fachpraktischen Ausbildungsphase im
										Kooperationsunternehmen oder sonstiges Einkommen der
										Auszubildenden (m/w) darstellt. Der Lebenshaltungsbedarf der
										Auszubildenden (m/w) wird entweder über den Träger einer
										Ausbildungsförderung oder aus sonstigem Einkommen oder
										Unterhalt der Auszubildenden (m/w) gedeckt. Die
										Aufwandsbeteiligung findet ihre Rechtsgrundlage allein und
										ausschließlich in dem Vertragsverhältnis zwischen NLA und dem
										Kooperationsunternehmen und hat keinerlei Auswirkungen zu
										Lasten der Auszubildenden (m/w). <br><br /> Auf die
											Aufwandsbeteiligung entfallen keine Umsatzsteuer, keine
											Sozialversicherungsbeiträge oder sonstigen zusätzlichen
											Kosten. <br><br /> Die Aufwandsbeteiligung ist unabhängig von
												Ausfallzeiten des schulischen Auszubildenden (m/w) durch
												Krankheit oder aus sonstigen Gründen zu zahlen. Bei längerer
												Erkrankung über 6 Wochen entfällt die Kostenbeteiligung für
												das Kooperationsunternehmen anteilig für die Dauer des
												Ausfalls. Gleiches gilt für die 6-wöchige
												Prüfungsvorbereitungszeit. Hierbei legen die
												Vertragsparteien für den Ausfalltag ein Dreißigstel der
												monatlichen Aufwandsbeteiligung zugrunde. <br><br /> Das
													Praktikum endet mit dem Tag der mündlichen Prüfung. Dieser
													Termin wird von der IHK Berlin etwa 4-6 Wochen nach der
													schriftlichen Prüfung festgelegt. Der letzte
													Praktikumsmonat wird deshalb anteilig in Rechnung gestellt.
													Bis zum 15. des Monats fallen 50 % der Aufwandsbeteiligung
													an. Ab dem 16. des Monats fallen 100 % der
													Aufwandsbeteiligung an. 
							
							</td>
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!--------------------------------------------------------->
	<div class="page">
		<table width="520"
			style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;">11.</td>
							<td style="text-align: justify;">Das Kooperationsunternehmen
								erstellt zum Abschluss der Berufsausbildung für den schulischen
								Auszubildenden (m/w) ein qualifiziertes Zeugnis.
						
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">12.</td>
							<td style="text-align: justify;">Das Kooperationsunternehmen
								weist den Teilnehmer (m/w) darauf hin, dass bei angestrebter
								Einstellung die Vermittlungsgebühr beim zuständigen
								Fördergeldgeber für die NLA zu beantragen ist.
						
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>3. Vertragsänderungen</b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr valign="top">
							<td style="padding-right: 10px;">1.</td>
							<td style="text-align: justify;">Beide Partner können nach
								vorheriger Rücksprache den Vertrag in allen Teilen
								einvernehmlich ändern. Alle Änderungen müssen schriftlich
								erfolgen. Nebenabreden gelten nicht.
								<td>
						
						</tr>
						<tr>
							<td></td>
							<td><br /></td>
						</tr>
						<tr valign="top">
							<td style="padding-right: 10px;">2.</td>
							<td style="text-align: justify;">Sollten sich die in diesem
								Vertrag zugrunde liegenden rechtlichen und tatsächlichen
								Verhältnisse in wesentlichen Punkten ändern, werden sich die
								Vertragsparteien bemühen, eine gütliche Einigung über die
								notwendige Anpassung oder Auflösung herbeizuführen.
								Vertragsänderungen bedürfen der Schriftform.
								<td>
						
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>4. Rücktrittsklausel</b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td style="padding-right: 10px;"></td>
							<td style="text-align: justify;">NLA behält sich vor, bis zwei
								Wochen vor Beginn der Ausbildung vom Vertrag zurückzutreten,
								wenn aus noch nicht bekannten Gründen eine Ausbildung nicht
								erfolgen kann.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td><b>5. Beendigung des Vertrags</b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td style="padding-right: 10px;"></td>
							<td style="text-align: justify;">Beide Parteien haben das Recht,
								den Vertrag mit einer Frist von 8 Wochen zum Monatsende zu
								kündigen. Bei einer Kündigung des Vertrages durch NLA und dem
								schulischen Auszubildenden (m/w) wird der Kooperationsvertrag
								zum gleichen Datum durch NLA gekündigt. In der Probezeit kann
								der Vertrag mit einer Frist von 2 Wochen beiderseitig gekündigt
								werden. Nach der Probezeit kann der Kooperationsvertrag durch
								das Kooperationsunternehmen fristlos gekündigt werden, wenn im
								Verhalten und/oder in der Person der schulischen Auszubildenden
								liegende Gründe eine fristlose Kündigung rechtfertigen. NLA kann
								den Vertrag bei Pflichtverletzung durch das
								Kooperationsunternehmen (z.B. Zahlungsverzug) ebenfalls fristlos
								kündigen.</td>
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
				<td><b>6. Salvatorische Klausel</b></td>
			</tr>
			<tr>
				<td></td>
				<td><br /></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td style="padding-right: 10px;"></td>
							<td style="text-align: justify;">Sollte sich eine Klausel dieses
								Vertrags als unwirksam oder undurchführbar erweisen, bleiben die
								übrigen Vertragsbestimmungen und die Wirksamkeit dieses Vertrags
								im Ganzen hiervon unberührt. An die Stelle dieser Klausel soll
								eine Bestimmung treten, die dem Sinn und Zweck der nichtigen
								Klausel möglichst nach- kommt.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><br /> <br /> <br /> <br/><br /> <br /> <br/></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td>_________________________________<br />Ort, Datum
							</td>
							<td align="right">____________________________________________________________<br/>Stempel,
								Unterschrift Kooperationsunternehmen
							</td>
						</tr>
						<tr>
							<td></td>
							<td><br/> <br/><br /> <br /> <br/><br /> <br /> <br/></td>
						</tr>
						<tr>
							<td>Berlin, <?php echo date('d.m.Y');?></td>
							<td align="right"><img src="assets/images/logo.png" width="250px"
								height="auto" /></td>
						</tr>
						<tr>
							<td>Ort, Datum
							</td>
							<td align="right">Stempel,
								Unterschrift NextLevel Akademie
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	</main>
</body>
</html>