var operaciones_ajax="operaciones.php";
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 
function MTD_VALIDAR_USUARIO()
{
    
    var usuario ="";
    var password="";    
    usuario     =$("#username").val();
    password    =$("#password").val();
    var mensaje_error="";
    if (usuario == "")
    {       
        mensaje_error="Atencion, el usuario debe ser una direccion de email";               
    }
    else if (password == "")
    {
        mensaje_error="Atencion, debe ingresar su password";
    }
    
        
    if (!mensaje_error =="")
    {
        
        alert ("Error:" + mensaje_error);
    }
    else 
    {   
        
        var parametros  = {operacion: "validar_usuario",usuario: usuario, password: password};  
        $.ajax({
            url: "operaciones.php",data: parametros,type: "POST",cache: false,async: true,
            success: function(data) 
            {
                if (data == "0")
                {
                
                    window.location = "index.php?id=registro";
                    //ENVIAR AL SITIO
                }
                else
                {
                    alert ("Atencion, usuario o password incorrectos");
                    
                }
                    
                            
            }
        });  
    }
    
  
}
function MTD_MOSTRAR_CAMBIAR_CONTRASENHA(vp_id_usuario)
{
    var codigo ="";
    var mensaje_error="";    
    var id_usuario="-1";
    if (vp_id_usuario != "")
    {
       id_usuario = vp_id_usuario; 
    }  
    
    // Load dialog on click 
    //$('#basic-modal-content').modal();
    var parametros  = {operacion: "mostrar_cambiar_contrasenha",id_usuario: id_usuario};   
    $.ajax({
        url: "operaciones.php",data: parametros,type: "POST",cache: false,async: true,
        success: function(data) 
        {
            $("#basic-modal-content").empty();
            $("#basic-modal-content").append(data);         
            $('#basic-modal-content').modal();      
            $('#simplemodal-container').css('height', 'auto');
            
         }
    });
}
function MTD_CAMBIAR_CONTRASENHA()
{
    var codigo ="";
    var mensaje_error="";    
    var password1="";
    var password2="";
    var id_usuario="";
    id_usuario=$("#id_usuario").val();
    password1=$("#password1").val();
    password2=$("#password2").val();
    if (password1 == password2)
    {
        //Load dialog on click  
        //$('#basic-modal-content').modal();
        var parametros  = {operacion: "cambiar_password", password: password2, id_usuario: id_usuario};
     
        // Load dialog on click 
        //$('#basic-modal-content').modal();
   
        $.ajax({
            url: "operaciones.php",data: parametros,type: "POST",cache: false,async: true,
            success: function(data) 
            {
                $("#contenedor_resultado").empty();
                $("#contenedor_resultado").append(data);                
             }
        });
    }
    else
    {
        alert("Atencion, el password ingresado no coincide")
    }
   
}
function MTD_EDITAR_PERFIL()
{
    var codigo ="";
    var mensaje_error="";    
    var id_usuario="";

    
    // Load dialog on click 
    //$('#basic-modal-content').modal();
    var parametros  = {operacion: "mostrar_editar_datos_personales",id_usuario : id_usuario};   
    $.ajax({
        url: "operaciones.php",data: parametros,type: "POST",cache: false,async: true,
        success: function(data) 
        {
            $("#basic-modal-content").empty();
            $("#basic-modal-content").append(data);
            $('#basic-modal-content').modal();      
            
         }
    });
   
    
}   
function MTD_ACTUALIZAR_DATOS_PERSONALES()
    {           
         
        var nombre   ="";
        var apellido ="";
        var registro_medico   ="";
        var cedula      ="";
        var direccion   ="";
        var telefono    ="";
        var telefono_celular   ="";
        var mensaje_error="";
        var tratamiento = "";
        var especialidad="";
        var id_usuario="";
        nombre          =$("#nombre").val();
        apellido        =$("#apellido").val();      
        cedula          =$("#cedula").val();
        telefono        =$("#telefono").val();
        telefono_celular=$("#telefono_celular").val();    
        direccion       =$("#direccion").val();             
        id_usuario      =$("#id_usuario").val();
        if (nombre == '')
        {
       
            mensaje_error= "Debe ingresar los campos obligatorios";
            $("#lb_nombre").css({'color' : '#FF0000'});
            $("#nombre").css({'background-color' : '#FFFFEE'});
        }    
        if (apellido== '')
        {
        
            mensaje_error= "Debe ingresar los campos obligatorios";
            $("#lb_apellido").css({'color' : '#FF0000'});
        }
       
        if (cedula == '')
        {
            mensaje_error= "Debe ingresar los campos obligatorios";
            
            $("#lb_cedula").css({'color' : '#FF0000'});
        }
        if (telefono_celular== '')
        {
            mensaje_error= "Debe ingresar los campos obligatorios";
            
            $("#lb_telefono_celular").css({'color' : '#FF0000'});
        }    
        if (mensaje_error == '')
        {    
            
            var parametros  = {operacion: "actualizar_datos_personales",
                    nombre: nombre, 
                    apellido: apellido,                 
                    cedula:cedula,
                    telefono: telefono,
                    telefono_celular: telefono_celular,
                    direccion: direccion,                       
                    id_usuario: id_usuario                                                
                    };
            
            
            $.ajax({
                url: "operaciones.php",data: parametros,type: "POST",cache: false,async: true,
                success: function(data) 
                {
                    $("#contenedor_resultado").empty();
                    $("#contenedor_resultado").append(data);        
                 }
            });      
        }
        else
        {    
        /*          
             $('#bubble_actualizar').SetBubblePopupOptions({themePath: path_template + 'images/jquerybubblepopup-theme/',themeName: 'azure',position : 'top',innerHtml: mensaje_error, mouseOver: 'hide'});      
             $('#bubble_actualizar').ShowBubblePopup();*/
             alert("Error : " + mensaje_error);
        }
    }