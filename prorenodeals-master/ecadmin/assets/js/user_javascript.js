//.................................. User Jquery ...................................................//
//.................................. developed by Somnath mukherjee and his Team ...................//
var VPATH = "http://" + window.location.hostname + "/mrtheoyellowpage/admin/";

$(document).ready(function() {
    //function get_banner_position()
    $("#banner_type").change(function() {
        var ban_val = $("#banner_type").val();
        var url = VPATH + "banner/get_banner_type_position/" + ban_val;
        //window.location = url;
        $.ajax({
            type: "POST",
            url: url,
            beforeSend: function() {
                $("#banner_type_loader").show();
            },
            success: function(dd) {
                $("#banner_type_loader").hide();
                $("#banner_type_position").html(dd);
            }
        });
    });
	
	
});

function getCatList(id)
{
	if(id!=''){
	var url = VPATH + "listing/get_category/" + id;
        //window.location = url;
        $.ajax({
            type: "POST",
            url: url,
            beforeSend: function() {
                //$("#banner_type_loader").show();
            },
            success: function(dd) {
                //$("#banner_type_loader").hide();
                $("#cat_list").html(dd);
            }


        });
		}
}

function updateMemberPlan(field_value,field_name)
{
	var member_type = $("#member_type").val();
	var member_plan_id = $("#plan_id").val();
	
	var url = VPATH + "memberplan/edit_plan/"+member_type+"/"+member_plan_id+"/"+field_name+"/"+field_value;
	window.location = url;
	

}

function get_state(country_id)
{
   if(country_id!=''){
	var url = VPATH + "listing/getState/" + country_id;
    //window.location = url;
    //alert(url);
    $.ajax({
        type: "POST",
        url: url,
        beforeSend: function() {
            $("#get_state_loader").show();
        },
        success: function(dd) {
            $("#get_state_loader").hide();
            $("#state_list").html(dd);
        }


    });
	}



}

function get_city(state_id)
{
  if(state_id!=''){
  $("#city_id").val(state_id);
   var url = VPATH + "listing/getCity/" + state_id;
	
   // window.location = url;

    $.ajax({
        type: "POST",
        url: url,
        beforeSend: function() {

            $("#get_city_loader").show();
        },
        success: function(dd) {

            $("#get_city_loader").hide();
            $("#city_list").html(dd);
        }


    });
	}

}

function get_sub_cat_with_keywords_edit(c_id)
{
	if(c_id!=''){
    var url = VPATH + "listing/getSubCategory_edit/" + c_id;
    $.ajax({
        type: "POST",
        url: url,
        beforeSend: function() {

            $("#feedloader").show();
        },
        success: function(dd) {

            $("#feedloader").hide();
            $("#get_sub_cat").html(dd);
        }


    });
	}

}

function get_n_cat_with_keywords_edit(c_id, p_id)
{
	if(c_id!=''){		
    var url = VPATH + "listing/getNCategory_edit/" + c_id;
	
    $.ajax({
        type: "POST",
        url: url,
        beforeSend: function() {

            $("#feedloader_"+p_id).show();
        },
        success: function(dd) {

           $("#feedloader_"+p_id).hide();
            $("#div_" + p_id).html(dd);
        }


    });
	}

}






