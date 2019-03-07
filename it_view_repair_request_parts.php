<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$userID = $_SESSION['userID'];
require_once("db/mysql_connect.php");
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
                                    <?php
                                        if (isset($_SESSION['submitMessage'])){

                                            echo "<div style='text-align:center' class='alert alert-success'><h5><strong>
                                                    {$_SESSION['submitMessage']}
                                                  </strong></h5></div>";

                                            unset($_SESSION['submitMessage']);
                                        }
                                    ?>
                                    <h4 class="gen-case" style="float:right">
                                    </h4>
                                    <h4>Request for Parts for Repair</h4>
                                </header>
                                <div class="panel-body ">

                                    <div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img src="images/chat-avatar2.jpg" alt="">
                                                <strong>Helpdesk</strong>
                                                to
                                                <strong>me</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <h5>Date Created:
                                                </h5>
                                            </div>
                                            <div class="col-md-8">
                                                <h5>Comments:
                                                </h5>
                                            </div>
                                            <div class="cp;-col-md-4"></div>
                                        </div>
                                    </div>
                                    <div class="view-mail">
                                        <p>
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <section class="panel">
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Asset Status</th>
                                                <th>Property Code</th>
                                                <th>Asset/ Software Name</th>
                                                <th>Building</th>
                                                <th>Room</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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

                                        <div class="form-group ">
                                            <div class="form-group ">
                                                <label for="category" class="control-label col-lg-4">Category</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-bot15" disabled>
                                                        <option selected="selected">Repair</option>
                                                        <option>Repair</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <label for="status" class="control-label col-lg-4">Status</label>
                                            <div class="col-lg-8">
                                                <select class="form-control m-bot15" name="status" readonly>
                                                    <option value='1' <?php if($status=='1' ) echo "selected" ;?> >Open</option>
                                                    <option value='2' <?php if($status=='2' ) echo "selected" ;?> >Assigned</option>
                                                    <option value='3' <?php if($status=='3' ) echo "selected" ;?> >In Progress</option>
                                                    <option value='4' <?php if($status=='4' ) echo "selected" ;?> >Transferred</option>
                                                    <option value='5' <?php if($status=='5' ) echo "selected" ;?> >Escalated</option>
                                                    <option value='6' <?php if($status=='6' ) echo "selected" ;?> >Waiting For Parts</option>
                                                    <option value='7' <?php if($status=='7' ) echo "selected" ;?> >Closed</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label for="priority" class="control-label col-lg-4">Priority</label>
                                            <div class="col-lg-8">
                                                <select class="form-control m-bot15" name="priority" readonly>
                                                    <option value="Low">Low</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="High">High</option>
                                                    <option value="Urgent">Urgent</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label for="assign" class="control-label col-lg-4">Escalate To</label>
                                            <div class="col-lg-8">
                                                <select class="form-control m-bot15" name="escalateUserID" id='escalateUser' disabled>
                                                    <option value='<?php echo $userID;?>'>None</option>
                                                    <?php
                                                            $query3="SELECT u.UserID,CONCAT(Convert(AES_DECRYPT(lastName,'Fusion')USING utf8),', ',Convert(AES_DECRYPT(firstName,'Fusion')USING utf8)) as `fullname` FROM thesis.user u join thesis.ref_usertype rut on u.userType=rut.id where rut.description='Engineer';";
                                                            $result3=mysqli_query($dbc,$query3);
                                                                    
                                                            while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
                                                                //if($assigneeUserID == $row3['UserID']){
                                                                    //echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
                                                                //}
																if($assigneeUserID != $row3['UserID']){
                                                                   echo "<option value='{$row3['UserID']}'>{$row3['fullname']}</option>";
                                                                }    
                                                            }   
                                                        ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Due Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control form-control-inline input-medium default-date-picker" size="10" type="text" value="<?php echo $dueDate;?>" disabled>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-sm-12">
                            <section class="panel">
                                <div class="panel-body ">
                                    <div>
                                        <h4>Requested Parts </h4>
                                    </div>

                                    <table class="table table-bordered table table-hover" id="addtable">
                                        <thead>
                                            <tr>
                                                <th style="display: none">AssetID</th>
                                                <th width="150">Quantity</th>
                                                <th>Category</th>
                                                <th>Specification</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type='number' min='0' step='1' class='form-control' name='quantity0' disabled>
                                                </td>
                                                <td width="300">
                                                    <select class="form-control" name="category0" disabled>
                                                        <option>Select Category</option>
                                                        <?php 

                                                        $sql = "SELECT * FROM thesis.ref_assetcategory;";

                                                        $result = mysqli_query($dbc, $sql);

                                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                        {
                                                            echo "<option value ={$row['assetCategoryID']}>";
                                                            echo "{$row['name']}</option>";
                                                        }

                                                    ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class='form-control' name='specification0' disabled>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <input style="display: none" type="number" id="count" name="count">
                                </div>
                            </section>
                            
                            <section class="panel">
                                <div class="panel-body ">
                                    <div>
                                        <h4>Parts to Be Given</h4>
                                    </div>

                                    <table class="table table-bordered table table-hover" id="addtable">
                                        <thead>
                                            <tr>
                                                <th style="display: none">AssetID</th>
                                                <th width="150">Property Code</th>
                                                <th>Brand</th>
                                                <th>Model</th>
                                                <th>Specification</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="300">
                                                    <select class="form-control">
                                                        <option>Select Property Code</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td>
                                                    <input class='form-control' name='specification0' disabled>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <input style="display: none" type="number" id="count" name="count">
                                </div>
                            </section>
                            <button type="submit" name="submit" id="submit" class="btn btn-success">Send</button>
                            <a href="engineer_all_ticket.php"><button type="button" class="btn btn-danger">Back</button></a>
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

    </script>

    <script src="js/scripts.js"></script>
    <script src="js/advanced-form.js"></script>

</body>

</html>
