<html>
<head><title>Hotel Managment System</title></head>
<script src="jquery-3.3.1.min.js"></script>
<body>
    <fieldset>
        <legend>Reception</legend>
    <form action="" method="POST" id="form1" >
        <p><label for="cc">Customer Credit Number</label>   <input type="number" id="cc" name="cnum"></p>
        <p><label for="cn">Customer Name</label>   <input type="text" id="cn" name="cname"></p>
        
        <p><label for="chkin">Check-in</label>   <input type="date" id="chkin" name="chkin"></p>
        <p><label for="chkout">Check-out</label>   <input type="date" id="chkout" name="chkout"></p>
        <p><label for="rn">Room-Number</label>   <select name="roomnum" id="rn">
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
            </select></p>
        <input type="submit" name="submit" value="Reserve" id="reserv">
        </form>
        </fieldset>

        <fieldset>
           <legend>Check-Out</legend>
           <p><label for="rname">Resident name </label><input type="text" id="rname"></p>
           <p><button>Check-Out</button></p>
           <div id ="div1"></div>
        </fieldset>
</body>
<script>
     $("button").on("click",function(e)
     {
         var name=document.getElementById("rname").value;
         var str="<table >";
                        var sum=0;
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
                       str+="<th>Guest Details</th> <tr><td>Name :</td><td>"+results[0].guestname+"</td></tr>"
                        +"<tr><td>Room :</td><td>"+results[0].roomnum+"</td></tr><th>Guest Invoice</th>";
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
                        str+="<th>Total Price</th><tr><td>Resturant Price :</td><td>"+sum+"</td></tr>";
                        
                       // document.getElementById("tbl").innerHTML=str;
                      
                    }
                }
            }
            
            );

      
            $.ajax(
            {
                "type":"GET",
                "url":"days.php",
                "data":'name='+name,
                "success":function(response)
                {
                    if(response)
                    {
                        var orders=JSON.parse(JSON.stringify(response));
                        var results=JSON.parse(orders);
                        console.log(results);
                        var din=results[0].in_date;
                        var dout=results[0].out_date;
                        dt1=new Date(din);
                        dt2=new Date(dout);
                        var days=Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
                        console.log(days);
                        var totalroom=days*200;
                        str+="<tr><td>Total days :</td><td>"+days+"</td></tr>"+
                        "<tr><td>Room Booking Price :</td><td>"+totalroom+"</td></tr>";
                        sum+=totalroom;
                        str+="<th>Total Reservation Cost</th><tr><td>Total Reservation :</td><td>"+sum+"</td></tr>"
                        str+="</table>";
                         document.getElementById("div1").innerHTML=str;
                      
                    }
                }
            }
            
            );
     }
     );

    $("#cn").on("blur",function(e)
    {
        var str=document.getElementById("cn").value;
        var res=str.split(" ");
        var len=res.length;
        if(len!=3)
        {
            alert("Name Must Be Triple");
            document.getElementById("cn").value='';
        }
    }
    );
     
    $("#chkout").on("mouseout",function(e)
    {
    var chkin=document.getElementById("chkin").value;
    var chkout=document.getElementById("chkout").value;
    if (chkout<chkin)
    {
        alert("chkin must be less than chkout");
        //document.getElementById("chkin").value="0000-00-00";
        //document.getElementById("chkout").value="0000-00-00";
    }
    }
    );

    $("#rn").on("mouseout",function(e)
    {
       
        var room=Number(document.getElementById("rn").value);
        $.ajax(
            {
                "type":"GET",
                "url":"reserved.php",
                "data":'room='+room,
                "success":function(response)
                {
                    if(response)
                    {
                        var dates=JSON.parse(JSON.stringify(response));
                        var results=JSON.parse(dates);
                        var chkin=document.getElementById("chkin").value;
                        var chkout=document.getElementById("chkout").value;
                        if(results!=0)
                        {
                        for (var i=0;i<results.length;i++)
                        {
                            //var d1 = Date.parse("2012-11-01");
                            //var d2 = Date.parse("2012-11-04");
                            if (chkin>=results[i].in_date&&chkout<=results[i].out_date)
                            {
                               
                                alert("This is room is reserved");

                                e.preventDefault();
                              
                                
                                }
                        }
                        }
                        else
                        {
                             // console.log(results[0].in_date);
                        }
                      
                      
                    }
                }
            }
            
            );
    }
    );
</script>
</html>
<?php
if (isset($_POST['submit']))
{
$conn = new mysqli("localhost","root","" ,"hotel");
$cnum=$_POST['cnum'];
$cname=$_POST['cname'];
$chkin=$_POST['chkin'];
$chkout=$_POST['chkout'];
$roomnum=$_POST['roomnum'];
$sql = "INSERT INTO Reserve (cc, cname, roomnum,out_date,in_date)
VALUES ('$cnum', '$cname', '$roomnum','$chkout','$chkin')";
mysqli_query($conn, $sql);
}
?>
