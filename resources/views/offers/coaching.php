<?php
header("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
	<title>Empfehlungsschreiben für das Coaching</title>
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
	style="margin-left: 70px; margin-right: 50px; text-align: justify-all;">

	<footer>
	<table width="520"
		style="padding-left: 150px; padding-right: 50px; font-size: 12px;">
		<tr>
			<td align="center" style="color: #9B9B9B;">NextLevel Akademie-Inh.
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
				<td align="center" style="font-size: 20px;"><b><br /><br><br> <br /></b></td>
			</tr>
			<tr>

				<td>
					<h5>
						<b>Empfehlungsschreiben für das Coaching</b>
					</h5> <u><font style="font-size: 11px;">NextLevel Akademie,
							Bundesallee 86, 12161 Berlin</font></u>
				</td>
			</tr>

			<tr>
				<td><b><?php

    if (isset($jobcenter_name)) {
        echo $jobcenter_name;
    } else
        echo "Jobcenter"?> / Agentur für Arbeit</b><br>
                            <?php

                            if (isset($expert_advisor)) {
                                echo $expert_advisor;
                            }
                            ?><br>
<?php

if (isset($street)) {
    echo utf8_decode($street);
}
?> <?php

if (isset($door_no)) {
    echo $door_no;
}
?> <br>
<?php

if (isset($zip)) {
    echo $zip;
}
?> <?php

if (isset($city)) {
    echo $city;
}
?> <br></td>
			</tr>
			<tr>
				<td align="right">Berlin,&nbsp;<?php echo date('d.m.Y') ?></td>
			</tr>
			

							<tr>
								<td style="text-align: justify;"></br><br></br> <b>Betreff</b> Kd.-Nr:&nbsp;<?php echo $studentno; ?> </td>
							</tr>
							<tr>
								<td><br></td>
							</tr>
							<tr>
								<td style="text-align: justify;">Sehr geehrte <?php

if ($expert_gender == "Female") {
            echo "Frau";
        } else {
            echo "Herr &nbsp;";
        }
        echo $expert_advisor;
        ?>,<br /> <br />
								</td>

							</tr>
							<tr>

								<td style="text-align: justify;">
                                  der o.g. Kunde war am  <?php  echo date('d.m.Y')?> zu einem Beratungsgespräch bei uns in der NextLevel Akademie.
                                                                         
                                                                        </td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>


								<td style="text-align: justify;">
                                                                            <?php
                                                                            // echo '<ul>';

                                                                            if (in_array(1, $starr)) {

                                                                                echo 'Wir haben gemeinsam evaluiert, dass die berufliche Zukunft derzeit noch sehr unklar ist und der Kunde gern mit einem Coach daran arbeiten möchte.<br><br>';
                                                                            }
                                                                            if (in_array(2, $starr)) {

                                                                                echo 'So sollen Unsicherheiten bzgl. der persönlichen Zukunft abgebaut werden und gleichzeitig eine realistische Vorstellung der beruflichen Zukunft entwickelt werden, die bis hin zum Jobeinstieg durch uns unterstützt wird. 
Der Kunde wünscht sich Unterstützung im Bereich der Erstellung von Bewerbungsunterlagen, der Selbst- & Fremdwahrnehmung inkl. Ressourcenanalyse, Blockaden aufdecken und Selbstsicherheit in Bewerbungsverfahren sowie Unterstützung bei der Weg-Ziel-Planung und das ausloten von neuen Möglichkeiten.
';
                                                                            }

                                                                            ?>


                                                                                </td>
							</tr>

							<tr>
								<td><br></td>
							</tr>
							<tr>
								<td style="text-align: justify;"><?php echo $test_desc?></td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>
								<td style="text-align: justify;">Aufgrund der persönlichen
									Schilderungen des Kunden und seiner momentanen Situation
									empfehlen wir die Teilnahme an der Coachingmaßnahme 
                              <?php
                            foreach ($prodarr as $key => $value) {

                                $products = \DB::table('products')->select('*')
                                    ->where('id', $value)
                                    ->get();
                                echo '<font face="DejaVu Sans"><b>' . $products[0]->title . '</b></font>';
                                echo " ab sofort in drei Monaten Laufzeit mit einem Umfang " . $total_less . " UE.<br> ";
                            }

                            ?>
                            </td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>
								<td style="text-align: justify;">So kann der Entwicklungsprozess
									arbeitsmarktnah und langfristig erfolgreich sein. Bitte stellen
									Sie dem Kunden den AVGS01 aus.<br> <br>
								
								</td>
							</tr>
							
			</table>
			</div>
			
			
			<div class="last-page">
			<table width="520"
			style="margin-top: 40px; padding-left: 10px; padding-right: 10px; font-size: 14px;">				
							
							<tr>
								<td style="text-align: justify;">Anbei senden wir lhnen die
									individuelle Bedarfsermittlung aus dem Beratungsgespräch und
									der Selbsteinschätzung zur detaillierten Übersicht.<br><br>
								
								</td>
							</tr>
			
							<tr>
								<td style="text-align: justify;">In der unten aufgeführten Liste
									sehen Sie den Überblick zum Bedarf.</td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>
								<td>
									<ul>
  
                                <?php

                                foreach ($prodarr as $key => $value) {

                                    $row3 = DB::SELECT("SELECT * FROM products where id = '" . $value . "'");
                                    foreach ($row3 as $key => $value5) {
                                        echo '<font size=13 face="DejaVu Sans"><b>' . $value5->title . '</b></font><br>';

                                        foreach ($modarr as $key => $value2) {

                                            $row2 = DB::SELECT("SELECT m.* FROM modules m inner join product_modules pm on pm.m_id = m.id where pm.p_id = '" . $value5->id . "' and m.id='" . $value2 . "'");
                                            foreach ($row2 as $key => $value3) {
                                                echo ' <font size=12 face="DejaVu Sans"><p style="padding-left:20px;"><b>' . $value3->title . '</b><p></font>';

                                                foreach ($itemsarr as $key => $value6) {

                                                    $row3 = DB::SELECT("  select * from module_items mi inner join modules_module_items mmi on mmi.m_id = mi.id where mmi.p_id= '" . $value2 . "' and mi.id= '" . $value6 . "'  ");

                                                    foreach ($row3 as $key => $value8) {
                                                        echo ' <p style="padding-left:40px;">' . $value8->title . '</p>';
                                                    }
                                                }
                                            }
                                        }
                                        echo '</ul>';
                                    }
                                }

                                ?>


                                
								
								
								
								</td>
							</tr>




							<tr>
								<td><br></td>
							</tr>
							<tr>
								<td>für Rückfragen erreichen Sie uns telefonisch unter 030 89 64
									00 64 oder unter&nbsp;&nbsp;<br><a href="#">info@nextlevel-akademie.de</a>.




								
								
								</td>
								<td><br /></td>
							</tr>
							<tr>
								<td><br /> <br /></td>
							</tr>
							<tr>
								<td>Mit freundlichen grüßen</td>
							</tr>



							<tr>
								<td><?php
        if (file_exists((dirname(dirname(public_path())) . '/admin_signatures/' . $signature))) {
            echo '<img src="' . dirname(dirname(public_path())) . '/admin_signatures/' . $signature . '" width="250px" style=" text-decoration: none;
    border-bottom: 2px solid black;" />';
        } else {
            ?> <br/> <br/> <br/> <br/> <?php 
        }
        ?><br> NextLevel Akademie </td>



							</tr>
		
		</table>



	</div>
	</main>
</body>
</html>



