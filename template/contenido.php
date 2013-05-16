<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FUNDACIÓN PARAGUAYA | SIDOC</title>
    <meta name="description" content="" />
    <meta name="robots" content="all" />
    <link rel="shortcut icon" href="favicon.ico" />
    <link href="css/fundacionparaguaya.css" rel="stylesheet" type="text/css" />
    <link href="css/programacion.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ asset('js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/selectivizr-min.js"></script>
    <script type="text/javascript" src="{{ asset('js/modernizr-2.5.3.js"></script>
    <script type="text/javascript" src="{{ asset('js/easySlider1.7.js"></script>
    <!--flex-->
    <link rel="stylesheet" type="text/css" href="css/flexpaper.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/flexpaper.js"></script>
    <script type="text/javascript" src="js/flexpaper_handlers.js"></script>
    <!--Fin Flex-->
    <!--[if IE]>
    <style>
        #txt_busqueda{ border:0; }
    </style>
    <![endif]-->
    <!--[if IE 7]>
    <style>
        .headerbottom{
            height:110px;
        }
        
        #contenedor{ padding:0; }
    </style>
    <![endif]-->
<!-- Productos-Detalles -  Fancybox -->

    <script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
    <link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
        $(document).ready(function() {

            $("a.ampliar").fancybox({
                'overlayShow'   : true,
                'transitionIn'  : 'elastic',
                'transitionOut' : 'none'
            });
            
        });
    </script><!-- easySlider 1.7 -->
    <link type="text/css" href="js/easySlider/screen.css" rel="stylesheet" media="screen" />    
        <script type="text/javascript">
            $(document).ready(function(){   
                $("#slider").easySlider({
                    auto: true, 
                    continuous: true
                });
            }); 
    </script><!-- superfish 1.4.8 -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="js/superfish/superfish.css" media="screen">
    <link rel="stylesheet" type="text/css" href="js/superfish/superfish-vertical.css" media="screen">
    <script type="text/javascript" src="js/superfish/hoverIntent.js"></script>
    <script type="text/javascript" src="js/superfish/superfish.js"></script>

    <script type="text/javascript">

        // initialise plugins
        jQuery(function(){
            jQuery('ul.sf-menu').superfish();
        });

    </script>
</head>

<body class="esp" id="quienes">

    <div class="bg">
        <div class="bgheader">
            <div class="s960 divcentrado" id="header">
                  
            <div class="headertop">
                    <ul class="botonera">
                        <li><a href="./" title="Inicio"><img src="images/btn_inicio.png" width="36" height="37" alt="Inicio" /></a></li>
                        <li><a id="btn_quienes" href="index.php" title="INICIO">INICIO</a></li>
                        <li><a id="btn_involucrate" href="index.php?seccion=administracion" title="ADMINISTRACION">ADMINISTRACION</a></li>
                        
                    </ul><!-- fin botonera -->
