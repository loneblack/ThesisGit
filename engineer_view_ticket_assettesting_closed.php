<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$userid=$_SESSION['userID'];
	$ticketID=$_GET['id'];

	//GET ALL TICKET DATA
	$queryOut = "SELECT *,t.dueDate,t.priority,e.name as `empName` FROM thesis.ticket t join assettesting at on t.testingID=at.testingID 
											join user u on t.requestedBy=u.UserID
											join employee e on u.UserID=e.UserID
											where t.ticketID='{$ticketID}'";
    $resultOut = mysqli_query($dbc, $queryOut);
	$rowOut = mysqli_fetch_array($resultOut, MYSQLI_ASSOC);
	
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
                                                    <h5>Name:</h5>
                                                </label><input type="text" value="<?php echo $rowOut['empName']; ?>" class="form-control" disabled>
                                                <br>

                                            </section>
                                        </div>

                                        <section>
                                            <br>
                                        </section>
                                        <section id="unseen">
                                            <table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center">Brand</th>
                                                            <th style="text-align:center">Model</th>
                                                            <th>Asset Status</th>
															<th style="text-align:center">Comments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
														$query = "SELECT atd.check,atd.comment,atd.asset_assetID as `assetID`,rb.name as `brand`, am.description as `model` FROM thesis.assettesting_details atd join assettesting at on atd.assettesting_testingID=at.testingID 
																	  join ticket t on at.testingID=t.testingID
																	  join asset a on atd.asset_assetID=a.assetID
																	  join assetmodel am on a.assetModel=am.assetModelID
																	  join ref_brand rb on am.brand=rb.brandID
																	  where t.ticketID='{$ticketID}'";
                                                                  
														$result = mysqli_query($dbc, $query);
                                                    
														while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
															$idDisapp="Disapp_".$row['assetID'];
															$idWorking="Working_".$row['assetID'];
															$idForEsc="ForEsc_".$row['assetID'];
															$idEscEng="escalateEng_".$row['assetID'];
															echo "<tr>
																<td style='text-align:center'>{$row['brand']}</td>
																<td style='text-align:center'>{$row['model']}</td>
																<td>
																	<select id='assetStatus_".$row['assetID']."' name='testStat[]' class='form-control' onchange='checkValue(\"{$row['assetID']}\")' required disabled>";
																		if($row['check']=='1'){
																			echo "<option value='1'>Working</option>";
																		}
																		else{
																			echo "<option value='3'>Defective</option>";
																		}
																		
																echo "</select>
																</td>
																<td><input style='text' id='{$row['assetID']}' name='comments[]' value='{$row['comment']}' class='form-control comments' disabled></td>
																<input type='hidden' id='{$idDisapp}' name='disapprovedAsset[]' value='{$row['assetID']}'>
																<input type='hidden' id='{$idWorking}' name='workingAsset[]' value='{$row['assetID']}'>
																<input type='hidden' id='{$idForEsc}' name='forEscAsset[]' value='{$row['assetID']}'>
																<input type='hidden' name='listOfTestAss[]' value='{$row['assetID']}'>
																</tr>";
														}
													
													
													
													
													
													?>
                                                        <!-- <tr>
                                                           
                                                            <td style="text-align:center">Apple Tablet</td>
                                                            <td style="text-align:center">iPad</td>
                                                            
                                                            <td>
                                                                <select id="assetStatus" class="form-control" onchange="checkValue()">
                                                                    <option value="0">Select Asset Status</option>
                                                                    <option value="1">Working</option>
                                                                    <option value="2">Escalated To</option>
                                                                    <option value="3">Defective</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" id="escalateEng" disabled>
                                                                    <option value="0">Select Engineer</option>
                                                                </select>
                                                            </td>
															<td><input style="text" class="form-control"></td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>




                                            <div>
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
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                                <div class="form-group ">
                                                    <div class="form-group ">
                                                        <label style="padding-left:22px" for="category" class="control-label col-lg-4">Category</label>
                                                        <div class="col-lg-8" style="padding-right:30px">
                                                            <select class="form-control m-bot15" name="category" disabled>
                                                                <?php
																	$query2 = "SELECT * FROM thesis.ref_servicetype";
																	$result2 = mysqli_query($dbc, $query2);
																	while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
																		if($row2['id']==25){
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

                                                            <!--<option>Assigned</option>
															<option>In Progress</option>
															<option selected="selected">Transferred</option>
															<option>Escalated</option>
															<option>Waiting For Parts</option>
															<option>Closed</option> -->
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
                                                        <input class="form-control form-control-inline input-medium default-date-picker" name="dueDate" size="10" type="datetime" value="<?php echo $rowOut['dueDate']; ?>" readonly />
                                                    </div>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </section>
                            </div>

                        </div>
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
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script type="text/javascript">
        // Shorthand for $( document ).ready()
        $(function() {

        });

        function addTest() {
            var row_index = 0;
            var isRenderd = false;

            $("td").click(function() {
                row_index = $(this).parent().index();

            });

            var delayInMilliseconds = 300; //1 second

            setTimeout(function() {

                appendTableRow(row_index);
            }, delayInMilliseconds);



        }

        var appendTableRow = function(rowCount) {
            var cnt = 0
            var tr = "<tr>" +
                "<td style=''></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td>" +
                "<div>" +
                "<label class='form-inline'>" +
                "<input type='checkbox' class='form-check-input' hidden><input style='width:300px' type='text' class='form-control'></label></div>" +
                "</td>" +
                "<td><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }
    </script>




</body>

</html>