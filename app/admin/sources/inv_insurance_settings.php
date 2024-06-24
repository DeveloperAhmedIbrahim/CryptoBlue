
<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?><div class="row">
<div class="col-md-12 col-lg-12">
        <h4 class="card-title"><i class="fa fa-shield"></i> Insurance Settings</h4>
        <h5>With this plugin you will enable your customers to protect their investments by charging them extra for insurance that will ensure that for a certain period of time their investment is protected from changes in the daily rate of return.</h5>
        <br><br>
    </div>
    <div class="col-lg-12">
                <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Installation guide:<br/>
                        To update automatically insurance expiration time you must add a CRON job which to be run every 1 hour.<br/>
                        Command line: <b>/usr/bin/php -q /home/your username/public_html/app/cron/update_insurances.php</b> or <b>curl "<?php echo $settings['url']; ?>app/cron/update_insurances.php"</b>
                    </div>
                    </div>
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <br>
          <?php
          $CEAction = protect($_POST['ce_btn']);
          if(isset($CEAction) && $CEAction == "save") {
            if(isset($_POST['invest_insurance_plugin'])) { $invest_insurance_plugin = 1; } else { $invest_insurance_plugin = '0'; }
            $invest_insurance_fee = protect($_POST['invest_insurance_fee']);
            $invest_insurance_duration = protect($_POST['invest_insurance_duration']);
            if($invest_insurance_plugin == "1" && empty($invest_insurance_fee)) {
                echo error("Please enter a insurance tax fee.");
            } elseif($invest_insurance_plugin == "1" && !is_numeric($invest_insurance_fee)) {
                echo error("Please enter a fee with numbers.");
            } elseif($invest_insurance_plugin == "1" && empty($invest_insurance_duration)) {
                echo error("Please enter a insurance duration.");
            } elseif($invest_insurance_plugin == "1" && !is_numeric($invest_insurance_duration)) {
                echo error("Please enter a duration with numbers.");
            } else {
                $update = $db->query("UPDATE ce_settings SET invest_insurance_plugin='$invest_insurance_plugin',invest_insurance_fee='$invest_insurance_fee',invest_insurance_duration='$invest_insurance_duration'");
                $settingsQuery = $db->query("SELECT * FROM ce_settings ORDER BY id DESC LIMIT 1");
                $settings = $settingsQuery->fetch_assoc();
                echo success("Your changes was saved successfully.");
            }
          }
          ?>
          <form action="" method="POST">
            <div class="form-check">
                <div class="checkbox">
                    <label for="checkbox1" class="form-check-label ">
                        <input type="checkbox" id="checkbox1" name="invest_insurance_plugin" <?php if($settings['invest_insurance_plugin'] == "1") { echo 'checked'; } ?> value="1" class="form-check-input"> Enable Insurances for Active Investments
                    </label>
                </div>
            </div>
            <br>
            <div class="form-group">
                            <label>Insurance Tax Fee</label>
                            <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="invest_insurance_fee" value="<?php echo $settings['invest_insurance_fee']; ?>" placeholder="0.00" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            <small>The cost of insurance will be calculated on total amount of investment. For example if user have invested 0.5 BTC and your insurance tax fee is 1.5%, the insurance tax for investment will be 0.0075 BTC for duration below.</small>
                        </div>
                        <div class="form-group">
                            <label>Insurance Duration</label>
                            <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="invest_insurance_duration" value="<?php echo $settings['invest_insurance_duration']; ?>" placeholder="1" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">days</span>
                                    </div>
                                </div>
                            <small>How much time will be valid the insurance for investment which have insurance.</small>
                        </div>
            <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save changes</button>
        </form>
        </div>
      </div>
    </div>
</div>