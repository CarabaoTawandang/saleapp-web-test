<?
session_start();
include("../includes/config.php"); //connect database db.carabao.com

//echo $id=$_POST['id_provider'];

?>
<script type="text/javascript">
$(function(){	
		$('#btn_scarch,#btn_close').button();
		
		
		$('#select_QuestionType').change(function(){
				$.ajax({
					url:'report/Show_Question.php',
					type:'POST',
					data:'value='+$('#select_QuestionType').prop('value'),
					//alert('Test');
					//data:{name:'1'}
					success:function(result){
						$('.Show_Question').html(result);
					}
				});
		});
		
		$("#btn_close").click(function(){
                    //hidden alert
                    $(".alert_box").css("display", "none");
        });
		
	});//function	
</script>




<div style="width: 100%; text-align: center;    margin-bottom: 2%" >
	<table style="width: 100%; border-collapse: collapse" border="1">
    <thead>
        <tr style="text-align: center; background-color: #201f10; color: white">
		<td style="width:100px">กลุ่มคำถาม</td>
		<td style="width:200px">คำถาม</td>
		<td style="width:150px">ประเภทการตอบ</td>
		<td style="width:150px">อธิบายคำตอบ</td>
        <td  rowspan="2">หมายเหตุ</td> </tr>
    </thead>
	
    <tbody>
		<tr height="150px" valign="button"  align="center">
		<td >
			<select  id="select_QuestionType" name="select_QuestionType"   style="width:170px;" >
			<option value="">-เลือกกลุ่มคำถาม-</option>
			<? $sqlOp="select prd_type_id,prd_type_nm from st_item_type ";
				
				$qryOp=sqlsrv_query($con,$sqlOp);
				while($deOp=sqlsrv_fetch_array($qryOp)){
				echo "<option value='".$deOp['prd_type_id']." '>";
				echo $deOp['prd_type_nm'];
				echo "</option>";
				}
			?>
			<option value="อื่นๆ">อื่นๆ</option>
			</select>
			
		</td>
		<td  class="Show_Question" align="left">
		<input type="text" style="width:200px;" >
		</td>
		<td>
			<select  id="select_AnswerType" name="select_AnswerType" style="width:170px;" >
			<option value="">-เลือกประเภทคำตอบ -</option>
			<option value="text">text</option>
			<option value="dropbox">dropbox</option>
			<option value="checkbox">checkbox</option>
			<option value="radio">radio</option>
			<option value="date">date</option>
			<option value="time">time</option>
			<option value="datetime">datetime</option>
			<option value="file">file</option>
			</select>
		</td>
		<td >
			<textarea style="width:200px;align:center" id="txt_Answer" name="txt_Answer"></textarea>
		</td>
		<td  align="center">
			<textarea style="width:300px;align:center" id="txt_Detail" name="txt_Detail"></textarea>
			<br><br><input type="checkbox" id="view_img"   name="view_img" class="view_img" value="แสดงรูป">แสดงรูปของคำถามด้วย
		</td>
		</tr>
		
    </tbody>
	</table>
	<div style="width: 100%; margin-top: 2%; text-align: center" >
		<button id="save_detail" class="myButton_login">add</button>
		<button id="close_detail" class="myButton_login">close</button>
		<div align="left"><B style="color:red;text-align:left;">*หมายเหตุ : ถ้าเลือกประเภทการตอบแบบ dropbox : ให้ขั้นด้วย#</B></div>
		<div class="result_list"  style="overflow-y: auto;width:20%; height: 70%; border-radius: 10px; padding: 2%; 
		text-align: left; position: relative; margin: 0 ; margin-top: 2%; background-color: rgba(81,80,40, 0.2)">
		ต.ย ประเภทการตอบ
		<br><br>text : <input type="text" style="width:100px;">
		<br><br>dropbox : <select style="width:100px;"><option>เลือก</option></select>
		<br><br>checkbox : <input type="checkbox" checked>
		<br><br>radio : <input type="radio" checked>
		<br><br>date :  <input type="text" style="width:100px;" value="<?=date('Y-m-d');?>">
		<br><br>time : <input type="text" style="width:100px;" value="<?=date('H:i');?>">
		<br><br>file : <input type="file" >
		</div>
</div>