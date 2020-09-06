<?php 
    session_start();
    $noNavbar="";
    $pageTitle="login";

    if (isset($_SESSION['Username'])){
        header('Location: dashboard.php');
    }
    include 'init.php';
    

    if($_SERVER['REQUEST_METHOD']== 'POST'){

        $username   = $_POST['user'];
        $password   = $_POST['pass'];
        $hashedpass = sha1($password);
        
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
                               AND 
                                     GroupID=1 
                               LIMIT 1");
                               // the admin only have GroupID=1
        //from main form from user
        $stmt->execute(array($username, $hashedpass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
         
        //check the database record about username

        if($count > 0){
            $_SESSION['Username'] = $username;
            $_SESSION['ID'] = $row['UserID']; // this row has all info as array
            header('Location: dashboard.php');
            exit();
        }
    }
    ?>
        
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <h4 id="hi" class="text-center">Admin Login</h4>
        <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/> 
        <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password"> 
        <input class="btn btn-primary btn-block" type="submit" value="Login"> 
    </form> 

<?php include 'includes/templetes/footer.php';?>
