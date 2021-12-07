<?php

$connect = mysqli_connect("localhost", "root", "", "monitoring");
$output = '';
$sql = " SELECT * FROM record WHERE reason LIKE '%".$_POST["search"]."%' or daterecorded LIKE '%".$_POST["search"]."%'
or timeout LIKE '%".$_POST["search"]."%' or status LIKE '%".$_POST["search"]."%' ";
$result = mysqli_query($connect, $sql);
if(mysqli_num_rows($result) > 0)
{
 $output .= '<h4 align="center">Search Result</h4>';
 $output .= '<div class="table-responsive">
            <table class="table table bordered">
                <tr>
                <th scope="col">ID no.</th>
                <th scope="col">datet</th>
                <th scope="col">Time Out</th>
                <th scope="col">Point of Origin</th>
                <th scope="col">Destination</th>
                <th scope="col">Reason</th>
                <th scope="col">Status</th>
                </tr>';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '
   <tr>
   <td>'.$row['rid'].'</td>
   <td>'.$row['daterecorded'].'</td>
   <td>'.$row['timeout'].'</td>
   <td>'.$row['pointoforigin'].'</td>
   <td>'.$row['addressto'].'</td>
   <td>'.$row['reason'].'</td>
   <td>'.$row['status'].'</td>
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