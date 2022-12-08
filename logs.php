<?php
include "conn.php";
session_start();
if(isset($_SESSION['user'])){
    $stmt =  $conn ->prepare("SELECT `tkt_id`, `problem`, `details`, `user`, `status`, `date` FROM `tkt_logs` WHERE tkt_id = ?");
    $stmt->execute(array($_GET['tkt_id']));
    $rows = $stmt->fetchAll();

//     echo "<pre>" ; 
// print_r($rows);
//     echo "</pre>";
  



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
    <?php
    echo "######################################## <br>"; 
    echo "Logs of tkt_no . # " . $_GET['tkt_id'] . "<br>"; 
    echo "########################################"; 
    foreach($rows as $row){
?>



<h5>- <?php echo "user : " . $row['user']?></h5>
<h5>- <?php echo "Action Status  : " . $row['status']?> </h5>
<h5>- <?php echo  $row['date']?> </h5>
<h5>- <?php echo "Problem Title  : " . $row['problem']?></h5>
<div class="alert alert-dark" role="alert" role="alert">
<?php echo  $row['details']?>
</div>


<hr>






<?php



    }
    
    
    
    ?>





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>