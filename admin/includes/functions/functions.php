<?php

/*for getting all records it is global function*/

function getAllForm($field , $table , $where=NULL , $and=NULL , $orderfield , $ordering="DESC"){
    global $con;
    $getAll = $con -> prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");
    $getAll->execute();
    $all = $getAll->fetchAll();
    return $all ;
}







/* title function */

function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo ' default ';
    }
}





/* redirecthome function after update 1 */

function redirectHome($msg, $seconds=1 ,$url=null){

    echo  $msg ;
    if ($url === null)
    {
        $url='index.php';
        $link='Home Page';
    }else{
        if(isset($_SERVER['HTTP_REFERER'] )&& $_SERVER['HTTP_REFERER'] !==''){
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'previous page';
        }else{
            $url='index.php';
            $link='Home Page';
        }
    }
    
    echo '<div class="alert alert-info">you will be directed to '.$link.' after '. $seconds . ' seconds.</div>';
    header("refresh:$seconds;url=$url");
    exit();
}



/* check the user exist before or not */

function checkItems($select, $from , $value){
    global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select =?");
    $statement -> execute(array($value));
    $count = $statement->rowCount();
    return $count;
}


/*function to count number of items */
function countItems($item, $table){
    global $con;
    $stmt2= $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2-> execute();
    return $stmt2->fetchColumn();
}


/*to get latest recoreds or results from database
 order --> mean the thing you wanna order by it
 ASC -->تصاعدي 
 DESK --> تنازلي
*/

function getlatest($select , $table, $order , $limit=5){

    global $con;
    $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getstmt->execute();
    $rows = $getstmt->fetchAll();
    return $rows;
}