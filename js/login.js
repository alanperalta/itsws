$(function(){
var user = $("input[name=user]");
var pass = $("input[name=password]");
            $('button[type="submit"]').click(function(e) {
                e.preventDefault();
                //little validation just to check username
                if (user.val() !== "" && pass.val() !== "") {
                    var parametros = {
                        'user':$("input[name=user]").val(),
                        'password':$("input[name=password]").val(),
                        'dbName':$("#dbName").val()
                    };
                    $.ajax({
                        data:  parametros,
                        url:   '../controller/login.php',
                        type:  'post',
                        dataType: 'json'
                    }).done( function (response) {
//                        alert(response.message +' '+response.error);
                            if(!response.error){
                                window.location.replace("menu.php");
                        }else{
                            //remove success mesage replaced with error message
                            $("#output").removeClass(' alert alert-success');
                            $("#output").addClass("alert alert-danger animated fadeInUp").html(response.message);
                        }
                        }
                    );
                    
                    //show avatar
                    $(".avatar").css({
                        "background-image": "url('http://api.randomuser.me/0.3.2/portraits/women/35.jpg')"
                    });
                } else {
                    $("#output").removeClass(' alert alert-success');
                    $("#output").addClass("alert alert-danger animated fadeInUp").html("Complete los campos");
                }
            });
});
