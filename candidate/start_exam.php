<?php
    session_start();
    if(empty($_SESSION['candidate_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';
    if(isset($_POST['submitPaper'])){
        $str=explode('id',$_SESSION['quiz']);        
        $json_data='[';
        for($i=1;$i<count($str);$i++){            
            if(isset($_POST[$str[$i]])){                                                        
                $json_data=$json_data.'{"qid": "'.$str[$i].'","aid": "'.$_POST[$str[$i]].'"},';
            }
        }
        $time=$_POST['submitPaper'];
        $json_data=substr($json_data,0,-1);        
        $json_data=$json_data.']';
        $query="INSERT INTO report(exam_id,applicant_id,report,time_remaining) VALUES ('".$_SESSION['active_exam']."','".$_SESSION['candidate_id']."','$json_data','$time')";
        $con->query($query);        
        header("Location: report.php");
    }      
    $query="select * from active_exams where status=0 and id='".$_SESSION['active_exam']."'";
    $result=$con->query($query);
    if($result){
        $fetchData=$result->fetch_assoc();
        $questions=$fetchData['questions'];
        $_SESSION['quiz']=$questions;
        $time=$fetchData['duration'];        
        $str=explode('id',$questions);                                                                                                                
        $query_in=$str[1];
        for($i=2;$i<count($str);$i++){
            $query_in=$query_in.','.$str[$i];
        }
        $query="SELECT * FROM question WHERE question_id IN($query_in) ORDER by rand()";
        $result=$con->query($query);                        
        $query_pallet=$query;
    } 
?>
<html>
    <head>
        <?php head(); ?>
    </head>
    <body>
        <script>
            function quizId(qid){                                
                var classes=document.getElementsByClassName("quizBox");
                for(i=0;i<classes.length;i++){
                    if(classes[i].style.display=='block'){
                        classes[i].style.display='none';
                        str=classes[i].id;
                        str=str.split("_");
                        ids="pallete_"+str[1];                        
                        if(document.getElementById(ids).style.backgroundColor=="green");
                        else document.getElementById(ids).style.backgroundColor="red";
                        document.getElementById(ids).style.color="white";
                    }
                }                
                document.getElementById("currentQuiz_"+qid).style.display='block';                                                            
            }
        </script>
        <div class="page-container">
            <div class="left-content">
                <div class="mother-grid-inner">
                    <ol class="breadcrumb">
                        <center>
                            <li class="breadcrumb-item">
                                <h4><a>Online Assesment</a></h4>
                            </li>
                        </center>
                    </ol>   
                    <div class="agile-grids">
                        <div class="agile-tables">
                            <div class="w3l-table-info">
                                <form id="submitpaper" method="post" action="">
                                    <?php while($fetchdata=$result->fetch_assoc()){  
                                        $q_id=$fetchdata['question_id']; 
                                        $q_text=$fetchdata['question_text'];  
                                    ?>                                
                                    <div class="quizBox" id="currentQuiz_<?php echo $q_id; ?>" style="display: none;">
                                        <div class="qname">
                                            <?php echo $q_text; ?><hr>
                                        </div>
                                        <div class="option">
                                            <div data-toggle="buttons"> 
                                                <?php $query="select * from answer where question_id='$q_id' order by rand()"; 
                                                    $result1=$con->query($query); 
                                                    while($fetchdata1=$result1->fetch_assoc()){ 
                                                        $a_id=$fetchdata1['answer_id']; 
                                                        $option=$fetchdata1['answer_text']; 
                                                ?>                                                                            
                                                <label class="btn btn-option" style="border-radius: 20px; white-space:normal !important; word-wrap: break-word;">
                                                    <input type="radio" onchange="updateProgressBar(this)" name="<?php echo $q_id; ?>" value="<?php echo $a_id; ?>"/>                                    
                                                    <h5><?php echo $option; ?></h5>                                    
                                                </label>                           
                                                <?php } ?>
                                            </div>                                       
                                        </div>                                                                                                          
                                    </div> 
                                    <?php } ?>
                                    <input type="hidden" id="setTime" name="submitPaper" value="yes"/> <hr> <br><br> 
                                </form>                                                         
                            </div>
                            <div class="float-right">
                                <button class="btn btn-primary" onclick="next_QuizSet()">Next</button>
                                <button class="btn btn-primary" onclick="pre_QuizSet()">Previous</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>                        
                    </div>                    
                </div>                                            
            </div>            
            <div class="sidebar-menu">			
                <div style="background: skyblue; color: black;">
			        <div style="border-top:1px ridge rgba(255, 255, 255, 0.15)"></div>                        
                    <div class="text-center" style="background-color: skyblue;">
                        <div class="progress" style="height: fit-content; margin-top: 0px;">
                            <div id="progress_bar" class="progress-bar" role="progressbar" style="width:0%;">0</div>
                        </div>
                        <h4 id="timer" class="panel-heading">Time Remaining: 00:00:00</h4>                        
                        <a href="#confirmEnd" data-toggle="modal" class="text-center btn btn-default">Submit Exam</a>                                            
                    </div><hr>                                                                        
                    <h3 align="center">Question Palette</h3><hr>
                    <?php 
                        $result=$con->query($query_pallet);                
                        $total_question=0; 
                        while($fetchdata=$result->fetch_assoc()){   
                            $q_id=$fetchdata['question_id'];  
                            $total_question++; 
                    ?>
                        <a class="btn btn-option palletIndex" style="border-radius: 20px;" id="pallete_<?php echo $q_id; ?>" onclick="quizId('<?php echo $q_id; ?>')">                        
                            <h5><?php echo $total_question; ?></h5>                        
                        </a>          
                        <script>
                            if(<?php echo $total_question;?>==1){                            
                                document.getElementById("pallete_<?php echo $q_id; ?>").click();                                                        
                            }
                        </script>
                    <?php } ?>  <hr>                                                				
                    <h5 style="margin: 10px;">Legend</h5>
                    <label style="background-color: green; padding: 10px; font-size: 12px; margin: 10px; color: white;">Answered</label>                           
                    <label style="background-color: red; padding: 10px; font-size: 12px; margin: 10px; color: white;">UnAnswered</label>
                    <label style="background-color: whitesmoke; padding: 10px; font-size: 12px; margin: 10px; color: black;">Not Visited</label>
                </div>                        
            </div>
            <?php script(); ?>
            <style>
                .affix{
                    bottom: 0px;
                    right: 50px;                 
                    position: fixed;   	                               
                    z-index:777;
                }
                .btn-option {                                                                    
                    font-family: monospace;                                            
                    margin: 5px;                            
                    color: black;
                    font-family: monospace;
                    background-color: whitesmoke;
                    border-color: #285e8e; 
                }
                .btn-option:hover{
                    color: white;
                    font-family: monospace;
                    background-color: seagreen;
                    border-color: #285e8e; 
                }
                .btn-option:focus, .btn-option:active, .btn-option.active, .open>.dropdown-toggle.btn-option {                                    
                    color: white;
                    font-family: monospace;
                    background-color: darkslategrey;
                    border-color: #285e8e; 
                }            
                hr{
                    border-color: darkslategrey;
                }
                .qname{
                    padding: 20px 20px 10px 20px;                
                    font-size: 1.5pc;
                    word-wrap: break-word;
                    color: blue;
                }
                .option{
                    padding: 0px 0px 20px 20px;                                    
                }
                .quizBox{
                    margin: 0px 5px 30px 5px;                                    
                    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
                }
            </style>                                       
        <script>
            var phpData="<?php echo $time; ?>";
            var total_question="<?php echo $i; ?>";
            var hours = parseInt(phpData[0]+phpData[1]);                
            var minutes = parseInt(phpData[3]+phpData[4]);                
            var second = parseInt(phpData[6]+phpData[7]);                
            var x = setInterval(function() {                                                        
                if(hours<10 && minutes<10 && second<10) currenttime = "Time Remaining:  0"+hours+":0"+minutes+":0"+second;                     
                else if(hours<10 && minutes<10)  currenttime = "Time Remaining:  0"+hours+":0"+minutes+":"+second; 
                else if(hours<10 && second<10) currenttime = "Time Remaining:  0"+hours+":"+minutes+":0"+second; 
                else if(second<10 && minutes<10) currenttime = "Time Remaining:  "+hours+":0"+minutes+":0"+second; 
                else currenttime = "Time Remaining:  "+hours+":"+minutes+":"+second;                                   
                if (hours<=0 && minutes<=0 && second<=0){
                    clearInterval(x);
                    document.getElementById("timer").innerHTML = "EXPIRED";
                    submit_paper();
                    return;
                }                    
                if(second<=0 && (minutes>0 || hours>0)){
                    second=60;
                    minutes--;
                    if(minutes<=0 && hours>0){
                        minutes=60;
                        hours--;
                    }
                }                    
                second--;
                document.getElementById("timer").innerHTML = currenttime;
                }, 1000 );                    
                var attempted=new Array();
                var attempted_index=0;
                function decrementProgressBar(ths){
                    index=attempted.indexOf(ths.name);
                    attempted.splice(index,1);
                    attempted_index--;
                    progress_bar.innerHTML=attempted_index;
                    progress_bar.style.width=attempted_index/parseInt(total_question)*100+"%";
                }
                function updateProgressBar(ths){                                                                    
                    if(attempted.includes(ths.name)) return;                    
                    attempted[++attempted_index]=ths.name;
                    progress_bar.innerHTML=attempted_index;
                    temp=attempted_index+1;
                    progress_bar.style.width=temp/parseInt(total_question)*100+"%";
                    classes=document.getElementsByClassName("quizBox");
                    for(i=0;i<classes.length;i++){
                        if(classes[i].style.display=='block'){
                            str=classes[i].id;
                            str=str.split("_");
                            ids="pallete_"+str[1];
                            document.getElementById(ids).style.backgroundColor="green";
                            document.getElementById(ids).style.color="white";
                        }
                    }                
                }
                function submit_paper(){                         
                    setTime.value=timer.innerHTML;
                    submitpaper.submit();
                }                                
                function next_QuizSet(){
                    classes=document.getElementsByClassName("quizBox");
                    for(i=0;i<classes.length;i++){
                        if(classes[i].style.display=='block'){
                            str=classes[i].id;
                            str=str.split("_");                                                        
                            ids="pallete_"+str[1];                            
                            classes=document.getElementsByClassName("palletIndex");
                            for(i=0;i<classes.length;i++){
                                if(classes[i].id==ids){
                                    ids=classes[i+1].id;                                    
                                    document.getElementById(ids).click();
                                }
                            }                            
                            break;                                                        
                        }
                    }
                }
                function pre_QuizSet(){
                    classes=document.getElementsByClassName("quizBox");
                    for(i=0;i<classes.length;i++){
                        if(classes[i].style.display=='block'){
                            str=classes[i].id;
                            str=str.split("_");                                                        
                            ids="pallete_"+str[1];                            
                            classes=document.getElementsByClassName("palletIndex");
                            for(i=0;i<classes.length;i++){
                                if(classes[i].id==ids){
                                    ids=classes[i-1].id;                                    
                                    document.getElementById(ids).click();
                                }
                            }                            
                            break;                                                        
                        }
                    }
                }                                
        </script>
        <div id="confirmEnd" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md" >
                <form method ="post" class="modal-content">                                                        
                    <div class="modal-header" style=" background-color: #3E3A86;color:#fff;"><button type="button" class="close" style="color:#fff !important;opacity:1" data-dismiss="modal">&times;</button><h4 class="modal-title" >Stay Attention</h4></div>
                    <div class="modal-body">                                  
                        <h4 style="color: black" class="modal-title">Confirm End Exam</h4>                                                  
                    </div>                                    
                    <div class="modal-footer"><button type="button" class="btn btn-sm btn-primary" onclick="submit_paper()">Yes</button><button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button></div>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>