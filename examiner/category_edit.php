<?php
    session_start();
    if(empty($_SESSION['examiner_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';    
    $flag=0;
    if(!isset($_SESSION['category_edit_id'])) header("Location: category.php");      
    if(isset($_POST['title_submit'])){				
        $category_id=$_POST['category_id'];
        $title=$_POST['title'];
        $examiner_id=$_SESSION['examiner_id'];		
        $result = $con->query("select id from category where title='$title'");
	    $count=$result->num_rows;
	    if($count==0){             
            $query = "update category set title='$title',examiner_id='$examiner_id' where id='$category_id'";        
            $con->query($query);		
            $flag=1;
        }			
        else $flag=-1;			
    }
    $category_id=$_SESSION['category_edit_id'];
    $result=$con->query("select * from category where id='$category_id'")->fetch_assoc();		
    $title=$result['title'];
    if(isset($_POST['goback'])){				
        unset($_SESSION['category_edit_id']);
        header("Location: category.php");
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
                                <h4><a>Edit Category View</a></h4>
                            </li>
                        </center>
		            </ol>
                    <div class="breadcrumb"> 		                                                                              
                        <form action="" method="post" class="myform">
                            <div class="col-md-8 form-group1 group-mail">
                                <label class="control-label">Category/Title</label>
                                <input type="hidden" name="category_id" value="<?php echo $category_id; ?>"/>
                                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" style="border-radius: 20px; color: black;" required>
                            </div>
                            <div class="clearfix"> </div>                                
                            <?php if($flag==1){ ?><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-angle-right"></i> Successfully Updated Category.</div> <?php  }else if($flag==-1){ ?><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-ban"></i> Problem Inserting Data.</div> <?php  } ?>
                            <div class="col-md-12 form-group">
                                <button type="submit" style="border-radius: 20px;" class="btn btn-primary" name="title_submit">Submit</button>
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