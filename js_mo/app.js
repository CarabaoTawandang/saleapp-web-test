$(function(){
    $("#select_provider").change(function(){
        $.ajax({
            url: 'detail_provider.php',
            type: 'POST',
            data: {id_provider: $(this).val().trim()},
            success: function(data){
                //show alert
                $(".alert_box").css("display", "block");
                $(".detail_content").html(data);

                //save
                $("#save").click(function(){
                    var array_id = [];
                    $(document).find(".checkbox").each(function(index, value){
                        if($(this).prop("checked")){
                            array_id[index] = $(this).closest("tr").find(".id_detail_provider").html().trim();
                        }
                    });

                    if(array_id.length > 0){
                        $.ajax({
                            url: 'load_data_detail_res.php',
                            type: 'POST',
                            data: {array_id: array_id},
                            success: function(data){
                                $(".result_list").html(data);

                                //hidden alert
                                $(".alert_box").css("display", "none");
                            }
                        })
                    }
                });

                //close
                $("#close").click(function(){
                    //hidden alert
                    $(".alert_box").css("display", "none");
                });
            }
        });
    });
});