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
	
<script type='text/javascript' src='../jQuery/jquery-1.9.1.min.js'></script>
<script type='text/javascript' src='../jQuery/jquery-ui-1.10.0.custom.min.js'></script>


<script type="text/javascript" src="../jQuery/path.js"></script>
<link rel='stylesheet' type='text/css' href='jQuery/ui-lightness/jquery-ui-1.10.0.custom.min.css'>
<script type="text/javascript">
$(function(){

$('#txt_day,#txt_day1').datepicker({
			
				dateFormat:'yy-mm-dd'
			});
	//$(".alert_box").css("display", "block").html("<img src='images/89.gif'>");
	//$('.result_list').html("<img src='images/89.gif'>");
	$("#btn_add,#btSAVE").button();
	var id_provider = "test";
	$(".add_this").click(function(){
		//alert(id_provider);
		detail_provider(id_provider);
		
	});
	
    
    var array_id = [];
	var array_img = []; 
	var array_id2 = new Array();
	var array_id22 = [];
	var array_id3 = [];
	var array_id4 = [];
	var array_detail = [];
    var row_index = 0;
	var view_img =[];
	
    
       
   

    
    function detail_provider(id_provider){
		
				
        $.ajax({
            url: 'report/detail_Question.php',
            type: 'POST',
            data: {id_provider: id_provider},
            success: function(data){
                //show alert
                $(".alert_box").css("display", "block");
                $(".detail_content").html(data);

                //save_detail
                var select_QuestionType = false;
                $("#save_detail").click(function(){ 
					
					
                    $(document).find("#select_QuestionType").each(function(index, value){
								//alert($(this).val().trim());
                        if($(this).val().trim()){  //ถ้ามีค่าใน val คำถาม
								txt_check = false; 
								Checkarray_id2 = false; 
								var col_index =0;
								array_id2[row_index] = new Array();
                            /*if(array_id.length > 0) {
                                for (var i = 0; i <= array_id.length; i++) {
									 if (array_id[i] == $(this).closest("tr").find("#select_QuestionType").val().trim()) {
                                      txt_check = true;
									  alert('เก็บ1');  // ไม่เอาค่าที่ซ้ำ
                                    }
                                }
                            }*/
							if(!txt_check){
									array_id[row_index]= $(this).closest("tr").find("#select_QuestionType").val().trim();
									
									//alert(array_img[row_index]);
									$(document).find(".id_Question").each(function(index, value){
										//alert($(this).prop("checked"));
										if($(this).prop("checked"))
										{ 
											array_id2[row_index][col_index] = $(this).val().trim();
											//alert(array_id2[row_index][col_index]);
											Checkarray_id2 =true;
											col_index++;
										
										}
									});
									
									
										if(!Checkarray_id2)
										{
											array_id22[row_index]= $(this).closest("tr").find(".id_Question").val().trim();
										}
									
									
									array_id3[row_index]= $(this).closest("tr").find("#select_AnswerType").val().trim();	
									array_id4[row_index]= $(this).closest("tr").find("#txt_Answer").val().trim();
									array_detail[row_index]= $(this).closest("tr").find("#txt_Detail").val().trim();
									
									$(document).find(".view_img").each(function(index, value){
									if($(this).prop("checked"))
										{ 	var Valimg = $(this).closest("tr").find("#view_img").val().trim();
											var txt_img =Valimg; //+array_id[row_index];
											array_img[row_index]=txt_img;
											//alert(array_img[row_index]);
										}
									});
                                txt_check = false;
								row_index++;
							}
                        }
                    });
					//alert(array_id.length);
					if(array_id.length > 0){
						//alert('โชว์ page');
						$('.result_list').html("<img src='images/89.gif'>");
                        $.ajax({
                            url: 'report/load_data_Question.php',
                            type: 'POST',
                            data: {array_id: array_id,array_id2: array_id2,array_id3: array_id3,array_id4: array_id4
							,array_id22: array_id22,array_detail: array_detail,array_img: array_img},
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
									$(document).find(".this_item").each(function (){
                                    //$(this).parent().parent().closest("div").find(".this_item").each(function(){
                                        if($(this).find("input[type=checkbox]").prop("checked")){
                                            bool = false;
											//alert('111111');
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
                                    $(this).closest("tr").find(".this_item").each(function(){
                                        if($(this).find("input[type=checkbox]").prop("checked")){
											var del=$(this).find("input[type=checkbox]").val();
											//alert(array_id[del]);
											
											array_id[del]="";
                                            $(this).remove();
                                        }
                                    });

                                    $(document).find(".div_this_item .this_item").each(function(){
                                        alert($(this).find("tr").html().trim());
                                        array_id[count_index] = $(this).find("tr").html().trim();
										alert(array_id[count_index]);
                                        count_index++;
                                    });

                                    if($(this).closest("tr").find(".this_item").size() == 0){
                                        $(".btn_remove_this").attr("disabled", "disabled");
                                    }
                                });
                            }
							
                        });
						
						
                    }//if array_id.length 
					
                });//save_detail 
				$("#close_detail").click(function(){
                    $(".alert_box").css("display", "none");
				});
                
            }// data: {id_provider
        });//ajax
		
    }//detail_provider
	
	
    var count = 0;
    //var array_ids = [];
    $("#btSAVE").click(function(){
	
			var txt_planName = $('#txt_planName').prop('value');
			var txt_remark = $('#txt_remark').prop('value');
			var txt_COMPANY = $('#txt_COMPANY').prop('value');	
			var txt_day = $('#txt_day').prop('value');	
			var txt_day1 = $('#txt_day1').prop('value');	
			//var txtDC[] = $('.checkboxDC').prop('value');
			/*var txtDC =document.getElementById(".checkboxDC").checked != true;
			alert(txtDC);*/
        
		if(txt_planName =='')  {alert("โปรดใส่หัวข้อ !");}
			
		else {
			//alert(txt_day1);
			//alert(array_id2[0][0]);
            $.ajax({
                url: 'report/save_MasterSurvey.php',
                type: 'POST',
                data: {txt_planName,txt_remark,txt_COMPANY,array_id: array_id,array_id2: array_id2,array_id3: array_id3,array_id4: array_id4
							,array_id22: array_id22,array_detail: array_detail,array_img: array_img
							,txt_day: txt_day,txt_day1: txt_day1
							},
                success: function(data){
                    $(".box").html(data);//result_alert
                }
            });
        
		}//else
    });
	

	$('#DcAll').change(function()
	{		
				if (this.checked) 
				{ 	//alert('checked'); 
					$(".checkboxDC").attr("checked", "true");
				} 
				else 
				{ 	//alert('no');
					//$(".checkbox").attr("checked", "false");
					$(".checkboxDC").removeAttr("checked"); 
				}
				
	});
	$('#RoleAll').change(function()
	{		
				if (this.checked) 
				{ 	//alert('checked'); 
					$(".checkboxRole").attr("checked", "true");
				} 
				else 
				{ 	//alert('no');
					//$(".checkbox").attr("checked", "false");
					$(".checkboxRole").removeAttr("checked"); 
				}
				
	});
	

});
</script>


	
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>สร้าง From Survey</h3>
            
          <p>
		  <input type="button" value="ค้นหา From Survey" id="btn_add" onclick="window.location='?page=';"  class="inner_position_right">
		  </p>

            
    </div>
        
    <div class="sep"></div>
