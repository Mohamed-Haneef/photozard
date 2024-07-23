<?php
${basename(__FILE__, '.php')} = function () {
    if($this->isAuthenticated() and $this->paramsExists('profile')) {
        $delete_msg = UserProfile::deleteProfile($this->_request['profile']);
        $data  = [
            $delete_msg['status'] => $delete_msg['response']
        ];
        return $this->response($this->json($data), $delete_msg['status_code']);
    } else {
        $data  = [
            "error" => "some problem"
        ];
        return $this->response($this->json($data), 401);
    }
};
