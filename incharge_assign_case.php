<!DOCTYPE html>
<html>
<head>
    
    <?php
    session_start();
    if(!isset($_SESSION['x']))
        header("location:inchargelogin.php");
    
    $conn=mysqli_connect("localhost","root","","crime_portal");
    if(!$conn)
    {
        die("could not connect".mysqli_error());
    }
    mysqli_select_db($conn, "crime_portal");
    
    $i_id=$_SESSION['email'];
    $result1=mysqli_query($conn,"SELECT location FROM police_station where i_id='$i_id'");
    $q2=mysqli_fetch_assoc($result1);
    $location=$q2['location'];
    
    if(isset($_POST['s2']))
    {
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $cid=$_POST['cid'];
        $pid=$_POST['pid'];
        
        $_SESSION['cid']=$cid;
        $qu=mysqli_query($conn,"select inc_status,location from complaint where c_id='$cid'");
        
        $q=mysqli_fetch_assoc($qu);
        $inc_st=$q['inc_status'];
        $loc=$q['location'];

        $_SESSION['pid']=$pid;
        $quer=mysqli_query($conn,"select location from police where p_id='$pid'");
        
        $que=mysqli_fetch_assoc($quer);
        $loca=$que['location'];


        
        
        if(strcmp("$inc_st","Assigned")==0)
        {   
          $msg1="Case already assigned";
          echo "<script type='text/javascript'>alert('$msg1');</script>";
            
        }
        else if(strcmp("$loc","$location")!=0 || strcmp("$loca", "$location")!=0)
        {
            $msg="Incorrect Location";
            echo "<script type='text/javascript'>alert('$msg');</script>";
        }
        else{
          $q3=mysqli_query($conn,"update complaint set inc_status='Assigned',p_id='$pid' where c_id='$cid'");
        
    }
    }
  }
  $query1="select c_id,type_crime,d_o_c,location,inc_status,p_id from complaint where location='$location' order by c_id desc";
  $result=mysqli_query($conn,$query1);
    
      
  ?>

	<title>Incharge Homepage</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
	
    <script>
     function f1()
        {
          var sta2=document.getElementById("ciid").value;
          var x2=sta2.indexOf(' ');
     if(sta2!="" && x2>=0)
     {
        document.getElementById("ciid").value="";
        alert("Blank Field not Allowed");
      }       
}
</script>
    
</head>
<body style="background-color: #dfdfdf">
	<nav  class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php"><b>Crime Records</b></a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li ><a href="official_login.php">Official Login</a></li>
        <li ><a href="inchargelogin.php">Incharge Login</a></li>
        <li ><a href="Incharge_complain_page.php">Incharge Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="incharge_assign_case.php">Assign Cases</a></li>
        <li ><a href="Incharge_complain_page.php">View Complaints</a></li>
        <li ><a href="incharge_view_police.php">Police Officers</a></li>
        <li><a href="inc_logout.php">Logout &nbsp <i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
      </ul>
    </div>
  </div>
 </nav>
    
    

    <form style="margin-top: 7%; margin-left: 30%;" method="post">
      <input type="text" name="cid" style="width: 250px; height: 30px; background-color:white;" placeholder="&nbsp Complaint Id" id="ciid" onfocusout="f1()" required>
      <input type="text" name="pid" style="width: 250px; height: 30px; background-color:white;" placeholder="&nbsp Police Id" id="piid" onfocusout="f1()" required>
        <div>
      <input class="btn btn-primary" type="submit" value="Submit" name="s2" style="margin-top: 10px; margin-left: 20%;">
        </div>
    </form>
    
    
    
 <div style="padding:50px;">
   <table class="table table-bordered">
    <thead class="thead-dark" style="background-color: black; color: white;">
      <tr>
        <th scope="col">Complaint Id</th>
        <th scope="col">Type of Crime</th>
        <th scope="col">Date of Crime</th>
        <th scope="col">Location</th>
        <th scope="col">Complaint Status</th>
          <th scope="col">Police ID</th>
      </tr>
    </thead>

            <?php
              while($rows=mysqli_fetch_assoc($result)){

             ?> 

            <tbody style="background-color: white; color: black;">
      <tr>
        <td><?php echo $rows['c_id'];?></td>
        <td><?php echo $rows['type_crime'];?></td>     
        <td><?php echo $rows['d_o_c'];?></td>
          <td><?php echo $rows['location'];?></td>
          <td><?php echo $rows['inc_status']; ?></td>
          <td><?php echo $rows['p_id']; ?></td>
      </tr>
    </tbody>
    
    <?php
    } 
    ?>
  
</table>
 </div>
    <div style="position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   height: 30px;
   background-color: rgba(0,0,0,0.8);
   color: white;
   text-align: center;">
  <h4 style="color: white;">&copy <b>Crime Records</b></h4>
</div>

 <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>
 <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>