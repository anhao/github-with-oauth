<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/14
 * Time: 11:20
 */

require  "GitAuth.php";


$code = $_GET['code'];

$e = new Gitauth();

$e->get_token($code);