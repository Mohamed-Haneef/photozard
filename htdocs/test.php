<?php
// include 'libs/load.php';
?>
<!-- <pre> -->
<?php
// echo Session::getUser()->getEmail();
// $image_tmp = $_FILES['post_image']['tmp_name'];
// $text = $_POST['post_text'];
// echo $image_tmp;
// Post::registerPost($text, $image_tmp);

// $posts = Post::getAllPosts();
// foreach($posts as $post){
//     print($post['id']);
//     $p = new Post($post['id']);
//     print($p->getPostText());
//     $l = new Like($p);
//     print($l->getID());
//     $l->toggleLike();
// }

?>
<!-- </pre> -->
<?php
include 'libs/load.php';

$profile = new UserProfile(Session::getUser()->getID());
var_dump($profile->setBio("Orewa monkey D Luffy"));
// var_dump($profile);?>