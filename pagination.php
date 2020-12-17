<?php
session_start();
 //pagination.php  
 include('./connection.php');
 $record_per_page = 5;
 $page = '';
 $output = '';
 if(isset($_POST["page"]))  
 {  
      $page = $_POST["page"];  
 }  
 else  
 {  
      $page = 1;  
 }  
 $start_from = ($page - 1)*$record_per_page;  
 $query = "SELECT * FROM visitors ORDER BY fname DESC LIMIT $start_from, $record_per_page";  
 $result = mysqli_query($conn, $query);  
 $output .= "  
      <table class='table table-bordered'>  
           <tr>
                <th width='20%'>Name</th>
                <th width='20%'>Number</th>
                <th width='20%'>Email</th>
                <th width='20%'>Address</th>
                <th width='20%'>Code</th>
           </tr>
 ";  
 while($row = mysqli_fetch_array($result))  
 {  
      $output .= '  
           <tr>  
                <td>'.$row["fname"].''.$row["lname"].'</td>
                <td>'.$row["mobile"].'</td>
                <td>'.$row["email"].'</td>
                <td>'.$row["homeAddress"].'</td>
                <td>'.$row["code"].'</td>
                <td><span><a href="edit-visitor.php?id='.$row["code"].'">Edit</a></span></td>
                <td><span><a href="admin-dashboard.php?id='.$row['code'].'">Delete</a></span></td>
           </tr>  
      ';  
 }  
 $output .= '</table><br /><div align="center">';  
 $page_query = "SELECT * FROM visitors ORDER BY fname DESC";  
 $page_result = mysqli_query($conn, $page_query);  
 $total_records = mysqli_num_rows($page_result);  
 $total_pages = ceil($total_records/$record_per_page);  
 for($i=1; $i<=$total_pages; $i++)  
 {  
      $output .= "<span class='pagination_link' style='cursor:pointer; padding:6px; border:1px solid #ccc;' id='".$i."'>".$i."</span>";  
 }  
 $output .= '</div><br /><br />';  
 echo $output;  
 ?>  