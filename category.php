
<?php 
    session_start();
    $pageTitle = 'category page';
    include 'init.php';
    $stmt=$con->prepare("SELECT items.*, category.Name AS category_name, users.Username FROM items 
            INNER JOIN category ON category.ID = items.Cat_ID 
            INNER JOIN users ON users.UserID = items.Member_ID
            WHERE Cat_ID = ? AND Approve=1");
            $stmt->execute(array($_GET['pageid']));
            $allItems = $stmt->fetch();
            $allItem = $stmt->fetchALL();
    ?>

<div class="container articles">
    <h1 class="text-center"><?php
    echo '<h1 class="text-center text-capitalize">'.$allItems['category_name'].' Articles</h1>';
    ?></h1>
    
    <div class="row">
        
        <?php 
        if(isset($_GET['pageid'])){ //we use it to prevent eror from enter to page without pageid or we can instead it with $catid= isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']): 0;
            
            foreach($allItem as $item){
                echo'<div class="card">';
                    echo'<div class="row no-gutters">';
                        echo '<div class="col-md-4">';
                            echo '<img src="admin/upload/image/' . $item['Image'] . '" class="card-img" alt="...">';
                        echo '</div>';
                        echo '<div class="col-md-8">';
                            echo '<div class="card-body">';
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
        }else{
            echo ' you didnt specify page id';
        }
        ?>
    </div>
</div>

<?php include 'includes/templetes/footer.php';?>