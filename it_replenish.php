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
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

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
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Stock List

                                        </header>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <section class="panel">
                                                        <div class="panel-body">
                                                            <form>
                                                                <div class="adv-table">
                                                                    <table class="table table-bordered table table-hover" id="tableTest">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="text-align:center"><input type="checkbox" disabled></th>
                                                                                <th>Asset Category</th>
                                                                                <th>Floor</th>
                                                                                <th>Ceiling</th>
                                                                                <th>Total Quantity</th>
                                                                                <th>To Buy</th>
                                                                                <th>Brand</th>
                                                                                <th>Model</th>
                                                                                <th>Add</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="text-align:center"><input type="checkbox" checked disabled></td>
                                                                                <td>Computer</td>
                                                                                <td>5</td>
                                                                                <td>50</td>
                                                                                <td>43</td>
                                                                                <td><input type=number class="form-control"></td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Brand</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Model</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><button type="button" class="btn btn-primary" onclick="Add(1)"> Add </button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align:center"><input type="checkbox" checked disabled></td>
                                                                                <td>Laptop</td>
                                                                                <td>6</td>
                                                                                <td>
                                                                                    10
                                                                                </td>
                                                                                <td>
                                                                                    <font color="orange">8</font>
                                                                                </td>
                                                                                <td><input type=number class="form-control"></td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Brand</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Model</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><button type="button" class="btn btn-primary" onclick="Add(2)"> Add </button></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align:center"><input type="checkbox" checked disabled></td>
                                                                                <td>VGA</td>
                                                                                <td>6</td>
                                                                                <td>24</td>
                                                                                <td>
                                                                                    <font color="red">5</font>
                                                                                </td>
                                                                                <td><input type=number class="form-control"></td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Brand</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control">
                                                                                        <option>Select Model</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><button type="button" class="btn btn-primary" onclick="Add(3)"> Add </button></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </form>
                                                        </div>
                                                        <button class="btn btn-success">Submit</button>
                                                        <a href="it_inventory.php"><button class="btn btn-danger">Back</button></a>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
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

    <!--Core js-->
    <script type="text/javascript">
		function removeRow(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
		
		function Add() {
            var row_index = 0;
			var isRenderd = false;
			$("td").click(function() {
                row_index = $(this).parent().index();
            });
            var delayInMilliseconds = 0; //1 second
			setTimeout(function() {
                appendTableRow(row_index);
            }, delayInMilliseconds);
           
		};
		
		 var appendTableRow = function(rowCount) {
            var cnt = 0;
            var tr = "<tr>" +
                     "<td></td>" +
                     "<td></td>" +
                     "<td></td>" +
                     "<td></td>" +
                     "<td></td>" +
                     "<td></td>" +
                     "<td><select class='form-control'><option>Select Brand</option></select></td>" +
                     "<td><select class='form-control'><option>Select Model</option></select></td>" +
                     "<td><button id='remove' class='btn btn-danger' type='button' + onClick='removeRow(this)'>Remove</button></td>" +
                     + "</tr>";
            $('#tableTest tbody tr').eq(rowCount).after(tr);
							
        }
        function Remove(button) {
            //Determine the reference of the Row using the Button.
            var row = button.parentNode.parentNode;
            var name = row.getElementsByTagName("TD")[0].innerHTML;
            if (confirm("Remove: " + name)) {

                //Get the reference of the Table.
                var table = document.getElementById("tblCustomers");

                //Delete the Table row using it's Index.
                table.deleteRow(row.rowIndex);
            }
        };
        
    </script>

    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
    <script src="js/dynamic_table_init.js"></script>

    <!--common script init for all pages-->
    <script src="js/scripts.js"></script>



</body>

</html>