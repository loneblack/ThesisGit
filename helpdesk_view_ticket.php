<!DOCTYPE html>
<?php
	session_start(); 
	require_once('db/mysql_connect.php');
	$_SESSION['ticketID']=$_GET['ticketID'];
	
	$que1="SELECT rts.status as `status` FROM thesis.ticket t join thesis.ref_ticketstatus rts on t.status=rts.ticketID where t.ticketID='{$_SESSION['ticketID']}'";
	$res1=mysqli_query($dbc,$que1);
	$row0=mysqli_fetch_array($res1,MYSQLI_ASSOC);
	
	//if($row0['action']!='Answered'){
		//$que="UPDATE `thesis`.`ticket` SET `action`='Unanswered' WHERE `ticketID`='{$_SESSION['ticketID']}'";
		//$res=mysqli_query($dbc,$que);
	//}
	
	$key = "Fusion";
	$flag=0;
	
	$query="SELECT t.dateCreated as `dateCreated`,t.description as `ticketdes`,t.dateCreated,rut.description as `usertypedes`,CONCAT(Convert(AES_DECRYPT(lastName,'{$key}')USING utf8),', ',Convert(AES_DECRYPT(firstName,'{$key}')USING utf8)) as `fullname` FROM thesis.ticket t 
														 join thesis.user u on t.creatorUserID=u.UserID 
														 join thesis.ref_usertype rut on u.userType=rut.id
                                                         where t.ticketID='{$_SESSION['ticketID']}'";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

	if (isset($_POST['submit'])){
		
		$message=NULL;
		$category=$_POST['category'];
		$status=$_POST['status'];
		$priority=$_POST['priority'];
		$assigned=$_POST['assigned'];
		
		
		if($_POST['dueDate']<$row['dateCreated']){
			$dueDate=FALSE;
			$message="Invalid due date input.";
		}
		else{
			$dueDate=$_POST['dueDate'];
		}
		
		if(!isset($message)){
			echo "<script type='text/javascript'>alert('Success');</script>"; // Show modal
			
			$query="UPDATE `thesis`.`ticket` SET `action`='Answered', `status`='{$status}', `assigneeUserID`='{$assigned}', `dueDate`='{$dueDate}', `priority`='{$priority}', `serviceType`='{$category}' WHERE `ticketID`='{$_SESSION['ticketID']}'";
			$result=mysqli_query($dbc,$query);
			$flag=1;
		}
		else{
			echo "<script type='text/javascript'>alert('".$message."');</script>";
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

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-8">
                            <section class="panel">
                                <header class="panel-heading wht-bg">
                                    <!-- <h4 class="gen-case"> 
										<a class="btn btn-success">Opened</a>
                                        <a class="btn btn-warning">Unassigned</a> -->
                                    </h4>
									<h4 class="gen-case"> 
										<?php 
											
											//if($row0['action']=='Unanswered'){
												//echo "<a class='btn btn-warning'>{$row0['action']}</a>";
											//}
											//elseif($row0['action']=='Answered'){
												//echo "<a class='btn btn-danger'>{$row0['action']}</a>";
											//}
											//else{
												//echo "<a class='btn btn-success'>{$row0['action']}</a>";
											//}
											
											if($row0['status']=='Open'){
												echo "<a class='btn btn-success'>{$row0['status']}</a>";
											}
											elseif($row0['status']=='Closed'){
												echo "<a class='btn btn-danger'>{$row0['status']}</a>";
											}
											elseif($row0['status']=='Assigned'){
												echo "<a class='btn btn-info'>{$row0['status']}</a>";
											}
											elseif($row0['status']=='In Progress'||$row0['status']=='Waiting for Parts'){
												echo "<a class='btn btn-warning'>{$row0['status']}</a>";
											}
											elseif($row0['status']=='Transferred'){
												echo "<a class='btn btn-primary'>{$row0['status']}</a>";
											}
											elseif($row0['status']=='Escalated'){
												echo "<a class='btn btn-secondary'>{$row0['status']}</a>";
											}
										?>
                                    </h4>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <!-- <strong>IT Office</strong> -->
												<strong><?php echo $row['usertypedes'] ?></strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <!-- <p class="date"> 10:15AM 02 FEB 2018</p><br><br> -->
												<p class="date"><?php echo $row['dateCreated'] ?></p><br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="view-mail">
                                        <!-- <p>Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. </p> -->
										<p><?php echo $row['ticketdes'] ?></p>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-sm-4">

                            <section class="panel">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked labels-info ">
                                        <li>
                                            <h4>Properties</h4>
                                        </li>
                                    </ul>
                                    <div class="form">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="<?php echo $_SERVER['PHP_SELF']."?ticketID={$_SESSION['ticketID']}"; ?>">
                                            <div class="form-group ">
                                                <div class="form-group ">
                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="category" value="<?php if (isset($_POST['category']) && !$flag) echo $_POST['category'];  ?>" required>
														<?php
															$query1="SELECT * FROM thesis.ref_servicetype";
															$result1=mysqli_query($dbc,$query1);
														
															while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
																echo "<option value='{$row1['id']}'>{$row1['serviceType']}</option>";
															}

														?>
                                                    </select>
                                                </div>
                                            </div>
                                                
                                                <label for="status" class="control-label col-lg-3">Status</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="status" value="<?php if (isset($_POST['status']) && !$flag) echo $_POST['status'];  ?>" required>
														<?php
															$query2="SELECT * FROM thesis.ref_ticketstatus";
															$result2=mysqli_query($dbc,$query2);
															
															while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
																echo "<option value='{$row2['ticketID']}'>{$row2['status']}</option>";
															}
														?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="priority" class="control-label col-lg-3">Priority</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" name="priority" value="<?php if (isset($_POST['priority']) && !$flag) echo $_POST['priority'];  ?>" required>
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
                                                    <select class="form-control m-bot15" name="assigned" value="<?php if (isset($_POST['assigned']) && !$flag) echo $_POST['assigned'];  ?>" required>
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

                                            <div class="form-group">
                                                <label class="control-label col-lg-3">Due Date</label>
                                                <div class="col-lg-6">
													<!-- class="form-control form-control-inline input-medium default-date-picker" -->
                                                    <input class="form-control m-bot15" size="10" name="dueDate" type="datetime-local" value="<?php if (isset($_POST['dueDate']) && !$flag) echo $_POST['dueDate']; ?>" required />
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-success" name="submit">Update</button>
                                        </form>
                                    </div>

                                </div>
                            </section>
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