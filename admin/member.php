<?php

/*manage members page:

for add | edit |delete members

*/

session_start();
    if (isset($_SESSION['Username'])){
        
        include 'init.php';

        $action = isset($_GET['action'])? $_GET['action'] : '';

        if ($action == 'manage'){ // manage page

            $query = '';
            if(isset($_GET['page']) && $_GET['page'] == 'pending'){
                $query = ' AND RegStatus = 0';
            }

            $stmt=$con->prepare("SELECT * FROM users WHERE GroupID !=1 $query ");
            $stmt->execute();
            $rows = $stmt->fetchAll();
        
        ?>
            <h1 class="text-center">Manage Members</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table manage-member table-bordered table text-center">
                        <tr>
                            <td>#ID</td>
                            <td>Avatar</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Full Name</td>
                            <td>Registerd Date</td>
                            <td>Control</td>
                        </tr>
                        <?php

                            foreach($rows as $row){
                                echo "<tr>";
                                    echo "<td>" . $row['UserID'] . "</td>";
                                    echo "<td>";
                                    if(empty($row['Avatar'])){
                                        echo "no picture";
                                    }else{
                                    echo "<img src='upload/avatar/" . $row['Avatar'] . "'alt=''/>";
                                    }
                                    echo "</td>";
                                    echo "<td>" . $row['Username'] . "</td>";
                                    echo "<td>" . $row['Email'] . "</td>";
                                    echo "<td>" . $row['FullName'] . "</td>";
                                    echo "<td>". $row['Date'] . "</td>";
                                    echo '<td>
                                        <a  href="member.php?action=edit&userid='. $row['UserID'] . '" class="btn btn-success my-1">Edit</a>
                                        <a  href="member.php?action=delete&userid='. $row['UserID'] . '" class="btn confirm btn-danger my-1">Delete</a>';

                                        if ($row['RegStatus'] == 0 ){
                                            echo ' <a  href="member.php?action=activate&userid='. $row['UserID'] . '" class=" btn  btn-info my-1"> activate </a>';
                                        }
                                    echo "</td>";
                                    echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
                <a href="?action=add" class="btn btn-primary my-3"><i class="fa fa-plus"></i> Add new Member</a>
            </div>
       
            
<?php   }elseif($action == 'add' ){ ?>

                <h1 class="text-center">Add Member</h1>
                <div class="container">
                <form class="form-horizontal" action="?action=insert" method="POST" enctype="multipart/form-data">
                        <!--start username feild-->
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Username</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" name="username" placeholder="Enter Your Name" class="form-control" required="required" />
                                </div>
                            </div>
                        </div>
                        <!--start avatar feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">User Avatar</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="file" name="avatar" class=" form-control" required="required" >
                                    
                                </div>
                            </div>
                        </div>
                        <!--start avatar feild-->
                        <!--start password feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Password</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="password" name="password" placeholder="Enter Your Password" class="password form-control" required="required" autocomplete="new-password">
                                    <i class="show-pass fa fa-eye "></i>
                                </div>
                            </div>
                        </div>
                        <!--start email feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Email</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="email" name="email" placeholder="Enter Your Email" required="required" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!--start full name feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Full Name</label>
                                </div>
                                <div class="col-sm-10">
                                 <input type="text" name="fullname"  required="required" required="required" placeholder="Enter Your Full Name" class="form-control"> 
                                </div>
                            </div>
                        </div>
                        <!--start button-->
                        <div class="form-group">
                            <div class="col-sm-10 ml-auto">
                                <input type="submit" name="save" class="btn btn-primary px-4">
                            </div>
                        </div>
                    </form>
                </div>
       
 <?php  }elseif($action == 'insert'){
             echo '<h1 class="text-center">ADD MEMBER</h1>';
             echo "<div class='container'>";
 
             if($_SERVER['REQUEST_METHOD']== 'POST'){

                $avatarName = $_FILES['avatar']['name'];
                $avatarSize = $_FILES['avatar']['size'];
                $avatarTmp = $_FILES['avatar']['tmp_name'];
                $avatarType = $_FILES['avatar']['type'];
                // securty to identify the kinds of the pic 
                $allowExtention = array("jpeg" , "jpg" , "png" , "gif");

                $avatarExtention1 = explode('.',$avatarName);
                $avatarExtention2 = end($avatarExtention1);
                $avatarExtention = strtolower($avatarExtention2);


                //get avatar exection 

 
                 $user  =$_POST['username'];
                 $pass  =$_POST['password'];
                 $email =$_POST['email'];
                 $name  =$_POST['fullname'];

                 $hashpass=sha1($pass);
 
 
                 //validate the form by php
 
                 $formErrors = array();
                 if(empty($user)){
                     $formErrors[]= '<div class="alert alert-danger"> user cant be <strong>empty</strong></div>';
                 }
                 if(empty($pass)){
                    $formErrors[]= '<div class="alert alert-danger"> pass cant be <strong>empty</strong></div>';
                }
                 if(strlen($user) < 4){
                     $formErrors[]= '<div class="alert alert-danger"> user cant be less than<strong>4 characters </strong></div>';
                 }
                 if(empty($name)){
                     $formErrors[]= '<div class="alert alert-danger"> name cant be <strong>empty</strong></div>';
                 }
                 if(! in_array( $avatarExtention ,$allowExtention)){
                    $formErrors[]= '<div class="alert alert-danger"> this extention not found</div>';

                 }
                 if(empty($avatarName)){
                    $formErrors[]= '<div class="alert alert-danger"> folder img cant be <strong>empty</strong></div>';
                 }
                 if($avatarSize > 4194304){
                    $formErrors[]= '<div class="alert alert-danger"> the picture is very big</div>';
                 }
                
                 foreach($formErrors as $error){
                     echo $error ;
                 }
 
                 if (empty($formErrors)){ 

                    $avatar = rand(0 , 10000000).'_'.$avatarName;
                    move_uploaded_file($avatarTmp , "upload\avatar\\".$avatar);

                    $check = checkItems("Username", "users" , $user);

                    if ($check ==1){
                        echo 'sorry this user was exist ';
                    }
                    else{
                        // insert new userinfo
                        $stmt = $con->prepare("INSERT INTO 
                                                users(Username, Password, Email, FullName ,RegStatus, Date ,Avatar )
                                                VALUES(:zuser, :zpass, :zmail, :zname ,1,now() , :zavatar)");
                                                //here when admin add member the RegStatus=1 but the default is 0
                        $stmt->execute(array(
                            'zuser' => $user,
                            'zpass' => $hashpass,
                            'zmail' => $email,
                            'zname' => $name,
                            'zavatar' => $avatar
                        ));
                        echo '<div class="container text-center">';
                        $msg = '<div class="alert alert-success">You add a new Member</div>';
                        redirectHome($msg,5);
                        echo '</div>';
                    }
                 }  
             }else{
                 $msg = 'sorry you cant browse this page';
                 redirectHome($msg,5);
             }
 
             echo "</div>";
 
 
        
        }elseif($action == 'edit'){ 
            //check the request userid is integer
            
            $userid= isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0;
            // select all data depened on this ID

            $stmt = $con->prepare("SELECT
                                     * 
                               FROM 
                                     users 
                               WHERE 
                                     UserID=? 
                               
                               LIMIT 1");
            //from main form from user
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            // if rowcount is one so the id is found < if the rowacount is zero so id is not found.
            $count = $stmt->rowCount();
            
            //check the database record about username

            if($count > 0){

            ?>

                <h1 class="text-center">Edit Member</h1>
                <div class="container">
                    <form class="form-horizontal" action="?action=update" method="POST">
                        <!--start username feild-->
                        <input type="hidden" name="userid" value="<?php echo $userid ?>"/>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Username</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" required="required" autocomplete="off"> <!--validate the form by html-->
                                </div>
                            </div>
                        </div>
                        <!--start password feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Password</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
                                    <input type="password" name="newpassword" class="form-control" autocomplete="new-password">

                                </div>
                            </div>
                        </div>
                        <!--start email feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">Email</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="email" name="email"  value="<?php echo $row['Email'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!--start fullname feild-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label class="control-label">full Name</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" name="fullname"  value="<?php echo $row['FullName'] ?>" required="required" class="form-control"> 
                                </div>
                            </div>
                        </div>
                        <!--start button-->
                        <div class="form-group">
                            <div class="col-sm-10 ml-auto">
                                <input type="submit" name="save" class="btn btn-primary px-4">
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
            echo '<h1 class="text-center">UPDATE MEMBER</h1>';
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD']== 'POST'){

                $id    =$_POST['userid'];
                $user  =$_POST['username'];
                $email =$_POST['email'];
                $name  =$_POST['fullname'];

                $pass= empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

                //validate the form by php

                $formErrors = array();
                if(empty($user)){
                    $formErrors[]= '<div class="alert alert-danger"> user cant be <strong>empty</strong></div>';
                }
                if(strlen($user) < 4){
                    $formErrors[]= '<div class="alert alert-danger"> user cant be less than<strong>4 characters </strong></div>';
                }
                if(empty($name)){
                    $formErrors[]= '<div class="alert alert-danger"> name cant be <strong>empty</strong></div>';
                }
                foreach($formErrors as $error){
                    echo $error ;
                }

                if (empty($formErrors)){

                    $stmt2 = $con->prepare("SELECT * FROM users WHERE Username=? AND UserID != ?");
                    $stmt2 -> execute(array($user , $id));
                    $count = $stmt2 -> rowCount();
                    if ($count ==1){
                        echo 'sorry this user is exist';
                    } else{
                        $stmt=$con->prepare("UPDATE users SET Username=?, Email=?, FullName=? , Password=? WHERE UserID=? ");
                        $stmt->execute(array($user,$email,$name,$pass,$id ));
    
                        echo '<div class="container text-center">';
                        $msg = '<div class="alert alert-success">You updated Member info</div>';
                        redirectHome($msg,5);
                        echo '</div>'; 
                    }
                }
            }else{
                $msg = 'sorry you cant browse this page';
                echo "</>";
                 redirectHome($msg ,5);
               
            }

            echo "</div>";


        }elseif($action =="delete"){
            echo '<h1 class="text-center">Delete member</h1>';
            echo "<div class='container'>";

            //check the request userid is integer
            
            $userid= isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0;
            // select all data depened on this ID

            
            $check= checkItems('UserID','users',$userid);
            //check the database record about username

            if($check > 0){
                $stmt = $con->prepare("DELETE FROM users WHERE userID = :zuser");
                $stmt->bindParam(":zuser", $userid);
                $stmt->execute();
                echo '<div class="container text-center">';
                $msg = '<div class="alert alert-danger">You deleted This Member</div>';
                redirectHome($msg,5);
                echo '</div>'; 
            }else{
                echo ' this ID is not found';
            }


        }elseif($action =='activate'){
            echo '<h1 class="text-center">activate member</h1>';
                echo "<div class='container'>";
             //check the request userid is integer
            
             $userid= isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0;
             // select all data depened on this ID

             $check= checkItems('UserID','users',$userid);
             
             //check the database record about username
 
             if($check > 0){
                 $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID=?");
                 $stmt->execute(array($userid));
                 echo '<div class="container my-5 text-center">';
                 $msg = '<div class="alert alert-success">You Activate this Member</div>';
                 redirectHome($msg,5);
                 echo '</div>';  
             }else{
                 echo ' this ID is not found';
             }
        }
    


        include 'includes/templetes/footer.php';

    }else{
        header('location:dashboard.php');
        exit();
    }