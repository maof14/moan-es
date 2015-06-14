<!DOCTYPE html>
<html lang='<?=$lang?>' class='no-js'>
<head>
	<meta charset='utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="http://www.moanenterprise.com/">
	<title><?=get_title($title)?></title>
	<?php if(isset($favicon)): ?><link rel='shortcut icon' href='<?=$favicon?>'/><?php endif; ?>
	<?php if(isset($stylesheets)): ?>
	<?php foreach($stylesheets as $file): ?>
		<link rel="stylesheet" type="text/css" href='<?=$file?>'/>
	<?php endforeach; ?>
	<link rel='stylesheet' type='text/css' href='<?=$stylesheet?>'>
	<?php endif; ?>
	<?php if(isset($js['above'])) : ?> 
		<?php foreach($js['above'] as $file): ?> 
			<script src='<?=$file?>'></script>
		<?php endforeach; ?>
	<?php endif; ?>
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div id='header'>
		<nav class='navbar navbar-inverse navbar-fixed-top'>
			<div class='container'>
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">MOAN Enterprise Solutions</a>
		        </div>
				<?=$navmenu?>
			</div>
		</nav>
	</div>
	<div id='container' class='container'>
		<!-- flash message, if any. -->
		<?php if($flash->hasMessage() == true) echo $flash->getMessage(); ?>
		<!-- main content -->
		<?=$main?>
	</div>
	

	<div id='footer'>
	<?=$footer?>
	</div>
	<?php if(isset($js['below'])) : ?> 
		<?php foreach($js['below'] as $file): ?> 
			<script src='<?=$file?>'></script>
		<?php endforeach; ?>
	<?php endif; ?>
</body>
</html>