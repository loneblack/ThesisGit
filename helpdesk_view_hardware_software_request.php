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
                    Welcome Helpdesk!
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

                        <div class="row">
                            <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Hardware/Software Request Form
                                    </header>
                                    
									<div class="panel-body">
                                        <h4>Requested Services/Materials</h4>
											<table class="table table-bordered table-striped table-condensed table-hover" align="center" id="tblCustomers" cellpadding="0" cellspacing="0" border="1">
												<thead>
													<tr>
														<th>Hardware/Software</th>
														<th style="width:105px">Quantity</th>
														<th style="width:125px">Estimated Cost</th>
														<th>Budget Source</th>
														<th>Recommended Supplier</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<td><input class="form-control"  type="text" id="items" disabled /></td>
														<td><input class="form-control"  type="number" id="txtCountry" min="1" step="1" disabled /></td>
														<td><input class="form-control"  type="number" id="txtName" min="0.01" step="0.01" disabled /></td>
														<td><input class="form-control"  type="text" id="amount" disabled /></td>
														<td>
															<select class="form-control" name="supplier" id="supplier" disabled >
																<option>Select Supplier</option>
																<option value="23">23</option>
																<option value="supplier">Supplier</option>
															</select>
														</td>
													</tr>
												</tfoot>
											</table>
											
											<h4>Additional Details</h4>
											<table class="table table-bordered table-striped table-condensed table-hover" align="center" id="additionalDetails" cellpadding="0" cellspacing="0" border="1">
												<thead>
													<tr>
														<th>Course</th>
														<th>Offerings Per Year</th>
														<th>Students Per Section</th>
														<th>Section Per Term</th>
														<th>Section Per Year</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<td style="width:225px"><input class="form-control"  type="text" id="course" disabled /></td>
														<td><input class="form-control"  type="number" id="offeringYear" min="1" disabled /></td>
														<td><input class="form-control"  type="number" min="1" id="students" disabled /></td>
														<td><input class="form-control"  type="number" min="1" id="sectionTerm" disabled /></td>
														<td><input class="form-control"  type="number" min="1" id="sectionYear" disabled /></td>
													</tr>
												</tfoot>
											</table>
											<hr>
											<div class="container-fluid">
												<div class="form-group">
													<div style="">
														<a href="helpdesk_all_request.php"><button style="float:left" class="btn btn-default" type="button">Back</button></a>
													</div>
												</div>
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
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
   
    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>