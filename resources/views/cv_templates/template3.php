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
    <img src="<?php echo $base64; ?>" style="max-width:130px; max-height:130px; position:absolute; z-index:777; left:650px; top:15px; <?php if(isset($preview_img_style)) echo $preview_img_style; ?>">
    <?php } ?>
    
    <div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:200px; background:#ededed; padding:5px; height:100vh;">
        <div style="background-color: #465C7A; color:white; padding:15px; font-size:20px;">Lebenslauf</div>
        <div style="background-color: #D7D7D7; padding:15px; font-size:17px; margin-top:10px;">Persönliche Daten</div>
    </div>
        
    <div style="margin-left:230px; padding-top:20px; width:510px; <?php if(isset($preview_mrg_style)) echo $preview_mrg_style; ?>">
        
        <hr style="margin-top:55px; margin-bottom:10px; border:1px solid #ededed;">
        
        <table style="margin-top:0px; margin-bottom:15px;">
            <tbody>
                <tr>
                    <td style="width:200px; text-align:top; padding-top:5px; color:#717171;" valign="top">Name</td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px;">
                        <?php echo $personal_details->name; ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:200px; text-align:top; padding-top:5px; color:#717171;" valign="top">Geburtsdatum</td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px;">
                        <?php echo $personal_details->dob; ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:200px; text-align:top; padding-top:5px; color:#717171;" valign="top">Adresse</td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px;">
                        <?php echo $personal_details->address; ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:200px; text-align:top; padding-top:5px; color:#717171;" valign="top">Telefon</td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px;">
                        <?php echo $personal_details->phone_no; ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:200px; text-align:top; padding-top:5px; color:#717171;" valign="top">E-Mail</td>
                    <td style="width:500px; padding-top:5px; padding-bottom:5px;">
                        <?php echo $personal_details->email; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
        
        <?php if(isset($experience) AND !empty($experience)) { ?>
        <div style="position:absolute; left:0pt; width:200px; background:#ededed; padding:5px;">
        <div style="background-color: #D7D7D7; padding:15px; font-size:17px;">Berufserfahrung</div>
    </div>
        
    <div style="margin-left:230px; padding-top:5px; width:510px; <?php if(isset($preview_mrg_style)) echo $preview_mrg_style; ?>">
        
        <hr style="margin-bottom:15px; border:1px solid #ededed; margin-top:0px;">
        
        <table>
            <tbody>
                <?php
                    foreach($experience as $ex2) {
                ?>
                <tr>
                    <td style="width:160px; padding-top:5px; text-align:top; color:#717171;" valign="top"><?php if($ex2->present=='1') echo 'seit '; if($ex2->from_month<10) echo '0'; echo $ex2->from_month.'/'.$ex2->from_year; 
                        if($ex2->present=='0') { echo ' - '; if($ex2->to_month<10 AND $ex2->to_month!='') echo '0'; echo $ex2->to_month.'/'.$ex2->to_year; } ?></td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px;">
                        <b><?php echo $ex2->company_name; ?></b><br>
                        <?php echo $ex2->job_title; ?><br>
                        <ul style="padding-left:13px; color:#888; margin-bottom:0px;">
                            <?php 
                        $responsibilities=array();
                        if($ex2->responsibilities!='') $responsibilities=explode(';', $ex2->responsibilities);
                        
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
        
    </div>
        <?php } ?>
        
        
        <?php if(isset($education) AND !empty($education)) { ?>
        <div style="position:absolute; left:0pt; width:200px; background:#ededed; padding:5px;">
            <div style="background-color: #D7D7D7; padding:15px; font-size:17px;">Ausbildung</div>
        </div>
        
    <div style="margin-left:230px; padding-top:5px; width:510px; <?php if(isset($preview_mrg_style)) echo $preview_mrg_style; ?>">
        
        <hr style="margin-top:0px; margin-bottom:15px; border:1px solid #ededed;">
        
        <table style="border-collapse: collapse;">
            <tbody>
                <?php
                    foreach($education as $edu) {
                ?>
                <tr>
                    <td style="width:160px; text-align:top; padding-top:5px; color:#717171;" valign="top"><?php if($edu->present=='1') echo 'seit '; if($edu->from_month<10) echo '0'; echo $edu->from_month.'/'.$edu->from_year; 
                        
                        if($edu->present=='0') { echo ' - '; if($edu->to_month<10 AND $edu->to_month!='') echo '0'; echo $edu->to_month.'/'.$edu->to_year; } ?></td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px;">
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
        
    </div>
        <?php } ?>
        
        <div style="position:absolute; left:0pt; width:200px; background:#ededed; padding:5px;">
            <div style="background-color: #D7D7D7; padding:15px; font-size:17px;">Kenntnisse und Interessen</div>
        </div>
        
    <div style="margin-left:230px; padding-top:5px; width:510px; <?php if(isset($preview_mrg_style)) echo $preview_mrg_style; ?>">
        
        <hr style="margin-top:0px; margin-bottom:15px; border:1px solid #ededed;">
        
        <table style="margin-bottom:20px;">
            <tbody>
                <tr>
                    <td style="width:160px; text-align:top; padding-top:5px; color:#717171;" valign="top">Fremdsprachen</td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px;">
                        <?php 
                        if(!empty($languages)) {
                            foreach($languages as $language) {
                                echo $language->language.' ('.$language->fluency.')<br>';
                            } } ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:160px; text-align:top; padding-top:5px; color:#717171;" valign="top">IT-Kenntnisse</td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px;">
                        <?php 
                        if(!empty($skills)) {
                            foreach($skills as $skill) {
                                echo $skill->skill.' ('.$skill->fluency.')<br>';
                            } } ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:160px; text-align:top; padding-top:5px; color:#717171;" valign="top">Hobbys</td>
                    <td style="width:310px; padding-top:5px; padding-bottom:5px;">
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
