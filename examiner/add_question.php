<?php
    session_start();
    if(empty($_SESSION['examiner_id'])) header("Location: login.php");
    require_once 'database.php';
    require_once 'layout.php';    
    $flag=0;
    if(isset($_POST['question_submit'])){				
        $id=$_POST['title'];
        $question=$_POST['question'];
        $answer=$_POST['answer'];       
        $q_id=0;
        $a_id=0;
        $query="INSERT INTO question(question_text,answer_id,category) VALUES('$question','$a_id','$id')";        
        if($con->query($query)==TRUE){
            $q_id=$con->insert_id;
            $query="INSERT INTO answer(answer_text,question_id,category) VALUES('$answer','$q_id','$id')";
            $con->query($query);		
            $a_id=$con->insert_id;
            $query="UPDATE question SET answer_id='$a_id' WHERE question_id=$q_id";        
            $con->query($query);		
            $option=$_POST['option'];
            foreach($option as $key=>$value){            
                $query="INSERT INTO answer(answer_text,question_id,category) VALUES('$value','$q_id','$id')";
                $con->query($query);		
            }             
            $flag=1;                        
        }                        
        else $flag=-1;
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
                                    <a>Add Question</a>                                                                        
                                </h4>
                            </li>                            
                        </center>
		            </ol>
                    <div class="validation-system"> 		                        
                        <div class="validation-form">                                                                                                                        
                            <a href="add_Question_ByExcel.php" class="float-right btn btn-warning">
                                <i class="fa fa-file-excel-o"> Excel</i>                                        
                            </a>                                                                        
                            <form action="" method="post" class="myform">
                                <div class="row">                                
                                    <div class="col-md-7" style="margin-bottom: 10px">
                                        <div class="form-group group-mail">
                                            <label class="control-label"> Examination Category</label>
                                            <select style="border-radius: 20px;" class="form-control select2" name="title" required>                                    
                                                <option value="" selected>Select any title</option>  <?php $result = $con->query("SELECT * FROM category where status='0'"); while($row=$result->fetch_assoc()) {?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['title']; ?></option>  <?php } ?>
                                            </select>
                                        </div>
                                        <div class="clearfix"> </div>
                                        <div class="form-group group-mail">
                                            <label class="control-label"> Question ?</label>
                                            <textarea style="border-radius: 20px; color: black;" class="form-control" rows="3"  name="question" autofocus required></textarea>
                                        </div>
                                        <div class="clearfix"> </div>
                                        <div class="form-group group-mail">
                                            <label class="control-label"> Answer</label>
                                            <textarea style="border-radius: 20px; color: black;" class="form-control" rows="3" name="answer" required></textarea>
                                        </div>
                                        <div class="clearfix"> </div>
                                    </div>
                                    <div class="col-md-5" style="margin-bottom: 10px">                                    
                                        <table class="table table-bordered table-hover" id="option_ans">
                                            <tr id="option_content">
                                                <td>
                                                    <label class="control-label">Option</label>                                
                                                    <textarea style="border-radius: 20px; color: black;" class="form-control" rows="3" name="option[]" required></textarea>                                                
                                                </td>                                                
                                            </tr>
                                        </table>
                                        <div class="clearfix"> </div>
                                        <?php if($flag==1){ ?> <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-angle-right"></i> Successfully Registerd Question.</div> <?php  }else if($flag==-1){ ?><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-ban"></i> Problem Inserting Data.</div> <?php  } ?>
                                        <div class="col-md-12 form-group">
                                            <button type="submit" style="border-radius: 20px;" class="btn btn-success" name="question_submit">Submit</button>
                                            <button type="button" style="border-radius: 20px;" class="btn btn-primary" onclick="add_option('option_ans','option_content')">Add Option</button>                                            
                                            <button type="reset" style="border-radius: 20px;" class="btn btn-default">Reset</button>
                                        </div>		
                                        <div class="clearfix"> </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                                                                                                                                        
                </div>
            </div>
            <script>
            function add_option(tableId,cellId){        
                var table = document.getElementById(tableId);        
                var row = table.insertRow();        
                cellId = document.getElementById(cellId);
                row.innerHTML = cellId.innerHTML;
                var cell = row.insertCell();
                cell.innerHTML = '<a class="btn btn-danger" style="border-radius: 20px;" onclick="delete_option(\''+tableId+'\',this)">Delete Option</a>';
            }
            function delete_option(tableId,i){          
                i = i.parentNode.parentNode.rowIndex;      
                var table = document.getElementById(tableId);
                table.deleteRow(i);
            }          
            </script>
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