<!--{tpl-login} -->                     
                </div><!-- fin headertop -->
                
                                <div class="headerbottom">
                    <div class="logotipo"><a href="./" title="Fundacion Paraguaya"><img src="images/logo_fundacionparaguaya.jpg" width="183" height="108" alt="Fundación Paraguaya" /></a></div><!-- fin logotipo -->
                    
                    <div class="right s380">
                        <div class=" s160 left">
                            <h3><a id="espanol" href="./" title="Español">> BUSQUEDA DE DOCUMENTOS</a></h3>                            
                        </div><!-- fin idiomas -->
                        <form action="" method="post"  class="right s200" id="buscador" name="buscador">
                            <input id="txt_busqueda" name="txt_busqueda" type="text" value="Buscar..." />
                            <a href="#" onclick="if(($('#txt_busqueda').val()!='') && ($('#txt_busqueda').val()!='Buscar...')){ location.href='busqueda.php?buscar='+$('#txt_busqueda').val(); }else{ alert('Ingrese la informacion a buscar'); }" title="Buscar"><img src="images/ico_buscador.png" width="26" height="26" alt="Buscar" /></a>
                        </form><!-- fin buscador -->
                    </div><!-- fin right -->
                </div><!-- fin headerbottom -->                
            </div><!-- fin header -->
        </div><!-- fin bgheader -->
        
        <div class="bgcontenido">       
            <div class="s960 divcentrado" id="contenedor">
                <h1>Quiénes Somos</h1>
                <div class="left col_izquierda">

                    <!-- MENU DESPLEGABLE SUPERFISH -->
                    <ul class="sf-menu">
                       <li class="current">
                            <a href="#" title="Filosofía">Filosofía</a>
                            <ul>
                                <li><a href="quienes.php?id=67&tipo=contenido" title="Nuestra Visión">Nuestra Visión</a></li>
                                <li><a href="quienes.php?id=68&tipo=contenido" title="Nuestra Misión">Nuestra Misión</a></li>
                                <li><a href="quienes.php?id=69&tipo=contenido" title="Objetivos Estratégicos">Objetivos Estratégicos</a></li>
                                <li><a href="quienes.php?id=70&tipo=contenido" title="Nuestros Principios">Nuestros Principios</a></li>
                            </ul>
                        </li>                   
                        <li class="current">
                            <a href="#" title="Nuestros Programas">Nuestros Programas</a>
                                <ul>
                                    <li><a href="quienes.php?id=71&tipo=contenido" title="Microfinanzas">Microfinanzas</a></li>
                                    <li><a href="quienes.php?id=74&tipo=contenido" title="Educacion Emprendedora">Educacion Emprendedora</a></li>
                                    <li><a href="quienes.php?id=75&tipo=contenido" title="Escuelas Autosuficientes">Escuelas Autosuficientes</a></li>
                                </ul>
                        </li>                   
                        <li class="current">
                            <a href="quienes.php?id=73" title="Historia">Historia</a>
                        </li>                   
                                            <li class="current">
                            <a href="quienes.php?id=86" title="Memorias y Documentos">Memorias y Documentos</a>
                        </li>                   
                        <li class="current">
                            <a href="quienes.php?id=76" title="Consejo de Administración">Consejo de Administración</a>
                        </li>                   
                        <li class="current">
                            <a href="#" title="Gerentes">Gerentes</a>
                                <ul>
                                    <li><a href="quienes.php?id=88&tipo=contenido" title="Gerentes">Gerentes</a></li>
                                    <li><a href="quienes.php?id=89&tipo=contenido" title="Gerentes de Área">Gerentes de Área</a></li>
                                </ul>
                        </li>                   
                        <li class="current">
                            <a href="quienes.php?id=90" title="Oficinas Regionales">Oficinas Regionales</a>
                        </li>                   
                        <li class="current">
                            <a href="#" title="Código de Ética y Políticas">Código de Ética y Políticas</a>
                                <ul>
                                    <li><a href="quienes.php?id=92&tipo=contenido" title="Código de Ética">Código de Ética</a></li>
                                    <li><a href="quienes.php?id=93&tipo=contenido" title="Políticas de la Institución">Políticas de la Institución</a></li>
                                </ul>
                        </li>                   
                        <li class="current">
                            <a href="#" title="Logros y Premios">Logros y Premios</a>
                                <ul>
                                    <li><a href="quienes.php?id=96&tipo=contenido" title="Logros">Logros</a></li>
                                    <li><a href="quienes.php?id=97&tipo=contenido" title="Premios">Premios</a></li>
                                </ul>
                        </li>                   
                        <li class="current">
                            <a href="http://www.senatur.gov.py/" title="Acerca de Paraguay">Acerca de Paraguay</a>
                        </li>                   
                    </ul>
                    <!-- FIN MENU DESPLEGABLE SUPERFISH -->

                </div><!-- fin col_izquierda -->
            
                <div class="right col_derecha">
                <h2>Filosofía</h2>                                      
                <!-- Sub Botonera-->            
                <ul id="sub_botonera">
                    <li><a class="activo" href="quienes.php?id=67&tipo=contenido" title="Nuestra Visión"> Nuestra Visión </a> </li>
                    <li><a  href="quienes.php?id=68&tipo=contenido" title="Nuestra Misión"> Nuestra Misión </a> </li>
                    <li><a  href="quienes.php?id=69&tipo=contenido" title="Objetivos Estratégicos"> Objetivos Estratégicos </a> </li>
                    <li><a  href="quienes.php?id=70&tipo=contenido" title="Nuestros Principios"> Nuestros Principios </a> </li>
                </ul><!-- fin sub_botonera -->
                                            
                <div class="contenido">
                <h2>Lista de documentos</h2>      
                    <div class="contenido ">
                            
                            <div id="documentViewer" class="flexpaper_viewer" style="width:770px;height:500px"></div>
                            <script type="text/javascript">
                                function getDocumentUrl(document){
                                    return "php/services/view.php?doc={doc}&format={format}&page={page}".replace("{doc}",document);
                                }

                                var startDocument = "Paper";

                                $('#documentViewer').FlexPaperViewer(
                                        { config : {

                                            SWFFile : 'docs/recuperacion.pdf.swf',

                                            Scale : 0.6,
                                            ZoomTransition : 'easeOut',
                                            ZoomTime : 0.5,
                                            ZoomInterval : 0.2, 
                                            FitPageOnLoad : true,
                                            FitWidthOnLoad : false,
                                            FullScreenAsMaxWindow : false,
                                            ProgressiveLoading : false,
                                            MinZoomSize : 0.2,
                                            MaxZoomSize : 5,
                                            SearchMatchAll : false,
                                            InitViewMode : 'Portrait',
                                            RenderingOrder : 'flash',
                                            StartAtPage : '',

                                            ViewModeToolsVisible : true,
                                            ZoomToolsVisible : true,
                                            NavToolsVisible : true,
                                            CursorToolsVisible : true,
                                            SearchToolsVisible : false,
                                            PrintEnabled : false,
                                             PrintToolsVisible : false,
                                            WMode : 'window',
                                            localeChain: 'es_ES'
                                        }}
                                );
                            </script>

        </div><!-- fin contenido -->    
        </div><!-- fin contenido -->                   
        </div><!-- fin col_derecha -->
        <div class="clear"></div>
    </div> <!--fin contenedor -->
              
        </div><!-- fin bgcontenido -->
    </div><!-- fin bg -->
    
    <div class="bgfooter">
        <div class="s960 divcentrado" id="footer">
                        <div class="footertop">
                <ul id="menufooter">
                    <li>
                        <div class="despliegue">
                            <img src="images/img_microfinanzas.jpg" width="79" height="47" alt="Microfinanzas" />
                            <a href="microfinanzas.php" title="Microfinanzas">MICROFINANZAS</a>
                        </div>
                    </li>
                                      
                    <li>
                        <div class="despliegue">
                            <img src="images/img_educacion.jpg" width="79" height="47" alt="Educación Emprendedora" />
                            <a href="edu_emprendedora.php" title="Educación Emprendedora">EDUCACIÓN EMPRENDEDORA</a>
                        </div>
                    </li>
                    
                    <li>
                        <div class="despliegue">
                            <img src="images/img_escuelas.jpg" width="79" height="47" alt="Escuelas Autosuficientes" />
                            <a href="esc_autosuficientes.php" title="Escuelas Autosuficientes">ESCUELAS AUTOSUFICIENTES</a>
                        </div>
                    </li>
                    
                    <li>
                        <div class="despliegue">
                            <img src="images/img_teach.jpg" width="79" height="47" alt="Teach a man to fish" />
                            <a href="http://www.teachamantofish.org.uk/es/home.php" target="_blank" title="Teach a man to fish">TEACH A MAN TO FISH</a>
                        </div>
                    </li>                                         
                </ul><!-- fin menufooter -->
            </div><!-- fin footertop -->                
                        <div class="footerdown">
                
                <!-- <div class="alianzas s560 mr10"> -->
                <div class="alianzas s380 mr20">
                    <p>Trabajamos con:</p>
                    <a href="http://www.kiva.org/" target="_blank" title="Kiva"><img src="images/alianzas/logo_kiva.png" alt="Kiva" /></a><!-- fin logo -->
                    <a href="http://www.skoll.com/" target="_blank" title="Skoll Foundation"><img src="images/alianzas/logo_skoll.png" alt="Skoll Foundation" /></a><!-- fin logo -->
                    <a href="http://www.teachamantofish.org.uk/es/home.php" target="_blank" title="Teach man to fish"><img src="images/alianzas/logo_teach.png" alt="Teach man to fish" /></a><!-- fin logo -->                    <!--<a href="#" title="Fundacion Paraguay"><img src="images/alianzas/sinlogo.jpg" width="80" height="57" alt="Fundacion Paraguaya" /></a>
                    <a href="#" title="Fundacion Paraguay"><img src="images/alianzas/sinlogo.jpg" width="80" height="57" alt="Fundacion Paraguaya" /></a>-->
                </div><!-- fin alianzas -->
                
                <div class="s100 left mr20 mt20">
                    <p style="color: #fff; font-size: 12px; float: left; margin-right: 10px;">Webmail:</p>
                    <!--<a href="http://mail.fundacionparaguaya.org.py:8081/" target="_blank" title="Webmail"><img src="images/ico_mail.png" width="16" height="16" alt="Mail" /></a> -->
                    <a href="https://mail.fundacionparaguaya.org.py/" target="_blank" title="Webmail"><img src="images/ico_mail.png" width="16" height="16" alt="Mail" /></a>
                </div><!-- fin redes -->
                
                <div class="redes s140 mr10">
                    <p>Seguinos:</p>
                    <a href="http://www.facebook.com/pages/Fundacion-Paraguaya/56540351830" target="_blank" title="Facebook"><img src="images/ico_facebook.jpg" width="17" height="17" alt="Facebook" /></a><!-- fin logo -->
                    <!--- <a href="#" title="Twitter"><img src="images/ico_twitter.jpg" width="17" height="17" alt="Twitter" /> </a> ---> <!-- fin logo --> 
                    <a href="http://www.youtube.com/user/fundapar" target="_blank" title="Youtube"><img src="images/ico_youtube.jpg" width="17" height="17" alt="Youtube" /></a><!-- fin logo -->
                </div><!-- fin redes -->
                
                <div class="creditos s180">
                    <a href="http://www.puntopy.com/" target="_blank" title="Puntopy"><img src="images/puntopy.png" width="180" height="21" alt="Puntopy" /></a>
                </div><!-- fin creditos -->
                
            </div><!-- fin footerdown -->
                
        </div><!-- fin footer -->
    </div><!-- fin bgfooter -->


</body>
</html>