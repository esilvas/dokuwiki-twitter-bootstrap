<?php
/**
 * DokuWiki Starter Template
 *
 * @link     http://dokuwiki.org/template:starter
 * @author   Emilio Silvas <>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && $_SERVER['REMOTE_USER'] );
?>
<!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php _tpl_include('meta.html') ?>	
</head>

<body>
    <?php /* with these Conditional Comments you can better address IE issues in CSS files,
             precede CSS rules by #IE6 for IE6, #IE7 for IE7 and #IE8 for IE8 (div closes at the bottom) */ ?>
    <!--[if IE 6 ]><div id="IE6"><![endif]--><!--[if IE 7 ]><div id="IE7"><![endif]--><!--[if IE 8 ]><div id="IE8"><![endif]-->

    <?php /* classes mode_<action> are added to make it possible to e.g. style a page differently if it's in edit mode,
         see http://www.dokuwiki.org/devel:action_modes for a list of action modes */ ?>
    <?php /* .dokuwiki should always be in one of the surrounding elements (e.g. plugins and templates depend on it) */ ?>
    <!-- ********** HEADER ********** -->
	<div id="dokuwiki__site" class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<?php tpl_link(wl(),$conf['title'],'class="brand" id="dokuwiki__top" accesskey="h" title="[H]"') ?>
				<?php /* how to insert logo instead (if no CSS image replacement technique is used):
						upload your logo into the data/media folder (root of the media manager) and replace 'logo.png' accordingly:
						tpl_link(wl(),'<img src="'.ml('logo.png').'" alt="'.$conf['title'].'" />','id="dokuwiki__top" accesskey="h" title="[H]"') */ ?>
				<?php if (tpl_getConf('tagline')): ?>
					<!-- FIX THIS LATER -->
					<!-- <p class="claim"><?php //echo tpl_getConf('tagline') ?></p> -->
				<?php endif ?>

				<div class="nav-collapse">
					<ul class="nav">
						<li><a href="#dokuwiki__content"><?php echo tpl_getLang('skip_to_content') ?></a></li>

						<!-- USER TOOLS -->
						<?php if ($conf['useacl'] && $showTools): ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo tpl_getLang('user_tools') ?><b class="caret"></b></a>
							<ul class="dropdown-menu">
								<?php /* the optional second parameter of tpl_action() switches between a link and a button,
									 e.g. a button inside a <li> would be: tpl_action('edit',0,'li') */
									if ($_SERVER['REMOTE_USER']) {
										echo '<li>';
										tpl_userinfo(); /* 'Logged in as ...' */
										echo '</li>';
									}
									tpl_action('admin', 1, 'li');
									_tpl_action('userpage', 1, 'li');
									tpl_action('profile', 1, 'li');
									_tpl_action('register', 1, 'li'); /* DW versions > 2011-02-20 can use the core function tpl_action('register', 1, 'li') */
									tpl_action('login', 1, 'li');
								?>
							</ul>
						</li>
						<?php endif ?>

						<!-- SITE TOOLS -->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo tpl_getLang('site_tools') ?><b class="caret"></b></a>
							<?php //tpl_searchform() ?>
							<ul class="dropdown-menu">
								<?php
									tpl_action('recent', 1, 'li');
									tpl_action('media', 1, 'li');
									tpl_action('index', 1, 'li');
								?>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div><!-- /header -->

	<div style='position: absolute; width: 100%; margin-right: auto; margin-left: auto;'>
		<div id='alertCarousel' class='carousel slide'>
			<div id="alertcontainer" >
				<div class='carousel-inner'>
					<?php html_msgarea() /* occasional error and info messages on top of the page */ ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container main site mode_<?php echo $ACT ?>">
		<?php //_tpl_include('header.html') ?>

		<!-- ********** ASIDE ********** -->
		<div id="dokuwiki__aside"><div class="pad include">
			<?php tpl_include_page(tpl_getConf('sidebarID')) /* includes the given wiki page */ ?>
		</div></div><!-- /aside -->

		<!-- BREADCRUMBS -->
		<div class="row-fluid">
			<div class="span12 breadcrumbs pad">
			<?php if($conf['breadcrumbs']){ ?>
				<?php tpl_breadcrumbs() ?>
			<?php } ?>
			<?php if($conf['youarehere']){ ?>
				<?php //tpl_youarehere() ?>
			<?php } ?>
			</div>
		</div>

		<!-- ********** CONTENT ********** -->
		<div id="dokuwiki__content" class="row-fluid dokuwiki">
			<?php tpl_flush() /* flush the output buffer */ ?>

			<div class="row-fluid page">
				<!-- wikipage start -->
				<?php tpl_content() /* the main content */ ?>
				<!-- wikipage stop -->
			</div>

			<?php tpl_flush() ?>
			<?php _tpl_include('pagefooter.html') ?>
		</div><!-- /content -->

		<div class="row-fluid">
			<p class="pull-left"><?php tpl_userinfo()?></p>
			<p class="pull-right"><?php tpl_pageinfo() ?></p>
		</div>

		<div class="row-fluid bar" id="bar__bottom">
		  <div class="bar-left" id="bar__bottomleft">
			<?php tpl_button('edit')?>
			<?php tpl_button('history')?>
			<?php tpl_button('revert')?>
		  </div>
		  <div class="bar-right" id="bar__bottomright">
			<?php tpl_button('subscribe')?>
			<?php tpl_button('media')?>
			<?php tpl_button('admin')?>
			<?php tpl_button('profile')?>
			<?php tpl_button('login')?>
			<?php tpl_button('index')?>
			<?php tpl_button('top')?>
		  </div>
		</div>
		
	</div><!-- /site -->
	
	<!-- ********** FOOTER ********** -->
	<div id="dokuwiki__footer" class="navbar navbar-fixed-bottom">
		<div class="navbar-inner">
			<div class="container">
				<div class="container">
				<p class="pull-left"><?php tpl_userinfo()?></p>
				<p class="pull-right"><?php tpl_pageinfo() ?></p>
				</div>
			
				<?php _tpl_include('footer.html') ?>
				
				<?php tpl_license('0') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
			</div>
		</div>
	</div><!-- /footer -->
	<div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>

	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap.min.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-alert.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-button.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-carousel.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-dropdown.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-modal.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-popover.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-scrollspy.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-tab.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-tooltip.js"></script>
	<script src="/wiki/lib/tpl/twitter-bootstrap/js/bootstrap-typeahead.js"></script>
</body>
</html>
