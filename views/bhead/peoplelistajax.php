<?php

$connect = mysqli_connect("localhost", "root", "", "monitoring");
$output = '';
$sql = " SELECT * FROM person WHERE pid LIKE '%".$_POST["search"]."%'";
$result = mysqli_query($connect, $sql);
if(mysqli_num_rows($result) > 0)
{
 $output .= '<h4 align="center">Search Result</h4>';
 $output .= '<div class="table-responsive">
            <table class="table table bordered">
                <tr>
                  <th scope="col">Person ID</th>
			      <th scope="col">Full Name</th>
			      <th scope="col">Gender</th>
			      <th scope="col">Contact Number</th>
			      <th scope="col">Address</th>
			     
			      
			      <th scope="col">Date Added</th>
                  <th scope="col">Action</th>
                </tr>';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '
   <tr>
   <th>'.$row['pid'].'</th>
   <td>'.$row['firstname'].' '.$row['lastname'].'</td>
   <td>'.$row['gender'].'</td>
   <td>'.$row['contactno'].'</td>
   <td>'.$row['address'].'</td>
   
   <td>'.$row['daterecorded'].'</td>
   <td><input type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'" value="View Records"/></td>
   </tr>
  ';
 }
 echo $output;
}
else
{
 echo 'Data Not Found';
}

?>
