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
    
    <div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:200px; background:#ededed; padding:5px; height:100vh; padding-left:15px; padding-top:180px;">
        <p><b>Kontaktdaten:</b></p>
        
        <p><?php echo $personal_details->address; ?></p>
        
        <p>
            Telefon: <?php echo $personal_details->phone_no; ?><br>
            Email: <?php echo $personal_details->email; ?>
        </p>
        
        <p style="margin-top:30px;"><b>Anlagen:</b></p>
        
        <?php if(isset($attachment_name)) { ?>
        <p style="padding-bottom:160px;"><?php echo $attachment_name; ?></p>
        <?php } ?>
    </div>
        
    <div style="margin-left:230px; width:490px; padding-left:80px; <?php if(isset($preview_mrg_style)) echo $preview_mrg_style; ?>">
        
        <div style="padding-top:160px;">
        <p style="margin:0px; font-size:40px;"><?php if(isset($personal_details->name)) echo $personal_details->name; ?></p>
        <p style="margin:0px; font-size:19px;"><?php if(isset($personal_details->title)) echo 'Bewerbung als '.$personal_details->title; ?></p>
        
    <?php
        if($personal_details->profile_image!='') {
        $path = 'images/profile/'.$personal_details->profile_image;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>
    <img src="<?php echo $base64; ?>" style="max-width:130px; max-height:130px; z-index:777; border-radius:10px; margin-top:70px; margin-bottom:70px;">
    <?php } ?>
    </div>
        
    </div>
        
</div>
    
</body>
    <?php if(!isset($pdf_generate)) { ?>
</html>
    <?php } ?>
