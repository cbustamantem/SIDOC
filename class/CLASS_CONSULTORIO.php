<?php
class CLASS_CONSULTORIO
{
    private $vlc_codigo_html;
    private $vlc_nombre_cliente;
    private $vlc_apellido_cliente;
    private $vlc_holding;
    private $vlc_empresa;
    private $vlc_sucursal;
    private $vlc_id_cliente;
    private $vlc_db_cn;
    function __construct ($vp_cn)
    {
    	$this->vlc_db_cn = $vp_cn;
        $this->MTD_LIMPIAR_VARIABLES();
        $this->MTD_INICIALIZAR_PAGINA();
        
    }
    function MTD_LIMPIAR_VARIABLES()
    {
    	$this->vlc_codigo_html = "";
        $this->vlc_codigo_html="";
	    $this->vlc_nombre_cliente="";
	    $this->vlc_apellido_cliente="";
	    $this->vlc_holding="";
	    $this->vlc_empresa="";
	    $this->vlc_sucursal="";
	    $this->vlc_id_cliente="";				
    }
    function MTD_INICIALIZAR_PAGINA ()
    {
        /*
         * TODO: 
         * VALORES DEL FORMULARIO
         * ----------------------
         * [tb_nombre_programa]
         * [id_programa]
         * 
         * ACCIONES DEL FORMULARIO
         * -----------------------
         * frm_insertar
         * frm_actualizar
         * 
         * ETIQUETAS DEL tpl
         * ------------------------
         * {accion-formulario}
         * {titulo-accion-formulario}
         * {grilla-datos-categoria}
         * {tb-nombre-categoria}         
         */
       $this->vlc_codigo_html = FN_LEER_TPL('tpl/tpl-consultorio.html');
       include ('CLASS_ABM_PACIENTES.php');
       $obj_pacientes = new CLASS_ABM_PACIENTES($this->vlc_db_cn );
       $listado_pacientes= $obj_pacientes->MTD_LISTAR_PACIENTES();
       $this->vlc_codigo_html = FN_REEMPLAZAR("{tpl-listado-pacientes}", $listado_pacientes,  $this->vlc_codigo_html );
    }
    
    
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return $this->vlc_codigo_html;
    }
}
?>
