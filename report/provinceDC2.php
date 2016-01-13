<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_POST["txt_packName"];	//รหัสUser
$value=$_POST['txt_geo'];

$sql3="select st_user.User_id,st_user.dc_groupid
,st_user_group_dc_detail.dc_GeoId   as GEO_CODE
,dc_geography.GEO_NAME
,st_user_group_dc_detail.dc_ProId as PROVINCE_CODE
,dc_province.PROVINCE_NAME


from st_user left join st_user_group_dc_detail
on st_user.dc_groupid =st_user_group_dc_detail.dc_groupid  left join  dc_geography
on st_user_group_dc_detail.dc_GeoId = dc_geography.GEO_CODE left join dc_province
on st_user_group_dc_detail.dc_ProId = dc_province.PROVINCE_CODE

where st_user.User_id='$USER_id'
and st_user_group_dc_detail.dc_GeoId='$value'

group by  st_user.User_id,st_user.dc_groupid
,st_user_group_dc_detail.dc_GeoId
,dc_geography.GEO_NAME
,st_user_group_dc_detail.dc_ProId
,dc_province.PROVINCE_NAME
order by dc_province.PROVINCE_NAME asc";
	
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);
?>
<option value=''>- Select* -</option>
<?
			
				for($i=0;$i<$row3;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry3);
			?>
			<option value="<?print $detail3['PROVINCE_CODE']?>"><?print $detail3['PROVINCE_NAME']   ?></option>
					
				<?
				
			
				}	
				
				
				
				?>
				
