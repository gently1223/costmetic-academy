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
        $path = 'images/profile/'.$personal_details->profile_image;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>
    <img src="<?php echo $base64; ?>" style="max-width:130px; max-height:130px; position:absolute; z-index:777; border-radius:10px; left:55px; top:65px;">
    <?php } ?>
    
    <div style="background:#333f49; color:white; overflow:hidden;">
        <!--<div style="display:inline-block; width:200px; height:50px;">
        </div>-->
        <div style="display:inline-block; width:750px; padding-left:250px; padding-top:25px; padding-bottom:25px;">
            <p style="margin:0px; font-size:40px;"><?php if(isset($personal_details->name)) echo $personal_details->name; ?></p>
            <p style="margin:0px; font-size:19px;">LEBENSLAUF</p>
        </div>
    </div>
    
    <div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:240px; background:#ededed; padding-top:20px; text-align:center; padding-top:130px; height:100vh;">
        <small>Geburtsdatum</small>
        <p><?php if(isset($personal_details->dob)) echo $personal_details->dob; ?></p>
        
        <small>Adresse</small>
        <p><?php if(isset($personal_details->address)) echo $personal_details->address; ?></p>
        
        <small>Telefon</small>
        <p><?php if(isset($personal_details->phone_no)) echo $personal_details->phone_no; ?></p>
        
        <small>E-Mail</small>
        <p><?php if(isset($personal_details->email)) echo $personal_details->email; ?></p>
    </div>
        
    <div style="margin-left:250px; padding-top:20px; width:510px;">
        <?php if(isset($experience) AND !empty($experience)) {
            $path = 'images/experience.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>
        <p style="margin:0px; font-size:19px;"><img src="<?php echo $base64; ?>" width="32" height="32"> Berufserfahrung</p>
        <hr style="margin-top:5px; margin-bottom:2px; border:1px solid #ededed;">
        
        <table>
            <tbody>
                <?php
                    foreach($experience as $exp) {
                ?>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:160px; font-weight:bold; padding-top:5px; text-align:top; border-bottom:2px solid #ededed;" valign="top"><?php if($exp->present=='1') echo 'seit '; if($exp->from_month<10) echo '0'; echo $exp->from_month.'/'.$exp->from_year; 
                        if($exp->present=='0') { echo ' - '; if($exp->to_month<10 AND $exp->to_month!='') echo '0'; echo $exp->to_month.'/'.$exp->to_year; } ?></td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
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
            $path = 'images/education.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>
        <p style="margin:0px; font-size:19px; margin-top:30px;"><img src="<?php echo $base64; ?>" width="32" height="32"> Ausbildung</p>
        <hr style="margin-top:5px; margin-bottom:2px; border:1px solid #ededed;">
        
        <table style="border-collapse: collapse;">
            <tbody>
                <?php
                    foreach($education as $edu) {
                ?>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:160px; font-weight:bold; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top"><?php if($edu->present=='1') echo 'seit '; if($edu->from_month<10) echo '0'; echo $edu->from_month.'/'.$edu->from_year; 
                        
                        if($edu->present=='0') { echo ' - '; if($edu->to_month<10 AND $edu->to_month!='') echo '0'; echo $edu->to_month.'/'.$edu->to_year; } ?></td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
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
            $path = 'images/skills.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>
        <p style="margin:0px; font-size:19px; margin-top:30px;"><img src="<?php echo $base64; ?>" width="32" height="32"> Kenntnisse und Interessen</p>
        <hr style="margin-top:5px; margin-bottom:2px; border:1px solid #ededed;">
        
        <table style="margin-bottom:20px;">
            <tbody>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:160px; font-weight:bold; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top">Fremdsprachen</td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php 
                        if(!empty($languages)) {
                            foreach($languages as $language) {
                                echo $language->language.' ('.$language->fluency.')<br>';
                            } } ?>
                    </td>
                </tr>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:160px; font-weight:bold; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top">IT-Kenntnisse</td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
                        <?php 
                        if(!empty($skills)) {
                            foreach($skills as $skill) {
                                echo $skill->skill.' ('.$skill->fluency.')<br>';
                            } } ?>
                    </td>
                </tr>
                <tr style="border-bottom:2px solid #ededed;">
                    <td style="width:160px; font-weight:bold; text-align:top; padding-top:5px; border-bottom:2px solid #ededed;" valign="top">Hobbys</td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px; border-bottom:2px solid #ededed;">
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
