<?php

${basename(__FILE__, '.php')} = function () {
    if ($this->isAuthenticated() and $this->paramsExists('id')) {
        $p = new Post($this->_request['id']);
        $l = new Like($p);
        $l->toggleLike();
        $liked = $l->isLiked();
        $data = [
            'success' => $liked
        ];
        $this->response($this->json($data), 200);
    } else {
        $this->response($this->json([
            'error'=>"bad request"
        ]), 400);
    }
};
