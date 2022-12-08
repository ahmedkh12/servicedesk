<?php
include "conn.php";
session_start();

if(isset($_SESSION['user'])){
    $stmt =  $conn ->prepare("SELECT  `tkt_id`, `attch_name`, `user_added`, `date` ,`size` , `type` FROM `tkt_attach` WHERE tkt_id = ?");
    $stmt->execute(array($_GET['tkt_id']));
    $rows = $stmt->fetchAll();



// get the tkt status from tkts table 

$stmt1 =  $conn ->prepare("SELECT  `status` FROM `tkts` WHERE `tkt_id` = ? LIMIT 1 ");
$stmt1->execute(array($_GET['tkt_id']));
$rows1 = $stmt1->fetch();



// print_r($rows);

if($_SERVER['REQUEST_METHOD']=='POST'){
    date_default_timezone_set('Africa/Cairo');
                    $attach = $_FILES['attach'];
                    $user_added = $_SESSION['user'];
                    $date = date('m/d/Y h:i:s a', time());  // the time of create 






                    $img_name = $attach['name'];
                    $img_type = $attach['type'];
                    $img_size = $attach['size'];
                    $img_temp  = $attach['tmp_name']; // the temp path of the img 
                    $allowed_ext = array("jpeg" , "jpg" , "png");
                    $gen_img_name = rand(0,1000)."_".$attach['name'] ;
                    
                  @ $img_ex = end(explode("." , $img_name)) or die(" ");  // to get the last string of img name 'extension'

if(in_array($img_ex , $allowed_ext)){

    
    move_uploaded_file($img_temp,"uploaded_img\\".$gen_img_name); // upload img from the temp path to the path in project 

    // move img info to the database 
            
    $stmt1 = $conn->prepare("INSERT INTO `tkt_attach`( `tkt_id`, `attch_name`,`size` ,`type`, `user_added`, `date`) VALUES (?,?,?,?,?,?)");
    $stmt1->execute(array($_GET['tkt_id'],  $gen_img_name ,$img_size ,$img_type, $user_added , $date ));


    echo '    <div class="alert alert-success" role="alert">';
    echo  " Image Uploaded" ;
    echo '</div>';
    


}
else {
    echo "Not Allowd File Upload  " ; 
}

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

</head>
<body>

<?php  echo "Attachment Of the tkt ID # " . $_GET['tkt_id']?> <br>
<h5>Ticket Status : <span id = "tkt_state"><?php echo $rows1['status'];?></span> </h5>


<form  id = "up"action="" method = "POST"  enctype="multipart/form-data">
<input type="file" name = "attach"  required>
<input type="submit"  value = "Upload Attach">
</form>
<br><br>


<table class="table table-striped  table-sm">
  <thead>
    <tr>
      <th scope="col">Attach Name</th>
      <th scope="col">User Added</th>
      <th scope="col">Date</th>
      <th scope="col">Size</th>
      <th scope="col">Type</th>
     


    </tr>
  </thead>
  <tbody>
  <?php
    foreach($rows as $row){
 ?>
    <tr>

      <td><a download href= <?php echo "uploaded_img\\".$row['attch_name']?>> <?php echo $row['attch_name']?></a></td>
      <td><?php echo $row['user_added']?></td>
      <td><?php echo $row['date']?></td>
      <td><?php echo $row['size']?></td>
      <td><?php echo $row['type']?></td>
    
    </tr>

   

<?php

    }
    
    
    
    ?>
  
  </tbody>
</table>
<script>








      let x = document.getElementById("tkt_state") ;
 
 if(x.innerHTML==='closed'){
   document.getElementById("up").style.display="none";
   x.innerHTML+=' ->> You can\'t Upload files '
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