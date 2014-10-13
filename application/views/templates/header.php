<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/23/14
 * Time: 8:59 AM
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle; ?></title>

    <!-- Bootstrap -->
    <link href="/<?php echo BASEURL.APPPATH; ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Typeahead style -->
    <link href="/<?php echo BASEURL.APPPATH; ?>/assets/typeahead/styles.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Typeahead js -->
    <script src="/<?php echo BASEURL.APPPATH; ?>/assets/typeahead/typeahead.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/<?php echo BASEURL.APPPATH; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <!--<div class="navbar-header">
            <a class="navbar-brand" href="/<?php /*echo BASEURL; */?>index.php/Dashboard/home">Aquatek Engineers</a>
        </div>-->

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-header" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="navbar-brand dropdown-toggle" data-toggle="dropdown">Aquatek Engineers<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Filtsep Technologies</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/<?php echo BASEURL; ?>">Home <span class="glyphicon glyphicon-th-large"></span></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>