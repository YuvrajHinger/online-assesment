<?php
session_start();
if (empty($_SESSION['examiner_id'])) header("Location: login.php");
require_once 'database.php';
require_once 'layout.php';
// ajax Query
$message = 0;
if (isset($_POST['generateTable'])) {
    $query = "select * from question where category='" . $_POST['generateTable'] . "' and status='0'";
    $getData = $con->query($query);
    $i = 0;
    $output = '';
    while ($fetchData = $getData->fetch_assoc()) {
        $i++;
        $id = $fetchData['question_id'];
        $question_text = $fetchData['question_text'];
        $output = $output . "<tr>
                <td>$i</td>
                <td>$question_text</td>
                <td><input type='checkbox' value='$id' onchange='selectQuestion(this.checked,this.value,this)'/></td>
            </tr>";
    }
    echo $output;
    unset($_POST['generateTable']);
    return;
}
if (isset($_POST['reset'])) {
    unset($_SESSION['save_data_step1']);
    unset($_SESSION['step']);
    unset($_POST['step2']);
}
class exam_detail
{
    var $exam_title;
    var $exam_date;
    var $exam_time;
    var $exam_duration;
    var $exam_purpose;
    var $exam_question;
    var $exam_marks;
    var $exam_key;
    var $negative_marking;
    var $quiz_id;
    function setStep1($i1, $i2, $i3, $i4, $i5, $i6, $i7, $i8, $i9)
    {
        $this->exam_title = $i1;
        $this->exam_date = date("y-m-d", strtotime($i2));
        $this->exam_time = $i3;
        $this->exam_duration = $i4;
        $this->exam_purpose = $i5;
        $this->exam_question = $i6;
        $this->exam_marks = $i7;
        $this->exam_key = $i8;
        $this->negative_marking = $i9;
    }
    function setStep2($i1)
    {
        $this->quiz_id = $i1;
    }
}
if (isset($_POST['step1'])) {
    $save_data = new exam_detail;
    $save_data->setStep1($_POST['exam_title'], $_POST['exam_date'], $_POST['exam_time'], $_POST['exam_duration'], $_POST['exam_purpose'], $_POST['exam_question'], $_POST['exam_marks'], $_POST['exam_key'], $_POST['negative_marking']);
    $_SESSION['save_data_step1'] = $save_data;
    $_SESSION['step'] = 1;
}
if (isset($_POST['step2'])) {
    $qid = $_POST['quiz_id'];
    $question_arr = '';
    foreach ($qid as $key => $value) {
        $question_arr = $question_arr . 'id' . $value;
    }
    $_SESSION['save_data_step1']->setStep2($question_arr);
    $_SESSION['step'] = 2;
}
if (isset($_POST['confirm_save'])) {
    $query = "insert into active_exams(title,date,time,duration,purpose,total_question,total_marks,exam_key,negative_marking,questions,examiner_id) values('" . $_SESSION['save_data_step1']->exam_title . "','" . $_SESSION['save_data_step1']->exam_date . "','" . $_SESSION['save_data_step1']->exam_time . "','" . $_SESSION['save_data_step1']->exam_duration . "','" . $_SESSION['save_data_step1']->exam_purpose . "','" . $_SESSION['save_data_step1']->exam_question . "','" . $_SESSION['save_data_step1']->exam_marks . "','" . $_SESSION['save_data_step1']->exam_key . "','" . $_SESSION['save_data_step1']->negative_marking . "','" . $_SESSION['save_data_step1']->quiz_id . "','" . $_SESSION['examiner_id'] . "')";
    if ($con->query($query)) $message = 1;
    else $message = -1;
    unset($_SESSION['save_data_step1']);
    unset($_SESSION['step']);
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
                            <h4><a>Generate Exam</a></h4>
                        </li>
                    </center>
                </ol>
                <div class="validation-system">
                    <div class="validation-form">
                        <!-- First layout -->
                        <?php if (!isset($_SESSION['step'])) { ?>

                        <div class="row">
                            <!-- List View -->
                            <div class="col-md-7">
                                <table class="table table-bordered table-hover myform">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Active Exams</th>
                                            <th>Date</th>
                                            <th>Authentication Key</th>
                                            <th>Posted By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $query = "select * from `active_exams` where status = '0' order by date desc";
                                            $getData = $con->query($query);
                                            $i = 0;
                                            while ($fetchData = $getData->fetch_assoc()) {
                                                $i++;
                                                $id = $fetchData['id'];
                                                $title = $fetchData['title'];
                                                $key = $fetchData['exam_key'];
                                                $date = $fetchData['date'];
                                                $date = date("d-m-y", strtotime($date));
                                                $fetchData1 = $con->query("select examiner_username from examiner_login where examiner_id='" . $fetchData['examiner_id'] . "'")->fetch_assoc();
                                                $name = $fetchData1['examiner_username']; ?>
                                        <tr>
                                            <td> <?php echo $i; ?></td>
                                            <td> <?php echo $title; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $key; ?></td>
                                            <td><?php echo $name; ?></td>
                                            <td>
                                                <a style="margin: 0px 0px 10px 0px;" class="btn btn-primary"
                                                    onclick="alert('You don\'t have access to this tool.')">Edit</a>
                                                <a style="margin: 0px 0px 10px 0px;" class="btn btn-danger"
                                                    onclick="alert('You don\'t have access to this tool.')">Delete</a>
                                                <!-- <a style="margin: 0px 0px 10px 0px;" class="btn btn-danger" 
                                                    rel="tooltip" title="Delete" data-toggle="modal"
                                                    href="#delete<?php echo $id; ?>">Delete</a>-->
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
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Add View -->
                            <div class="col-md-5">
                                <?php if ($message == 1) { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <i class="icon fa fa-angle-right"></i> Successfully Post Exam.
                                </div>
                                <?php } else if ($message == -1) { ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <i class="icon fa fa-ban"></i> Problem Inserting Data.
                                </div>
                                <?php } ?>
                                <form action="" method="post" class="myform">
                                    <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                        <label class="control-label"> Exam Title</label>
                                        <input type="text" name="exam_title" placeholder="Title" class="form-control"
                                            style=" border-radius: 20px; color: black;" autocomplete="off" autofocus
                                            required>
                                    </div>
                                    <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                        <label class="control-label"> Date of Exam</label>
                                        <input type="text" name="exam_date" class="form-control datepicker"
                                            style=" border-radius: 20px; color: black;" autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                        <label class="control-label"> Time of Exam</label>
                                        <input type="time" name="exam_time" placeholder="Exam time" class="form-control"
                                            style=" border-radius: 20px; color: black;" autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                        <label class="control-label"> Duration</label>
                                        <input type="time" name="exam_duration" placeholder="Exam Duration"
                                            class="form-control" style=" border-radius: 20px; color: black;"
                                            autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                        <label class="control-label"> Purpose</label>
                                        <input type="text" name="exam_purpose" placeholder="Purpose"
                                            class="form-control" style=" border-radius: 20px; color: black;"
                                            autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                        <label class="control-label"> Nos Of Question</label>
                                        <input type="number" name="exam_question" placeholder="nos of questions"
                                            class="form-control" style=" border-radius: 20px; color: black;"
                                            autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                        <label class="control-label"> Total Marks</label>
                                        <input type="number" name="exam_marks" placeholder="Total marks"
                                            class="form-control" style=" border-radius: 20px; color: black;"
                                            autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                        <label class="control-label"> Security Key</label>
                                        <input type="text" name="exam_key" placeholder="Authentication Key"
                                            class="form-control" style=" border-radius: 20px; color: black;"
                                            autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6" style="margin: 0px 0px 20px 0px;">
                                        <label class="control-label"> Negative Marking</label>
                                        <div data-toggle="buttons">
                                            <label class="btn btn-option" style="border-radius: 20px;">
                                                <input type="radio" name="negative_marking" value="yes" /> Yes
                                            </label>
                                            <label class="btn btn-option active" style="border-radius: 20px;">
                                                <input type="radio" name="negative_marking" value="no" checked /> NO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <button type="submit" style="border-radius: 20px;" class="btn btn-primary"
                                            name="step1">Submit</button>
                                        <button type="reset" style="border-radius: 20px;" class="btn btn-default"
                                            value="reset">Reset</button>
                                    </div>
                                    <div class="clearfix"> </div>
                                </form>
                            </div>
                        </div>
                        <!-- Second Layout of Add View -->
                        <?php } else if ($_SESSION['step'] == 1) { ?>
                        <form id="finalSubmit" class="row" method="post">
                            <input id="totalRows" name="step2" type="hidden"
                                value="<?php echo $_SESSION['save_data_step1']->exam_question; ?>" />
                            <div class="col-md-5">
                                <h4 class="float-left">Total Question:
                                    <?php echo $_SESSION['save_data_step1']->exam_question; ?></h4>
                                <h4 class="float-right">Selected Question: <a id="putRows">0</a></h4>
                                <div class="clearfix"></div>
                                <div class="form-group float-right">
                                    <button type="button" onclick="submitStep2()" style="border-radius: 20px;"
                                        class="btn btn-primary">Submit</button>
                                    <button type="submit" style="border-radius: 20px;" class="btn btn-default"
                                        name="reset">Cancel</button>
                                </div>
                                <div class="clearfix"></div>
                                <table id="putTable" class="table table-bordered table-hover myform">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-7">
                                <label class="control-label">Category</label>
                                <select onchange="generateTable(this.value)" style="border-radius: 20px;"
                                    class="form-control select2" name="title">
                                    <option value="">Select category</option>
                                    <?php $result = $con->query("SELECT * FROM category where status='0'");
                                        while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['title']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="float-right">
                                    <label class="control-label">Select All</label>
                                    <input type="checkbox" onchange="selectAll(this.checked)" />
                                </div>
                                <table id="getTable" class="table table-bordered table-hover myform">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="question_tbody">
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <!--  Final Layout of Add View -->
                        <?php } else if ($_SESSION['step'] == 2) { ?>
                        <form id="confirm_submit" class="row" method="post">
                            <h4 class="text-center">Confirm Details</h4>
                            <div class="col-md-5">
                                <table id="getTable" class="table table-bordered table-hover myform">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $str = explode('id', $_SESSION['save_data_step1']->quiz_id);
                                            $avg = $_SESSION['save_data_step1']->exam_marks / $_SESSION['save_data_step1']->exam_question;
                                            for ($i = 1; $i < count($str); $i++) {
                                                $query = "select * from question where question_id='" . $str[$i] . "'";
                                                $getData = $con->query($query);
                                                $fetchData = $getData->fetch_assoc();
                                            ?>
                                        <tr>
                                            <td><?php echo $fetchData['question_text']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-7">
                                <div class="myform">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>exam title</label>
                                            <input type="text" readonly
                                                value="<?php echo $_SESSION['save_data_step1']->exam_title ?>"
                                                class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>exam date</label>
                                            <input type="text" readonly
                                                value="<?php echo $_SESSION['save_data_step1']->exam_date ?>"
                                                class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>exam time</label>
                                            <input type="text" readonly
                                                value="<?php echo $_SESSION['save_data_step1']->exam_time ?>"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>exam duration</label>
                                            <input type="text" readonly
                                                value="<?php echo $_SESSION['save_data_step1']->exam_duration ?>"
                                                class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>exam purpose</label>
                                            <input type="text" readonly
                                                value="<?php echo $_SESSION['save_data_step1']->exam_purpose ?>"
                                                class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>exam question</label>
                                            <input type="text" readonly
                                                value="<?php echo $_SESSION['save_data_step1']->exam_question ?>"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>exam marks</label>
                                            <input type="text" readonly
                                                value="<?php echo $_SESSION['save_data_step1']->exam_marks ?>"
                                                class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>exam key</label>
                                            <input type="text" readonly
                                                value="<?php echo $_SESSION['save_data_step1']->exam_key ?>"
                                                class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>negative marking</label>
                                            <input type="text" readonly
                                                value="<?php echo $_SESSION['save_data_step1']->negative_marking ?>"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="submit" style="border-radius: 20px;" class="btn btn-primary"
                                        name="confirm_save">Confirm Save</button>
                                    <button type="submit" style="border-radius: 20px;" class="btn btn-default"
                                        name="reset">Cancel</button>
                                </div>
                            </div>
                        </form>
                        <?php } ?>
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

        .btn-option {
            font-family: monospace;
            margin: 5px;
            color: black;
            font-family: monospace;
            background-color: whitesmoke;
            border-color: #285e8e;
        }

        .btn-option:hover {
            color: white;
            font-family: monospace;
            background-color: seagreen;
            border-color: #285e8e;
        }

        .btn-option:focus,
        .btn-option:active,
        .btn-option.active,
        .open>.dropdown-toggle.btn-option {
            color: white;
            font-family: monospace;
            background-color: darkslategrey;
            border-color: #285e8e;
        }
        </style>
        <script>
        function selectAll(value) {
            if (value) {
                checkbox = document.querySelectorAll('input[type="checkbox"]');
                for (i = 1; i < checkbox.length; i++)
                    checkbox[i].click();
            }
        }

        function generateTable(value) {
            if (value) {
                $.ajax({
                    url: '',
                    type: 'post',
                    data: {
                        "generateTable": value
                    },
                    success: function(response) {
                        document.getElementById('question_tbody').innerHTML = response;
                    }
                });
            }
        }

        function selectQuestion(condition, value, index) {
            if (condition) {
                index = index.parentNode.parentNode.rowIndex;
                var get_table = document.getElementById("getTable").getElementsByTagName('tbody')[0];
                var put_table = document.getElementById("putTable").getElementsByTagName('tbody')[0];
                var data = get_table.rows[index - 1].cells[1].innerHTML;
                var length = put_table.rows.length;
                var i = 0;
                for (i = 0; i < length; i++) {
                    var check_data = put_table.rows[i].cells[0].innerHTML;
                    if (check_data == data) {
                        alert("Already Added..|");
                        break;
                    }
                }
                if (i != length) return;
                if (length >= totalRows.value) {
                    alert("Nos of Question Exceed. |");
                    return;
                }
                var row = put_table.insertRow();
                var cell1 = row.insertCell();
                var cell2 = row.insertCell();
                cell1.innerHTML = data;
                cell2.innerHTML = '<input type="hidden" name="quiz_id[]" value="' + value +
                    '"/><a class="btn btn-default" style="border-radius: 20px;" onclick="delete_option(\'putTable\',this)">Delete</a>';
                putRows.innerHTML = put_table.rows.length;
            }
        }

        function delete_option(tableId, i) {
            i = i.parentNode.parentNode.rowIndex;
            var put_table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
            put_table.deleteRow(i - 1);
            putRows.innerHTML = put_table.rows.length;
        }

        function submitStep2() {
            if (totalRows.value != putRows.innerHTML) {
                alert('Selected Question count must equal to Total Question |');
                return;
            }
            finalSubmit.submit();
        }
        </script>
    </div>
</body>

</html>