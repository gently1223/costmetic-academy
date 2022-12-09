<style>
    @-webkit-keyframes passing-through {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30%, 70% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); }
  100% {
    opacity: 0;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px); } }
@-moz-keyframes passing-through {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30%, 70% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); }
  100% {
    opacity: 0;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px); } }
@keyframes passing-through {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30%, 70% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); }
  100% {
    opacity: 0;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px); } }
@-webkit-keyframes slide-in {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); } }
@-moz-keyframes slide-in {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); } }
@keyframes slide-in {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); } }
@-webkit-keyframes pulse {
  0% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); }
  10% {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1); }
  20% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); } }
@-moz-keyframes pulse {
  0% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); }
  10% {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1); }
  20% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); } }
@keyframes pulse {
  0% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); }
  10% {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1); }
  20% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); } }
.dropzone, .dropzone * {
  box-sizing: border-box; }

.dropzone {
  min-height: 150px;
  border: 2px solid rgba(0, 0, 0, 0.3);
  background: white;
  padding: 54px 54px; }
  .dropzone.dz-clickable {
    cursor: pointer; }
    .dropzone.dz-clickable * {
      cursor: default; }
    .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * {
      cursor: pointer; }
  .dropzone.dz-started .dz-message {
    display: none; }
  .dropzone.dz-drag-hover {
    border-style: solid; }
    .dropzone.dz-drag-hover .dz-message {
      opacity: 0.5; }
  .dropzone .dz-message {
    text-align: center;
    margin: 2em 0; }
  .dropzone .dz-preview {
    position: relative;
    display: inline-block;
    vertical-align: top;
    margin: 16px;
    min-height: 100px; }
    .dropzone .dz-preview:hover {
      z-index: 1000; }
      .dropzone .dz-preview:hover .dz-details {
        opacity: 1; }
    .dropzone .dz-preview.dz-file-preview .dz-image {
      border-radius: 20px;
      background: #999;
      background: linear-gradient(to bottom, #eee, #ddd); }
    .dropzone .dz-preview.dz-file-preview .dz-details {
      opacity: 1; }
    .dropzone .dz-preview.dz-image-preview {
      background: white; }
      .dropzone .dz-preview.dz-image-preview .dz-details {
        -webkit-transition: opacity 0.2s linear;
        -moz-transition: opacity 0.2s linear;
        -ms-transition: opacity 0.2s linear;
        -o-transition: opacity 0.2s linear;
        transition: opacity 0.2s linear; }
    .dropzone .dz-preview .dz-remove {
      font-size: 14px;
      text-align: center;
      display: block;
      cursor: pointer;
      border: none; }
      .dropzone .dz-preview .dz-remove:hover {
        text-decoration: underline; }
    .dropzone .dz-preview:hover .dz-details {
      opacity: 1; }
    .dropzone .dz-preview .dz-details {
      z-index: 20;
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
      font-size: 13px;
      min-width: 100%;
      max-width: 100%;
      padding: 2em 1em;
      text-align: center;
      color: rgba(0, 0, 0, 0.9);
      line-height: 150%; }
      .dropzone .dz-preview .dz-details .dz-size {
        margin-bottom: 1em;
        font-size: 16px; }
      .dropzone .dz-preview .dz-details .dz-filename {
        white-space: nowrap; }
        .dropzone .dz-preview .dz-details .dz-filename:hover span {
          border: 1px solid rgba(200, 200, 200, 0.8);
          background-color: rgba(255, 255, 255, 0.8); }
        .dropzone .dz-preview .dz-details .dz-filename:not(:hover) {
          overflow: hidden;
          text-overflow: ellipsis; }
          .dropzone .dz-preview .dz-details .dz-filename:not(:hover) span {
            border: 1px solid transparent; }
      .dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {
        background-color: rgba(255, 255, 255, 0.4);
        padding: 0 0.4em;
        border-radius: 3px; }
    .dropzone .dz-preview:hover .dz-image img {
      -webkit-transform: scale(1.05, 1.05);
      -moz-transform: scale(1.05, 1.05);
      -ms-transform: scale(1.05, 1.05);
      -o-transform: scale(1.05, 1.05);
      transform: scale(1.05, 1.05);
      -webkit-filter: blur(8px);
      filter: blur(8px); }
    .dropzone .dz-preview .dz-image {
      border-radius: 20px;
      overflow: hidden;
      width: 120px;
      height: 120px;
      position: relative;
      display: block;
      z-index: 10; }
      .dropzone .dz-preview .dz-image img {
        display: block; }
    .dropzone .dz-preview.dz-success .dz-success-mark {
      -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1); }
    .dropzone .dz-preview.dz-error .dz-error-mark {
      opacity: 1;
      -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1); }
    .dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark {
      pointer-events: none;
      opacity: 0;
      z-index: 500;
      position: absolute;
      display: block;
      top: 50%;
      left: 50%;
      margin-left: -27px;
      margin-top: -27px; }
      .dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg {
        display: block;
        width: 54px;
        height: 54px; }
    .dropzone .dz-preview.dz-processing .dz-progress {
      opacity: 1;
      -webkit-transition: all 0.2s linear;
      -moz-transition: all 0.2s linear;
      -ms-transition: all 0.2s linear;
      -o-transition: all 0.2s linear;
      transition: all 0.2s linear; }
    .dropzone .dz-preview.dz-complete .dz-progress {
      opacity: 0;
      -webkit-transition: opacity 0.4s ease-in;
      -moz-transition: opacity 0.4s ease-in;
      -ms-transition: opacity 0.4s ease-in;
      -o-transition: opacity 0.4s ease-in;
      transition: opacity 0.4s ease-in; }
    .dropzone .dz-preview:not(.dz-processing) .dz-progress {
      -webkit-animation: pulse 6s ease infinite;
      -moz-animation: pulse 6s ease infinite;
      -ms-animation: pulse 6s ease infinite;
      -o-animation: pulse 6s ease infinite;
      animation: pulse 6s ease infinite; }
    .dropzone .dz-preview .dz-progress {
      opacity: 1;
      z-index: 1000;
      pointer-events: none;
      position: absolute;
      height: 16px;
      left: 50%;
      top: 50%;
      margin-top: -8px;
      width: 80px;
      margin-left: -40px;
      background: rgba(255, 255, 255, 0.9);
      -webkit-transform: scale(1);
      border-radius: 8px;
      overflow: hidden; }
      .dropzone .dz-preview .dz-progress .dz-upload {
        background: #333;
        background: linear-gradient(to bottom, #666, #444);
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 0;
        -webkit-transition: width 300ms ease-in-out;
        -moz-transition: width 300ms ease-in-out;
        -ms-transition: width 300ms ease-in-out;
        -o-transition: width 300ms ease-in-out;
        transition: width 300ms ease-in-out; }
    .dropzone .dz-preview.dz-error .dz-error-message {
      display: block; }
    .dropzone .dz-preview.dz-error:hover .dz-error-message {
      opacity: 1;
      pointer-events: auto; }
    .dropzone .dz-preview .dz-error-message {
      pointer-events: none;
      z-index: 1000;
      position: absolute;
      display: block;
      display: none;
      opacity: 0;
      -webkit-transition: opacity 0.3s ease;
      -moz-transition: opacity 0.3s ease;
      -ms-transition: opacity 0.3s ease;
      -o-transition: opacity 0.3s ease;
      transition: opacity 0.3s ease;
      border-radius: 8px;
      font-size: 13px;
      top: 130px;
      left: -10px;
      width: 140px;
      background: #be2626;
      background: linear-gradient(to bottom, #be2626, #a92222);
      padding: 0.5em 1.2em;
      color: white; }
      .dropzone .dz-preview .dz-error-message:after {
        content: '';
        position: absolute;
        top: -6px;
        left: 64px;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #be2626; }
</style>

<div class="form-row" id="contacts-form" style="display:none;">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail1177" class=""><?php echo trans('forms.referral_source'); ?></label>
                                                        <select name="referral_source" class="form-control" id="referral_source">
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <?php 
                                                            if(!empty($referral_sources)) {
                                                                foreach($referral_sources as $source) {
                                                            ?>
                                                            <option value="<?php echo $source->id; ?>" <?php if(isset($contact->referral_source) AND $contact->referral_source==$source->id) echo 'selected'; ?>><?php echo $source->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="team_email_box">
                                                    <div class="position-relative form-group" style="display:none;">
                                                        <label for="team_email" class=""><?php echo trans('forms.team_email'); ?> </label>
                                                        <input name="team_email"  id="team_email_field" type="email" class="form-control"  value="<?php if(isset($contact->team_email)) echo $contact->team_email; ?>"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="street_name" class=""><?php echo trans('forms.street_name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="street_name" id="street_name_field" type="text" class="form-control required" required value="<?php if(isset($contact->street_name)) echo $contact->street_name; ?>"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="door_no" class=""><?php echo trans('forms.door_no'); ?> <font style="color:red;">*</font></label>
                                                        <input name="door_no" id="door_no_field" type="text" class="form-control required" required value="<?php if(isset($contact->door_no)) echo $contact->door_no; ?>"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="additional_address" class=""><?php echo trans('forms.additional_address'); ?></label>
                                                        <input name="address" id="additional_address_field" type="text" class="form-control" value="<?php if(isset($contact->additional_address)) echo $contact->additional_address; ?>"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="zip_code" class=""><?php echo trans('forms.zip_code'); ?> <font style="color:red;">*</font></label>
                                                        <input name="zip_code" id="zip_code_field" type="text" class="form-control required" required value="<?php if(isset($contact->zip_code)) echo $contact->zip_code; ?>"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="city" class=""><?php echo trans('forms.city'); ?> <font style="color:red;">*</font></label>
                                                        <input name="city" id="city_field" type="text" class="form-control required" required value="<?php if(isset($contact->city)) echo $contact->city; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="dob">
                                                    <div class="position-relative form-group">
                                                        <label for="dob_field" class=""><?php echo trans('forms.dob'); ?></label>
                                                        <input name="dob" id="dob_field" type="text" class="form-control today_calendar" value="<?php if(isset($contact->dob)) echo $contact->dob; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="birth_location">
                                                    <div class="position-relative form-group">
                                                        <label for="birth_location_field" class=""><?php echo trans('forms.birth_location'); ?></label>
                                                        <input name="birth_location" id="birth_location_field" type="text" class="form-control" value="<?php if(isset($contact->birth_location)) echo $contact->birth_location; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="mobile">
                                                    <div class="position-relative form-group">
                                                        <label for="mobile_field" class=""><?php echo trans('forms.phone_no'); ?> <font style="color:red;">*</font></label>
                                                        <input name="phone_no" id="mobile_field" type="text" class="form-control required" required value="<?php if(isset($contact->phone_no)) echo $contact->phone_no; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="price_ue">
                                                    <div class="position-relative form-group">
                                                        <label for="price_ue_field" class=""><?php echo trans('forms.ue'); ?> <font style="color:red;">*</font></label>
                                                        <input name="price_ue" id="price_ue_field" type="number" step="any" min="0" class="form-control required" required value="<?php if(isset($contact->price_ue)) echo $contact->price_ue; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="marital_status">
                                                    <div class="position-relative form-group">
                                                        <label for="marital_status_field" class=""><?php echo trans('forms.marital_status'); ?></label>
                                                        <select name="marital_status" id="marital_status_field" type="text" class="form-control">
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <option value="Single"  <?php if(isset($contact->marital_status) AND $contact->marital_status=='Single') echo 'selected'; ?>><?php echo trans('forms.single'); ?></option>
                                                            <option value="Married"  <?php if(isset($contact->marital_status) AND $contact->marital_status=='Married') echo 'selected'; ?>><?php echo trans('forms.married'); ?></option>
                                                            <option value="Free"  <?php if(isset($contact->marital_status) AND $contact->marital_status=='Free') echo 'selected'; ?>><?php echo trans('forms.free'); ?></option>
                                                            <option value="Widow"  <?php if(isset($contact->marital_status) AND $contact->marital_status=='Widow') echo 'selected'; ?>><?php echo trans('forms.widow'); ?></option>
                                                            <option value="Unknown"  <?php if(isset($contact->marital_status) AND $contact->marital_status=='Unknown') echo 'selected'; ?>><?php echo trans('forms.unknown'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="customer_no" style="display:none;">
                                                    <div class="position-relative form-group">
                                                        <label for="customer_no_field" class=""><?php echo trans('forms.customer_no'); ?></label>
                                                        <input name="customer_no" id="customer_no_field" type="text" class="form-control" value="<?php if(isset($contact->customer_no)) echo $contact->customer_no; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="org_zeichen" style="display:none;">
                                                    <div class="position-relative form-group">
                                                        <label for="org_zeichen_field" class=""><?php echo trans('forms.org_zeichen'); ?></label>
                                                        <input name="org_zeichen" id="org_zeichen_field" type="text" class="form-control" value="<?php if(isset($contact->org_zeichen)) echo $contact->org_zeichen; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="child_care">
                                                    <div class="position-relative form-group">
                                                        <label for="child_care_field" class=""><?php echo trans('forms.child_care'); ?></label>
                                                        <input name="child_care" id="child_care_field" type="text" class="form-control" value="<?php if(isset($contact->child_care)) echo $contact->child_care; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="funding_source">
                                                    <div class="position-relative form-group">
                                                        <label for="funding_source_field" class=""><?php echo trans('forms.funding_source'); ?> <font style="color:red;">*</font></label>
                                                        <select name="funding_source" class="form-control required" required onchange="get_address(this)" id="funding_source_field">
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <?php 
                                                            if(!empty($funding_sources)) {
                                                                foreach($funding_sources as $source) {
                                                            ?>
                                                            <option value="<?php echo $source->id; ?>" <?php if(isset($contact->funding_source) AND $contact->funding_source==$source->id) echo 'selected'; ?> data-address="<?php echo $source->address; ?>"><?php echo $source->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="contact_person">
                                                    <div class="position-relative form-group">
                                                        <label for="contact_person_field" class=""><?php echo trans('forms.contact_person'); ?> <font style="color:red;">*</font></label>
                                                        <select name="contact_person[]" class="form-control required select-multiple" multiple='' required id="contact_person_field" style="width:100%;">
                                                            <?php 
                                                            if(!empty($experts)) {
                                                                foreach($experts as $expert) {
                                                            ?>
                                                            <option value="<?php echo $expert->id; ?>" <?php if(isset($contact->contact_person) AND $contact->contact_person==$expert->id) echo 'selected'; ?>><?php echo $expert->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="funding_source_address">
                                                    <div class="position-relative form-group">
                                                        <label for="funding_source_address_field" class=""><?php echo trans('forms.address_funding'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control funding_address required" name="address_funding" value="" required id="funding_source_address_field" readonly value="<?php if(isset($funding_source)) echo $funding_source['address']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="period">
                                                    <div class="position-relative form-group">
                                                        <label for="period_field" class=""><?php echo trans('forms.beginning_end'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control date_range required" name="period" required id="period_field" value="<?php if(isset($contact->beginning)) echo date_format(new DateTime($contact->beginning),'d-m-Y').' - '.date_format(new DateTime($contact->end),'d-m-Y'); ?>">
                                                    </div>
                                                </div>
    
                                                <div class="col-md-6" id="parents">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_field" class="" style="display:block;">&nbsp;</label>
                                                        <input type="checkbox" class="" name="parent" id="parent_field" <?php if(isset($contact->parent) AND $contact->parent=='1') echo 'checked'; ?> value="1" onchange="show_parent_box(this)"> <?php echo trans('forms.parent_guardian'); ?>
                                                    </div>
                                                </div>
    
                                                <div class="col-12 mb-3" id="parent_box" style="padding:10px; border:1px solid #E2E2E0; border-radius:10px; <?php if(isset($contact->parent) AND $contact->parent=='1') {} else echo 'display:none'; ?>">
                                                    <h6 style="font-weight:bold;"><?php echo trans('forms.parent_guardian'); ?>:</h6>
                                                    <div class="row">
                                                        
                                                    <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_first_name_field" class=""><?php echo trans('forms.first_name'); ?></label>
                                                        <input name="parent_first_name" id="parent_first_name_field" type="text" class="form-control" value="<?php if(isset($contact->parent_first_name)) echo $contact->parent_first_name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_last_name_field" class=""><?php echo trans('forms.last_name'); ?></label>
                                                        <input name="parent_last_name" id="parent_last_name_field" type="text" class="form-control" value="<?php if(isset($contact->parent_last_name)) echo $contact->parent_last_name; ?>">
                                                    </div>
                                                </div>
                                                    <div class="col-md-6">
                                                    <div class="position-relative form-group" style="position:relative;">
                                                        <label for="parent_email_field" class=""><?php echo trans('forms.email'); ?></label>
                                                        <input name="parent_email" id="parent_email_field" type="email" class="form-control" value="<?php if(isset($contact->parent_email)) echo $contact->parent_email; ?>">
                                                    </div>
                                                </div>
                                                        <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_street_name_field" class=""><?php echo trans('forms.street_name'); ?> </label>
                                                        <input name="parent_street_name" id="parent_street_name_field" type="text" class="form-control" value="<?php if(isset($contact->parent_street_name)) echo $contact->parent_street_name; ?>"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_door_id" class=""><?php echo trans('forms.door_no'); ?></label>
                                                        <input name="parent_door_no" id="parent_door_id" type="text" class="form-control" value="<?php if(isset($contact->parent_door_no)) echo $contact->parent_door_no; ?>"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_address_field" class=""><?php echo trans('forms.additional_address'); ?></label>
                                                        <input name="parent_address" id="parent_address_field" type="text" class="form-control" value="<?php if(isset($contact->parent_additional_address)) echo $contact->parent_additional_address; ?>"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_city_field" class=""><?php echo trans('forms.city'); ?></label>
                                                        <input name="parent_city" id="parent_city_field" type="text" class="form-control" value="<?php if(isset($contact->parent_city)) echo $contact->parent_city; ?>"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_zip_code_field" class=""><?php echo trans('forms.zip_code'); ?> </label>
                                                        <input name="parent_zip_code" id="parent_zip_code_field" type="text" class="form-control" value="<?php if(isset($contact->parent_zip_code)) echo $contact->parent_zip_code; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="dob">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_dob_field" class=""><?php echo trans('forms.dob'); ?></label>
                                                        <input name="parent_dob" id="parent_dob_field" type="text" class="form-control calendar" value="<?php if(isset($contact->praent_dob)) echo $contact->parent_dob; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="mobile">
                                                    <div class="position-relative form-group">
                                                        <label for="parent_phone_no_field" class=""><?php echo trans('forms.phone_no'); ?></label>
                                                        <input name="parent_phone_no" id="parent_phone_no_field" type="text" class="form-control" value="<?php if(isset($contact->parent_phone_no)) echo $contact->parent_phone_no; ?>"></div>
                                                </div>
                                                    
                                                </div>
                                                    </div>
    
                                                <div class="col-md-3" id="start_working">
                                                    <div class="position-relative form-group">
                                                        <label for="start_working_field" class=""><?php echo trans('forms.start_working_from'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control today_calendar required" name="start_working" value="" required id="start_working_field" value="<?php if(isset($contact->start_working)) echo $contact->start_working; ?>">
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3" id="unlimited_employment">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="" style="display:block;"><?php echo trans('forms.unlimited_employment'); ?> <font style="color:red;">*</font></label>
                                                        <input type="radio" class="" name="unlimited_employment" value="1" <?php if(isset($contact->unlimited_employment) AND $contact->unlimited_employment=='1') echo 'checked'; ?>> <?php echo trans('forms.yes'); ?>
                                                        <input type="radio" class="" name="unlimited_employment" value="1" <?php if((isset($contact->unlimited_employment) AND $contact->unlimited_employment=='0') OR !isset($contact->unlimited_employment) OR $contact->unlimited_employment=='') echo 'checked'; ?>> <?php echo trans('forms.no'); ?>
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3" id="employment_end">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.employment_end_date'); ?></label>
                                                        <input type="text" class="form-control today_calendar" name="employment_end" id="employment_end_field" value="<?php if(isset($contact->employment_end)) echo $contact->employment_end; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="bank_name">
                                                    <div class="position-relative form-group">
                                                        <label for="bank_name_field" class=""><?php echo trans('forms.bank_name'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control required" name="bank_name" required id="bank_name_field" value="<?php if(isset($contact->bank_name)) echo $contact->bank_name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="iban">
                                                    <div class="position-relative form-group">
                                                        <label for="iban_field" class=""><?php echo trans('forms.iban'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control required" name="iban" required id="iban_field" value="<?php if(isset($contact->iban)) echo $contact->iban; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="bic">
                                                    <div class="position-relative form-group">
                                                        <label for="bic_field" class=""><?php echo trans('forms.bic'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control required" name="bic" required id="bic_field" value="<?php if(isset($contact->bic)) echo $contact->bic; ?>">
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3" id="yearly_salary">
                                                    <div class="position-relative form-group">
                                                        <label for="yearly_salary_field" class=""><?php echo trans('forms.yearly_salary'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control requred" required name="yearly_salary" id="yearly_salary_field" value="<?php if(isset($contact->yearly_salary)) echo $contact->yearly_salary; ?>">
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3" id="working_hours">
                                                    <div class="position-relative form-group">
                                                        <label for="working_hours_field" class=""><?php echo trans('forms.working_hours_week'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control requred" required name="working_hours" id="working_hours_field" value="<?php if(isset($contact->working_hours)) echo $contact->working_hours; ?>">
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3" id="probation_period">
                                                    <div class="position-relative form-group">
                                                        <label for="probation_period_field" class=""><?php echo trans('forms.probation_period'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control requred" required name="probation_period" id="probation_period_field" value="<?php if(isset($contact->probation_period)) echo $contact->probation_period; ?>">
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3" id="position">
                                                    <div class="position-relative form-group">
                                                        <label for="position_field" class=""><?php echo trans('forms.position'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control requred" required name="employment_position" id="position_field" value="<?php if(isset($contact->position)) echo $contact->position; ?>">
                                                    </div>
                                                </div>
    
    
<!-- Vourcher -->

                                                <div class="col-md-12" id="voucher">
                                                    <input type="hidden" name="vouchers" id="files" value="<?php if(isset($contact->vouchers)) echo $contact->vouchers; ?>">
                                                    <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo trans('forms.voucher'); ?></label>
                      <div class="dropzone" id="dropzone-box" style="min-height:100px; cursor: pointer; border: 2px dashed #0087F7;
    border-radius: 5px;
    background: white;     padding: 44px 44px; box-sizing: border-box;     font-size: 100%;
    font: inherit;
    vertical-align: baseline; margin-bottom:10px;">
                  <div class="dz-message needsclick" style="font-weight: 400; text-align: center;
    margin: 2em 0; font-size:20px;">
    <?php echo trans('forms.drop_files_here'); ?><br>
  </div>
              </div>
                </div>
                                                    <!--<div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.voucher'); //if(!isset($not_required)) { ?> <font style="color:red;">*</font><?php //} ?></label>
                                                        <div id="file_name"></div>
                                                        <input type="file" class="form-control <?php //if(!isset($not_required)) { ?>required<?php //} ?> file" name="voucher" style="display:none;" id="voucher_field">
                                                        <div class="browse" style="border:1px solid #d2d6de; padding:5px; cursor:pointer;"><i class="fa fa-upload"></i> <?php echo trans('forms.choose_file'); ?></div>
                                                    </div>-->
                                                    
                                                </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="<?php echo url('assets/plugins/dropzone/dropzone.js'); ?>"></script>
<script>
    var token = "<?php echo csrf_token() ?>";
    $("div#dropzone-box").dropzone({
        url: "<?php echo url('admin/upload-files'); ?>",
        params: 
        {
            _token: token
        },
        success: function( file, response )
        {
            //alert(response.filename);
            var old_files=$("#files").val();
            if(old_files!='')
            var files=old_files.split(',');
            else var files=[];
            files.push(response.filename);
            var new_files=files.join(',');
            $("#files").val(new_files);
        }
    });
    
    function check_email(th, id)
    {
        var email=$(th).val();
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('id', id);
        formData.append('email', email);
        
        $.ajax({
                url: "<?php echo url('admin/check-email') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    //$("#submit_btn").attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    //$("#submit_btn").attr('disabled', false);
                    // here we will handle errors and validation messages
                        $("#email-error").show();
                        $("#submit_btn_c").attr('disabled', true);
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#email-error").hide();
                        $("#submit_btn_c").attr('disabled', false);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
    
    function get_address(th)
    {
        var address=$('option:selected', th).attr('data-address');
        $(".funding_address").val(address);
        
        if($("#contact_type").val()=='Expert Advisor') $("#additional_address").val(address);
    }
</script>