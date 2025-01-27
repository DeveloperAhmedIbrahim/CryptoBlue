<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);
if($b == "add_merchant") {
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-plus"></i> Add Merchant</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "new") {
                        $name = protect($_POST['name']);
                        $currency = protect($_POST['currency']);
                        $min_amount = protect($_POST['min_amount']);
                        $max_amount = protect($_POST['max_amount']);
                        $reserve = protect($_POST['reserve']);
                        $g_field_1 = protect($_POST['g_field_1']);
                        $g_field_2 = protect($_POST['g_field_2']);
                        $g_field_3 = protect($_POST['g_field_3']);
                        $g_field_4 = protect($_POST['g_field_4']);
                        $g_field_5 = protect($_POST['g_field_5']);
                        $g_field_6 = protect($_POST['g_field_6']);
                        $g_field_7 = protect($_POST['g_field_7']);
                        $g_field_8 = protect($_POST['g_field_8']);
                        $g_field_9 = protect($_POST['g_field_9']);
						$g_field_10 = protect($_POST['g_field_10']);
						$merchant_source = '';
                        if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
                        if(isset($_POST['require_login'])) { $require_login = '1'; } else { $require_login = '0'; }
                        if(isset($_POST['require_email_verify'])) { $require_email_verify = '1'; } else { $require_email_verify = '0'; }
                        if(isset($_POST['require_document_verify'])) { $require_document_verify = '1'; } else { $require_document_verify = '0'; } 
                        $check = $db->query("SELECT * FROM ce_gateways WHERE name='$name' and currency='$currency'");
                        if(empty($name) or empty($currency) or empty($min_amount) or empty($max_amount) or empty($reserve)) {
                            echo error("Required fields: gateway, currency, min. amount, max. amount and reserve.");
                        } elseif($check->num_rows>0) {
                            echo error("Gateway <b>$name $currency</b> was exists.");
                        } elseif(!is_numeric($min_amount)) { 
                            echo error("Please enter min. amount with numbers.");
                        } elseif(!is_numeric($max_amount)) {
                            echo error("Please enter max. amount with numbers.");
                        } elseif(!is_numeric($reserve)) {
                            echo error("Please enter reserve with numbers.");
                        } else {
							if($name == "Stripe") {
								$merchant_source = 'stripe';
							} elseif($name == "2checkout") {
								$merchant_source = '2checkout';
							} else {
								$merchant_source = '';
							}
                            $insert = $db->query("INSERT ce_gateways (name,currency,min_amount,max_amount,reserve,include_fee,extra_fee,fee,allow_send,require_login,require_email_verify,require_mobile_verify,require_document_verify,allow_attachments,max_attachments,require_attachments,g_field_1,g_field_2,g_field_3,g_field_4,g_field_5,g_field_6,g_field_7,g_field_8,g_field_9,g_field_10,manual_payment,external_gateway,external_icon,is_crypto,merchant_source) VALUES ('$name','$currency','$min_amount','$max_amount','$reserve','0','0','0','$allow_send','$require_login','$require_email_verify','0','$require_document_verify','0','0','0','$g_field_1','$g_field_2','$g_field_3','$g_field_4','$g_field_5','$g_field_6','$g_field_7','$g_field_8','$g_field_9','$g_field_10','0','0','','0','$merchant_source')");
                            if($db->error) {
                                echo error($db->error);
                            } else {
                            echo success("Gateway <b>$name $currency</b> was added successfully.");
                            $query = $db->query("SELECT * FROM ce_gateways WHERE name='$name' and currency='$currency'");
                            $row = $query->fetch_assoc();
                            $listquery = $db->query("SELECT * FROM ce_gateways ORDER BY id");
								if($listquery->num_rows>0) {
									$i=1;
									$list = '';
									while($ls = $listquery->fetch_assoc()) {
											if($i == 1) { 
												$list = $ls["id"];
											} else {
												$list .= ','.$ls["id"];
											}
											$i++;
									}
                                } 
                                $insert = $db->query("INSERT ce_gateways_directions (gateway_id,directions) VALUES ('$row[id]','$list')");
                            }
								
                        }
                     }
                     ?>

                     <form action="" method="POST">
                        <div class="form-group">
                            <label>Gateway</label>
                            <select class="form-control" name="name"  onchange="CEA_LoadFields(this.value);">
									<option value=""></option>
									<option value="PayPal">PayPal</option>
									<option value="Stripe">Stripe VISA/MasterCard</option>
									<!--<option value="2checkout">2checkout VISA/MasterCard</option>-->
									<option value="Paytm">Paytm</option>
									<option value="MTN">MTN</option>
									<option value="Paysera">Paysera</option>
									<option value="Yandex Money">Yandex Money</option>
									<option value="AdvCash">AdvCash</option>
									<option value="Entromoney">Entromoney</option>
									<option value="Mollie">Mollie</option>
									<option value="Payeer">Payeer</option>
									<option value="Payza">Payza</option>
									<option value="Perfect Money">Perfect Money</option>
									<option value="Skrill">Skrill</option>
									<option value="SolidTrust Pay">SolidTrust Pay</option>
									<option value="WebMoney">WebMoney</option>
                                </select>
                        </div> 
                        <div class="form-group">
								<label>Currency</label>
											<select class="form-control" name="currency">
												<option value=""></option>
														<?php 
														$currencies = getFiatCurrencies();
														foreach($currencies as $curk => $curv) {
															echo '<option value="'.$curk.'">'.$curv.'</option>';
														}
														?>
												</select>
							</div>
							<div class="form-group">
								<label>Minimal amount for exchange</label>
								<input type="text" class="form-control" name="min_amount">
							</div>
							<div class="form-group">
								<label>Maximum amount for exchange</label>
								<input type="text" class="form-control" name="max_amount">
							</div>
							<div class="form-group">
								<label>Reserve</label>
								<input type="text" class="form-control" name="reserve">
                            </div>
                            <div id="account_fields">
								
							</div>
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="allow_send" value="yes"> Allow customers to send money through this gateway
								</label>
							</div>
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="require_login" value="yes"> Require user to login before exchange
								</label>
							</div> 
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_email_verify" value="yes"> Require user to verify their email address before exchange
								</label>
							</div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_document_verify" value="yes"> Require user to verify their identify before exchange
								</label>
							</div>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="new"><i class="fa fa-plus"></i> Add</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "add_crypto") {
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-plus"></i> Add Crypto</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "new") {
                        $merchant_source = protect($_POST['merchant_source']);
						if($merchant_source == "coinpayments.net") {
							$name = protect($_POST['coin_name']);
							$currency = protect($_POST['coin_code']);
							$extensions = array('jpg','jpeg','png','svg'); 
								$fileextension = end(explode('.',$_FILES['uploadFile']['name'])); 
								$fileextension = strtolower($fileextension);
						} else {
							$name = protect($_POST['coin']);
							$currency = GetCryptoCurrency($name);
						}
                        $min_amount = protect($_POST['min_amount']);
                        $max_amount = protect($_POST['max_amount']);
                        $reserve = protect($_POST['reserve']);
                        $g_field_1 = protect($_POST['g_field_1']);
                        $g_field_2 = protect($_POST['g_field_2']);
                        $g_field_3 = protect($_POST['g_field_3']);
                        $g_field_4 = protect($_POST['g_field_4']);
                        $g_field_5 = protect($_POST['g_field_5']);
                        $g_field_6 = protect($_POST['g_field_6']);
                        $g_field_7 = protect($_POST['g_field_7']);
                        $g_field_8 = protect($_POST['g_field_8']);
                        $g_field_9 = protect($_POST['g_field_9']);
						$g_field_10 = protect($_POST['g_field_10']);
						if($merchant_source == "block.io") {
							if(isset($_POST['option_2'])) { $g_field_3 = 2; } else { $g_field_3 = 1; }
						}
                        if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
                        if(isset($_POST['require_login'])) { $require_login = '1'; } else { $require_login = '0'; }
                        if(isset($_POST['require_email_verify'])) { $require_email_verify = '1'; } else { $require_email_verify = '0'; }
                        if(isset($_POST['require_document_verify'])) { $require_document_verify = '1'; } else { $require_document_verify = '0'; } 
                        $check = $db->query("SELECT * FROM ce_gateways WHERE name='$name' and currency='$currency'");
                        if(empty($name) or empty($currency) or empty($min_amount) or empty($max_amount) or empty($reserve)) {
                            echo error("Required fields: gateway, currency, min. amount, max. amount and reserve.");
                        } elseif($check->num_rows>0) {
                            echo error("Gateway <b>$name $currency</b> was exists.");
                        } elseif(!is_numeric($min_amount)) { 
                            echo error("Please enter min. amount with numbers.");
                        } elseif(!is_numeric($max_amount)) {
                            echo error("Please enter max. amount with numbers.");
                        } elseif(!is_numeric($reserve)) {
							echo error("Please enter reserve with numbers.");
							}	elseif($merchant_source == "block.io" && empty($g_field_1)) { echo error("Please enter a Block.io API Key."); }
							elseif($merchant_source == "block.io" && empty($g_field_2)) { echo error("Please enter a Block.io Secret."); }
							elseif($merchant_source == "block.io" && $g_field_3 == "0" && empty($g_field_4)) { echo error("Please enter a Block.io Address.");  }
							elseif($merchant_source == "coinpayments.net" && empty($g_field_1)) { echo error("Please enter a Coinpayments.net Merchant ID"); }
							elseif($merchant_source == "coinpayments.net" && empty($g_field_2)) { echo error("Please enter a Coinpayments.net IPN Secret");
                        } elseif($merchant_source == "coinpayments.net" && empty($_FILES['uploadFile']["name"])) {
							echo error("Please select a gateway icon.");	
						} elseif($merchant_source == "coinpayments.net" && !in_array($fileextension,$extensions)) { 
                            echo error("Allowed icon format jpg, svg and png."); 
                        } else {
							$external_icon = '';
							if($merchant_source == "coinpayments.net" && !empty($_FILES['uploadFile'])) {
								$upload_dir = '../../';
								$iconpath = 'uploads/'.time().'_icon.'.$fileextension;
								$uploading = $upload_dir.$iconpath;
								@move_uploaded_file($_FILES['uploadFile']['tmp_name'],$uploading);
								$external_icon = $iconpath;
							}
                            $insert = $db->query("INSERT ce_gateways (name,currency,min_amount,max_amount,reserve,include_fee,extra_fee,fee,allow_send,require_login,require_email_verify,require_mobile_verify,require_document_verify,allow_attachments,max_attachments,require_attachments,g_field_1,g_field_2,g_field_3,g_field_4,g_field_5,g_field_6,g_field_7,g_field_8,g_field_9,g_field_10,manual_payment,external_gateway,external_icon,is_crypto,merchant_source) VALUES ('$name','$currency','$min_amount','$max_amount','$reserve','0','0','0','$allow_send','$require_login','$require_email_verify','0','$require_document_verify','0','0','0','$g_field_1','$g_field_2','$g_field_3','$g_field_4','$g_field_5','$g_field_6','$g_field_7','$g_field_8','$g_field_9','$g_field_10','0','0','$external_icon','1','$merchant_source')");
                            if($db->error) {
                                echo error($db->error);
                            } else {
                            echo success("Gateway <b>$name $currency</b> was added successfully.");
                            $query = $db->query("SELECT * FROM ce_gateways WHERE name='$name' and currency='$currency'");
                            $row = $query->fetch_assoc();
                            $listquery = $db->query("SELECT * FROM ce_gateways ORDER BY id");
								if($listquery->num_rows>0) {
									$i=1;
									$list = '';
									while($ls = $listquery->fetch_assoc()) {
											if($i == 1) { 
												$list = $ls["id"];
											} else {
												$list .= ','.$ls["id"];
											}
											$i++;
									}
                                } 
                                $insert = $db->query("INSERT ce_gateways_directions (gateway_id,directions) VALUES ('$row[id]','$list')");
                            }
								
                        }
                     }
                     ?>

                     <form action="" method="POST" enctype="multipart/form-data">
                     <div class="form-group">
								<label>Select merchant source</label>
								<select name="merchant_source" class="form-control" onchange="CEA_LoadCryptoFields(this.value);".>
									<option value=""></option>
									<option value="block.io">Block.io</option>
                                    <option value="coinpayments.net">Coinpayments.net</option>
                                    <option value="blockchain.com">Blockchain.com</option>
								</select>
							</div>
							<div id="merchant_fields">
							
							</div>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="new"><i class="fa fa-plus"></i> Add</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "add_manual") {
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-plus"></i> Add Manual Payment</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "new") {
                        $name = protect($_POST['name']);
                        $currency = protect($_POST['currency']);
                        $o_currency = protect($_POST['o_currency']);
                        $min_amount = protect($_POST['min_amount']);
                        $max_amount = protect($_POST['max_amount']);
                        $reserve = protect($_POST['reserve']);
                        $g_field_1 = protect($_POST['g_field_1']);
                        $g_field_2 = protect($_POST['g_field_2']);
                        $g_field_3 = protect($_POST['g_field_3']);
                        $g_field_4 = protect($_POST['g_field_4']);
                        $g_field_5 = protect($_POST['g_field_5']);
                        $g_field_6 = protect($_POST['g_field_6']);
                        $g_field_7 = protect($_POST['g_field_7']);
                        $g_field_8 = protect($_POST['g_field_8']);
                        $g_field_9 = protect($_POST['g_field_9']);
                        $g_field_10 = protect($_POST['g_field_10']);
                        $field_1 = protect($_POST['field_1']);
                        $field_2 = protect($_POST['field_2']);
                        $field_3 = protect($_POST['field_3']);
                        $field_4 = protect($_POST['field_4']);
                        $field_5 = protect($_POST['field_5']);
                        $field_6 = protect($_POST['field_6']);
						$field_7 = protect($_POST['field_7']);
                        $field_8 = protect($_POST['field_8']);
						$field_9 = protect($_POST['field_9']);
                        $field_10 = protect($_POST['field_10']);
                        $extensions = array('jpg','jpeg','png'); 
							$fileextension = end(explode('.',$_FILES['uploadFile']['name'])); 
							$fileextension = strtolower($fileextension); 
								if(!empty($o_currency)) {
									$currency = $o_currency;
								} else {
									$currency = $currency;
								}
						$max_attachments = protect($_POST['max_attachments']);
						if(isset($_POST['require_attachments'])) { $require_attachments = '1'; } else { $require_attachments = '0'; }
						if(isset($_POST['allow_attachments'])) { $allow_attachments = '1'; } else { $allow_attachments = '0'; }
						if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
						if(isset($_POST['is_crypto'])) { $is_crypto = '1'; } else { $is_crypto = '0'; }
                        if(isset($_POST['require_login'])) { $require_login = '1'; } else { $require_login = '0'; }
                        if(isset($_POST['require_email_verify'])) { $require_email_verify = '1'; } else { $require_email_verify = '0'; }
                        if(isset($_POST['require_document_verify'])) { $require_document_verify = '1'; } else { $require_document_verify = '0'; } 
                        $check = $db->query("SELECT * FROM ce_gateways WHERE name='$name' and currency='$currency'");
                        if(empty($name) or empty($currency) or empty($min_amount) or empty($max_amount) or empty($reserve)) {
                            echo error("Required fields: gateway, currency, min. amount, max. amount and reserve.");
                        } elseif($check->num_rows>0) {
                            echo error("Gateway <b>$name $currency</b> was exists.");
                        } elseif(!is_numeric($min_amount)) { 
                            echo error("Please enter min. amount with numbers.");
                        } elseif(!is_numeric($max_amount)) {
                            echo error("Please enter max. amount with numbers.");
                        } elseif(!is_numeric($reserve)) {
                            echo error("Please enter reserve with numbers.");
                        } elseif($allow_attachments == "1" && empty($max_attachments)) {
							echo error("Please enter maximum attachments in orders.");
						} elseif($allow_attachments == "1" && !is_numeric($max_attachments)) {
							echo error("Please enter maximum attachments with numbers.");
						} elseif(!in_array($fileextension,$extensions)) { 
                            echo error("Allowed icon format jpg and png."); 
                        } else {
                            if(!is_dir("../../uploads")) {
                                mkdir("../../uploads",0777);
                            }
                            $upload_dir = '../../';
                            $iconpath = 'uploads/'.time().'_icon.'.$fileextension;
                            $uploading = $upload_dir.$iconpath;
                            @move_uploaded_file($_FILES['uploadFile']['tmp_name'],$uploading);
                            $insert = $db->query("INSERT ce_gateways (name,currency,min_amount,max_amount,reserve,include_fee,extra_fee,fee,allow_send,require_login,require_email_verify,require_mobile_verify,require_document_verify,allow_attachments,max_attachments,require_attachments,g_field_1,g_field_2,g_field_3,g_field_4,g_field_5,g_field_6,g_field_7,g_field_8,g_field_9,g_field_10,manual_payment,external_gateway,external_icon,is_crypto,merchant_source) VALUES ('$name','$currency','$min_amount','$max_amount','$reserve','0','0','0','$allow_send','$require_login','$require_email_verify','0','$require_document_verify','$allow_attachments','$max_attachments','$require_attachments','$g_field_1','$g_field_2','$g_field_3','$g_field_4','$g_field_5','$g_field_6','$g_field_7','$g_field_8','$g_field_9','$g_field_10','1','1','$iconpath','$is_crypto','')");
                            if($db->error) {
                                echo error($db->error);
                            } else {
                            echo success("Gateway <b>$name $currency</b> was added successfully.");
                            $query = $db->query("SELECT * FROM ce_gateways WHERE name='$name' and currency='$currency'");
                            $row = $query->fetch_assoc();
								if(!empty($field_1)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_1','1')"); }
								if(!empty($field_2)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_2','2')"); }
								if(!empty($field_3)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_3','3')"); }
								if(!empty($field_4)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_4','4')"); }
								if(!empty($field_5)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_5','5')"); }
								if(!empty($field_6)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_6','6')"); }
								if(!empty($field_7)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_7','7')"); }
								if(!empty($field_8)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_8','8')"); }
								if(!empty($field_9)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_9','9')"); }
								if(!empty($field_10)) { $insert = $db->query("INSERT ce_gateways_fields (gateway_id,type,field_name,field_number) VALUES ('$row[id]','','$field_10','10')"); }
                            $listquery = $db->query("SELECT * FROM ce_gateways ORDER BY id");
								if($listquery->num_rows>0) {
									$i=1;
									$list = '';
									while($ls = $listquery->fetch_assoc()) {
											if($i == 1) { 
												$list = $ls["id"];
											} else {
												$list .= ','.$ls["id"];
											}
											$i++;
									}
                                } 
                                $insert = $db->query("INSERT ce_gateways_directions (gateway_id,directions) VALUES ('$row[id]','$list')");
                            }
								
                        }
                     }
                     ?>

                     <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Gateway name</label>
                            <input type="text" class="form-control" name="name">
                        </div> 
                        <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Currency</label>
								<select class="form-control" name="currency">
											<option value=""></option>
											
											<?php 
														$currencies = getFiatCurrencies();
														foreach($currencies as $curk => $curv) {
															echo '<option value="'.$curk.'">'.$curv.'</option>';
														}
														?>
									</select>
								</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Currency</label>
										<input type="text" class="form-control" name="o_currency" placeholder="Enter currency code if is not listed.">
									</div>
								</div>
								</div>
							<div class="form-group">
								<label>Minimal amount for exchange</label>
								<input type="text" class="form-control" name="min_amount">
							</div>
							<div class="form-group">
								<label>Maximum amount for exchange</label>
								<input type="text" class="form-control" name="max_amount">
							</div>
							<div class="form-group">
								<label>Reserve</label>
								<input type="text" class="form-control" name="reserve">
                            </div>
                            <div id="account_fields">
									<div class="row">
										<div class="col-md-12"><?php echo info("<b>Name of the field</b> will be required by user when make exchange by this gateway. For example if you adding Bank Gateway enter for field name <b>SGBank Name</b> and etc.. For <b>Value of the field</b> need to enter your data for field, when user sell to this gateway will show data for payment in fields you are entered. You can add up to 10 fields."); ?></div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 1</label>
												<input type="text" class="form-control" name="field_1">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 1</label>
												<input type="text" class="form-control" name="g_field_1">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 2</label>
												<input type="text" class="form-control" name="field_2">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 2</label>
												<input type="text" class="form-control" name="g_field_2">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 3</label>
												<input type="text" class="form-control" name="field_3">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 3</label>
												<input type="text" class="form-control" name="g_field_3">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 4</label>
												<input type="text" class="form-control" name="field_4">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 4</label>
												<input type="text" class="form-control" name="g_field_4">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 5</label>
												<input type="text" class="form-control" name="field_5">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 5</label>
												<input type="text" class="form-control" name="g_field_5">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 6</label>
												<input type="text" class="form-control" name="field_6">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 6</label>
												<input type="text" class="form-control" name="g_field_6">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 7</label>
												<input type="text" class="form-control" name="field_7">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 7</label>
												<input type="text" class="form-control" name="g_field_7">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 8</label>
												<input type="text" class="form-control" name="field_8">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 8</label>
												<input type="text" class="form-control" name="g_field_8">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 9</label>
												<input type="text" class="form-control" name="field_9">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 9</label>
												<input type="text" class="form-control" name="g_field_9">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 10</label>
												<input type="text" class="form-control" name="field_10">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 10</label>
												<input type="text" class="form-control" name="g_field_10">
											</div>
										</div>
									</div>
								</div>
								<div class="checkbox">
								<label>
								  <input type="checkbox" name="allow_send" value="yes"> Allow customers to send money through this gateway
								</label>
                            </div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="allow_attachments" value="yes"> Allow attachments in orders
								</label>
                            </div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_attachments" value="yes"> Require attachments in orders
								</label>
                            </div>
							<div class="form-group">
					 			<label>Maximum allwed attachments</label>
								 <input type="text" class="form-control" name="max_attachments">
							</div>
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="is_crypto" value="yes"> Is crypto currency
								</label>
							</div> 
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="require_login" value="yes"> Require user to login before exchange
								</label>
							</div> 
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_email_verify" value="yes"> Require user to verify their email address before exchange
								</label>
							</div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_document_verify" value="yes"> Require user to verify their identify before exchange
								</label>
                            </div>
                            <div class="form-group">
										<label>Select icon to upload (format: jpg, png, recommended size: 48x48,56x66 and etc..)</label>
										<input type="file" name="uploadFile" class="form-control">
									</div>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="new"><i class="fa fa-plus"></i> Add</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "edit_merchant") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM ce_gateways WHERE id='$id'");
	if($query->num_rows==0) {
		header("Location: ./?a=exchange_gateways");
	}
	$row = $query->fetch_assoc();
	?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-pencil"></i> Edit Gateway</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "save") {
                        $min_amount = protect($_POST['min_amount']);
                        $max_amount = protect($_POST['max_amount']);
                        $reserve = protect($_POST['reserve']);
                        $g_field_1 = protect($_POST['g_field_1']);
                        $g_field_2 = protect($_POST['g_field_2']);
                        $g_field_3 = protect($_POST['g_field_3']);
                        $g_field_4 = protect($_POST['g_field_4']);
                        $g_field_5 = protect($_POST['g_field_5']);
                        $g_field_6 = protect($_POST['g_field_6']);
                        $g_field_7 = protect($_POST['g_field_7']);
                        $g_field_8 = protect($_POST['g_field_8']);
                        $g_field_9 = protect($_POST['g_field_9']);
                        $g_field_10 = protect($_POST['g_field_10']);
                        if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
                        if(isset($_POST['require_login'])) { $require_login = '1'; } else { $require_login = '0'; }
                        if(isset($_POST['require_email_verify'])) { $require_email_verify = '1'; } else { $require_email_verify = '0'; }
                        if(isset($_POST['require_document_verify'])) { $require_document_verify = '1'; } else { $require_document_verify = '0'; } 
                        $check = $db->query("SELECT * FROM ce_gateways WHERE name='$name' and currency='$currency'");
                        if(empty($min_amount) or empty($max_amount) or empty($reserve)) {
                            echo error("Required fields: min. amount, max. amount and reserve.");
                        } elseif(!is_numeric($min_amount)) { 
                            echo error("Please enter min. amount with numbers.");
                        } elseif(!is_numeric($max_amount)) {
                            echo error("Please enter max. amount with numbers.");
                        } elseif(!is_numeric($reserve)) {
                            echo error("Please enter reserve with numbers.");
                        } else {
							$update = $db->query("UPDATE ce_gateways SET min_amount='$min_amount',max_amount='$max_amount',reserve='$reserve',g_field_1='$g_field_1',g_field_2='$g_field_2',g_field_3='$g_field_3',g_field_4='$g_field_4',g_field_5='$g_field_5',g_field_6='$g_field_6',g_field_7='$g_field_7',g_field_8='$g_field_8',g_field_9='$g_field_9',g_field_10='$g_field_10',allow_send='$allow_send',require_login='$require_login',require_email_verify='$require_email_verify',require_document_verify='$require_document_verify' WHERE id='$row[id]'");
							echo success("Your changes was saved successfully.");
							$query = $db->query("SELECT * FROM ce_gateways WHERE id='$row[id]'");
							$row = $query->fetch_assoc();
						}
                     }
                     ?>

                     <form action="" method="POST">
                        <div class="form-group">
					 		<label>Gateway</label>
							 <input type="text" class="form-control" disabled value="<?php echo $row['name']." ".$row['currency']; ?>">
						</div>	
							<div class="form-group">
								<label>Minimal amount for exchange</label>
								<input type="text" class="form-control" name="min_amount" value="<?php echo $row['min_amount']; ?>">
							</div>
							<div class="form-group">
								<label>Maximum amount for exchange</label>
								<input type="text" class="form-control" name="max_amount" value="<?php echo $row['max_amount']; ?>">
							</div>
							<div class="form-group">
								<label>Reserve</label>
								<input type="text" class="form-control" name="reserve" value="<?php echo $row['reserve']; ?>">
                            </div>
                            <div id="account_fields">
							<?php
					$gateway = $row['name'];
					if($gateway == "PayPal") {
						?>
						<div class="form-group">
							<label>Your PayPal account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Stripe") {
						?>
						<div class="form-group">
							<label>Your Stripe Public Key</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your Stripe Secret Key</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<?php
					}
					elseif($gateway == "2checkout") {
						?>
						<div class="form-group">
							<label>Your 2checkout Seller ID</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your 2checkout Private Key</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<?php
					} elseif($gateway == "Paytm") {
						?>
						<div class="form-group">
							<label>Your Paytm Merchant key</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your Paytm Merchant ID</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<div class="form-group">
							<label>Your Paytm Website name</label>
							<input type="text" class="form-control" name="g_field_3" value="<?php echo $row['g_field_3']; ?>">
						</div>
						<?php
					} elseif($gateway == "Skrill") {
						?>
						<div class="form-group">
							<label>Your Skrill account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your Skrill secret key</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<?php
					} elseif($gateway == "WebMoney") {
						?>
						<div class="form-group">
							<label>Your WebMoney account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Payeer") {
						?>
						<div class="form-group">
							<label>Your Payeer account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your Payeer secret key</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<?php
					} elseif($gateway == "Perfect Money") {
						?>
						<div class="form-group">
							<label>Your Perfect Money account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Account ID or API NAME</label>
							<input type="text" class="form-control" name="g_field_3" value="<?php echo $row['g_field_3']; ?>">
						</div>
						<div class="form-group">
							<label>Passpharse</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
							<small>Alternate Passphrase you entered in your Perfect Money account.</small>
						</div>
						<?php
					} elseif($gateway == "AdvCash") {
						?>
						<div class="form-group">
							<label>Your AdvCash account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					}  elseif($gateway == "Mollie") {
						?>
						<div class="form-group">
							<label>Your Mollie API Key</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Bitcoin") {
						?>
						<div class="form-group">
							<label>Your secret key</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
							<small>Enter random secret key, to protect IPN requestst</small>
						</div>
						<div class="form-group">
							<label>Your Blockchain.info xPub</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<div class="form-group">
							<label>Your Blockchain.info API Key</label>
							<input type="text" class="form-control" name="g_field_3" value="<?php echo $row['g_field_3']; ?>">
						</div>
						<?php
					} elseif($gateway == "Litecoin") {
						?>
						<div class="form-group">
							<label>Your Litecoin address</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Dogecoin") {
						?>
						<div class="form-group">
							<label>Your Dogecoin address</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "OKPay") {
						?>
						<div class="form-group">
							<label>Your OKPay account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Entromoney") { 
						?>
						<div class="form-group">
							<label>Your Entromoney Account ID</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your Entromoney Receiver (Example: U11111111 or E1111111)</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<div class="form-group">
							<label>SCI ID</label>
							<input type="text" class="form-control" name="g_field_3" value="<?php echo $row['g_field_3']; ?>">
						</div>
						<div class="form-group">
							<label>SCI PASS</label>
							<input type="text" class="form-control" name="g_field_4" value="<?php echo $row['g_field_4']; ?>">
						</div>
						<?php
					} elseif($gateway == "SolidTrust Pay") {
						?>
						<div class="form-group">
							<label>Your SolidTrust Pay account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>SCI Name</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<div class="form-group">
							<label>SCI Password</label>
							<input type="text" class="form-control" name="g_field_3" value="<?php echo $row['g_field_3']; ?>">
						</div>
						<?php
					} elseif($gateway == "Neteller") {
						?>
						<div class="form-group">
							<label>Your Neteller account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "UQUID") {
						?>
						<div class="form-group">
							<label>Your UQUID account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "BTC-e") {
						?>
						<div class="form-group">
							<label>Your BTC-e account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Yandex Money") {
						?>
						<div class="form-group">
							<label>Your Yandex Money account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "QIWI") {
						?>
						<div class="form-group">
							<label>Your QIWI account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Payza") {
						?>
						<div class="form-group">
							<label>Your Payza account</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>IPN SECURITY CODE</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<?php
					}elseif($gateway == "Dash") {
						?>
						<div class="form-group">
							<label>Your Dash address</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Peercoin") {
						?>
						<div class="form-group">
							<label>Your Peercoin address</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Edinarcoin") {
						?>
						<div class="form-group">
							<label>Your Edinarcoin address</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Ethereum") {
						?>
						<div class="form-group">
							<label>Your Ethereum address</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Bank Transfer") {
						?>
						<div class="form-group">
							<label>Bank Account Holder's Name</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Bank Account Number/IBAN</label>
							<input type="text" class="form-control" name="g_field_4" value="<?php echo $row['g_field_4']; ?>">
						</div>
						<div class="form-group">
							<label>SWIFT Code</label>
							<input type="text" class="form-control" name="g_field_5" value="<?php echo $row['g_field_5']; ?>">
						</div>
						<div class="form-group">
							<label>Bank Name in Full</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<div class="form-group">
							<label>Bank Branch Country, City, Address</label>
							<input type="text" class="form-control" name="g_field_3" value="<?php echo $row['g_field_3']; ?>">
						</div>
						<?php
					} elseif($gateway == "Western Union") {
						?>
						<div class="form-group">
							<label>Your name (For money receiving)</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your location (For money receiving)</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<?php
					} elseif($gateway == "Moneygram") {
						?>
						<div class="form-group">
							<label>Your name (For money receiving)</label>
							<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your location (For money receiving)</label>
							<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
						</div>
						<?php
					} else {}
					?>
							</div>
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="allow_send" value="yes" <?php if($row['allow_send'] == "1") { echo 'checked'; } ?>> Allow customers to send money through this gateway
								</label>
							</div>
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="require_login" value="yes" <?php if($row['require_login'] == "1") { echo 'checked'; } ?>> Require user to login before exchange
								</label>
							</div> 
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_email_verify" value="yes" <?php if($row['require_email_verify'] == "1") { echo 'checked'; } ?>> Require user to verify their email address before exchange
								</label>
							</div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_document_verify" value="yes" <?php if($row['require_document_verify'] == "1") { echo 'checked'; } ?>> Require user to verify their identify before exchange
								</label>
							</div>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save Changes</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "edit_crypto") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM ce_gateways WHERE id='$id'");
	if($query->num_rows==0) {
		header("Location: ./?a=exchange_gateways");
	}
	$row = $query->fetch_assoc();
	?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-pencil"></i> Edit Gateway</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "save") {
                        $min_amount = protect($_POST['min_amount']);
                        $max_amount = protect($_POST['max_amount']);
                        $reserve = protect($_POST['reserve']);
                        $g_field_1 = protect($_POST['g_field_1']);
                        $g_field_2 = protect($_POST['g_field_2']);
                        $g_field_3 = protect($_POST['g_field_3']);
                        $g_field_4 = protect($_POST['g_field_4']);
                        $g_field_5 = protect($_POST['g_field_5']);
                        $g_field_6 = protect($_POST['g_field_6']);
                        $g_field_7 = protect($_POST['g_field_7']);
                        $g_field_8 = protect($_POST['g_field_8']);
                        $g_field_9 = protect($_POST['g_field_9']);
						$g_field_10 = protect($_POST['g_field_10']);
						if($row['merchant_source'] == "block.io") {
							if(isset($_POST['option_2'])) { $g_field_3 = 2; } else { $g_field_3 = 1; }
						}
                        if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
                        if(isset($_POST['require_login'])) { $require_login = '1'; } else { $require_login = '0'; }
                        if(isset($_POST['require_email_verify'])) { $require_email_verify = '1'; } else { $require_email_verify = '0'; }
						if(isset($_POST['require_document_verify'])) { $require_document_verify = '1'; } else { $require_document_verify = '0'; } 
						$merchant_source = $row['merchant_source'];
                        $check = $db->query("SELECT * FROM ce_gateways WHERE name='$name' and currency='$currency'");
                        if(empty($min_amount) or empty($max_amount) or empty($reserve)) {
                            echo error("Required fields: min. amount, max. amount and reserve.");
                        } elseif(!is_numeric($min_amount)) { 
                            echo error("Please enter min. amount with numbers.");
                        } elseif(!is_numeric($max_amount)) {
                            echo error("Please enter max. amount with numbers.");
                        } elseif(!is_numeric($reserve)) {
							echo error("Please enter reserve with numbers.");
							}	elseif($merchant_source == "block.io" && empty($g_field_1)) { echo error("Please enter a Block.io API Key."); }
				elseif($merchant_source == "block.io" && empty($g_field_2)) { echo error("Please enter a Block.io Secret."); }
				elseif($merchant_source == "block.io" && $g_field_3 == "0" && empty($g_field_4)) { echo error("Please enter a Block.io Address.");  }
				elseif($merchant_source == "coinpayments.net" && empty($g_field_1)) { echo error("Please enter a Coinpayments.net Merchant ID"); }
				elseif($merchant_source == "coinpayments.net" && empty($g_field_2)) { echo error("Please enter a Coinpayments.net IPN Secret"); 
                        } else {
							$update = $db->query("UPDATE ce_gateways SET min_amount='$min_amount',max_amount='$max_amount',reserve='$reserve',g_field_1='$g_field_1',g_field_2='$g_field_2',g_field_3='$g_field_3',g_field_4='$g_field_4',g_field_5='$g_field_5',g_field_6='$g_field_6',g_field_7='$g_field_7',g_field_8='$g_field_8',g_field_9='$g_field_9',g_field_10='$g_field_10',allow_send='$allow_send',require_login='$require_login',require_email_verify='$require_email_verify',require_document_verify='$require_document_verify' WHERE id='$row[id]'");
							echo success("Your changes was saved successfully.");
							$query = $db->query("SELECT * FROM ce_gateways WHERE id='$row[id]'");
							$row = $query->fetch_assoc();
						}
                     }
                     ?>

                     <form action="" method="POST" enctype="">
                        <div class="form-group">
					 		<label>Gateway</label>
							 <input type="text" class="form-control" disabled value="<?php echo $row['name']." ".$row['currency']; ?>">
						</div>	
							<div class="form-group">
								<label>Minimal amount for exchange</label>
								<input type="text" class="form-control" name="min_amount" value="<?php echo $row['min_amount']; ?>">
							</div>
							<div class="form-group">
								<label>Maximum amount for exchange</label>
								<input type="text" class="form-control" name="max_amount" value="<?php echo $row['max_amount']; ?>">
							</div>
							<div class="form-group">
								<label>Reserve</label>
								<input type="text" class="form-control" name="reserve" value="<?php echo $row['reserve']; ?>">
                            </div>
                            <div id="account_fields">
							<?php
					$merchant_source = $row['merchant_source'];
					if($merchant_source == "block.io") {
					?>
					<div class="form-group">
								<label>Block.io API Key</label>
								<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
							</div>
							<div class="form-group">
								<label>Block.io Merchant Secret</label>
								<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="option_2" value="yes" <?php if($row['g_field_3'] == "2") { echo 'checked'; } ?>> Generate new address for each exchange</label>
							</div>
							<div class="form-group">
								<label>Block.io Address</label>
								<input type="text" class="form-control" name="g_field_4" value="<?php echo $row['g_field_4']; ?>">
								<small>Enter here a address from your block.io account, if you do not want to generate new address for each exchange. Address must be from your block.io account to verify automatically transaction.</small>
							</div>
					<?php
					} elseif($merchant_source == "coinpayments.net") {
					?>
					<div class="form-group">
								<label>Coinpayments.net API Public</label>
								<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
							</div>
							<div class="form-group">
								<label>Coinpayments.net API Private</label>
								<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
							</div>
							<div class="form-group">
								<label>Coinpayments.net Merchant ID</label>
								<input type="text" class="form-control" name="g_field_3" value="<?php echo $row['g_field_3']; ?>">
							</div>
							<div class="form-group">
								<label>Coinpayments.net IPN Secret</label>
								<input type="text" class="form-control" name="g_field_4" value="<?php echo $row['g_field_4']; ?>">
							</div>
							<div class="form-group">
								<label class="form-label">CoinPayments Crypto Currency Prefix</label>
                                    <input type="text" class="form-control" name="g_field_5" value="<?php echo $row['g_field_5']; ?>">
                                    <small>Some crypto currencies have a other coin prefix. For example for USDT prefix
                                        is: USDT.ERC20 or USDT.TRC20, if you use regular crypto currency like Bitcoin,
                                        Ethereum enter BTC, ETH<br />You can check CoinPayments Supported Currencies
                                        here: <a href="https://www.coinpayments.net/supported-coins"
                                            target="_blank">https://www.coinpayments.net/supported-coins</a></small>
							</div>
					<?php
					} elseif($merchant_source == "blockchain.com") {
					?>
					<div class="form-group">
								<label>Your secret key</label>
								<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
								<small>Enter random secret key, to protect IPN requestst</small>
							</div>
							<div class="form-group">
								<label>Your Blockchain.com xPub</label>
								<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
							</div>
							<div class="form-group">
								<label>Your Blockchain.com API Key</label>
								<input type="text" class="form-control" name="g_field_3" value="<?php echo $row['g_field_3']; ?>">
							</div>

					<?php
					} else {}
					?>
							</div>
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="allow_send" value="yes" <?php if($row['allow_send'] == "1") { echo 'checked'; } ?>> Allow customers to send money through this gateway
								</label>
							</div>
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="require_login" value="yes" <?php if($row['require_login'] == "1") { echo 'checked'; } ?>> Require user to login before exchange
								</label>
							</div> 
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_email_verify" value="yes" <?php if($row['require_email_verify'] == "1") { echo 'checked'; } ?>> Require user to verify their email address before exchange
								</label>
							</div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_document_verify" value="yes" <?php if($row['require_document_verify'] == "1") { echo 'checked'; } ?>> Require user to verify their identify before exchange
								</label>
							</div>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save Changes</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "edit_manual") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM ce_gateways WHERE id='$id'");
	if($query->num_rows==0) {
		header("Location: ./?a=exchange_gateways");
	}
	$row = $query->fetch_assoc();
	?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-pencil"></i> Edit Gateway</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "save") {
                        $min_amount = protect($_POST['min_amount']);
                        $max_amount = protect($_POST['max_amount']);
                        $reserve = protect($_POST['reserve']);
                        $g_field_1 = protect($_POST['g_field_1']);
                        $g_field_2 = protect($_POST['g_field_2']);
                        $g_field_3 = protect($_POST['g_field_3']);
                        $g_field_4 = protect($_POST['g_field_4']);
                        $g_field_5 = protect($_POST['g_field_5']);
                        $g_field_6 = protect($_POST['g_field_6']);
                        $g_field_7 = protect($_POST['g_field_7']);
                        $g_field_8 = protect($_POST['g_field_8']);
                        $g_field_9 = protect($_POST['g_field_9']);
                        $g_field_10 = protect($_POST['g_field_10']);
						$field_1 = protect($_POST['field_1']);
						$field_2 = protect($_POST['field_2']);
						$field_3 = protect($_POST['field_3']);
						$field_4 = protect($_POST['field_4']);
						$field_5 = protect($_POST['field_5']);
						$field_6 = protect($_POST['field_6']);
						$field_7 = protect($_POST['field_7']);
						$field_8 = protect($_POST['field_8']);
						$field_9 = protect($_POST['field_9']);
						$field_10 = protect($_POST['field_10']);
                        $max_attachments = protect($_POST['max_attachments']);
						if(isset($_POST['require_attachments'])) { $require_attachments = '1'; } else { $require_attachments = '0'; }
						if(isset($_POST['allow_attachments'])) { $allow_attachments = '1'; } else { $allow_attachments = '0'; }
                        if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
						if(isset($_POST['is_crypto'])) { $is_crypto = '1'; } else { $is_crypto = '0'; }
						if(isset($_POST['require_login'])) { $require_login = '1'; } else { $require_login = '0'; }
                        if(isset($_POST['require_email_verify'])) { $require_email_verify = '1'; } else { $require_email_verify = '0'; }
                        if(isset($_POST['require_document_verify'])) { $require_document_verify = '1'; } else { $require_document_verify = '0'; } 
                        $check = $db->query("SELECT * FROM ce_gateways WHERE name='$name' and currency='$currency'");
                        if(empty($min_amount) or empty($max_amount) or empty($reserve)) {
                            echo error("Required fields: min. amount, max. amount and reserve.");
                        }elseif(!is_numeric($min_amount)) { 
                            echo error("Please enter min. amount with numbers.");
                        } elseif(!is_numeric($max_amount)) {
                            echo error("Please enter max. amount with numbers.");
                        } elseif(!is_numeric($reserve)) {
                            echo error("Please enter reserve with numbers.");
                        } elseif($allow_attachments == "1" && empty($max_attachments)) {
							echo error("Please enter maximum attachments in orders.");
						} elseif($allow_attachments == "1" && !is_numeric($max_attachments)) {
							echo error("Please enter maximum attachments with numbers.");
						} else {
							foreach($_POST['field'] as $k => $v) {
								if(!empty($v)) {
									$check = $db->query("SELECT * FROM ce_gateways_fields WHERE gateway_id='$row[id]' and field_number='$k'");
									if($check->num_rows>0) {
										$update = $db->query("UPDATE ce_gateways_fields SET field_name='$v' WHERE gateway_id='$row[id]' and field_number='$k'");
									} else {
										$insert = $db->query("INSERT ce_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$v','$k')");
									}
								}
							}
							$update = $db->query("UPDATE ce_gateways SET min_amount='$min_amount',max_amount='$max_amount',reserve='$reserve',g_field_1='$g_field_1',g_field_2='$g_field_2',g_field_3='$g_field_3',g_field_4='$g_field_4',g_field_5='$g_field_5',g_field_6='$g_field_6',g_field_7='$g_field_7',g_field_8='$g_field_8',g_field_9='$g_field_9',g_field_10='$g_field_10',allow_send='$allow_send',require_login='$require_login',require_email_verify='$require_email_verify',require_document_verify='$require_document_verify',max_attachments='$max_attachments',require_attachments='$require_attachments',allow_attachments='$allow_attachments',is_crypto='$is_crypto' WHERE id='$row[id]'");
							echo success("Your changes was saved successfully.");
							$query = $db->query("SELECT * FROM ce_gateways WHERE id='$row[id]'");
							$row = $query->fetch_assoc();
						}
                     }
                     ?>

                     <form action="" method="POST">
                        <div class="form-group">
					 		<label>Gateway</label>
							 <input type="text" class="form-control" disabled value="<?php echo $row['name']." ".$row['currency']; ?>">
						</div>	
							<div class="form-group">
								<label>Minimal amount for exchange</label>
								<input type="text" class="form-control" name="min_amount" value="<?php echo $row['min_amount']; ?>">
							</div>
							<div class="form-group">
								<label>Maximum amount for exchange</label>
								<input type="text" class="form-control" name="max_amount" value="<?php echo $row['max_amount']; ?>">
							</div>
							<div class="form-group">
								<label>Reserve</label>
								<input type="text" class="form-control" name="reserve" value="<?php echo $row['reserve']; ?>">
                            </div>
                            <div id="account_fields">
							<?php
					$fieldsquery = $db->query("SELECT * FROM ce_gateways_fields WHERE gateway_id='$row[id]' ORDER BY id");
					if($fieldsquery->num_rows>0) {
						while($field = $fieldsquery->fetch_assoc()) {
							$f[$field[field_number]] = $field[field_name];
						}
					}
					?>
					<div class="row">
						<div class="col-md-12"><?php echo info("<b>Name of the field</b> will be required by user when make exchange by this gateway. For example if you adding Bank Gateway enter for field name <b>SGBank Name</b> and etc.. For <b>Value of the field</b> need to enter your data for field, when user sell to this gateway will show data for payment in fields you are entered. You can add up to 10 fields."); ?></div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 1</label>
								<input type="text" class="form-control" name="field[1]" value="<?php echo $f[1]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 1</label>
								<input type="text" class="form-control" name="g_field_1" value="<?php echo $row['g_field_1']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 2</label>
								<input type="text" class="form-control" name="field[2]" value="<?php echo $f[2]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 2</label>
								<input type="text" class="form-control" name="g_field_2" value="<?php echo $row['g_field_2']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 3</label>
								<input type="text" class="form-control" name="field[3]" value="<?php echo $f[3]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 3</label>
								<input type="text" class="form-control" name="g_field_3" value="<?php echo $row['g_field_3']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 4</label>
								<input type="text" class="form-control" name="field[4]" value="<?php echo $f[4]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 4</label>
								<input type="text" class="form-control" name="g_field_4" value="<?php echo $row['g_field_4']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 5</label>
								<input type="text" class="form-control" name="field[5]" value="<?php echo $f[5]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 5</label>
								<input type="text" class="form-control" name="g_field_5" value="<?php echo $row['g_field_5']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 6</label>
								<input type="text" class="form-control" name="field[6]" value="<?php echo $f[6]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 6</label>
								<input type="text" class="form-control" name="g_field_6" value="<?php echo $row['g_field_6']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 7</label>
								<input type="text" class="form-control" name="field[7]" value="<?php echo $f[7]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 7</label>
								<input type="text" class="form-control" name="g_field_7" value="<?php echo $row['g_field_7']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 8</label>
								<input type="text" class="form-control" name="field[8]" value="<?php echo $f[8]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 8</label>
								<input type="text" class="form-control" name="g_field_8" value="<?php echo $row['g_field_8']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 9</label>
								<input type="text" class="form-control" name="field[9]" value="<?php echo $f[9]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 9</label>
								<input type="text" class="form-control" name="g_field_9" value="<?php echo $row['g_field_9']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 10</label>
								<input type="text" class="form-control" name="field[10]" value="<?php echo $f[10]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 10</label>
								<input type="text" class="form-control" name="g_field_10" value="<?php echo $row['g_field_10']; ?>">
							</div>
						</div>
					</div>
							</div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="allow_send" value="yes" <?php if($row['allow_send'] == "1") { echo 'checked'; } ?>> Allow customers to send money through this gateway
								</label>
                            </div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="allow_attachments" value="yes" <?php if($row['allowallow_attachments_send'] == "1") { echo 'checked'; } ?>> Allow attachments in orders
								</label>
                            </div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_attachments" value="yes" <?php if($row['require_attachments'] == "1") { echo 'checked'; } ?>> Require attachments in orders
								</label>
                            </div>
							<div class="form-group">
					 			<label>Maximum allwed attachments</label>
								 <input type="text" class="form-control" name="max_attachments" value="<?php echo $row['max_attachments']; ?>">
							</div>
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="is_crypto" value="yes" <?php if($row['is_crypto'] == "1") { echo 'checked'; } ?>> Is crypto currency
								</label>
							</div> 
                            <div class="checkbox">
								<label>
								  <input type="checkbox" name="require_login" value="yes" <?php if($row['require_login'] == "1") { echo 'checked'; } ?>> Require user to login before exchange
								</label>
							</div> 
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_email_verify" value="yes" <?php if($row['require_email_verify'] == "1") { echo 'checked'; } ?>> Require user to verify their email address before exchange
								</label>
							</div>
							<div class="checkbox">
								<label>
								  <input type="checkbox" name="require_document_verify" value="yes" <?php if($row['require_document_verify'] == "1") { echo 'checked'; } ?>> Require user to verify their identify before exchange
								</label>
                            </div>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save Changes</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM ce_gateways WHERE id='$id'");
	if($query->num_rows==0) {
		header("Location: ./?a=exchange_gateways");
	}
	$row = $query->fetch_assoc();
	?>
	<div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-trash"></i> Delete Gateway</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $confirmed = protect($_GET['confirmed']);
                     if(isset($confirmed) && $confirmed == "1") {
						$delete = $db->query("DELETE FROM ce_gateways WHERE id='$row[id]'");
						$delete = $db->query("DELETE FROM ce_orders WHERE gateway_from='$id'");
						$delete = $db->query("DELETE FROM ce_orders WHERE gateway_to='$id'");
						$delete = $db->query("DELETE FROM ce_rates WHERE gateway_from='$id'");
						$delete = $db->query("DELETE FROM ce_rates WHERE gateway_to='$id'");
						$delete = $db->query("DELETE FROM ce_gateways_fields WHERE gateway_id='$id'");
						$delete = $db->query("DELETE FROM ce_gateways_rules WHERE gateway_from='$id'");
						$delete = $db->query("DELETE FROM ce_gateways_rules WHERE gateway_to='$id'");
						$dirquery = $db->query("SELECT * FROM ce_gateways_directions WHERE directions LIKE '%$id%'");
						if($dirquery->fetch_assoc()) {
							while($dir = $dirquery->fetch_assoc()) {
								$newlist = '';
								$i=1;
								$dirs = explode(",",$dir['directions']);
								foreach($dirs as $k=>$v) {
									if($v !== $id) { 
										if($i == 1) {
											$newlist .= $v;
										} else {
											$newlist .= ','.$v;
										}
										$i++;
									}
								}
								$update = $db->query("UPDATE ce_gateways_directions SET directions='$newlist' WHERE id='$dir[id]'");
							}
						}
						$delete = $db->query("DELETE FROM ce_gateways_directions WHERE gateway_id='$id'");
                        echo success("Gateway ($row[name] $row[currency]) was deleted successfully.");    
                     } else {
                        echo info("Are you sure you want to delete gateway ($row[name] $row[currency])?");
                        echo '<a href="./?a=exchange_gateways&b=delete&id='.$id.'&confirmed=1" class="btn btn-success"><i class="fa fa-trash"></i> Yes, I confirm</a> 
                        <a href="./?a=exchange_gateways" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
                     }
                     ?>
                </div>
              </div>
            </div>
        </div>
	<?php
} else { 
    ?>
 <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="ti-credit-card"></i> Exchange Gateways
                 <span class="pull-right">
                 <a href="./?a=exchange_gateways&b=add_merchant" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add merchant</a> 
                 <a href="./?a=exchange_gateways&b=add_crypto" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add crypto</a> 
                 <a href="./?a=exchange_gateways&b=add_manual" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add manual payment</a>
                </span></h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Gateway</th>
                                <th>Min. amount</th>
                                <th>Max. amount</th>
                                <th>Reserve</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                            $limit = 20;
                            $startpoint = ($page * $limit) - $limit;
                            if($page == 1) {
                                $i = 1;
                            } else {
                                $i = $page * $limit;
                            }
                            $statement = "ce_gateways";
                            $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
                            if($query->num_rows>0) {
                                while($row = $query->fetch_assoc()) {
                                    ?>
                                    <tr>
                                    <td>
                                    <?php
                                    if($row['external_gateway'] == "0" && $row['is_crypto'] == "1" or $row['manual_payment'] == "0" && $row['is_crypto'] == "1") {
                                        echo '<span class="badge badge-warning">crypto</span>';
                                        $link = 'edit_crypto';
                                    } elseif($row['external_gateway'] == "1" or $row['manual_payment'] == "1") {
                                        echo '<span class="badge badge-danger">manual</span>'; 
                                        $link = 'edit_manual';
                                    } else {
                                        echo '<span class="badge badge-primary">merchant</span>';
                                        $link = 'edit_merchant';
                                    }
                                    ?> 
                                    <?php echo $row['name']." ".$row['currency']; ?></td>
                                    <td><?php echo $row['min_amount']." ".$row['currency']; ?></td>
                                    <td><?php echo $row['max_amount']." ".$row['currency']; ?></td>
                                    <td><?php echo $row['reserve']." ".$row['currency']; ?></td>
                                    <td>
                                        <a href="./?a=exchange_gateways&b=<?php echo $link; ?>&id=<?php echo $row['id']; ?>" class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</a> 
                                        <a href="./?a=exchange_gateways&b=delete&id=<?php echo $row['id']; ?>" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">No gateways yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <?php
                    $ver = "./?a=exchange_gateways";
                    if(admin_pagination($statement,$ver,$limit,$page)) {
                        echo '<br>';
                        echo admin_pagination($statement,$ver,$limit,$page);
                    }
                    ?>
                </div>
              </div>
            </div>
        </div>
    <?php
}
?>
