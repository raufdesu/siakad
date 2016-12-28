<?php
 buat_file('../install.txt','0');
try {
    $dbh = new PDO('mysql:host=localhost', $_POST['db_user'], $_POST['db_pass']);
    $error = "";
    $dbh->exec("DROP DATABASE IF EXISTS `".$_POST['db']."`;CREATE  DATABASE `".$_POST['db']."`;") 
        or $error = $dbh->errorInfo();
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
}


try {
    $dbh = new PDO('mysql:host=localhost;dbname='.$_POST['db'], $_POST['db_user'], $_POST['db_pass']);
    $dbs = file_get_contents('../db.sql', true);
     $sql = '';
        foreach (explode(";\n", $dbs) as $query) {
            $sql = trim($query);
            
            if($sql) {
                $dbh->query($sql);
            } 
        }

    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}

echo 'good';

unlink('../install.txt');

unlink('../index.php');

 function buat_file($file,$isi)
 {
    $fp=fopen($file,'w');
    if(!$fp)return 0;
    fwrite($fp, $isi);
    fclose($fp);return 1;

 }

$isi = '<?php
	header("location:admina/index.php");
?>
';
 buat_file('../index.php',$isi);

$isi_config = '<?php
date_default_timezone_set("Asia/Jakarta");
ini_set( "display_errors", true );
define( "HOST", "localhost" );
//nama database
define( "DATABASE_NAME", "'.$_POST['db'].'" );
define( "DB_USERNAME", "'.$_POST['db_user'].'" );

define( "PORT", 3306);
//password mysql
define( "DB_PASSWORD", "'.$_POST['db_pass'].'" );
//dir admin
define( "DIR_ADMIN", "feeder-importer/admina/");
//main directory
define( "DIR_MAIN", "feeder-importer/");

define ("SITE_ROOT", $_SERVER["DOCUMENT_ROOT"]."/".DIR_MAIN);

define("DB_CHARACSET", "utf8");

require_once ("Database.php");
require_once ("Datatable.php");
require_once ("My_pagination.php");
require_once ("url.php");
require_once ("DTable.php");
require_once ("Table_Clean.php");

$db=new Database("mysql");

//postgre
//$pgs=new Database("pgsql");

//pagination
$pg=New My_pagination();
$dtable = new TableData();

$new_table = new DTable("mysql");
$clean = new Table_Clean("mysql");

function handleException( $exception ) {
  echo  $exception->getMessage();
}

set_exception_handler( "handleException" );


?>';

 buat_file('../admina/inc/config.php',$isi_config);