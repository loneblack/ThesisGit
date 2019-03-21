<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
$id = $_GET['id'];
$_SESSION['previousPage'] = "engineer_view_ticket_repair_opened.php?id={$id}";
require_once("db/mysql_connect.php");

$query =  "SELECT *, t.status AS 'status', s.status AS 'statusDescription' FROM thesis.ticket t JOIN ref_ticketstatus s ON t.status = s.ticketID  WHERE t.ticketID = {$id};";
$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        
        $dateCreated = $row['dateCreated'];
        $dueDate = $row['dueDate'];
        $summary = $row['summary'];
        $details = $row['details'];
        $status = $row['status'];
        $statusDescription = $row['statusDescription'];
        $description = $row['description'];
        $priority = $row['priority'];
        $others = $row['others'];
        $assigneeUserID = $row['assigneeUserID'];
        $comment = $row['comment'];
        $serviceID = $row['service_id'];


    }
$assets = array();

$query2 =  "SELECT * FROM thesis.ticketedasset WHERE ticketID = {$id};";
$result2 = mysqli_query($dbc, $query2);

while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($assets, $row['assetID']);
}

$components = array();
$source = array();

$queryComponents = "SELECT *, cc.assetID as'componentID', c.assetID as 'sourceID' 
                        FROM thesis.ticketedasset t 
                    JOIN computer c ON c.assetID = t.assetID
                    JOIN computercomponent cc ON c.computerID = cc.computerID
                    WHERE ticketID = '{$id}';";
$resultComponents = mysqli_query($dbc, $queryComponents);

