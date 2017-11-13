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
                        url:   'controller/login.php',
                        type:  'post',
                        dataType: 'json'
                    }).done( function (response) {
//                        alert(response.message +' '+response.error);
                            if(!response.error){
                                $("#output").addClass("alert alert-success animated fadeInUp").html("Bienvenido/a " + "<span style='text-transform:uppercase'>" + user.val() + "</span>");
                                $("#output").removeClass(' alert-danger');
                                $("input, select").css({
                                    "height":"0",
                                    "padding":"0",
                                    "margin":"0",
                                    "opacity":"0"
                                });
                            //change button text 
                                $('button[type="submit"]').html("Ventas Pendientes")
                                .removeClass("btn-info")
                                .addClass("btn-default").click(function(){
                                    $("input, select").css({
                                        "height":"auto",
                                        "padding":"10px",
                                        "opacity":"1"
                                    }).val("");
                                    $('button[type="submit"]').html("Ingresar");
                                });
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
