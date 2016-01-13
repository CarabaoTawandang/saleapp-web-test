<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
		$RoleID =$_SESSION["RoleID"];
		$userType= $_SESSION["RoleID"];
		$userType2 = $_SESSION["RoleID_Lineid"];
		
		$sqlOpen="select cust_type_id,cust_type_name from st_cust_type";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$rowOpen=sqlsrv_num_rows($qryOpen);
		
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
	

<script type="text/javascript">
$(function(){
	//$(".alert_box").css("display", "block").html("<img src='images/89.gif'>");
	$(".add_customer").click(function(){
		if($('#select_provider').prop('value')=='')  {alert("โปรดใส่DC ก่อน!!!");}
		else {detail_provider(id_provider);}
		
	});
	
    var id_provider = "";
    var array_id = [];
    var count_index = 0;
	
    $("#select_provider").change(function(){
		
		id_provider = $(this).val().trim();
        detail_provider(id_provider);
    });

    function detail_provider(id_provider){
        $.ajax({
            url: 'report/detail_providerDC.php',
            type: 'POST',
            data: {id_provider: id_provider},
            success: function(data){
                //show alert
                $(".alert_box").css("display", "block");
                $(".detail_content").html(data);

                //save_detail
                var check = false;
                $("#save_detail").click(function(){ 
				
                    $(document).find(".checkbox").each(function(index, value){
                        if($(this).prop("checked")){
                            check = false;
                            if(array_id.length > 0) {
                                for (var i = 0; i < array_id.length; i++) {
                                    if (array_id[i] == $(this).closest("tr").find(".id_detail_provider").html().trim()) {
                                        check = true;
                                    }
                                }
                            }

                            if(!check){
                                array_id[count_index] = $(this).closest("tr").find(".id_detail_provider").html().trim();
                                count_index++;
                                check = false;
                            }
                        }
                    });

                    if(array_id.length > 0){
						$('#save_con').html("<img src='images/89.gif'>");
                        $.ajax({
                            url: 'report/load_data_providerDC.php',
                            type: 'POST',
                            data: {array_id: array_id},
                            success: function(data){
                                $(".result_list").html(data);

                                //hidden alert
                                $(".alert_box").css("display", "none");



                                /*$(document).find(".div_this_item").sortable({
                                    cursor: 'pointer',
                                    update: function(){}
                                });*/
								
								$( ".div_this_item" ).sortable();
								$( ".div_this_item" ).disableSelection();

                                

                                $(".checkbox").click(function(){
                                    var bool = true;
                                    $(this).parent().parent().closest("div").find(".this_item").each(function(){
                                        if($(this).find("input[type=checkbox]").prop("checked")){
                                            bool = false;
                                        }
                                    });

                                    if(!bool){
                                        $(".btn_remove_this").removeAttr("disabled");
                                    }else{
                                        $(".btn_remove_this").attr("disabled", "disabled");
                                    }
                                });

                                $(".btn_remove_this").click(function(){
                                    count_index = 0;
                                    $(this).closest("div").find(".this_item").each(function(){
                                        if($(this).find("input[type=checkbox]").prop("checked")){
                                            $(this).remove();
                                        }
                                    });

                                    $(document).find(".div_this_item .this_item").each(function(){
                                        //alert($(this).find("span").html().trim());
                                        array_id[count_index] = $(this).find("span").html().trim();
                                        count_index++;
                                    });

                                    if($(this).closest("div").find(".this_item").size() == 0){
                                        $(".btn_remove_this").attr("disabled", "disabled");
                                    }
                                });
                            }
                        });
                    }
                });

                //close_detail
                $("#close_detail").click(function(){
                    //hidden alert
                    $(".alert_box").css("display", "none");
                });
            }
        });
    }

    var count = 0;
    var array_ids = [];
    $("#btSAVE").click(function(){
			var select_provider = $('#select_provider').prop('value');	
			var txt_planName = $('#txt_planName').prop('value');
			var txt_remark = $('#txt_remark').prop('value');
			var txt_COMPANY = $('#txt_COMPANY').prop('value');	
        $(document).find(".box .this_item input[type=checkbox]").each(function(){
            count++;
            array_ids[count] = $(this).attr("value");
        });
        count = 0;
		if(txt_planName =='')  {alert("โปรดใส่หัวข้อแผนการวิ่ง !");}
			else if(select_provider=='')  {alert("โปรดใส่DC และร้านค้า !");}
			else {
        if(array_id.length > 0){
			$(".alert_box").css("display", "block").html("<img src='images/89.gif'>");
            $.ajax({
                url: 'report/save_MasterPlan.php',
                type: 'POST',
                data: {array_id: array_ids, id_provider: id_provider,select_provider,txt_planName,txt_remark,txt_COMPANY},
                success: function(data){
                    $(".alert_box").html(data);
                }
            });
        }else{
            alert("ไม่มีข้อมูลร้านค้าในแผน!!!");
        }
		}//else
    });
	
	
	
	$("#btn_add,#btSAVE").button();
	
});
</script>






