<?php
if(isset($_GET['drink']))
{
    $conn = new mysqli("localhost","root","" ,"hotel");
    $drink=$_GET['drink'];

    $sql="select dprice from Orders where drinks='$drink'";
 
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