<?php	
	session_start();	
	require_once 'database.php';    
	require_once 'layout.php';	
	$flag=0;
	if(isset($_SESSION['examiner_id'])) header("Location: index.php");	    
	if(isset($_POST['login'])){				
		$username=$_POST['username'];
		$password=$_POST['password'];
		$query="select * from examiner_login where examiner_username='$username' && examiner_password='$password' && status='0'";
		$result=$con->query($query);
		if($result->num_rows>0){
			$row=$result->fetch_assoc();
			$_SESSION['examiner_id']=$row['examiner_id'];
			$_SESSION['examiner_username']=$row['examiner_username'];							
			header("Location: index.php");	    
			$flag=0;			
		}
		else $flag=1;				
	}	
?>
<html>
    <head>
        <?php head(); ?>
    </head>
    <body>
        <div class="main-wthree" style="background: none">
	        <div class="container">
	            <div class="sin-w3-agile bg-dark" style="border: solid gray; padding: 5%; margin-top: 5%">
					<?php if($flag=='1'){ ?>
						<div class="alert alert-danger alert-dismissible">                  			
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  			<i class="icon fa fa-ban"></i> Enter Correct Email and Password.
              			</div> 
					<?php  }?>
		            <h2>Examiner Sign In</h2>					
		            <form action="" method="post">
			            <div class="username">
				            <span class="username">Username:</span>
				            <input type="text" name="username" class="name" placeholder="" value="admin" required="">
				            <div class="clearfix"></div>
			            </div>
			            <div class="password-agileits">
				            <span class="username">Password:</span>
				            <input type="password" name="password" class="password" placeholder="" value="admin" required="">
				            <div class="clearfix"></div>
			            </div>						
			            <div class="login-w3">
					        <input type="submit" class="login" value="Sign In" name="login">
			            </div>
			            <div class="clearfix"></div>
		            </form>
                </div>
            </div>
        </div>
		<?php script(); ?>		
    </body>
</html>
