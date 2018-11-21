<!DOCTYPE html>
<?php
	session_start();
	require_once('db/mysql_connect.php');
	
	if(isset($_POST['confirm'])){
		if(!empty($_POST['markForDis'])){
			$markForDis=$_POST['markForDis'];
			foreach($markForDis as $forDis){
				$queryForDis="UPDATE `thesis`.`asset` SET `assetStatus`='11' WHERE `assetID`='{$forDis}'";
				$resultForDis=mysqli_query($dbc,$queryForDis);
			}
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
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

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
				<?php
                    if (isset($_SESSION['submitMessage'])){

                        echo "<div class='alert alert-success'>
                                {$_SESSION['submitMessage']}
							  </div>";
                        unset($_SESSION['submitMessage']);
                    }
				?>
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        
                        <div class="row">


                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
										<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <header class="panel-heading">
                                            Mark for Disposal
                                            <span class="tools pull-right">
                                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                            </span>
                                        </header>
                                        <div class="panel-body">
                                            <div class="adv-table">
                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Item</th>
															<th>Status</th>
                                                            <th>Property Code</th>
                                                            <th>Model</th>
                                                            <!-- <th class="hidden-phone">Comments</th> -->
                                                            <th class="hidden-phone">Brand</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
														<?php
															//GET Broken not fixable ASSET
															$queryAsset="SELECT a.assetID,rac.name as `assetCat`,rb.name as `brandName`,am.description as `assetModel`,ras.description as `assetStat`,a.propertyCode FROM thesis.asset a join assetmodel am on a.assetModel=am.assetModelID
																		  join ref_assetstatus ras on a.assetStatus=ras.id
																		  join ref_brand rb on am.brand=rb.brandID
																		  join ref_assetcategory rac on am.assetCategory=rac.assetCategoryID where a.assetStatus='4'";
															$resultAsset=mysqli_query($dbc,$queryAsset);
															while($rowAsset=mysqli_fetch_array($resultAsset,MYSQLI_ASSOC)){
																echo "<tr class='gradeX'>
																<td style='width:7px; text-align:center'><input type='checkbox' class='form-check-input' name='markForDis[]' id='exampleCheck1' value='{$rowAsset['assetID']}'></td>
																<td>{$rowAsset['assetCat']}</td>
																<td><label class='label label-danger'>{$rowAsset['assetStat']}</label></td>
																<td>{$rowAsset['propertyCode']}</td>
																<td>{$rowAsset['assetModel']}</td>
																<td>{$rowAsset['brandName']}</td>
															</tr>";
															}
														?>
                                                       <!-- <tr class="gradeX">
                                                            <td style="width:7px; text-align:center"><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
                                                            <td>Laptop</td>
                                                            <td><label class="label label-danger">Broken - Not Fixable</label></td>
                                                            <td>LPTP-0099</td>
                                                            <td>Samsung</td>
                                                            <td>dead</td>
															<td>Brand</td>
                                                        </tr> -->
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th>Item</th>
															<th>Status</th>
                                                            <th>Property Code</th>
                                                            <th>Model</th>
                                                            <!-- <th class="hidden-phone">Comments</th> -->
                                                            <th class="hidden-phone">Brand</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="padding-left:10px; padding-bottom:10px">
                                            <button type="submit" name="confirm" onclick="Confirm()" class="btn btn-info">Confirm</button>
											<button type="button" onclick="window.history.back()" class="btn btn-secondary">Back</button>
                                        </div>
										</form>
                                    </section>
                                </div>
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
	
	<script>
	function Confirm() {
		confirm("Are you sure?");
	}
	</script>

    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>

    <!--dynamic table-->
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>

    <script src="js/morris-chart/morris.js"></script>
    <script src="js/morris-chart/raphael-min.js"></script>
    <script src="js/morris.init.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init.js"></script>

</body>

</html>