function FormPost(buttonsection,SPATH,url,formnameid) {
	console.log(formnameid);
 var buttonval=$(buttonsection).val();
        $(buttonsection).attr('value', 'Wait....').after('<img src="'+SPATH+'assets/img/loader.gif" class="loaderimg"/>');
        $(buttonsection).attr('disabled', 'disabled');
		
        $.ajax({
            type: "POST",
            url: url,
            data: $('#'+formnameid).serialize(),
            dataType: "json",
            cache: false,
            success: function(msg) {
			$('.loaderimg').remove();
                if (msg['status'] == 'OK' && formnameid=="member_logform") { 
                  window.location.href='postjob';
                }
                else if(msg['status'] == 'OK' && formnameid=="member_register"){ 
                  window.location.href='postjob/newuserLogin/'+msg['uid'];
				  
                }
				if(msg['status'] == 'OK' && formnameid=="register"){
					window.location.href = SPATH+'signup/register_success';
				}
				
                if (msg['status'] == 'OK') {
                    
                    if(formnameid=="changepass_frm"){ 
                        $("#change_pass").attr("checked", false);
                    }
				$('#'+formnameid).trigger('reset');
				clearErrors();
				 $('#'+formnameid).hide();
                                 $('.alert-success').html(msg['message']).show();
                                
                                
                                   if(msg['location']){
                                            window.location.replace( msg['location']);
                                    }
							
                  
                } else if (msg['status'] == 'FAIL') {
                    registerFormPostResponse(buttonsection,buttonval,formnameid,msg['errors']);
                }
            },
            error: function(msg) {
                $(buttonsection).attr('value', buttonval);
                $(buttonsection).removeAttr('disabled');
            }
        });
        
        return false;
    }
 
 function registerFormPostResponse(buttonsection,buttonval,formnameid,errors) {
        $(buttonsection).attr('value', buttonval);
        $(buttonsection).removeAttr('disabled');
    
        clearErrors();
		console.log(errors);
        if (errors.length > 0) {
            for (i = 0; i < errors.length; i++) {
                showError(formnameid,errors[i].id, errors[i].message);
            }
        }
		
		var error_ele = $('.rerror').not(':empty').offset();
		if(error_ele){
			$(window).scrollTop(error_ele.top - 150);
		}
    }
    
    
 
 function clearErrors() {
        $('.rerror').hide();
        
       
    }
    
    function showError(formnameid,field, message) {
        
        if ( field == 'zip' || field == 'state') {
            $('#'+formnameid+' #' + field).after('<span class="error-msg" id="errmsg_' + field + '">' + message + '</span>');
        } else {
            message = " <span class=\"error-msg\"> "+message+"</span>";
            $('#'+formnameid+' #'+field+'Error')
                .html(message)
                .show();
                if($("#"+formnameid+" input[name=recaptcha_response_field]").length){
					Recaptcha.reload();
				}
        }
    }