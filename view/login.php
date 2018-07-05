<htlm>
    <header>
        <title>Login TGroup</title>
        <?php include_once '../includes/meta-data.php';?>
        <link rel="stylesheet" type="text/css" href="../css/login.css"/>
        <script type="text/javascript" src="../js/login.js"></script>
    </header>
    <body>
        <div class="container">
            <div class="login-container">
                <div id="output"></div>
                <div class="avatar"></div>
                <div class="form-box">
                    <form action="POST">
                        <input name="user" type="text" placeholder="Usuario">
                        <input type="password" name="password" placeholder="Contrase&ntilde;a">
                        <select name="dbName" placeholder="Contrase&ntilde;a" id="dbName" class="form-control">
                            <option value="TGROUP">DAMIAN</option>
                            <option value="LILIANA">LILIANA</option>
                            <option value="T.">T.</option>
                            <option value="TPRUEBA" selected>PRUEBA</option>-->
                        </select>
                        <button class="btn btn-info btn-block login" type="submit">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</htlm>
