$(document).ready(function(){
	 $("#submitsignup").click(function () {
		$("#signupform").submit();
	  });
	$("#signupform").validate( {
		rules: {
			fullname: {
				required: true,
				minlength: 2
			},
			username: {
				required: true,
				minlength: 5
			},
			dateofbirth: {
				required: true,
				date: true,
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 5
			},
			confirmpassword: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
		},
		messages: {
			fullname: {
				required: "Please enter your full name.",
				minlength: "This seems a little short."
			},
			username: {
				required: "Please enter a username.",
				minlength: "This seems a little short for us."
			},
			dateofbirth: {
				required: "Please enter your date of birth."	
			},
			email: {
				required: "Please enter your contact email address.",
				email: "Please enter a correct email. 'example@example.com'"
			},
			password: {
				required: "Please provide a password.",
				minlength: "Your password must be at least 5 characters long."
			},
			confirmpassword: {
				required: "Please provide a password.",
				minlength: "Your password must be at least 5 characters long.",
				equalTo: "Please enter the same password."
			},
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );

			// Add `has-feedback` class to the parent div.form-group
			// in order to add icons to inputs
			element.parents( ".col-5" ).addClass( "has-feedback" );

			if ( element.prop( "type" ) === "checkbox" ) {
				error.insertAfter( element.parent( "label" ) );
			} else {
				error.insertAfter( element );
			}
		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-8" ).addClass( "has-danger" ).removeClass( "has-success" );
			$( element ).addClass( "form-control-danger" ).removeClass( "form-control-success" );
		},
		unhighlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-8" ).addClass( "has-success" ).removeClass( "has-danger" );
			$( element ).addClass( "form-control-danger" ).removeClass( "form-control-success" );
		}
	} );
} );