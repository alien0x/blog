<?php

/*manage comments page:


*/

session_start();
    if (isset($_SESSION['Username'])){
        
        include 'init.php';

        $action = isset($_GET['action'])? $_GET['action'] : 'manage';

        if ($action == 'manage'){ // comments page

            $stmt=$con->prepare("SELECT comments.*, items.Name AS Item_name, users.Username AS member FROM comments 
                                INNER JOIN items ON items.Item_ID = comments.Item_id 
                                INNER JOIN users ON users.UserID = comments.User_id ");
            $stmt->execute();
            $rows = $stmt->fetchAll();
        
        ?>
            <h1 class="text-center">Manage Comments</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table table-bordered table text-center">
                        <tr>
                            <td>ID</td>
                            <td>Comment</td>
                            <td>Article's title</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Control</td>
                        </tr>
                        <?php

                            foreach($rows as $row){
                                echo "<tr>";
                                    echo "<td>" . $row['C_ID'] . "</td>";
                                    echo "<td>" . $row['Comment'] . "</td>";
                                    echo "<td>" . $row['Item_name'] . "</td>";
                                    echo "<td>" . $row['member'] . "</td>";
                                    echo "<td>". $row['Comment_Date'] . "</td>";
                                    echo '<td>
                                        <a href="comments.php?action=edit&comid='. $row['C_ID'] . '" class="btn btn-success my-1">Edit</a>
                                        <a href="comments.php?action=delete&comid='. $row['C_ID'] . '" class="btn confirm btn-danger my-1">Delete</a>';

                                        if ($row['status'] == 0 ){
                                            echo ' <a href="comments.php?action=approve&comid='. $row['C_ID'] . '" class=" btn  btn-info my-1 "> approve </a>';
                                        }
                                    echo "</td>";
                                    echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>        
<?php       }elseif($action == 'edit'){ 
            //check the request userid is integer
            
            $comid= isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']): 0;
            // select all data depened on this ID

            $stmt = $con->prepare("SELECT
                                     * 
                               FROM 
                                     comments 
                               WHERE 
                                     C_ID=? 
                               
                               LIMIT 1");
            //from main form from user
            $stmt->execute(array($comid));
            $row = $stmt->fetch();
            // if rowcount is one so the id is found < if the rowacount is zero so id is not found.
            $count = $stmt->rowCount();
            
            //check the database record about username

            if($count > 0){

            ?>

                <h1 class="text-center">Edit comment</h1>
                <div class="container">
                    <form class="form-horizontal" action="?action=update" method="POST">
                        <!--start username feild-->
                        <input type="hidden" name="comid" value="<?php echo $comid ?>"/>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">comment</label>
                                </div>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="comment"><?php echo $row['Comment'];?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!--start button-->
                        <div class="form-group">
                            <div class="col-sm-10 ml-auto">
                                <input type="submit" value="Update" name="save" class="btn btn-primary px-4">
                            </div>
                        </div>
                    </form>
                </div>
<?php
            }else{
                // if th ID not found
                echo 'there is no ID';
            }
        }elseif($action == 'update'){
            echo '<h1 class="text-center">UPDATE Comment</h1>';
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD']== 'POST'){

                $id    =$_POST['comid'];
                $comment  =$_POST['comment'];
                
                //validate the form by php

                $formErrors = array();
                if(empty($comment)){
                    $formErrors[]= '<div class="alert alert-danger"> comment cant be <strong>empty</strong></div>';
                }
                
                foreach($formErrors as $error){
                    echo $error ;
                }

                if (empty($formErrors)){

                    $stmt=$con->prepare("UPDATE comments SET Comment=? WHERE C_ID=? ");
                    $stmt->execute(array($comment,$id ));
                    echo '<div class="container text-center">';
                        $msg = '<div class="alert alert-success">You Updated the comment</div>';
                        redirectHome($msg,5);
                        echo '</div>'; 

                }
            }else{
                $msg = 'sorry you cant browse this page';
                 redirectHome($msg ,5);
               
            }

            echo "</div>";


        }elseif($action =="delete"){
            echo '<h1 class="text-center">Delete the Comment</h1>';
            echo "<div class='container'>";
            //check the request userid is integer
            
            $comid= isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']): 0;
            // select all data depened on this ID

            $check= checkItems('C_ID','comments',$comid);
            //check the database record about username

            if($check > 0){
                $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zcomment");
                $stmt->bindParam(":zcomment", $comid);
                $stmt->execute();
                echo '<div class="container text-center">';
                        $msg = '<div class="alert alert-success">You Deleted comment</div>';
                        redirectHome($msg,5);
                        echo '</div>'; 

            }else{
                echo ' this ID is not found';
            }


        }elseif($action =='approve'){
            echo '<h1 class="text-center">Approve Comment</h1>';
            echo "<div class='container'>";
             //check the request userid is integer
            
             $comid= isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']): 0;
             // select all data depened on this ID

             $check= checkItems('C_ID','comments',$comid);
             
             //check the database record about username
 
             if($check > 0){
                 $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE C_ID=?");
                 $stmt->execute(array($comid));
                 echo '<div class="container text-center">';
                 $msg = '<div class="alert alert-success">You approve comment</div>';
                 redirectHome($msg,5);
                 echo '</div>';  
             }else{
                 echo ' this ID is not found';
             }
        }
    


        include 'includes/templetes/footer.php';

    }else{
        header('ocation:dashboard.php');
        exit();
    }