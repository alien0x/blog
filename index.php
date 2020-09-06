<?php 
ob_start();
    session_start();
    $pageTitle = 'pagehome';
    
    include 'init.php';?>

        <div class="container articles">
            <h1>- All Articles -</h1>
            <div class="row">
                <?php 
                    $stmt=$con->prepare("SELECT items.*, category.Name AS category_name, users.Username  FROM items 
                                INNER JOIN category ON category.ID = items.Cat_ID 
                                INNER JOIN users ON users.UserID = items.Member_ID
                                WHERE Approve=1");
                    $stmt->execute();
                    $allItem = $stmt->fetchAll();
                    foreach($allItem as $item){
                        echo'<div class="card">';
                            echo'<div class="row no-gutters">';
                                echo '<div class="col-md-4">';
                                    echo '<img src="admin/upload/image/' . $item['Image'] . '" class="card-img" alt="...">';
                                echo '</div>';
                                echo '<div class="col-md-8">';
                                    echo '<div class="card-body">';
                                        echo'<h4 class="card-title text-uppercase "> '. $item['category_name'].'</h4>';
                                        echo'<h5 class="card-title text-capitalize"><span>Title of article : </span> <a class="tit" href="show-item.php?itemid= '. $item['Item_ID'] .'"> '. $item['Name'].'</a></h5>';
                                        echo '<p class="card-text text-capitalize"><span>Publisher <i class="fa fa-user"></i> : </span> '. $item['Username'] .'</p>';
                                        echo '<p class="card-text desc"> <i class="fa fa-arrow-right"></i> '. $item['Description'] .'</p>';
                                        echo'<p class="card-text"><small class="text-muted"><i class="fa fa-calendar"></i> '. $item['Add_Date'] .'</small></p>';
                                    echo'</div>';
                                echo'</div>';
                            echo'</div>';
                        echo'</div>';
                    }
                ?>
            </div>
        </div> 

<?php include 'includes/templetes/footer.php'; 
ob_end_flush();?>
