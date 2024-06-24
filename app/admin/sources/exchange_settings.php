<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?>
<div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-cogs"></i> Exchange Settings</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <?php
                  $CEAction = protect($_POST['ce_btn']);
                  if(isset($CEAction) && $CEAction == "save") {
                    $curcnv_api = protect($_POST['curcnv_api']);
                    $cryptocnv_api = protect($_POST['cryptocnv_api']);
                    $au_rate_int = protect($_POST['au_rate_int']);
                    $referral_comission = protect($_POST['referral_comission']);
                    $referral_min_withdrawal = protect($_POST['referral_min_withdrawal']);
                    $show_operator_status = protect($_POST['show_operator_status']);
                    if($show_operator_status == "Yes") { $show_operator_status = 1; } else { $show_operator_status = 0; } 
                    $show_worktime = protect($_POST['show_worktime']);
                    if($show_worktime == "Yes") { $show_worktime = 1; } else { $show_worktime = 0; }
                    $worktime_start = protect($_POST['worktime_start']);
                    $worktime_end = protect($_POST['worktime_end']);
                    $worktime_gmt = protect($_POST['worktime_gmt']);
                    $expire_uncompleted_time = protect($_POST['expire_uncompleted_time']);

                    if(empty($curcnv_api) or empty($cryptocnv_api) or empty($expire_uncompleted_time) or empty($au_rate_int) or empty($referral_comission) or empty($referral_min_withdrawal)) {
                        echo error("All fields are required."); 
                    } elseif(!is_numeric($au_rate_int)) {
                        echo error("Please enter auto refresh interval with numbers.");
                    } elseif(!is_numeric($referral_comission)) {
                        echo error("Please enter referral comission with numbers.");
                    } elseif(!is_numeric($referral_min_withdrawal)) {
                        echo error("Please enter minimal withdrawal amount with numbers.");
                    } elseif($show_worktime == "1" && empty($worktime_start)) {
                        echo error("Please enter a work time start.");  
                    }  elseif($show_worktime == "1" && empty($worktime_end)) {
                        echo error("Please enter a work time end.");  
                    }  elseif($show_worktime == "1" && empty($worktime_gmt)) {
                        echo error("Please enter a work time gmt zone.");  
                    } elseif(!is_numeric($expire_uncompleted_time)) {
                        echo error("Please enter a minutes with numbers.");
                    } else {
                        $expire_uncompleted_time = $expire_uncompleted_time * 60;
                        $update = $db->query("UPDATE ce_settings SET cryptocnv_api='$cryptocnv_api',expire_uncompleted_time='$expire_uncompleted_time',show_operator_status='$show_operator_status',show_worktime='$show_worktime',worktime_start='$worktime_start',worktime_end='$worktime_end',worktime_gmt='$worktime_gmt',curcnv_api='$curcnv_api',au_rate_int='$au_rate_int',referral_comission='$referral_comission',referral_min_withdrawal='$referral_min_withdrawal'");
                        $settingsQuery = $db->query("SELECT * FROM ce_settings ORDER BY id DESC LIMIT 1");
                        $settings = $settingsQuery->fetch_assoc();
                        echo success("Your changes was saved successfully.");
                    }
                  }
                  ?>
                  <form action="" method="POST">
                    <div class="form-group">
                        <label>Currency Converter API Key</label>
                        <input type="text" class="form-control" name="curcnv_api" value="<?php echo $settings['curcnv_api']; ?>">
                        <small>To use automatic converter from USD to EUR and etc. You must enter here your API Key provided by <a href="https://currencyconverterapi.com">currencyconverterapi.com</a>. How to get API Key: Open <a href="https://currencyconverterapi.com">https://currencyconverterapi.com</a> and click on "Pricing", choose plan "PREMIUM" and follow steps.</small>
                    </div>
                    <div class="form-group">
                        <label>CryptoCompare API Key</label>
                        <input type="text" class="form-control" name="cryptocnv_api" value="<?php echo $settings['cryptocnv_api']; ?>">
                        <small>To use automatic converter from BTC to USD, BTC to LTC and etc. You must enter here your API Key provided by <a href="https://min-api.cryptocompare.com/pricing">cryptocompare.com</a>. How to get API Key: Open <a href="https://min-api.cryptocompare.com/pricing">https://min-api.cryptocompare.com/pricing</a> and click on "Get your free key", if you have a more than 100000 calls/month use premium subscription.</small>
                    </div>
                    <div class="form-group">
                        <label>Auto rate refresh interval</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="au_rate_int" value="<?php echo $settings['au_rate_int']; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">minute(s)</span>
                            </div>
                        </div>
                        <small>Entered number will be converted to minutes automatically. For example use 5. This is to update the exchange rate when the customer is on the exchange page but has not yet placed an exchange order.</small>
                    </div>
                    <div class="form-group">
                        <label>Referral comission</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="referral_comission" value="<?php echo $settings['referral_comission']; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Referral min. withdrawal amount</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="referral_min_withdrawal" value="<?php echo $settings['referral_min_withdrawal']; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">USD</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Show Operator Status</label>
                        <select class="form-control" name="show_operator_status" id="show_operator_status">
                            <option value="Yes" <?php if($settings['show_operator_status'] == "1") { echo 'selected'; } ?>>Yes</option>
                            <option value="No" <?php if($settings['show_operator_status'] == "0") { echo 'selected'; } ?>>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Show Work time</label>
                        <select class="form-control" name="show_worktime" id="show_worktime">
                            <option value="Yes" <?php if($settings['show_worktime'] == "1") { echo 'selected'; } ?>>Yes</option>
                            <option value="No" <?php if($settings['show_worktime'] == "0") { echo 'selected'; } ?>>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Work time start</label>
                        <input type="text" class="form-control" name="worktime_start" value="<?php echo $settings['worktime_start']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Work time end</label>
                        <input type="text" class="form-control" name="worktime_end" value="<?php echo $settings['worktime_end']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Work time GMT Zone</label>
                        <input type="text" class="form-control" name="worktime_gmt" value="<?php echo $settings['worktime_gmt']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Expire orders after</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="expire_uncompleted_time" value="<?php echo $settings['expire_uncompleted_time']/60; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">minutes</span>
                            </div>
                        </div>
                        <small>This will change the "Expired" status after XX minutes have expired and the order has not been paid.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save changes</button>
                </form>
                </div>
              </div>
            </div>
        </div>