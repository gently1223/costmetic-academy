<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Teilnahmebescheinigung</title>
<?php
if ($personal_details['qualification'] != '') {
    $path = 'certificate_templates/' . $personal_details['template']; //'certificate_templates/2.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
?>  
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<style>
@page {
	size: a4 portrait;
	margin: 0px;
	font-family: GOTHIC;
}

html {
	margin: 0px;
}
ul li{
	list-style: none;
}
body {
	
	font-family: GOTHIC;
	background-image:url('<?php echo $base64;?>');
	text-align: center;
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
	src: url(https://app.nextlevel-akademie.de/cosmetic-school/vendor/dompdf/dompdf/lib/fonts/GOTHIC.TTF)
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
	top: 0px;
	left: 0px;
	right: 0px;
	
}
ul li{
	list-style: none !important;
	font-size: 14px;
	line-height: 1;		
}
ul li::before{
	content: '\2022';
	margin-right: 5px;
	font-weight: bold;
	line-height: 1;

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
<?php
$totalpages = floor(round(count($personal_details['module_items']) / 10, PHP_ROUND_HALF_DOWN) + 1);

$cc = 0;
for ($i = 1; $i <= $totalpages; $i ++) {
    if ($i <= $totalpages) {
        
        $count = 1;
        $list = '<ul style="padding-bottom:50px;">';
        
        for ($j = $cc; count($personal_details['module_items']) > $j; $j++) {
            $personal_details['module_items'][$j] = str_replace("&nbsp;", "", $personal_details['module_items'][$j]);
            if(trim($personal_details['module_items'][$j]) != "") {
                $list .= '<li style="font-size: 20px; color: #000;">' . trim($personal_details['module_items'][$j]) . '</li>';
                
                if ($count == 10) {
                    
                    break;
                }
            }
            $count ++;
        }
        
        $list .= '</ul>';
                 
            if($i < $totalpages) {?>
<div class="page">
  <?php }
  else 
  { ?>
<div class="last-page">
  <?php }?>
	<table width="100%" align="center" style="padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px;">
		<tr>
			<td align="center"
					style="font-size: 32px; padding-top: 80px; font-family: 'GOTHIC'; color: #499FA4; letter-spacing: 3px; line-height: 1;"><br/>TEILNAHME-<br>BESCHEINIGUNG
			</td>
		</tr>
		<tr>
			<td align="center"
					style="padding-top: 20px; font-size: 20px; color: #000; font-family: 'GOTHIC'">Die NextLevel zeichnet
			</td>
		</tr>
		<tr>
			<td align="center" style="font-family: 'GOTHIC'; font-size: 32px;padding-bottom: 10px; color: #499FA4; text-transform: uppercase;"><?php echo $personal_details['full_name'];?>
			</td>
		</tr>
		<tr>
			<td align="center" style="padding-top: 10px; font-family: 'GOTHIC'; font-size: 18px; margin: 10px 0; line-height:0.9;color: #000">für die erfolgreiche Teilnahme <br><?php echo  $personal_details['an_der']; ?> 
			</td>
		</tr>
		<tr>
			<td align="center" style="font-size: 22px; color: #000; font-family: 'GOTHIC';padding: 10px 0;"><?php echo mb_strtoupper($personal_details['qualification'], 'UTF-8');?><br/>aus.
			</td>
		</tr>
		<tr>
			<td align="center" style="font-size: 20px; color: #000; font-family: 'GOTHIC';line-height: 0.9;"><?php echo $personal_details['sub_qualification'];?>
			</td>
		</tr>
		<tr>
			<td align="center" style="font-size: 22px; color: #000; letter-spacing: 3px; font-family: 'GOTHIC';padding: 10px 0;">SCHWERPUNKTE
			</td>
		</tr>
		<tr>
			<td align="" style="padding-top:10px;padding-left: 28%; padding-right: 10px; font-family: 'GOTHIC';">
					<?php   echo $list; ?>
			</td>
		</tr>
	</table>
</div>
	<?php  } 
		$cc = $cc+10;
	}
?>
</main>

</body>

</html>
