<div class="album py-5 bg-dark-grey">
	<div class="container">
		<h3 class="font-white" id="total-posts">Total Posts: <span id="total-posts-count">N/A</span></h3>
		<!-- data-masonry='{"percentPosition": true }' -->
		<div class="row" id="masonry-area">
			<?php
                $posts = Post::getAllPosts();
			use Carbon\Carbon;

			foreach ($posts as $post) {
			    $p = new Post($post['id']);
			    $uploaded_time = Carbon::parse($p->getUploadedTime());
			    $uploaded_time_str = $uploaded_time->diffForHumans();
			    $owner = new User($post['owner']);
			    $s = UserProfile::getDetails(Session::getUser()->getId());
			    $a = $s->getAvatar();
			    $avatar = isset($a) ? $a : "/profileimg/default.jpeg";
			    if(Session::isAuthenticated()) {
			        $l = new Like($p);
			        $is_liked = $l->isLiked();
			    } else {
			        $is_liked = null;
			    }
			    Session::loadTemplate('index/photocard', [
			        'p' => $p,
			        'uploaded_time_str' => $uploaded_time_str,
			        'owner' => $owner,
			        'is_liked' => $is_liked
			    ]);
			}
			?>
		</div>
	</div>
</div>