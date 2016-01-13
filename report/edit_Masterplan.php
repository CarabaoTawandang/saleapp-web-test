<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
		$RoleID =$_SESSION["RoleID"];
		
		$Plan_id= $_GET['id'];
		
		$sqlOpen="select a.Plan_id,a.Plan_name,a.DC_id,a.Remark,a.COMPANYCODE
		,b.dc_groupname,c.COMPANYNAME
		from st_Master_plan a left join st_user_group_dc b
		on a.DC_id = b.dc_groupid left join st_companyinfo_exp c
		on a.COMPANYCODE = c.COMPANYCODE
		where a.Plan_id =$Plan_id ";
		$qryOpen=sqlsrv_query($con,$sqlOpen);
		$reOpen=sqlsrv_fetch_array($qryOpen);
		//$rowOpen=sqlsrv_num_rows($qryOpen);
		
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
	<link rel="stylesheet" href="css_mo/app.css" type="text/css">

<script type="text/javascript">
$(function(){
	$(".add_customer").click(function(){
		if($('#select_provider').prop('value')=='')  {alert("โปรดใส่DC ก่อน!!!");}
		else {detail_provider(id_provider);}
		
	});
	
    var id_provider = $('#select_provider').prop('value');
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
                            url: 'report/load_data_providerDC2.php',
                            type: 'POST',
                            data: {array_id: array_id},
                            success: function(data){
                                $(".result_list").html(data);

                                //hidden alert
                                $(".alert_box").css("display", "none");



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
			var txt_planID =$('#txt_planID').prop('value');
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
			$('.box').html("<img src='images/89.gif'>");
            $.ajax({
                url: 'report/save_EditMasterPlan.php',
                type: 'POST',
                data: {array_id: array_ids, id_provider: id_provider,txt_planID,select_provider,txt_planName,txt_remark,txt_COMPANY},
                success: function(data){
                    $(".box").html(data);
                }
            });
        }else{
            alert("ไม่มีข้อมูลร้านค้าในแผน!!!");
        }
		}//else
    });
	
	
	$("#btn_add,#btSAVE").button();
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
	$(document).find(".div_this_item .this_item").each(function(){
                                        //alert($(this).find("span").html().trim());
                                        array_id[count_index] = $(this).find("span").html().trim();
                                        count_index++;
	});


	
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
        
        <h3>แก้ไขแผน</h3>
            
          <p>
		  <input type="button" value="ค้นหาแผน" id="btn_add" onclick="window.location='?page=from_plan';"  class="inner_position_right">
		  </p>

            
    </div>
        
    <div class="sep"></div><br>
<div class="box" align="center" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  width="1124px">


<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>หัวข้อแผนการวิ่ง : </B></td><td>
<input type="text" id="txt_planName" name="txt_planName" value="<? echo $reOpen['Plan_name']; ?>" ><B style="color:red;text-align:center;">*</B>
<input type="hidden" id="txt_planID" name="txt_planID" value="<? echo $reOpen['Plan_id']; ?>" >
</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>DC: </B></td><td>
	<select  id="select_provider" name="select_provider" style="width:200px;" >
	<option value="<? echo $reOpen['DC_id']; ?>"><? echo $reOpen['dc_groupname']; ?></option>
		
	<B style="color:red;text-align:center;">*</B>
	
</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150" align="left"  valign= "top" ><B>ร้านค้า : </B></td>
<td align="left">
	<button class="btn_remove_this" disabled>ลบร้านในแผน</button>
	<button class="add_customer">เพิ่มร้านในแผน</button>
	<B style="color:red;text-align:center;">*หมายเหตุ : ควรจัดเรียงลำดับการเข้าร้านหลังจากเพิ่มร้านหรือลบร้านค้าในแผนเรียบร้อยแล้ว</B>
	<div class="result_list">
		<div class="div_this_item" style="overflow-y: auto;width: 90%; height: 400px; border-radius: 10px; padding: 2%; text-align: left; position: relative; margin: 0 ; margin-top: 2%; background-color: rgba(81,80,40, 0.2)">
		<?php 
			$sqlCheck="select a.Plan_id,a.row,a.Cust_num
			,b.CustName
			,b.AddressNum
			,b.AddressMu 
			,b.DISTRICT_NAME
			,b.AMPHUR_NAME
			,b.PROVINCE_NAME
			,b.cust_type_name
			from st_Master_PlanDetail a left join st_View_cust_web  b
			on a.Cust_num =b.CustNum
			where a.Plan_id =$Plan_id
			order by a.row asc";	
			$qryCkeck=sqlsrv_query($con,$sqlCheck);
			while($reCkeck=sqlsrv_fetch_array($qryCkeck))
			{ $Cust_num= $reCkeck['Cust_num']; $row= $reCkeck['row'];
		?>
				<div class="this_item ui-state-default"  >
					<input type="checkbox" class="checkbox" value="<?php echo $Cust_num;?>">
					
					<?php 	
							echo "[".$row."] -";
							echo "<span style='cursor: pointer'>". $Cust_num ;	echo "</span>";
							echo " ".$reCkeck['CustName'];
							echo "  ที่อยู่  ".$reCkeck['AddressNum'];
							echo " ม.  ".$reCkeck['AddressMu'];
							echo " ต.  ".$reCkeck['DISTRICT_NAME'];
							echo " อ.  ".$reCkeck['AMPHUR_NAME'];
							echo " จ.  ".$reCkeck['PROVINCE_NAME'];
							echo " ".$reCkeck['cust_type_name'];
							
		?>
					
				</div>

		<?php }?>

		</div><? //echo $sqlCheck ?>
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
<input type="text" id="txt_remark"align="center" name="txt_remark" size="35" value="<? echo $reOpen['Remark']; ?>"/></td></tr>
	
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
	<option value="<?print $reOpen['COMPANYCODE']?>" ><?print $reOpen['COMPANYNAME']?></option>
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
