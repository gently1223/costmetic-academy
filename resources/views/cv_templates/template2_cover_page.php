<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        @page { margin: 0px; }
        body { margin: 0px; }
        
        h1, h4{
            font-family: sans-serif;
        }
        
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body style="margin:0px;">
    <?php
        if($personal_details->profile_image!='') {
        $path = 'cv_templates/corner.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>
    <img src="<?php echo $base64; ?>" style="position:absolute; left:0pt; top:0pt; max-width:300px; max-height:300px;">
    <?php } ?>
    
    <div style="text-align:center; padding-top:90px; margin-left:20px; margin-right:20px;">
        <p style="margin:0px; font-size:40px;"><?php if(isset($personal_details->name)) echo $personal_details->name; ?></p>
        <p style="margin:0px; font-size:19px;"><?php if(isset($personal_details->title)) echo 'Bewerbung als '.$personal_details->title; ?></p>
        
    <?php
        if($personal_details->profile_image!='') {
        $path = 'images/profile/'.$personal_details->profile_image;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>
    <img src="<?php echo $base64; ?>" style="max-width:130px; max-height:130px; z-index:777; border-radius:10px; margin-top:80px;">
    <?php } ?>
    </div>
    
    <div style="clear:both; position:relative; border-top:2px solid #cdb5a4; margin-top:120px; padding-top:20px; margin-left:55px; margin-right:55px;">
    <div style="position:absolute; left:0pt; width:350px; height:100vh; padding-left:30px;">
        <p><b>Kontaktdaten:</b></p>
        
        <p><?php echo $personal_details->address; ?></p>
        
        <p>
            Telefon: <?php echo $personal_details->phone_no; ?><br>
            Email: <?php echo $personal_details->email; ?>
        </p>
        
        
    </div>
        
    <div style="margin-left:350px; width:350px; padding-left:55px;">
        <p><b>Anlagen:</b></p>
        
        <?php if(isset($attachment_name)) { ?>
        <p style="padding-bottom:160px;"><?php echo $attachment_name; ?></p>
        <?php } ?>
        
    </div>
</div>
    
</body>
    <?php if(!isset($pdf_generate)) { ?>
</html>
    <?php } ?>
