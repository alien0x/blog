<?php

    ob_start();
    session_start();
    if (isset($_SESSION['Username'])){
        
        $pageTitle="dashboard";
        include 'init.php'; 
        $latestUsers = 5;
        $theLatest = getLatest("*" , "users" , "UserID" , $latestUsers);
        $latestitems = 5;
        $theLatestItem = getLatest("*" , "items" , "Item_ID" , $latestitems);
        $latestcomments = 5;
        $theLatestcomments = getLatest("*" , "comments" , "C_ID" , $latestcomments);
                            
        ?>

        <div class="home-stats">
            <div class="container text-center ">
                <h1 class="py-3">DASHBOARD</h1>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat st-member">
                            Total Members
                            <span><a href="member.php?action=manage"> <?php echo countItems('UserID', 'users') ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-pending">
                            Pending
                            <span><a href="member.php?action=manage&page=pending"><?php echo checkItems('RegStatus', 'users' , 0) ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-item">
                            Total Articles
                            <span><a href="items.php?action=manage"> <?php echo countItems('Item_ID', 'items') ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-comment">
                            Total Comments
                            <span><a href="comments.php?action=manage"> <?php echo countItems('C_ID', 'comments') ?></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="latest">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card toggle-info">
                            <div class="card-header">
                                <i class="fa fa-users"></i> Latest Registerd Users
                                <span class="pull-right "><i class="fa fa-angle-double-down"></i></span>
                            </div>
                            <div  class="card-body dis">
                                <ul class="list-unstyled">
                                <?php
                                foreach($theLatest as $user){
                                    echo '<li>' . $user["Username"] ;
                                
                                    echo ' <span><a href="member.php?action=edit&userid='.$user["UserID"].'" class="btn pull-right btn-success"><i class="fa fa-edit"></i>EDIT</a></span>';

                                    if ($user['RegStatus'] == 0 ){
                                        echo '<span><a href="member.php?action=activate&userid='.$user["UserID"].'" class="btn btn-info pull-right "><i class="fa fa-close"></i>ACTIVATE</a></span>';
                                    }

                                    echo '</li>';
                            
                                }
                                
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card toggle-info">
                            <div class="card-header">
                                <i class="fa fa-tag"></i> Latest Articles
                                <span class="pull-right"><i class="fa fa-angle-double-down"></i></span>

                            </div>
                            <div class="card-body dis">
                            <ul class="list-unstyled">
                            <?php
                            foreach($theLatestItem as $item){
                                echo '<li>' . $item["Name"] ;
                               
                                echo ' <span><a href="items.php?action=edit&itemid='.$item["Item_ID"].'" class="btn pull-right btn-success"><i class="fa fa-edit"></i>EDIT</a></span>';

                                if ($item['Approve'] == 0 ){
                                    echo '<span><a href="items.php?action=approve&itemid='.$item["Item_ID"].'" class="btn btn-info pull-right "><i class="fa fa-close"></i>Approve</a></span>';
                                }

                                echo '</li>';
                           
                            }
                            
                            ?>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--start latest comment-->
                <div class="row my-2">
                    <div class="col-sm-6">
                        <div class="card toggle-info">
                            <div class="card-header">
                                <i class="fa fa-comments-o"></i> Latest comments
                                <span class="pull-right"><i class="fa fa-angle-double-down"></i></span>

                            </div>
                            <div class="card-body dis">
                                
                                <?php $stmt=$con->prepare("SELECT comments.*,users.Username AS member ,users.UserID AS member_ID FROM comments 
                                        INNER JOIN users ON users.UserID = comments.User_id 
                                        ORDER BY C_ID DESC LIMIT 5 
                                        ");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();

                                    foreach($rows as $row){
                                        echo '<div class="comment-box">';
                                            echo '<span class="member-n"><a href="member.php?action=edit&userid='.$row["member_ID"].'">'.$row["member"].'</a></span>';
                                            echo '<p class="member-c">'.$row["Comment"].'</p>';
                                        echo '</div>';
                                    }
?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

<?php
        include 'includes/templetes/footer.php';

    }else{
        header('Location:index.php');
        exit();
    }

    ob_end_flush();
?>