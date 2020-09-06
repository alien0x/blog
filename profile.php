<?php 
//here we didnt use id for each member cause it depend on session to appear this page
    session_start();
    $pageTitle = 'profile';
    include 'init.php';
    if (isset($_SESSION['user'])){

        $getUser = $con -> prepare("SELECT * FROM users WHERE Username=?");
        $getUser -> execute(array($sessionUser));
        $info = $getUser->fetch();

    ?>

        <div class="information block">
        <h1 class="text-center">- My Profile -</h1>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        My Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="text-capitalize">
                                        <i class="fa fa-unlock-alt fa-fw"></i>
                                       <strong class="stro"> Name :</strong> <?php echo $info['Username'];?>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope-o fa-fw"></i>
                                        <strong class="stro"> Email :</strong> <?php echo $info['Email'];?>
                                    </li>
                                    <li class="text-capitalize">
                                        <i class="fa fa-user fa-fw"></i>
                                        <strong class="stro">Full Name :</strong> <?php echo $info['FullName'];?>
                                    </li>
                                    <li>
                                        <i class="fa fa-calendar fa-fw"></i>
                                       <strong class="stro"> Register Date :</strong> <?php echo $info['Date'];?>
                                    </li>
                                    
                                </ul>
                                <a href="" class="btn btn-default ">Edit info</a>
                            </div>
                            <div class="col-md-6">
                                <div class="imag">
                                    <?php if(empty($info['Avatar'])){
                                            echo "";
                                        }else{
                                            echo "<img src='admin/upload/avatar/" . $info['Avatar'] . "' class='img-fluid' alt=''/>";
                                        }?>
                                </di>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="my-ads" class="my-article block">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        My Articles
                    </div>
                    <div class="card-body articles">
                        <div class="row">
                        <?php 
                         
                            foreach(getitems('Member_ID' ,$info['UserID'] ,1) as $item){


                                    echo'<div class="card">';
                                        echo'<div class="row no-gutters">';
                                            echo '<div class="col-md-4 item-box">';
                                            if ($item['Approve']==0){
                                                echo '<span class="approve-status">Waiting Approval</span>';
                                            }
                                                echo '<img src="admin/upload/image/' . $item['Image'] . '" class="card-img" alt="...">';
                                            echo '</div>';
                                            echo '<div class="col-md-8">';
                                                echo '<div class="card-body ">';
                                                    
                                                    echo'<h4 class="card-title text-uppercase "> '. $item['category_name'].'</h4>';
                                                    echo'<h5 class="card-title text-capitalize"><span>Title of article : </span><a class="tit" href="show-item.php?itemid= '. $item['Item_ID'] .'"> '. $item['Name'].'</a></h5>';
                                                    echo '<p class="card-text text-capitalize"><span>Publisher <i class="fa fa-user"></i> : </span> '. $item['Username'] .'</p>';
                                                    echo '<p class="card-text desc"><i class="fa fa-arrow-right"></i> '. $item['Description'] .'</p>';
                                                    echo'<p class="card-text"><small class="text-muted"><i class="fa fa-calendar"></i> '. $item['Add_Date'] .'</small></p>';
                                                echo'</div>';
                                            echo'</div>';
                                        echo'</div>';
                                    echo'</div>';
                                
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-comments block">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        Latest comments
                    </div>
                    <div class="card-body">
                    <?php
                        $stmt=$con->prepare("SELECT comments.*, items.Name AS Item_name, users.Username AS member FROM comments 
                                    INNER JOIN items ON items.Item_ID = comments.Item_id 
                                    INNER JOIN users ON users.UserID = comments.User_id 
                                    WHERE User_id = ?");
                        $stmt->execute(array($info['UserID']));
                        $comments = $stmt->fetchAll();

                        

                    ?>
                       
                            <?php foreach($comments as $comment){
                            echo '<div class="row latest">';
                                echo '<div class="col-md-8">';
                                    echo '<p><strong class="stro" >Comment : </strong>'.$comment['Comment'].'&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></p>';
                                echo '</div>';
                                echo '<div class="col-md-4">';
                                    echo '<p><strong class="stro" >Article : </strong>'.$comment['Item_name'].'</p>';
                                echo '</div>';
                                echo '<hr class="custom ">';
                            echo '</div>';
                            }?>
                            
                    </div>
                </div>
            </div>
        </div>
<?php 
    }else{
        header('location: login.php');
        exit();
    }

include 'includes/templetes/footer.php'; ?>
