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
<body style="margin:0px; padding-left:35px; padding-right:35px; padding-top:30px; padding-bottom:35px;">
    <?php
        $path = 'cv_templates/corner.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>
    <img src="<?php echo $base64; ?>" style="position:absolute; left:0pt; top:0pt; max-width:200px; max-height:200px;">
    
    <?php
        if($personal_details->profile_image!='') {
        $path = 'images/profile/'.$personal_details->profile_image;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    ?>
    
    <div style="clear:both; position:relative;">
        <!--<div style="display:inline-block; width:200px; height:50px;">
        </div>-->
        <?php if($personal_details->profile_image!='') { ?>
        <img src="<?php echo $base64; ?>" style="position:absolute; left:0pt; max-width:130px; max-height:130px; z-index:777; border-radius:10px; margin-right:30px; margin-top:17px;">
        <?php } ?>
        
        <div style="margin-left:160px;">
            <p style="margin:0px; font-size:35px; text-transform:uppercase;">LEBENSLAUF</p>
            
            <div style="margin:0px; font-size:19px; font-weight:bold; border-bottom:2px solid #cdb5a4; width:540px; max-width:100%;"><!--<img src="<?php //echo $base64; ?>" width="32" height="32">--> PERSÖNLICHE DATEN</div>
            <!--<hr style="margin-top:5px; margin-bottom:2px; border:1px solid #cdb5a4; max-width:460px;">-->
            
            <table style="margin-bottom:20px;">
            <tbody>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:160px; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top">
                        <?php
                        $path = 'images/user_icon.png';
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        ?>
                        <img src="<?php echo $base64; ?>" width="15" height="15" style="margin-bottom:2px; margin-right:5px;"> Name</td>
                    <td style="width:380px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php echo $personal_details->name; ?>
                    </td>
                </tr>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:100px; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top"><?php
                        $path = 'images/calendar_icon.png';
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        ?>
                        <img src="<?php echo $base64; ?>" width="15" height="15" style="margin-bottom:2px; margin-right:5px;"> Geburstdaten</td>
                    <td style="width:380px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php echo $personal_details->dob; ?>
                    </td>
                </tr>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:100px; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top"><?php
                        $path = 'images/address_icon.png';
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        ?>
                        <img src="<?php echo $base64; ?>" width="15" height="15" style="margin-bottom:2px; margin-right:5px;"> Adresse</td>
                    <td style="width:380px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php echo $personal_details->address; ?>
                    </td>
                </tr>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:100px; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top"><?php
                        $path = 'images/phone_icon.png';
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        ?>
                        <img src="<?php echo $base64; ?>" width="15" height="15" style="margin-bottom:2px; margin-right:5px;"> Telefon</td>
                    <td style="width:380px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php echo $personal_details->phone_no; ?>
                    </td>
                </tr>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:100px; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top"><?php
                        $path = 'images/email_icon.png';
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        ?>
                        <img src="<?php echo $base64; ?>" width="15" height="15" style="margin-bottom:2px; margin-right:5px;"> E-Mail</td>
                    <td style="width:380px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php echo $personal_details->email; ?>
                    </td>
                </tr>
            </tbody>
        </table>
            
        </div>
    </div>
    
    <div style="clear:both; position:relative;">
        
    <div style="padding-top:5px; width:620px;">
        <?php if(isset($experience) AND !empty($experience)) {
            //$path = 'images/experience.png';
            //$type = pathinfo($path, PATHINFO_EXTENSION);
            //$data = file_get_contents($path);
            //$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>
        <div style="margin:0px; font-size:19px; font-weight:bold; text-transform:uppercase; border-bottom:2px solid #cdb5a4; width:700px; <?php if(isset($preview_style)) echo $preview_style; ?> "><!--<img src="<?php //echo $base64; ?>" width="32" height="32">--> Berufserfahrung</div>
        <!--<hr style="margin-top:5px; margin-bottom:2px; border:1px solid #cdb5a4; width:700px; max-width:100%;">-->
        
        <table>
            <tbody>
                <?php
                    foreach($experience as $exp) {
                ?>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:200px; padding-top:5px; text-align:top; border-bottom:2px solid #ededed;" valign="top"><?php if($exp->present=='1') echo 'seit '; if($exp->from_month<10) echo '0'; echo $exp->from_month.'/'.$exp->from_year; 
                        if($exp->present=='0') { echo ' - '; if($exp->to_month<10 AND $exp->to_month!='') echo '0'; echo $exp->to_month.'/'.$exp->to_year; } ?></td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <b><?php echo $exp->company_name; ?></b><br>
                        <?php echo $exp->job_title; ?><br>
                        <ul style="padding-left:13px; color:#888; margin-bottom:0px;">
                            <?php 
                        $responsibilities=array();
                        if($exp->responsibilities!='') $responsibilities=explode(';', $exp->responsibilities);
                        
                        foreach($responsibilities as $resp) {
                            ?>
                            <li><?php echo $resp; ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <?php
        } if(isset($education) AND !empty($education)) {
            //$path = 'images/education.png';
            //$type = pathinfo($path, PATHINFO_EXTENSION);
            //$data = file_get_contents($path);
            //$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>
        <div style="margin:0px; font-size:19px; margin-top:30px; font-weight:bold; text-transform:uppercase; border-bottom:2px solid #cdb5a4; width:700px; <?php if(isset($preview_style)) echo $preview_style; ?>"><!--<img src="<?php //echo $base64; ?>" width="32" height="32" style="display:none;">--> Ausbildung</div>
        <!--<hr style="margin-top:5px; margin-bottom:2px; border:1px solid #cdb5a4; width:700px; max-width:100%;">-->
        
        <table style="border-collapse: collapse;">
            <tbody>
                <?php
                    foreach($education as $edu) {
                ?>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:200px; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top"><?php if($edu->present=='1') echo 'seit '; if($edu->from_month<10) echo '0'; echo $edu->from_month.'/'.$edu->from_year; 
                        
                        if($edu->present=='0') { echo ' - '; if($edu->to_month<10 AND $edu->to_month!='') echo '0'; echo $edu->to_month.'/'.$edu->to_year; } ?></td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <b><?php echo $edu->school; ?></b><br>
                        <?php echo $edu->qualification; ?><br>
                        <ul style="padding-left:13px; color:#888; margin-bottom:0px;">
                            <?php 
                        $details=array();
                        if($edu->details!='') $details=explode(';', $edu->details);
                        
                        foreach($details as $detail) {
                            ?>
                            <li><?php echo $detail; ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <?php }
            //$path = 'images/skills.png';
            //$type = pathinfo($path, PATHINFO_EXTENSION);
            //$data = file_get_contents($path);
            //$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>
        <div style="margin:0px; font-size:19px; margin-top:30px; font-weight:bold; text-transform:uppercase; border-bottom:2px solid #cdb5a4; width:700px; <?php if(isset($preview_style)) echo $preview_style; ?>"><!--<img src="<?php //echo $base64; ?>" width="32" height="32">--> Kenntnisse und Interessen</div>
        <!--<hr style="margin-top:5px; margin-bottom:2px; border:1px solid #cdb5a4; width:700px; max-width:100%;">-->
        
        <table style="margin-bottom:20px;">
            <tbody>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:200px; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top">Fremdsprachen</td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php 
                        if(!empty($languages)) {
                            foreach($languages as $language) {
                                echo $language->language.' ('.$language->fluency.')<br>';
                            } } ?>
                    </td>
                </tr>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:200px; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top">IT-Kenntnisse</td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php 
                        if(!empty($skills)) {
                            foreach($skills as $skill) {
                                echo $skill->skill.' ('.$skill->fluency.')<br>';
                            } } ?>
                    </td>
                </tr>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:200px; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top">Hobbys</td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php 
                        if(!empty($hobby)) {
                                echo $hobby->hobby;
                            } ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
</body>
</html>
