<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	$userID = $_SESSION['userID'];
	$testingID=$_GET['testingID'];
	//GET Due Date
	$queryReqID="SELECT *, a.statusID as 'status' FROM thesis.assettesting a 
				JOIN request_borrow b
				ON a.borrowID = b.borrowID
                WHERE a.testingID ={$testingID}";
	$resultReqID=mysqli_query($dbc,$queryReqID);			
	$rowReqID=mysqli_fetch_array($resultReqID,MYSQLI_ASSOC);	
	
	$status=$rowReqID['status'];

	if(isset($_POST['submit'])){
		
		$message=null;
		$category=25;
		$priority=$_POST['priority'];
		$assigned=$_POST['assigned'];
		$currDate=date("Y-m-d H:i:s");
		$dueDate=$rowReqID['startDate'];
		$summary=$rowReqID['purpose'];
		$borrowID = $rowReqID['borrowID'];

		
		if(!isset($message)){
			//insert to ticket
			$queryTicket="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `testingID`, `serviceType`, `summary`, `details`) 
											VALUES ('{$status}', {$assigned}, '{$_SESSION['userID']}', now(), now(), '{$dueDate}', '{$priority}', '{$testingID}', '{$category}', '{$summary}', 'Please test the following assets:')";
			$resultTicket=mysqli_query($dbc,$queryTicket);
			echo $queryTicket;
		
			//get ticket ID of recentyl inserted ticket
			$queryTicketID="SELECT * FROM `thesis`.`ticket` order by ticketID desc limit 1";
			$resultTicketID=mysqli_query($dbc,$queryTicketID);
			while($row=mysqli_fetch_array($resultTicketID,MYSQLI_ASSOC)){
				$ticketID = $row['ticketID'];
			}

			//get assets to be ticketed
			$queryastDetails="SELECT * FROM thesis.assettesting_details WHERE assettesting_testingID = {$testingID};";
			$resultastDetails=mysqli_query($dbc,$queryastDetails);
			while($row=mysqli_fetch_array($resultastDetails,MYSQLI_ASSOC)){
				//insert to ticketed asset
				$queryTicketed="INSERT INTO `thesis`.`ticketedasset` (`ticketID`, `assetID`) VALUES ('{$ticketID}', '{$row['asset_assetID']}');";
				$resultTicketed=mysqli_query($dbc,$queryTicketed);

				//update asset status
				$QAssetStatus = "UPDATE `thesis`.`asset` SET `assetStatus` = '12' WHERE (`assetID` = '{$row['asset_assetID']}');";
				$RAssetStatus = mysqli_query($dbc,$QAssetStatus);

				//asset audit
				$AuditQuery = "INSERT INTO `thesis`.`assetaudit` (`UserID`, `date`, `assetID`, `assetStatus`) VALUES ('{$userID}', 'now()', '{$row['asset_assetID']}', '12');";
				$AuditResult = mysqli_query($dbc,$AuditQuery);
			}

			//Change asset testing status to Ongoing
			$updateQuery = "UPDATE `thesis`.`assettesting` SET `statusID` = '2' WHERE (`testingID` = '{$testingID}');";
			$updateResult=mysqli_query($dbc,$updateQuery);

			$message = "Form submitted!";
			$_SESSION['submitMessage'] = $message;
		}
		
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
        <?php include 'helpdesk_navbar.php' ?>

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

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Asset Testing Request
                                </header>
								<div style="padding-left:30px; padding-top:10px">
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" 
									<?php 
									if ($status != 1) echo "disabled";

									?> >Create Ticket</button>
								</div>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Create a Ticket</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal" id="signupForm" method="post">
                                                        <div class="form-group ">
                                                            <div class="form-group ">
                                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control m-bot15" name="category" value="<?php if (isset($_POST['category'])) echo $_POST['category']; ?>" required disabled>
																		<?php
																			
																			$querya="SELECT * FROM thesis.ref_servicetype";
																			$resulta=mysqli_query($dbc,$querya);
																			while($rowa=mysqli_fetch_array($resulta,MYSQLI_ASSOC)){
																				if($rowa['id']=='25'){
																					echo "<option value='{$rowa['id']}' selected>{$rowa['serviceType']}</option>";
																				}
																				else{
																					echo "<option value='{$rowa['id']}'>{$rowa['serviceType']}</option>";
																				}
																			}
																		
																		?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <label for="status" class="control-label col-lg-3">Status</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status'])) echo $_POST['status']; ?>" required >
																	<?php
																			
																		$queryb="SELECT * FROM thesis.ref_ticketstatus";
																		$resultb=mysqli_query($dbc,$queryb);
																		while($rowb=mysqli_fetch_array($resultb,MYSQLI_ASSOC)){
																		
																				echo "<option value='{$rowb['ticketID']}'>{$rowb['status']}</option>";
																			
																		}
																		
																	?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="priority" class="control-label col-lg-3">Priority</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="priority" value="<?php if (isset($_POST['priority'])) echo $_POST['priority']; ?>" required>
                                                                    <option value='Low'>Low</option>
                                                                    <option value='Medium'>Medium</option>
                                                                    <option value='High' selected>High</option>
                                                                    <option value='Urgent'>Urgent</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="assigned" value="<?php if (isset($_POST['assigned'])) echo $_POST['assigned']; ?>" required>
                                                                	<option value='NULL'>None</option>
																	<?php
																		$query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer'";
																		$result3=mysqli_query($dbc,$query3);
																		
																		while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
																			echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
																		}										
																	
																	?>

                                                                </select>
                                                            </div>
                                                        </div>
																
                                                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--                                MODAL END-->
                                
                                <div class="panel-body">
									
									<div class="panel-body">
										<section>	
										</section>
									</div>

									<section id="unseen">
									<h3>Checklist</h3>
										<table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
											<thead>
												<tr>
													
													<!-- <th>Property Code</th> -->
													<th>Item</th>
													<th>Category</th>
													<th>Brand</th>
													<th>PropertyCode</th>
													<th>Comments</th>
												</tr>
											</thead>
											<tbody>
												<?php
													
													$query="SELECT b.name as 'brand',propertyCode,am.description as 'item',am.itemSpecification 
															FROM thesis.assettesting_details atd 
															join asset a on atd.asset_assetID=a.assetID
															join assetmodel am on a.assetModel=am.assetModelID
                                                            join ref_brand b on am.brand = b.brandID
															where atd.assettesting_testingID='{$testingID}';";
													$result=mysqli_query($dbc,$query);
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
														echo "<tr>
																<td style='text-align:center'>{$row['brand']}</td>
																<td style='text-align:center'>{$row['item']}</td>
																<td style='text-align:center'>{$row['itemSpecification']}</td>
																<td style='text-align:center'>{$row['propertyCode']}</td>
																<td><input style='text' class='form-control' disabled></td>
															</tr>";
													}
													
												?>

											</tbody>
										</table>
										<div>
											<a href="helpdesk_all_request.php"><button type="button" class="btn btn-danger" data-dismiss="modal">Back</button></a>
										</div>

									</section>
								</div>
                            </section>

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
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
   
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>