<?php
session_start();
if (empty($_SESSION['candidate_id'])) header("Location: login.php");
require_once 'database.php';
require_once 'layout.php';
if (isset($_POST['detail_submit'])) {
    $candidate_id = $_POST['candidate_id'];
    $name = $_POST['name'];
    $hsc = $_POST['hsc'];
    $ssc = $_POST['ssc'];
    $highqualification = $_POST['higherqualification'];
    $query = "insert into candidate_detail(candidate_id,name,hsc,ssc,higherstudies) values('$candidate_id','$name','$hsc','$ssc','$highqualification')";
    $con->query($query);
    $success = "Data inserted Successfully.!";
}
if (isset($_POST['detail_update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $hsc = $_POST['hsc'];
    $ssc = $_POST['ssc'];
    $highqualification = $_POST['higherqualification'];
    $query = "update candidate_detail set name='$name',hsc='$hsc',ssc='$ssc',higherstudies='$highqualification' where id='$id'";
    $con->query($query);
    $success = "Data Updated Successfully.!";
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
                            <h4><a>Profile</a></h4>
                        </li>
                    </center>
                </ol>
                <div class="breadcrumb">
                    <?php if (isset($success)) { ?><div class="alert alert-success alert-dismissible"><button
                            type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-angle-right"></i> <?php echo $success; ?></div> <?php  } ?>
                    <div class="row">
                        <?php
                        $query = "select * from  candidate_detail where candidate_id='" . $_SESSION['candidate_id'] . "'";
                        $result = $con->query($query);
                        $count = $result->num_rows;
                        if (!$count) {
                        ?>
                        <div class="col-md-12">
                            <div class="myform bg-light">
                                <form action="" method="post">
                                    <h4 class="text-center">Profile.</h4>
                                    <hr>
                                    <input type="hidden" name="candidate_id"
                                        value="<?php echo $_SESSION['candidate_id']; ?>">
                                    <label for="name">NAME</label><input type="text" class="form-control" name="name"
                                        id="name" placeholder="name" required><br>
                                    <label for="hsc">HSC MARKS</label><input type="text" class="form-control" name="hsc"
                                        id="hsc" placeholder="hsc result" required><br>
                                    <label f or="ssc">SSC MARKS</label><input type="text" class="form-control"
                                        name="ssc" id="ssc" placeholder="ssc result" required><br>
                                    <label for="higherqualification">HIGHER QUALIFICATION AGGREGATE</label><input
                                        type="text" class="form-control" name="higherqualification"
                                        id="higherqualification" placeholder="Aggregate" required>
                                    <hr>
                                    <button name="detail_submit" class="btn btn-primary" type="submit">Save
                                        Details</button>
                                </form>
                            </div>
                        </div>
                        <?php } else {
                            $result = $result->fetch_assoc(); ?>
                        <div class="col-md-12">
                            <div class="myform bg-light">
                                <form action="" method="post">
                                    <h4 class="text-center">Profile.</h4>
                                    <hr>
                                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                    <label for="name">NAME</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="<?php echo $result['name'] ?>" placeholder="name" required><br>
                                    <label for="hsc">HSC MARKS</label>
                                    <input type="text" class="form-control" name="hsc" id="hsc"
                                        value="<?php echo $result['hsc'] ?>" placeholder="hsc result" required><br>
                                    <label f or="ssc">SSC MARKS</label>
                                    <input type="text" class="form-control" name="ssc"
                                        value="<?php echo $result['ssc'] ?>" id="ssc" placeholder="ssc result"
                                        required><br>
                                    <label for="higherqualification">HIGHER QUALIFICATION AGGREGATE</label>
                                    <input type="text" class="form-control" name="higherqualification"
                                        id="higherqualification" value="<?php echo $result['higherstudies'] ?>"
                                        placeholder="Aggregate" required>
                                    <hr>
                                    <button name="detail_update" class="btn btn-primary" type="submit">Update
                                        Details</button>
                                </form>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php sidebar(); ?>
    </div>
    <?php script(); ?>
</body>

</html>