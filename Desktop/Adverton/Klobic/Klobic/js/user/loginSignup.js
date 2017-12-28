$(document).ready(function(){
  // Click on Submit
  $(".login-box .form-submit").click(function(e) {
    e.preventDefault();
    $(".login-box #errors").empty().removeClass('alert alert-danger');
    $(".login-box .form-submit").prop('disabled', true);
    
    var url = DOMAIN_NAME;
    if($('input[name="forgot"]').val() === "")
      url += "auth/forgot.php";
    else
      url += "auth/signup.php";
    
    $.ajax({
      type: "POST",
      url: url,
      data: $("form").serialize()
    }).done(function(response) {
        if(response && response.errors){
      	  var errors = response.errors;
      	  
      	  if(url === DOMAIN_NAME+"auth/forgot.php" && response.messages.length > 1){
      	    $(".login-box #errors")
      	    .addClass('alert alert-success')
      	    .append("<span>"+response.messages[0]+"</span>");
      	    $('#login_input_email').remove();
      	    $('.form-submit').remove();
      	    return;
      	  }
      	  
      	  if(response.errors.length == 0){
            $(".login-box .form-submit").addClass('form-submit-animated');
						setTimeout(function(){
              window.location = "/"
						}, 3600);
						return;
      	  }
      	  
      	  for(i in response.errors){
      	    $(".login-box #errors")
      	    .addClass('alert alert-danger')
      	    .append("<span>"+errors[i]+"</span>");
      	  }
      	  
          $(".login-box .form-submit").prop('disabled', false);
        }
    	  
    	 // for(i in response.messages){
    	 //   $(".login-box .errors").append( "<div class\"alert alert-danger\" role=\"alert\">"+messages[i]+"</div>");
    	 // }
    });
  });
  
  // Click on reset
  $(".reset").click(function() {
    $('.form-submit').removeClass('form-submit-animated');
  });
});