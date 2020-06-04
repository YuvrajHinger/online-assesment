<?php    
    require_once 'database.php';
    require_once 'layout.php';                
?>
<html>
    <head>
        <?php head(); ?>
    </head>
    <body>        
        <script>
            var hours = 0;                
            var minutes = 1;
            var second = 3;                
            var x = setInterval(function() {                                        
                second--;
                if(hours<10 && minutes<10 && second<10) currenttime = "Time Remaining:  0"+hours+":0"+minutes+":0"+second;                     
                else if(hours<10 && minutes<10)  currenttime = "Time Remaining:  0"+hours+":0"+minutes+":"+second; 
                else if(hours<10 && second<10) currenttime = "Time Remaining:  0"+hours+":"+minutes+":0"+second; 
                else if(second<10 && minutes<10) currenttime = "Time Remaining:  "+hours+":0"+minutes+":0"+second; 
                else currenttime = "Time Remaining:  "+hours+":"+minutes+":"+second;                                   
                if (hours<=0 && minutes<=0 && second<=0){
                    clearInterval(x);
                    document.getElementById("timer").innerHTML = "EXPIRED";
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
                document.getElementById("timer").innerHTML = currenttime;
                }, 1000 );                    
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
                                <h4>
                                    <a class="text-center">Quiz</a>                                    
                                </h4>
                            </li>
                        </center>
                    </ol>                          
                    <div class="agile-grids">
                        <div class="agile-tables">
                            <div class="w3l-table-info">                                
                                <?php $query="select * from question order by rand()"; $result=$con->query($query); 
                                while($fetchdata=$result->fetch_assoc()){ $q_id=$fetchdata['question_id'];  $q_text=$fetchdata['question_text']; ?>                                
                                    <div class="quizBox" id="currentQuiz_<?php echo $q_id; ?>" style="display: none;">                                                                            
                                        <div class="qname"><?php echo $q_text; ?><hr></div>                                        
                                        <div class="option"> 
                                            <div data-toggle="buttons">
                                                <?php $query="select * from answer where question_id='$q_id' order by rand()";  $result1=$con->query($query);  
                                                while($fetchdata1=$result1->fetch_assoc()){ $a_id=$fetchdata1['answer_id'];  $option=$fetchdata1['answer_text']; ?> 
                                                    <label class="btn btn-option" style="border-radius: 20px; white-space:normal !important; word-wrap: break-word;">
                                                        <input type="radio" onchange="updateProgressBar(this)" name="<?php echo $q_id; ?>" value="<?php echo $a_id; ?>"/>                                    
                                                        <h5><?php echo $option; ?></h5>                                    
                                                    </label>                           
                                                <?php } ?>                                            
                                            </div>                                       
                                        </div>                                                                                                          
                                    </div> 
                                <?php } ?>                                                                                     
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
            <?php script(); ?>
            <div id="logout" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md" >
                <form action="logout.php" method ="post">
                    <div class="modal-content">
                        <div class="modal-header" style=" background-color: #3E3A86;color:#fff;">
                            <button type="button" class="close" style="color:#fff !important;opacity:1" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" >
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
                    $query="select * from question order by rand()"; $result=$con->query($query); $total_question=0; 
                    while($fetchdata=$result->fetch_assoc()){   $q_id=$fetchdata['question_id'];  $total_question++; 
                    ?>
                    <a class="btn btn-option palletIndex" style="border-radius: 20px;" id="pallete_<?php echo $q_id; ?>" onclick="quizId('<?php echo $q_id; ?>')">                        
                        <h5><?php echo $total_question; ?></h5>                        
                    </a>          
                    <script>
                        if(<?php echo $total_question;?>==1){                            
                            document.getElementById("pallete_<?php echo $q_id; ?>").click();                                                        
                        }
                    </script>
                <?php } ?>                        <hr>                                                				
                <h5 style="margin: 10px;">Legend</h5>
                <label style="background-color: green; padding: 10px; font-size: 12px; margin: 10px; color: white;">Answered</label>                           
                <label style="background-color: red; padding: 10px; font-size: 12px; margin: 10px; color: white;">UnAnswered</label>
                <label style="background-color: whitesmoke; padding: 10px; font-size: 12px; margin: 10px; color: black;">Not Visited</label>
            </div>                        
        </div>                      
            <style>
                .affix{
                    top:10px;   
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
                var total_question="<?php echo $total_question; ?>";
                var attempted=new Array();
                var attempted_index=0;
                function updateProgressBar(ths){                                                                                        
                    if(attempted.includes(ths.name)) return;                    
                    attempted[attempted_index++]=ths.name;
                    progress_bar.innerHTML=attempted_index;
                    progress_bar.style.width=attempted_index/parseInt(total_question)*100+"%";
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
        </div>        
    </body>
</html>