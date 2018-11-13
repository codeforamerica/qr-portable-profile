$.fn.fill_highlight = function() {
    this.css("transform", "scale(1.15)").delay(250).queue(function (next) { $(this).css('transform', 'scale(1)'); next(); });
};

chrome.runtime.onMessage.addListener(function(data_from_extension, sender, sendResponse) {
	var user_info = data_from_extension;
	
	
	$("form *").css("transition", "all 250ms");
	
	// parse some info
	var user_info_birth_date = user_info["birth_date"].split("-");
	var user_info_name = user_info["name"].split(" ");
	
	// CalJOBS
	$("form [name='ctl00$Main_content$ucLogin$txtUsername']").val(user_info["name"].replace(" ", "").toLowerCase()).fill_highlight();
	$("form [name='ctl00$Main_content$txtZip']").val(user_info["address_zip"]).fill_highlight();
	$("form [name='ctl00$Main_content$ucEmailTextBox$txtEmail']").val(user_info["email_address"]).fill_highlight();
	$("form [name='ctl00$Main_content$ucEmailTextBox$txtEmailConfirm']").val(user_info["email_address"]).fill_highlight();
	$("form [name='ctl00$Main_content$ucRegDemographics$txtDOB']").val(user_info_birth_date[1]+"/"+user_info_birth_date[2]+"/"+user_info_birth_date[0]).fill_highlight();
	
	// California EDD
	$("form [name='Email']").val(user_info["email_address"]).fill_highlight();
	$("form [name='ConfirmedEmail']").val(user_info["email_address"]).fill_highlight();
	
	// MyBenefits CalWIN
	$("form [name='firstName']").val(user_info_name[0]).fill_highlight();
	$("form [name='lastName']").val(user_info_name[1]).fill_highlight();
	$("form [name='email']").val(user_info["email_address"]).fill_highlight();
	$("form [name='email2']").val(user_info["email_address"]).fill_highlight();
	
	// Unemployment Insurance registration

	$("form [name='ctl00$contentMain$ucClaimantAccountRegistrationTemplate$frmClaimantAccountRegistration$prtFirstName$ctl00$txtValue']").val(user_info_name[0]).fill_highlight();
	$("form [name='ctl00$contentMain$ucClaimantAccountRegistrationTemplate$frmClaimantAccountRegistration$prtLastName$ctl00$txtValue']").val(user_info_name[1]).fill_highlight();
	$("form [name='ctl00$contentMain$ucClaimantAccountRegistrationTemplate$frmClaimantAccountRegistration$prtDateOfBirth$ctl00$txtDate']").val(user_info_birth_date[1]+"/"+user_info_birth_date[2]+"/"+user_info_birth_date[0]).fill_highlight();
	
	
	$.each(user_info, function(key, value) {
		$("form [name='"+key+"']").val(value).fill_highlight();
	});
});