<?php 
if (is_file("./local_config.php")) {
    require_once __DIR__ . "/local_config.php";
} else {
    define('MYSQLPASSWORD',"请填写您的数据库秘密！！！");
}
