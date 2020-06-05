<?php
session_start();
if (empty($_SESSION['examiner_id'])) header("Location: login.php");
require_once 'database.php';
require_once 'layout.php';
if (isset($_POST['detail_view'])) {
    $_SESSION['detail_applicant_id'] = $_POST['candidate_id'];
    $_SESSION['detail_exam_id'] = $_POST['exam_id'];
    $_SESSION['score'] = $_POST['score'];
    header("Location: report_detail.php");
}
if (isset($_POST['filter_search'])) {
    if ($_POST['search_by_exam']) {
        if ($_POST['search_by_candidate']) {
        } else {
        }
    } else if ($_POST['search_by_candidate']) {
    }
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
                            <h4><a>Report</a></h4>
                        </li>
                    </center>
                </ol>
                <ol class="breadcrumb">
                    <hr>
                    <form action="" method="post" class="myform">
                        <div class="row">
                            <div class="col-md-3" style="margin: 5px;">
                                <select name="search_by_exam" class="form-control select2">
                                    <option value="" selected>Search By Exam</option>
                                    <?php $result = $con->query("SELECT Distinct exam_id FROM report");
                                    while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['exam_id'] ?>">
                                        <?php
                                            $result1 = $con->query("SELECT title FROM active_exams where id='" . $row['exam_id'] . "'");
                                            $row1 = $result1->fetch_assoc();
                                            echo $row1['title'];
                                            ?>
                                    </option> <?php } ?>
                                </select>

                            </div>
                            <div class="col-md-3" style="margin: 5px;">
                                <select name="search_by_candidate" class="form-control select2" name="title">
                                    <option value="" selected>Search By Candidate</option>
                                    <?php $result = $con->query("SELECT Distinct applicant_id FROM report");
                                    while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['applicant_id'] ?>">
                                        <?php
                                            $result1 = $con->query("SELECT candidate_username FROM candidate_login where candidate_id='" . $row['applicant_id'] . "'");
                                            $row1 = $result1->fetch_assoc();
                                            echo $row1['candidate_username'];
                                            ?>
                                    </option> <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-5" style="margin: 5px;">
                                <button type="submit" class="btn btn-primary" name="filter_search">Filter</button>
                                <button class="btn btn-primary" onclick="window.location.href=''">Reset</button>
                                <a class="btn btn-primary" href="get_excel_report.php">
                                    Download Excel
                                </a>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="bg-light table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Candidate Name</th>
                                    <th>Exam</th>
                                    <th>Date</th>
                                    <th>Total Question</th>
                                    <th>Correct</th>
                                    <th>Wrong</th>
                                    <th>Score</th>
                                    <th>Negative Marking</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "select * from active_exams where status=0 and examiner_id='" . $_SESSION['examiner_id'] . "' order by date desc";
                                $result = $con->query($query);
                                $index = 0;
                                while ($fetchData = $result->fetch_assoc()) {
                                    $exam = $fetchData['title'];
                                    $date = $fetchData['date'];
                                    $total_question = $fetchData['total_question'];
                                    $negative_marking = $fetchData['negative_marking'];
                                    $total_marks = $fetchData['total_marks'];
                                    $result1 = $con->query("select * from report where exam_id='" . $fetchData['id'] . "'");
                                    while ($fetchData1 = $result1->fetch_assoc()) {
                                        $index++;
                                        $applicant_id = $con->query("select candidate_username from candidate_login where candidate_id='" . $fetchData1['applicant_id'] . "'")->fetch_assoc();
                                        $applicant_id = $applicant_id['candidate_username'];
                                        $report = $fetchData1['report'];
                                        $report = json_decode($report);
                                        $correct = 0;
                                        $wrong = 0;
                                        $score = 0;
                                        $count = count($report);
                                        for ($i = 0; $i < $count; $i++) {
                                            $qid = $report[$i]->qid;
                                            $aid = $report[$i]->aid;
                                            $data = $con->query("select answer_id from question where question_id='$qid' and status='0'")->fetch_assoc();
                                            $data = $data['answer_id'];
                                            if ($aid == $data) $correct++;
                                            else $wrong++;
                                        }
                                        $score = $correct;
                                        if ($negative_marking == "yes") {
                                            $score = $score - ($wrong / 2);
                                        }
                                        $score = $score * $total_marks / $total_question;
                                ?>
                                <tr>
                                    <td><?php echo $index; ?></td>
                                    <td><?php echo $applicant_id; ?></td>
                                    <td><?php echo $exam; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $total_question; ?></td>
                                    <td><?php echo $correct; ?></td>
                                    <td><?php echo $wrong; ?></td>
                                    <td><?php echo $score . "/" . $total_marks; ?></td>
                                    <td><?php echo $negative_marking; ?></td>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="candidate_id"
                                                value="<?php echo $fetchData1['applicant_id']; ?>" />
                                            <input type="hidden" name="exam_id"
                                                value="<?php echo $fetchData['id']; ?>" />
                                            <input type="hidden" name="score" value="<?php echo $score; ?>" />
                                            <button class="btn btn-primary" name="detail_view" type="submit">Detail
                                                View</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </ol>
            </div>
        </div>
        <?php script(); ?>
        <?php sidebar(); ?>
    </div>
</body>

</html>