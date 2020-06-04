<?php
    session_start();
    if(empty($_SESSION['examiner_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';    
    require_once 'excel_reader.php';
    $excel = new PhpExcelReader;    
    $flag=0;
    if(isset($_POST['excel_submit'])){				
        $id=$_POST['title'];
        $excel_file=$_FILES['excel_file']['name'];
        $excel->read($excel_file); 
        $n=count($excel->sheets);    
        $sheets=$excel->sheets[0];
        $q_id=0;
        $a_id=0;
        $row=2; 
        while($row<=$sheets['numRows']){
            $col=1;
            while($col<=$sheets['numCols']){
                if(isset($sheets['cells'][$row][$col])){
                    $data=$sheets['cells'][$row][$col];
                    if($col==1){
                        $query="INSERT INTO question(question_text,answer_id,category) VALUES('$data','$a_id','$id')";
                        $con->query($query);
                        $q_id=$con->insert_id;
                    }                                
                    else if($col==2){
                        $query="INSERT INTO answer(answer_text,question_id,category) VALUES('$data','$q_id','$id')";
                        $con->query($query);
                        $a_id=$con->insert_id;
                        $query="UPDATE question SET answer_id='$a_id' WHERE question_id=$q_id";        
                        $con->query($query);
                    }
                    else{
                        $query="INSERT INTO answer(answer_text,question_id,category) VALUES('$data','$q_id','$id')";
                        $con->query($query);
                    }
                }                
                $col++;
            }         
            $row++;
        }   $flag=1;     
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
                                <h4>                                    
                                    <a href="">Add Question</a>                                    
                                </h4>
                            </li>                            
                        </center>
		            </ol>
                    <div class="validation-system">                     
                        <div id="step1" class="validation-form">		                        
                            <?php if($flag==1){ ?>
                                <div class="alert alert-success alert-dismissible">                  			
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="icon fa fa-angle-right"></i> SuccessFullyRegisterd Question.
                                </div> 
                            <?php  }
                            else if($flag==-1){ ?>
                                <div class="alert alert-danger alert-dismissible">                  			
							        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  			        <i class="icon fa fa-ban"></i> Problem Inserting Data.
              			        </div> 
                            <?php  } ?>
                            <center>
                                <h3>Guideline to Upload Excel File</h3><hr>
                                <img class="img-responsive mx-auto d-block" style="border-radius: 10px; border: solid blue; padding: 2%" src="../include/image/quiz_upload.png" alt="Guideline For Upload"/><hr>
                                <h4 class="caption text-dark">File Format: filename.xls</h4><hr>
                                <h4 class="caption text-danger">Your Excel File Must Be in This Given Format. |</h4><hr>
                                <button onclick="changeView('step1','step2')" style="border-radius: 20px;" class="btn btn-primary">Proceed</button>
                            </center>                                                                                                                                                                                                                                   
                        </div>
 		                <div id="step2" class="validation-form" style="display:none">                            
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="col-md-12 form-group2 group-mail">
                                    <label class="control-label"> Category Title</label>
                                    <select class="form-control select2" name="title" required>                                    
                                        <option value="">Select any exam</option>  <?php $result = $con->query("SELECT * FROM category where status='0'"); while($row=$result->fetch_assoc()) {?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['title']; ?></option>  <?php } ?>
                                    </select>
                                </div>
                                <div class="clearfix"> </div>
                                <div class="col-md-12 form-group1 group-mail">                                                        
                                    <label class="control-label"> Upload Excel File</label>
                                    <input name="excel_file" type="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                </div>
                                <div class="clearfix"> </div>                                
                                <div class="col-md-12 form-group">                                                                        
                                    <button type="submit" style="border-radius: 20px; border-color: black;" class="btn btn-primary" name="excel_submit">Submit</button>
                                    <button type="reset" style="border-radius: 20px; border-color: black;" class="btn btn-default" value="reset">Reset</button>
                                    <button onclick="changeView('step2','step1')" style="border-radius: 20px; border-color: black;" class="btn btn-primary float-right">View Guide-line</button>
                                </div>		
                                <div class="clearfix"> </div>
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>            
            <?php script(); ?>
            <?php sidebar(); ?>
            <script>
            function changeView(h,s){
                document.getElementById(h).style.display='none';
                document.getElementById(s).style.display='block';
            }
            </script>
        </div>        
    </body>
</html>