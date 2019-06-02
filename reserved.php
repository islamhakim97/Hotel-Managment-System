<?php
if(isset($_GET['room']))
{
    $conn = new mysqli("localhost","root","" ,"hotel");
    $roomnum=$_GET['room'];
    $sql="select in_date,out_date from Reserve where roomnum='$roomnum'";
    if($result=$conn->query($sql))
    {
        $rows=array();
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
                array_push($rows,$row);
            }
            echo json_encode($rows);
            
        }
        else
            {
                $rows=0;
                echo json_encode($rows); 
                
            }
        
    }

}


?>