<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);
if($b == "new") {
    ?>
    <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-plus"></i> New Exchange Rate</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "new") {
                        $gateway_from = protect($_POST['gateway_from']);
                        $gateway_from_prefix = protect($_POST['gateway_from_prefix']);
                        $gateway_to = protect($_POST['gateway_to']);
                        $gateway_to_prefix = protect($_POST['gateway_to_prefix']);
                        if(isset($_POST['automatic_rate'])) { $automatic_rate = 1; } else { $automatic_rate = 0; }
                        $rate_from = protect($_POST['rate_from']);
                        $rate_to = protect($_POST['rate_to']);
                        $check = $db->query("SELECT * FROM ce_xmlrates WHERE gateway_from='$gateway_from' and gateway_to='$gateway_to'");
                        if(empty($gateway_from) or empty($gateway_from_prefix) or empty($gateway_to_prefix) or empty($gateway_to)) { echo error("All fields are required."); }
                        elseif($check->num_rows>0) { echo error("This exchange rate already exists."); }
                        elseif($automatic_rate == "0" && !is_numeric($rate_from)) { echo error("Please enter rate from with numbers."); }
                        elseif($automatic_rate == "0" && !is_numeric($rate_to)) { echo error("Please enter rate to with numbers."); }
                        else {
                            $insert = $db->query("INSERT ce_xmlrates (gateway_from,gateway_from_prefix,gateway_to,gateway_to_prefix,rate_from,rate_to,automatic_rate) VALUES ('$gateway_from','$gateway_from_prefix','$gateway_to','$gateway_to_prefix','$rate_from','$rate_to','$automatic_rate')");
                            echo success("Exchange rate was added successfully.");
                        }
                     }
                     ?>

                     <form action="" method="POST">
                     <div class="row">
                         <div class="col-md-12"><p>Please read this article <b><a href="https://www.bestchange.com/wiki/rates.html">https://www.bestchange.com/wiki/rates.html</a></b> to know what currency code of gateway to enter in fields below.</p></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gateway from</label>
                            <select class="form-control" name="gateway_from">
                                <?php
                                $list = $db->query("SELECT * FROM ce_gateways ORDER BY id");
                                if($list->num_rows>0) {
                                    while($l = $list->fetch_assoc()) {
                                        echo '<option value="'.$l["id"].'">'.$l["name"].' '.$l["currency"].'</option>';
                                    }
                                } else {
                                    echo '<option>No have gateways.</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Currency code for "Gateway from"</label>
                            <input type="text" class="form-control" name="gateway_from_prefix">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gateway to</label>
                            <select class="form-control" name="gateway_to">
                                <?php
                                $list = $db->query("SELECT * FROM ce_gateways ORDER BY id");
                                if($list->num_rows>0) {
                                    while($l = $list->fetch_assoc()) {
                                        echo '<option value="'.$l["id"].'">'.$l["name"].' '.$l["currency"].'</option>';
                                    }
                                } else {
                                    echo '<option>No have gateways.</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                            <label>Currency code for "Gateway to"</label>
                            <input type="text" class="form-control" name="gateway_to_prefix">
                        </div>
                    </div>
                </div>
                <div class="checkbox">
					<label>
					  <input type="checkbox" name="automatic_rate" value="yes" checked> Get automatic exchange rate for this direction
					</label>
				  </div>
                <hr/>
				<div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rate from</span>
                        </div>
                        <input type="text" class="form-control" name="rate_from" placeholder="1" aria-describedby="basic-addon1">
                    </div>
                            </div>
                            <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">=&nbsp;&nbsp; Rate to</span>
                        </div>
                        <input type="text" class="form-control" name="rate_to" placeholder="0.95" aria-describedby="basic-addon1">
                    </div>
                            </div>
                            </div>
                    <small>Enter the exchange rate manually if you do not want it updated automatically.</small>
				</div>
                <hr/>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="new"><i class="fa fa-plus"></i> Create</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "edit") {
    $id = protect($_GET['id']);
    $query = $db->query("SELECT * FROM ce_xmlrates WHERE id='$id'");
    if($query->num_rows==0) {
        header("Location: ./?a=export_rates");
    }
    $row = $query->fetch_assoc();
    ?>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-pencil"></i> Edit Exchange Rate</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $CEAction = protect($_POST['ce_btn']);
                     if(isset($CEAction) && $CEAction == "save") {
                        $gateway_from = protect($_POST['gateway_from']);
                        $gateway_from_prefix = protect($_POST['gateway_from_prefix']);
                        $gateway_to = protect($_POST['gateway_to']);
                        $gateway_to_prefix = protect($_POST['gateway_to_prefix']);
                        if(isset($_POST['automatic_rate'])) { $automatic_rate = 1; } else { $automatic_rate = 0; } 
                        $rate_from = protect($_POST['rate_from']);
                        $rate_to = protect($_POST['rate_to']);
                        if(empty($gateway_from_prefix) or empty($gateway_to_prefix)) { echo error("All fields are required."); }
                        elseif($automatic_rate == "0" && !is_numeric($rate_from)) { echo error("Please enter rate from with numbers."); }
                        elseif($automatic_rate == "0" && !is_numeric($rate_to)) { echo error("Please enter rate to with numbers."); }
                        else {
                            $update = $db->query("UPDATE ce_xmlrates SET gateway_from='$gateway_from',gateway_from_prefix='$gateway_from_prefix',gateway_to='$gateway_to',gateway_to_prefix='$gateway_to_prefix',automatic_rate='$automatic_rate',rate_from='$rate_from',rate_to='$rate_to' WHERE id='$row[id]'");
                            $query = $db->query("SELECT * FROM ce_xmlrates WHERE id='$id'");
                            $row = $query->fetch_assoc();
                            echo success("Your changes was saved successfully.");
                        }
                     }
                     ?>

                     <form action="" method="POST">
                         <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Gateway from</label>
                            <select class="form-control" name="gateway_from">
                                <?php
                                $list = $db->query("SELECT * FROM ce_gateways ORDER BY id");
                                if($list->num_rows>0) {
                                    while($l = $list->fetch_assoc()) {
                                        if($row['gateway_from'] == $l['id']) { $sel = 'selected'; } else { $sel = ''; }
                                        echo '<option value="'.$l["id"].'" '.$sel.'>'.$l["name"].' '.$l["currency"].'</option>';
                                    }
                                } else {
                                    echo '<option>No have gateways.</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Currency code for "Gateway from"</label>
                            <input type="text" class="form-control" name="gateway_from_prefix" value="<?php echo $row['gateway_from_prefix']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gateway to</label>
                            <select class="form-control" name="gateway_to">
                                <?php
                                $list = $db->query("SELECT * FROM ce_gateways ORDER BY id");
                                if($list->num_rows>0) {
                                    while($l = $list->fetch_assoc()) {
                                        if($row['gateway_to'] == $l['id']) { $sel2 = 'selected'; } else { $sel2 = ''; }
                                        echo '<option value="'.$l["id"].'" '.$sel2.'>'.$l["name"].' '.$l["currency"].'</option>';
                                    }
                                } else {
                                    echo '<option>No have gateways.</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                            <label>Currency code for "Gateway to"</label>
                            <input type="text" class="form-control" name="gateway_to_prefix" value="<?php echo $row['gateway_to_prefix']; ?>">
                        </div>
                    </div>
                </div>
                <div class="checkbox">
					<label>
					  <input type="checkbox" name="automatic_rate" value="yes" <?php if($row['automatic_rate'] == "1") { echo 'checked'; } ?>> Get automatic exchange rate for this direction
					</label>
				  </div>
                <hr/>
				<div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rate from</span>
                        </div>
                        <input type="text" class="form-control" name="rate_from" value="<?php echo $row['rate_from']; ?>" placeholder="1" aria-describedby="basic-addon1">
                    </div>
                            </div>
                            <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">=&nbsp;&nbsp; Rate to</span>
                        </div>
                        <input type="text" class="form-control" name="rate_to" value="<?php echo $row['rate_to']; ?>" placeholder="0.95" aria-describedby="basic-addon1">
                    </div>
                            </div>
                            </div>
                    <small>Enter the exchange rate manually if you do not want it updated automatically.</small>
				</div>
                <hr/>
                        <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save Changes</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    <?php
} elseif($b == "delete") {
    $id = protect($_GET['id']);
    $query = $db->query("SELECT * FROM ce_xmlrates WHERE id='$id'");
    if($query->num_rows==0) {
        header("Location: ./?a=export_rates");
    }
    $row = $query->fetch_assoc();
    ?>
 <div class="row">
            <div class="col-md-12 col-lg-12">
                <h4 class="card-title"><i class="fa fa-trash"></i> Delete Exchange Rate</h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                     <?php
                     $gateway_from = $row['gateway_from'];
                     $gateway_to = $row['gateway_to'];
                     $gateway_send = gatewayinfo($gateway_from,"name")." ".gatewayinfo($gateway_from,"currency");
                     $gateway_receive = gatewayinfo($gateway_to,"name")." ".gatewayinfo($gateway_to,"currency");
                     $confirmed = protect($_GET['confirmed']);
                     if(isset($confirmed) && $confirmed == "1") {
                        $delete = $db->query("DELETE FROM ce_xmlrates WHERE id='$id'");
                        echo success("Exchange rate from $gateway_send to $gateway_receive was deleted successfully.");    
                     } else {
                        echo info("Are you sure you want to delete exchange rate from $gateway_send to $gateway_receive?");
                        echo '<a href="./?a=export_rates&b=delete&id='.$id.'&confirmed=1" class="btn btn-success"><i class="fa fa-trash"></i> Yes, I confirm</a> 
                        <a href="./?a=export_rates" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
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
                <h4 class="card-title"><i class="fa fa-mail-forward"></i> Export Rates <span class="pull-right"><a href="./?a=export_rates&b=new" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Rate</a></span></h4>
                <br><br>
            </div>
            <div class="col-lg-12">
                <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> This plugin allow you to provide your exchange rates in xml format for BestChange.com. You can see your rates here <a href="<?php echo $settings['url']; ?>rates.php?s=xml"><?php echo $settings['url']; ?>rates.php?s=xml</a>
                    </div>
                    </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th>Gateway from</th>
                            <th>Gateway to</th>
                            <th>Exchange rate</th>
                            <th>Automatic rate</th>
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
                            $statement = "ce_xmlrates";
                            $query = $db->query("SELECT * FROM {$statement} ORDER BY gateway_from DESC LIMIT {$startpoint} , {$limit}");
                            if($query->num_rows>0) {
                                while($row = $query->fetch_assoc()) {
                                    ?>
                                    <tr>
                                     <td><?php echo gatewayinfo($row['gateway_from'],"name")." ".gatewayinfo($row['gateway_from'],"currency"); ?></td>
                                     <td><?php echo gatewayinfo($row['gateway_to'],"name")." ".gatewayinfo($row['gateway_to'],"currency"); ?></td>
                                      <td><?php if($row['automatic_rate']=="1") { echo '-'; } else { ?><?php echo $row['rate_from']; ?> <?php echo gatewayinfo($row['gateway_from'],"currency"); ?> = <?php echo $row['rate_to']; ?> <?php echo gatewayinfo($row['gateway_to'],"currency"); ?><?php  } ?></td>
                                     <td><?php if($row['automatic_rate']=="1") { echo '<span class="badge badge-success"><i class="fa fa-check"></i> Yes</span>'; } else { echo '<span class="badge badge-daner"><i class="fa fa-times"></i> No</span>'; }?></td>
                                    <td>
                                        <a href="./?a=export_rates&b=edit&id=<?php echo $row['id']; ?>" class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</a> 
                                        <a href="./?a=export_rates&b=delete&id=<?php echo $row['id']; ?>" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">No exchange rates yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <?php
                    $ver = "./?a=export_rates";
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