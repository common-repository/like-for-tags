<?php
/*
Plugin Name: Facebook Like for Tags
Plugin URI: http://www.ingboo.com/pvm/plugin
Description: Use the Facebook Like button as a permanent connection for ongoing updates and sharing tied to article tags. Your audience will automatically get updates into their news feed anytime you post a new article with same set of tags.
Version: 1.5
Author: Tomas Lund @ IngBoo
Author URI: http://www.ingboo.com/
Plugin License: Apache License 2.0
*/
require_once(dirname(__FILE__).'/ingboo.php');
// activate plugin
function ingboo_facebook_like_activate() {
  $existingOptions=get_option('ingboo-facebook-like');
  if (!$existingOptions) {
    $options = array('index' => 'yes',
		     'page' => 'no',
		     'post' => 'yes',
		     'archive' => 'yes',
		     'excerpt' => 'no',
		     'show_faces' => 'yes',
		     'layout_style' => 'standard',
		     'width' => '450',
		     'height' => '',
		     'verb' => 'like',
		     'font' => 'arial',
		     'color_scheme' => 'light',
		     'position' => 'above',
		     'use_tags' => 'no',
		     'partnerEmail' => '',
		     'partnerPassword' => '',
		     'partnerId' => '0',
		     'pulseId' => '0',
		     'imageRef'=>'',
		     'lastError' => '',
		     'useCode' => 'no',
		     'useIframe' => 'no'
		     );
  } else {
    $options=$existingOptions;
    $options['archive']='yes';
    $options['useIframe']='no';
  }
  update_option('ingboo-facebook-like', $options);
}

register_activation_hook( __FILE__, 'ingboo_facebook_like_activate');

