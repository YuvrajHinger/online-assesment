<?php
    session_start();
    if(empty($_SESSION['candidate_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';      
    $message=0;  
    if(isset($_POST['startAction'])){
        $key=$_POST['key'];
        $active_exam=$_POST['start_exam'];
        $result=$con->query("select exam_key from active_exams where id='$active_exam'")->fetch_assoc();
        $result=$result['exam_key'];        
        if($result==$key){
            $_SESSION['active_exam']=$active_exam;
            header("Location: start_exam.php");
        }   
        else{
            $message=1;
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
                                <h4><a>Examination</a></h4>
                            </li>
                        </center>
		            </ol>
                    <div class="breadcrumb">                        
                        <div class="float-right">
                            <h4><a class="btn btn-danger" id="letmehide" onclick="get_exam_chart_class(0)">View All <i class="fa fa-angle-down"></i></a></h4>
                            <h4><a class="btn btn-danger" style="display: none;" id="letmeshow" onclick="get_exam_chart_class(1)">Hide All <i class="fa fa-angle-up"></i></a></h4>
                        </div>     
                        <div class="clearfix"></div><hr>                   
                        <?php if($message==1) echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-ban"></i> Enter Correct Authentication Key.</div>';                                                    
                            $query="select * from exam_applicant where applicant_id='".$_SESSION['candidate_id']."'";
                            $result=$con->query($query);
                            while($fetchData=$result->fetch_assoc()){
                                $exam_id=$fetchData['exam_id'];
                                $query="select * from report where exam_id='$exam_id' and applicant_id='".$_SESSION['candidate_id']."'";    
                                $result1=$con->query($query);
                                $apply_count=$result1->num_rows;	                        
                                $query="select * from active_exams where id='$exam_id'";
                                $result1=$con->query($query);
                                $fetchData1=$result1->fetch_assoc();
                                $title=$fetchData1['title'];
                                date_default_timezone_set('Asia/Calcutta');                            
                                $cdate=date("Y-m-d");
                                $date=$fetchData1['date'];                                                                                                                                                                                        
                                if($cdate==$date) $wait=0;
                                else if($cdate<$date){
                                    $wait=1;
                                    $d1=date_create($cdate);
                                    $d2=date_create($date);
                                    $diff=date_diff($d1,$d2);
                                }
                                else $wait=-1;
                                $date=date("d M Y",strtotime($date));                                    
                                $time=$fetchData1['time'];                                                                                                  
                                $purpose=$fetchData1['purpose'];                                    
                                $negative_marking=$fetchData1['negative_marking'];                                    
                                $total_marks=$fetchData1['total_marks'];                                    
                                if($apply_count>0) $wait=2;
                        ?>
                        <div class="myform bg-light exam_chart">
                            <h4 class="text-center"><?php echo $title; ?></h4>
                            <a class="float-right text-danger">Time: <?php echo $time; ?></a>
                            <a class="float-left text-danger">Date: <?php echo $date; ?></a>
                            <div class="clearfix"></div><hr>
                            <h4>Detail</h4>
                            <label>Purpose: <a><?php echo $purpose; ?></a></label><br>
                            <label>Negative Marking: <a><?php echo $negative_marking; ?></a></label><br>
                            <label>Total Marks: <a><?php echo $total_marks; ?></a></label>
                            <hr>                        
                            <div class="text-center">
                            <?php if($wait==0){?>
                                <a class="btn btn-success" data-toggle="modal" href="#start<?php echo $exam_id;?>">Start Exam</a>
                                <div id="start<?php echo $exam_id;?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-md" >
                                        <form method ="post" class="modal-content">                                                        
                                            <div class="modal-header" style=" background-color: #3E3A86;color:#fff;"><button type="button" class="close" style="color:#fff !important;opacity:1" data-dismiss="modal">&times;</button><h4 class="modal-title" >Start Exam</h4></div>
                                            <div class="modal-body">                                  
                                                <h4 class="modal-title">To Confirm Press Yes</h4>          
                                                <input class="form-control" name="key" type="text" placeholder="Authentication Key" required/>
                                                <label>Exam Title: <a><?php echo $title; ?></a><label>                                            
                                            </div>
                                            <input type="hidden" value="<?php echo $exam_id; ?>" name="start_exam">
                                            <div class="modal-footer"><button type="submit" class="btn btn-sm btn-primary" name="startAction">Yes</button><button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button></div>
                                        </form>
                                    </div>
                                </div>
                            <?php }
                            else if($wait==-1){ ?>
                                <a class="btn btn-danger exam_status" disabled>Expired</a>
                            <?php }
                            else if($wait==2){ ?>
                                <a class="btn btn-success exam_status" disabled>completed</a>
                            <?php }
                            else{ ?>
                                <a class="btn btn-primary exam_status" disabled><?php echo $diff->format('%a days');?> Remaining</a>
                            <?php }?>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php sidebar(); ?>
        </div>        
        <?php script(); ?>
        <script>
        exam_chart_class();
        function exam_chart_class(){            
            classes=document.getElementsByClassName("exam_chart");
            in_classes=document.getElementsByClassName("exam_status");
            var exam_chart_count=classes.length;
            for(var i=0;i<exam_chart_count;i++){
                temp=in_classes[i].innerHTML;
                if(temp=='Expired' || temp=='completed')
                    classes[i].style.display='none'; 
            }
        }
        function get_exam_chart_class(abc){
            if(abc==0){
                letmehide.style.display='none';
                letmeshow.style.display='block';
                classes=document.getElementsByClassName("exam_chart");
                exam_chart_count=classes.length;
                for(i=0;i<exam_chart_count;i++){
                    classes[i].style.display='block'; 
                }
            }
            else{
                letmehide.style.display='block';
                letmeshow.style.display='none';
                exam_chart_class();
            }                        
        }
        </script>
        <style>
            .myform{
                margin: 0px 10px 10px 0px;                
                padding: 10px;
                box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
            }            
            hr{
                border-color: darkslategrey;
            }
        </style>
    </body>
</html>