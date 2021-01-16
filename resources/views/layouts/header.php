<!DOCTYPE html>
<html>
<head>
    <title>Webphenomenal.ru - сайт о backend и frontend разработке</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo URL_MAIN; ?>node_modules/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo URL_MAIN; ?>resources/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">

</head>
<body>

    <div class="hidden-menu">
                <div class="inner-hidden-menu">

                <span class="close_menu">&times;</span>


                <div class="to-home-in-hidden">
                     <a href="<?php echo URL_MAIN; ?>"> <i class="fa fa-home">Home</i></a>
                </div>


                  <?php if(!isset($_COOKIE['logged_user'])){?>
                    <div class="hidden-menu-login">
                        <p>In/Up</p>
                            <a href="<?php echo URL_MAIN; ?>login" id="user-login">Sign In</a>
                            <a href="<?php echo URL_MAIN; ?>register">Sign Up</a>

                        <?php if(isset($_COOKIE['logged_user'])){
                            $user = json_decode($_COOKIE['logged_user']);
                            $admin = $user->admin;
                            if($admin){?>
                                <li><a href="<?php echo URL_MAIN; ?>pelagus">Admin's Panel</a></li>
                                <?php }else{
                                    ?>
                                <li><a href="<?php echo URL_MAIN; ?>user/cabinet">Cabinet</a></li>
                                <?php  }?>
                                <li><a href="<?php echo URL_MAIN; ?>user/logout">Logout</a></li>
                        <?php } ?>
                    </div>
                   <?php }else{?>

                    <div class="hidden-menu-login">
                            <a href="<?php echo URL_MAIN; ?>user/logout">Logout</a>
                    </div>

                   <?php } ?>


                   <div class="hidden-menu-other-funcs">
                     <p>Other functions</p>
                       <a href="#">Message</a>
                    </div>


                   <div class="hidden-menu-categories">
                    <p>Categories</p>
                        <ul>
                            <?php foreach($categories as $category){?>
                            <li><a href="<?php echo URL_MAIN; ?>category/<?php echo $category->route_name; ?>/">
                                <?php echo $category->name;?>
                            </a></li>
                            <?php } ?>
                            <li><a href="<?php echo URL_MAIN; ?>categories">Другое</a>
                        </ul>
                    </div>

                </div>
        </div>

        <header class="main_header">

            <div id="header_header">
    			<div class="logo-of-site">
                   <a href="<?php echo URL_MAIN;?>">WebPhenomenal</a>
                </div>

            <!-- mobile version header with search and menu -->
            <div class="hidden-header-main-part">

                <div class="hidden-menu-logo-three">
                    <div class="logo-of-site-2">
                        <a href="<?php echo URL_MAIN;?>">WebPhenomenal</a>
                    </div>
                     <div class="three-line-menu">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                     </div>
                </div>

                <div class="hidden-menu-search" id="search-in-site-2">
                    <form action="<?php echo URL_MAIN ?>search" class="search-form" method="get">
                        <input type="search" name="q" id="search2" class="search" placeholder="Поиск..." />
                        <i class="fa fa-search search-icon" id="search-icon"></i>
                    </form>
                </div>                
            </div>   




                <div id="search-in-site">
                    <form action="<?php echo URL_MAIN ?>search" class="search-form" method="get">
                        <input type="search" name="q" id="search" class="search" placeholder="Поиск..." />
                        <button type="submit" class="search-submit">Поиск</button>
                    </form>
                </div>



                <div class="search-login">
                    <?php if(isset($_COOKIE['logged_user'])){
                        $user = json_decode($_COOKIE['logged_user']);
                        $admin = $user->admin;
                        ?>
                        <button class="show_user_settings">User</button>
                        
                        <div class="user-settings modal-hidden"> 
                            <?php if($admin){?>
                                 <li><a href="<?php echo URL_MAIN; ?>pelagus">Admin's Panel</a></li>
                            <?php }else{
                                ?>
                                <li><a href="<?php echo URL_MAIN; ?>user/cabinet">Cabinet</a></li>
                            <?php  }?>
                            <li><a href="<?php echo URL_MAIN; ?>user/logout" id="user-logout">Logout</a></li>
                        </div>
                  <?php } ?>
                    <?php if(!isset($_COOKIE['logged_user'])){?>
                        <div class="login-register">
                            <a href="<?php echo URL_MAIN; ?>login">Sign In</a>
                            <a href="<?php echo URL_MAIN; ?>register">Sign Up</a>
                         </div>
                  <?php } ?>
            </div>

            </div>

            <div class="menu">
                <ul>
                    <?php foreach($categories as $category){?>
                        <?php if($category->route_name==$current_page_url){ ?>
                            <li class="current_category"><a href="<?php echo URL_MAIN; ?>category/<?php echo $category->route_name; ?>/">
                            <?php echo $category->name;?>
                            </a></li>
                        <?php }else{?>
                             <li><a href="<?php echo URL_MAIN; ?>category/<?php echo $category->route_name; ?>/">
                            <?php echo $category->name;?>
                            </a></li>
                        <?php } ?>
                    <?php } ?>

                    <?php if($current_page_url=="other"){ ?>
                        <li class="current_category"><a href="<?php echo URL_MAIN; ?>categories/other">Другое</a>
                    <?php }else {?>
                        <li><a href="<?php echo URL_MAIN; ?>categories/other">Другое</a>
                    <?php } ?>
                </ul>


            </div>



		</header>

        
        <div class="errors">
            <?php if(isset($_SESSION['access_error'])){?>
                <li><?php echo $_SESSION['access_error'];?></li>
                <span class="close_errors">&times;</span>
            <?php } ?>

            <?php if(isset($_SESSION['search-error'])){?>
                <?php foreach ($_SESSION['search-error'] as $error) {?>
                    <li><?php echo $error;?></li>
                <?php } ?>
                <span class="close_errors">&times;</span>
            <?php } ?>



        </div>

        <?php
        unset($_SESSION['article_delete_success']);
        unset($_SESSION['article_delete_error']);
        unset($_SESSION['login_success']);
        unset($_SESSION['user_create_success']);
        unset($_SESSION['user_logout']);
        unset($_SESSION['access_error']);
        unset($_SESSION['search-error']);
         ?>