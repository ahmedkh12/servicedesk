<?php
include "nav.php";
include "conn.php";

if(isset($_SESSION['user'])){

  $stmt =  $conn ->prepare("SELECT  `tkt_id`, `problem_title`, `problem_details`, `dept`, `status` , `user_added`, `date` FROM `tkts` WHERE `user_added` = ? ");
  $stmt->execute(array($_SESSION['user']));
  $rows = $stmt->fetchAll();





}
else{
  header('Location: login.php');
  exit();
}





?>






<table class="table table-striped  table-sm">
  <thead>
    <tr>
      <th scope="col"># Ticket ID </th>
      <th scope="col">Problem Title</th>
      <th scope="col">Department</th>
      <th scope="col">Created Date</th>
      <th scope="col">Status</th>
      <th scope="col">Actions</th>

    </tr>
  </thead>
  <tbody>
    <?php
    foreach($rows as $row){
 ?>
    <tr>
      <td><?php echo $row['tkt_id']?></td>
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
      <button class="button" onClick="window.open('update.php?tkt_id=<?php echo $row['tkt_id']?>' , width=400,height=300)"> Update </button>
      <button class="button" onClick="window.open('logs.php?tkt_id=<?php echo $row['tkt_id']?>' , width=300,height=300)"> Logs </button>
      <button class="button" onClick="window.open('attachment.php?tkt_id=<?php echo $row['tkt_id']?>' , width=300,height=300)"> Manage Attachment </button>
      </td>
    </tr>



<?php

    }
    
    
    
    ?>

  
  </tbody>
</table>













<?php
include "fotter.php";
?>