$(document).ready(function () {

    //----------------------------------------------------
    //                    AJAX TOKEN
    //----------------------------------------------------
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#form_init").submit(function (e) {
        e.preventDefault();
        let form = new FormData(this);

      

        $('#output').html("<div class=\"col-md-12\"><div class=\"alert alert-danger\"> <i class=\"fa fa-info-circle\"></i> Processing</div></div>");
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: form,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            
            success: function (data) {
                if(data.status == 0){
                    console.log(data.error);
                    printErrorMsg (data.error);
                }
                else{
                    $('#output').html("<div class=\"col-md-12\"><div class=\"alert alert-success\"> <i class=\"fa fa-info-circle\"></i> " + data.msg + "</div></div>");
                    window.setTimeout(function () {
                        $(".alert").fadeTo(500, 0).slideUp(500, function () {
                            $(this).remove();
                            window.location.href=data.url;
                        });
                    }, 1000);
                }
            },
            error: function (data) {
                // uncomment this line if want to debug in console
                // console.log(data.responseText);
            }
        })
    });



    //Show all error
    function printErrorMsg (msg) {
        $('#output').html("<div class=\"col-md-12\"><div class=\"alert alert-danger\"> <ul></ul></div></div>");
        $("#output").find("ul").html('');
        $("#output").css('display','block');
        $.each( msg, function( key, value ) {
            $("#output").find("ul").append('<li>'+value+'</li>');
        });
    }

 

});