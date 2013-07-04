<?php
class CLASS_ABM_PERFILES
{
    private $id_perfil;
    private $perfil;
    private $codigo_html;
    private $db_cn;

    function __construct ($vp_cn)
    {
        $this->db_cn = $vp_cn;
        $this->MTD_LIMPIAR_VARIABLES();
        $this->MTD_INICIALIZAR_PAGINA ();
                     
    }
    function MTD_LIMPIAR_VARIABLES()
    {
        $this->id_perfil="";
        $this->perfil="";        
    } 
    function MTD_INICIALIZAR_PAGINA ()
    {
        /*
         * TODO: 
         * VALORES DEL FORMULARIO         
         */
        LOGGER::LOG("Asignando el template:");
        
        $vlc_codigo_html=FN_LEER_TPL('tpl/tpl-adm-perfiles.html');
        $vlc_codigo_html = FN_REEMPLAZAR("{tpl-lista-perfiles}",$this->MTD_LISTAR_PERFILES(),$vlc_codigo_html );
        $this->vlc_codigo_html= $vlc_codigo_html;
        
       
    }
    function MTD_LISTAR_PERFILES()
    {
        $codigo_html="";
        $datos=array();
        $datos = FN_RUN_QUERY("SELECT id_perfil, perfil from perfiles_usuarios",2,$this->db_cn);
        $encabezado= array();
        $codigo_html='<table class=" table table-bordered " id="example">
        <thead>
        <tr>
            <th>#</th>
            <th>Descripcion</th>            
            <th>Opciones</th>            
        </tr>
        </thead>
        <tbody>        
        ';
        foreach ($datos as $key => $value) 
        {
            $codigo_html.='
            <tr >
            <td>'.$value[0].'</td>
            <td>'.$value[1].'</td>
            <td>
      
                  <div class="btn-group">
                    <a class="btn" href="#Editar" onclick="javascript:MTD_MOSTRAR_PERMISOS('.$value[0].')"><i class="icon-edit"></i></a>
                    <a class="btn" href="#Eliminar" onclick="javascript:MTD_ELIMINAR_PERFIL('.$value[0].')"><i class="icon-remove-circle"></i></a>                                       
                  </div>
                
            </td>
            </tr>
            ';          
            
        }
        $codigo_html.="    </tbody> </table>";
        return $codigo_html;
        
        
    }
    function MTD_AGREGAR_PERFILES()
    {
        LOGGER::LOG("AGREGAR PERFILES");
        $descripcion=FN_RECIBIR_VARIABLES("descripcion");
        
        $sql="INSERT INTO perfiles_usuarios (perfil) values ('".$descripcion."');";
        $resultado=false;
        LOGGER::LOG("AGREGAR PERFILES: SQL:".$sql);
        $resultado= FN_RUN_NONQUERY($sql,$this->db_cn );
        if ($resultado == true)
        {
            return "0";
        }
        else
        {
            return "Error en la operacion de insercion de especialidad";
        }
    }
    function MTD_AGREGAR_PERMISOS()
    {
        LOGGER::LOG("AGREGAR PERMISOS");
        $id_perfil=FN_RECIBIR_VARIABLES("id_perfil");
        $categorias= array();
        $categorias = explode(":",FN_RECIBIR_VARIABLES("categorias"));
        $id_categoria=$categorias[0];
        $id_subcategoria=$categorias[1];
        $sql="";
        if ($id_subcategoria)
        {
            $sql="INSERT INTO perfiles_permisos (id_perfil,idcategoria,idsubcategoria) values (".$id_perfil.",".$id_categoria.",".$id_subcategoria.");";
        }
        else
        {
            $sql="INSERT INTO perfiles_permisos (id_perfil,idcategoria) values (".$id_perfil.",".$id_categoria.");";   
        }
        $resultado=false;
        LOGGER::LOG("AGREGAR PERMISOS: SQL:".$sql);
        $resultado= FN_RUN_NONQUERY($sql,$this->db_cn );
        if ($resultado == true)
        {
            return "0";
        }
        else
        {
            return "Error en la operacion de insercion de permisos";
        }
    }
    function MTD_ELIMINAR_PERFILES()
    {
        LOGGER::LOG("ELIMINAR PERFILES");
        $idperfil=FN_RECIBIR_VARIABLES("idperfil");
        
        $sql="DELETE  from perfiles_usuarios where id_perfil= ".$idperfil." limit 1;";
        $resultado=false;
        LOGGER::LOG("ELIMINAR PERFILES: SQL:".$sql);
        $resultado= FN_RUN_NONQUERY($sql,$this->db_cn );
        if ($resultado == true)
        {
            return "0";
        }
        else
        {
            return "Error en la operacion de ELIMINAR de PERFILES";
        }
    }

