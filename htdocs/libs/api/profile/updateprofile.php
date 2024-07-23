<?php

${basename(__FILE__, '.php')} = function () {
    if ($this->isAuthenticated() and $this->paramsExists('user_profile', 'username', 'bio', 'date_of_birth', 'instagram', 'twitter', 'facebook')) {
        if(isset($_FILES['user_profile'])) {
            $profile = $_FILES['user_profile']['tmp_name'];
        } else {
            $profile = $this->_request['user_profile'];
        }
        $user_details = [
            'bio' => $this->_request['bio'],
            'instagram' => $this->_request['instagram'],
            'twitter' => $this->_request['twitter'],
            'facebook' => $this->_request['facebook'],
        ];
        $update = UserProfile::updateProfile($profile, $user_details);
        if($update['status_code'] == 200) {
            $data = [
                $update['status'] => $update['response'],
                'path' => $update['path']
            ];
        } else {
            $data = [
                $update['status'] => $update['response']
            ];
        }
        
        return $this->response($this->json($data), $update['status_code']);
    } else {
        $data = [
            "error" => "Parameters missing for edit profile"
        ];
        return $this->response($this->json($data), 400);
    }
};
