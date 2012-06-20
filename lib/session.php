<?php
session_start();
require_once(__DIR__ . '/db.php');

class Session
{
    public $user;
    private $flash;

    public function __construct()
    {
        $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $this->flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
        unset($_SESSION['flash']);
    }

    /**
     * Initialises session checks. If role is null. The script
     * shouldn't have access to the $user variable.
     * 
     * @param string $role Protects the page for a certain user role
     */

    public function init($role = null)
    {
        // If $role is not null, get the user from the DB
        if (!is_null($role)) {
            if (!$this->getUser()) {
                $this->setFlash('You must be logged in to view this page!');
                header('location:/main_login.php');
                exit;
            } else { // Update the user from the db
                $pdo = DB::getInstance();
                $stmt = $pdo->prepare('SELECT * FROM members WHERE id = :id');
                $stmt->bindParam(':id', $this->user['id'], PDO::PARAM_INT);
                $stmt->execute();
                $this->setUser($stmt->fetch(PDO::FETCH_ASSOC));
            }
            // Now check if the user is banned
            if ($this->user['banned'] == 'Y') {
                $this->setFlash('You are banned. Please contact the webmaster.');
                unset($_SESSION['user']);
                header('location:/main_login.php');
                exit;
            }
            // Check roles required for access.
            if (($role != $this->user['role']) && ($this->user['role'] != 'ADMIN')) {
                    $this->setFlash('You do not have the required permissions to view this page!');
                    header('location:/main_login.php');
                    exit;
            }
            $this->updateUserActivity();
        }
    }
    
    public function logout()
    {
        unset($_SESSION['user']);
    }

    /**
     * Gets the current user. Returns false if no user is logged in
     */

    public function getUser()
    {
        return isset($this->user) ? $this->user : false;
    }

    private function setUser(array $user)
    {
        $_SESSION['user'] = $user;
        $this->user = $user;
    }

    /**
     * Returns true if flash is set.
     * 
     * @return bool
     */

    public function hasFlash()
    {
        return isset($this->flash);
    }

    public function getFlash()
    {
        return $this->flash;
    }

    /**
     * Sets the flash message
     * 
     * @param string, array $flash The message to flash on the next screen
     */

    public function setFlash($flash)
    {
        $_SESSION['flash'] = $flash;
    }
    
    public function updateUserActivity()
    {
    	$db = DB::getInstance();
    	$sql = "UPDATE `members` SET `last_active` = :time WHERE `id` = :id";
    	$stmt = $db->prepare($sql);
    	$stmt->bindValue(':time', time());
    	$stmt->bindParam(':id', $this->user['id']);
    	$stmt->execute();
    }
}

$session = new Session();
?>