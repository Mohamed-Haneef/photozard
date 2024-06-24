<?php

${basename(__FILE__, '.php')} = function () {
    if ($this->paramsExists(['username', 'password'])) {
        $user = $this->_request['username'];
        $password = $this->_request['password'];
        $fingerprint = $_COOKIE['fingerprint'];
        $token = UserSession::authenticate($user, $password, $fingerprint);
        if($token['status'] == 200) {
            $this->response($this->json([
                'success'=>'Authenticated',
                'token' => $token
            ]), 200);
        } else {
            $this->response($this->json([
                $token['status']=>$token['response']
            ]), $token['status_code']);
        }

    } else {
        $this->response($this->json([
            'error'=>"bad request"
        ]), 400);
    }
};
