<?php require_once __SITE_PATH . '/view/login_header.php'; ?>

		<form class="login-form" method="post" action="<?php echo __SITE_URL;?>/index.php?rt=hotels/loginResults">
			<label for="username">Username:</label>
			<br>
			<input type="text" name="username" />
			<br>
			<label for="password">Password:</label>
			<br>
			<input type="password" name="password" />
			<br>
			<button type="submit" name="loginButton">Login</button>
			<br>
			<br>
			<label for="email">If you are not registered yet, type in your email address and we will send you the registration code:</label>
			<br>
			<input type="text" name="email" value="">
			<br>
			<label for="">If you are a seller, type in the hotel code provided by your employer.</label>
			<input type="text" name="id_hotela" value="-1">
			<br>
			<button type="submit" name="registerButton">Register</button>
			<br>

		</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
