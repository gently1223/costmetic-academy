<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Zusatzqualifikation Zertifikat</title>
<?php
if ($personal_details['qualification'] != '') {
    $path = 'certificate_templates/' . $personal_details['template']; //'certificate_templates/1.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
?>    
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
ul li{
  list-style: none !important;
  line-height: 1;
}
ul li::before{
  content: '\2022';
  margin-right: 5px;
  font-weight: bold;

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

<body>


  <main>
    <?php
$totalpages = floor(round(count($personal_details['module_items']) / 7, PHP_ROUND_HALF_DOWN) + 1);

$cc = 0;
for ($i = 1; $i <= $totalpages; $i ++) {
    if ($i <= $totalpages) {

        $count = 1;
        $list = '<ul style="padding-bottom:70px;">';

        for ($j = $cc; count($personal_details['module_items']) > $j; $j++) {
            $personal_details['module_items'][$j] = str_replace("&nbsp;", "", $personal_details['module_items'][$j]);
            if(trim($personal_details['module_items'][$j]) != "") {
            $list .= '<li>' . trim($personal_details['module_items'][$j]) . '</li>';

            if ($count == 6) {

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
  {?>
  <div class="last-page">
  <?php }?>
    <table width="100%" align="center">
      <tr>
        <td align="center"
          style="padding-top: 120px; font-size: 45px; color: #499FA4; letter-spacing: 3px; font-family: 'GOTHIC';">ZERTIFIKAT</td>
      </tr>
      <tr>
        <td align="center"
          style="font-size: 20px; color: #000; font-family: 'GOTHIC'; font-weight: 400;">Die
          NextLevel zeichnet</td>
      </tr>
      <tr>
        <td align="center"
          style="font-size: 34px; color: #499FA4; text-transform: uppercase; font-family: 'GOTHIC';"><?php echo $personal_details['full_name'];?></td>
      </tr>
      <tr>
        <td align="center"
          style="font-size: 18px; color: #000; font-family: 'GOTHIC';">für die erfolgreiche Teilnahme vom 
          <?php echo $personal_details['from_date'];?> bis <?php echo $personal_details['to_date'];?> <br/><?php echo $personal_details['an_der'];?> aus.
         </td>
      </tr>
      <tr>
        <td align="center"
          style="padding-top:12px;font-size: 16px; line-height: 1; color: #000; font-weight: 400; letter-spacing: 3px; font-family: 'GOTHIC';">ZUSATZQUALIFIKATION
          <br><?php echo strtoupper($personal_details['qualification']);?>
        
        </td>
      </tr>
      <tr>
        <td align=""
          style="padding-top:30px;padding-left: 35%; padding-right: 10px; font-family: 'GOTHIC';">
        
        <?php   echo $list; ?>
        

        </td>
      </tr>





    </table>
  </div>
    <?php

} 
      $cc = $cc+6;
  
 }
?>
  </main>
  <!-- -->
</body>
</html>
