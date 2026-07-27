<html>
<body>
	<h1>Recuperaci&oacute;n de contrase&ntilde;a para <?= $identity ?></h1>
	<p>Pulse <?= anchor('auth/reset_password/'. $forgotten_password_code, 'aquí') ?> para continuar con el proceso de recuperaci&oacute;n de contrase&ntilde;a.</p>
	<!-- <p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?></p> -->
</body>
</html>