<?php

if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$query_wallet_gateways = "SELECT * FROM `ce_wallet_gateways`  ORDER BY `id` DESC";
$result_wallet_gateways = $db->query($query_wallet_gateways);

$CE_Action = protect($_POST["ce_btn"]);
$url = $settings["url"];
$back_url = $url."app/admin/?a=wallet&b=wallet_gateways";
if(isset($_GET["c"]) && $_GET["c"] == "status")
{
    $status = $_GET["status"];
    $id = $_GET["id"];
    if($status == 0)
    {
        $db->query("UPDATE `ce_wallet_gateways` SET `status` = '1' WHERE `id` = '$id'");
    }
    else if($status == 1)
    {
        $db->query("UPDATE `ce_wallet_gateways` SET `status` = '0' WHERE `id` = '$id'");
    }
    header("Location: $back_url");
}
if($CE_Action == "new")
{
    $name = protect($_POST["name"]);
    $currency = protect($_POST["currency"]);
    $icon = protect($_POST["icon"]);
    $wallet_id = protect($_POST["wallet_id"]);
    $fees = protect($_POST["fees"]);
    $status = 1;
    $time = time();

    if($_FILES["icon"]["name"] != null)
    {
        $target_dir = "../../uploads/";
        $extension = pathinfo($_FILES["icon"]["name"], PATHINFO_EXTENSION);
        $file_name = time()."_icon.".$extension;
        $target_file = $target_dir . $file_name;
        $temp_name = $_FILES["icon"]["tmp_name"];
        move_uploaded_file($temp_name, $target_file);
    }

    $query_wallet_gateways = "INSERT INTO `ce_wallet_gateways`
    (
        `name`,
        `currency`,
        `icon`,
        `wallet_id`,
        `fees`,
        `status`,
        `created`
    )
    VALUES
    (
        '$name',
        '$currency',
        'uploads/$file_name',
        '$wallet_id',
        '$fees',
        '$status',
        '$time'
    )";

    $db->query($query_wallet_gateways);

    $back_url = $settings["url"].'app/admin/?a=wallet&b=wallet_gateways';
    $_SESSION["success"] = "Wallet gateway created successfully";
    header("Location: $back_url");
    exit;
}
else if($CE_Action == "edit")
{
    $id = protect($_POST["id"]);
    $name = protect($_POST["name"]);
    $currency = protect($_POST["currency"]);
    $wallet_id = protect($_POST["wallet_id"]);
    $fees = protect($_POST["fees"]);
    $icon = protect($_POST["icon"]);
    $status = 1;
    $time = time();
    
    $id = protect($_GET["id"]);
    $result_wallet_gateway = $db->query("SELECT * FROM `ce_wallet_gateways` WHERE `id` = '$id'");
    $wallet_gateway = $result_wallet_gateway->fetch_assoc();
    $file_name = $wallet_gateway["icon"];
    $file_url = "../../uploads/".$file_name;
    if($_FILES["icon"]["name"] != null)
    {
        $target_dir = "../../uploads/";
        $extension = pathinfo($_FILES["icon"]["name"], PATHINFO_EXTENSION);
        $file_name = time()."_icon.".$extension;
        $target_file = $target_dir . $file_name;
        $temp_name = $_FILES["icon"]["tmp_name"];
        move_uploaded_file($temp_name, $target_file);
        if(file_exists($file_url))
        {
            unlink($file_url);
        }
        $file_name = "uploads/".$file_name;
    }

    $query_wallet_gateways = "UPDATE `ce_wallet_gateways` SET
    `name` = '$name',
    `currency` = '$currency',
    `icon` = '$file_name',
    `fees` = '$fees',
    `wallet_id` = '$wallet_id',
    `created` = '$time' WHERE `id` = '$id'";

    $db->query($query_wallet_gateways);

    $back_url = $settings["url"].'app/admin/?a=wallet&b=wallet_gateways';
    $_SESSION["success"] = "Wallet gateway created successfully";
    header("Location: $back_url");
    exit;
}

