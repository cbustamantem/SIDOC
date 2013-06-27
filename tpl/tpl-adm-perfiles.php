
<h2>Perfiles de Usuarios</h2>
<div style='float:right;margin-top:-20px;'>
	<button  type="button" class="btn btn-info" id="btnAgregar"><i class="icon-edit icon-white"></i> Agregar Perfil</button>	
</div>
<span>Busqueda </span><br>
<form>
 {tpl-datos}
 </form>


 <script type="text/javascript">
	<!--
	var operaciones_ajax="operaciones.php";
	$(document).ready(function(){
		$('#example').dataTable( {
		"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap",
		
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
		}
		} );
		$("#buscar").click(function() {			
			
			$("#myform").submit();
			});
				       
        $("#btnAgregar").click(function() {
        	MTD_MOSTRAR_FORMULARIO_PERFILES();
			});	
	
	});					 
	function MTD_MOSTRAR_FORMULARIO_PERFILES()
	{
		var codigo ="";
	    var mensaje_error="";    

	    
	    // Load dialog on click	
	    //$('#basic-modal-content').modal();
		var parametros 	= {operacion: "mostrar_agregar_perfiles"};	
		$.ajax({
	        url: operaciones_ajax,data: parametros,type: "POST",cache: false,async: true,
	        success: function(data) 
	        {
	        	$("#basic-modal-content").empty();
	        	$("#basic-modal-content").append(data);
	        	$('#basic-modal-content').modal();    	
	        	
	         }
	    });
	   
	  	
	}	
	function MTD_EDITAR_PERFIL(id_perfil)
	{
		var codigo ="";
	    var mensaje_error="";    

	    
	    // Load dialog on click	
	    //$('#basic-modal-content').modal();
		var parametros 	= {operacion: "mostrar_editar_datos_personales",id_perfil : id_perfil};	
		$.ajax({
	        url: operaciones_ajax,data: parametros,type: "POST",cache: false,async: true,
	        success: function(data) 
	        {
	        	$("#basic-modal-content").empty();
	        	$("#basic-modal-content").append(data);
	        	$('#basic-modal-content').modal();    	
	        	
	         }
	    });
	   
	  	
	}	

	function MTD_AGREGAR_USUARIO()
	{   		
		 
	    var nombre   ="";
	    var apellido ="";
	    var registro_medico   ="";
	    var cedula    	="";
	    var direccion 	="";
	    var telefono 	="";
	    var telefono_celular   ="";
	    var email 		="";
	    var contrasenha ="";
	    var contrasenha2="";
	    var mensaje_error="";
	    var tratamiento = "";
	    var especialidad="";
	    nombre     		=$("#nombre").val();
	    apellido     	=$("#apellido").val();
	    registro_medico =$("#registro_medico").val();
	    cedula     		=$("#cedula").val();
	    telefono     	=$("#telefono").val();
	    telefono_celular=$("#telefono_celular").val();
	    email    		=$("#email").val();
	    direccion		=$("#direccion").val();    
	    contrasenha     =$("#contrasenha").val();
	    contrasenha2    =$("#contrasenha2").val();	    
	    especialidad	=$("#especialidad :selected").val();	
	    
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
	    if (email == '')
	    {
	    	mensaje_error= "Debe ingresar los campos obligatorios";
	    
	     	$("#lb_email").css({'color' : '#FF0000'});
	    }
	    if (telefono_celular== '')
	    {
	    	mensaje_error= "Debe ingresar los campos obligatorios";
	    	
	    	$("#lb_telefono_celular").css({'color' : '#FF0000'});
	    }
	    if (contrasenha== '')
	    {
	    	mensaje_error= "Debe ingresar los campos obligatorios";
	    	
	    	$("#lb_contrasenha").css({'color' : '#FF0000'});
	    }
	    else if (contrasenha != contrasenha2)
	    {
	    	mensaje_error= mensaje_error+ "Las contrasenha ingresada no coinciden <br> ";
	    }
	    
	    if (mensaje_error == '')
	    {    
		    var parametros 	= {operacion: "agregar_perfil",
		    		nombre: nombre, 
		    		apellido: apellido,
		    		registro_medico:registro_medico,
		    		cedula:cedula,
		    		telefono: telefono,
		    		telefono_celular: telefono_celular,
		    		direccion: direccion,	    		
		    		email: email,
		    		registro_medico: registro_medico,
		    		password: contrasenha,
		    		tratamiento: tratamiento,
		    		especialidad: especialidad
		    		};	
		    $.ajax({
	            url: operaciones_ajax,data: parametros,type: "POST",cache: false,async: true,
	            success: function(data) 
	            {
	                    if (data == "0")
	                    {
	                    	location.href="index.php?id=registro&nuevo=true";
	                        //ENVIAR AL FORMULARIO DE LOGIN
	                    }
	                    else 
	                    {
	                    	/*
	                    	$('#bubble_registrar').SetBubblePopupOptions({
	        	    	        themePath: path_template + 'images/jquerybubblepopup-theme/',
	        	    	        themeName: 'orange',
	        	    	        position: 'top',
	        	    	        innerHtml: 'Error en la operacion:.'+ data, mouseOver: 'hide'
		        		 	 });   	 
		        	    	 $('#bubble_registrar').ShowBubblePopup();*/
		        	    	 alert('Error en la operacion:.'+ data);
	                    }
	             }
	        });	     
	    }
	    else
	    {    	    	
	    	alert('Error en la operacion:.'+ mensaje_error);
	    /*	 $('#bubble_registrar').SetBubblePopupOptions({themePath: path_template + 'images/jquerybubblepopup-theme/',themeName: 'azure',position : 'top',innerHtml: mensaje_error, mouseOver: 'hide'});   	 
	    	 $('#bubble_registrar').ShowBubblePopup();*/
	    }
	}

		
	function MTD_ELIMINAR_PERFIL(id_perfil)
	{
		var answer = confirm("Esta seguro de eliminar el perfil?")
		if (answer){
			var parametros 	= {operacion: "eliminar_perfil",id_perfil: id_perfil};	
			$.ajax({
		        url: operaciones_ajax,data: parametros,type: "POST",cache: false,async: true,
		        success: function(data) 
		        {
		        	$("#contenedor_resultado").empty();
		       	 	$("#contenedor_resultado").append(data);	  
		         }
		    });	 
		}
		else{
		        //some code
		}
	  
	}
//-->
</script>
