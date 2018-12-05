<!DOCTYPE html>
<html lang="en">

<?php
session_start();
require_once("db/mysql_connect.php");

$userID = $_SESSION['userID'];
$id = $_GET['id'];

$query = "SELECT *, t.id as 'serviceTypeID' FROM thesis.service s JOIN ref_servicetype t ON s.serviceType = t.id WHERE s.id = {$id}";

$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $serviceTypeID = $row['serviceTypeID'];
    $serviceType = $row['serviceType'];
    $details = $row['details'];
	$dateNeed = $row['dateNeed'];
	$endDate = $row['endDate'];
    $summary = $row['summary'];
    $others = $row['others'];
}

if(isset($_POST['submit'])){
        
        $status=$_POST['status'];
        $priority=$_POST['priority'];
        $assigned=$_POST['assigned'];
        if($assigned == 0) $assigned = "NULL";

        if($serviceTypeID == '29'){
             $queryTicket =  "INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `summary`, `details`, `serviceType`, `others`) VALUES ('{$status}', {$assigned}, '{$userID}', now(), now(), '{$dateNeed}', '{$priority}', '{$summary}', '{$details}', '{$serviceTypeID}', '{$others}');";
            $resultTicket = mysqli_query($dbc, $queryTicket);
            echo $queryTicket;
        }
        else{

            $queryTicket =  "INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `summary`, `details`, `serviceType`) VALUES ('{$status}', {$assigned}, '{$userID}', now(), now(), '{$dateNeed}', '{$priority}', '{$summary}', '{$details}', '{$serviceTypeID}');";
            $resultTicket = mysqli_query($dbc, $queryTicket);

             echo $queryTicket;
        }
        //Update status and steps
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
        <?php include 'helpdesk_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">

                            <section class="panel">
                                <header class="panel-heading">
                                    Service Request
                                </header>
								<div style="padding-top:10px; padding-left:10px; float:left">
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Create Ticket</button>
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
                                                    <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                                        <div class="form-group ">
                                                            <label for="status" class="control-label col-lg-3">Status</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="status" value="" required>
																	<?php
																		$query = "SELECT * FROM ref_ticketstatus";
																		
																		$result = mysqli_query($dbc, $query);

																		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
																		{
																			echo "<option value = '{$row['ticketID']}'>{$row['status']}</option>";
																		}	
																	?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="priority" class="control-label col-lg-3">Priority</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="priority" value="" required>
                                                                    <option value='Low'>Low</option>
                                                                    <option value='Medium'>Medium</option>
                                                                    <option value='High'>High</option>
                                                                    <option value='Urgent'>Urgent</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-bot15" name="assigned">
																	<option value="0">None</option>
																	<?php
																		$query = "SELECT (convert(aes_decrypt(firstName, 'Fusion') using utf8)) AS 'firstName' ,(convert(aes_decrypt(lastName, 'Fusion')using utf8)) AS 'lastName' FROM user WHERE userType = 4";
																		
																		$result = mysqli_query($dbc, $query);

																		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
																		{
																			echo "<option>{$row['firstName']} {$row['lastName']}</option>";
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
                                
                                <div style="padding-top:55px" class="panel-body">
									<div class="form" method="post">
										<form class="cmxform form-horizontal " id="servicerequest" method="post" action="requestor_service_request_form_DB.php">
											<div class="form-group ">
												<?php
													if (isset($_SESSION['submitMessage'])){

														echo "<div class='alert alert-success'>
																{$_SESSION['submitMessage']}
															  </div>";

														unset($_SESSION['submitMessage']);
													}
												?>
												<label for="serviceType" class="control-label col-lg-3">Type of Service Requested</label>
												<div class="col-lg-6">
													<select name="serviceType" onload='checkvalue(this.value)' class="form-control m-bot15" disabled>
														<option>Select Service Type</option>
														<option selected="selected">
															<?php echo $serviceType;?>
														</option>
													</select>
													<input type="text" class="form-control" name="others" id="others" placeholder="Specify request" style='display:none' disabled/>
												</div>
											</div>

                                            <?php if ($serviceTypeID == '29'){?>
                                            <div class="form-group ">
                                                <label for="others" class="control-label col-lg-3">Service Description</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" id="others" name="others" value="<?php echo $others; ?>" type="text" disabled />
                                                </div>
                                            </div>
                                            <?php } ?>

											<div class="form-group ">
                                                <label for="summary" class="control-label col-lg-3">Summary</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" id="summary" name="summary" value="<?php echo $summary; ?>" type="text" disabled />
                                                </div>
                                            </div>
											<div class="form-group ">
												<label for="details" class="control-label col-lg-3">Details</label>
												<div class="col-lg-6">
													<textarea class="form-control" rows="5" name="details" style="resize:none" disabled><?php echo $details ?></textarea>
												</div>
											</div>
											<div class="form-group ">
												<label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
												<div class="col-lg-6">
													<input class="form-control" id="dateNeeded" name="dateNeeded" value="<?php echo $dateNeed; ?>" type="text" disabled></input>
												</div>
											</div>
											<div class="form-group ">
												<label for="endDate" class="control-label col-lg-3">End date</label>
												<div class="col-lg-6">
													<input class="form-control" id="endDate" name="endDate" value="<?php echo $endDate; ?>" type="text" disabled />
												</div>
											</div>
											<div class="form-group">
												<div style="padding-left:10px">
													<a href="helpdesk_all_request.php"><button style="float:left" class="btn btn-default" type="button">Back</button></a>
												</div>
											</div>
										</form>
									</div>
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
	
	<script>
	function checkvalue(val){
		if(val==="25")
		   document.getElementById('others').style.display='block';
		else
		   document.getElementById('others').style.display='none'; 
	}
	</script>

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