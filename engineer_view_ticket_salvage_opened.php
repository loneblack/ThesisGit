<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$userid=$_SESSION['userID'];
	$ticketID=$_GET['id'];

	$que1="SELECT e.name AS requestedName FROM employee e JOIN user u  on e.UserID = u.UserID
	JOIN ticket t ON u.UserID = t.requestedBy WHERE t.ticketID='{$ticketID}'";
	$res1=mysqli_query($dbc,$que1);
	$row0=mysqli_fetch_array($res1,MYSQLI_ASSOC);

    $que2="SELECT t.dueDate AS dueDate FROM ticket t WHERE t.ticketID='{$ticketID}'";
	$res2=mysqli_query($dbc,$que2);
	$row66=mysqli_fetch_array($res2,MYSQLI_ASSOC);


    
		
		if(!isset($message)){
			$message = "Form submitted!";
			$_SESSION['submitMessage'] = $message; 
		}
	
	
	
?>
<html lang="en">

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
                <?php
                    if (isset($_SESSION['submitMessage']) && $_SESSION['submitMessage']=="Form submitted!"){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
					elseif(isset($_SESSION['submitMessage'])){
						 echo "<div class='alert alert-danger'>
                                {$_SESSION['submitMessage']}
							  </div>";
						 unset($_SESSION['submitMessage']);
					}
				?>
                <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="row">
                                <div class="col-sm-9">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Asset Testing Checklist
                                        </header>
                                        <div class="panel-body">

                                            <div class="panel-body">
                                                <section>
                                                    <label>
                                                        <h5>Requestor Name:</h5>
                                                    </label><input type="text" value="<?php echo $row0['requestedName']; ?>" class="form-control" disabled>
                                                    <br>
                                                    <h5>** Instructions: Check the checkbox of all working assets after testing and click Submit</h5>
                                                </section>
                                            </div>

                                            <section>
                                                <br>
                                            </section>

                                            <section id="unseen">
                                                <?php
                                                $query = "SELECT a.assetID, a.propertyCode, rac.name, ras.description  FROM asset a 
                                                            JOIN assetmodel am ON a.assetmodel = am.assetmodelID 
                                                            JOIN ref_assetstatus ras ON a.assetStatus = ras.id
                                                            JOIN ref_assetcategory rac ON am.assetCategory = rac.assetCategoryID 
                                                            JOIN salvage_details sd ON a.assetID = sd.asset_assetID
                                                            JOIN ticket t ON sd.salvageID = t.salvage_id
																where t.ticketID='{$ticketID}'";
                                                $result = mysqli_query($dbc, $query);
                                                
                                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                                    $aid = $row['assetID'];
                                                    echo "<h4>Property Code: {$row['propertyCode']}</h4>
                                                            <h4>Item Category: {$row['name']}</h4>
                                                            <table class='table table-bordered table-striped table-condensed table-hover' id='tableTest'>
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Property Code</th>
                                                                        <th>Brand</th>
                                                                        <th>Model</th>
                                                                        <th>Category</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                    ";   
                                                    $query2 = "SELECT cc.assetID, refac.name as assetCat, refb.name as brandName, assetm.description as assetModel, assetTable.propertyCode
                                                    FROM thesis.asset a 
                                                    join computer c on a.assetID = c.assetID
                                                    join computercomponent cc on c.computerID = cc.computerID
                                                    join asset assetTable on cc.assetID = assetTable.assetID
                                                    join assetmodel assetm on assetTable.assetModel = assetm.assetModelID
                                                    join ref_brand refb on assetm.brand = refb.brandID
                                                    join ref_assetcategory refac on assetm.assetCategory = refac.assetCategoryID
                                                    where c.assetID = {$aid};";  
                                                    $result1 = mysqli_query($dbc, $query2);
                                                    
                                                    while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
                                                    echo"
                                                        <td style='width:7px; text-align:center'><input type='checkbox' class='form-check-input' name='mark[]' id='exampleCheck1' value='{$row['assetID']}'></td>
                                                        <td>{$row['propertyCode']}</td>
                                                        <td>{$row['brandName']}</td>
                                                        <td>{$row['assetModel']}</td>
                                                        <td>{$row['assetCat']}</td>
                                                        </tr>
                                                    ";
                                                    }
                                                    echo "</tbody>
                                                        </table>";
                                                }
                                                
                                                ?>
