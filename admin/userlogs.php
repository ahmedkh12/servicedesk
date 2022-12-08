<?php
include "nav.php";
include "conn.php";

if(isset($_SESSION['user'])&& $_SESSION['reg']==1){


          
      $stmt =  $conn ->prepare("SELECT * FROM `tkt_logs` ");
      $stmt->execute();
      $rows = $stmt->fetchAll();
      $count = $stmt->rowCount();
    
















  
  
    
    }
    else{
      header('Location: ../login.php');
      exit();
    }
  


?>






<table class="table table-striped  table-sm">

<thead>
    <tr>
      <th scope="col">SQL ID </th>
      <th scope="col">TKT ID </th>
      <th scope="col">Problem</th>
      <th scope="col">Details</th>
      <th scope="col">user</th>
      <th scope="col">Status</th>
      <th scope="col">Date</th>

    </tr>
  </thead>
<tbody>
<?php
foreach($rows as $row){
?>

<tr>
      <td><?php echo $row['id']?></td>
      <td><?php echo $row['tkt_id']?></td>
      <td><?php echo $row['problem']?></td>
      <td><?php echo $row['details']?></td>
      <td><?php echo $row['user']?></td>
      <td><?php echo $row['status']?></td>
      <td><?php echo $row['date']?></td>

    </tr>


<?php







}
?>




</tbody>



</table>

















<?php
include "fotter.php";
?>




