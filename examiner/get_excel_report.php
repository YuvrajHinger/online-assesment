<?php
session_start();
if (empty($_SESSION['examiner_id'])) header("Location: login.php");
require_once 'database.php';
require_once 'excel_reader.php';
$query = "select * from active_exams where status=0 and examiner_id='" . $_SESSION['examiner_id'] . "' order by date desc";
$result = $con->query($query);
$index = 0;
$columnHeader = '';
$columnHeader = "Sr No" . "\t" . "CANDIDATE NAME" . "\t" . "EXAM" . "\t" . "Total Marks" . "\t" . "TOTAL QUESTION" . "\t" . "CORRECT" . "\t" . "WRONG" . "\t" . "SCORE" . "\t" . "NEGATIVE MARKING" . "\t";
$setData = '';
while ($fetchData = $result->fetch_assoc()) {
    $exam = $fetchData['title'];
    $date = $fetchData['date'];
    $total_question = $fetchData['total_question'];
    $negative_marking = $fetchData['negative_marking'];
    $total_marks = $fetchData['total_marks'];
    $result1 = $con->query("select * from report where exam_id='" . $fetchData['id'] . "'");
    while ($fetchData1 = $result1->fetch_assoc()) {
        $rowData = '';
        $index++;
        $applicant_id = $con->query("select candidate_username from candidate_login where candidate_id='" . $fetchData1['applicant_id'] . "'")->fetch_assoc();

        $applicant_id = $applicant_id['candidate_username'];

        $rowData .= '"' . $index . '"' . "\t";
        $rowData .= '"' . $applicant_id . '"' . "\t";
        $rowData .= '"' . $exam . '"' . "\t";
        $rowData .= '"' . $total_marks . '"' . "\t";
        $rowData .= '"' . $total_question . '"' . "\t";

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

        $rowData .= '"' . $correct . '"' . "\t";
        $rowData .= '"' . $wrong . '"' . "\t";
        $rowData .= '"' . $score . '"' . "\t";
        $rowData .= '"' . $negative_marking . '"' . "\t";
    }
    $setData .= trim($rowData) . "\n";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=candidate-report.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader) . "\n" . $setData . "\n";