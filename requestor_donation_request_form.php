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
        <?php include 'requestor_navbar.php' ?>

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
                                        Donation Request
                                    </header>
                                    <div class="panel-body">
                                        <div class="form" method="post">
                                            <form class="cmxform form-horizontal " id="signupForm" method="get" action="">
                                                <div class="form-group ">
                                                    <label class="control-label col-lg-3">Affiliation</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" id="ddl1" onchange="configureDropDownLists(this,document.getElementById('ddl2'))">
                                                            <option>Select Affiliation</option>
                                                            <option value="Office">Office</option>
                                                            <option value="Department">Department</option>
                                                            <option value="Organization">School Organization</option>
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="form-group" id="office">
                                                    <label class="control-label col-lg-3"></label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" id="ddl2">
                                                        </select>
                                                    </div>
                                                </div>






                                                <div class="form-group ">
                                                    <label for="number" class="control-label col-lg-3">Contact No.</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" rows="5" name="details" style="resize:none" type="text" required>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="dateNeeded" class="control-label col-lg-3">Date & time needed</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="dateNeeded" name="dateNeeded" type="datetime-local" />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="purpose" class="control-label col-lg-3">Purpose</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="purpose" name="purpose" type="text" />
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="container-fluid">
                                                    <h4>Requested Equipment</h4>

                                                    <table style="width:670px" class="table table-bordered table-striped table-condensed table-hover" id="tblCustomers" align="center" cellpadding="0" cellspacing="0" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:500px">Equipment</th>
                                                                <th style="width:150px">Quantity</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control" id="txtName">
                                                                        <option>Select</option>
                                                                    </select>
                                                                </td>
                                                                <td><input class="form-control" type="number" min="1" id="txtCountry" /></td>
                                                                <td style="text-align:center"><input class="btn btn-primary" type="button" onclick="Add()" value="Add" /></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <hr>
                                                <div class="container-fluid">

                                                    <div class="form-group">
                                                        <div class="col-lg-offset-3 col-lg-6">
                                                            <button class="btn btn-primary" type="submit">Save</button>
                                                            <button class="btn btn-default" type="button">Cancel</button>
                                                        </div>
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

    <!--Script for table -->
    <script type="text/javascript">
        window.onload = function() {
            //Build an array containing Customer records.
            var customers = new Array();


            //Add the data rows.
            for (var i = 0; i < customers.length; i++) {
                AddRow(customers[i][0], customers[i][1]);
            }
        };

        function Add() {
            var txtName = document.getElementById("txtName");
            var txtCountry = document.getElementById("txtCountry");
            AddRow(txtName.value, txtCountry.value);
            txtName.value = "";
            txtCountry.value = "";
        };

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

        function AddRow(name, country) {
            //Get the reference of the Table's TBODY element.
            var tBody = document.getElementById("tblCustomers").getElementsByTagName("TBODY")[0];

            //Add Row.
            row = tBody.insertRow(-1);

            //Add Name cell.
            var cell = row.insertCell(-1);
            cell.innerHTML = name;

            //Add Country cell.
            cell = row.insertCell(-1);
            cell.innerHTML = country;

            //Add Button cell.
            cell = row.insertCell(-1);
            var btnRemove = document.createElement("INPUT");
            btnRemove.type = "button";
            btnRemove.value = "Remove";
            btnRemove.setAttribute("onclick", "Remove(this);");
            btnRemove.setAttribute("class", "btn btn-primary");
            btnRemove.setAttribute("style", "text-align:center");

            cell.appendChild(btnRemove);
        }

        function getRooms(val) {
            $.ajax({
                type: "POST",
                url: "requestor_getRooms.php",
                data: 'buildingID=' + val,
                success: function(data) {
                    $("#FloorAndRoomID").html(data);

                }
            });
        }

        function configureDropDownLists(ddl1, ddl2) {
            var colours = ['Select Office', 'IT Office', 'Accounting Office', 'ABC Office'];
            var shapes = ['Select Department', 'Accountancy', 'Behavioral Sciences', 'Biology'];
            var names = ['Select Organization', 'ENGLICOM', 'LSCS', 'USG'];

            switch (ddl1.value) {
                case 'Office':
                    ddl2.options.length = 0;
                    for (i = 0; i < colours.length; i++) {
                        createOption(ddl2, colours[i], colours[i]);
                    }
                    break;
                case 'Department':
                    ddl2.options.length = 0;
                    for (i = 0; i < shapes.length; i++) {
                        createOption(ddl2, shapes[i], shapes[i]);
                    }
                    break;
                case 'Organization':
                    ddl2.options.length = 0;
                    for (i = 0; i < names.length; i++) {
                        createOption(ddl2, names[i], names[i]);
                    }
                    break;
                default:
                    ddl2.options.length = 0;
                    break;
            }

        }

        function createOption(ddl, text, value) {
            var opt = document.createElement('option');
            opt.value = value;
            opt.text = text;
            ddl.options.add(opt);
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