<!DOCTYPE html>
<html>

<?php
    require("/var/www/html/idea-repository/templates/head.php");
?>

<body> 
        <header class="">
            <div id="banner" class="fixed-top">
                <div class="row">
                    <div class="col-sm-8">
                        <h1 id="title" class="container-fluid">Idea Repository</h1>
                    </div>
                    <div class="col-sm-4" id="searchCol">
                        <form id="search" class="d-flex">
                        <input class="form-control me-2" type="text" placeholder="Search">
                        <button class="btn btn-primary" type="button">Search</button>
                    </form>
                    
                </div>
                </div>

                <nav  class="navbar navbar-default" id="navTwo">
                    <div class="container-fluid">
                        <ul class="nav" id="displayOne">
                        <li class="nav-item">
                        <a class="nav-link fa fa-home" href="http://cit.wvncc.edu/idea-repository/index.php"><span class="iconLabelH">Home</span></a>
                        
                        </li>
                        <li class="nav-item">
                        <a class="nav-link fa fa-user-circle" href="https://cit.wvncc.edu/idea-repository/profile.php"><span class="iconLabelH">Profile</span></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link fa fa-lightbulb-o" href="http://cit.wvncc.edu/idea-repository/getAllideasbyCreatorUserId.php"><span class="iconLabelH">Ideas</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa fa-magic" href="http://cit.wvncc.edu/idea-repository/epiphany.php"><span class="iconLabelH">Create New</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa fa-search" href="#"><span class="iconLabelH">Browse</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa fa-umbrella" href="#"><span class="iconLabelH">About</span></a>
                        </li>
                    </ul>
                    
                    </div>
                </nav> 
                <nav class="navbar" id="displayTwo">
                    <ul class="nav">
                        <li class="nav-item">
                        <a class="nav-link fa fa-home" href="http://cit.wvncc.edu/idea-repository/index.php"></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link fa fa-user-circle" href="https://cit.wvncc.edu/idea-repository/profile.php"></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link fa fa-lightbulb-o" href="http://cit.wvncc.edu/idea-repository/getAllideasbyCreatorUserId.php"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa fa-magic" href="http://cit.wvncc.edu/idea-repository/epiphany.php"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa fa-search" href="#"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa fa-umbrella" href="#"></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <main class="clear">
            <div id="verticalNav" class="sectionStyle">
                <nav  class="navbar">
                    <div class="container-fluid">
                        
                        <ul class="navbar-nav">
                        
                            <li class="nav-item row iconAndLabelLi">
                                <a class="nav-link fa fa-home col-sm-3 icon" href="#"></a>
                                <a class="nav-link col-sm-9 iconLabel" href="http://cit.wvncc.edu/idea-repository/index.php">Home</a>
                            </li>
                            <li class="nav-item row iconAndLabelLi">
                            
                                <a class="nav-link fa fa-user-circle col-sm-3 icon" href="#"></a>
                                <a class="nav-link col-sm-9 iconLabel" href="https://cit.wvncc.edu/idea-repository/profile.php">Profile</a>
                            </li>
                            <li class="nav-item row iconAndLabelLi">
                                <a class="nav-link fa fa-lightbulb-o col-sm-3 icon" href="http://cit.wvncc.edu/idea-repository/getAllideasbyCreatorUserId.php"></a>
                                <a class="nav-link col-sm-9 iconLabel" href="http://cit.wvncc.edu/idea-repository/getAllideasbyCreatorUserId.php">Ideas</a>
                            </li>
                            <li class="nav-item row iconAndLabelLi">
                                <a class="nav-link fa fa-magic col-sm-3 icon" href="http://cit.wvncc.edu/idea-repository/epiphany.php"></a>
                                <a class="nav-link col-sm-9 iconLabel" href="http://cit.wvncc.edu/idea-repository/epiphany.php">Create New</a>
                            </li>
                            <li class="nav-item row iconAndLabelLi">
                                
                                <a class="nav-link fa fa-search col-sm-3 icon" href="#"></a>
                                <a class="nav-link col-sm-9 iconLabel" href="#">Browse</a>
                            </li>
                            <li class="nav-item row iconAndLabelLi">
                                
                                <a class="nav-link fa fa-umbrella col-sm-3 icon" href="#"></a>
                                <a class="nav-link col-sm-9 iconLabel" href="#">About</a>
                            </li>
                    </ul>
                    </div>
                </nav> 
            </div>
            <div class="row clear" id="content">
                
                <div class="columnTwo column col-lg-9">