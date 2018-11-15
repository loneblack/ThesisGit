<!DOCTYPE html>
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
        <?php include 'it_navbar.php' ?>

        <!--main content-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-9">
                            <section class="panel">
                                <header style="padding-bottom:20px" class="panel-heading wht-bg">
                                    <h4 class="gen-case" style="float:right"> <a class="btn btn-danger">Open</a></h4>
                                    <h4>Repair Request - Parts needed</h3>
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
                                            <div style="float:right; padding-right:20px">
                                                <p class="date"> 10:15AM 02 FEB 2018</p><br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="view-mail">
                                        <p>HI would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. Hello I would like to repair my PC. </p>
                                    </div>
                                </div>
                            </section>

                            <section class="panel">
                                <div class="panel-body ">
                                    <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Asset/ Software Name</th>
                                            <th>Property Code</th>
                                            <th>Building</th>
                                            <th>Room</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center">
                                                <input type="checkbox" value="" disabled>
                                            </td>
                                            <td>PC</td>
                                            <td>123456</td>
                                            <td>Br. Andrew</td>
                                            <td>A 1702</td>
                                        </tr>
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
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="">
                                            <div class="form-group ">
                                                <div class="form-group ">
                                                    <label for="category" class="control-label col-lg-4">Category</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control m-bot15" disabled>
                                                            <option selected="selected">Repair</option>
                                                            <option>Repair</option>
                                                            <option>Maintenance</option>
                                                            <option>Replacement</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="status" class="control-label col-lg-4">Status</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15" >
                                                        <option>New</option>
                                                        <option>Pending</option>
                                                        <option selected="selected">In Progress</option>
                                                        <option>Solved</option>
                                                        <option>Closed</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="priority" class="control-label col-lg-4">Priority</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15" >
                                                        <option selected="selected">Low</option>
                                                        <option>Medium</option>
                                                        <option>High</option>
                                                        <option>Urgent</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="assign" class="control-label col-lg-4">Assigned</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option selected="selected">Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                        <option>Eng. Marvin Lao</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4" disabled>Due Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="10-13-2018" disabled />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Repair Date *</label>
                                                <div class="col-lg-8" >
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="10-13-2018"/>
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
                                        <h4>Comments or Request For Parts (if needed)</h4>
                                    </div>
                                    <div class="view-mail">
                                        <textarea class="form-control" style="resize:none" rows="5" readonly></textarea>
                                    </div>
                                </div>
                            </section>
							
							<section class="panel">
								<div class="panel-body">
									<h3>Parts to send</h3>
								</div>
								<div class="panel-body">
									<table class="table table-bordered table-striped table-condensed table-hover" id="tableTest">
										<thead>
											<tr>
												<th>Property Code</th>
												<th>Brand</th>
												<th>Model</th>
												<th>Quantity</th>
												<th>Add/ Remove</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>	
													<input name= "propertycode0" class="form-control" type="text">
												</td>
												<td>
													<select name='brand0' id='brand0' class='form-control m-bot15' required>              
														<option value=''>Select Brand</option>
													</select>
												</td>
												<td>
													<select name='model0' id='model0' class='form-control m-bot15' required>              
														<option value=''>Select Model</option>
													</select>
												</td>
												<td>
													<select name='quantity0' id='quantity0' class='form-control m-bot15' required>              
														<option value=''>0</option>
													</select>
												</td>
												<td style="text-align:center"><button type= "button" class="btn btn-success" onclick="addTest(4)"> Add </button></td>
											</tr>
										</tbody>
									</table>
								</div>
							</section>
							
                            <button onclick="#" class="btn btn-success">Send</button></a>
                            <a href="it_requests.php"><button class="btn btn-danger">Back</button></a>
                        </div>


                    </div>
                    <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>

    <!-- WAG GALAWIN PLS LANG -->
	
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

        var appendTableRow = function(rowCount, canvasItemID) {
            var cnt = 0;
            count++;
            var tr = "<tr>" +
                "<td><input class='form-control' name='propertycode"+count+"' id='propertycode"+count+"' type='text' >"+
                "</td>" +
				"<td><select class='form-control' name='brand"+count+"' id='brand"+count+"'><option>Select Brand</option>"+
                "</td>" +
				"<td><select class='form-control' name='model"+count+"' id='model"+count+"'><option>Select Model</option>"+
                "</td>" +
				"<td><select class='form-control' name='quantity"+count+"' id='quantity"+count+"'><option>0</option>"+
                "</td>" +
                "<td style='text-align:center'><button class='btn btn-danger' onclick='removeRow(this)'> Remove </button></td>" +
                "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
        }
    </script>

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