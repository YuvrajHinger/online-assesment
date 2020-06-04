<?php
    session_start();
    if(empty($_SESSION['examiner_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';
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
                                <h4 class="clearfix">                                
                                    <a class="float-right text-danger" id="date">                                                                            
                                    </a>
                                    <a class="float-left text-danger" id="time">                                        
                                    </a>
                                    <a>Dashboard</a>                                                                        
                                </h4>                                
                            </li>
                        </center>
                    </ol>
                    <div class="four-grids">
                        <div class="col-md-3 four-grid">
                            <div class="four-agileits">
                                <div class="icon">
                                    <i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
                                </div>
                                <div class="four-text">
                                    <h3>Examiner</h3>
								    <h3> <?php echo $con->query("select * from examiner_login where status=0")->num_rows; ?>  </h3>								
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <div class="four-grids">
                        <div class="col-md-3 four-grid">
                            <div class="four-agileinfo">
                                <div class="icon">
                                    <i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                                </div>
                                <div class="four-text">
                                    <h3>Candidate</h3>
								    <h3> <?php echo $con->query("select * from candidate_login where status=0")->num_rows; ?>  </h3>								
                                </div>
                            </div><br>
                        </div>
                    </div>                    
                    <div class="four-grids">
                        <div class="col-md-3 four-grid">
                            <div class="four-w3ls">
                                <div class="icon">
                                    <i class="glyphicon glyphicon-th-list" aria-hidden="true"></i>
                                </div>
                                <div class="four-text">
                                    <h3>Active Exams</h3>
                                    <h3> 
                                        <?php
                                            date_default_timezone_set('Asia/Calcutta');                            
                                            $cdate=date("y-m-d");
                                            $ctime=date("h:i:s");
                                            $query="select * from active_exams where status=0 and (date>='$cdate')"; 
                                            echo $con->query($query)->num_rows; 
                                        ?>  
                                    </h3>								
                                </div>
                            </div><br>
                        </div>
                    </div>                    
                    <div class="four-grids">
                        <div class="col-md-3 four-grid">
                            <div class="four-wthree">
                                <div class="icon">
                                    <i class="glyphicon glyphicon-file" aria-hidden="true"></i>
                                </div>
                                <div class="four-text">
                                    <h3>Report</h3>
								    <h3> 
                                        <?php
                                            $report_count=0;
                                            $query="select * from active_exams where status=0 and examiner_id='".$_SESSION['examiner_id']."' order by date desc";
                                            $result=$con->query($query);
                                            while($fetchData=$result->fetch_assoc()){                                                        
                                                $report_count+=$con->query("select * from report where exam_id='".$fetchData['id']."'")->num_rows;                                                
                                            }
                                            echo $report_count; 
                                        ?>  
                                    </h3>								
                                </div>
                            </div><br>
                        </div>
                    </div>                    
                </div>                
            </div>
            <?php sidebar(); ?>
        </div>
        <?php script(); ?>
        <script>            
            var x = setInterval(function() {                                                        
                var current = new Date();
                var hour = current.getHours();
                var min = current.getMinutes();
                var sec = current.getSeconds();
                var day = current.getDay();
                var date = current.getDate();
                var month = current.getMonth();                
                switch(day){
                    case 0: day = "Sunday"; break;
                    case 1: day = "Monday"; break;
                    case 2: day = "Tuesday"; break;
                    case 3: day = "Wednesday"; break;
                    case 4: day = "Thrusday"; break;
                    case 5: day = "Friday"; break;
                    case 6: day = "Saturday"; break;
                }                
                switch(month){
                    case 0: month = "January"; break;
                    case 1: month = "February"; break;
                    case 2: month = "March"; break;
                    case 3: month = "April"; break;
                    case 4: month = "May"; break;
                    case 5: month = "June"; break;
                    case 6: month = "July"; break;
                    case 7: month = "August"; break;
                    case 8: month = "September"; break;
                    case 9: month = "October"; break;
                    case 10: month = "November"; break;
                    case 11: month = "December"; break;							
                }
                document.getElementById('date').innerHTML = day + ", " + date + " " + month;
                if(hour<10 && min<10 && sec<10) document.getElementById('time').innerHTML = "0"+hour + ":0" + min + ":0" + sec; 
                else if(hour<10 && min<10) document.getElementById('time').innerHTML = "0"+hour + ":0" + min + ":" + sec; 
                else if(hour<10 && sec<10) document.getElementById('time').innerHTML = "0"+hour + ":" + min + ":0" + sec; 
                else if(min<10 && sec<10) document.getElementById('time').innerHTML = hour + ":0" + min + ":0" + sec; 
                else if(hour<10) document.getElementById('time').innerHTML = "0"+hour + ":" + min + ":" + sec; 
                else if(min<10) document.getElementById('time').innerHTML = hour + ":0" + min + ":" + sec; 
                else if(sec<10) document.getElementById('time').innerHTML = hour + ":" + min + ":0" + sec; 	
                else document.getElementById('time').innerHTML = hour + ":" + min + ":" + sec;
            }, 1000 );                    
        </script>
    </body>
</html>