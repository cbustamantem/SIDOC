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
function MTD_MOSTRAR_CAMBIAR_CONTRASENHA()
{
    var codigo ="";
    var mensaje_error="";    
    
    
    // Load dialog on click 
    //$('#basic-modal-content').modal();
    var parametros  = {operacion: "mostrar_cambiar_contrasenha"};   
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
    password1=$("#password1").val();
    password2=$("#password2").val();
    if (password1 == password2)
    {
        //Load dialog on click  
        //$('#basic-modal-content').modal();
        var parametros  = {operacion: "cambiar_password", password: password2};
     
        // Load dialog on click 
        //$('#basic-modal-content').modal();
   
        $.ajax({
            url: operaciones_ajax,data: parametros,type: "POST",cache: false,async: true,
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
