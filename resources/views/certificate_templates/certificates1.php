<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
if ($personal_details['qualification'] != '') {
    $path = 'certificate_templates/' . $personal_details['template']; //'certificate_templates/1.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
?>   
<title>Abschlusszertifikat</title>
<link rel="stylesheet" type="text/css"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<style>
@page {
	size:a3 portrait;
	margin: 0px;
	font-family: GOTHIC;

}

html {
	margin: 0px
}

body {
	margin: 0px;
	font-family: GOTHIC;
	background-image:url('<?php echo $base64;?>');
	background-position: center center; /* Center the image */
    background-repeat: no-repeat; /* Do not repeat the image */
    background-size: contain; /* Resize the background image to cover the entire container */
	/*padding: 20px;*/

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
main{
	overflow: hidden;
}
</style>
</head>

<body>


	<main>
	<div class="last-page">
		<table width="100%" align="center"
			style="padding-top: 150px; padding-left: 10px; padding-right: 10px;">

			<tr>
				<td align="center"
					style="font-size: 42px; color: #fff; letter-spacing: 3px; font-family: 'GOTHIC';">ZERTIFIKAT</td>

			</tr>
			<tr>
				<td align="center"
					style="font-size: 20px; color: #fff; font-family: 'GOTHIC';"><?php echo mb_strtoupper($personal_details['qualification'], 'UTF-8');?><br><?php echo mb_strtoupper($personal_details['sub_qualification'], 'UTF-8');?></td>
			</tr>

			<tr>
				<td align="center"
					style="font-size: 20px; margin: 10px 0; color: #fff; font-family: 'GOTHIC';">Die
					NextLevel zeichnet</td>
			</tr>
			<tr>
				<td align="center"
					style="font-size: 42px; color: #fff; font-family: 'GOTHIC'; text-transform: uppercase;"><?php echo mb_strtoupper($personal_details['full_name'], 'UTF-8');?></td>
			</tr>
			<tr>
				<td align="center"
					style="font-size: 18px; margin: 10px 0; font-family: 'GOTHIC'; color: #fff;">für
					die erfolgreiche Teilnahme <?php echo  $personal_details['an_der']; ?> <br>
					vom <?php echo $personal_details['from_date'];?> bis <?php echo $personal_details['to_date'];?> aus.
				 
				
				
				
				</td>
			</tr>

		</table>
	</div>
	</main>
</body>
</html>
