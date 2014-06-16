<?php
	$defined_constants = get_defined_constants(true);
	
	// Get Data
	$data = getObjectFromJson( ABSPATH . 'json/data.json' );
	$system = new codedude();
	$system->setConstants($defined_constants['user']);
	$system->init($data);
	$system->setCurrentPageData();
?>
<?php	
	// Get Data from $data variable
	function getData() {
		global $data;
		return $data;
	}
	
	function getFileContent($filePath) {
		if ( !file_exists($filePath) ) { return false;}
		$contents = file_get_contents($filePath); 
		$contents = utf8_encode($contents); 
		return $contents;
	}
	
	function getObjectFromJson($filePath) {
		$contents = getFileContent($filePath);
		$results = json_decode($contents);
		return $results;
	}
	
	function getMainMenu () {
		global $system;
		return $system->getMenu();
	}
	
	function getBannerContent () {
		global $system;
		return $system->getBannerContent();
	}
	
	function getFeaturedContent ($total_display = 0) {
		global $system;
		return $system->getFeaturedContent($total_display);
	}
	
	function getPageContent () {
		global $system;
		return $system->getPageContent();
	}
	
	function getFooter () {
		global $system;
		return $system->getFooter();
	}

	function getHead () {
		
		global $system;
		
		$defaults = array(
						'title' => 'Code Dude : Stop coding, start working',
						'desc' => '',
						'author' => 'Code Dude',
					);
		
		$defaults = array_merge($defaults, $system->currentPage);
		
		if ( $system->currentPage['title'] ) {
			$defaults['title'] .= ' : Code Dude';
		}
		
		ob_start();
		?>
        <meta charset="utf-8">
        <title><?php echo @$defaults['title']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo @$defaults['desc']; ?>">
        <meta name="author" content="<?php echo @$defaults['author']; ?>">

        <meta name="og:description" content="<?php echo @$defaults['desc']; ?>">
        <meta name="og:url" content="<?php echo ABSURL; ?>">
        <meta name="og:image" content="<?php echo REL_DIR_URL; ?>img/ico/apple-touch-icon-144-precomposed.png">
        <meta name="og:type" content="website">
        <meta name="og:author" content="<?php echo @$defaults['author']; ?>">
    
        <link href="<?php echo REL_DIR_URL; ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo REL_DIR_URL; ?>css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="<?php echo REL_DIR_URL; ?>css/styles.css" rel="stylesheet">
    
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo REL_DIR_URL; ?>img/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo REL_DIR_URL; ?>img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo REL_DIR_URL; ?>img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo REL_DIR_URL; ?>img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="<?php echo REL_DIR_URL; ?>img/ico/favicon.png">
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
	
	function getFootScripts () {
		
		ob_start();
		?>
		<script src="<?php echo REL_DIR_URL; ?>js/jquery.js"></script>
        <script src="<?php echo REL_DIR_URL; ?>js/bootstrap.min.js"></script>
        <script src="<?php echo REL_DIR_URL; ?>js/scripts.js"></script>
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
?>
<?php
	/**
	 * Expected Result as Below:
	 * --------------------------------------------------------------------------------
          <a class="brand" href="#">Code Dude</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Wordpress Plugins <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Crazy CMS</a></li>
                  <li><a href="#">Custom Post Type Permissions</a></li>
                  <li><a href="#">Image Upload MetaBox</a></li>
                  <li><a href="#">Template List Metabox</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Ready to use</li>
                  <li><a href="#">Portfolio</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">CSS<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">rkSlider</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">jQuery<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">rkSlider</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Extra<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">iOS7</a></li>
                  <li><a href="#">Resume using JSON</a></li>
                  <li><a href="#">Image Upload MetaBox</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
          <div style="clear:both;"></div>
	 * --------------------------------------------------------------------------------
	 */
	
	class codedude {
		
		var $data;
		var $menu;
		var $projects;
		var $active_menu = '';
		var $currentMenu = '';
		var $currentPageUrl = THIS_PAGE;
		var $currentPage = array();
		var $featured = array();
		var $featuredItems = array();
		var $contentDirPath = '';
		var $errPageDirPath = '';
		var $defaultConstants = array();
		
		public function __construct( $data = '' ) {
			// If default home page
			if (!($this->currentPageUrl)) {
				$this->currentPageUrl = $this->cleanupURL(BASE_FILE_URL . '/home');
			}

			if ( $data != '' ) {
				$this->data = $data;
				$this->init($data);
			}
		}
		
		public function init( $data = '' ) {
			if ( $data != '' ) {
				$this->data = $data;
			}
			if ( !empty($this->defaultConstants) ) {
				$this->cleanUpDataUrls();
			}
			// If there is data then set the necessary values
			if ( $this->data ) {
				$this->contentDirPath = $this->data->content_dir;
				$this->errPageDirPath = $this->data->err_pages_dir;
				$this->menu = $this->data->menu;
				$this->featured = $this->data->featured;
				$this->projects = $this->data->projects;
			}
		}
		
		public function displayMenu () {
			echo $this->getMenu();
		}

		public function getMenu() {
			
			$menu = '';
			// Main Logo
			$logo = '<a class="brand" href="'. $this->data->siteurl .'">'. $this->data->sitename .'</a>';
			
			foreach ( $this->menu as $slug => $item ) {
				$menu .= $this->getMenuItems($slug, $item, $this->projects);
			}
			
			if ( !empty($menu) ) {
				$menu = '<div class="nav-collapse collapse"><ul class="nav">' . $menu . '</ul></div>';
			}
			
			$content = '<div class="navbar navbar-inverse navbar-fixed-top">
						  <div class="navbar-inner">
							<div class="container">
							  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							  </button>';
			$content .= $logo . $menu;
			$content .= '</div></div></div>';

			return $content;
		}
		
		public function getMenuItems($slug, $item, $subMenuItems) {
			
			$this->currentMenu = $item;
			
			extract ((array) $item);
			
			$class = (array) $class;
			
			// Set Featured Item
			if ( in_array($url, $this->featured) ) {
				$this->setFeaturedContent( $item );;
			}
			
			if ( isset($subMenuItems->$slug) ) {
				$class[] = 'dropdown';
				$link = "\n" . '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'. $title .'<b class="caret"></b></a>';
			} else {
				$link_target = ( isset($target) ) ? 'target="'. $target .'"' : '' ;
				$link = ( !empty($url) ) ? '<a href="'. $url .'" '. $link_target .'>'. $title .'</a>' : $title;
			}
			
			// Submenu also checks for active submenu and it will set active menu accordingly
			$submenu = $this->subMenu( $slug, $subMenuItems );
			
			if ( $this->active_menu == $title ) { $class[] = 'active'; }
			$class = implode(' ', $class);
			if ( !empty($class) ) { $class = ' class="'. $class .'"';}
			
			$content = '<li'. $class .'>'. $link . $submenu .'</li>' . "\n";
			
			return $content;
		}
		
		public function subMenu( $slug = '', $menu_items = array() ) {
			
			$content = '';
			
			$menu = $menu_items->$slug;
			
			foreach ( $menu as $slug => $item ) {
				$content .= $this->getSubMenuItems($item);			
			}
			
			if ( !empty($content) ) {
				$content = "\n" . '<ul class="dropdown-menu">' . $content . '</ul>' . "\n";
			}
			
			return $content;
		}
		
		public function getSubMenuItems($item) {
			
			extract ((array) $item);
			
			// Set Featured Item
			if ( in_array($url, $this->featured) ) {
				$this->setFeaturedContent( $item );;
			}
			
			$link_target = ( isset($target) ) ? 'target="'. $target .'"' : '' ;
			
			$link = ( !empty($url) ) ? '<a href="'. $url .'" '. $link_target .'>'. $title .'</a>' : $title;
			
			if ( !empty($class) ) { $class = ' class="'. $class .'"';}
			
			$content = '<li'. $class .'>'. $link .'</li>';
			
			return $content;
		}
		
		public function setCurrentPageData () {
			foreach ( $this->menu as $slug => $item ) {
				if ( $this->currentPageUrl == $this->cleanupURL($item->url) ) {
					$this->active_menu = $item->title;
					$this->currentPage = (array) $item;
					break;
				} else {
					foreach ( $this->projects->$slug as $category => $project ) {
						if ( $this->currentPageUrl == $this->cleanupURL($project->url) ) {
							$this->active_menu = $item->title;
							$this->currentPage = (array) $project;
							break;
						}
					}
				}
			}
			
			// If current page exists then set page type to content
			// Else the page doesn't exists then set 404 Error Page
			if ( $this->currentPage ) {
				// Set current page type to Content page
				$this->currentPage['page_type'] = 'content';
			} else {
				$this->setErrorPage("404");
				// Set current page type to Error Page
				$this->currentPage['page_type'] = 'error';
			}
			return $this->currentPage;
		}
		
		public function getPageContent () {
			if ( !$this->currentPage['content'] ) { return; }
			$pageDirPath = ($this->currentPage['page_type'] == "content") ? $this->contentDirPath : $this->errPageDirPath;
			$filePath = ABSPATH . $pageDirPath . $this->currentPage['content'];
			// If PHP is set to true then include the file
			// Else get file content and show in page
			if ($this->currentPage['php'] == "true") {
				$contents = include($filePath);
			} else {
				$contents = getFileContent($filePath); 
				return $contents;
			}
		}
		
		public function getBannerContent() {
			
			// If no current page is set then don't show
			if ( !$this->currentPage ) { return ''; }
			
			ob_start();
			?>
                <div class="hero-unit">
                    <?php
						echo '<h1>'. $this->currentPage['title'] .'</h1>';
						if ($this->currentPage['desc']) {
							echo '<p>'. $this->currentPage['desc'] .'</p>';
						}
						$btns = array();
						if ($this->currentPage['download']) {
							$btns[] = '<a href="'. $this->currentPage['download'] .'" class="btn btn-primary btn-large">Download &raquo;</a>';
						}
						if ($this->currentPage['visit']) {
							$btns[] = '<a href="'. $this->currentPage['visit'] .'" class="btn btn-success btn-large" target="_blank">Visit &raquo;</a>';
						}
						if (!empty($btns)) {
							echo '<p>'. implode('&nbsp;&nbsp;',$btns) .'</p>';
						}
					?>
                </div>
            <?php
			$content = ob_get_contents();
			ob_end_clean();
			
			return $content;
		}
		
		public function setFeaturedContent ( $item ) {
			$this->featuredItems[] = (array) $item;
		}
		
		// $total_display_items = Total Featured Items to be shown
		// 0 = all
		// null = none
		public function getFeaturedContent ( $total_display_items = 0 ) {
			
			if ( is_null($total_display_items) ) return '';
			
			$content = '';
			
			// If no current page is set then don't show
			if ( !$this->featuredItems || empty($this->featuredItems) ) { return ''; }
			$counter = 0;
			foreach ( $this->featuredItems as $item ) {
				$counter++;
				if ( ($total_display_items > 0) && ($counter > $total_display_items) ) { break; }
				ob_start();
				?>
					<div class="span4">
						<?php
							echo '<h2>'. $item['title'] .'</h2>';
							if ($item['desc']) {
								echo '<p>'. $item['desc'] .'</p>';
							}
							if ($item['url']) {
								echo '<p><a class="btn" href="'. $item['url'] .'">View details &raquo;</a></p>';
							}
						?>
					</div>
				<?php
				$content .= ob_get_contents();
				ob_end_clean();
			}
			
			if ( $content != '' ) {
				$content = '<div class="row">' . $content . '</div>';
			}
			
			return $content;
		}
		
		public function getFooter () {
			return '<p>&copy; Code Dude 2013</p>';
		}
		
		public function setConstants ($constants) {
			$new_array = array();
			foreach ( $constants as $key => $value ) {
				$new_array['{{'. $key .'}}'] = $value;
			}
			$this->defaultConstants = $new_array;
		}
		
		public function cleanUpDataUrls () {
			$this->data->siteurl = $this->processUrl($this->data->siteurl);
			$this->data->content_dir = $this->processUrl($this->data->content_dir);
			$this->data->err_pages_dir = $this->processUrl($this->data->err_pages_dir);
			foreach ( $this->data->menu as $slug => $item ) {
				$item->url = $this->processUrl($item->url);
			}
			foreach ( $this->data->featured as $key => $featured ) {
				$this->data->featured[$key] = $this->processUrl($featured);
			}
			foreach ( $this->data->projects as $category => $projects ) {
				foreach ( $projects as $key => $value ) {
					$value->url = $this->processUrl($value->url);
					$value->download = $this->processUrl($value->download);
				}
			}
		}
		public function processUrl ( $url ) {
			return strtr($url,$this->defaultConstants);
		}
		public function cleanupURL ( $url ) {
			$url = $this->processUrl($url);
			return str_replace(BASE_FILE_URL, '', $url);
		}
		
		public function setErrorPage ( $err_code = "404" ) {
			$this->currentPage = (array) $this->data->err_pages->$err_code;
		}
	}
?>