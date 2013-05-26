<?php
class CLASS_WEB_MENU_PRINCIPAL
{
    private $vlc_codigo_html;
    private $vlc_codigo_menues;
    private $vlc_conexion;
    function __construct ($conexion)
    {
        $this->vlc_codigo_html="";
        $this->vlc_codigo_menues="";
        $this->vlc_codigo_html= "";
        $this->vlc_conexion= $conexion;
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
       $menues = array();
       $menues =  FN_RUN_QUERY("select idcategoria, categoria from categorias", 2,$this->vlc_conexion);
       $codigo_html = "<ul class='sf-menu' style='margin-top:60px;'>";
       $codigo_submenu="";
       if (isset($_GET['administracion']))
       {
            $codigo_html.="<li class='current'><a href='index.php?administracion=1&seccion=categorias' title='Categorias'>Categorias</a>";
            $codigo_html.="<li class='current'><a href='index.php?administracion=1&seccion=subcategorias' title='SubCategorias'>SubCategorias</a>";
            $codigo_html.="<li class='current'><a href='index.php?administracion=1&seccion=usuarios' title='Usuarios'>Usuarios</a>";
            $codigo_html.="<li class='current'><a href='index.php?administracion=1&seccion=perfiles' title='Perfil de Acceso'>Perfil de Acceso</a>";
       }
       else
       {
           
           foreach($menues as $menu)
           {
                $codigo_html.="<li class='current'><a href='index.php?seccion=documentos&categoria=".$menu[0]."' title='".$menu[1]."'>".$menu[1]."</a>";
                $submenues = array();
                $submenues = FN_RUN_QUERY("select idsubcategoria,subcategoria from subcategorias where idcategoria=".$menu[0],2,$this->vlc_conexion );
                if ($submenues)
                {
                    $codigo_submenu="<ul>";
                    foreach ($submenues as $submenu) 
                    {                    
                        $codigo_submenu.="<li><a href='index.php?seccion=documentos&categoria=".$menu[0]."&subcategoria=".$submenu[0]."' title='".$submenu[1]."'>".$submenu[1]."</a></li>";
                    }
                    $codigo_submenu.="</ul>";
                    $codigo_html.=$codigo_submenu;
                    $codigo_submenu="";
                }
                
                $codigo_html.="</li>";
           }
        }
       $codigo_html.="</ul>";
       $this->vlc_codigo_html= $codigo_html;
    }
    function MTD_ASIGNAR_MENU($vp_link,$vp_titulo)
    {
     
       
    }
    function MTD_IMPLEMENTAR_MENUES()
    {
        /*
         * TODO:
         * Remplazar la lista de menues con la asignada en la variable de la clase
         * {lista-menues}
         */
       
    }
    
    function MTD_RETORNAR_CODIGO_HTML()
    {
        return $this->vlc_codigo_html;
        //return  $this->vlc_codigo_menues;
    }
    
}
?>