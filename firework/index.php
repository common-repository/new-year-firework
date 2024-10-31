<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $_GET['text']; ?></title>
	<meta charset="UTF-8">
	<!-- If Chrome Frame is enabled, let's use it! -->
	<meta http-equiv="X-UA-Compatible" content="chrome=1" />
	<meta name="Description" content="<?php echo $_GET['text']; ?>" />
	<!-- Load jQuery -->
	<script src="<?php echo $_GET['url']; ?>/wp-includes/js/jquery/jquery.js"></script>
	<!-- Load the fireworks script and stylesheet -->
	<script src="canvas/fireworks.js"></script>
	<link href="canvas/fireworks.css" rel="stylesheet" />
	<meta name="robots" content="noindex" />
</head>
<body>
	<h1><?php echo $_GET['text']; ?></h1>
	<script>
		var site_url = "<?php echo $_GET['url']; ?>";
		document.write('<div style="background:url(images/background.jpg) repeat-x;position:absolute;left:0;top:'+(jQuery(window).height()-193)+'px;width:100%;height:200px;"></div>');
		document.write('<canvas id="cv" width="'+jQuery(window).width()+'" height="'+(jQuery(window).height()-100)+'" style="position:absolute;left:0;top:0;"></canvas>');
	</script>

	<div id="message">
		<a href="<?php echo $_GET['url']; ?>">Back To Home Page</a>
	</div>
	
	<input id="firetext" type="hidden" value="<?php echo $_GET['text']; ?>" />
	<?php if(isset($_GET['music'])){ ?>
	<div style="display: none;">
		<audio src="<?php echo $_GET['music']; ?>" autoplay="autoplay" id="music"></audio>
	</div>
	<?php } ?>
</body>
</html>