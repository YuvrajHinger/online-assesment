<?php
    session_start();
    if(empty($_SESSION['examiner_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';  
    $flag=0;
    if(!isset($_SESSION['candidate_edit_id'])) header("Location: candidate.php");      
    if(isset($_POST['candidate_update_submit'])){				
        $candidate_id=$_POST['candidate_id'];
        $candidate_username=$_POST['candidate_username'];
        $result = $con->query("select candidate_id from candidate_login where candidate_username='$candidate_username'");
	    $count=$result->num_rows;
	    if($count==0){             
            $candidate_password=$_POST['candidate_password'];            
            $query="update candidate_login set candidate_username='$candidate_username',candidate_password='$candidate_password' where candidate_id='$candidate_id'";        
            $con->query($query);		
            $flag=1;
        }			
        else $flag=-1;			
    }
    $candidate_id=$_SESSION['candidate_edit_id'];
    $result=$con->query("select * from candidate_login where candidate_id='$candidate_id'")->fetch_assoc();		
    $username=$result['candidate_username'];
    $password=$result['candidate_password'];
    if(isset($_POST['goback'])){				
        unset($_SESSION['candidate_edit_id']);
        header("Location: candidate.php");
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
                                    <a>Edit Candidate View</a>                                                                        
                                </h4>                                
                            </li>
                        </center>
		            </ol>
                    <div class="breadcrumb"> 		                                                                              
                        <form action="" method="post" class="myform">
                            <div class="col-md-12 form-group1 group-mail">
                                <label class="control-label"> Candidate Username</label>
                                <input type="hidden" name="candidate_id" value="<?php echo $candidate_id; ?>"/>
                                <input type="text" name="candidate_username" class="form-control" value="<?php echo $username; ?>" style=" border-radius: 20px; color: black;" required>
                            </div>
                            <div class="clearfix"> </div>
                            <div class="col-md-12 form-group1 group-mail">
                                <label class="control-label"> Candidate Password</label>
                                <input type="text" name="candidate_password" class="form-control" value="<?php echo $password; ?>" style=" border-radius: 20px; color: black;" required>                                                                         
                            </div>
                            <div class="clearfix"> </div>
                            <?php if($flag==1){ ?> <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-angle-right"></i> Successfully Updated Candidate.</div> <?php  }else if($flag==-1){ ?><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-ban"></i> Problem Updating Data.</div> <?php  } ?>
                            <div class="col-md-12 form-group">
                                <button type="submit" style="border-radius: 20px;" class="btn btn-primary" name="candidate_update_submit">Submit</button>                                    
                                <button type="reset" style="border-radius: 20px;" class="btn btn-default" value="reset">Reset</button>
                                <button type="submit" style="border-radius: 20px; float: right;" class="btn btn-secondary" name="goback">Go Back</button>
                            </div>		
                            <div class="clearfix"> </div>                                        
                        </form>                                                    
                    </div>
                </div>     
            </div>                
            <?php script(); ?>
            <?php sidebar(); ?>
            <style>
            .myform{
                padding: 30px;                                    
                box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
            }            
            </style>            
        </div>        
    </body>    
</html>