if (!class_exists("IngbooFacebookLike")) {
  class IngbooFacebookLike {
    function IngbooFacebookLike() {
      $this->__construct();
    }

    function __construct() {
    }

    function load() {
      add_action('admin_init', array(&$this, 'options'));
      $this->path = plugins_url('/like-for-tags/');
      $this->options = get_option('ingboo-facebook-like');
      $this->api=new IngBoo();
      // display it!
      add_action('the_post', array(&$this, 'initialize'));
      // admin stuff
      add_action('admin_menu', array(&$this, 'menu'));
      add_action('admin_head', array(&$this, 'admin_css'));
      add_action('admin_head', array(&$this, 'admin_js'));
      add_action('update_option_ingboo-facebook-like',array(&$this, 'doPartnerUpdate'));
      add_filter('contextual_help_list', array(&$this, 'show_help'), 10, 2);
    }
		
    function ingboo_plugin_links($links,$file) {
      if ($file == plugin_basename(__FILE__)) {
	$links[] = '<a href="plugins.php?page=ingboo_facebook_like_menu">Settings</a>';
      }
      return $links;
    }

    function initialize($posts) {
      if (is_front_page()) {
	if ($this->options['excerpt']=='yes') {
	  add_filter('the_excerpt', array(&$this, 'show_ingboo_facebook_like'));
	} else if ($this->options['index']=='yes') {
	  $this->display();
	}
      } else if(is_single()) {
	if ($this->options['post'] == 'yes') {
	  $this->display();
	}
      } else if (is_page()) {
	if ($this->options['page'] == 'yes') {
	  $this->display();
	}
      } else if (is_archive() || is_search() || is_category() || is_tax()) {
        if ($this->options['archive'] == 'yes') {
	  // For themes that uses excerpts for archive/search
	  add_filter('the_excerpt', array(&$this, 'show_ingboo_facebook_like'));
	  $this->display();
	}
      }
      return $posts;
    }
		
    function display() {
      add_filter('the_content', array(&$this, 'show_ingboo_facebook_like'));
    }

    function options() {
      register_setting('ingboo_facebook_like_settings', 'ingboo-facebook-like');
    }
		
    function show_ingboo_facebook_like($content) {
      if ($this->options['useCode']=='yes') {
	return $content;
      }
      $iframe=$this->getLike(false);
      if ($iframe=='') {
	return $content;
      } else if ($this->has_value($likeValues,'below')) {
	return $content . $iframe;
      } else if ($this->has_value($likeValues,'above')) {
	return $iframe . $content;
      } else if($this->options['position'] == 'below') {
	return $content . $iframe;
      } else {
	return $iframe . $content;
      }
    }

    function getLike($always=true) {
      if ($this->options['partnerId']=='0' || $this->options['pulseId']=='0') {
	  return '';
      }
      $likeValues=get_post_custom_values('like');
      if ($this->has_value($likeValues,'false') || $this->has_value($likeValues,'0')) {
	if (!$always) {
	  return '';
	}
      }
      $useIframe=false;
      if ($this->options['useIframe']=='yes') {
	$useIframe=true;
      }
      $declHeight=$this->options['height'];
      if ($declHeight!==null && $declHeight!=='') {
	$height=$declHeight;
      } else if ($this->options['layout_style']=='button_count') {
	$height = '21';
      } else if ($this->options['layout_style']=='box_count') {
	$height = '65';
      } else if($this->options['show_faces'] == "yes") {
	$height = '80';
      } else {
	$height = '35';
      }
      if ($useIframe) {
	$url="";
      } else {
	$url="http://www.ingboo.com/pvm/og/ps?";
      }
      $url .= 'tid='.$this->options['partnerId'].".".$this->options['pulseId'];
      if (is_page() && !is_front_page()) {
	// No extra filters on these
      } else if ($this->options['use_tags']=='yes') {
	$posttags=get_the_tags($id);
	if ($posttags) {
	  $i=0;
	  foreach($posttags as $tag) {
	    if ($i<4) {
	      $url.='&filter'.$i++.'='.urlencode($tag->name);
	    }
	  }
	}
      } else {
	$postcats=get_the_category($id);
	if ($postcats) {
	  $i=0;
	  foreach($postcats as $cat) {
	    if ($i<4) {
	      $url.='&filter'.$i++.'='.urlencode($cat->name);
	    }
	  }
	}
      }
      if ($useIframe) {
	$fb_options='';
	if ($this->options['layout_style']=='standard') {
	  $fb_options.='s:';
	} else if ($this->options['layout_style']=='button_count') {
	  $fb_options.='b:';
	} else {
	  $fb_options.='x:';
	}
	if ($this->options['show_faces']=='yes') {
	  $fb_options.='t:';
	} else {
	  $fb_options.='f:';
	}
	if ($this->options['verb'] == 'like') {
	  $fb_options.='l:';
	} else {
	  $fb_options.='r:';
	}
	if ($this->options['color_scheme'] == 'dark') {
	  $fb_options.='d:';	  
	} else {
	  $fb_options.='l:';
	}
	if ($this->options['font'] =="arial") {
	  $fb_options.='0';
	} else if ($this->options['font'] =="lucida grande") {
	  $fb_options.='1';
	} else if ($this->options['font'] =="segoe ui") {
	  $fb_options.='2';
	} else if ($this->options['font'] =="tahoma") {
	  $fb_options.='3';
	} else if ($this->options['font'] =="trebuchet ms") {
	  $fb_options.='4';
	} else if ($this->options['font'] =="verdana") {
	  $fb_options.='5';
	}
	$url.='&_fb_o='.$fb_options;	
	$url.='&_w='.$this->options['width'];
	$url.='&_h='.$height;
	$wd=$this->options['width'];
	$wd+=30;
	$ht=$height;
	$ht+=60;
	$iframe ='<iframe src="http://www.ingboo.com/pvm/lk?' . $url. '" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:' . $wd . 'px; height:'.$ht.'px;"></iframe>';
      } else {
	$iframe = '<iframe src="http://www.facebook.com/plugins/like.php?href=' . urlencode($url) . '&amp;layout=' . $this->options['layout_style'] . '&amp;show_faces=' . $this->options['show_faces'] . '&amp;width=' . $this->options['width'] . '&amp;action=' . $this->options['verb'] . '&amp;font=' . $this->options['font'] . '&amp;colorscheme=' . $this->options['color_scheme'] . '" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:' . $this->options['width'] . 'px; height:' . $height . 'px"></iframe>';
      }
      return $iframe;
    }

    function menu() {
      add_submenu_page('plugins.php','Like for Tags Options', 'Like for Tags', 'manage_options', 'ingboo_facebook_like_menu', array(&$this, 'ingboo_facebook_like_settings'));
    }
		
    function ingboo_facebook_like_settings() {
      include( dirname(__FILE__).'/options.php');
    }
		
    function admin_css() {
      echo '<link rel="stylesheet" href="' . $this->path . 'css/admin.css" type="text/css" />';
    }
		
    function admin_js() {
      echo '<script type="text/javascript" src="' . $this->path . 'js/ingboo_facebook_like_admin.js"></script>';
    }

    function has_value($customLike,$searchFor) {
      if ($customLike===undefined) {
	return false;
      } else if (!is_array($customLike)) {
	return false;
      } else {
	foreach ($customLike as $k => $v) {
	  if ($v==$searchFor) {
	    return true;
	  }
	}
	return false;
      }
    }

    function doPartnerUpdate() {
      $options = get_option('ingboo-facebook-like');
      if ($options['reset']) {
	$options = array('index' => 'yes',
			 'page' => 'no',
			 'post' => 'yes',
			 'archive' => 'yes',
			 'excerpt' => 'no',
			 'show_faces' => 'yes',
			 'layout_style' => 'standard',
			 'width' => '450',
			 'height' => '',
			 'verb' => 'like',
			 'font' => 'arial',
			 'color_scheme' => 'light',
			 'position' => 'below',
			 'use_tags' => 'yes',
			 'partnerEmail' => '',
			 'partnerPassword' => '',
			 'partnerId' => '0',
			 'pulseId' => '0',
			 'imageRef'=>'',
			 'lastError' => '',
			 'useCode' => 'no',
			 'useIframe' => 'no'
			 );
	update_option('ingboo-facebook-like', $options);
	return;
      }
      $argsOk=false;
      if ($this->options['partnerId']=='0' && $options['partnerId']=='0') {
	  if ($options['partnerEmail']!=='') {
	    if ($options['partnerPassword']==='') {
	      $options['partnerPassword']='sndms00';
	    }
	    $argsOk=true;
	  } 
      } else if ($options['partnerEmail']!==$this->options['partnerEmail']) {
	if ($options['partnerPassword']==='') {
	  $options['partnerPassword']='sndms00';
	}
	$argsOk=false;
      } else if ($options['partnerPassword']!==$this->options['partnerPassword']) {
	$argsOk=false;
      } else if ($options['lastError']!=='') {
	$argsOk=false;
      }
      if ($argsOk) {
	try {
	  $partnerXml=$this->api->get_partner($options['partnerEmail'],$options['partnerPassword']);
	  $options['partnerId']=''.$partnerXml->id;
	  $this->options['partnerId']=$options['partnerId'];
	  if ($options['imageRef']=='http://') {
	    $options['imageRef']='';
	  }
	  $this->options['imageRef']=$options['imageRef'];
	  $this->rssUrl=get_bloginfo('rss2_url');
	  $pulse=$this->api->mk_pulse($this->rssUrl,$options['partnerEmail'],$options['partnerPassword'],$options['imageRef']);
	  $options['pulseId']=''.$pulse->id;
	  $this->options['pulseId']=$options['pulseId'];
	  $options['lastError']='';
	  update_option('ingboo-facebook-like', $options);
	} catch (Exception $e) {
	  error_log("Exception: $e");
	  $options['lastError']=$e->getMessage();
	  update_option('ingboo-facebook-like', $options);
	}
      }
    }

    function show_help($help, $screen) {
      error_log("Screen: ".print_r($screen,true)." Help: ".$help);
      if (is_object($screen)) {
	$screen = $screen->id;
      }		
      if ($screen=='plugins_page_ingboo_facebook_like_menu') {
	$txt='<p>'.__('The fields on this screen determines how the plugin Facebook Like For Tags will interact with your posts').'</p>';
	$txt.='<p>'.__('There are three main categories that influences how the Like buttons will work: General Settings, Facebook Settings, and Location Settings').'</p>';
	$txt.='<h3>'.__('General Settings').'</h3><p>'.__('Your email address and the password you provide are used to connect your site with the change-detect-notification system. Also, you can use this to log in to ').'<a href="http://www.ingboo.com/pc/">partner central</a>'.__(' for more detailed configuration, such as uploading a brand image or changing update frequency. It is recommended that you filter updates based on categories since it usually provides good granularity to trigger news feed updates.').'</p>';
	$txt.='<h3>'.__('Facebook Settings').'</h3><p>'.__('These settings are described in detail by ').'<a href="http://developers.facebook.com/docs/reference/plugins/like">Facebook</a>'.__('. The height can be fixed for your blog. If you want a custom setting for height, you may need to test your way forward. It can be changed at any time.').'</p>';
	$txt.='<h3>'.__('Location Settings').'</h3><p>'.__('You can decide where you want the Like button located. Besides above and below posts, you can choose to display it on your front page (recommended), individual blog pages (recommended), on WordPress pages (e.g., about, press, etc.) and with excerpts.').'</p>';
	$txt.='<p>'.__('For detailed installation instructions, go to the ').'<a href="http://www.ingboo.com/pvm/plugin">plugin page</a>.'.'</p>';
	$help[$screen]=$txt;
      }
      return $help;
    }
  }
}

global $wp_version;
if (class_exists("IngbooFacebookLike")) {
  if (version_compare($wp_version, '2.8alpha','>')) {
    add_filter('plugin_row_meta',array(&$IngbooFacebookLike,'ingboo_plugin_links'),10,2);
  } else {
    add_filter('plugin_action_links',array(&$IngbooFacebookLike,'ingboo_plugin_links'),10,2);
  }
  add_action('plugins_loaded', create_function('', 'global $IngbooFacebookLike; $IngbooFacebookLike = new IngbooFacebookLike();$IngbooFacebookLike->load();'));
}
?>
