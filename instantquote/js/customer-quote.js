$(function () {
	$("#srpcustomerRequestQuote").validate({
		rules :{
			business_personal: {
				required: true
			},
			first_name: {
				required: true
			},
			last_name: {
				required: true
			},
			contact_email: {
				required: true,
				email: true,
			},
			contact_number: {
				required: true
			},

		},
		messages :{
			business_personal: {
				required: "Please select an option"
			},
			first_name: {
				required: "Please enter first name"
			},
			last_name: {
				required: "Please enter last name"
			},
			contact_email: {
				required: "Please enter contact email",
				email: "Please enter a valid email",
			},
			contact_number: {
				required: "Please enter contact number"
			},
		},
		submitHandler: function(form, event){
			$("#js-customer-contact-submit").attr('disabled', true);
			$("#js-customer-contact-submit").html('Please wait..');
			var business_personal = $("#business-personal").val();
			var first_name = $("#first_name").val();
			var last_name = $("#last_name").val();
			var contact_email = $("#contact_email").val();
			var company_name = $("#company_name").val();
			var contact_number = $("#contact_number").val();

			$.ajax({
				url: base_url + "module/instantquote/customerQuote",
				type: "post",
                data: {
      				action : 'saveCustomerQuote',
      				ajax : true,
                	business_personal: business_personal,
                	first_name: first_name,
                	last_name: last_name,
                	contact_email: contact_email,
                	company_name: company_name,
                	contact_number: contact_number
                },
				success: function (result) {
					$("#js-customer-contact-submit").attr('disabled', false);
					$("#js-customer-contact-submit").html('Submit');
					const res = JSON.parse(result);
					if(res){
						$("#flash-message").css('display', 'block').addClass('alert alert-success').html(res.message);
						setTimeout(function () {
							$("#contact-modal").hide();
							$("#flash-message").css('display','none').html('');
							
						}, 1500);
						
					}
					else{
						$("#flash-message").css('display', 'block').addClass('alert alert-danger').html(res.message);
						setTimeout(function () {
							$("#flash-message").css('display','none').html('');
						}, 1500);
					}
				},
			});
		}
	});
});