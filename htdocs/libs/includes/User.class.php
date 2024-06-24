<?php

require_once "Database.class.php";
include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

class User
{
    use SQLGetterSetter;
    private $conn;

    public $id;
    public $username;
    public $table;

    public static function signup($user, $pass, $email, $phone, $dob)
    {
        $options = [
            'cost' => 9,
        ];
        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);
        $conn = Database::getConnection();
        $conn->begin_transaction();
        try {
            $sql = "INSERT INTO `auth` (`username`, `password`, `email`, `phone`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $user, $pass, $email, $phone);
            $stmt->execute();
            
            $user_id = $conn->insert_id;
            
            $sql = "INSERT INTO `user_profile` (`id`, `uid`, `username`, `dob`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $user_id, $user_id, $user, $dob);
            $stmt->execute();
            $conn->commit();
            
            return ['status' => 'success', 'response' => 'signup successful', 'status_code' => 200];


        } catch (Exception $e) {
            if ($conn->errno === 1062) {
                $duplicate_key = $conn->error;
                if (strpos($duplicate_key, "username") !== false) {
                    return ['status' => 'error', 'response' => 'Username already present', 'status_code' => 400];
                } elseif (strpos($duplicate_key, "email") !== false) {
                    return ['status' => 'error', 'response' => 'email already present', 'status_code' => 400];
                } elseif(strpos($duplicate_key, "phone") !== false) {
                    return ['status' => 'error', 'response' => 'phone already present', 'status_code' => 400];
                } else {
                    return ['status' => 'error', 'response' => 'Unhandled Duplicate entry exception, check the error log', 'status_code' => 400];
                }
            } else {
                return ['status' => 'error', 'response' => 'Unhandled exception, check the error log, error no: '.$conn->errno, 'status_code' => 400];
            }
        }
    }

    public static function login($user, $pass)
    {
        $query = "SELECT * FROM `auth` WHERE `username` = ? OR `email` = ? OR `phone` = ?";
        $conn = Database::getConnection();
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }
        $stmt->bind_param("sss", $user, $user, $user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['password'])) {
                return ['status' => 'success', 'response' => 'Login success', 'status_code' => 200, 'username' => $row['username']];
            } else {
                return ['status' => 'error', 'response' => 'Password mismatch', 'status_code' => 401];
            }
        } else {
            return ['status' => 'error', 'response' => 'User Not found'.'user: '.$user.'pass'."$pass", 'status_code' => 400];
        }
    }

    public function __construct($username)
    {
        $this->conn = Database::getConnection();
        $this->username = $username;
        $this->id = null;
        $this->table = 'auth';
        $sql = "SELECT `id` FROM `auth` WHERE `username`= '$username' OR `id` = '$username' OR `email` = '$username' LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
        } else {
            throw new Exception("Username does't exist");
        }
    }

    public function setDob($year, $month, $day)
    {
        if (checkdate($month, $day, $year)) {
            return $this->_set_data('dob', "$year.$month.$day");
        } else {
            return false;
        }
    }



    // public function getUsername()
    // {
    //     return $this->username;
    // }

    public function authenticate()
    {
    }

    // public function setBio($bio)
    // {
    //     //TODO: Write UPDATE command to change new bio
    //     return $this->_set_data('bio', $bio);
    // }

    // public function getBio()
    // {
    //     //TODO: Write SELECT command to get the bio.
    //     return $this->_get_data('bio');
    // }

    // public function setAvatar($link)
    // {
    //     return $this->_set_data('avatar', $link);
    // }

    // public function getAvatar()
    // {
    //     return $this->_get_data('avatar');
    // }

    // public function setFirstname($name)
    // {
    //     return $this->_set_data("firstname", $name);
    // }

    // public function getFirstname()
    // {
    //     return $this->_get_data('firstname');
    // }

    // public function setLastname($name)
    // {
    //     return $this->_set_data("lastname", $name);
    // }

    // public function getLastname()
    // {
    //     return $this->_get_data('lastname');
    // }



    // public function getDob()
    // {
    //     return $this->_get_data('dob');
    // }

    // public function setInstagramlink($link)
    // {
    //     return $this->_set_data('instagram', $link);
    // }

    // public function getInstagramlink()
    // {
    //     return $this->_get_data('instagram');
    // }

    // public function setTwitterlink($link)
    // {
    //     return $this->_set_data('twitter', $link);
    // }

    // public function getTwitterlink()
    // {
    //     return $this->_get_data('twitter');
    // }
    // public function setFacebooklink($link)
    // {
    //     return $this->_set_data('facebook', $link);
    // }

    // public function getFacebooklink()
    // {
    //     return $this->_get_data('facebook');
    // }
}
