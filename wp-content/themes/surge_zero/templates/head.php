<head >
	<meta charset="utf-8">
	<title></title><!--set in yoast-->

	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">

	<!--font imports-->
	<style>
		@import url('https://fonts.googleapis.com/css?family=Lato:100,300');
	</style>

	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicon.png" rel="icon" type="image/png">

	<?php	wp_head();?>

	<!--gtag-->
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-35885860-1');
	</script>
	<script>
		var appServerUrl = '<?= getenv('APP_SERVER_URL'); ?>';
	</script>
</head>
