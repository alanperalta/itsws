<?php 
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login']){
?>
<htlm>
    <header>
        <title>TGroup Web Version</title>
        <?php include_once '../includes/meta-data.php';?>
        <link rel="stylesheet" type="text/css" href="../css/menu.css"/>
        <link rel="stylesheet" type="text/css" href="../css/contenido.css"/>
        <script type="text/javascript" src="../js/menu.js"></script>
    </header>
    <body>
        <div class="nav-side-menu">
            <div class="brand">Usuario: <?php echo $_SESSION['user']?></div>
            <div class="brand">Base de datos: <?php echo $_SESSION['db']?></div>
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

                <div class="menu-list">

                    <ul id="menu-content" class="menu-content collapse out">
                        <li class="active">
                          <a href="#">
                          <i class="fa fa-dashboard fa-lg"></i> Panel principal
                          </a>
                        </li>

                        <li  data-toggle="collapse" data-target="#ventas" class="collapsed">
                          <a href="#"><i class="fa fa-shopping-cart fa-lg"></i> Ventas <span class="arrow"></span></a>
                        </li>
                        <ul class="sub-menu collapse" id="ventas">
                            <li class="active"><a href="#" onclick="cargarContenido('ERP_PEN_VEN_IMP')"><i class="fa fa-calendar fa-lg"></i>Pendientes de imputaci&oacute;n</a></li>
                            <li class="active"><a href="#" onclick="cargarContenido('ERP_COM_VEN_REC')"><i class="fa fa-arrow-left fa-lg"></i>Recibos</a></li>
                        </ul>


                        <li data-toggle="collapse" data-target="#compras" class="collapsed">
                          <a href="#"><i class="fa fa-gift fa-lg"></i> Compras <span class="arrow"></span></a>
                        </li>  
                        <ul class="sub-menu collapse" id="compras">
                        <li class="active"><a href="#" onclick="cargarContenido('ERP_PEN_COM_IMP')"><i class="fa fa-calendar fa-lg"></i>Pendientes de imputaci&oacute;n</a></li>
                        </ul>

                         <li>
                          <a href="../controller/logout.php">
                              <i class="fa fa-ban fa-lg"></i> Cerrar sesi&oacute;n
                          </a>
                        </li>
                    </ul>
             </div>
        </div>
        <div class="contenido"></div>
    </body>
</html>
    <?php } else header("location: ../view/login.php");?>