<?php 

    ob_start();

    session_start();

    $pageTitle = 'Items';

    if (isset($_SESSION['Username'])){

        include 'init.php';
        $action = isset($_GET['action'])? $_GET['action'] : 'manage';
        if ($action == 'manage'){
        
            $stmt=$con->prepare("SELECT items.*, category.Name AS category_name, users.Username  FROM items 
                                INNER JOIN category ON category.ID = items.Cat_ID 
                                INNER JOIN users ON users.UserID = items.Member_ID");
            $stmt->execute();
            $items = $stmt->fetchAll();
        
        ?>
            <h1 class="text-center">Manage Articles</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table manage-items table-bordered table text-center">
                        <tr>
                            <td>#Article_ID</td>
                            <td>Title</td>
                            <td>Description</td>
                            <td>Picture</td>
                            <td>Topic</td>
                            <td>Member</td>
                            <td>Date Adding</td>
                            <td>Control</td>
                        </tr>
                        <?php

                            foreach($items as $item){
                                echo "<tr>";
                                    echo "<td>" . $item['Item_ID'] . "</td>";
                                    echo "<td>" . $item['Name'] . "</td>";
                                    echo "<td>" . $item['Description'] . "</td>";
                                    echo "<td>";
                                    if(empty($item['Image'])){
                                        echo "no picture";
                                    }else{
                                    echo "<img src='upload/image/" . $item['Image'] . "'alt=''/>";
                                    }
                                    echo "</td>";
                                    echo "<td>" . $item['category_name'] . "</td>";
                                    echo "<td>" . $item['Username'] . "</td>";
                                    echo "<td>". $item['Add_Date'] . "</td>";
                                    echo '<td>
                                        <a href="items.php?action=edit&itemid='. $item['Item_ID'] . '" class="btn btn-success my-1">Edit</a>
                                        <a href="items.php?action=delete&itemid='. $item['Item_ID'] . '" class="btn confirm btn-danger my-1">Delete</a>';
                                        if ($item['Approve'] == 0 ){
                                            echo ' <a href="items.php?action=approve&itemid='. $item['Item_ID'] . '" class=" btn  btn-info my-1"> approve </a>';
                                        }
                                    echo "</td>";
                                    echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
                <a href="?action=add" class="btn btn-primary my-3"><i class="fa fa-plus"></i> Add new Article</a>
            </div>
       

<?php        }elseif($action == 'add'){?>
            <h1 class="text-center">Add Article</h1>
                <div class="container">
                    <form class="form-horizontal" action="?action=insert" method="POST" enctype="multipart/form-data">
                        <!--start titl field-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Title</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" name="title" placeholder="Title of Article" class="form-control" required="required" />
                                </div>
                            </div>
                        </div>
                        <!--start description field-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Description</label>
                                </div>
                                <div class="col-sm-10">
                                    <textarea type="text" name="description" placeholder="Description of the Article" class="form-control" required="required" ></textarea>
                                </div>
                            </div>
                        </div>
                        <!--start image feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Picture</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="file" name="image" class=" form-control" required="required" >
                                </div>
                            </div>
                        </div>
                        
                        <!--start status feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">status</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option value="0">...</option>
                                        <option value="1">&#xf005; &#xf005; &#xf005; &#xf005; &#xf005;</option>
                                        <option value="2">&#xf005; &#xf005; &#xf005; &#xf005;</option>
                                        <option value="3">&#xf005; &#xf005; &#xf005;</option>
                                        <option value="4">&#xf005; &#xf005;</option>
                                        <option value="5">&#xf005;</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--start member feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Member</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="member">
                                        <option value="0">...</option>
                                        <?php 
                                          $stmt = $con ->prepare("SELECT * FROM users");
                                          $stmt->execute();
                                          $users = $stmt ->fetchAll();
                                          foreach($users as $user){
                                              echo '<option value="'.$user["UserID"].'">'.$user["Username"].'</option>';
                                          }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--start category feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Topic belongs</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="category">
                                        <option value="0">...</option>
                                        <?php 
                                          $allCats = getAllForm("*" , "category" , "" , "" , "ID" , "ASC");
                                          foreach($allCats as $cat){
                                              echo '<option value="'.$cat["ID"].'">'.$cat["Name"].'</option>';
                                          }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>              
                        <!--start button-->
                        <div class="form-group">
                            <div class="col-sm-10 ml-auto">
                                <input type="submit" name="save" value="Add Article" class="btn btn-primary px-4">
                            </div>
                        </div>
                    </form>
                </div>
       


 <?php  }elseif($action == 'insert'){
        
            if($_SERVER['REQUEST_METHOD']== 'POST'){
                echo '<h1 class="text-center">ADD Article</h1>';
                echo "<div class='container'>";

                $imageName = $_FILES['image']['name'];
                $imageSize = $_FILES['image']['size'];
                $imageTmp = $_FILES['image']['tmp_name'];
                $imageType = $_FILES['image']['type'];
                // securty to identify the kinds of the pic 
                $allowExtention = array("jpeg" , "jpg" , "png" , "gif");

                $imageExtention1 = explode('.',$imageName);
                $imageExtention2 = end($imageExtention1);
                $imageExtention = strtolower($imageExtention2);

                $name  =$_POST['title'];
                $desc  =$_POST['description'];
                $status  =$_POST['status'];
                $member  =$_POST['member'];
                $category  =$_POST['category'];
                

                


                //validate the form by php

                $formErrors = array();
                if(empty($name)){
                    $formErrors[]= '<div class="alert alert-danger"> name cant be <strong>empty</strong></div>';
                }
                if(empty($desc)){
                   $formErrors[]= '<div class="alert alert-danger"> description cant be <strong>empty</strong></div>';
               }
                
                if($status == 0){
                    $formErrors[]= '<div class="alert alert-danger">status cant be <strong> zero</strong></div>';
                }
                if(($member ==0)){
                    $formErrors[]= '<div class="alert alert-danger"> member cant be <strong>empty</strong></div>';
                }
                if($category == 0){
                    $formErrors[]= '<div class="alert alert-danger">Topic cant be <strong> empty </strong></div>';
                }
                if(! in_array( $imageExtention ,$allowExtention)){
                    $formErrors[]= '<div class="alert alert-danger"> this extention not found</div>';

                 }
                 if(empty($imageName)){
                    $formErrors[]= '<div class="alert alert-danger"> folder img cant be <strong>empty</strong></div>';
                 }
                 if($imageSize > 4194304){
                    $formErrors[]= '<div class="alert alert-danger"> the picture is very big</div>';
                 }

                foreach($formErrors as $error){
                    echo $error ;
                }

                if (empty($formErrors)){ 

                    $image= rand(0 , 10000000).'_'.$imageName;
                    move_uploaded_file($imageTmp , "upload\image\\".$image);

                   $check = checkItems("Name", "items" , $name);

                   if ($check ==1){
                       echo 'sorry this user was exist ';
                   }else{
                       // insert new userinfo
                       $stmt = $con->prepare("INSERT INTO 
                                               items(Name, Description ,Status,Member_ID, Cat_ID, Add_Date ,Image)
                                               VALUES(:zname, :zdesc,:zstatus ,:zmember,:zcategory,now() , :zimage)");
                                               //here when admin add member the RegStatus=1 but the default is 0
                       $stmt->execute(array(
                           'zname' => $name,
                           'zdesc' => $desc,
                           'zstatus' => $status,
                           'zmember' => $member,
                           'zcategory' => $category,
                           'zimage' => $image,
                       ));
                       echo '<div class="container text-center">';
                       $msg = '<div class="alert alert-success">You Insert the new Article</div>';
                       redirectHome($msg,5);
                       echo '</div>';
                   }
                }
             
            }else{
                echo '<div class="container text-center">';
                       $msg = '<div class="alert alert-danger">sorry you cant browse this page directly</div>';
                       redirectHome($msg,5);
                       echo '</div>';                
             }

            echo "</div>";

        }elseif($action == 'edit'){

            $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']): 0;
            // select all data depened on this ID

            $stmt = $con->prepare("SELECT
                                     * 
                               FROM 
                                     items 
                               WHERE 
                                     Item_ID=? 
                               
                               LIMIT 1");
            //from main form from user
            $stmt->execute(array($itemid));
            $item = $stmt->fetch();
            // if rowcount is one so the id is found < if the rowacount is zero so id is not found.
            $count = $stmt->rowCount();
            
            //check the database record about username

            if($count > 0){

            ?>
                <h1 class="text-center">Edit Article</h1>
                <div class="container">
                <form class="form-horizontal" action="?action=update" method="POST">
                <input type="hidden" name="itemid" value="<?php echo $itemid ?>"/>
                        <!--start name feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Title</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $item['Name'] ?>" name="title" placeholder="Title of Article" class="form-control" required="required" />
                                </div>
                            </div>
                        </div>
                        <!--startdescription feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Description</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $item['Description'] ?>" name="description" placeholder="Description of the Article" class="form-control" required="required" />
                                </div>
                            </div>
                        </div>
                        <!--start status feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">status</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option value="0" >...</option>
                                        <option value="1" <?php if($item['Status']== 1){ echo 'selected';} ?> >&#xf005; &#xf005; &#xf005; &#xf005; &#xf005; </option>
                                        <option value="2" <?php if($item['Status']== 2){ echo 'selected';} ?> >&#xf005; &#xf005; &#xf005; &#xf005;</option>
                                        <option value="3" <?php if($item['Status']== 3){ echo 'selected';} ?> >&#xf005; &#xf005; &#xf005;</option>
                                        <option value="4" <?php if($item['Status']== 4){ echo 'selected';} ?> >&#xf005; &#xf005;</option>
                                        <option value="5" <?php if($item['Status']== 5){ echo 'selected';} ?> >&#xf005;</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--start member feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Member</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" value="<?php echo $row['status'] ?>" name="member">
                                        <option value="0">...</option>
                                        <?php 
                                          $stmt = $con ->prepare("SELECT * FROM users");
                                          $stmt->execute();
                                          $users = $stmt ->fetchAll();
                                          foreach($users as $user){
                                              echo '<option value="'.$user["UserID"].'"';
                                              if($item['Member_ID'] == $user["UserID"]){echo'selected';}
                                              echo '>'.$user["Username"].'</option>';
                                          }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--start category feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Topic</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="category">
                                        <option value="0">...</option>
                                        <?php 
                                          $stmt2 = $con ->prepare("SELECT * FROM category");
                                          $stmt2 -> execute();
                                          $cats = $stmt2 ->fetchAll();
                                          foreach($cats as $cat){
                                              echo '<option value="'.$cat["ID"].'"';
                                              if($item['Cat_ID'] == $cat["ID"]){echo'selected';}
                                              echo '>'.$cat["Name"].'</option>';
                                          }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!--start button-->
                        <div class="form-group">
                            <div class="col-sm-10 ml-auto">
                                <input type="submit" name="save" value="Update Article" class="btn btn-primary px-4">
                            </div>
                        </div>
                    </form>

                    <?php
                    $stmt=$con->prepare("SELECT comments.*,users.Username AS member FROM comments 
                                        INNER JOIN users ON users.UserID = comments.User_id  
                                        WHERE Item_id =?");
                    $stmt->execute(array($itemid));
                    $rows = $stmt->fetchAll();

                    ?>
                    <h1 class="text-center">Article <?php echo $item['Name']; ?>'s Comments</h1>
                        <div class="table-responsive">
                            <table class="main-table table-bordered table text-center">
                                <tr>
                                    <td>Comment</td>
                                    <td>User Name</td>
                                    <td>Added Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php

                                    foreach($rows as $row){
                                        echo "<tr>";
                                            echo "<td>" . $row['Comment'] . "</td>";
                                            echo "<td>" . $row['member'] . "</td>";
                                            echo "<td>". $row['Comment_Date'] . "</td>";
                                            echo '<td>
                                                <a href="comments.php?action=edit&comid='. $row['C_ID'] . '" class="btn btn-success my-1">Edit</a>
                                                <a href="comments.php?action=delete&comid='. $row['C_ID'] . '" class="btn confirm btn-danger my-1">Delete</a>';

                                                if ($row['status'] == 0 ){
                                                    echo ' <a href="comments.php?action=approve&comid='. $row['C_ID'] . '" class=" btn  btn-info my-1"> approve </a>';
                                                }
                                            echo "</td>";
                                            echo "</tr>";
                                    }
                                ?>
                            </table>
                        </div>
                </div>
                
<?php
            }else{
                // if th ID not found
                echo 'there is no ID';
            }
            
        }elseif($action == 'update'){

            if($_SERVER['REQUEST_METHOD']== 'POST'){
                echo '<h1 class="text-center">UPDATE Article</h1>';
                echo "<div class='container'>";

                $id       =$_POST['itemid'];
                $name     =$_POST['title'];
                $desc     =$_POST['description'];
                $status   =$_POST['status'];
                $member   =$_POST['member'];
                $category =$_POST['category'];
                //validate the form by php

                $formErrors = array();
                if(empty($name)){
                    $formErrors[]= '<div class="alert alert-danger"> Title cant be <strong>empty</strong></div>';
                }
                if(empty($desc)){
                   $formErrors[]= '<div class="alert alert-danger"> description cant be <strong>empty</strong></div>';
               }
                if($status == 0){
                    $formErrors[]= '<div class="alert alert-danger">status cant be <strong> zero</strong></div>';
                }
                if(($member ==0)){
                    $formErrors[]= '<div class="alert alert-danger"> member cant be <strong>empty</strong></div>';
                }
                if($category == 0){
                    $formErrors[]= '<div class="alert alert-danger">Topic cant be <strong> zero </strong></div>';
                }

                foreach($formErrors as $error){
                    echo $error ;
                }

                if (empty($formErrors)){ 

                    $stmt=$con->prepare("UPDATE items SET Name=?, Description=? , Status=? , Member_ID=? ,Cat_ID=? WHERE Item_ID=? ");
                    $stmt->execute(array($name,$desc,$status,$member,$category ,$id ));


                    echo '<div class="container text-center">';
                       $msg = '<div class="alert alert-success">You updet the Article</div>';
                       redirectHome($msg ,5);
                       echo '</div>';

                }
            }else{
                echo '<div class="container text-center">';
                       $msg = '<div class="alert alert-danger">sorry you cant browse this page directly</div>';
                       redirectHome($msg,5);
                echo '</div>';  
               
            }

            echo "</div>";


        }elseif($action == 'delete'){

            echo '<h1 class="text-center">Delete Article</h1>';
                echo "<div class='container'>"; 

            $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']): 0;
            
            // select all data depened on this ID

            $check= checkItems('Item_ID','items',$itemid);

            //check the database record about username

            if($check > 0){
                $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zitem");
                $stmt->bindParam(":zitem", $itemid);
                $stmt->execute();

                echo '<div class="container text-center">';
                 $msg = '<div class="alert alert-success">You delete This Article</div>';
                 redirectHome($msg,5);
                 echo '</div>'; 

            }else{
                
                echo ' this ID is not found';
            }

        }elseif($action == 'approve'){
            echo '<h1 class="text-center">Approve the  Article</h1>';
             echo "<div class='container'>";
            $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']): 0;
             // select all data depened on this ID

             $check= checkItems('Item_ID','items',$itemid);
             
             //check the database record about username
 
             if($check > 0){
                 $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID=?");
                 $stmt->execute(array($itemid));

                 echo '<div class="container text-center">';
                 $msg = '<div class="alert alert-success">You Approve This Article</div>';
                 redirectHome($msg,5);
                 echo '</div>'; 

                  
             }else{
                 echo ' this ID is not found';
             }
        }
        include 'includes/templetes/footer.php';
    }else{
        header('location: index.php');
        exit();
    }





?>