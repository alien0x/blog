<?php 
    ob_start();
    session_start();
    $pageTitle = 'show items';
    include 'init.php';
    
    $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']): 0;
            // select all data depened on this ID

            $stmt = $con->prepare("SELECT 
                                    items.*,
                                    category.Name AS category_name,
                                    users.Username 
                               FROM 
                                     items 
                               INNER JOIN
                                     category
                               ON
                                     category.ID = items.Cat_ID
                                INNER JOIN
                                     users
                                ON
                                    users.UserID = items.Member_ID
                                WHERE 
                                     Item_ID=? 
                                And
                                     Approve= 1");
            //from main form from user
            $stmt->execute(array($itemid));
            // if rowcount is one so the id is found < if the rowacount is zero so id is not found.
            $count = $stmt->rowCount();

            if ($count > 0){
                $item = $stmt->fetch();
?>
<div class="container item-in my-5">
    <div class="row ">
        <div class="col-lg-3">
            <img class="fluid-img img-card center-block" src="admin/upload/image/<?php echo $item['Image'] ?>" alt="">
        </div>
        <div class="col-lg-9 item-info">            
            <ul class="list-unstyled my-5">
                <li><span> Title : </span><?php echo $item['Name']?></li>
                <li><span><i class="fa fa-calendar"></i> Date : </span><?php echo $item['Add_Date']?></li>
                <li><span>Topic : </span><a class="topic" href="category.php?pageid=<?php echo $item['Cat_ID']?>&pagename=<?php echo str_replace(' ' , '-' ,$item['category_name'])?>"> <?php echo $item['category_name']?></a></li>
                <li><span><i class="fa fa-user"></i> Add By : </span><a href="#"> <?php echo $item['Username']?></a></li>
                </li>
                <p><?php echo $item['Description']?></p>

            </ul>
        </div>
    </div>
    <?php if (isset($_SESSION['user'])){ ?>
    <div class="row">
        <div class="col-md-offset-3">
            <div class="add-comment">
                <h3> Comment</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' .$item['Item_ID'] ?>" method="POST" >
                    <textarea name="comment" required></textarea>
                    <input class="btn" type="submit" value="Add">
            </div>
            </form>
            <?php 
            
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $comment =filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                    $itemid = $item['Item_ID'];
                    $userid = $_SESSION['uid'];

                    if (!empty($comment)){

                        $stmt = $con ->prepare("INSERT INTO comments(Comment , status , Comment_Date , Item_id , User_id)
                                                VALUES(:zcomment , 0 , now() , :zitemid , :zuserid) ");
                        $stmt ->execute(array(
                            'zcomment' => $comment,
                            'zitemid'  => $itemid,
                            'zuserid'  => $userid
                        ));
                        if($stmt){
                            echo '<div class="alert text-center alert-success my-3">comment added</div>';
                        }
                    }else{
                        echo '<div class="alert text-center alert-danger">you have to add comment</div>';

                    }
                }
            
            ?>
        </div>
    </div>
    <?php
    }else{
     echo '<a href="login.php"> login  </a> or <a href="login.php">  register </a> before can comment'; 
     }?>
    <hr class="custom my-5">

    <?php 
             $stmt=$con->prepare("SELECT comments.*,  users.Username AS member , users.Avatar AS photo FROM comments 
             INNER JOIN users ON users.UserID = comments.User_id 
             WHERE Item_id=?  
            ORDER BY C_ID DESC ");
                $stmt->execute(array($item['Item_ID']));
                $rows = $stmt->fetchAll();
  
    
    foreach($rows as $comment){?>
                <div class="comment-box">
                    <div class="row">
                        <div class="col-sm-2 text-center">
                        <img class="img-fluid img-card center-block rounded-circle" src="admin/upload/avatar/<?php 
                        if(empty($comment['photo'])){
                            echo "photo1.png" ;
                        }else{
                            echo $comment['photo'];
                        }
                        ?>

                        " alt="">
                        <h6><?php echo $comment['member'] ;?></h6>
                        
                        </div>
                        <div class="col-sm-10">
                        <p class="lead"><?php echo$comment['Comment']; ?></p>
                        </div>
                    </div>
                </div>

                <?php } ?>

            </div>
      
<?php 
            }else{
                echo '<div class="aleert text-center alert-danger">there \'s no such id or this item not approval</div>';
            }
include 'includes/templetes/footer.php';
    ob_end_flush(); 
?>
