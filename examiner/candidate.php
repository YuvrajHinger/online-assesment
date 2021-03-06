<?php
session_start();
if (empty($_SESSION['examiner_id'])) header("Location: login.php");
require_once 'database.php';
require_once 'layout.php';
$flag = 0;
$delete_alert = 0;
if (isset($_POST['candidate_submit'])) {
    $candidate_username = $_POST['candidate_username'];
    $result = $con->query("select candidate_id from candidate_login where candidate_username='$candidate_username'");
    $count = $result->num_rows;
    if ($count == 0) {
        $candidate_password = $_POST['candidate_password'];
        $query = "INSERT INTO candidate_login(candidate_username,candidate_password) VALUES ('$candidate_username','$candidate_password')";
        $con->query($query);
        $flag = 1;
    } else $flag = -1;
}
if (isset($_POST['delete_id'])) {
    $delete_alert = 1;
    $delete_id = $_POST['delete_id'];
    if ($con->query("update `candidate_login` SET `status`='1' where candidate_id='$delete_id'")) $delete_alert = 1;
    else $delete_alert = -1;
}
if (isset($_POST['edit_id'])) {
    $_SESSION['candidate_edit_id'] = $_POST['edit_id'];
    header("Location: candidate_edit.php");
}
?>
<html>

<head>
    <?php head(); ?>
</head>

<body>
    <div class="page-container">
        <div class="left-content">
            <div class="mother-grid-inner">
                <ol class="breadcrumb">
                    <center>
                        <li class="breadcrumb-item">
                            <h4>
                                <a>Candidate View</a>
                            </h4>
                        </li>
                    </center>
                </ol>
                <div class="validation-system">
                    <div class="validation-form">
                        <div class="row">
                            <div class="col-md-7" style="margin-bottom: 10px">
                                <?php if ($delete_alert == 1) { ?><div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button><i class="icon fa fa-angle-right"></i> Successfully
                                    Deleted Candidate.</div> <?php  } else if ($delete_alert == -1) { ?><div
                                    class="alert alert-danger alert-dismissible"><button type="button" class="close"
                                        data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-ban"></i>
                                    Problem Deleting Data.</div> <?php  } ?>
                                <table class="table table-bordered table-hover myform">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $query = "select * from `candidate_login` where status = '0'";
                                        $getData = $con->query($query);
                                        $i = 0;
                                        while ($fetchData = $getData->fetch_assoc()) {
                                            $i++;
                                            $id = $fetchData['candidate_id'];
                                            $username = $fetchData['candidate_username'];
                                            $password = $fetchData['candidate_password']; ?>
                                        <tr>
                                            <td> <?php echo $i; ?></td>
                                            <td><?php echo $username; ?></td>
                                            <td><?php echo $password; ?></td>
                                            <td>
                                                <a class="btn btn-primary" rel="tooltip" title="Edit"
                                                    data-toggle="modal" href="#edit<?php echo $id; ?>">Edit</a>
                                                <a class="btn btn-danger" rel="tooltip" title="Delete"
                                                    data-toggle="modal" href="#delete<?php echo $id; ?>">Delete</a>
                                                <div id="delete<?php echo $id; ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog modal-md">
                                                        <form method="post" class="modal-content">
                                                            <div class="modal-header"
                                                                style=" background-color: #3E3A86;color:#fff;"><button
                                                                    type="button" class="close"
                                                                    style="color:#fff !important;opacity:1"
                                                                    data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Stay Attention</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h4 class="modal-title">Are you sure you want to remove
                                                                    this record?</h4>
                                                            </div>
                                                            <input type="hidden" value="<?php echo $id; ?>"
                                                                name="delete_id">
                                                            <div class="modal-footer"><button type="submit"
                                                                    class="btn btn-sm btn-primary"
                                                                    name="deleteAction">Yes</button><button
                                                                    type="button" class="btn btn-sm btn-danger"
                                                                    data-dismiss="modal">Cancel</button></div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div id="edit<?php echo $id; ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog modal-md">
                                                        <form method="post" class="modal-content">
                                                            <div class="modal-header"
                                                                style=" background-color: #3E3A86;color:#fff;"><button
                                                                    type="button" class="close"
                                                                    style="color:#fff !important;opacity:1"
                                                                    data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Stay Attention</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h4 class="modal-title">Are you sure you want to edit
                                                                    this record?</h4>
                                                            </div>
                                                            <input type="hidden" value="<?php echo $id; ?>"
                                                                name="edit_id">
                                                            <div class="modal-footer"><button type="submit"
                                                                    class="btn btn-sm btn-primary"
                                                                    name="deleteAction">Yes</button><button
                                                                    type="button" class="btn btn-sm btn-danger"
                                                                    data-dismiss="modal">Cancel</button></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-5" style="margin-bottom: 10px">
                                <a href="add_candidate_ByExcel.php" class="float-right btn btn-warning">
                                    <i class="fa fa-file-excel-o"> Excel</i>
                                </a>
                                <form action="" method="post" class="myform">
                                    <div class="col-md-12 form-group1 group-mail">
                                        <label class="control-label"> Candidate Username</label>
                                        <input type="text" name="candidate_username" class="form-control"
                                            placeholder="username" style=" border-radius: 20px; color: black;" autofocus
                                            required>
                                    </div>
                                    <div class="clearfix"> </div>
                                    <div class="col-md-12 form-group1 group-mail">
                                        <label class="control-label"> Candidate Password</label>
                                        <input type="password" name="candidate_password" class="form-control"
                                            placeholder="password" style=" border-radius: 20px; color: black;" required>
                                    </div>
                                    <div class="clearfix"> </div>
                                    <?php if ($flag == 1) { ?> <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button><i class="icon fa fa-angle-right"></i>
                                        Successfully Registerd Candidate.</div> <?php  } else if ($flag == -1) { ?><div
                                        class="alert alert-danger alert-dismissible"><button type="button" class="close"
                                            data-dismiss="alert" aria-hidden="true">×</button><i
                                            class="icon fa fa-ban"></i> Problem Inserting Data.</div> <?php  } ?>
                                    <div class="col-md-12 form-group">
                                        <button type="submit" style="border-radius: 20px;" class="btn btn-primary"
                                            name="candidate_submit">Submit</button>
                                        <button type="reset" style="border-radius: 20px;" class="btn btn-default"
                                            value="reset">Reset</button>
                                    </div>
                                    <div class="clearfix"> </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php script(); ?>
        <?php sidebar(); ?>
        <style>
        .myform {
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
        }
        </style>
    </div>
</body>

</html>