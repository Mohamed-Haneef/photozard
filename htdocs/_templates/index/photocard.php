<?php

$post_id = $p->getID();
$post_path = $p->getImageUri();
$post_description = $p->getPostText();
$post_owner = $owner->getUsername();
$post_total_likes = $p->getLikeCount();



?>

<div class="col-lg-3 mb-4" id="post-<?=$post_id?>">
    <div class="card">
        <img class="bd-placeholder-img card-img-top"
            src="<?=$post_path?>">
        <div class="card-body">
            <p class="card-text font-white"><?=$post_description?>
            </p>

            <span class="font-white mr-2">Total likes:</span>
            <span class="total-like-count font-white mr-2"
                id="total-like-count"><?=$post_total_likes?></span>
            <div class="d-flex justify-content-between align-items-center my-2">
                <?php if(Session::isAuthenticated()) { ?>
                <div class="btn-group" data-id="<?=$post_id?>">
                    <?php if($is_liked !== true) { ?>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-like">Like</button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-sm btn-primary btn-like">Liked</button>
                    <?php } ?>
                    <?php if (Session::isOwnerOf($p->getOwner())) {?>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                    <?php  }?>
                </div>
                <?php } ?>
                <small class="text-muted">
                    <span><?=$uploaded_time_str?></span> by <span
                        class="font-weight-bold"><?=$post_owner?></span>
                </small>
            </div>

        </div>
    </div>
</div>