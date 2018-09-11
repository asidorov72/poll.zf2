$(document).ready(function () {

    $( "button.apply-btn" ).on( "click", function(event) {
    
        $form = $(this).parents("form");
        var url = $form.attr('action');
        var id = $form.find("[name='id']").val();
        var answer = $form.find('input[name="answer[]"]:checked').serialize();
   
        var request = $.ajax({
            url: url,
            type: 'post',
            data: {'id':id,'answer':answer},
            dataType: 'html',
            beforeSend: function(){
                var htmlContent = '<span class="text-info" style="padding-left:20px"> Please wait... </span>';
                $('.loader').html(htmlContent);
            }
        });
  
        request.done(function(msg) {

            var htmlContent = '<div style="display:block;padding:10px" class="small">';
            htmlContent += '<p>Thank you. The test was saved.</p>';
            htmlContent += '</div>';
            
            $('.loader').html('');
            $("#test-block-"+id).html(htmlContent);
        });

        request.fail(function(jqXHR, textStatus) {
          console.log( "Request failed: " + textStatus );
        });
        
        event.preventDefault();
    });
});