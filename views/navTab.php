<?php

    //session_start();

    if(!$_SESSION['usuario']) {
        header("Location: ../views/index.php");
    }

    // -------------



    $nomeUsuario = $_SESSION['usuario'][0];
    $tipoUsuario = $_SESSION['usuario'][1];
    $sistema = "EasyMarket";

?>


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="João Leite" >

    <title> <?php echo $sistema ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>





</head>

<body>


    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <!-- Navigation -->
        	<div class="navbar-header">

	            <a class="navbar-brand" href=""> <?php echo $sistema ?> </a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="">
                        <i class="fa fa-user fa-fw"></i>  <?php echo $nomeUsuario ?>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li> <a href="../models/logout.php"><i class="fa fa-sign-out fa-fw"></i> Sair do sistema </a> </li>
                    </ul>
                </li>
            </ul>



            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">



                <?php
                    $dono = 1;
                    $gerente = 2;

                    if($_SESSION['usuario']['tipoUser'] == $dono || $_SESSION['usuario']['tipoUser'] == $gerente) {

            	echo '
                        <li><a href="financeiro.php"><i class="fa fa-home fa-fw"></i> Financeiro </a></li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Funcionários <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="cadFuncionario.php"> Cadastrar </a></li>
                                <li><a href="funcionarios.php"> Listar </a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Produtos <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="cadProduto.php"> Cadastrar </a></li>
                                <li><a href="produtos.php"> Listar</a></li>
                            </ul>
                        </li> ';
                }
                ?>
                        <li><a href="pedidos.php"><i class="fa fa-folder-open fa-fw"></i> Pedidos em aberto </a></li>
                        <li><a href="cadPedido.php"><i class="fa fa-pencil fa-fw"></i> Realizar pedido </a></li>
                        <li><a href="caixa.php"><i class="fa fa-money fa-fw"></i> Caixa </a></li>
                    </ul>
                </div>
            </div>
    </nav>
