<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php wp_title(''); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<?php // Google Tag Manager ?>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-THT3ZGQ');</script>
		<?php // End Google Tag Manager ?>
		<?php wp_head(); ?>
		<?php $iconBase = get_home_url().'/wp-content/themes/r-eh/assets/icons/'; ?>
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $iconBase ?>apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $iconBase ?>apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $iconBase ?>apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $iconBase ?>apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $iconBase ?>apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $iconBase ?>apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $iconBase ?>apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $iconBase ?>apple-icon-152x152.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $iconBase ?>android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $iconBase ?>favicon-32x32.png">
		<style>
		.skip {
		  border: 0 !important;
		  clip: rect(0 0 0 0) !important;
		  height: 0.0625rem !important;
		  margin: -0.0625rem !important;
		  overflow: hidden !important;
		  padding: 0 !important;
		  position: absolute !important;
		  width: 0.0625rem !important;
		}
		.skip-active:focus, .skip-active:active {
		  font-size: 14px;
		  display: block;
		  text-decoration: none;
		  position: static !important;
		  width: 100% !important;
		  height: 1.125rem !important;
		  text-align: center;
		}
		</style>
	</head>

	<body <?php body_class(); ?>>

		<?php // Google Tag Manager (noscript) ?>
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-THT3ZGQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<?php // End Google Tag Manager (noscript) ?>

		<a class="skip skip-active" href="#maincontent">Skip to main content</a>

		<div class="main-wrapper"> <?php // closed in footer.php ?>

			<header class="header">
				<div class="container">
					<a class="logo" href="<?php echo home_url();?>">
						<img alt="Logo" src=" data:image/png;base64,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">
					</a>
					<nav class="nav">
						<?php if (is_page_template('page-template-info.php')): ?>
							<?php wp_nav_menu(array('menu' => 'Info navigation', 'fallback_cb' => false)); ?>
						<?php else: ?>
							<?php wp_nav_menu(array('menu' => 'Navigation', 'fallback_cb' => false)); ?>
						<?php endif; ?>
						<?php /* Search function not wanted at this stage
						<div class="search">
							<div class="search__link">Search</div>
							<?php dynamic_sidebar( 'Search' ); ?>
						</div>
						*/?>
					</nav>
					<div class="cart-icon">
						<img src="data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgMTg0LjM0IDI5NC40MiI+PGRlZnM+PHN0eWxlPi5jbHMtMSwuY2xzLTN7ZmlsbDpub25lO30uY2xzLTJ7Y2xpcC1wYXRoOnVybCgjY2xpcC1wYXRoKTt9LmNscy0ze3N0cm9rZTojMjMxZjIwO3N0cm9rZS1taXRlcmxpbWl0OjEwO3N0cm9rZS13aWR0aDozcHg7fTwvc3R5bGU+PGNsaXBQYXRoIGlkPSJjbGlwLXBhdGgiPjxyZWN0IGNsYXNzPSJjbHMtMSIgd2lkdGg9IjE4NC4zNCIgaGVpZ2h0PSIyOTQuNDIiLz48L2NsaXBQYXRoPjwvZGVmcz48dGl0bGU+c2hvcHBpbmctYmFnPC90aXRsZT48ZyBjbGFzcz0iY2xzLTIiPjxwYXRoIGNsYXNzPSJjbHMtMyIgZD0iTTExNC41NywyMy40bDEuMTQsMjEuMTdtLTM1Ljc2LTI4LDQzLjE0LDhNNjAuNjUsMTUuMzlsOS4wOSwxLjcybS05LjA5LDIwVjE1LjM5TDY4LjYsOGw1LjExLS41OG02LDQuODYsNDIuODUsOG0xLjE0LDI0LjMxTDEyMi41MSw5LjFNNzkuMzksNDBWMS42N20tOS42NSwzNlYxMS4zOWw5LjY1LTkuNzJMMTIyLjUxLDkuMWw3Ljk1LDEyTDEzMSw0Ni4yOU0yNiwzNy4xM0wzNi4yNCwyOTIuMjVNMS42MiwyNzcuOTRMMzQsMjUxLjYzTTEuNjIsMjc3Ljk0bDM0LjA1LDE0Ljg3LDE0Ny0yNEwxNjYuOCw0OS43MiwxMzEsNDYuMjlsLTEwNS0xNHY2LjI5bC05LjA5LTJaIi8+PC9nPjwvc3ZnPg==" alt="Cart icon">
						<div class="cart-icon__qty"><?php echo sprintf (_n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></div>
					</div>
					<div class="menu-btn">
						Menu
					</div>
					<div class="pcp-grid">
						<span class="pcp-grid__md"><span></span><span></span><span></span><span></span></span>
						<span class="pcp-grid__normal"><span></span><span></span><span></span><span></span><span></span><span></span></span>
					</div>
				</div>
			</header>

			<main class="container<?php if (is_single()): ?> container--single<?php endif; ?>" id="maincontent">
