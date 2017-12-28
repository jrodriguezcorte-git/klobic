function deleteByID(id){
    var path = window.location.pathname;
    path = path.match(/([^\/]*)\/*$/)[1];
    var url = "/admin/"+path+"/actions.php";
    
    $.ajax({
      type: "GET",
      url: url,
      dataType: 'json',
      data: {delete: id}
    })
    .done(function(response) {
        if(response){
          if(response.code == 200){
      	    $('#'+id).remove();
            
          } else {
      	    var errors = response.errors;
    	    
        	 // for(i in response.messages){
        	 //   $(".login-box .errors").append( "<div class\"alert alert-danger\" role=\"alert\">"+messages[i]+"</div>");
        	 // }
          }
        }
    });
} 