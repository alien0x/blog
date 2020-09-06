<?php 
      session_start();
      $noNavbar="";
      $pageTitle="login";

      // if u have seesion already u entre
  
      if (isset($_SESSION['user'])){
          header('Location: index.php');
      }
      include 'init.php';
      
  
      if($_SERVER['REQUEST_METHOD']== 'POST'){

        if(isset($_POST['login'])){
  
            $user   = $_POST['username'];
            $pass   = $_POST['password'];
            $hashedpass = sha1($pass);
        
            //check if the user exist in database or not
            //from database info
            $stmt = $con->prepare("SELECT
                                        UserID , Username , Password 
                                    FROM 
                                        users 
                                    WHERE 
                                        Username=? 
                                    AND 
                                        Password=? 
                                    ");
                                    
            //from main form from user
            $stmt->execute(array($user, $hashedpass));
            $get = $stmt -> fetch();
            $count = $stmt->rowCount();
            
            //check the database record about username
    
            if($count > 0){
                $_SESSION['user'] = $user;
                $_SESSION['uid'] = $get['UserID'];
                header('Location: index.php');
                exit();
            }
        }else{
            $formerrors= array();
            if(isset($_POST['username'])){
                $filterUser = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);
                if($filterUser >3){
                    $formerrors[] = 'username must be more than 3 characters';
                }
            }
            if(isset($_POST['password']) && isset($_POST['password-again'])){
                if(empty($_POST['password'])){
                    $formerrors[] = 'sorry the password is empty';

                }
                $pass1 = sha1($_POST['password']);
                $pass2 = sha1($_POST['password-again']);

                if($pass1 !== $pass2){
                    $formerrors[] = 'sorry the password is not matched';
                }
            }
            if(isset($_POST['email'])){
                $filteremail = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
                if(filter_var($filteremail , FILTER_VALIDATE_EMAIL) != true){
                    $formerrors[] = 'this email is not valid';
                }
            }
            if (empty($formerrors)){ 

                $check1 = checkItems("Username", "users" , $_POST['username']);
                $check2 = checkItems("Email", "users" , $_POST['email']);

                if ($check1 == 1){
                    echo 'sorry this user was exist ';
                }
                elseif($check2 == 1){
                    echo 'sorry this email was exist ';
                }
                else{
                    // insert new userinfo
                    $stmt = $con->prepare("INSERT INTO 
                                            users(Username, Password, Email,RegStatus, Date)
                                            VALUES(:zuser, :zpass, :zmail , 0 ,now())");
                                            //here when admin add member the RegStatus=1 but the default is 0
                    $stmt->execute(array(
                        'zuser' => $_POST['username'],
                        'zpass' => $_POST['password'],
                        'zmail' => $_POST['email']
                    ));
                    
                    $successMsg = 'congrats u are now registerd user';
                }
             }  

        }
      }
?>
<!-- we have to make validate or check in front:html and back:php -->
    <div class="container login-page">
        <div class="text-center">
            <h1 class="my-3">
                <span data-class="login" class="active">Login</span> | <span data-class="signup">SignUp</span>
            </h>
        </div>
        <!--login form-->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <input class="form-control" type="text" name="username" autocomplete="off" placeholder="username"/>
            <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="password"/>
            <input class="btn btn-block btn-primary" name="login" type="submit" value="login"/>

        </form>
        <!--signup form-->
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <input class="form-control" type="text" name="username" autocomplete="off" placeholder="username" pattern=".{4,}" title="username must be more than 3 characters" required/>
            <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="password" minlength="3" required/>
            <input class="form-control" type="password" name="password-again" autocomplete="new-password" placeholder="write password again" minlength="3" required/>
            <input class="form-control" type="email" name="email" placeholder="Email"/>
            <input class="btn btn-block btn-success" name="signup" type="submit" value="signup"/>

        </form>
        <div class="the-errors text-center">
            <?php 
                if(!empty($formerrors)){
                    foreach($formerrors as $error){
                        echo '<div class="msg error">';
                        echo  $error ;
                        echo '<div>';
                    }
                }
                if (isset($successMsg)){
                    echo '<div class = "msg success">'.$successMsg. '</div>';
                }
            
            ?>
        </div>
    </div>

<?php include 'includes/templetes/footer.php';?>