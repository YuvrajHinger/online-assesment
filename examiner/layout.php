<?php
function head()
{                                    ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../include/plugins/timepicker/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="../include/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" type="text/css" href="../include/plugins/select2/bootstrap-select.min.css" />
<link rel="stylesheet" type="text/css" href="../include/plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css" href="../include/plugins/select2/multi-select.css" />
<link href="../include/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="../include/css/jquery-ui.css">
<link href="../include/css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="../include/css/morris.css" type="text/css" />
<link href="../include/css/font-awesome.css" rel="stylesheet">
<script src="../include/js/jquery-2.1.4.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../include/css/icon-font.min.css" type='text/css' /> <?php
                                                                                    }
                                                                                    function sidebar()
                                                                                    {                         ?>
<div id="logout" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <form action="logout.php" method="post">
            <div class="modal-content">
                <div class="modal-header" style=" background-color: #3E3A86;color:#fff;">
                    <button type="button" class="close" style="color:#fff !important;opacity:1"
                        data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        Stay Attention
                    </h4>
                </div>
                <div class="modal-body">
                    <h4 class="modal-title">
                        Confirm log-out
                    </h4>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" name="logout">Yes</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="sidebar-menu">
    <header class="logo1">
        <a onclick="toggleSideBar()" class="sidebar-icon">
            <span class="fa fa-bars"></span>
        </a>
    </header>
    <div style="border-top:1px ridge rgba(255, 255, 255, 0.15)"></div>
    <div class="menu">
        <ul id="menu">
            <li>
                <a href="index.php">
                    <i class="fa fa-tachometer"></i>
                    <span>Dashboard</span>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li id="menu-academico">
                <a href="candidate.php">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span> Candidate</span>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li id="menu-academico">
                <a href="examiner.php">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span>Examiner</span>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li id="menu-academico">
                <a href="category.php">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span>Category</span>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <a href="add_question.php">
                    <i class="fa fa-question"></i>
                    <span>Add Question</span>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <a href="active_exam.php">
                    <i class="fa fa-sticky-note-o"></i>
                    <span>Active Exam</span>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <a href="report.php">
                    <i class="fa fa-asterisk"></i>
                    <span>Exam Results</span>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <a href="#logout" rel="tooltip" title="log-out" data-toggle="modal">
                    <i class="fa fa-sign-out"></i>
                    <span>Log-Out</span>
                    <div class="clearfix"></div>
                </a>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
</div> <?php
                                                                                    }
                                                                                    function script()
                                                                                    {  ?>
<script>
window.onload = function() {
    history.replaceState("", "", "");
}
$(function() {
    $(".select2").select2();
    $('.select2-input').addClass('form-control');
    $('.timepicker').timepicker();
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        todayHighlight: true
    });
    $('.datepicker').attr('placeholder', 'DD-MM-YYYY');
});
var toggle = true;

function toggleSideBar() {
    if (toggle) {
        $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
        $("#menu span").css({
            "position": "absolute"
        });
    } else {
        $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
        setTimeout(function() {
            $("#menu span").css({
                "position": "relative"
            });
        }, 400);
    }
    toggle = !toggle;
}
</script>
<script src="../include/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="../include/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="../include/plugins/select2/bootstrap-select.min.js"></script>
<script src="../include/plugins/select2/select2.min.js"></script>
<script src="../include/plugins/select2/jquery.multi-select.js"></script>
<script src="../include/js/scripts.js"></script>
<script src="../include/js/bootstrap.min.js"></script> <?php
                                                                                    }   ?>