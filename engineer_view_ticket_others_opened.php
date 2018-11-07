<!DOCTYPE html>
<html lang="en">
<?php

require_once("db/mysql_connect.php");

$id = $_GET['id'];

$query = "SELECT t.ticketID, (convert(aes_decrypt(au.firstName, 'Fusion') using utf8)) AS 'firstName' ,(convert(aes_decrypt(au.lastName, 'Fusion')using utf8)) AS 'lastName',
        lastUpdateDate, dateCreated, dateClosed, dueDate, priority,summary,
        t.description, t.serviceType as 'serviceTypeID', st.serviceType,t.status as 'statusID', s.status, others, comment
        FROM thesis.ticket t
            JOIN user au
        ON t.assigneeUserID = au.UserID
            JOIN ref_ticketstatus s
        ON t.status = s.ticketID
            JOIN ref_servicetype st
        ON t.serviceType = st.id
        WHERE t.ticketID = {$id};";

$result = mysqli_query($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $lastUpdateDate = $row['lastUpdateDate'];
    $dateCreated = $row['dateCreated'];
    $dateClosed = $row['dateClosed'];
    $dueDate = $row['dueDate'];
    $priority = $row['priority'];
    $summary = $row['summary'];
    $description = $row['description'];
    $serviceTypeID = $row['serviceTypeID'];
    $serviceType = $row['serviceType'];
    $statusID = $row['statusID'];
    $status = $row['status'];
    $firstName = $row['firstName'];
    $lastName = $row['lastName'];
    $others = $row['others'];
    $comment = $row['comment'];
    
    
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
                    Welcome Engineer!
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
                        <div class="col-sm-8">
                            <section class="panel">
                                <header style="padding-bottom:20px"class="panel-heading wht-bg">
                                    <h4 class="gen-case" style="float:right"> <a class="btn btn-success">Opened</a></h4>
									<h4>Others</h3>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong>IT Office</strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="date"><?php echo $dateCreated;?></p><br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="view-mail">
                                        <p><?php echo $description;?></p>
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
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                            <div class="form-group ">
                                                <div class="form-group ">
                                                <label for="category" class="control-label col-lg-3">Category</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option selected="selected"><?php echo $others;?></option>
                                                    </select>
                                                </div>
                                            </div>
                                                
                                                <label for="status" class="control-label col-lg-3">Status</label>
                                                <div class="col-lg-6">
                                                     <select class="form-control m-bot15">
                                                        <option <?php if($statusID == '2') echo 'selected="selected"';?>>Assigned</option>
                                                        <option <?php if($statusID == '3') echo 'selected="selected"';?>>In Progress</option>
                                                        <option <?php if($statusID == '4') echo 'selected="selected"';?>>Transferred</option>
                                                        <option <?php if($statusID == '5') echo 'selected="selected"';?>>Waiting For Parts</option>
                                                        <option <?php if($statusID == '6') echo 'selected="selected"';?>>Escalated</option>
                                                        <option <?php if($statusID == '7') echo 'selected="selected"';?>>Closed</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="priority" class="control-label col-lg-3">Priority</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15">
                                                        <option <?php if($priority == 'Low') echo 'selected="selected"';?>>Low</option>
                                                        <option <?php if($priority == 'Medium') echo 'selected="selected"';?>>Medium</option>
                                                        <option <?php if($priority == 'High') echo 'selected="selected"';?>>High</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-3">Assigned</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option selected="selected">Eng. <?php echo $firstName." ".$lastName;?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-3">Due Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value=<?php echo "'".$dueDate."'";?> disabled/>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </section>
                        </div>
		
						<div class="col-sm-12">
                            <section class="panel">
                                <div class="panel-body ">

                                    <div>
                                        <h4>Comments (if needed)</h4>
                                    </div>
                                    <div class="view-mail">
										<textarea class="form-control" style="resize:none" rows="5"></textarea>
                                    </div>
                                </div>
                            </section>
							<button onclick="return confirm('Send and close ticket?')" class="btn btn-success">Send</button></a>
							<a href="engineer_all_ticket.php"><button class="btn btn-danger">Back</button></a>
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