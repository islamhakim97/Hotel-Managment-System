<?php
if(isset($_GET['name']))
{
    $conn = new mysqli("localhost","root","" ,"hotel");
    $name=$_GET['name'];
    $sql="select in_date,out_date from Reserve where cname='$name'";
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