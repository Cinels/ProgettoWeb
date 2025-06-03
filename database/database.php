<?php
class DatabaseHelper{
    private $db;
    private $isLogged = false;
    private $user = null;
    private $userType = null;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }        
    }


    public function isLogged() {
        return $isLogged;
    }
    
    public function getUserType() {
        return $userType;
    }

    public function getProfileImage() {
        return $user['fotoProfilo'];
    }

    public function checkLogin($email, $password){
        $encryptedPassword = hash('sha256', $password);
        $query = "SELECT email, nome, cognome, fotoProfilo FROM UTENTE WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $encryptedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if (count($result->fetch_all(MYSQLI_ASSOC)) == 1) {
            $isLogged = true;
            $user = $result->fetch_all(MYSQLI_ASSOC);
            if(isClientProfile($email)) {
                $userType = "client";
            } else {
                $userType = "vendor";
            }
        } else {
            $templateParams["errorelogin"] = "Email o Password errati"
        }
    }

    public function singIn($image, $name, $surname, $email, $password) {
        if (isEmailAvailable($email)) {
            $encryptedPassword = hash('sha256', $password);
            $query = "INSERT INTO UTENTE (email, nome, cognome, password, fotoProfilo) VALUE (?, ?, ?, ?, ?);";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssss', $email, $name, $surname, $encryptedPassword, $image);
            $stmt->execute();

            $query = "INSERT INTO CLIENTE (email) VALUE (?);";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
        }
    }

    public function logout() {
        $isLogged = false;
        $user = null;
    }


    private function isEmailAvailable() {
        $query = "SELECT email FROM UTENTE WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) == 0;
    }

    private function isClientProfile($email) {
        $query = "SELECT C.email FROM UTENTE U, CLIENTE C WHERE U.email = C.email AND U.email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) == 1;
    }
}
?>