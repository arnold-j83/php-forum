<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="A short description." />
    <meta name="keywords" content="put, keywords, here" />
    <title>PHP-MySQL forum</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
<!--html 5 nav bootstrap navbar -->
    <div class="nav navbar-header">
        <a class="navbar-brand" href="#/home">My forum</a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myCollapsingList">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
    </div>
    <!--responsive div to show hamburger menu-->
    <div class="collapse navbar-collapse" id="myCollapsingList">
    <a id="top"></a>
        
        <ul class="nav navbar-nav navbar-right">
            <?php
            session_start();
            if(isset($_SESSION['user_name']))
            {
                echo '<li><a data-toggle="collapse" data-target=".navbar-collapse" href="signout.php">Hello' . $_SESSION['user_name'] . '. Not you? Sign out</a></li>';
            }
            else
            {
                echo '<li><a data-toggle="collapse" data-target=".navbar-collapse" href="signin.php">Sign in</a> or <a href="sign up">create an account</a>.</li>';
            }
            ?>
            <li><a data-toggle="collapse" data-target=".navbar-collapse" href="index.php">Home</a></li>
            <li><a data-toggle="collapse" data-target=".navbar-collapse" href="create_topic.php">Create a topic</a></li>
            <li><a data-toggle="collapse" data-target=".navbar-collapse" href="create_cat.php">Create a category</a></li>
        </ul>
    </div>
    
</nav>
<div class="container">
    <h1>My forum</h1>
        <div id="content">