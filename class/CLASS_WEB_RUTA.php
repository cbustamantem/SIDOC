<?php
class CLASS_WEB_RUTA
{
    private $vlc_codigo_html;   
    private $vlc_conexion;
    function __construct ($conexion)
    {
        $this->vlc_codigo_html="";
        $this->vlc_codigo_menues="";
        $this->vlc_codigo_html= "";
        $this->vlc_conexion= $conexion;
        $this->MTD_INICIALIZA_MENU();            
        /*
         * TODO:
         * reemplazar los banners
         * {link-baner}
         * {ruta-imagen}
         */        
    }
    function MTD_INICIALIZA_MENU()
    {

        $ruta= ' <ul id="sub_botonera">  <li><a class="activo" href="index.php" title="Inicio"> Inicio</a> </li>';
        $categoria ="";
        $subcategoria ="";
        $titulo="<h2>Listado de Documentos</h2>";
        if (isset($_GET["categoria"]))
        {
            $datos = array();
            $categoria =FN_RECIBIR_VARIABLES("categoria");
            $datos = FN_RUN_QUERY("SELECT categoria from categorias where idcategoria=".$categoria ,1,$this->vlc_conexion);
            if ($datos)
            {
                $ruta.= '<li><a class="activo" href="index.php?categoria='.$categoria .'" title="'.$datos[0][0].'">'.$datos[0][0].'</a> </li>';
            }
            
            $titulo="<h2>Categorias: ".$datos[0][0]."</h2>";
        }
        if (isset($_GET["subcategoria"]))
        {
            $subcategoria=FN_RECIBIR_VARIABLES("subcategoria");
            $datos = array();
            $datos = FN_RUN_QUERY("SELECT subcategoria from subcategorias where idsubcategoria=".$subcategoria,1,$this->vlc_conexion);

            if ($datos)
            {
                $ruta.= '<li><a class="activo"  href="index.php?categoria='.$categoria .'&subcategoria='.$subcategoria.'" title="'.$datos[0][0].'">'.$datos[0][0].'</a> </li>';
            }
            $titulo="<h2>Sub Categorias: ".$datos[0][0]."</h2>";
        }
        if (isset($_GET["administracion"]))
        {
            
            $ruta.= '<li><a class="activo"  href="index.php?administracion=1" title="Administracion">Administraci&oacute;n</a> </li>';
            $titulo="<h2>Administracion de documentos</h2>";   
        }
        $ruta.="</ul>";
        $this->vlc_codigo_html=$titulo.$ruta;
    }

    function MTD_RETORNAR_CODIGO_HTML()
    {
        return $this->vlc_codigo_html;
        //return  $this->vlc_codigo_menues;
    }
    
}
?>