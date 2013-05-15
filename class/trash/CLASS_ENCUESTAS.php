<?
class CLASS_ENCUESTAS
{
    private $vlc_conexion;
    private $vlc_codigo_html;
    //---------------------------
	//- CONSTRUCTOR DE LA CLASE -
	//---------------------------
    function __construct ($vp_bd)
    {
        //----------------------------------------
	    //- Inicializa las variables de la clase -
    	//----------------------------------------
        $this->vlc_conexion = $vp_bd;
        $this->vlc_codigo_html="<h3> HTML NO ASIGNADO </H3>";
        
        //-------------------------------
	    //- Verifica que accion realiza -
    	//-------------------------------
        if (isset($_POST['MTD_REGISTRA_ENCUESTA']))
        {
            $this->MTD_REGISTRA_ENCUESTA();
            $this->MTD_MUESTRA_ENCUESTA('');
        }
        else
        {
            $this->MTD_MUESTRA_ENCUESTA('');
        }       
    }
    /*
    +++++++++++++++++++++++++++++++++++++++++++++++
	- MTD_MUESTRA_ENCUESTA -
	Carga el template de la encuesta
    retorna los valores a visualizar
    +++++++++++++++++++++++++++++++++++++++++++++++
	*/
    function MTD_MUESTRA_ENCUESTA ($vp_resultado)
    {  
            
        $vlf_tpl = "tpl_frm_encuesta.html";
        $this->vlc_codigo_html= $this->MTD_OBTENER_TPL($vlf_tpl);        
    }
    /*
    +++++++++++++++++++++++++++++++++++++++++++++++
	- MTD_REGISTRA_ENCUESTA -
	registra los datos de la encuesta en la base
    dispone un mensaje de registro almacenado
    +++++++++++++++++++++++++++++++++++++++++++++++
	*/
    function MTD_REGISTRA_ENCUESTA ()
    {
       //TODO: Registrar encuesta
       //----------------------------
	   //- Inicializa las variables -
       //----------------------------
       $vlf_rb_evaluacion_1="";
       $vlf_rb_importancia_1="";
       $vlf_tb_observaciones_1="";
       
       $vlf_rb_evaluacion_2="";
       $vlf_rb_importancia_2="";
       $vlf_tb_observaciones_2="";
       
       $vlf_rb_evaluacion_3="";
       $vlf_rb_importancia_3="";
       $vlf_tb_observaciones_3="";
       
       $vlf_rb_evaluacion_4="";
       $vlf_rb_importancia_4="";
       $vlf_tb_observaciones_4="";
       
       $vlf_rb_evaluacion_5="";
       $vlf_rb_importancia_5="";
       $vlf_tb_observaciones_5="";
       
       $vlf_rb_evaluacion_6="";
       $vlf_rb_importancia_6="";
       $vlf_tb_observaciones_6="";
       
       $vlf_rb_evaluacion_7="";
       $vlf_rb_importancia_7="";
       $vlf_tb_observaciones_7="";
       
       $vlf_rb_evaluacion_8="";
       $vlf_rb_importancia_8="";
       $vlf_tb_observaciones_8="";
       
       $vlf_rb_evaluacion_9="";
       $vlf_rb_importancia_9="";
       $vlf_tb_observaciones_9="";
       
       $vlf_rb_evaluacion_10="";
       $vlf_rb_importancia_10="";
       $vlf_tb_observaciones_10="";
       
       $vlf_rb_evaluacion_11="";
       $vlf_rb_importancia_11="";
       $vlf_tb_observaciones_11="";
       
       $vlf_rb_evaluacion_12="";
       $vlf_rb_importancia_12="";
       $vlf_tb_observaciones_12="";
       
       $vlf_rb_evaluacion_12="";
       $vlf_rb_importancia_12="";
       $vlf_tb_observaciones_12="";
       
       $vlf_rb_evaluacion_13="";
       $vlf_rb_importancia_13="";
       $vlf_tb_observaciones_13="";
       
       $vlf_rb_evaluacion_14="";
       $vlf_rb_importancia_14="";
       $vlf_tb_observaciones_14="";
       
       $vlf_rb_evaluacion_15="";
       $vlf_rb_importancia_15="";
       $vlf_tb_observaciones_15="";
       
       $vlf_rb_evaluacion_16="";
       $vlf_rb_importancia_16="";
       $vlf_tb_observaciones_16="";
       
       $vlf_rb_evaluacion_17="";
       $vlf_rb_importancia_17="";
       $vlf_tb_observaciones_17="";

       $vlf_tb_observaciones_18="";
       //$vlf_tb_observacidescribe respuesta_encuestasones_19="";
       
       $vlf_nombre_empresa="";
       $vlf_nombre_funcionario="";
       $vlf_nombre_sector="";
       $resultado=false;
       //TODO: ASIGNAR EL NUMERO DE CLIENTES
       $vlf_id_cliente="50";
       //----------------------------
	   //- Asigna las variables -
       //----------------------------
       if (isset($_REQUEST['tb_nombre_empresa']))
       {
           $vlf_nombre_empresa= $_REQUEST['tb_nombre_empresa'];
       }
       
       if (isset($_REQUEST['tb_nombre_funcionario']))
       {
           $vlf_nombre_funcionario= $_REQUEST['tb_nombre_funcionario'];
       }
      
       if (isset($_REQUEST['tb_nombre_sector']))
       {
           $vlf_nombre_sector= $_REQUEST['tb_nombre_sector'];
       }
       if (isset($_REQUEST['rb_evaluacion_1']))
       {
           $vlf_rb_evaluacion_1 = $_REQUEST['rb_evaluacion_1'];           
       }
       if (isset($_REQUEST['rb_importancia_1']))
       {
           $vlf_rb_importancia_1 = $_REQUEST['rb_importancia_1'];           
       }
       if (isset($_REQUEST['tb_observaciones_1']))
       {
           $vlf_tb_observaciones_1 = $_REQUEST['tb_observaciones_1'];                    
       }
       
       if (isset($_REQUEST['rb_evaluacion_2']))
       {
           $vlf_rb_evaluacion_2 = $_REQUEST['rb_evaluacion_2'];           
       }
       if (isset($_REQUEST['rb_importancia_2']))
       {
           $vlf_rb_importancia_2 = $_REQUEST['rb_importancia_2'];           
       }
       if (isset($_REQUEST['tb_observaciones_2']))
       {
           $vlf_tb_observaciones_2 = $_REQUEST['tb_observaciones_2'];           
       }       
       if (isset($_REQUEST['rb_evaluacion_3']))
       {
           $vlf_rb_evaluacion_3 = $_REQUEST['rb_evaluacion_3'];           
       }
       if (isset($_REQUEST['rb_importancia_3']))
       {
           $vlf_rb_importancia_3 = $_REQUEST['rb_importancia_3'];           
       }
       if (isset($_REQUEST['tb_observaciones_3']))
       {
           $vlf_tb_observaciones_3 = $_REQUEST['tb_observaciones_3'];           
       }
       
       if (isset($_REQUEST['rb_evaluacion_4']))
       {
           $vlf_rb_evaluacion_4 = $_REQUEST['rb_evaluacion_4'];           
       }
       if (isset($_REQUEST['rb_importancia_4']))
       {
           $vlf_rb_importancia_4 = $_REQUEST['rb_importancia_4'];           
       }
       if (isset($_REQUEST['tb_observaciones_4']))
       {
           $vlf_tb_observaciones_4 = $_REQUEST['tb_observaciones_4'];           
       }
       
       if (isset($_REQUEST['rb_evaluacion_5']))
       {
           $vlf_rb_evaluacion_5 = $_REQUEST['rb_evaluacion_5'];           
       }
       if (isset($_REQUEST['rb_importancia_5']))
       {
           $vlf_rb_importancia_5 = $_REQUEST['rb_importancia_5'];           
       }
       if (isset($_REQUEST['tb_observaciones_5']))
       {
           $vlf_tb_observaciones_5 = $_REQUEST['tb_observaciones_5'];           
       }
       
       if (isset($_REQUEST['rb_evaluacion_6']))
       {
           $vlf_rb_evaluacion_6 = $_REQUEST['rb_evaluacion_6'];           
       }
       if (isset($_REQUEST['rb_importancia_6']))
       {
           $vlf_rb_importancia_6 = $_REQUEST['rb_importancia_6'];           
       }
       if (isset($_REQUEST['tb_observaciones_6']))
       {
           $vlf_tb_observaciones_6 = $_REQUEST['tb_observaciones_6'];           
       }
       
       if (isset($_REQUEST['rb_evaluacion_7']))
       {
           $vlf_rb_evaluacion_7 = $_REQUEST['rb_evaluacion_7'];           
       }
       if (isset($_REQUEST['rb_importancia_7']))
       {
           $vlf_rb_importancia_7 = $_REQUEST['rb_importancia_7'];           
       }
       if (isset($_REQUEST['tb_observaciones_7']))
       {
           $vlf_tb_observaciones_7 = $_REQUEST['tb_observaciones_7'];           
       }
       
       if (isset($_REQUEST['rb_evaluacion_8']))
       {
           $vlf_rb_evaluacion_8 = $_REQUEST['rb_evaluacion_8'];           
       }
       if (isset($_REQUEST['rb_importancia_8']))
       {
           $vlf_rb_importancia_8 = $_REQUEST['rb_importancia_8'];           
       }
       if (isset($_REQUEST['tb_observaciones_8']))
       {
           $vlf_tb_observaciones_8 = $_REQUEST['tb_observaciones_8'];           
       }
       
       if (isset($_REQUEST['rb_evaluacion_9']))
       {
           $vlf_rb_evaluacion_9 = $_REQUEST['rb_evaluacion_9'];           
       }
       if (isset($_REQUEST['rb_importancia_9']))
       {
           $vlf_rb_importancia_9 = $_REQUEST['rb_importancia_9'];           
       }
       if (isset($_REQUEST['tb_observaciones_9']))
       {
           $vlf_tb_observaciones_9 = $_REQUEST['tb_observaciones_9'];           
       }
       
      if (isset($_REQUEST['rb_evaluacion_10']))
       {
           $vlf_rb_evaluacion_10 = $_REQUEST['rb_evaluacion_10'];           
       }
       if (isset($_REQUEST['rb_importancia_10']))
       {
           $vlf_rb_importancia_10 = $_REQUEST['rb_importancia_10'];           
       }
       if (isset($_REQUEST['tb_observaciones_10']))
       {
           $vlf_tb_observaciones_10 = $_REQUEST['tb_observaciones_10'];           
       }
       
      if (isset($_REQUEST['rb_evaluacion_11']))
       {
           $vlf_rb_evaluacion_11 = $_REQUEST['rb_evaluacion_11'];           
       }
       if (isset($_REQUEST['rb_importancia_11']))
       {
           $vlf_rb_importancia_11 = $_REQUEST['rb_importancia_11'];           
       }
       if (isset($_REQUEST['tb_observaciones_11']))
       {
           $vlf_tb_observaciones_11 = $_REQUEST['tb_observaciones_11'];           
       }
       
      if (isset($_REQUEST['rb_evaluacion_12']))
       {
           $vlf_rb_evaluacion_12 = $_REQUEST['rb_evaluacion_12'];           
       }
       if (isset($_REQUEST['rb_importancia_12']))
       {
           $vlf_rb_importancia_12 = $_REQUEST['rb_importancia_12'];           
       }
       if (isset($_REQUEST['tb_observaciones_12']))
       {
           $vlf_tb_observaciones_12 = $_REQUEST['tb_observaciones_12'];           
       }
       
      if (isset($_REQUEST['rb_evaluacion_13']))
       {
           $vlf_rb_evaluacion_13 = $_REQUEST['rb_evaluacion_13'];           
       }
       if (isset($_REQUEST['rb_importancia_13']))
       {
           $vlf_rb_importancia_13 = $_REQUEST['rb_importancia_13'];           
       }
       if (isset($_REQUEST['tb_observaciones_13']))
       {
           $vlf_tb_observaciones_13 = $_REQUEST['tb_observaciones_13'];           
       }
       
      if (isset($_REQUEST['rb_evaluacion_14']))
       {                      
           $vlf_rb_evaluacion_14 = $_REQUEST['rb_evaluacion_14'];           
       }
       if (isset($_REQUEST['rb_importancia_14']))
       {   
           $vlf_rb_importancia_14 = $_REQUEST['rb_importancia_14'];           
       }
       if (isset($_REQUEST['tb_observaciones_14']))
       {
           $vlf_tb_observaciones_14 = $_REQUEST['tb_observaciones_14'];           
       }
       
      if (isset($_REQUEST['rb_evaluacion_15']))
       {
           $vlf_rb_evaluacion_15 = $_REQUEST['rb_evaluacion_15'];           
       }
       if (isset($_REQUEST['rb_importancia_15']))
       {
           $vlf_rb_importancia_15 = $_REQUEST['rb_importancia_15'];           
       }
       if (isset($_REQUEST['tb_observaciones_15']))
       {
           $vlf_tb_observaciones_15 = $_REQUEST['tb_observaciones_15'];           
       }
       
      if (isset($_REQUEST['rb_evaluacion_16']))
       {
           $vlf_rb_evaluacion_16 = $_REQUEST['rb_evaluacion_16'];           
       }
       if (isset($_REQUEST['rb_importancia_16']))
       {
           $vlf_rb_importancia_16 = $_REQUEST['rb_importancia_16'];           
       }
       if (isset($_REQUEST['tb_observaciones_16']))
       {            
           $vlf_tb_observaciones_16 = $_REQUEST['tb_observaciones_16'];           
       }
       
       if (isset($_REQUEST['rb_evaluacion_17']))
       {
           $vlf_rb_evaluacion_17 = $_REQUEST['rb_evaluacion_17'];           
       }
       if (isset($_REQUEST['rb_importancia_17']))
       {
           $vlf_rb_importancia_17 = $_REQUEST['rb_importancia_17'];           
       }
       if (isset($_REQUEST['tb_observaciones_17']))
       {
           $vlf_tb_observaciones_17 = $_REQUEST['tb_observaciones_17'];           
       }
       
       if (isset($_REQUEST['tb_observaciones_18']))
       {
           $vlf_tb_observaciones_18 = $_REQUEST['tb_observaciones_18'];           
       }
       
       if (isset($_REQUEST['tb_observaciones_19']))
       {
           $vlf_tb_observaciones_19 = $_REQUEST['tb_observaciones_19'];           
       }
       //------------------------
	   //- Asigna sentencia sql -
       //------------------------
       $vlf_sql_insert="INSERT INTO respuesta_encuestas 
       (nombre_empresa,nombre_funcionario,nombre_sector,id_cliente,
        evaluacion1,importancia1,observaciones1,
		evaluacion2,importancia2,observaciones2,
		evaluacion3,importancia3,observaciones3,
		evaluacion4,importancia4,observaciones4,
		evaluacion5,importancia5,observaciones5,
		evaluacion6,importancia6,observaciones6,
		evaluacion7,importancia7,observaciones7,
		evaluacion8,importancia8,observaciones8,
		evaluacion9,importancia9,observaciones9,
		evaluacion10,importancia10,observaciones10,
		evaluacion11,importancia11,observaciones11,
		evaluacion12,importancia12,observaciones12,
		evaluacion13,importancia13,observaciones13,
		evaluacion14,importancia14,observaciones14,
		evaluacion15,importancia15,observaciones15,
		evaluacion16,importancia16,observaciones16,
		evaluacion17,importancia17,observaciones17,
		observaciones18,observaciones19) 
		VALUES
		('$vlf_nombre_empresa','$vlf_nombre_funcionario','$vlf_nombre_sector','$vlf_id_cliente',
		'$vlf_rb_evaluacion_1','$vlf_rb_importancia_1','$vlf_tb_observaciones_1',
        '$vlf_rb_evaluacion_2','$vlf_rb_importancia_2','$vlf_tb_observaciones_2',
        '$vlf_rb_evaluacion_3','$vlf_rb_importancia_3','$vlf_tb_observaciones_3',
        '$vlf_rb_evaluacion_4','$vlf_rb_importancia_4','$vlf_tb_observaciones_4',
        '$vlf_rb_evaluacion_5','$vlf_rb_importancia_5','$vlf_tb_observaciones_5',
        '$vlf_rb_evaluacion_6','$vlf_rb_importancia_6','$vlf_tb_observaciones_6',
        '$vlf_rb_evaluacion_7','$vlf_rb_importancia_7','$vlf_tb_observaciones_7',
        '$vlf_rb_evaluacion_8','$vlf_rb_importancia_8','$vlf_tb_observaciones_8',
        '$vlf_rb_evaluacion_9','$vlf_rb_importancia_9','$vlf_tb_observaciones_9',
        '$vlf_rb_evaluacion_10','$vlf_rb_importancia_10','$vlf_tb_observaciones_10',
        '$vlf_rb_evaluacion_11','$vlf_rb_importancia_11','$vlf_tb_observaciones_11',
        '$vlf_rb_evaluacion_12','$vlf_rb_importancia_12','$vlf_tb_observaciones_12',
        '$vlf_rb_evaluacion_13','$vlf_rb_importancia_13','$vlf_tb_observaciones_13',
        '$vlf_rb_evaluacion_14','$vlf_rb_importancia_14','$vlf_tb_observaciones_14',
        '$vlf_rb_evaluacion_15','$vlf_rb_importancia_15','$vlf_tb_observaciones_15',
        '$vlf_rb_evaluacion_16','$vlf_rb_importancia_16','$vlf_tb_observaciones_16',
        '$vlf_rb_evaluacion_17','$vlf_rb_importancia_17','$vlf_tb_observaciones_17',
        '$vlf_tb_observaciones_18','$vlf_tb_observaciones_19')
		 ";
                    
        $resultado= FN_RUN_MYSQL_NONQUERY($vlf_sql_insert,$this->vlc_conexion);
         //echo "SQL ($resultado) $vlf_sql_insert";
        return $resultado;
    }
    function MTD_OBTENER_TPL($tpl)
    {
        $vlf_codigo_html="";
        
        $vlf_codigo_html= FN_LEER_TPL('tpl/tpl_frm_encuesta.html');
        ///echo "<h3> lectura del html </h3> <hr> $vlf_codigo_html";
        return $vlf_codigo_html;        
    }
    /*
    +++++++++++++++++++++++++++++++++++++++++++++++
	- MTD_MOSTRAR_HTML -
	retorna el contenido del formato html
    +++++++++++++++++++++++++++++++++++++++++++++++
	*/
    function MTD_MOSTRAR_HTML()
    {
        
         return $this->vlc_codigo_html;
    }
}
?>