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

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    All Suppliers
                                </header>
                                <div class="panel-body">
                                    <section id="unseen">
                                        <div class="panel-body">
                                            <div class="adv-table">
                                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Company Name</th>
                                                            <th>Contact Person</th>
                                                            <th>Email</th>
                                                            <th>Contact Number</th>
                                                            <th>Address</th>
                                                            <th>Edit</th>
                                                            <th>Associate to Product</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
												
//													require_once('mysql_connect.php');
//													$query="SELECT * FROM thesis.supplier";
//													$result=mysqli_query($dbc,$query);
//													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
//														echo "<tr>
//															<td>{$row['name']}</td>
//															<td>{$row['contactPerson']}</td>
//															<td>{$row['email']}</td>
//															<td>{$row['contactNo']}</td>
//															<td>{$row['address']}</td>
//															<td><a href='it_edit_supplier.php?supplierid={$row['supplierID']}'><button type='button' class='btn btn-primary'><i class='glyphicon glyphicon-pencil'></i> Edit</button></a></td>
//														</tr>";
//														
//														
//														
//													}
												
												?>


                                                        <tr class="gradeX">
                                                            <td>ABC Company</td>
                                                            <td>Marvin Lao</td>
                                                            <td>marvin_lao@email.com</td>
                                                            <td>09178429929</td>
                                                            <td>456 Zento Mendoza Street, Alfra Hu Akbar, Iraq</td>
                                                            <td style="text-align:center"><button type="button" class="btn btn-primary" id="edit"><i class="glyphicon glyphicon-pencil"></i> Edit</button></td>
                                                            <td style="text-align:center"><button type="button" class="btn btn-info" id="associate" data-toggle="modal" data-target="#association"><i class="fa fa-plus"></i> Associate</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
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

    <!-- Modal -->
    <div class="modal fade" id="association" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel">Associate Supplier to Product</h5>

                </div>
                <div class="modal-body">
                    div class="form-group last">
                    <label class="control-label col-md-3">Searchable</label>
                    <div class="col-md-9">
                        <select name="country" class="multi-select" multiple="" id="my_multi_select3">
                            <option value="AF">Afghanistan</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AS">American Samoa</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AQ">Antarctica</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<!-- WAG GALAWIN PLS LANG -->

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