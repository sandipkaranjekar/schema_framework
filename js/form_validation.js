$(document).ready(function(){
	 $.validator.addMethod(
	     "DateFormat",
	     function(value, element) {
	     return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
	     },
	      "Please enter a date in the format dd/mm/yyyy"//removed ;
	  );
	// category form validation
	$("#frm_add_category").validate({
		rules: {
			category_name: "required",
			category_order: {
				required: true,
				number: true
			}
		},
		messages: {
			category_name: "Please enter the category name.",
			category_order: {
				required: "Please enter the category order.",
				number: "Please enter the numbers only."
			}
		}
	});

	// Login form validation
	$("#frm_login").validate({
		rules: {
			username: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 5
			}
		},
		messages: {
			username: {
				required: "Please enter a username.",
				email: "Your username must be valid email address"
			},
			password: {
				required: "Please enter a password.",
				minlength: "Your password must be at least 5 characters."
			}
		}
	});

	// Password reset form validation
	$("#frm_reset").validate({
		rules: {
			old_password: {
				required: true,
				minlength: 5
			},
			new_password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#new_password"
			}
		},
		messages: {
			old_password: {
				required: "Please provide a old password.",
				minlength: "Your password must be at least 5 characters."
			},
			new_password: {
				required: "Please provide a new password.",
				minlength: "Your password must be at least 5 characters."
			},
			confirm_password: {
				required: "Please provide a confirm password.",
				minlength: "Your password must be at least 5 characters.",
				equalTo: "Please enter the same password as above."
			}
			
		}
	});

	// Forget password form validation
	$("#frm_forget").validate({
		rules:{
			forget_email: {
				required: true,
				email: true
			}
		},
		messages:{
			forget_email: {
				required: "Please enter email address.",
				email: "Please enter valid email address."
			}
		}
	});
	
	// Product form validation
	$("#frm_add_product").validate({
		rules: {
			product_code: "required",
			product_name: "required",
			packing: "required",
			product_photo: "required",
			category: "required"
		},
		messages: {
			product_code: "Please enter the product code.",
			product_name: "Please enter the product name.",
			packing: "Please enter packing details.",
			product_photo: "Please upload product photo.",
			category: "Please select the category."
		}
	});

	// Saving calculator validation
	$("#saving_calculator").validate({
		rules: {
			no_of_light: {
				required: true,
				number: true
       			},
			cost_per_unit: {
				required: true,
				number: true
       			}
		},
		messages: {
			no_of_light: {
				required: "Please enter the number of CFL/Incandescent in use.",
				number: "Please enter numbers only."
			},
			cost_per_unit: {
				required: "Please enter the cost per unit.",
				number: "Please enter numbers only."
			}
		}
	});

	// Order form validation
	$("#frm_order").validate({
		rules: {
			order_name: "required",
			order_email: {
				required: true,
				email: true
			},
			order_contact: {
				required: true,
				number: true
			},
			order_address: "required"
		},
		messages: {
			order_name: "Please enter the name.",
			order_email: {
				required: "Please enter the email.",
				email: "Please enter valid email."
			},
			order_contact: {
				required: "Please enter the contact number.",
				number: "Please enter only numbers."
			},
			order_address: "Please enter the address."
		}
	});

	// testimonial form validation
	$("#frm_testimonial").validate({
		rules: {
			test_name: "required",
			test_email: {
				required: true,
				email: true
			},
			test_contact: {
				required: true,
				number: true
			},
			test_msg: "required"
		},
		messages: {
			test_name: "Please enter the name.",
			test_email: {
				required: "Please enter the email.",
				email: "Please enter valid email."
			},
			test_contact: {
				required: "Please enter contact number.",
				number: "Please enter numbers only."
			},
			test_msg: "Please enter message."
		}
	});

	// User form validation
	$("#frm_add_user").validate({
		rules: {
			user_name: "required",
			username_email: {
				required: true,
				email: true
			},
			user_contact: {
				required: true,
				number: true
			},
			address: "required"
		},
		messages: {
			user_name: "Please enter the name.",
			username_email: {
				required: "Please enter the email.",
				email: "Please enter valid email."
			},
			user_contact: {
				required: "Please enter contact number.",
				number: "Please enter numbers only."
			},
			address: "Please enter address."
		}
	});
	
	// Contact us english form validation
	$("#frm_feedback").validate({
		rules: {
			feedback_name: "required",
			feedback_firm: "required",
			feedback_email: {
				required: true,
				email: true
			},
			feedback_mobile: {
				required: true,
				number: true
			},
			feedback_dob: {
				DateFormat : true
			}
		},
		messages: {
			feedback_name: "Please enter the name.",
			feedback_firm: "Please enter the firm name.",
			feedback_email: {
				required: "Please enter the email.",
				email: "Please enter valid email."
			},
			feedback_mobile: {
				required: "Please enter contact number.",
				number: "Please enter numbers only."
			}
		}
	});

		// Contact us english form validation
	$("#frm_feedback1").validate({
		rules: {
			name: "required",
			email: {
				required: true,
				email: true
			},
			contact: {
				required: true,
				number: true
			},
			message: "required",
					},
		messages: {
			name: "Please enter the name.",
			email: {
				required: "Please enter the email.",
				email: "Please enter valid email."
			},
			contact: {
				required: "Please enter contact number.",
				number: "Please enter numbers only."
			},
			message: "Please enter the message.",
		}
	});


	// Contact us hindi form validation
	$("#frm_hindi_feedback").validate({
		rules: {
			feedback_name: "required",
			feedback_firm: "required",
			feedback_email: {
				required: true,
				email: true
			},
			feedback_mobile: {
				required: true,
				number: true
			},
			feedback_dob: {
				DateFormat : true
			}
		},
		messages: {
			feedback_name: "Please enter the name.",
			feedback_firm: "Please enter the firm name.",
			feedback_email: {
				required: "Please enter the email.",
				email: "Please enter valid email."
			},
			feedback_mobile: {
				required: "Please enter contact number.",
				number: "Please enter numbers only."
			}
		}
	});
});


