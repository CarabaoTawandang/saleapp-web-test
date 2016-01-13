<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$value				=	$_POST["value"];	//รหัสUser
$sql1="select dc_groupname,dc_groupid
			from st_View_User_DC 
			where dc_groupid='$value'
			group by dc_groupname,dc_groupid
			";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry1=sqlsrv_query($con,$sql1,$params,$options);
			$detail1=sqlsrv_fetch_array($qry1);
			if($detail1['dc_groupid'])
			{
			echo "ร้านค้าใน ";
			echo $detail1['dc_groupid']; echo "  : ". $detail1['dc_groupname']; 
			echo "<br>";
			
			$sql3="select st_user.dc_groupid
			,st_user_group_dc_detail.dc_GeoId   as GEO_CODE
			,dc_geography.GEO_NAME
			,st_user_group_dc_detail.dc_ProId as PROVINCE_CODE
			,dc_province.PROVINCE_NAME
			,dc_province.PROVINCE_ID

			from st_user left join st_user_group_dc_detail
			on st_user.dc_groupid =st_user_group_dc_detail.dc_groupid  left join  dc_geography
			on st_user_group_dc_detail.dc_GeoId = dc_geography.GEO_CODE left join dc_province
			on st_user_group_dc_detail.dc_ProId = dc_province.PROVINCE_CODE

			where st_user.dc_groupid='$value'


			group by  st_user.dc_groupid
			,st_user_group_dc_detail.dc_GeoId
			,dc_geography.GEO_NAME
			,st_user_group_dc_detail.dc_ProId
			,dc_province.PROVINCE_NAME
			,dc_province.PROVINCE_ID
			order by dc_province.PROVINCE_NAME asc";
			
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);
				
				
			$sql4="select ,st_user.dc_groupid 
			,st_user_group_dc_detail.dc_GeoId as GEO_CODE 
			,dc_geography.GEO_NAME 
			,st_user_group_dc_detail.dc_ProId as PROVINCE_CODE 
			,dc_province.PROVINCE_NAME 
			,dc_province.PROVINCE_ID 
			,st_user_group_dc_detail.dc_ampId 
			from st_user left join st_user_group_dc_detail on st_user.dc_groupid =st_user_group_dc_detail.dc_groupid left join dc_geography 
			on st_user_group_dc_detail.dc_GeoId = dc_geography.GEO_CODE left join dc_province on st_user_group_dc_detail.dc_ProId = dc_province.PROVINCE_CODE 
			where st_user.dc_groupid='$value ' 

			group by st_user.dc_groupid ,st_user_group_dc_detail.dc_GeoId ,dc_geography.GEO_NAME ,st_user_group_dc_detail.dc_ProId 
			,dc_province.PROVINCE_NAME ,dc_province.PROVINCE_ID ,st_user_group_dc_detail.dc_ampId 
			order by dc_province.PROVINCE_NAME asc";
			
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry4=sqlsrv_query($con,$sql4,$params,$options);
				$row4=sqlsrv_num_rows($qry4);
?>


<script type="text/javascript">
$(function(){	
		//alert("phung");
		$('#txt_geo').change(function(){
				$.ajax({
					url:'report/provinceDC2.php',
					type:'POST',
					data:$('#frmuser').serialize(),
					//alert("phung");
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro').html(result);
					}
				});
		});	
		<? for($i=1;$i<=$row3;$i++){ ?>
		$('#txtPro<?=$i;?>').click(function(){
					if($(this).is(":checked")){
					$(".boxT").hide();
					$(".showPro<?=$i;?>").show();
					document.getElementById("showPro<?=$i;?>").style.display="block"
					document.getElementById("notshowPro<?=$i;?>").style.display="none";
					} 
					else{
					$(".boxT").hide();
					$(".notshowPro<?=$i;?>").show();
					document.getElementById("notshowPro<?=$i;?>").style.display="block";
					document.getElementById("showPro<?=$i;?>").style.display="none";
					}
		});//txtGeo1
		<? } ?>
		
		
		
		
		
		
		<? for($j=1;$j<=$row4;$j++){ $detailAmp=sqlsrv_fetch_array($qry4); ?>
		$('#txtAmp_<?=$detailAmp['dc_ampId'];?>').click(function(){ //alert("showCust_<?=$detailAmp['dc_ampId'];?>");
					if($(this).is(":checked")){
					$(".boxT").hide();
					$(".showCust_<?=$j;?>").show();
					
					document.getElementById("showCust_<?=$j;?>").style.display="block"
					document.getElementById("NotshowCust_<?=$j;?>").style.display="none";
					} 
					else{
					$(".boxT").hide();
					$(".NotshowCust_<?=$detailAmp['dc_ampId'];?>").show();
					document.getElementById("NotshowCust_<?=$j;?>").style.display="block";
					document.getElementById("showCust_<?=$j;?>").style.display="none";
					}
		});//txtGeo1
		<? } ?>
		
		
			
		
		
	});//function	
</script>
<input type="button" class="button_style" id="btnShow" value="Add New" onclick="return btnShow_onclick()"
causesvalidation="false" style="width: 68px; height: 28px" />
<?
			$j=1;
				for($i=1;$i<=$row3;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry3);
			?>
			<input type="checkbox" value="<?print $detail3['PROVINCE_CODE']?>" id="txtPro<?=$i;?>" name="txtPro[]"><?print $detail3['PROVINCE_NAME']; ?>
			<div id="showPro<?=$i;?>" style="display:none">
				<? 
				if($i==$i)
				{	$sqlAmp="SELECT AMPHUR_CODE,AMPHUR_NAME FROM dc_amphur where PROVINCE_ID='$detail3[PROVINCE_ID]' ";
					$qryAmp=sqlsrv_query($con,$sqlAmp,$params,$options); 
					
					while($detailAmp=sqlsrv_fetch_array($qryAmp))
					{ ?> 
					&nbsp;&nbsp;&nbsp;
					<input type="checkbox" id="txtAmp_<?=$detailAmp['AMPHUR_CODE'];?>" name="txtAmp[]" value="<?=$detailAmp['AMPHUR_CODE'];?>">อ.<? echo $detailAmp['AMPHUR_NAME'];?>
					<div id="showCust_<?=$j;?>" style="display:none">
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id="txtCust_" name="txtCust[]" >ร้านค้า
					</div>
					<div id="NotshowCust_<?=$j;?>" ></div>	
					
					<? 
					$j++;} //while
				}//for
				
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="allCustPro" name="allCustPro" value="allCustPro">เลือกทุกร้านใน จ. <?print $detail3['PROVINCE_NAME']; ?>
					<br>
			</div>	
			<div id="notshowPro<?=$i;?>" ></div>		
				
				
				
				
				<? echo"<br>";
				}	
				?>
				
			
<?
			}
			else
			{
			echo "ไม่ได้ผูก DC ไว้คะ";
			}
?>