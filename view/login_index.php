<?php require_once __SITE_PATH . '/view/login_header.php'; ?>

		<form method="post" action="<?php echo __SITE_URL;?>/index.php?rt=hotels/loginResults">
			Username:
			<br>
			<input type="text" name="username" />
			<br>
			Password:
			<br>
			<input type="password" name="password" />
			<br>
			<button type="submit" name="loginButton">Login</button>
			<br>
			<br>
			If you are not registered yet, type in your email and we will send you the registration code.
			<br>
			<input type="text" name="email" value="">
			<br>
			If you are a seller, type in the hotel code provided by your employer.
			<input type="text" name="id_hotela" value="-1">
			<br>
			<button type="submit" name="registerButton">Register</button>
			<br>

		</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
