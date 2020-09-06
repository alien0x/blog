<?php 

ob_start();

session_start();

$pageTitle = 'Categories';

if(isset($_SESSION['Username'])){
    
    include 'init.php';

    $action = isset($_GET['action'])? $_GET['action'] : 'manage';

    if($action == 'manage'){
        $sort = 'ASC';
        $sort_array = array('ASC' , 'DESC');

        if (isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array)){
            $sort = $_GET['sort'] ;
        }

        $stmt2 = $con -> prepare("SELECT * FROM category ORDER BY Ordering $sort");
        $stmt2  -> execute();
        $cats = $stmt2 -> fetchAll();?>

        
        <h1 class="text-center">Manage Topics</h1>
        <div class="container categories">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                        Manage Topics
                            <div class="ordering pull-right">
                                Ordering:
                            <a class="<?php if ($sort == 'ASC'){ echo 'active';} ?>" href="category.php?action=manage&sort=ASC">ASC </a>::
                            <a class="<?php if ($sort == 'DESC'){ echo 'active';} ?>" href="category.php?action=manage&sort=DESC"> DESC</a>
                            &nbsp;
                                <-->
                            &nbsp; View:
                            <a class=" second active" >full body </a>::
                            <a class="first" > classic</a>
                            </div>
                        </div>
                        <div class="card-body">
                        <?php 

                            foreach($cats as $cat){

                                echo "<div class='cat'>";

                                    echo "<div class='hidden-button'>";
                                        echo "<a href='category.php?action=edit&catid=".$cat['ID']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                        echo "<a href='category.php?action=delete&catid=".$cat['ID']."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                                        echo "</div>";
                                    echo "<h3>- " . $cat['Name'] . "</h3>";
                                    echo "<div class='full-view'> ";
                                        echo "<p> <span> Description :</span> " ;if ( $cat['Description'] == ''){
                                            echo "This category has no description";
                                        }else{
                                            echo $cat['Description'];
                                        } echo "</p>";
                                        if ($cat['Visibility'] == 1){
                                            echo "<span class='visibility'> Hidden</span>";
                                        }
                                        if ($cat['Allow_Comment'] == 1){
                                            echo "<span class='commenting'> Commenting Disabled</span>";
                                        }
                                      
                                    echo "</div>";
                                echo "</div>";
                                
                                echo "<hr>";
                            }
                        
                        ?>
                        </div>
                    </div>
                    <a href="category.php?action=add" class="btn btn-primary my-3"><i class="fa fa-plus fa-1x"></i>  Add New Topics</a>
                </div>
            </div>
        </div>
       


<?php 

    }elseif($action == 'add'){?>

        <h1 class="text-center">Add New Topics</h1>
                <div class="container">
                <form class="form-horizontal" action="?action=insert" method="POST">
                        <!--start username feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Name</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" name="name" placeholder="Name Of Topics" class="form-control" required="required" />
                                </div>
                            </div>
                        </div>
                        <!--start description feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Description</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" name="description" placeholder="Descrip the topic" class=" form-control"  >
                                    
                                </div>
                            </div>
                        </div>
                        <!--start visible feild-->
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">visible</label>
                                </div>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="vis-yes" type="radio" name="visibility" value="0" checked/>
                                        <label for="vis-yes">yes</label>
                                    </div>
                                    <div>
                                        <input id="vis-no" type="radio" name="visibility" value="1" />
                                        <label for="vis-no">no</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--start commenting feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Allow commenting</label>
                                </div>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="com-yes" type="radio" name="commenting" value="0" checked/>
                                        <label for="com-yes">yes</label>
                                    </div>
                                    <div>
                                        <input  id="com-no" type="radio" name="commenting" value="1" />
                                        <label for="com-no">no</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--start button-->
                        <div class="form-group">
                            <div class="col-sm-10 ml-auto">
                                <input type="submit" name="save" value="Add Topics" class="btn btn-primary px-4">
                            </div>
                        </div>
                    </form>
                </div>
       

<?php
    }elseif($action == 'insert'){

            
 
             if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<h1 class="text-center">InsertTopic</h1>';
                echo "<div class='container'>";
 
                 $name  =$_POST['name'];
                 $des  =$_POST['description'];
                 $visible  =$_POST['visibility'];
                 $comment =$_POST['commenting'];
 
                 //validate the form by php
 
                

                $check = checkItems("Name", "category" , $name);

                if ($check == 1){
                    echo '<div class="alert alert-danger"> sorry , this name of category was exit .</div>';
                }
                else{
                    // insert new userinfo
                    $stmt = $con->prepare("INSERT INTO 
                                            category(Name , Description ,Visibility ,Allow_Comment)
                                            VALUES(:zname, :zdes , :zvisible ,:zcomment)");
                                            //here when admin add member the RegStatus=1 but the default is 0
                    $stmt->execute(array(
                        'zname' => $name,
                        'zdes' => $des,
                        'zvisible' => $visible,
                        'zcomment' => $comment,
                    ));
                    echo '<div class="container text-center">';
                    $msg = '<div class="alert alert-success"> You insert your new Topic </div>';
                    redirectHome($msg,5);
                    echo '</div>';
                }
               
             }else{
                 $msg = 'sorry you cant browse this page';
                 redirectHome($msg ,5);
             }
 
             echo "</div>";
 
 
        
        
    }elseif($action == 'edit'){
        $catid= isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']): 0;
            // select all data depened on this ID

            $stmt = $con->prepare("SELECT
                                     * 
                               FROM 
                                     category 
                               WHERE 
                                     ID=? 
                               ");
            //from main form from user
            $stmt->execute(array($catid));

            $cat = $stmt->fetch();
            // if rowcount is one so the id is found < if the rowacount is zero so id is not found.
            $count = $stmt->rowCount();
            
            //check the database record about username

            if($count > 0){

            ?>

                <h1 class="text-center">Edit Topic</h1>
                    <div class="container">
                    <form class="form-horizontal" action="?action=update" method="POST">
                    <input type="hidden" name="catid" value="<?php echo $catid ?>"/>
                            <!--start username feild-->
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="control-label">Name</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" placeholder="Name Of Topics" class="form-control" required="required" value= "<?php echo $cat['Name'] ;?>"/>
                                    </div>
                                </div>
                            </div>
                            <!--start description feild-->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="control-label">Description</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" name="description" placeholder="Descrip the Topic" class=" form-control" value= "<?php echo $cat['Description'] ;?>" >
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <!--start visible feild-->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="control-label">visible</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div>
                                            <input id="vis-yes" type="radio" name="visibility" value="0" <?php if ( $cat['Visibility'] == 0 ){ echo 'checked' ; }?>/>
                                            <label for="vis-yes">yes</label>
                                        </div>
                                        <div>
                                            <input id="vis-no" type="radio" name="visibility" value="1" <?php if ( $cat['Visibility'] == 1 ){ echo 'checked' ; }?>/>
                                            <label for="vis-no">no</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--start commenting feild-->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="control-label">Allow commenting</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div>
                                            <input id="com-yes" type="radio" name="commenting" value="0" <?php if ( $cat['Allow_Comment'] == 0 ){ echo 'checked' ; }?>/>
                                            <label for="com-yes">yes</label>
                                        </div>
                                        <div>
                                            <input  id="com-no" type="radio" name="commenting" value="1" <?php if ( $cat['Allow_Comment'] == 1 ){ echo 'checked' ; }?>/>
                                            <label for="com-no">no</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--start button-->
                            <div class="form-group">
                                <div class="col-sm-10 ml-auto">
                                    <input type="submit" name="save" value="update Topic" class="btn btn-primary px-4">
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
            }else{
                // if th ID not found
                echo '<div class="container text-center">';
                    $msg = '<div class="alert alert-danger">there is no ID</div>';
                    redirectHome($msg,5);
                echo '</div>';
            }
    }elseif($action == 'update'){


            if($_SERVER['REQUEST_METHOD']== 'POST'){
                echo '<h1 class="text-center">UPDATE Topic</h1>';
                echo "<div class='container'>";
                
                 $id = $_POST['catid'];
                 $name  =$_POST['name'];
                 $des  =$_POST['description'];
                 $visible  =$_POST['visibility'];
                 $comment =$_POST['commenting'];


                
                    $stmt=$con->prepare("UPDATE category SET Name=?, Description=?,Visibility =? , Allow_Comment=? WHERE ID=? ");
                    $stmt->execute(array($name,$des,$visible,$comment,$id ));
    
                    echo '<div class="container text-center">';
                    $msg = '<div class="alert alert-success"> You update your Topic Info </div>';
                    redirectHome($msg,5);
                    echo '</div>';

                
            }else{
                echo '<div class="container text-center">';
                $msg = '<div class="alert alert-danger">sorry you cant browse this page</div>';
                redirectHome($msg,5);
                echo '</div>';
               
            }

            echo "</div>";

    }elseif($action == 'delete'){
        echo '<h1 class="text-center">Delete Topic</h1>';
        echo "<div class='container'>";

        $catid= isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']): 0;
        // select all data depened on this ID
        $check= checkItems('ID','category',$catid);
        //check the database record about username

        if($check > 0){
            $stmt = $con->prepare("DELETE FROM category WHERE ID = :zcatid");
            $stmt->bindParam(":zcatid", $catid);
            $stmt->execute();
            echo '<div class="container text-center">';
                    $msg = '<div class="alert alert-success">You delete This Topic </div>';
                    redirectHome($msg,5);
                    echo '</div>';

        }else{
            echo '<div class="container text-center">';
            $msg = '<div class="alert alert-danger">there is no ID</div>';
            redirectHome($msg,5);
            echo '</div>';
        }
      echo '</div>';
    }

    include 'includes/templetes/footer.php';


}else{
    header('Location:index.php');
    exit();
}

ob_end_flush();





?>