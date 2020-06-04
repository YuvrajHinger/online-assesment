<?php
    session_start();
    if(empty($_SESSION['examiner_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';    
    require_once 'excel_reader.php';
    $excel = new PhpExcelReader;    
    $flag=0;
    if(isset($_POST['excel_submit'])){				        
        $excel_file=$_FILES['excel_file']['name'];        
        $excel->read($excel_file); 
        $n=count($excel->sheets);    
        $sheets=$excel->sheets[0];        
        $row=2;         
        while($row<=$sheets['numRows']){                        
            if(isset($sheets['cells'][$row][1])){                    
                $candidate_username=$sheets['cells'][$row][1];                
                $result = $con->query("select candidate_id from candidate_login where candidate_username='$candidate_username'");
                $count=$result->num_rows;
                if($count==0){             
                    $candidate_password=$sheets['cells'][$row][2];
                    $query="INSERT INTO candidate_login(candidate_username,candidate_password) VALUES ('$candidate_username','$candidate_password')";        
                    $con->query($query);		                    
                }			                                
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
                                    <a href="">Add Candidate</a>                                    
                                </h4>
                            </li>                            
                        </center>
		            </ol>
                    <div class="validation-system">                     
                        <div class="validation-form">		                        
                            <form action="" method="post" enctype="multipart/form-data">
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
                                    <img class="img-responsive mx-auto d-block" style="border-radius: 10px; border: solid blue; padding: 2%" src="../include/image/candidate_upload.png" alt="Guideline For Upload"/><hr>                                    
                                    <img class="img-responsive mx-auto d-block" style="border-radius: 10px; border: solid blue; padding: 2%" src="../include/image/save_type.png" alt="Guideline For Upload"/><hr>
                                    <h4 class="caption text-dark">File Format: filename.xls</h4><hr>                                    
                                    <h4 class="caption text-danger">Your Excel File Must Be in This Given Format. |</h4><hr>                                    
                                </center>
                                <div class="col-md-12 form-group1 group-mail">                                                        
                                    <label class="control-label"> Upload Excel File</label>
                                    <input name="excel_file" type="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required/>
                                </div>
                                <div class="clearfix"> </div>                                
                                <div class="col-md-12 form-group">                                                                        
                                    <button type="submit" class="btn btn-primary" name="excel_submit">Submit</button>
                                    <button type="reset" class="btn btn-default" value="reset">Reset</button>                                    
                                </div>		
                                <div class="clearfix"> </div>
                            </form>                        
                        </div>                    
                    </div>
                </div>            
            </div>            
            <?php script(); ?>
            <?php sidebar(); ?>            
        </div>        
    </body>
</html>