<?php
if(isset($_GET['meal']))
{
    $conn = new mysqli("localhost","root","" ,"hotel");

    $meal=$_GET['meal'];
    $sql="select mprice from Orders where meals='$meal'";
 
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