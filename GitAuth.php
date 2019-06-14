<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/14
 * Time: 10:39
 */


class GitAuth
{
    protected $config = array(
        'app_name'=>'test',
        'response_type'=>'code',
        'client_id'=>'353b38fb5e8d2557f33e',
        'client_secret'=>'12dc7029e71b87eb26ce05b51fc008ef59318da5',
        'redirect_uri' =>'http://localhost/github/callback.php',
        'scope'=>'email',
    );


    public function getTime(){
        return $this->state;
    }
    public function git_authorize_url()
    {
        return "https://github.com/login/oauth/authorize?scope=" . $this->config['scope'] . '&client_id=' . $this->config['client_id'] . '&redirect_uri=' . $this->config['redirect_uri'];
    }

    public function get_token($code){
        session_start();

        $ch = curl_init();
        $data = array(
            'client_id'=>'353b38fb5e8d2557f33e',
            'client_secret'=>'12dc7029e71b87eb26ce05b51fc008ef59318da5',
            'code'=>$code,
            'redirect_uri'=>$this->config['redirect_uri'],
            'grant_type'=>'authorization_code',
        );

        curl_setopt($ch, CURLOPT_URL,"https://github.com/login/oauth/access_token");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $_SESSION['access_token'] = json_decode($server_output);
        $user = $_SESSION['access_token'];

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close ($ch);
        $this->get_user($user->access_token);
    }
    public function get_user($access_token){
        session_start();
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"https://api.github.com/user?access_token=".$access_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.$this->config['app_name'],'Accept: application/json'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $get_response = curl_exec($ch);
        $_SESSION['response'] = json_decode($get_response);

        curl_close($ch);

        header("location:http://localhost/github/index.php?user");
    }
}