<style type="text/css">
    .boxhide{
        
        display: none;
        
		
    }
   
</style>

	
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>สร้างแผน</h3>
            
          <p>
		  <input type="button" value="ค้นหาแผน" id="btn_add" onclick="window.location='?page=from_plan';"  class="inner_position_right">
		  </p>

            
    </div>
        
    <div class="sep"></div><br><div id="alert_box"  class="alert_box" align="center"></div>
<div class="box" align="center" >

<table cellpadding="0" cellspacing="0"  border="0" align="center"  width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>หัวข้อแผนการวิ่ง : </B></td><td>
<input type="text" id="txt_planName" name="txt_planName" ><B style="color:red;text-align:center;">*</B>
</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>DC: </B></td><td>
	<select  id="select_provider" name="select_provider" style="width:170px;" >
	<option value="">-เลือก DC-</option>
		<? $sqlOp="select a.dc_groupname,a.dc_groupid
			from st_user_group_dc a   ";
			if($userType <>"7" and $userType2<>""){
				$sqlOp.=" left join st_user u
				on u.dc_groupid =a.dc_groupid
				where u.User_id= '$USER_id'"; }
			echo $sqlOp;
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['dc_groupid']." '>";
			echo $deOp['dc_groupname'];
			echo "</option>";
			}
		?>
	</select>
	<B style="color:red;text-align:center;">*</B>
	
</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150" align="left"  valign= "top" ><B>ร้านค้า : </B></td>
<td align="left">
	<button class="btn_remove_this" disabled>ลบร้านในแผน</button>
	<button class="add_customer">เพิ่มร้านในแผน</button>
	<B style="color:red;text-align:center;">*หมายเหตุ : ควรจัดเรียงลำดับการเข้าร้านหลังจากเพิ่มร้านหรือลบร้านค้าในแผนเรียบร้อยแล้ว</B>
	<div class="result_list">
		<div style="width: 90%; height: 400px; border-radius: 10px; padding: 2%; text-align: left; position: relative; margin: 0 ; margin-top: 2%; background-color: rgba(81,80,40, 0.2)">***
			
		</div>
	</div>
	<div class="alert_box">
        <div class="result_alert">
            <div class="detail_content"></div>
        </div>
	</div>

</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>


<tr><td width="150"><B>หมายเหตุ</B></td><td>
<input type="text" id="txt_remark"align="center" name="txt_remark" size="35"/></td></tr>
	
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
	<?	$sql="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['COMPANYCODE']?>" ><?print $detail['COMPANYNAME']?></option>
		
			<?
			}

		
	
	?>
	</select>
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />
<input type="button" id="btSAVE" name="btSAVE" value="SAVE">			</tr>	
</table>
</div>

</div>
</div>


</body>
</html>
