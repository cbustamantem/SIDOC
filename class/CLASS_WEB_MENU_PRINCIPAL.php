<?php
class CLASS_WEB_MENU_PRINCIPAL
{
    private $vlc_codigo_html;
    private $vlc_codigo_menues;
    function __construct ()
    {
        $this->vlc_codigo_html="";
        $this->vlc_codigo_menues="";
        $this->vlc_codigo_html= FN_LEER_TPL('tpl/tpl-menu-principal.html');        
        $this->MTD_INICIALIZA_MENU();
        $this->MTD_IMPLEMENTAR_MENUES();        
        /*
         * TODO:
         * reemplazar los banners
         * {link-baner}
         * {ruta-imagen}
         */        
    }
    function MTD_INICIALIZA_MENU()
    {
        $this->MTD_ASIGNAR_MENU('index.php?id=registro','Area Principal');
        if ($_SESSION['rol_usuario'] == "admin")
        {
        	$this->MTD_ASIGNAR_MENU('index.php?id=registro&seccion=administracion','Administraci&oacute;n');
        }
        $this->MTD_ASIGNAR_MENU('index.php?id=registro&seccion=resultados-contables','Resultados Contables');               
        //$this->MTD_ASIGNAR_MENU('index.php?id=registro&seccion=graficos-contables','Gr&aacute;ficos Contables');
        $this->MTD_ASIGNAR_MENU('index.php?id=registro&seccion=salir','Cerrar Sesion');
                
    }
    function MTD_ASIGNAR_MENU($vp_link,$vp_titulo)
    {
     
        $vlf_estructura_menu="<a href='$vp_link' style='color:#435A08; font-size:11px;' class='cpst-link'>>$vp_titulo</a> &nbsp; ";
                
        //ASIGNA EL CODIGO A LA VARIABLE DE LA CLASE
        $this->vlc_codigo_menues =  $this->vlc_codigo_menues.$vlf_estructura_menu; 
    }
    function MTD_IMPLEMENTAR_MENUES()
    {
        /*
         * TODO:
         * Remplazar la lista de menues con la asignada en la variable de la clase
         * {lista-menues}
         */
       $this->vlc_codigo_html = FN_REEMPLAZAR("{menu-principal}",$this->vlc_codigo_menues,$this->vlc_codigo_html);                            
    }
    
    function MTD_RETORNAR_CODIGO_HTML()
    {
        return $this->vlc_codigo_html;
        //return  $this->vlc_codigo_menues;
    }
    
}
?>