<!--                                               tttttttttttttttttttttttttttttttttttttttttttttttt-->



                                                <div>
                                                    <button onclick="return confirm('Confirm checklist?')" type="submit" name="save" id="save" class="btn btn-success" data-dismiss="modal">Submit</button>
                                                    <!-- <button onclick="return confirm('Confirm checklist?')" type="button" class="btn btn-success" data-dismiss="modal">Save</button> -->
                                                    <a href="engineer_all_ticket.php"><button type="button" class="btn btn-danger" data-dismiss="modal">Back</button></a>
                                                </div>
                                                
                                                
                                            </section>
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
                                                        <label style="padding-left:22px" for="category" class="control-label col-lg-4">Category</label>
                                                        <div class="col-lg-8" style="padding-right:30px">
                                                            <select class="form-control m-bot15" name="category" disabled>
                                                                <?php
																	$query2 = "SELECT * FROM thesis.ref_servicetype";
																	$result2 = mysqli_query($dbc, $query2);
																	while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
																		if($row2['id']==29){
																			echo "<option selected value='{$row2['id']}'>{$row2['serviceType']}</option>";
																		}
																		else{
																			echo "<option value='{$row2['id']}'>{$row2['serviceType']}</option>";
																		}
																	}
																
																?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <label for="status" class="control-label col-lg-4">Status</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status']) && !$flag) echo $_POST['status']; ?>" disabled>
                                                            <?php
																$query1 = "SELECT * FROM thesis.ref_ticketstatus";
																$result1 = mysqli_query($dbc, $query1);
																while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
																	if($row1['ticketID']==2){
																		echo "<option disabled selected value='{$row1['ticketID']}' >{$row1['status']}</option>";
																	}
																	else{
																		echo "<option value='{$row1['ticketID']}'>{$row1['status']}</option>";
																	}
																}

															
															?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="priority" class="control-label col-lg-4">Priority</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" id="priority" name="priority" value="<?php if (isset($_POST['priority']) && !$flag) echo $_POST['priority']; ?>" disabled>
                                                            <option value="">Select Priority</option>
															<?php
																if($rowOut['priority']=='Low'){
																	echo "  <option value='Low' selected>Low</option>
																			<option value='Medium'>Medium</option>
																			<option value='High'>High</option>
																			<option value='Urgent'>Urgent</option>";
																}
																elseif($rowOut['priority']=='Medium'){
																	echo "  <option value='Low'>Low</option>
																			<option value='Medium' selected>Medium</option>
																			<option value='High'>High</option>
																			<option value='Urgent'>Urgent</option>";
																}
																elseif($rowOut['priority']=='High'){
																	echo "  <option value='Low'>Low</option>
																			<option value='Medium'>Medium</option>
																			<option value='High' selected>High</option>
																			<option value='Urgent'>Urgent</option>";
																}
																elseif($rowOut['priority']=='Urgent'){
																	echo "  <option value='Low' selected>Low</option>
																			<option value='Medium'>Medium</option>
																			<option value='High'>High</option>
																			<option value='Urgent' selected>Urgent</option>";
																}
															?>
                                                            
                                                        </select>
                                                    </div>
                                                </div>

                                                

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Due Date</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control form-control-inline input-medium default-date-picker" name="dueDate" size="10" type="text" value="<?php echo $row66['dueDate']; ?>" disabled/>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </section>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->


    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script type="text/javascript">
		function checkValue(x) {
			
			var disapp = "Disapp_" + x;
			var working = "Working_" + x
			var forEsc = "ForEsc_" + x;
			var escEng = "escalateEng_" + x;
			var selectID = "assetStatus_" + x;
			
			//Working stat
			if(document.getElementById(selectID).value == "1"){
				//comments
				document.getElementById(x).disabled = true;
				
				//for asset stat
				document.getElementById(forEsc).disabled = true;
                
				//for esc engineer
				document.getElementById(escEng).disabled = true;
			}
			//Escalate stat
            else if(document.getElementById(selectID).value == "2"){
				//comments
				document.getElementById(x).disabled = true;
				
				//for asset stat
				document.getElementById(forEsc).disabled = false;
				
				//for esc engineer
				document.getElementById(escEng).disabled = false;
				
            }
			else{
				//comments
				document.getElementById(x).disabled = false;
				
				//for asset stat
				document.getElementById(forEsc).disabled = true;
				
				//for esc engineer
				document.getElementById(escEng).disabled = true;
				
            }
        }
		
        $('#save').click(function() {
            var isExist = false;
            for (var i = 0; i < document.getElementsByClassName("comments").length; i++) {
                if (document.getElementsByClassName("comments")[i].value == '' && !document.getElementsByClassName("comments")[i].disabled) {
                    isExist = true;
                }
            }
            if (isExist) {
                document.getElementById("priority").required = true;
                document.getElementById("escalate").required = true;
            } else {
                document.getElementById("priority").required = false;
                document.getElementById("escalate").required = false;
            }
        });
    </script>




</body>

</html>