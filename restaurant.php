<html>
<head><title>Restaurant</title></head>
<script src="jquery-3.3.1.min.js"></script>
<body>
    <fieldset>
        <legend>Making Orders</legend>
    <form action="" method="POST" id="form1" >
        <p><label for="cc">Guest Name</label>   <input type="text" id="gn" name="gn"></p>
        
        <p><label for="rn">Guest-Room</label>   <select name="groom" id="groom">
            <option value="1"> Room 1</option>
            <option value="2"> Room 2</option>
            <option value="3"> Room 3</option>
            <option value="4"> Room 4</option>
            <option value="5"> Room 5</option>
            <option value="6"> Room 6</option>
            <option value="7"> Room 7</option>
            <option value="8"> Room 8</option>
            <option value="9"> Room 9</option>
            <option value="10"> Room 10</option>
            </select>
        </p>
            

           
            <label for="mo">Make Order(Meals)</label>  
            <select name="morder" id="mo">
            <option value="Break fast(milk-cheese-jam-bread)" >Break fast(milk-cheese-jam-bread)</option>
            <option value="lunch(Bean-cheese-eggs-tea)">lunch(Bean-cheese-eggs-tea)</option>
            <option value="dinner(milk-cheese-egges)">dinner(milk-cheese-egges)</option>
            </select><input type="number" name="mp" id="mp">
            
            <label for="do">Make Order(Drinks)</label>  
            <select name="dorder" id="do">
            <option value="Tea">Tea</option>
            <option value="Nescafe">Nescafe</option>
            <option value="Coffee">Coffee</option>
            </select><input type="number" name= "dp" id="dp">

        <input type="submit" name="submit" value="Order" id="reserv">
        </form>
        </fieldset>
        <br>
        <fieldset> <legend>Invoice</legend>
            
                <p>Guest Name <input type="text" name="guest" id="gname"></p>
        <input type="button" value="Check-orders"  name="orders" id="sub">
        <div id="tbl"></div>

</fieldset>
</body>
</html>
<script>
    $("#gname").on("blur",function(e)
    {
        var str=document.getElementById("gname").value;
        var res=str.split(" ");
        var len=res.length;
        if(len!=3)
        {
            alert("Name Must Be Triple");
            document.getElementById("gname").value='';
        }
    }
    );
    $("#gn").on("blur",function(e)
    {
        var str=document.getElementById("gn").value;
        var res=str.split(" ");
        var len=res.length;
        if(len!=3)
        {
            alert("Name Must Be Triple");
            document.getElementById("gn").value='';
        }
    }
    );
$("#mo").on("mouseout",
    function(e){
        var meal=document.getElementById("mo").value;
        
        
        $.ajax(
            {
                "type":"GET",
                "url":"getordersmeal.php",
                "data":'meal='+meal,
                "success":function(response)
                {
                    if(response)
                    {
                        var orders=JSON.parse(JSON.stringify(response));
                        var results=JSON.parse(orders);
                        console.log(results);
                        document.getElementById("mp").value=results[0].mprice;
                      
                      
                    }
                }
            }
            
            );
    });

    $("#do").on("mouseout",
    function(e){
       
        var drink=document.getElementById("do").value;
        
        $.ajax(
            {
                "type":"GET",
                "url":"getordersdrink.php",
                "data":'drink='+drink,
                "success":function(response)
                {
                    if(response)
                    {
                        var orders=JSON.parse(JSON.stringify(response));
                        var results=JSON.parse(orders);
                        console.log(results);
                        document.getElementById("dp").value=results[0].dprice;
                      
                      
                    }
                }
            }
            
            );
    });

    $("#sub").on("click",
    function(e){
        var name=document.getElementById("gname").value;
        
        
        $.ajax(
            {
                "type":"GET",
                "url":"orders.php",
                "data":'name='+name,
                "success":function(response)
                {
                    if(response)
                    {
                        var orders=JSON.parse(JSON.stringify(response));
                        var results=JSON.parse(orders);
                        console.log(results);
                        console.log(results.length);
                        //document.getElementById("mp").value=results[0].mprice;
                        var str="<table ><th>Guest Details</th> <tr><td>Name :</td><td>"+results[0].guestname+"</td></tr>"
                        +"<tr><td>Room :</td><td>"+results[0].roomnum+"</td></tr><th>Guest Invoice</th>";
                        var sum=0;
                        for(var i=0;i<results.length;i++)
                        {
                            var keys=Object.keys(results[i]);
                            str+="<tr><td>"+keys[2] +":</td><td>"+results[i].meals+"</td></tr>";
                            str+="<tr><td>"+keys[3] +":</td><td>"+results[i].mprice+"</td></tr>";
                            str+="<tr><td>"+keys[4] +":</td><td>"+results[i].drinks+"</td></tr>";
                            str+="<tr><td>"+keys[5] +":</td><td>"+results[i].dprice+"</td></tr>";
                            sum+=Number(results[i].mprice);
                            sum+=Number(results[i].dprice);
                        }
                        str+="<th>Total Price</th><tr><td>Inovice :</td><td>"+sum+"</td></tr>";
                        str+="</table>";
                        document.getElementById("tbl").innerHTML=str;
                      
                    }
                }
            }
            
            );
    });

</script>
<?php
if (isset($_POST['submit']))
{
    $conn = new mysqli("localhost","root","" ,"hotel");
    $guestname=$_POST['gn'];
    $room=$_POST['groom'];
    $meal=$_POST['morder'];
    $mprice=$_POST['mp'];
    $drink=$_POST['dorder'];
    $dprice=$_POST['dp'];
    $sql = "INSERT INTO Guest (guestname, roomnum, meals,mprice,drinks,dprice)
VALUES ('$guestname', '$room', '$meal','$mprice','$drink','$dprice')";
mysqli_query($conn, $sql);
}
?>
