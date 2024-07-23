<?php

include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

class UserProfile
{
    use SQLGetterSetter;
    private $conn;
    public $id;
    public $table;
    

    public function __construct($id)
    {
        $this->id = $id;
        $this->conn = Database::getConnection();
        $this->table = 'user_profile';
    }

    // public static function updateProfile($profile_tmp, $details): array
    // {

    //     $bio = $details['bio'];
    //     $instagram = $details['instagram'];
    //     $twitter = $details['twitter'];
    //     $facebook = $details['facebook'];

    //     //profile processing
    //     if (is_file($profile_tmp) and exif_imagetype($profile_tmp) !== false) {
    //         $author = Session::getUser()->getUsername();
    //         $profile_name = md5($author.time()) . image_type_to_extension(exif_imagetype($profile_tmp));
    //         $profile_path = get_config('profile_path') . $profile_name;
    //         if (move_uploaded_file($profile_tmp, $profile_path)) {
    //             $profile_uri = "/profileimg/$profile_name";
                
    //             $db = Database::getConnection();
    //             $update_command = "UPDATE `user_profile` SET `avatar` = ?, `bio` = ?, `instagram` = ?, `twitter` = ?, `facebook` = ? WHERE `username` = ?";

    //             $stmt = $db->prepare($update_command);

    //             if ($stmt) {
    //                 $stmt->bind_param('ssssss', $profile_uri, $bio, $instagram, $twitter, $facebook, $author);
    //                 if ($stmt->execute()) {
    //                     return ['response'=>'Profile Updated successfully', 'status' => 'success', 'status_code' => 200, 'path' => $profile_uri];
    //                 } else {
    //                     return ['response'=>'Failed to update', 'status' => 'error', 'status_code' => 301];
    //                 }
    //             } else {
    //                 return ['response'=>'Connection to database failed', 'status' => 'error', 'status_code' => 301];
    //             }
    //         } else {
    //             return ['response'=>'Image cannot be moved', 'status' => 'error', 'status_code' => 301];
    //         }
    //     } else {
    //         return ['response'=>'Error with processing the image', 'status' => 'error', 'status_code' => 301];
    //     }
    // }

    public static function updateProfile($profile_tmp = "/profileimg/default.jpeg", $details): array
    {
        $bio = $details['bio'];
        $instagram = $details['instagram'];
        $twitter = $details['twitter'];
        $facebook = $details['facebook'];

        $author = Session::getUser()->getUsername();
        $profile_uri = '';

        // Profile processing
        if (!empty($profile_tmp) && $profile_tmp !== 'default.png' && is_file($profile_tmp) && exif_imagetype($profile_tmp) !== false) {
            $profile_name = md5($author . time()) . image_type_to_extension(exif_imagetype($profile_tmp));
            $profile_path = get_config('profile_path') . $profile_name;
            if (move_uploaded_file($profile_tmp, $profile_path)) {
                $profile_uri = "/profileimg/$profile_name";
            } else {
                return ['response' => 'Image cannot be moved', 'status' => 'error', 'status_code' => 301];
            }
        } else {
            // Set default profile image if none provided
            $profile_uri = $profile_tmp;
        }

        $db = Database::getConnection();
        $update_command = "UPDATE `user_profile` SET `avatar` = ?, `bio` = ?, `instagram` = ?, `twitter` = ?, `facebook` = ? WHERE `username` = ?";

        $stmt = $db->prepare($update_command);

        if ($stmt) {
            $stmt->bind_param('ssssss', $profile_uri, $bio, $instagram, $twitter, $facebook, $author);
            if ($stmt->execute()) {
                return ['response' => 'Profile updated successfully', 'status' => 'success', 'status_code' => 200, 'path' => $profile_uri];
            } else {
                return ['response' => 'Failed to update', 'status' => 'error', 'status_code' => 301];
            }
        } else {
            return ['response' => 'Connection to database failed', 'status' => 'error', 'status_code' => 301];
        }
    }


    public static function deleteProfile($profile_path)
    {
        $full_path = get_config('profile_path') . basename($profile_path);
        if (file_exists($full_path)) {
            if (unlink($full_path)) {
                return ['response' => 'Profile image deleted successfully', 'status' => 'success', 'status_code' => 200];
            } else {
                return ['response' => 'Failed to delete the file', 'status' => 'error', 'status_code' => 500];
            }
        } else {
            return ['response' => 'File does not exist', 'status' => 'error', 'status_code' => 404];
        }
    }
    public static function getDetails($id)
    {
        $profile = new UserProfile($id);
        return $profile;
    }
}
