<!DOCTYPE html>
<?php

	$flag=0;
	$key = "Fusion";
	require_once('db/mysql_connect.php');
	
	//temporary userID
	$userID='3';
	
	if (isset($_POST['submit'])){
		$message=NULL;
		$date=date("Y-m-d H:i:s");
		$title=$_POST['title'];
		$category=$_POST['category'];
		$status=$_POST['status'];
		$priority=$_POST['priority'];
		$assigned=$_POST['assigned'];
		$description=$_POST['description'];
		
		if($_POST['dueDate']<$date){
			$dueDate=FALSE;
			$message="Invalid due date input.";
		}
		else{
			$dueDate=$_POST['dueDate'];
		}
		
		if(!isset($message)){
			echo "<script type='text/javascript'>alert('Success');</script>"; // Show modal
			
			$query="INSERT INTO `thesis`.`ticket` (`status`, `assigneeUserID`, `creatorUserID`, `lastUpdateDate`, `dateCreated`, `dueDate`, `priority`, `summary`, `description`, `serviceType`, `action`) VALUES ('{$status}', '{$assigned}', '{$userID}', now(), now(), '{$dueDate}', '{$priority}', '{$title}', '{$description}', '{$category}', 'New Ticket')";
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
                        <div class="col-sm-12">


                            <section class="panel">
                                <header class="panel-heading">
                                    Create A New Ticket
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
											
											<div class="form-group ">
                                                <label for="ccomment" class="col-lg-2 col-sm-2 control-label">Title</label>
                                                <div class="col-lg-10">
													<input class=" form-control" name="title" type="text" value="<?php if (isset($_POST['title']) && !$flag) echo $_POST['title']; ?>" required />
                                                </div>
                                            </div>
											
                                            <div class="form-group">
                                                <label for="name" class="col-lg-2 col-sm-2 control-label">Category</label>
                                                <div class="col-lg-10">
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
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-lg-2 col-sm-2 control-label">Status</label>
                                                <div class="col-lg-10">
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
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-lg-2 col-sm-2 control-label">Priority</label>
                                                <div class="col-lg-10">
                                                    <select class="form-control m-bot15" name="priority" value="<?php if (isset($_POST['priority']) && !$flag) echo $_POST['priority'];  ?>" required>
                                                        <option value='Low'>Low</option>
                                                        <option value='Medium'>Medium</option>
                                                        <option value='High'>High</option>
                                                        <option value='Urgent'>Urgent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-lg-2 col-sm-2 control-label">Assigned</label>
                                                <div class="col-lg-10">
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
                                                <label for="name" class="col-lg-2 col-sm-2 control-label">Due Date</label>
                                                <div class="col-lg-10">
                                                    <!-- class="form-control form-control-inline input-medium default-date-picker" -->
                                                    <input class="form-control m-bot15" size="10" name="dueDate" type="datetime-local" value="<?php if (isset($_POST['dueDate']) && !$flag) echo $_POST['dueDate']; ?>" required />
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="ccomment" class="col-lg-2 col-sm-2 control-label">Notes</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control " id="description" name="description" required><?php if (isset($_POST['description']) && !$flag) echo $_POST['description']; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-success" name="submit">Submit</button>
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
