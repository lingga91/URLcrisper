$(function() {
      $("#crisp").click( function()
           {
            
                 var url = $("#url").val();
                 if (!url.trim()) {
                    $.confirm({
                        title: 'Empty Field!',
                        content: 'Please enter a URL',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                           close: function () {
                            }
                        }
                    });
                    return;
                }
                 crispt_it(url);
           }
      );
            
      function crispt_it(url){
        
        $.ajax({   
            url: "index.php",  
            type:'POST',
            dataType: "json",
            data: {url:url},
            success: function(result){
                //console.log(result);
                if(result.status.trim() == 'invalid'){ 
                   $.confirm({
                        title: 'Invalid URL!',
                        content: 'Please enter a valid URL',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            tryAgain: {
                                text: 'Try again',
                                btnClass: 'btn-red',
                                action: function(){
                                }
                            }
                        }
                    });
                }
                else if(result.status.trim() == 'success'){
                    
                    $.confirm({
                        title: 'Your new crispy URL',
                        content: "<a href='"+result.url+"' target='_blank'>"+result.url+"</a>", 
                        type: 'green',
                        typeAnimated: true,
                        buttons: {
                            close: function () {  
                            }
                        }
                    });
                }
                else{
                    $.confirm({
                        title: 'Encountered an error!',
                        content: 'Something went wrong, Please contact your administrator',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            close: function () {
                            }
                        }
                    });
                }
            }
        });
               
      }
});

