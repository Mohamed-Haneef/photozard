<?php

// if (isset($_POST['post_text']) and isset($_FILES['post_image'])) {
//     $image_tmp = $_FILES['post_image']['tmp_name'];
//     $text = $_POST['post_text'];
//     Post::registerPost($text, $image_tmp);
// }

?>

<section class="py-5 text-center container">
	<div class="row py-lg-5">
		<div class="col-lg-6 col-md-8 mx-auto">
			<h1 id="greeting" class="fw-light">What are you upto,
				<?=Session::getUser()->getUsername()?>?
			</h1>
			<p class="lead text-muted">Share a photo that talks about it.</p>
			<textarea id="post_text" name="post_text" class="form-control bg-dark-grey font-white"
				placeholder="What are you upto?" rows="3"></textarea>
			<div class="input-group mb-3">
				<input type="file" accept="image/*" class="form-control bg-dark-grey font-white" name="post_image"
					id="post_image">
				<!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
			</div>
			<p>
				<button class="btn btn-success share-memory my-2" id="share-memory">Share memory</button>
				<a href="/somesecret.php" class="btn btn-secondary my-2">Secret Page</a>
			</p>
		</div>
	</div>
</section>