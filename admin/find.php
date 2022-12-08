<?php
include "nav.php";
include "conn.php";
?>
<?php
?>
<form action="" method = "POST" >
    
    <input type="number" class="form-control" name = "tkt_to_find"  autocomplete="off" required  placeholder="Ticket Number">
    
    <div class="d-grid gap-2">
    <input type="submit" class="btn btn-primary "  value = "Find">
    </div>
    </form>
    
<?php


if(isset($_SESSION['user'])&& $_SESSION['reg']==1){

  @ $input_val = $_POST['tkt_to_find'] or die(" ");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
    $stmt =  $conn ->prepare("SELECT  `tkt_id`, `user_added` , `problem_title`, `problem_details`, `dept`, `status`, `user_added`, `date` FROM `tkts` WHERE `tkt_id` = ?");
    $stmt->execute(array($input_val));
    $rows = $stmt->fetchAll();
    $count = $stmt->rowCount();
  

    }

  
  }
  else{
    header('Location: ../login.php');
    exit();
  }





?>








<?php

if($count<1){
  echo '<div class="alert alert-danger" role="alert">';
  echo  " No Record Found Please Review Tkt No";
 echo '</div>' ; 
}
else {
    echo '<div class="alert alert-success" role="alert">';
     echo $count  . " Record  Found ";
    echo '</div>' ; 
  foreach($rows as $row){
    ?>
    
    <table class="table table-striped  table-sm">
      <thead>
        <tr>
          <th scope="col"># Ticket ID </th>
          <th scope="col">User Added</th>
          <th scope="col">Problem Title</th>
          <th scope="col">Department</th>
          <th scope="col">Created Date</th>
          <th scope="col">Status</th>
          <th scope="col">Actions</th>
    
        </tr>
      </thead>
    <tbody>
    <tr>
          <td><?php echo $row['tkt_id']?></td>
          <td><?php echo $row['user_added']?></td>
          <td><?php echo $row['problem_title']?></td>
          <td><?php echo $row['dept']?></td>
          <td><?php echo $row['date']?></td>
          <td><?php if($row['status']=='open') {
            echo '<button type="button" class="btn btn-success">';
             echo $row['status'];
            echo '</button>';
          } elseif($row['status']=='closed') {
            echo '<button type="button" class="btn btn-danger">';
             echo $row['status'];
            echo '</button>';
          }?></td>
          
          <td>
          <button class="button" onClick="window.open('../update.php?tkt_id=<?php echo $row['tkt_id']?>' , width=400,height=300)"> Update </button>
          <button class="button" onClick="window.open('../logs.php?tkt_id=<?php echo $row['tkt_id']?>' , width=300,height=300)"> Logs </button>
          <button class="button" onClick="window.open('../attachment.php?tkt_id=<?php echo $row['tkt_id']?>' , width=300,height=300)"> Attachment </button>
          <a class="btn btn-outline-secondary" href='handle.php?tkt_id=<?php echo $row['tkt_id']?>'>Handle</a> 
        </td>
        </tr>
    </tbody>
    </table>
    
    
    
    
    <?php
    
    
    
    
    }
}



?>




<?php
include "fotter.php"; 
?>