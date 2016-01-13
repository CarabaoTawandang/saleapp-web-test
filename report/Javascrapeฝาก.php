
<script type="text/javascript">
$(function(){	
	$("#btn_add,#save,#btSAVE").button();
	
	$("#select_provider").change(function()
	{
			var select_provider = $('#select_provider').prop('value');
			//var txt_detail = $('#txt_detail').prop('value');
		$.ajax({
            url: 'report/detail_providerDC.php',
            type: 'POST',
            
			
			data: {select_provider},
			//data: {id_provider55: $(this).val().trim()},  //-----------ของโม
			
            success: function(data){
                //show alert
                $(".alert_box").css("display", "block");
                $(".detail_content").html(data);

                //save
                $("#save").click(function(){
					//$('#save_con').html("<img src='images/89.gif'>");
                    var array_id = [];
                    $(document).find(".checkbox").each(function(index, value){
                        if($(this).prop("checked")){
                            array_id[index] = $(this).closest("tr").find(".id_detail_providerDC").html().trim();
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
                                    $(this).closest("div").find(".this_item").each(function(){
                                        if($(this).find("input[type=checkbox]").prop("checked")){
											var a=$(this).find("input[type=checkbox]").prop("value");
											$(this).remove();
											
                                        }
                                    });

                                    if($(this).closest("div").find(".this_item").each().size() == 0){
                                        $(".btn_remove_this").attr("disabled", "disabled");
                                    }
                                });



                            }
                        });
                    }
                });

                //close
                $("#close").click(function(){
                    //hidden alert
                    $(".alert_box").css("display", "none");
                });
            }
        });
		$(".show").show();
		
    });// คลิก DC
	
	$("#AddCust").click(function(){
		var select_provider = $('#select_provider').prop('value');
			//var txt_detail = $('#txt_detail').prop('value');
		$.ajax({
            url: 'report/detail_providerDC.php',
            type: 'POST',
            
			
			data: {select_provider},
			//data: {id_provider55: $(this).val().trim()},  //-----------ของโม
			
            success: function(data){
                //show alert
                $(".alert_box").css("display", "block");
                $(".detail_content").html(data);

                //save
                $("#save").click(function(){
					//$('#save_con').html("<img src='images/89.gif'>");
                    var array_id = [];
                    $(document).find(".checkbox").each(function(index, value){
                        if($(this).prop("checked")){
                            array_id[index] = $(this).closest("tr").find(".id_detail_providerDC").html().trim();
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
                                    $(this).closest("div").find(".this_item").each(function(){
                                        if($(this).find("input[type=checkbox]").prop("checked")){
											
											$(this).remove();
											
                                        }
                                    });

                                    if($(this).closest("div").find(".this_item").each().size() == 0){
                                        $(".btn_remove_this").attr("disabled", "disabled");
                                    }
                                });



                            }
                        });
                    }
                });

                //close
                $("#close").click(function(){
                    //hidden alert
                    $(".alert_box").css("display", "none");
                });
            }
        });
		$(".show").show();
    });//---------------------คลิกเพิ่มร้าน
	
	/*$('#btSAVE').click(function(){
			var select_provider = $('#select_provider').prop('value');	
			var txt_planName = $('#txt_planName').prop('value');
			var txt_remark = $('#txt_remark').prop('value');
			var txt_COMPANY = $('#txt_COMPANY').prop('value');
			if(txt_planName =='')  {alert("โปรดใส่หัวข้อแผนการวิ่ง !");}
			else if(select_provider=='')  {alert("โปรดใส่DC และร้านค้า !");}
			else {
			$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/save_MasterPlan.php',
						type:'POST',
						data: {select_provider,txt_planName,txt_remark,txt_COMPANY},
						success:function(result){
							$('#txt_search').html(result);
							}
							});
			}
							
							
	});*/
	//---------------คลิกบันทึก
	
	
	var array_id = [];
    var count = 0
    $("#btSAVE").click(function(){
			var select_provider = $('#select_provider').prop('value');	
			var txt_planName = $('#txt_planName').prop('value');
			var txt_remark = $('#txt_remark').prop('value');
			var txt_COMPANY = $('#txt_COMPANY').prop('value');
			
			
        $(document).find(".box .this_item input[type=checkbox]").each(function(){
            count++;
            array_id[count] = $(this).attr("value");
        });
        count = 0;
        if(array_id.length > 0){
			$('.box').html("<img src='images/89.gif'>");
            $.ajax({
				url:'report/save_MasterPlan.php',
                type: 'POST',
                data: {array_id: array_id,select_provider,txt_planName,txt_remark,txt_COMPANY},
                success: function(data){
                    $(".box").html(data);
                }
            });
        }else{
            alert("ไม่มีข้อมูล");
        }
    });
	
	$( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();	
});//function	
</script>
