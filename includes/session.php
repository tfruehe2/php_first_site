<?php
class Session {

  private $logged_in=false;
  public $user_id;
  public $message;

  protected static $instance;

  function __contruct() {
    session_start();
    $this->check_message();
    $this->check_login();
    if($this->logged_in) {
      // actions to take if user is logged in
    } else {
      // actions to take if user is NOT logged in
    }
  }

  public static function getInstance(){
    if ( !isset(self::$instance))
    {
        self::$instance = new self;
    }
    return self::$instance;
  }

  public function is_logged_in() {
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 'true' ) {
      return true;
    }
    return false;
  }

  public function login($user) {
    if($user) {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['logged_in'] = true;
      $this->user_id = $user->id;
      $this->logged_in = true;
      return $user;
    }

  }

  public function logout() {
    unset($_SESSION['user_id']);
    unset($_SESSION['logged_in']);
    unset($_SESSION['message']);
    unset($this->user_id);
    $this->logged_in = false;
  }

  public function destroy() {
    session_destroy();
    unset($_SESSION);
  }

  public function message($msg="") {
    global $_SESSION;
    if(!empty($msg)) {
      $_SESSION['message'] = $msg;
    } else {
      if (isset($_SESSION['message'])) {
        $text = $_SESSION['message'];
        unset($_SESSION['message']);
        return $text;
      } else
      return "";
    }
  }

  private function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }

  private function check_message() {
    if(isset($_SESSION['message'])) {
      $this->message = $_SESSION['message'];
      unset($_SESSION['messsage']);
    } else {
      $this->message = "";
    }
  }
}


$session = Session::getInstance();
$message = $session->message();

?>
