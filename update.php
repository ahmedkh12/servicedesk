<?php
include "conn.php";
session_start();
if(isset($_SESSION['user'])){
    $stmt =  $conn ->prepare("SELECT  `tkt_id`, `problem_title`, `problem_details`, `dept`, `status`, `user_added`, `date` FROM `tkts` WHERE tkt_id = ?");
    $stmt->execute(array($_GET['tkt_id']));
    $rows = $stmt->fetch();
  
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    date_default_timezone_set('Africa/Cairo');
$comment = $_POST['details'];
$date = date('m/d/Y h:i:s a', time());

$stmt2 = $conn->prepare("INSERT INTO `tkt_logs`( `tkt_id`, `problem`, `details`, `user`, `status` , `date`) VALUES (?,?,?,?,?,?)  ");
$stmt2->execute(array($_GET['tkt_id'],  $rows['problem_title'] , $comment , $_SESSION['user'] , "Update" , $date ));
// add the comment to the logs of the ticket in the database 
echo '    <div class="alert alert-success" role="alert">';
echo  "the comment  Have been Updated Susessfully " ;
echo '</div>';







}




}


else{

    header('Location: login.php');
    exit();
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/master.css">
<style>
    h5{
        color:red;
    }
</style>
</head>
<body>
    
<h5><?php echo "Ticket No : # " . $_GET['tkt_id']?></h5>
<h6><?php echo "Created Date  : " . $rows['date'] ?></h6>
<h6><?php echo "Added By  : " . $rows['user_added'] ?></h6>
<h6><?php echo "Problem Title   : " . $rows['problem_title'] ?></h6>
<h6 ><?php echo "Ticket status   : "?><span id ="tkt_status" ><?php echo $rows['status']?></span></h6>
<hr>
<form id ="add"action="" method="POST" enctype="multipart/form-data">
<textarea name="details" id="" cols="60" rows="10" placeholder = "Type  Comment To  Ticket logs " required></textarea>


<input type="submit" class="btn btn-primary "  value = "Submit">

</form>



































<script>
  let x = document.getElementById("tkt_status") ;
 
  if(x.innerHTML==='closed'){
    document.getElementById("add").style.display="none";
    x.innerHTML=' The Ticket is Closed You can\'t update comment '
    x.style.color = "red"
  }
  else{
    x.style.color = "green"
    document.getElementById("add").style.display="block";
    
  }

  
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>