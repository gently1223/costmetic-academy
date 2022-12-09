<?php
header("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
	<title>Angebot für Coaching/Umschulung</title>
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
	font-weight: normal;
	src:
		url(https://app.nextlevel-akademie.de/cosmetic-school/vendor/dompdf/dompdf/lib/fonts/GOTHICB.TTF)
		format('truetype');
}

table thead tr th {
	font-family: 'GOTHICB';
}

table tbody tr td {
	font-family: 'GOTHIC';
}

ul li:before {
	vertical-align: middle;
	font-size: 1.5em;
}

footer {
	position: fixed;
	bottom: 10px;
	left: 0px;
	right: 0px;
	height: 50px;
}

.last-page {
	page-break-after: never;
	overflow: hidden;
}
</style>

</head>
<body
	style="margin-left: 70px; margin-right: 50px; padding-bottom: 50px; padding-top: 50px; text-align: justify-all;">

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
		<table>

			<tr>
				<td align="center" style="font-size: 20px;"><b><br />
					<br /></b></td>
			</tr>
			<tr>
				<td><u><font style="font-size: 11px;">NextLevel Akademie,
							Bundesallee 86, 12161 Berlin</font></u></td>
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
			<br><br><br><br> <br></br>

							<tr>
								<td style="text-align: justify;"><br></br>
								<b>Betreff</b> Kd.-Nr:&nbsp;<?php echo $studentno; ?> </td>
							</tr>
							<tr>
								<td><br></td>
							</tr>
							<tr>
								<td style="text-align: justify;">Sehr geehrte/r Frau/Herr&nbsp;<?php echo $expert_advisor; ?>,<br /><br />
								</td>

							</tr>
							<tr>

								<td style="text-align: justify;">

                                                                           <?php
                                                                        $replacetext = "";
                                                                        $replacetext2 = "";

                                                                        $addons = \DB::table('regular_addon')->select('*')->
                                                                        // ->where('regular_main', $qualificationid)
                                                                        get();

                                                                        if (count($addons) == 0) {

                                                                            $qual_name = '"' . $qualification . '" &nbsp;und ist gemäß des Erstgespräches auch geeignet.<br/><br/>';
                                                                            $replacetext2 = '';
                                                                            $replacetext = utf8_decode($studname) . "&nbsp;interessiert sich für die&nbsp;" . $qual_name;

                                                                            echo $replacetext;
                                                                        }

                                                                        ?><?php

                                                                        if (count($addons) > 0) {
                                                                            $qual_name = '"' . $qualification . '"';
                                                                            echo utf8_decode($studname) . "&nbsp;interessiert sich für die&nbsp;" . $qual_name;
                                                                        }

                                                                        foreach ($addons as $add) {
                                                                            if (in_array($add->id, $addon)) {
                                                                                echo " " . $add->addon_text;
                                                                            }
                                                                        }
                                                                        ?>

                                                                            <?php
                                                                            if (count($addons) > 0) {
                                                                                $replacetext2 = "und ist gemäß des Erstgespräches auch geeignet.<br/><br/>";
                                                                                $replacetext = '';
                                                                                echo $replacetext2;
                                                                            }
                                                                            ?>

                                                                        
                                                                        </td>
							</tr>
							<tr>


								<td style="text-align: justify;">
                                                                            <?php

                                                                            foreach ($textt as $text) {
                                                                                $maintext = $text['texts'][0];

                                                                                if (strpos($maintext, 'Autofill durch Auswahl Fachberater/Verkäufer/Kauffrau') !== false) {

                                                                                    $maintext = str_replace("Autofill durch Auswahl Fachberater/Verkäufer/Kauffrau", $qualifications[1]['qual'][0], $maintext);
                                                                                }
                                                                                if (strpos($maintext, 'Name Kunde Autofill') !== false) {

                                                                                    $maintext = str_replace("Name Kunde Autofill", utf8_decode($studname), $maintext);
                                                                                }
                                                                                echo $maintext . ' ';

                                                                                $extra = \DB::table('regular_extraqualifications')->select('*')
                                                                                    ->where('text_main_id', $text['id'][0])
                                                                                    ->get();

                                                                                    if($text['id'][0] == '1') {
                                                                                        echo '<ul>';
                                                                                    }
                                                                                foreach ($extra as $ex) {
                                                                                    if (in_array($ex->id, $extr)) {
                                                                                        if($text['id'][0] == '1') //extra qualifications should be in UL->LI)
                                                                                            echo '<li>' . $ex->extra_text . '</li>';
                                                                                            
                                                                                        else{
                                                                                            echo $ex->extra_text;}
                                                                                    }
                                                                                }
                                                                                if($text['id'][0] == '1') {
                                                                                    echo '</ul>';
                                                                                }
                                                                            }
                                                                            if (count($textt) > 0) {
                                                                                echo 'zusammen.<br/><br/>';
                                                                            }
                                                                            ?> 
                                                                           <?php
                                                                        if ($qualificationid == 1) {

                                                                            $extras = \DB::table('quali_textblocks')->select('*')
                                                                                ->where('qual_id', $qualificationid)
                                                                                ->get();

                                                                            foreach ($extras as $ex) {

                                                                                if (in_array($ex->id, $quaalblk)) {
                                                                                    $maintext = $ex->text_blk;
                                                                                    $maintext = str_replace("Name Kunde Autofill", utf8_decode($studname), $maintext);
                                                                                    $maintext = str_replace("startdatum", date('d.m.Y'), $maintext);

                                                                                    echo $maintext . '<br><br>';
                                                                                }
                                                                            }
                                                                        }

                                                                        if ($qualificationid == 2) {

                                                                            $extras = \DB::table('quali_textblocks')->select('*')
                                                                                ->where('qual_id', $qualificationid)
                                                                                ->get();
                                                                            foreach ($extras as $ex) {
                                                                                if (in_array($ex->id, $quaalblk)) {
                                                                                    $maintext = $ex->text_blk;

                                                                                    $maintext = str_replace("Name Kunde Autofill", utf8_decode($studname), $maintext);
                                                                                    $maintext = str_replace("startdatum", date('d.m.Y'), $maintext);

                                                                                    echo $maintext . '<br><br>';
                                                                                }
                                                                            }
                                                                        }
                                                                        if ($qualificationid == 3) {

                                                                            $extras = \DB::table('quali_textblocks')->select('*')
                                                                                ->where('qual_id', $qualificationid)
                                                                                ->get();

                                                                            foreach ($extras as $ex) {
                                                                                if (in_array($ex->id, $quaalblk)) {
                                                                                    $maintext = $ex->text_blk;

                                                                                    $maintext = str_replace("Name Kunde Autofill", utf8_decode($studname), $maintext);
                                                                                    $maintext = str_replace("startdatum", date('d.m.Y'), $maintext);

                                                                                    echo $maintext . '<br><br>';
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>


                                                                                </td>
							</tr>

							<tr>
								<td><br></td>
							</tr>
							<tr>
								<td><?php echo $test_desc?></td>
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
								<td><br />
								<br /></td>
							</tr>
							<tr>
								<td>Mit freundlichen grüßen</td>
							</tr>



							<tr>
								<td><?php
        if (file_exists((dirname(dirname(public_path())) . '/admin_signatures/' . $signature))) {
            echo '<img src="' . dirname(dirname(public_path())) . '/admin_signatures/' . $signature . '" width="250px" style=" text-decoration: none;
    border-bottom: 2px solid black;" />';
        } 
        ?><br> NextLevel Akademie </td>



							</tr>
		
		</table>



	</div>
	</main>
</body>
</html>