    function MTD_MOSTRAR_PERMISOS()
    {
       LOGGER::LOG("MOSTRAR PERMISOS");
           /*
         * TODO: 
         * VALORES DEL FORMULARIO         
         */
       
        
        $vlc_codigo_html=FN_LEER_TPL("tpl/tpl-abm-perfiles-permisos.html");

        
        $vlc_codigo_html = FN_REEMPLAZAR("{tpl-id-perfil}", FN_RECIBIR_VARIABLES("id_perfil"),$vlc_codigo_html );
        $vlc_codigo_html = FN_REEMPLAZAR("{tpl-lista-categoria}",$this->MTD_SELECCION_CATEGORIAS(),$vlc_codigo_html );
        $vlc_codigo_html = FN_REEMPLAZAR("{tpl-lista-permisos}",$this->MTD_LISTAR_PERMISOS(),$vlc_codigo_html );
        $this->vlc_codigo_html= $vlc_codigo_html;        
        return $vlc_codigo_html;

    }
    function MTD_LISTAR_PERMISOS()
    {
         
        $codigo_html="";
        $datos=array();
        $id_perfil = FN_RECIBIR_VARIABLES("id_perfil");
        LOGGER::LOG("MOSTRAR PERMISOS > ID: $id_perfil");
        $sql="SELECT perm.id_permiso, cat.categoria, sub.subcategoria  
                FROM perfiles_permisos as perm
                LEFT JOIN categorias as cat ON (perm.idcategoria =  cat.idcategoria)
                LEFT JOIN subcategorias as sub ON (perm.idsubcategoria = sub.idsubcategoria)
                WHERE  id_perfil =". $id_perfil ;
        LOGGER::LOG("MOSTRAR PERMISO: SQL:".$sql);
        $datos = FN_RUN_QUERY($sql,3,$this->db_cn);
        $encabezado= array();
        $codigo_html='<table class=" table table-bordered " id="perfiles">
        <thead>
        <tr>
            <th>#</th>
            <th>Categoria</th>            
            <th>SubCategoria</th>
            <th>Opciones</th>            
        </tr>
        </thead>
        <tbody>        
        ';
        foreach ($datos as $key => $value) 
        {
            $codigo_html.='
            <tr >
            <td>'.$value[0].'</td>
            <td>'.$value[1].'</td>
            <td>'.$value[2].'</td>
            <td>
      
                  <div class="btn-group">                    
                    <a class="btn" href="#Eliminar" onclick="javascript:MTD_ELIMINAR_PERMISO('.$value[0].')"><i class="icon-remove-circle"></i></a>                                       
                  </div>
                
            </td>
            </tr>
            ';          
            
        }
        $codigo_html.="    </tbody> </table>";
        return $codigo_html;
        
        
    }
    function MTD_ELIMINAR_PERMISOS()
    {
        LOGGER::LOG("ELIMINAR PERMISO");
        $idpermiso=FN_RECIBIR_VARIABLES("id_permiso");
        
        $sql="DELETE  from perfiles_permisos where id_permiso= ".$idpermiso." limit 1;";
        $resultado=false;
        LOGGER::LOG("ELIMINAR PERMISO: SQL:".$sql);
        $resultado= FN_RUN_NONQUERY($sql,$this->db_cn );
        if ($resultado == true)
        {
            return "0";
        }
        else
        {
            return "Error en la operacion de ELIMINAR de PERMISO";
        }
    }
    function MTD_SELECCION_CATEGORIAS()
    {
        LOGGER::LOG("MOSTRAR SELECCION CATEGORIAS");
        $codigo_html="";
        $datos = array();
        $datos = FN_RUN_QUERY("SELECT 
                        cab.idcategoria,
                        cab.categoria,
                        sub.idsubcategoria,
                         sub.subcategoria                        
                        from categorias as cab
                        left join subcategorias as sub ON (cab.idcategoria = sub.idcategoria)
                        order by cab.categoria, sub.subcategoria " , 4 , $this->db_cn);
        
        $codigo_html="<select id='lst_categorias'>";

       
        foreach($datos as $key => $value)
        {
            $seleccion="";
            if (!$value[2])
            {
                $value[2]="0";
            }
            
            if ($this->id_categoria == $value[0] && trim($this->id_subcategoria) == "")
            {
                $seleccion =" SELECTED ";
            }
            else if  ($this->id_categoria == $value[0] && $this->id_subcategoria == $value[2])
            {
                $seleccion =" SELECTED ";   
            }
            

            $codigo_html.="<option value='".$value[0].":".$value[2]."' ".$seleccion." >".$value[1]." - ".$value[3]."</option>";
        }
        $codigo_html.="</select>";
        return $codigo_html;
    }
    function MTD_RECIBIR_DATOS_DB ($vp_arreglo_datos)
    {   
        $this->vlc_id_perfil               = $vp_arreglo_datos[0][0];
        $this->vlc_perfil                  = $vp_arreglo_datos[0][1];

    }
  
    function MTD_DB_ACTUALIZAR ()
    {
        $resultado = false;
        $vlf_sql = "
        UPDATE
        clientes
        SET
        nombre_cliente      = '".$this->vlc_nombre_cliente."', 
        apellido_cliente    = '".$this->vlc_apellido_cliente."', 
        holding             = '".$this->vlc_holding."', 
        empresa             = '".$this->vlc_empresa."', 
        sucursal            = '".$this->vlc_sucursal."'     
        WHERE
        id_cliente = ".$this->vlc_id_cliente.";";
                
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_cn );     
       // echo  $vlf_sql;   
        return $resultado;
    }
    function MTD_DB_ELIMINAR ()
    {
        $resultado = false;
        $vlf_sql = "DELETE FROM clientes  where id_cliente =" . $this->vlc_id_cliente;
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_cn );
        return $resultado;
    }
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return $this->vlc_codigo_html;
    }
}
?>