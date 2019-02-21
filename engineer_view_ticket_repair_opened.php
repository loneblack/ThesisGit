<!DOCTYPE html>
<html lang="en">
<?php
session_start();

$id = $_GET['id'];
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


    }
$assets = array();

$query2 =  "SELECT * FROM thesis.ticketedasset WHERE ticketID = {$id};";
$result2 = mysqli_query($dbc, $query2);

while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
    array_push($assets, $row['assetID']);
}

?>
<?php
// Insertion to ticket
    
    if(isset($_POST['submit'])){
		
        $status=$_POST['status'];
	
        //if($_POST['escalateUserID']=='0')
        //$assigneeUserID="NULL";
        $priority=$_POST['priority'];
        $currDate=date("Y-m-d H:i:s");
		
		
		//GET SERVICEID
		$queryServID="SELECT * FROM thesis.ticket where ticketID='{$id}'";
		$resultServID=mysqli_query($dbc,$queryServID);
		$rowServID=mysqli_fetch_array($resultServID,MYSQLI_ASSOC);
		
		//For repaired assets
		if(!empty($_POST['repAsset'])){
			$repAsset=$_POST['repAsset'];
			foreach($repAsset as $value){
				$query5="UPDATE `thesis`.`ticketedasset` SET `checked`=1 WHERE `ticketID`='{$id}' and `assetID`='{$value}'";
				$result5=mysqli_query($dbc,$query5);
			}
		}
		
		//For escalation
		if(isset($_POST['escalateUserID'])&&isset($_POST['forEscAsset'])){
			$forEscAsset=$_POST['forEscAsset'];
			$escalateUserID=$_POST['escalateUserID'];
			//GET TICKET DATA
			$queryTickDat="SELECT * FROM thesis.ticket where ticketID='{$id}'";
			$resultTickDat=mysqli_query($dbc,$queryTickDat);
			$rowTickDat=mysqli_fetch_array($resultTickDat,MYSQLI_ASSOC);
			
			//CREATE TICKET FOR ESCALATION
			$queryEsc="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `summary`, `details`, `description`, `serviceType`, `service_id`) VALUES ('5', '{$escalateUserID}', '{$_SESSION['userID']}', now(), now(), '{$rowTickDat['dueDate']}', '{$priority}', '{$rowTickDat['summary']}', '{$rowTickDat['details']}', '{$rowTickDat['description']}', '27', '{$rowTickDat['service_id']}')";
			$resultEsc=mysqli_query($dbc,$queryEsc);
			
			//GET LATEST TICKET
			$queryLatTic="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
			$resultLatTic=mysqli_query($dbc,$queryLatTic);
			$rowLatTic=mysqli_fetch_array($resultLatTic,MYSQLI_ASSOC);
						
			//INSERT TO TICKETEDASSET
			foreach($forEscAsset as $escAsset){
				$queryTicAss="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$rowLatTic['ticketID']}', '{$escAsset}');";
				$resultTicAss=mysqli_query($dbc,$queryTicAss);
								
				//DELETE ASSET TO TICKETEDASSET
				$queryDelTic="DELETE FROM `thesis`.`ticketedasset` WHERE `ticketID`='{$id}' and `assetID`='{$escAsset}'";
				$resultDelTic=mysqli_query($dbc,$queryDelTic);
			}
		}
		
		//Request for parts code
		if(!empty($_POST['model'])){
			$model=$_POST['model'];
			$quantity=$_POST['quantity'];
			foreach (array_combine($model, $quantity) as $mod => $qty){
				$queryReqPart="INSERT INTO `thesis`.`requestparts` ( `serviceID`, `assetModelID`, `quantity`) VALUES ('{$rowServID['service_id']}', '{$mod}' ,'{$qty}')";
				$resultReqPart=mysqli_query($dbc,$queryReqPart);
				
				$querya="UPDATE `thesis`.`ticket` 
				SET `status` = '6',
				WHERE (`ticketID` = '{$id}');";
				$resulta=mysqli_query($dbc,$querya);
				
			}
		}
        
		//Check if all assets are repaired
		
		//GET QTY of Assets of a Ticket
		$queryTicketed="SELECT count(ticketID) as `numAssets`, count(IF(checked = 1, ticketID, null)) as `repairedAssets` FROM thesis.ticketedasset where ticketID='{$id}'";
		$resultTicketed=mysqli_query($dbc,$queryTicketed);
		$rowTicketed=mysqli_fetch_array($resultTicketed,MYSQLI_ASSOC);
		
		//GET QTY of Assets of a SERVICE
		$queryService="SELECT count(ta.ticketID) as `numAssets`, count(IF(checked = 1, ta.ticketID, null)) as `repairedAssets` FROM thesis.ticketedasset ta join ticket t on ta.ticketID=t.ticketID where t.service_id='{$rowServID['service_id']}'";
		$resultService=mysqli_query($dbc,$queryService);
		$rowService=mysqli_fetch_array($resultService,MYSQLI_ASSOC);
		
		//UPDATE SERVICE STATUS (STILL NEEDS TO BE FIXED)
		if($rowService['numAssets']==$rowService['repairedAssets']){
			$queryComp="UPDATE `thesis`.`service` SET `steps`='11' WHERE `id`='{$rowServID['service_id']}'";
			$resultComp=mysqli_query($dbc,$queryComp);
		}
		
		//UPDATE TICKET
		

        //if(!isset($message)){


        //$querya="UPDATE `thesis`.`ticket` 
        //SET `status` = '{$status}',
        //`assigneeUserID` = {$assigneeUserID},
        //`dateClosed` = '{$currDate}',
        //`priority` = '{$priority}'
        //WHERE (`ticketID` = '{$id}');";
        //$resulta=mysqli_query($dbc,$querya);
		
		//UPDATE TICKET STATUS 
		if($rowTicketed['numAssets']==$rowTicketed['repairedAssets']){
			$queryTickUp="UPDATE `thesis`.`ticket` SET `status`='7',`dateClosed` = '{$currDate}' WHERE `ticketID`='{$id}'";
			$resultTickUp=mysqli_query($dbc,$queryTickUp);
		}
		
        $message = "Ticket Updated!";
        $_SESSION['submitMessage'] = $message;
        }
        
    //}
    
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
						<form class="cmxform form-horizontal " id="signupForm" method="post" action="">
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
                                                <h5>Summary:
                                                    <?php echo $summary;?>
                                                </h5>
                                            </div>
                                            <div class="cp;-col-md-4"></div>
                                        </div>
                                    </div>
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
                                                <th style="width:50px"></th>
                                                <th>Property Code</th>
                                                <th>Asset/ Software Name</th>
                                                <th>Building</th>
                                                <th>Room</th>
                                                <th>Asset Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                        
                                            for ($i=0; $i < count($assets); $i++) { 
                                                
                                                
                                                $query3 =  "SELECT a.assetID, propertyCode, br.name AS 'brand', c.name as 'category', itemSpecification, s.id, m.description, b.name as 'building', f.floorroom
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

                                                   echo "<tr>
                                                    <td><input type='checkbox'></td>
                                                    <td>{$row['propertyCode']}</td>
                                                    <td>{$row['brand']} {$row['category']} {$row['description']}</td>
                                                    <td>{$row['building']}</td>
                                                    <td>{$row['floorroom']}</td>
                                                    <td>
                                                        <select name='assetStatus' class='form-control'>
                                                            <option>Select Asset Status</option>
                                                        </select>
                                                    </td>
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
                                                        <option value=''>None</option>
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
                                <div class="panel-body ">

                                    <div>
                                        <h4>Comments</h4>
                                    </div>
                                    <div class="view-mail">
                                        <textarea class="form-control" style="resize:none" rows="5" name="comment"></textarea>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-sm-12">
                            <section class="panel">
                                <div class="panel-body ">
                                    <div>
                                        <h4><h4>Request For Parts (if needed)</h4></h4>
                                    </div>

                                    <table class="table table-bordered table table-hover" id="addtable">
                                    <thead>
                                        <tr>
                                            <th>Quantity</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Add Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type='number' min='0' step='1' class='form-control' name='quantity[]'>
                                            </td>
                                            <td>
                                                <select class="form-control">
                                                    <option>Select Category</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control">
                                                    <option>Select Brand</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control">
                                                    <option>Select Model</option>
                                                </select>
                                            </td>
                                            <td style="text-align:center"><button class="btn btn-primary" type="button" onclick="addTest(1)">Add</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </section>
                            <button type="submit" name="submit" id="submit" class="btn btn-success">Send</button></a>
                            <a href="helpdesk_all_ticket.php"><button type="button" class="btn btn-danger">Back</button></a>
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

    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
        var count = 0; 
        function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
		
		$('#submit').click(function () {
			var isEscEmpty = true;
			for(var i=0;i<document.getElementsByClassName("forEsc").length;i++){
				if(document.getElementsByClassName("forEsc")[i].checked == true){
					isEscEmpty = false;
				}
			}
			
			if(isEscEmpty==false){
				document.getElementById("escalateUser").required = true;
			}
			else{
				document.getElementById("escalateUser").required = false;
			}
			
		});
		
		function repairCheck(checkbox) {
			if(checkbox.checked == true){
				var code = checkbox.id;
				var res = code.split("_");
				
				var code1="myCheckEsc_" + res[1];
				document.getElementById(code1).checked = false;
			}
        }
		
		function forEscCheck(checkbox) {
			if(checkbox.checked == true){
				var code = checkbox.id;
				var res = code.split("_");
				
				var code1="myCheckRep_" + res[1];
				document.getElementById(code1).checked = false;
			}
        }
		
        function addTest(cavasItemID) {
			count++;
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
						
		function getBrand(clicks){
			var code = "brand" + clicks;
			var code1 = "category" + clicks;
			var category=document.getElementById(code1).value;
			var cat=parseInt(category);
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById(code).innerHTML = this.responseText;
			}
			};
			xmlhttp.open("GET", "brand_ajax.php?category=" + cat, true);
			xmlhttp.send();
							
		}
		function getModel(clicks){
			var code1 = "category" + clicks;
			var code2 = "brand" + clicks;
			var code3 = "model" + clicks;
			var category=document.getElementById(code1).value;
			var brand=document.getElementById(code2).value;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById(code3).innerHTML = this.responseText;
			}
			};
			xmlhttp.open("GET", "model_ajax.php?category=" + category + "&brand=" + brand, true);
			xmlhttp.send();
							
		}
		
        var appendTableRow = function(rowCount, clicks) {
            //count++;
            var tr = "<tr>" +
                "<td><input type='number' min='0' step='1' class='form-control' name='quantity[]'></td>" +
                "<td><select class='form-control' id='category"+clicks+"' name='category[]' onchange='getBrand(\"" + clicks + "\")'><option>Select Category</option>" +
				'<?php 
					$sql = "SELECT * FROM thesis.ref_assetcategory;";

                    $result = mysqli_query($dbc, $sql);

                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                        {   
                            echo "<option value ={$row['assetCategoryID']}>";
                            echo "{$row['name']}</option>";
                        }
				
				
				
				?>'
				+ "</select></td>" +
                "<td><select class='form-control' id='brand"+clicks+"' name='brand[]' onchange='getModel(\"" + clicks + "\")'><option>Select Brand</option></select></td>" +
                "<td><select class='form-control' id ='model"+clicks+"' name='model[]'><option>Select Model</option></select></td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#addtable tbody tr').eq(rowCount).after(tr);
			
        }
		
		var myInput = document.getElementById("customx");
			if (myInput && myInput.value) {
				alert("My input has a value!");
		}
        
        
    </script>

    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>