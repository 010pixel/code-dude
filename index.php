<?php
	if ( !defined('ABSPATH') )
		define('ABSPATH', dirname(__FILE__) . '/');
	require_once( ABSPATH . 'php/settings.php' );
	require_once( ABSPATH . 'php/functions.php' );
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php echo getHead(); ?>
  </head>

  <body>

	<?php echo getMainMenu(); ?>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <?php echo getBannerContent(); ?>

      <?php echo getPageContent(); ?>

      <!-- Example row of columns -->
      <?php echo getFeaturedContent(3); ?>

      <hr>

      <footer>
        <?php echo getFooter(); ?>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<?php echo getFootScripts(); ?>

  </body>
</html>
