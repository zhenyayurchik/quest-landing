$('#id-form').validate({
	submitHandler:function(form){
		$(form).ajaxSubmit({
			target:$('.answer'),
			resetForm:true,
		});
	}
})