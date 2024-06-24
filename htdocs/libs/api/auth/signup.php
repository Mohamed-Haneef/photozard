<?php

${basename(__FILE__, '.php')} = function () {
    if ($this->paramsExists(['email_address', 'password', 'phone', 'username', 'date_of_birth'])) {
        $email = $this->_request['email_address'];
        $password = $this->_request['password'];
        $phone = $this->_request['phone'];
        $username = $this->_request['username'];
        $dob = $this->_request['date_of_birth'];

        $result = User::signup($username, $password, $email, $phone, $dob);
        if($result) {
            $data = [
                $result['status'] => $result['response']
            ];
            return $this->response($this->json($data), $result['status_code']);
        } else {
            $data = [
                $result['status'] => $result['response']
            ];
            return $this->response($this->json($data), $result['status_code']);
        }

    } else {
        $data = ['error' => 'details missing'];
        return $this->response($this->json($data), 401);
    }
};