<div class="box" align="center" >

<table cellpadding="0" cellspacing="0"  border="0" align="center"  width="1124px">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>หัวข้อ   From Survey: </B></td><td>
<input type="text" id="txt_planName" name="txt_planName" ><B style="color:red;text-align:center;">*</B>
</td></tr> 

</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150" align="left"  valign= "top" ><B>คำถาม : </B></td>
<td align="left" >
	<button class="btn_remove_this" disabled>ลบ</button>
	<button class="add_this">เพิ่มคำถาม</button>
	<B style="color:red;text-align:center;">*หมายเหตุ : ถ้าประเภทการตอบแบบ dropbox : ให้ขั้นด้วย#</B>
	
	<div class="result_list"  style="overflow-y: auto;width: 90%; height: 400px; border-radius: 10px; padding: 2%; 
	text-align: left; position: relative; margin: 0 ; margin-top: 2%; background-color: rgba(81,80,40, 0.2)">
		
	<table style="width: 100%; border-collapse: collapse" border="1">
    <thead>
        <tr style="text-align: center; background-color: #201f10; color: white">
		<td  rowspan="2" style="width:30px">ลำดับ</td>
		<td style="width:100px">กลุ่มคำถาม</td>
		<td style="width:200px">คำถาม</td>
		<td style="width:150px">ประเภทการตอบ</td>
		<td style="width:150px">อธิบายคำตอบ</td>
        <td  rowspan="2">หมายเหตุ</td> 
        <td style="width:100px">รูปของคำถาม</td>    
        </tr>
    </thead>
	</table>
	</div>
	
	<div class="alert_box">
        <div class="result_alert">
            <div class="detail_content"></div>
        </div>
	</div>
		
</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ></td><td colspan="2"><input type="button" class="myButton_login" id="Pview" name="Pview" value="ดูรูปแบบ"> 

</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>วันที่แสดง</B></td><td><input type="text" id="txt_day" name="txt_day" required/>
&nbsp;<B>ถึง</B>&nbsp;<input type="text" id="txt_day1" name="txt_day1" required/>&nbsp;<B style="color:red;text-align:center;">*</B></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<!---
<tr><td ><B>DCที่ใช้</B></td><td>
	<input type="checkbox"  id="DcAll"  name="DcAll" value="DcAll" />All DC<br>
	<? 	$sqlOpen1="select  * from st_user_group_dc";
		$qryOpen1=sqlsrv_query($con,$sqlOpen1);
		$i=1;
		while($open2=sqlsrv_fetch_array($qryOpen1)){
	?>
	<input type="checkbox"  name="txtDC[]" id="txtDC[]"  value="<?=$open2['dc_groupid'];?>" class="checkboxDC"/><?=$open2['dc_groupname'];?><br>
	<? $i++;} ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B style="color:red;text-align:center;">*(เลือกได้มากกว่า1ประเภท)</B>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td ><B>ตำแหน่งที่ใช้</B></td><td>
	<input type="checkbox"  id="RoleAll"  name="RoleAll" value="RoleAll" />All ตำแหน่ง
	<? 
		$sqlOpen="select  RoleName_Linename,RoleID_Lineid from st_user_rolemaster_detail";
		$qryOpen=sqlsrv_query($con,$sqlOpen);
		$i=1;
		while($open1=sqlsrv_fetch_array($qryOpen)){
	?>
	<input type="checkbox" class="checkboxRole" name="txtType[]" value="<?=$open1['RoleID_Lineid'];?>" /><?=$open1['RoleName_Linename'];?>
	<? $i++;} ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B style="color:red;text-align:center;">*(เลือกได้มากกว่า1ประเภท)</B>
</td></tr>---------->
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