while ($row = mysqli_fetch_array($resultComponents, MYSQLI_ASSOC)){
    array_push($components, $row['componentID']);
    array_push($source, $row['sourceID']);
}
?>
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>DLSU IT Asset Management</title>

    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>

    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">

                <a href="#" class="logo">
                    <img src="images/dlsulogo.png" alt="" width="200px" height="40px">
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'engineer_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
						<form class="cmxform form-horizontal " id="signupForm" method="post" action="engineer_view_ticket_repair_opened_DB.php?id=<?php echo $id;?>">
                        <div class="col-sm-9">
                            <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <?php
                                        if (isset($_SESSION['submitMessage'])){

                                            echo "<div style='text-align:center' class='alert alert-success'><h5><strong>
                                                    {$_SESSION['submitMessage']}
                                                  </strong></h5></div>";

                                            unset($_SESSION['submitMessage']);
                                        }
                                    ?>
                                    <h4 class="gen-case" style="float:right">
                                        <?php
                                        if($status=='1'){
                                            echo "<a class='btn btn-success'>Open</a>";
                                        }
                                        elseif($status=='7'){
                                            echo "<a class='btn btn-danger'>Closed</a>";
                                        }
                                        elseif($status=='2'){
                                            echo "<a class='btn btn-info'>Assigned</a>";
                                        }
                                        
                                        elseif($status=='3'){
                                            echo "<a class='btn btn-warning'>In Progress</a>";
                                        }
                                        elseif($status=='6'){
                                            echo "<a class='btn btn-warning'>Waiting for Parts</a>";
                                        }
                                        elseif($status=='4'){
                                            echo "<a class='btn btn-primary'>Transferred</a>";
                                        }
                                        elseif($status=='5'){
                                            echo "<a class='btn btn-default'>Escalated</a>";
                                        }
                                    ?>
                                    </h4>
                                    <h4>Repair Ticket</h4>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong>Helpdesk</strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <h5>Date Created:
                                                    <?php echo $dateCreated;?>
                                                </h5>
                                            </div>
                                            <div class="col-md-8">
                                                
                                            </div>
                                            <div class="cp;-col-md-4"></div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="view-mail">
                                        <p>Details:
                                            <?php echo $details;?>
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <section class="panel">
                                <div class="panel-body">
                                    <h5><b>** Check the Checkbox if item is repaired</b></h5>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Asset Status</th>
                                                <th>Property Code</th>
                                                <th>Asset Model</th>
                                                <th>Building</th>
                                                <th>Room</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                        
                                            for ($i=0; $i < count($assets); $i++) { 

                                                
                                                $query3 =  "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', c.name as 'category', itemSpecification, s.id, m.description, b.name as 'building', f.floorroom
                                                        FROM asset a 
                                                            JOIN assetModel m
                                                        ON assetModel = assetModelID
                                                            JOIN ref_brand br
                                                        ON brand = brandID
                                                            JOIN ref_assetcategory c
                                                        ON assetCategory = assetCategoryID
                                                            JOIN ref_assetstatus s
                                                        ON a.assetStatus = s.id
                                                            JOIN assetassignment aa
                                                        ON a.assetID = aa.assetID
                                                            JOIN building b
                                                        ON aa.BuildingID = b.BuildingID
                                                            JOIN floorandroom f
                                                        ON aa.FloorAndRoomID = f.FloorAndRoomID 
                                                            WHERE a.assetID = {$assets[$i]};";

                                                $result3 = mysqli_query($dbc, $query3);  

                                                while ($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)){

                                                    $forRepair = "";
                                                    $falseReport = "";
                                                    $repaired = "";
                                                    $broken = "";

                                                    if($row['assetStatus']==9) $forRepair = "selected";
                                                    if($row['assetStatus']==22) $falseReport = "selected";
                                                    if($row['assetStatus']==23) $repaired = "selected";
                                                    if($row['assetStatus']==4) $broken = "selected";


                                                   echo "
                                                    <tr>
                                                    <td width = '200'>
                                                        <select name='assetStatus".$i."' class='form-control'>
                                                            <option value ='{$row['assetStatus']}'>Select Asset Status</option>
                                                            <option value='9' ".$forRepair.">For Repair</option>
                                                            <option value='22' ".$falseReport.">False Report</option>
                                                            <option value='23' ".$repaired.">Repaired</option>
                                                            <option value='4' ".$broken.">Broken - Not Fixable</option>
                                                        </select>
                                                    </td>
                                                    <td>{$row['propertyCode']}</td>
                                                    <td>{$row['brand']} {$row['category']} {$row['description']}</td>
                                                    <td>{$row['building']}</td>
                                                    <td>{$row['floorroom']}</td>
                                                    <td style = 'display: none'><input type='number' name='assetID[]' value ='{$row['assetID']}'></td>
                                                    </tr>";
                                                }  

                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                        </div>

                        <div class="col-sm-3">

                            <section class="panel">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked labels-info ">
                                        <li>
                                            <h4>Properties</h4>
                                        </li>
                                    </ul>
                                    <div class="form">
                                        
                                            <div class="form-group ">
                                                <div class="form-group ">
                                                    <label for="category" class="control-label col-lg-4">Category</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" disabled>
                                                            <option selected="selected">Repair</option>
                                                            <option>Repair</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="status" class="control-label col-lg-4">Status</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15" name="status" readonly>
                                                        <option value='1' <?php if($status=='1' ) echo "selected" ;?> >Open</option>
                                                        <option value='2' <?php if($status=='2' ) echo "selected" ;?> >Assigned</option>
                                                        <option value='3' <?php if($status=='3' ) echo "selected" ;?> >In Progress</option>
                                                        <option value='4' <?php if($status=='4' ) echo "selected" ;?> >Transferred</option>
                                                        <option value='5' <?php if($status=='5' ) echo "selected" ;?> >Escalated</option>
                                                        <option value='6' <?php if($status=='6' ) echo "selected" ;?> >Waiting For Parts</option>
                                                        <option value='7' <?php if($status=='7' ) echo "selected" ;?> >Closed</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="priority" class="control-label col-lg-4">Priority</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15" name="priority" readonly>
                                                        <option value="Low" <?php if($priority=='Low' ) echo "selected" ;?> >Low</option>
                                                        <option value="Medium" <?php if($priority=='Medium' ) echo "selected" ;?> >Medium</option>
                                                        <option value="High" <?php if($priority=='High' ) echo "selected" ;?> >High</option>
                                                        <option value="Urgent" <?php if($priority=='Urgent' ) echo "selected" ;?> >Urgent</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-4">Escalate To</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15" name="escalateUserID" id='escalateUser'>
                                                        <option value='<?php echo $userID;?>'>None</option>
                                                        <?php
                                                            $query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer';";
                                                            $result3=mysqli_query($dbc,$query3);
                                                                    
                                                            while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
                                                                //if($assigneeUserID == $row3['UserID']){
                                                                    //echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
                                                                //}
																if($assigneeUserID != $row3['UserID']){
                                                                   echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
                                                                }    
                                                            }   
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Due Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="<?php echo $dueDate;?>" disabled>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-sm-12">

                            <section class="panel">
                                <div class="panel-body">
                                    <h5><b>Modifications done</b></h5>
                                    <p>Select the action performed for each asset component</p>
                                    
                                    <table class="table table-hover" name="modifications" id="modifications">
                                        <thead>
                                            <tr>
                                                <th>Source</th>
                                                <th>Property Code</th>
                                                <th>Asset Model</th>
                                                <th>Action</th>
                                                <th>Destination</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                        
                                            for ($i=0; $i < count($components); $i++) { 

                                                //display the components
                                                $query3 =  "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', c.name as 'category', itemSpecification, m.description
                                                    FROM asset a 
                                                        JOIN assetModel m
                                                    ON assetModel = assetModelID
                                                        JOIN ref_brand br
                                                    ON brand = brandID
                                                        JOIN ref_assetcategory c
                                                    ON assetCategory = assetCategoryID
                                                        WHERE a.assetID = {$components[$i]};";

                                                $result3 = mysqli_query($dbc, $query3);  
                                                
                                                while ($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)){

                                                //display source
                                                $querySource =  "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', c.name as 'category', itemSpecification, m.description
                                                    FROM asset a 
                                                        JOIN assetModel m
                                                    ON assetModel = assetModelID
                                                        JOIN ref_brand br
                                                    ON brand = brandID
                                                        JOIN ref_assetcategory c
                                                    ON assetCategory = assetCategoryID
                                                        WHERE a.assetID = '{$source[$i]}';";

                                                $resultSource = mysqli_query($dbc, $querySource); 
                                                $rowSource = mysqli_fetch_array($resultSource, MYSQLI_ASSOC);

                                                   echo "
                                                    <tr>
                                                    <td>{$rowSource['propertyCode']}</td>
                                                    <td>{$row['propertyCode']}</td>
                                                    <td>{$row['brand']} {$row['category']} {$row['description']}</td>
                                                    <td>
                                                        <select class='form-control form-control-inline' name='actionID[]'>
                                                            <option value='0'>None</option>
                                                            <option value='2'>Removed</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class='form-control form-control-inline' name='destinationID[]'>
                                                            <option value='0'>None</option>";

                                                    echo
                                                        "</select>
                                                    </td>
                                                    <td style = 'display: none'><input type='number' name='assets[]' value ='{$row['assetID']}'></td>
                                                    <td style = 'display: none'><input type='number' name='sourceID[]' value ='{$source[$i]}'></td>
                                                    </tr>";
                                                }  

                                            }
                                            ?>
                                            <?php
                                                        
                                                //display requested parts
                                                $query3 =  "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', c.name as 'category', itemSpecification, m.description
                                                    FROM requestparts_assets ra
                                                        JOIN asset a 
                                                    ON ra.assetID = a.assetID
                                                        JOIN assetModel m
                                                    ON assetModel = assetModelID
                                                        JOIN ref_brand br
                                                    ON brand = brandID
                                                        JOIN ref_assetcategory c
                                                    ON assetCategory = assetCategoryID
                                                        JOIN requestparts rp
                                                    ON ra.requestPartsID = rp.id
                                                        WHERE rp.serviceID = {$serviceID}
                                                    AND rp.statusID = 3;"; // only show delivered items
                                                
                                                $result3 = mysqli_query($dbc, $query3);  

                                                if (mysqli_num_rows($result3)>0)
                                                {
                                                    while ($row = mysqli_fetch_array($result3, MYSQLI_ASSOC))
                                                    {


                                                   echo "
                                                    <tr>
                                                    <td>Requested Part</td>
                                                    <td>{$row['propertyCode']}</td>
                                                    <td>{$row['brand']} {$row['category']} {$row['description']}</td>
                                                    <td>
                                                        <select class='form-control form-control-inline' name='actionID[]'>
                                                            <option value='0'>None</option>
                                                            <option value='1'>Added</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class='form-control form-control-inline' name='destinationID[]'>
                                                            <option value='0'>Action</option>";

                                                    for ($j=0; $j < count($assets); $j++) { 
                                                        $queryCompound =  "SELECT assetStatus, a.assetID, propertyCode, br.name AS 'brand', c.name as 'category', itemSpecification, s.id, m.description, b.name as 'building', f.floorroom
                                                            FROM asset a 
                                                                JOIN assetModel m
                                                            ON assetModel = assetModelID
                                                                JOIN ref_brand br
                                                            ON brand = brandID
                                                                JOIN ref_assetcategory c
                                                            ON assetCategory = assetCategoryID
                                                                JOIN ref_assetstatus s
                                                            ON a.assetStatus = s.id
                                                                JOIN assetassignment aa
                                                            ON a.assetID = aa.assetID
                                                                JOIN building b
                                                            ON aa.BuildingID = b.BuildingID
                                                                JOIN floorandroom f
                                                            ON aa.FloorAndRoomID = f.FloorAndRoomID 
                                                                WHERE a.assetID = {$assets[$j]}
                                                            AND (assetCategory = 13 OR assetCategory = 46 OR assetCategory = 40);";

                                                        $resultCompound = mysqli_query($dbc, $queryCompound); 
                                                                
                                                        while ($rowCompound = mysqli_fetch_array($resultCompound, MYSQLI_ASSOC)){

                                                            echo "<option value='{$rowCompound['assetID']}'>{$rowCompound['propertyCode']}</option>";
                                                        }
                                                    }

                                                    echo
                                                        "</select>
                                                    </td>
                                                    <td style = 'display: none'><input type='number' name='assets[]' value ='{$row['assetID']}'></td>
                                                    <td style = 'display: none'><input type='number' name='sourceID[]' value ='0'></td>
                                                    </tr>";
                                                    }  
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                        </div>

                        <div class="col-sm-12">
                            <section class="panel">
                                <div class="panel-body ">

                                    <div>
                                        <h4>Comments</h4>
                                    </div>
                                    <div class="view-mail">
                                        <textarea class="form-control" style="resize:none" rows="5" name="comment"><?php echo $comment;?></textarea>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <hr>
                        <div class="col-sm-12">
                            <section class="panel">
                                <div class="panel-body ">
                                    <div>
                                        <h4><h4>Request For Parts (if needed)</h4></h4>
                                    </div>

                                    <table class="table table-bordered table table-hover" id="addtable">
                                    <thead>
                                        <tr>
                                            <th style="display: none">AssetID</th>
                                            <th width="150">Quantity</th>
                                            <th>Category</th>
                                            <th>Specification</th>
                                            <th>Delivery Status</th>
                                            <th>Add Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $checkExistingReqeust = "SELECT * FROM thesis.requestparts WHERE serviceID = '{$serviceID}';";
                                            $resultExistingRequest = mysqli_query($dbc, $checkExistingReqeust); 

                                        if(mysqli_num_rows($resultExistingRequest) == 0) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type='number' min='0' step='1' class='form-control' name='quantity0'>
                                            </td>
                                            <td width="300">
                                                <select class="form-control" name = "category0">
                                                    <option>Select Category</option>
                                                    <option value="2">Accessories</option>
                                                    <option value="3">Adapter</option>
                                                    <option value="6">Batery</option>
                                                    <option value="16">Hard Disk Drive (External)</option>
                                                    <option value="17">Hard Disk Drive (Internal)</option>
                                                    <option value="18">Keyboard</option>
                                                    <option value="19">LAN Card</option>
                                                    <option value="22">Memory</option>
                                                    <option value="23">Monitor</option>
                                                    <option value="24">Motherboard</option>
                                                    <option value="25">Mouse</option>
                                                    <option value="28">Non-IT Equipment</option>
                                                    <option value="29">Optical Drive (External)</option>
                                                    <option value="30">Optical Drive (Internal)</option>
                                                    <option value="32">Power Supply</option>
                                                    <option value="34">Processor</option>
                                                    <option value="49">Video Card</option>
                                                    <!-- 
                                                    <?php 

                                                        $sql = "SELECT * FROM thesis.ref_assetcategory;";

                                                        $result = mysqli_query($dbc, $sql);

                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetCategoryID']}>";
                                                            echo "{$row['name']}</option>";
                                                        }

                                                    ?>
                                                     -->
                                                </select>
                                            </td>
                                            <td>
                                                <input class='form-control' name='specification0'>
                                            </td>
                                            <td>
                                                <select class="form-control" id="delivery" name="delivery" readonly>
                                                    <option value="0">Pending</option>
                                                </select>
                                            </td>
                                            <td style="text-align:center" width='10px'><button class="btn btn-primary" type="button" onclick="addTest(1)">Add</button></td>
                                        </tr>
                                        <?php } ?>
                                        <?php 

                                        $sql = "SELECT *, rpd.id as 'detailsID' FROM thesis.requestparts_details rpd JOIN requestparts rp ON rpd.requestPartsID = rp.id WHERE serviceID = '{$serviceID}';";
                                        $result = mysqli_query($dbc, $sql);
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {

                                            $delivered = ""; 
                                            $pending = "";
                                            $readonly = "";
                                            $specs = $row['specifications'];
                                            if($row['received'] == 1){
                                                $delivered = "selected";
                                                $readonly = "readonly";
                                            }
                                            else{
                                                $pending = "selected";
                                            }
                                            echo
                                            "<tr>
                                                <td style='display: none'><input type='number' name='detailsID[]' value ='{$row['detailsID']}'></td>
                                                <td>
                                                    <input type='number' min='0' step='1' class='form-control' name='quantity' value =  '{$row['quantity']}'readonly>
                                                </td>
                                                <td width='300'>
                                                    <select class='form-control' name = 'category' readonly>";
                                                        

                                                            $sqlCategory = "SELECT * FROM thesis.ref_assetcategory WHERE assetCategoryID = '{$row['assetCategoryID']}';";

                                                            $resultCategory = mysqli_query($dbc, $sqlCategory);

                                                            while ($rowCategory = mysqli_fetch_array($resultCategory, MYSQLI_ASSOC))
                                                            {
                                                                echo "<option value ={$rowCategory['assetCategoryID']}>";
                                                                echo "{$rowCategory['name']}</option>";
                                                            }

                                                        
                                            echo    
                                                    "</select>
                                                </td>
                                                <td>
                                                    <input class='form-control' name='specification' value= '".$specs."' readonly>
                                                </td>
                                                <td>
                                                    <select class='form-control' id='deliveryStatus' name='deliveryStatus[]' ".$readonly.">
                                                        <option value='0'".$pending.">Pending</option>
                                                        <option value='1'".$delivered.">Delivered</option>
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <input style="display: none" type="number" id="count" name = "count">
                                </div>
                            </section>
                            <button type="submit" name="submit" id="submit" class="btn btn-success">Send</button>
                            <a href="engineer_all_ticket.php"><button type="button" class="btn btn-danger">Back</button></a>
                        </form>
                    </div>

                    </div>
                    <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>

    
        <script type="text/javascript">
        var count = 0; 
        function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
		
        function addTest(cavasItemID) {
            var row_index = 0;
            var canvasItemID = cavasItemID;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 0; //1 second

            setTimeout(function() {

                appendTableRow(row_index, canvasItemID);
            }, delayInMilliseconds);

        }


				
        var appendTableRow = function(rowCount, clicks) {
            count++;
            $("#count").val(count);
            var tr = "<tr>" +
                "<td><input type='number' min='0' step='1' class='form-control' name='quantity"+ count +"'></td>" +
                "<td><select class='form-control' name='category"+ count +"'><option>Select Category</option><option value='2'>Accessories</option><option value='3'>Adapter</option><option value='6'>Batery</option><option value='16'>Hard Disk Drive (External)</option><option value='17'>Hard Disk Drive (Internal)</option><option value='18'>Keyboard</option><option value='19'>LAN Card</option><option value='22'>Memory</option><option value='23'>Monitor</option><option value='24'>Motherboard</option><option value='25'>Mouse</option><option value='28'>Non-IT Equipment</option><option value='29'>Optical Drive (External)</option><option value='30'>Optical Drive (Internal)</option><option value='32'>Power Supply</option><option value='34'>Processor</option><option value='49'>Video Card</option>"

				+ "</select></td>" +
                "<td><input class='form-control' name='specification"+ count +"'></td>" +
                "<td><select class='form-control' name='deliveryStatus[]"+ count +"' id='deliveryStatus'><option value='0'>Pending</option><option value='1'>Delivered</option></td>" +
                "<td style='text-align:center'><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#addtable tbody tr').eq(rowCount).after(tr);

        } 
    </script>

    <script>
        function addModification(modificationID) {
            var row_index = 0;
            var modificationID = modificationID;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 0; //1 second


            setTimeout(function() {

                appendTableRow1(row_index, modificationID);
            }, delayInMilliseconds);

        }

        var appendTableRow1 = function(rowCount, clicks) {

            count++;

            $("#count").val(count);

            var tr = "<tr>" +
                "<td><input type='text' class='form-control' name='sourceDestination"+ count +"'></td>"
                +
                "<td><input type='text' class='form-control' name='propertyCode"+ count +"'></td>" 
                +
                "<td><input type='text' class='form-control' name='assetModel"+ count +"'></td>"
                +
                "<td><select clsas='form-control' name='action"+ count +"'> <option>Action</option> <option value='1'>Added</option> <option value='0'> Removed </option> </td>"
                +
                "</tr>";

            $('#modifications tbody tr').eq(rowCount).after(tr);

        }
    </script>

    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>