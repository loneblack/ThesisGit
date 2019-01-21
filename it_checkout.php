<!DOCTYPE html>
<?php 
	session_start();
	require_once('db/mysql_connect.php');
	$id=$_GET['id'];
	
	$queryInvDet="SELECT a.assetID, a.propertyCode,rb.name as `brandName`,am.description as `modelName`,ras.description as `assetStat`,CONCAT(bldg.name,' ',far.floorRoom) AS `location`,e.name as `borrower` FROM thesis.asset a left join assetmodel am on a.assetModel=am.assetModelID
																							 left join ref_brand rb on am.brand=rb.brandID
																							 left join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID
																							 left join borrow_details_item bdi on a.assetID=bdi.assetID
																							 left join borrow_details bd on bdi.borrow_detailsID=bd.borrow_detailscol
																							 left join request_borrow rbw on bd.borrowID=rbw.borrowID
																							 left join floorandroom far on rbw.FloorAndRoomID=far.FloorAndRoomID
																							 left join building bldg on far.BuildingID=bldg.BuildingID
																							 left join employee e on rbw.personresponsibleID=e.employeeID
																							 left join ref_assetstatus ras on a.assetStatus=ras.id
																							 where a.assetID='{$id}'";
	$resultInvDet=mysqli_query($dbc, $queryInvDet);
	$rowInvDet=mysqli_fetch_array($resultInvDet, MYSQLI_ASSOC);
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
    <link rel="stylesheet" type="text/css" href="js/gritter/css/jquery.gritter.css" />
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
                    <img src="images/dlsulogo.png" alt="" width="200px" height="40px">!
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
                        <div class="col-sm-12">


                            <section class="panel">
                                <header class="panel-heading">
                                    Checkout an Asset
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="category" class="col-lg-2 col-sm-2 control-label">Property Code</label>
                                                <h5><?php echo $rowInvDet['propertyCode']; ?></h5>
                                            </div>

                                            <div class="form-group">
                                                <label for="category" class="col-lg-2 col-sm-2 control-label">Brand Name</label>
                                                <h5><?php echo $rowInvDet['brandName']; ?></h5>
                                            </div>

                                            <div class="form-group">
                                                <label for="category" class="col-lg-2 col-sm-2 control-label">Model</label>
                                                <h5><?php echo $rowInvDet['modelName']; ?></h5>
                                            </div>

                                            <div class="form-group">
                                                <label for="brand" class="col-lg-2 col-sm-2 control-label">Checkout To</label>
                                                <ul class="nav nav-stacked nav-justified">
                                                    <li class="active"><a href="#User" data-toggle="tab">User</a></li>
                                                    <li><a href="#Location" data-toggle="tab">Location</a></li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane fade in active" id="User">
                                                        <label for="model" class="col-lg-2 col-sm-2 control-label"></label>
                                                        <div class="col-lg-5">
                                                            <select class="form-control m-bot15">
                                                                <option>Select User</option>
                                                                <option>Marvin Lao</option>
                                                                <option>Pimentel Boi</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="Location">
                                                        <label for="model" class="col-lg-2 col-sm-2 control-label"></label>
                                                        <div class="col-lg-5 m-bot15">
                                                            <select class="form-control">
                                                                <option>Select Location</option>
                                                                <option>Andrew</option>
                                                                <option>Goks</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="control-label col-lg-2 col-sm-2">Checkout Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="" /   >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-2 col-sm-2">Expected Checkin Date</label>
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Notes</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" rows="5" id="notes" placeholder="Notes"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-success">Checkout</button>
                                                    <button type="submit" class="btn btn-danger">Cancel</button>
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
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>
    <script src="js/gritter.js" type="text/javascript"></script>

</body>

</html>