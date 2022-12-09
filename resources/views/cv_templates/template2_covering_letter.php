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
    <img src="<?php echo $base64; ?>" style="position:absolute; left:0pt; top:0pt; max-width:150px; max-height:150px;">
    <?php } ?>
    
    <div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:350px; padding-top:100px; height:100vh; padding-left:68px;">
        
        <p>
            <?php echo nl2br($personal_details->to_address); ?>
        </p>
        
    </div>
        
    <div style="margin-left:350px; padding-top:100px; width:350px; padding-left:55px; padding-right:68px;">
        
        <p>
            <?php echo $personal_details->name; ?><br>
            <?php echo $personal_details->address; ?>
        </p>
        
        <p>
            Telefon: <?php echo $personal_details->phone_no; ?><br>
            Email: <?php echo $personal_details->email; ?>
        </p>
        
    </div>
</div>
    
    <div style="padding-left:68px; padding-top:20px; margin-right:68px;">
        <p style="border-bottom:2px solid #cdb5a4; font-weight:bold; padding-bottom:8px;"><?php if(isset($personal_details->title)) echo 'Bewerbung als '.$personal_details->title; ?></p>
        
        <p style="margin-top:20px; text-align:justify;"><?php echo nl2br($personal_details->content); ?></p>
        <p>
            <?php
                if($personal_details->signature!='') {
                $path = 'signatures/'.$personal_details->signature;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>
        <img src="<?php echo $base64; ?>" style="max-width:150px; max-height:150px; z-index:777; margin-top:20px; margin-bottom:20px;">
            <?php } ?>
        </p>
    </div>
    
</body>
    <?php if(!isset($pdf_generate)) { ?>
</html>
    <?php } ?>