?>
<div class="row">
    <?php if(isset($_GET["c"]) && $_GET["c"] == "add"){ ?>
        <div class="col-md-12 col-lg-12">
            <h4 class="card-title">
                <i class="fa fa-money"></i> 
                Wallet Gateways
            </h4>
            <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Currency Code</label>
                                        <input type="text" class="form-control" name="currency" id="currency">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Your Wallet Address</label>
                                        <input type="text" class="form-control" name="wallet_id" id="wallet_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input type="file" class="form-control" name="icon" id="icon">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fees (enter without %. it will calculate in percentage.)</label>
                                        <input type="text" class="form-control" name="fees" id="fees" value="0">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="ce_btn" value="new"><i class="fa fa-plus"></i> Create</button>
                        </form>
                    </div>
                </div>
        </div>
    <?php } elseif(isset($_GET["c"]) && $_GET["c"] == "edit"){ ?>
        <?php  
            $id = protect($_GET["id"]);
            $result_wallet_gateway = $db->query("SELECT * FROM `ce_wallet_gateways` WHERE `id` = '$id'");
            $wallet_gateway = $result_wallet_gateway->fetch_assoc();
        ?>
        <div class="col-md-12 col-lg-12">
            <h4 class="card-title">
                <i class="fa fa-money"></i> 
                Wallet Gateways
            </h4>
            <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?=$wallet_gateway["id"]?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" value="<?=$wallet_gateway["name"]?>" class="form-control" name="name" id="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Currency Code</label>
                                        <input type="text" value="<?=$wallet_gateway["currency"]?>" class="form-control" name="currency" id="currency">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Your Wallet Address</label>
                                        <input type="text" class="form-control" value="<?=$wallet_gateway["wallet_id"]?>" name="wallet_id" id="wallet_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input type="file" class="form-control" name="icon" id="icon">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fees (enter without %. it will calculate in percentage.)</label>
                                        <input type="text" class="form-control" name="fees" id="fees" value="<?=$wallet_gateway["fees"]?>">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="ce_btn" value="edit"><i class="fa fa-plus"></i> Update</button>
                        </form>
                    </div>
                </div>
        </div>
    <?php } elseif(isset($_GET["c"]) && $_GET["c"] == "delete") { ?>
        <div class="col-md-12">
            <?php  
                $id = $_GET["id"];
                $result_wallet_gateway = $db->query("SELECT * FROM `ce_wallet_gateways` WHERE `id` = '$id'");
                $wallet_gateway = $result_wallet_gateway->fetch_assoc();
                if(isset($_GET["confirmed"]) && $_GET["confirmed"] == 1)
                {
                    $file_url = "../../uploads/".$wallet_gateway["icon"];
                    if(file_exists($file_url))
                    {
                        unlink($file_url);
                    }
                    $db->query("DELETE FROM `ce_wallet_gateways` WHERE `id` = '$id'");
                    header("Location: $back_url");
                }
            ?>
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <span>Are you sure you want to delete gateway (<?php echo $wallet_gateway["name"] . " " . $wallet_gateway["currency"]; ?>)?</span>
                    </div>
                    <a href="./?a=wallet&b=wallet_gateways&c=delete&id=<?=$id?>&confirmed=1" class="btn btn-success">
                        <i class="fa fa-trash"></i> 
                        Yes, I confirm
                    </a> 
                    <a href="./?a=exchange_gateways" class="btn btn-danger"><i class="fa fa-times"></i> No</a>                
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-md-12 col-lg-12">
                <h4 class="card-title">
                    <i class="fa fa-money"></i> 
                    Wallet Gateways
                    <span class="pull-right">
                        <a href="./?a=wallet&b=wallet_gateways&c=add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add gateway</a> 
                    </span>
                </h4>
                <br><br>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Currency</th>
                                            <th>Your Wallet Address</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($gateway = $result_wallet_gateways->fetch_assoc()){ ?>
                                        <tr>
                                            <td><?=$gateway['name']?></td>
                                            <td><?=$gateway['currency']?></td>
                                            <td><?=$gateway['wallet_id']?></td>
                                            <td>
                                                <?php
                                                    if($gateway['status'] == 1)
                                                    {
                                                        echo "<div class='badge badge-success'>Enabled</div>";
                                                    } 
                                                    else
                                                    {
                                                        echo "<div class='badge badge-danger'>Disabled</div>";                                                        
                                                    }                                                    
                                                ?>
                                            </td>
                                            <td>
                                                <?php if($gateway['status'] == 0) { ?>
                                                    <a href="./?a=wallet&b=wallet_gateways&c=status&status=<?=$gateway['status']?>&id=<?=$gateway['id']?>" class="badge badge-success">Enable</a> 
                                                <?php } else if($gateway['status'] == 1) { ?>
                                                    <a href="./?a=wallet&b=wallet_gateways&c=status&status=<?=$gateway['status']?>&id=<?=$gateway['id']?>" class="badge badge-danger">Disable</a> 
                                                <?php }  ?>
                                                <a href="./?a=wallet&b=wallet_gateways&c=edit&id=<?=$gateway['id']?>" class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</a> 
                                                <a href="./?a=wallet&b=wallet_gateways&c=delete&id=<?=$gateway['id']?>" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php } ?>
</div>