<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/14
 * Time: 10:46
 */

require 'GitAuth.php';


$e = new Gitauth();


if(isset($_GET['auth'])) {
    echo '<a href="'.$e->git_authorize_url().'">Login with Github</a>';
}


if(isset($_GET['user'])){
    session_start();

  echo '<pre>';

  print_r($_SESSION['response']);

  echo '</pre>';
}




