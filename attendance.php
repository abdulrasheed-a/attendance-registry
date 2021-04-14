<?php
$user_name='';
$password='';
$server='';
$database='';
$db_handle=mysqli_connect($server,$user_name,$password,$database);
if(!$db_handle){
    die("Could not connect : ".mysql_error());
}
function get_client_ip() {
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$ipadd=get_client_ip();
$dev_name=$_SERVER['HTTP_USER_AGENT'];
if(isset($_POST['fsubmit']))
{
	$rollno=$_POST['rollno'];
	$name=$_POST['sname'];
	$sql = "INSERT INTO stud(rollno,name,client_ip,device) values('$rollno','$name','$ipadd','$dev_name')";
	if(mysqli_query($db_handle,$sql)){
		echo "Submitted Succesfully";
	}
	else{
		echo "Error: ".$sql."".mysqli_error($db_handle);
	}
	mysqli_close($db_handle);
}
elseif(isset($_POST['vsheet']))
{
	$sqlview=mysqli_query($db_handle,"SELECT * from stud");
	if(mysqli_num_rows($sqlview)>0){
		echo "<table align='center' border=2>
		<tr><th>Rollno</th>
		<th>Name</th>
		<th>Timestamp</th>
		<th>IP Address</th>
		<th>Device</th>";
		while($row=mysqli_fetch_array($sqlview)){
			echo "<tr>
			<td>".$row['rollno']."</td>
			<td>".$row['name']."</td>
			<td>".$row['date_of_attend']."</td>
			<td>".$row['client_ip']."</td>
			<td>".$row['device']."</td>
			</tr>";
		}
		echo "</table>";
		mysqli_close($db_handle);
	}
	else{
		echo "No Entry Found";
	}
}
?>