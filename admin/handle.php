<?php
include "nav.php";
include "conn.php";

if(isset($_SESSION['user'])&& $_SESSION['reg']==1){

    $tkt = $_GET['tkt_id'] ; 

    $stmt =  $conn ->prepare("SELECT  `tkt_id`, `problem_title`, `problem_details`, `dept`, `status` FROM `tkts` WHERE `tkt_id` = ? ");
    $stmt->execute(array($tkt));
    $rows = $stmt->fetch();
  
  if($_SERVER['REQUEST_METHOD']=='POST'){
    date_default_timezone_set('Africa/Cairo');
$tkt_no = $_POST['tkt_no'];
$problem = $_POST['problem'];
$details = $_POST['details'];
$dept = $_POST['dept'];
$stat = $_POST['stat'];
$user_added = $_SESSION['user'];
$attach = $_FILES['attach'];
$date = date('m/d/Y h:i:s a', time()); 





$img_name = $attach['name'];
$img_type = $attach['type'];
$img_size = $attach['size'];
$img_temp  = $attach['tmp_name']; // the temp path of the img 
$allowed_ext = array("jpeg" , "jpg" , "png");
$gen_img_name = rand(0,1000)."_".$attach['name'] ;

@ $img_ex = end(explode("." , $img_name)) or die(" ");  // to get the last string of img name 'extension'

if(in_array($img_ex , $allowed_ext)){

$stmt =  $conn->prepare("UPDATE `tkts` SET `problem_title`='$problem',`problem_details`='$details',`dept`='$dept ',`status`='$stat' WHERE `tkt_id`= '$tkt_no' ");
$stmt->execute();  
// will update the record with  the user log on 

move_uploaded_file($img_temp,"../uploaded_img\\".$gen_img_name); // upload img from the temp path to the path in project 

// move img info to the database 

$stmt1 = $conn->prepare("INSERT INTO `tkt_attach`( `tkt_id`, `attch_name`,`size` , `type` ,  `user_added`, `date`) VALUES (?,?,?,?,?,?)");
$stmt1->execute(array($tkt_no,  $gen_img_name  ,$img_size,$img_type, $user_added , $date ));

$stmt2 = $conn->prepare("INSERT INTO `tkt_logs`( `tkt_id`, `problem`, `details`, `user`, `status` , `date`) VALUES (?,?,?,?,?,?)");
$stmt2->execute(array($tkt_no,  $problem , $details , $user_added , "Admin Update" , $date ));

echo '    <div class="alert alert-success" role="alert">';
echo  "Ticket Have been Updated  Susessfully  with id :  ". $tkt_no  ;
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





<form action="" method = "POST"  enctype="multipart/form-data">
    <label for="">Ticket Number :</label>
<input type="text" class="form-control" name = "tkt_no"  autocomplete="off" required readonly value = <?php echo $_GET['tkt_id']?>>
<label for="">title :</label>
<input type="text" class="form-control" name = "problem" placeholder="Problem Title" autocomplete="off" required value = <?php echo $rows['problem_title']?>>
<label for="">Details :</label>
<textarea class="form-control" name="details" id="" cols="30" rows="5" placeholder = "Write Problem In details" ><?php echo $rows['problem_details']?></textarea>
<label for="">Department :</label>
<input type="text" class="form-control" name = "dept" placeholder="Department" required  value = <?php echo $rows['dept']?>>
<label for="">Status :</label>
<input type="text" class="form-control" name = "stat" placeholder="Status" required value = <?php echo $rows['status']?>>
<label for="">Attach Screen from the error :</label>
<input type="file" class="form-control" name = "attach"  required>

<br>
<input type="submit" class="btn btn-primary "  value = "Submit">
<input type="reset" class="btn btn-danger "  value = "Cancle">
</form>







<?php
include "fotter.php";
?>