<?php
session_start();
require_once(__DIR__ . '/db.php');

class Session
{
    private $user;
    
    public function __construct()
    {
        $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
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
        if (false === is_null($role)) {
            if (false === $this->getUser()) {
                $this->setFlash('You must be logged in to view this page!');
                header('location:/main_login.php');
                exit;
            } else { // Update the user from the db
                $pdo = DB::getInstance();
                $stmt = $pdo->prepare('SELECT * FROM members WHERE id = :id');
                $stmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
                $stmt->execute();
                $this->user = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            // Now check if the user is banned
            if ($this->user['banned'] == 'Y') {
                $this->setFlash('You are banned. Please contact the webmaster.');
                unset($_SESSION['user']);
                header('location:/main_login.php');
                exit;
            }
             // Check roles required for access.
            if ($role == 'USER' && ($this->user['role'] != 'USER' && $this->user['role'] != 'ADMIN')) {
                $this->setFlash('You do not have the required permissions to view this page: User.');
                header('location:/index.php');
                exit;
            } else if ($role == 'ADMIN' && ($this->user['role'] != 'ADMIN')) {
                $this->setFlash('You do not have the required permissions to view this page: Admin.');
                header('location:/index.php');
                exit;
            }
        }
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
        return isset($_SESSION['flash']);
    }
    
    public function getFlash()
    {
        return $_SESSION['flash'];
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
    
    public function __destruct()
    {
        unset($_SESSION['flash']);
    }
}

$session = new Session();
?>