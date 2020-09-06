<!DOCTYPE html>
<html>
    <head>
        <meta charset="Utf-8"/>
        <title><?php getTitle()?></title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="layout/css/bootstrap.min.css">
        <link rel="stylesheet" href="layout/css/font-awesome.min.css">
        <link rel="stylesheet" href="layout/css/style.css">
       
    </head>
    <body>
        <!-- page one -->
        
        <header id="home">
            <div class="container-fluid">
                <div class="ham-menu">
                    <i class="fa fa-bars toggle"></i>
                    <i class="fa fa-times toggle"></i>
                </div>
                <div class="upper-bar">
                
                    <?php
                    
                        if (isset($_SESSION['user'])){ ?>
                            <nav class="navbar upper  ">
                            <div class="my_info ml-auto " id="navbarSupportedContent">
                            
                            <?php 
                                  $stmt=$con->prepare("SELECT Avatar FROM users WHERE UserID=? AND Username = ? LIMIT 1");
                                  $stmt->execute(array($_SESSION['uid'] , $_SESSION['user']));
                                  $callimage = $stmt->fetchAll();
                                foreach($callimage as $imag){
                        
                                    if(empty($imag['Avatar'])){
                                        echo "";
                                    }else{
                                        echo "<img src='admin/upload/avatar/" . $imag['Avatar'] . "' class='img-fluid rounded-circle' alt=''/>";
                                    }
                                }?>
                                <ul class="list-unstyled ">
                                    <li class="nav-item dropdown ">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php echo $_SESSION['user']; ?>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="profile.php">My Profile</a>
                                        <a class="dropdown-item" href="newadd.php">Adding New Article</a>
                                        <a class="dropdown-item" href="profile.php#my-ads">My Articles</a>
                                        <a class="dropdown-item" href="logout.php">logout</a>
                                        
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            </nav>
                        
                    <?php }else{ ?>
                        <a href="login.php">
                        <span class="pull-right">Login/Signup</span>
                        </a>
                  <?php }?>
                
            </div>
                <nav class="navbar-expand-lg d-flex align-item-center justify-content-center ">
                    
                    </a>
                    <ul class="nav-list text-center p-0">
                        <?php 
                        $allCats = getAllForm("*", "category" , "" , "" , "ID" , "ASC");
                        foreach($allCats as $cat){
                            echo '<li class="nav-item"><a class="nav-link text-capitalize" href = "category.php?pageid='.$cat['ID'].'">'. $cat['Name'].'</a></li>';
                        }

                       ?>
                    </ul>
                </nav>
        
                <div class="hero-text w-100 text-white px-2 px-sm-0 ">
                    <h1 class="display-4 banner">Hello Honey </h1>
                    <p class="lead mb-4 food-btn">In Our Blog You Will Discover alot.</p>
                    <a class="btn px-5 mr-2 banner" href="index.php">Home</a>
                   
                </div>
           </div>
        </header>
        <!-- page one -->
    














    
        