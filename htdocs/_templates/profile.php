<?php
$s = UserProfile::getDetails(Session::getUser()->getId());
$b = $s->getBio();
$bio = isset($b) ? $b : null;
$u = $s->getUsername();
$username = isset($u) ? $u : null;
$d = $s->getDob();
$date_of_birth = isset($d) ? $d : null;
$i = $s->getInstagram();
$instagram = isset($i) ? $i : null;
$t = $s->getTwitter();
$twitter = isset($t) ? $t : null;
$f = $s->getFacebook();
$facebook = isset($f) ? $f : null;


?>
<!-- <p class="font-white">
    <?= var_dump(UserProfile::getDetails(Session::getUser()->getId())) ?>
</p> -->

<section class="edit-profile">
    <div class="container">
        <form method="post" id="edit-profile">
            <div class="form-floating">
                <input name="username" type="text" class="form-control bg-dark-grey font-white" id="username"
                    value="<?= $username ?>"
                    placeholder="Enter your username" readonly>
                <label for="username">Username</label>
            </div>
            <div class="form-floating">
                <input name="date_of_birth" type="date" class="form-control bg-dark-grey font-white" id="date_of_birth"
                    value="<?= $date_of_birth ?>"
                    placeholder="Enter your date of birth" readonly>
                <label for="date_of_birth">Date of birth</label>
            </div>
            <div class="form-floating">
                <input name="bio" type="text" class="form-control bg-dark-grey font-white" id="bio"
                    value="<?= $bio ?>" placeholder="Enter your bio">
                <label for="bio">Bio</label>
            </div>
            <div class="form-floating">
                <input name="instagram" type="text" class="form-control bg-dark-grey font-white" id="instagram"
                    value="<?= $instagram ?>"
                    placeholder="Enter your Instagram handle">
                <label for="instagram">Instagram</label>
            </div>
            <div class="form-floating">
                <input name="twitter" type="text" class="form-control bg-dark-grey font-white" id="twitter"
                    value="<?= $twitter ?>"
                    placeholder="Enter your Twitter handle">
                <label for="twitter">Twitter</label>
            </div>
            <div class="form-floating">
                <input name="facebook" type="text" class="form-control bg-dark-grey font-white" id="facebook"
                    value="<?= $facebook ?>"
                    placeholder="Enter your Facebook handle">
                <label for="facebook">Facebook</label>
            </div>
            <button class="w-100 lavender-shining-button hvr-grow-rotate" type="submit">Update</button>
        </form>
    </div>
</section>