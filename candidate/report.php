<?php
    session_start();
    if(empty($_SESSION['candidate_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';  
    if(isset($_POST['detail_view'])){        
        $_SESSION['detail_exam']=$_POST['exam_id'];
        $_SESSION['detail_score']=$_POST['score'];
        header("Location: report_detail.php");
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
                    
                    <div class="bg-light table-responsive">                
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Exam</th>
                                <th>Date</th> 
                                <th>Total Question</th>                               
                                <th>Correct</th>
                                <th>Wrong</th>
                                <th>Score</th>
                                <th>Action</th>
                            </tr>                                                        
                        </thead>
                        <tbody>
                        <?php 
                        $query="select * from report where applicant_id='".$_SESSION['candidate_id']."'";
                        $result=$con->query($query);
                        $index=0;
                        while($fetchData=$result->fetch_assoc()){                            
                            $index++;
                            $fetchData1=$con->query("select * from active_exams where status=0 and id='".$fetchData['exam_id']."' order by date desc")->fetch_assoc(); 
                            $exam=$fetchData1['title'];
                            $date=$fetchData1['date'];
                            $negative_marking=$fetchData1['negative_marking'];
                            $total_question=$fetchData1['total_question'];                            
                            $total_marks=$fetchData1['total_marks'];
                            $report=$fetchData['report'];
                            $report=json_decode($report);
                            $correct=0;
                            $wrong=0;
                            $score=0;
                            $count=count($report);
                            for($i=0;$i<$count;$i++){
                                $qid=$report[$i]->qid;
                                $aid=$report[$i]->aid;
                                $data=$con->query("select answer_id from question where question_id='$qid' and status='0'")->fetch_assoc();
                                $data=$data['answer_id'];
                                if($aid==$data) $correct++;
                                else $wrong++;
                            }
                            $score=$correct;
                            if($negative_marking=="yes"){
                                $score=$score-($wrong/2);
                            }
                            $score=$score*$total_marks/$total_question;
                        ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $exam; ?></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $total_question; ?></td>
                                <td><?php echo $correct; ?></td>
                                <td><?php echo $wrong; ?></td>
                                <td><?php echo $score."/".$total_marks; ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="exam_id" value="<?php echo $fetchData['exam_id']; ?>"/>
                                        <input type="hidden" name="score" value="<?php echo $score; ?>"/>
                                        <button class="btn btn-primary" name="detail_view" type="submit">Detail View</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
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