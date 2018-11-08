<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$_SESSION['previousPage'] = "requestor_service_request_form.php";
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
                    Welcome IT Officer!
                </a>
            </div>

            <div class="nav notify-row" id="top_menu">

            </div>

        </header>
        <!--header end-->
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Service Request Form
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="post" action="requestor_service_request_form_DB.php">
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
                                                        <select name="serviceType" onchange='checkvalue(this.value)' class="form-control m-bot15" disabled>
                                                            <option>Select Service Type</option>
                                                            <option value="1">Access regulation/permission</option>
                                                            <option value="2">Activation/Deactivation of MyLasalle account</option>
                                                            <option value="3">Add/remove email address in mailing list</option>
                                                            <option value="4">Computer lab management</option>
                                                            <option value="5">Computer Set-up</option>
                                                            <option value="6">Creation/Deletion of mailing list</option>
                                                            <option value="7">Data extraction/Report generation/Printing</option>
                                                            <option value="8">Data/Information update</option>
                                                            <option value="9">Forms/Charts design</option>
                                                            <option value="10">IT asset management</option>
                                                            <option value="11">Network management</option>
                                                            <option value="12">Photoshoot/Virtual tour</option>
                                                            <option value="13">Print publishing</option>
                                                            <option value="14">Program access request</option>
                                                            <option value="15">Request for replacement unit</option>
                                                            <option value="16">Security management</option>
                                                            <option value="17" selected="selected">Server management</option>
                                                            <option value="18">Service/Backup unit provisions</option>
                                                            <option value="19">Stand by support Engineer</option>
                                                            <option value="20">System development/Revision</option>
                                                            <option value="21">Transfer and installation of application software</option>
                                                            <option value="22">Web graphics publishing</option>
                                                            <option value="23">Web site creation</option>
                                                            <option value="24">Website updating</option>
                                                            <option value="25">Others</option>
                                                        </select>
														<input type="text" class="form-control" name="others" id="others" placeholder="Specify request" style='display:none'/>
                                                    </div>
                                                </div>
												
                                                <div class="form-group ">
                                                    <label for="details" class="control-label col-lg-3">Details</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" rows="5" name="details" style="resize:none" disabled></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Date needed</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="dateNeeded" name="dateNeeded" type="date" disabled />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="endDate" class="control-label col-lg-3">End date</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="endDate" name="endDate" type="date" disabled />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <a href="it_requests.php"><button class="btn btn-default" type="button">Back</button></a>
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
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>


    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>