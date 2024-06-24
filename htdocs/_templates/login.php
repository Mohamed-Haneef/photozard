<main class="form-signin">
	<form method="post" action="login.php" id="login-form" autocomplete="off">
		<img class="mb-4" src="https://git.selfmade.ninja/uploads/-/system/appearance/logo/1/Logo_Dark.png" alt=""
			height="50">
		<?php if($_GET['signup'] == true) {?>
		<h2 class="mb-3">Signup successful, Login to continue</h2>
		<?php } else {?>
		<h1 class="h3 mb-3 fw-normal">Please Login</h1>
		<?php } ?>
		<div class="form-floating">
			<input name="user" type="text" class="form-control bg-dark-grey font-white" id="user"
				placeholder="name@example.com">
			<label for="floatingInput">Email address or Username</label>
		</div>
		<div class="form-floating">
			<input name="password" type="password" class="form-control bg-dark-grey font-white" id="password"
				placeholder="Password" autocomplete="new-password">
			<label for="floatingPassword">Password</label>
		</div>

		<!-- <div class="checkbox mb-3">
			<label>
				<input type="checkbox" value="remember-me"> Remember me
			</label>
		</div> -->
		<button class="w-100 hvr-grow-rotate lavender-shining-button" type="submit">Sign in</button>
		<a href="/signup" class="w-100 btn btn-link">Not registered? Sign up</a>
	</form>
</main>