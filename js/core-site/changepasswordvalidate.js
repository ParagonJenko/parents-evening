$(document).ready(function(){
	$("#changepasswordform").validate( {
		rules: {
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
			error.addClass( "form-text" );

			// Add `has-feedback` class to the parent div.form-group
			// in order to add icons to inputs
			

			if ( element.prop( "type" ) === "checkbox" ) {
				error.insertAfter( element.parent( "label" ) );
			} else {
				error.insertAfter( element );
			}
		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-10" ).addClass( "has-danger" ).removeClass( "has-success" );
			$( element ).addClass( "form-control-danger" ).removeClass( "form-control-success" );
		},
		unhighlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-10" ).addClass( "has-success" ).removeClass( "has-danger" );
			$( element ).addClass( "form-control-danger" ).removeClass( "form-control-success" );
		}
	} );
} );