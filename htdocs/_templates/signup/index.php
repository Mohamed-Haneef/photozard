<main class="form-signup">
    <form method="post" action="signup.php" id=signup-form>
        <img class="mb-4" src="https://git.selfmade.ninja/uploads/-/system/appearance/logo/1/Logo_Dark.png" alt=""
            height="50">
        <h2 class="mb-3">Signup Here</h2>
        <div class="form-floating">
            <input name="username" type="text" class="form-control bg-dark-grey font-white" id="username"
                placeholder="name@example.com">
            <label for="floatingInputUsername">Username</label>
        </div>
        <div class="form-floating">
            <input name="phone" type="text" class="form-control bg-dark-grey font-white" id="phone"
                placeholder="name@example.com">
            <label for="floatingInputUsername">Phone</label>
        </div>
        <div class="form-floating">
            <input name="email_address" type="email" class="form-control bg-dark-grey font-white" id="email_address"
                placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input name="date_of_birth" type="date" class="form-control bg-dark-grey font-white" id="date_of_birth"
                placeholder="Date of birth">
            <label for="floatingDateOfBirth">Date of birth</label>
        </div>
        <div class="form-floating">
            <input name="password" type="password" class="form-control bg-dark-grey font-white" id="password"
                placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <button class="w-100 lavender-shining-button
         hvr-grow-rotate" type="submit">Sign up</button>
        <a href="/login" class="w-100 btn btn-link">Already have an account? Login</a>
    </form>
</main>