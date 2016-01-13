<?		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=$_SESSION["USER_id"];	//รหัสพนักงาน
		$id="359224062552545";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
html{
	padding:0px;
	margin:0px;
}
div#map_canvas{
	margin:auto;
	width:600px;
	height:550px;
	overflow:hidden;
}
</style>

</head>

<body>

<div id="map_canvas">
</div> 
<?
		$GPS_="SELECT TOP 10 *, cast(date_time as datetime) as date_time_
				FROM st_gps_tracking 
				where imei = '$id'
				ORDER BY date_time desc	";
		$GPS_=sqlsrv_query($con,$GPS_,$params,$options);
		$num_rows=sqlsrv_num_rows($GPS_);
		
		
		
		
		/*$GPS=sqlsrv_fetch_array($GPS_);*/
		/*$r_num=sqlsrv_num_rows($GPS_);*/		
?>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAcNvUk-nhOGHxtqYjlYDTRRQIRG6yKtEoODg8BfMKCyHqWgeYjhTbSKxVXskDpcNKx0i7Msr1-E1jhg" type="text/javascript"></script>

<script type="text/javascript"> 
function initialize() { 
    
    var map = new GMap(document.getElementById("map_canvas")); 
	
<?	
	$resultArray = array();
	for ($i = 0;$i<$num_rows;$i++) {
	$GPS=sqlsrv_fetch_array($GPS_);
	array_push($resultArray,$GPS);

		/*while ($GPS = sqlsrv_fetch_array($GPS_)){*/
	$GPS_X=$GPS['latitude'];
	$GPS_Y=$GPS['longitude'];
	$GPS_DAY=date_format($GPS['date_time_'],'d/m/Y H:i:s');?>//ดึงพิกัด
	
	var center = new GLatLng(<?echo $GPS_X;?>,<?echo $GPS_Y;?>); // การกำหนดจุดเริ่มต้น
	
	map.setCenter(center, 13);  // เลข 13 คือค่า zoom  สามารถปรับตามต้องการ 
	map.setUIToDefault(); 	
	var marker = new GMarker(center);  
    map.addOverlay(marker);			


<?}?>//loop	
  } 
 
</script>

</body>
</html>
<script type="text/javascript" src="js/jquery-1.4.1.min.js"></script>
<script type="text/javascript">
$(function(){
	initialize();
	$(document.body).unload(function(){
			GUnload();
	});
});
</script>
