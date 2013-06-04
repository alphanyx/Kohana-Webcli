<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Webcli</title>
		<?php


		if (isset($settings['JavaScript'])) {
			foreach ($settings['JavaScript'] as $javaScriptFile) {
		?>
		<script src="<?php echo $javaScriptFile; ?>"></script>
		<?php
			}
		}

		if (isset($settings['CSS'])) {
			foreach ($settings['CSS'] as $cssFile) {
		?>
		<link href="<?php echo $cssFile; ?>" rel="stylesheet"/>
		<?php
			}
		}
		?>
		<script>
			jQuery(document).ready(function($) {
				$('body').terminal("<?php echo $settings['terminalUrl']; ?>", {
					login: <?php echo $loginRequired === true ? 'true' : 'false'; ?>,
					greetings: "You are authenticated",
					onBlur: function() {
					// the height of the body is only 2 lines initialy
					return false;
					}
				});
			});
		</script>
	</head>
<body>
</body>
