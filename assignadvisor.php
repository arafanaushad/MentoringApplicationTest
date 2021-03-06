<?php
	session_start();
	require_once('dbconfig/config.php');
	if(!isset($_SESSION['username'])){
    echo "<script>window.location.href='index.php';</script>";
    //header('location:index.php');
     }
    //phpinfo();
    
	$username=$_SESSION['username'];
	$query="select * from faculty where username='$username'";
	$result=mysqli_query($con,$query);
	$row1=mysqli_fetch_array($result);
	$dept1=$row1['dept'];
	
	
?>

<html>  
<head lang="en">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css\tailwind.min.css">
    <title>View faculty</title>  
</head>  
<body>  
  
<div class="container ">
	<h1 class="mb-8 text-center text-2xl text-teal-400">
    Faculty list
  </h1> 
  <table class="text-left w-full ml-8">
		<thead class="bg-teal-400 flex text-white w-full"> 
  
        <tr class="flex w-full mb-4">
  
            <th class="p-4 w-1/6">User Name</th>  
            <th class="p-4 w-1/6">Department</th>
            <th class="p-4 w-1/6">Designation</th>    
            <th class="p-4 w-1/6">Type</th>  
            <th class="p-4 w-1/6">Batch</th>
            <th class="p-4 w-1/6">Assign advisor</th>  
        </tr>  
        </thead>  
        <tbody class="bg-grey-light flex flex-col items-center justify-between overflow-y-scroll w-full" style="height: 50vh;">
        <?php  
         
        $view_users_query="select * from faculty where dept='$dept1' ";//select query for viewing users.  
        $run=mysqli_query($con,$view_users_query);//here run the sql query.  
  
        while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.  
        {  
            $user_id=$row['username'];  
            $designation=$row['designation'];  
            $user_email=$row['email'];  
            $user_type=$row['user_type'];  
            $dept=$row['dept'];
        ?>  
        <form action="assignadvisor.php" method="post">
        
        <tr class="flex w-full mb-1"> 
<!--here showing results in the table -->  
            <td class="p-4 w-1/6 overflow-hidden"><?php echo $user_id;  ?></td>  
            <td class="p-4 w-1/6 overflow-hidden"><?php echo $dept; ?></td>
            <td class="p-4 w-1/6 overflow-hidden"><?php echo $designation;  ?></td>   
            <td class="p-4 w-1/6 overflow-hidden"><?php echo $user_type;  ?></td>  
            <td class="p-4 w-1/6 overflow-hidden"><input type="text"  name="batch" value=" "/></td>
            <td class="p-4 w-1/6 overflow-hidden"><a href="assignadvisor.php"><button class="text-green-400" type="submit"  name="<?php echo "$user_id"; ?>">Assign</button></a></td> <!--btn btn-danger is a bootstrap button to show danger-->  
        </tr>  
            </form>
        <?php
			if(isset($_POST[$user_id]))
			{
				$batch=$_POST['batch'];
				$query="select * from faculty where batch='$batch' and user_type='advisor' and dept='$dept'";
			    $query_run = mysqli_query($con,$query);
			    if($query_run)
			    {
				    if(mysqli_num_rows($query_run)<2)
				    {
				
				        $query = "update faculty set user_type='advisor',batch='$batch' where username='$user_id' ";
				         $query_run = mysqli_query($con,$query);
			        	if($query_run)
				    	{
					      echo '<script type="text/javascript">alert("Successfully assigned advisor ")</script>';
					        echo "<script>window.location.href='hod.php';</script>";
				    	}
				    	else
				    	{
					        echo '<script type="text/javascript">alert("cannot assign advisor!!")</script>';
				    	}
				    }
				    else
				    {
				        echo '<script type="text/javascript">alert("Already 2 advisors for the same batch exist!!")</script>';
				    }
			    }
			    else
			    {
			        echo '<script type="text/javascript">alert("DB error")</script>';
			    }
			}
		?>
       	 <?php } ?> 
            </tbody> 
    </table>  
    </br>
        <form href="assignadvisor.php" method="post">
    <a href="assignadvisor.php"><button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline float-right" type="submit" name="back">
								back
		</button> </a>
        </form>
        <?php
			if(isset($_POST['back']))
			{
			     echo "<script>window.location.href='hod.php';</script>";
            }
            ?> 
</div>  
</body>  
  
</html> 