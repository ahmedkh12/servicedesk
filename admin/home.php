<?php
include "conn.php";
include "nav.php"; 


if(isset($_SESSION['user'])&& $_SESSION['reg']==1){
    $stmt =  $conn ->prepare(" SELECT COUNT(`sql_id`)  as `count` From tkts WHERE status = 'open' ");
    $stmt->execute();
    $rows = $stmt->fetch();



    $stmt2 =  $conn ->prepare(" SELECT COUNT(`sql_id`)  as `count` From tkts WHERE status = 'closed' ");
    $stmt2->execute();
    $rows2 = $stmt2->fetch();

  
    $stmt3 =  $conn ->prepare(" SELECT COUNT(`id`)  as `count` From users WHERE reg_status = '0' ");
    $stmt3->execute();
    $rows3 = $stmt3->fetch();



}


else{

    header('Location: ../login.php');
    exit();
}


?>

<h3>Welecome To Admin </h3>

<br><br>
<a href="table_open.php"  class="btn btn-success">
  Tickets Open <span class="badge text-bg-secondary"><?php echo $rows['count'] ;?></span>
</a>

<a href="table_closed.php" class="btn btn-danger">
  Tickets closed <span class="badge text-bg-secondary"><?php echo $rows2['count'] ;?></span>
</a>

<a href="" class="btn btn-primary">
  Total Users <span class="badge text-bg-secondary"><?php echo $rows3['count'] ;?></span>
</a>

<hr>




<?php
include "fotter.php"; 

?>
