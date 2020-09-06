<?php 
    ob_start();
    session_start();
    $pageTitle = ' New add';

    include 'init.php';
    if (isset($_SESSION['user'])){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $formerrors = array();

            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageType = $_FILES['image']['type'];
            // securty to identify the kinds of the pic 
            $allowExtention = array("jpeg" , "jpg" , "png" , "gif");

            $imageExtention1 = explode('.',$imageName);
            $imageExtention2 = end($imageExtention1);
            $imageExtention = strtolower($imageExtention2);


            $name     = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $desc     = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $status   = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
            $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
            

            if(strlen($name) <4){
                $formErrors[] = ' item title must be more than 4 characters';
            }
            if(strlen($desc) <5){
                $formErrors[] = ' item description must be more than 5 characters';
            }
            
            if(empty($status) ){
                $formErrors[] = ' status dont alloW be empty';
            }
            if(empty($category)){
                $formErrors[] = ' category dont alloW be empty';
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

            if(empty($formErrors)){ 
                
                    $image= rand(0 , 10000000).'_'.$imageName;
                    move_uploaded_file($imageTmp , "admin\upload\image\\".$image);

                   $check = checkItems("Name", "items" , $name);
                   if($check ==1){
                    echo  '<div class="alert alert-danger">sorry this user was exist </div>';
                    
                    }else{

                    // insert new userinfo
                    $stmt = $con->prepare("INSERT INTO 
                                            items(Name, Description, Status ,Member_ID, Cat_ID, Add_Date ,Image)
                                            VALUES(:zname, :zdesc,:zstatus ,:zmember,:zcategory,now(),:zimage )");
                                            //here when admin add member the RegStatus=1 but the default is 0
                    $stmt->execute(array(
                        'zname'   => $name,
                        'zdesc'   => $desc,
                        'zstatus' => $status,
                        'zmember' => $_SESSION['uid'],
                        'zcategory' => $category,
                        'zimage' => $image,
                        
                    ));
                    
                    $smsg = 'succesed ';
                }
                
             }  
        }
?>



<div class="create-add block">
    <h1 class="text-center">- New Article -</h1>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Form of a New Article
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?> " method="POST" enctype="multipart/form-data">
                                <!--start titl field-->
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label class="control-label">Title</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" name="title" placeholder="Title of Article" class="form-control " required="required" />
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
                                            <textarea type="text" name="description" placeholder="Description of the Article" class="form-control " required="required" ></textarea>
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
                                            <input type="file" name="image" class=" form-control " required="required" >
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
                                        <input type="submit" name="save" value="Add Article" class="btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                   
                </div>
                <?php 
                    if(!empty($formErrors)){
                        foreach($formErrors as $error){
                            echo '<div class="alert alert-danger" >'. $error.'</div>';
                        }
                    }
                    if (isset($smsg)){
                        echo '<div class="alert alert-success">'.$smsg .'</div>';
                    }
                
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    }else{
        header('location:login.php');
        exit();
    }
    include 'includes/templetes/footer.php';
    ob_end_flush(); 

?>