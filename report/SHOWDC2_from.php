<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		
		
		
		$('#txt_pro').change(function(){
				
				$.ajax({
					url:'report/aumphur.php',
					type:'POST',
					data:'value='+$('#txt_pro').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_aum').html(result);
					}
				});
		});	
		$('#txt_aum').change(function(){
				
				$.ajax({
					url:'report/district.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_dis').html(result);
					}
				});
		});
	});//function	
</script>
</head>
<body>
<?

include("../includes/config.php");
echo "DC : ".$value				=	$_POST["value"];	//รหัสUser
?>
<br>
<B style="color:black;text-align:center;">จังหวัด  :</B>
	<select id="txt_pro" name="txt_pro"   style="width:150px;">
		<option value="" > - Selete -</option>
		<?
			$sql3="SELECT * FROM dc_Province order by PROVINCE_NAME asc  ";
	
	
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);
				for($i=0;$i<$row3;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry3);
			?>
			<option value="<?print $detail3['PROVINCE_CODE']?>"><?print $detail3['PROVINCE_NAME']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>
				

	</select>
	<B style="color:black;text-align:center;">อำเภอ / แขวง  :</B>
	<select id="txt_aum" name="txt_aum"   style="width:150px;">
		<option value="" > - Selete -</option>
	</select>
	<B style="color:black;text-align:center;">ตำบล / แขวง  :</B>
	<select id="txt_dis" name="txt_dis"   style="width:150px;">
		<option value="" > - Selete -</option>
	</select>
</body>
</html>