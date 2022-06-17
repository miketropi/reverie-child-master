<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?> > <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?> > <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?> "> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?> > <!--<![endif]-->
<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-N46M6C9');</script>
	<!-- End Google Tag Manager -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178722285-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-178722285-1');
	</script>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title('|', true, 'right'); ?></title>
	<meta name="viewport" content="width=device-width" />
	<meta content="telephone=no" name="format-detection">
	<link rel="shortcut icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/right-choice-favicon.png">
	<?php wp_head(); ?>
	<?php global $modifyPrice; $modifyPrice = false; ?>	
	<meta name="google-site-verification" content="WDqN3zfR1LRhqQfcX9fTtOHIvEhiuWRf6D26RzhY0r4" />
	<meta name="google-site-verification" content="WiV2u6Nw7YBNtaxGNeb-HCN3xwUBFaTRYaP6qBhM7C8" />
</head>

<body <?php body_class('antialiased'); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N46M6C9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="wrapper">

<?php //echo do_shortcode('[INSERT_ELEMENTOR id="15"]'); ?>

<?php ccs_header('header-classic') ?>

<?php
	if ( is_product_category() ) {
		echo do_shortcode('[INSERT_ELEMENTOR id="28318"]');
	}else if( is_product() ) {
		echo do_shortcode('[INSERT_ELEMENTOR id="1161"]');
	}
?>




<!-- Start the main container -->
<div class="container" role="document">
	<div class="row">