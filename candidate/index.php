<?php
    session_start();
    if(empty($_SESSION['candidate_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';    
    if(isset($_POST['applyAction'])){
        $exam_id=$_POST['exam_id'];
        $applicant_id=$_SESSION['candidate_id'];
        $query="insert into exam_applicant(exam_id,applicant_id) values('$exam_id','$applicant_id')";        
        $con->query($query);
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
                                <h4><a>Dashboard</a></h4>                                                                                            
                            </li>
                        </center>
		            </ol>
                    
                    <div class="row">
                        <?php                        
                            date_default_timezone_set('Asia/Calcutta');                            
                            $cdate=date("y-m-d");
                            $ctime=date("h:i:s");
                            $query="select * from active_exams where status=0 and (date>='$cdate')";
                            $getData=$con->query($query);
                            $i=0;
                            while($fetchData=$getData->fetch_assoc()){
                                $i++;
                                $id=$fetchData['id'];                        
                                $query="select * from exam_applicant where exam_id='$id' and applicant_id='".$_SESSION['candidate_id']."'";
                                $result=$con->query($query);
                                $count=$result->num_rows;                                
                                $date=$fetchData['date'];                                                                                                                                                            
                                $date=date("d M Y",strtotime($date));                                    
                                $time=$fetchData['time'];
                                $title=$fetchData['title'];                                                                      
                                $purpose=$fetchData['purpose'];                                    
                                $fetchData1=$con->query("select examiner_username from examiner_login where status=0 and examiner_id='".$fetchData['examiner_id']."'")->fetch_assoc(); $by=$fetchData1['examiner_username'];
                        ?>
                        <div class="col-md-3">
                            <div class="myform bg-light">
                                <h3><?php echo $title;?></h3>
                                <h4>Date of Exam: <a><?php echo $date;?></a></h4>
                                <h4>Time: <a><?php echo $time;?></a></h4>
                                <h4>Purpose: <a><?php echo $purpose;?></a></h4>
                                <h4>By: <a><?php echo $by;?></a></h4><hr>                                
                                <?php if($count==0){ ?>
                                <a rel="tooltip" title="apply"  data-toggle="modal" href="#apply<?php echo $id ;?>" class="btn btn-warning">Apply</a>
                                <div id="apply<?php echo $id ;?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-md" >
                                        <form method ="post" class="modal-content">                                                        
                                            <div class="modal-header" style=" background-color: #3E3A86;color:#fff;"><button type="button" class="close" style="color:#fff !important;opacity:1" data-dismiss="modal">&times;</button><h4 class="modal-title" >Stay Attention</h4></div>
                                            <div class="modal-body"><h4 class="modal-title">Apply Confirm</h4></div>
                                            <input type="hidden" value="<?php echo $id; ?>" name="exam_id">
                                            <div class="modal-footer"><button type="submit" class="btn btn-sm btn-primary" name="applyAction">Yes</button><button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button></div>
                                        </form>
                                    </div>
                                </div>
                                <?php }
                                else{ ?>
                                <a class="btn btn-success" disabled><i class="fa fa-check"></i>Applyed</a>    
                                <?php }?>
                            </div>
                        </div>                        
                        <?php } ?>
                    </div>

                </div>
            </div>
            <?php sidebar(); ?>
        </div>
        <?php script(); ?>
        <style>
            .myform{
                margin: 0px 0px 10px 0px;
                padding: 30px;                                    
                box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
            }            
        </style>
    </body>
</html>