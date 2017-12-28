(function($){
    var words = ["Thanks!" , "All Good!" , "Right on!"];
    var feedback = $(".feedback-box");
    
    //Feedback Toggle
    $("#feedback").on("click" , function(){
        feedback.addClass("show");
    });
    
    //Close Trigger
    $(".close").on("click" , function(){
        feedback.removeClass("show");
        setTimeout(function(){ 
            feedback.removeClass("show-confirm").find("textarea").val('');
        }, 1000);
    });

    //Submit
    $("#submit").on("click" , function (){
        feedback.removeClass("error");
        feedback.find(".error").remove();
        
        if( !$("textarea").val() || $("textarea").val().length < 20) {
            feedback.addClass("error");
            $("<div class='error' style='margin:-10px 0 10px;'>Minimun of 20 characteres.</div>").insertBefore(".feedback-box .BannerItem__bannerBuyContainer");
        } else {
            feedback.addClass("show-confirm");
            var randomWord = words[Math.floor(Math.random() * words.length)];
            $(".feedback-box h1 strong").text(randomWord);
            
            setTimeout(function (){
                feedback.removeClass("show").find("textarea").val('').delay(1000);
            },2000);
            
            $.ajax({
                type: "POST",
                url: "/auth/feedback.php",
                data: {
                    feedback: feedback.find("textarea").val()
                }
            }).done(function (response) {
                setTimeout(function (){
                    feedback.removeClass("show-confirm");
                }, 2200);
            });
        }
    });
})(jQuery);