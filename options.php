<div class="wrap ingboo_facebook_like_settings">
<h2>Like for Tags - Settings</h2>
<form method="post" action="options.php">
<?php settings_fields( 'ingboo_facebook_like_settings' ); ?>
<?php $options = get_option('ingboo-facebook-like'); ?>
<?php if ($options['lastError']!='') { ?>
<h3>Save failed</h3>
<?php echo $options['lastError']?>
<?php $options['lastError']='';?>      
<?php } ?>
<h3>General Settings</h3>
<input name="ingboo-facebook-like[partnerId]" type="hidden" value="<?php echo $options['partnerId']; ?>" />
<input name="ingboo-facebook-like[pulseId]" type="hidden" value="<?php echo $options['pulseId']; ?>" />
<table class="form-table">
  <tr valign="top" class="options">
    <th scope="row">Your email address</th>
    <td><label><input name="ingboo-facebook-like[partnerEmail]" type="text" value="<?php echo $options['partnerEmail']; ?>" <?php if ($options['partnerId']!=='0') { echo 'readonly="true"';} ?>/></label>
    </td>
  </tr>
  <tr valign="top" class="options">
    <th scope="row">Password</th>
    <td><label><input name="ingboo-facebook-like[partnerPassword]" type="password" value="<?php echo $options['partnerPassword']; ?>" <?php if ($options['partnerId']!=='0') { echo 'readonly="true"';} ?>/></label>
    </td>
  </tr>
   <tr valign="top" class="options">
     <th scope="row">Custom Logo</th>
     <td><label><input name="ingboo-facebook-like[imageRef]" type="text" value="<?php if ($options['imageRef']==='') { echo 'http://';} else { echo $options['imageRef'];} ?>" title="(optional) URL to logo image. 100x100 png,gif, or jpg." <?php if ($options['partnerId']!=='0') { echo 'readonly="true"';} ?>/></label>
    </td>
  </tr>
  <tr valign="top" class="options">
	<th scope="row">Filter by</th>
    <td>
      <label>Tags <input name="ingboo-facebook-like[use_tags]" type="radio" value="yes"<?php checked('yes', $options['use_tags']); ?> /></label>
      <label>Categories <input name="ingboo-facebook-like[use_tags]" type="radio" value="no"<?php checked('no', $options['use_tags']); ?> /></label>
    </td>
  </tr>
      <tr valign="top">
  <td colspan="2">After saving your settings you can visit <a href="http://www.ingboo.com/pc">Partner Central</a> for additional configuration options, like a custom logo and more. You will need your email address and password to login.</td>
   </tr>
</table>
<h3>Facebook Settings</h3>
<div id="ingboo_facebook_like_preview"></div>
<table class="form-table">
<tr valign="top" class="options">
	<th scope="row">Layout Style</th>
    <td>
    	<select name="ingboo-facebook-like[layout_style]">
          <option value="standard"<?php selected('standard', $options['layout_style']); ?>>standard</option>
          <option value="button_count"<?php selected('button_count', $options['layout_style']); ?>>button_count</option>
          <option value="box_count"<?php selected('box_count', $options['layout_style']); ?>>box_count</option>
        </select>
    </td>
</tr>
<tr valign="top" class="options">
	<th scope="row">Show Faces</th>
    <td>
    <label>Yes <input name="ingboo-facebook-like[show_faces]" type="radio" value="yes"<?php checked('yes', $options['show_faces']); ?> /></label>
    <label>No <input name="ingboo-facebook-like[show_faces]" type="radio" value="no"<?php checked('no', $options['show_faces']); ?> /></label>
    </td>
</tr>
<tr valign="top" class="options">
	<th scope="row">Width</th>
    <td>
    <label><input name="ingboo-facebook-like[width]" type="text" value="<?php echo $options['width']; ?>" /></label>
    </td>
</tr>
<!--
<tr valign="top" class="options">
	<th scope="row">Height</th>
    <td>
    <label><input name="ingboo-facebook-like[height]" type="text" value="<?php echo $options['height']; ?>" title="Leaving blank will use Facebook standard heights. Standard height depenends on layout: Standard layout with faces => 80, Standard layout without faces => 35, Button layout => 21, Box layout => 65"/></label>
    </td>
</tr>
-->
<tr valign="top" class="options">
	<th scope="row">Verb to display</th>
    <td>
    	<select name="ingboo-facebook-like[verb]">
        	<option value="like"<?php selected('like', $options['verb']); ?>>like</option>
            <option value="recommend"<?php selected('recommend', $options['verb']); ?>>recommend</option>
        </select>
    </td>
</tr>
<tr valign="top" class="options">
	<th scope="row">Font</th>
    <td>
    	<select name="ingboo-facebook-like[font]">
        	<option value="arial"<?php selected('arial', $options['font']); ?>>arial</option>
        	<option value="lucida grande"<?php selected('lucida grande', $options['font']); ?>>lucida grande</option>
        	<option value="segoe ui"<?php selected('segoe ui', $options['font']); ?>>segoe ui</option>
        	<option value="tahoma"<?php selected('tahoma', $options['font']); ?>>tahoma</option>
        	<option value="trebuchet ms"<?php selected('trebuchet ms', $options['font']); ?>>trebuchet ms</option>
        	<option value="verdana"<?php selected('verdana', $options['font']); ?>>verdana</option>
        </select>
    </td>
</tr>
<tr valign="top" class="options">
	<th scope="row">Color Scheme</th>
    <td>
    	<select name="ingboo-facebook-like[color_scheme]">
        	<option value="light"<?php selected('light', $options['color_scheme']); ?>>light</option>
        	<option value="dark"<?php selected('dark', $options['color_scheme']); ?>>dark</option>
        </select>
    </td>
</tr>
</table>
<h3>Location Settings</h3>
<table class="form-table">
<tr valign="top" class="options">
<th scope="row">Where would you like this displayed?</th>
<td>
    <label>Above Post <input name="ingboo-facebook-like[position]" type="radio" value="above"<?php checked('above', $options['position']); ?> /></label>
    <label>Below Post <input name="ingboo-facebook-like[position]" type="radio" value="below"<?php checked('below', $options['position']); ?> /></label>
</td>
</tr>
<tr valign="top" class="options">
<th scope="row">Show on front page?</th>
<td>
    <label>Yes <input name="ingboo-facebook-like[index]" type="radio" value="yes"<?php checked('yes', $options['index']); ?> /></label>
    <label>No <input name="ingboo-facebook-like[index]" type="radio" value="no"<?php checked('no', $options['index']); ?> /></label>
</td>
</tr>
<tr valign="top" class="options">
<th scope="row">Show on individual post?</th>
<td>
    <label>Yes <input name="ingboo-facebook-like[post]" type="radio" value="yes"<?php checked('yes', $options['post']); ?> /></label>
    <label>No <input name="ingboo-facebook-like[post]" type="radio" value="no"<?php checked('no', $options['post']); ?> /></label>
</td>
</tr>
<tr valign="top" class="options">
<th scope="row">Show on individual page?</th>
<td>
    <label>Yes <input name="ingboo-facebook-like[page]" type="radio" value="yes"<?php checked('yes', $options['page']); ?> /></label>
    <label>No <input name="ingboo-facebook-like[page]" type="radio" value="no"<?php checked('no', $options['page']); ?> /></label>
</td>
</tr>
<tr valign="top" class="options">
<th scope="row">Show on archive pages?</th>
<td>
    <label>Yes <input name="ingboo-facebook-like[archive]" type="radio" value="yes"<?php checked('yes', $options['archive']); ?> /></label>
    <label>No <input name="ingboo-facebook-like[archive]" type="radio" value="no"<?php checked('no', $options['archive']); ?> /></label>
</td>
</tr>
<tr valign="top" class="options">
<th scope="row" title="If you're using excerpts and want the Like button in the excerpt on the front page then set this value to Yes">Show in excerpts?</th>
<td>
    <label>Yes <input name="ingboo-facebook-like[excerpt]" type="radio" value="yes"<?php checked('yes', $options['excerpt']); ?> /></label>
    <label>No <input name="ingboo-facebook-like[excerpt]" type="radio" value="no"<?php checked('no', $options['excerpt']); ?> /></label>
</td>
</tr>
<tr valign="top" class="options">
<th scope="row" title="If you want to take complete control over when to insert the Like Button markup set this value to Yes.">Use by code modification?</th>
<td>
    <label>Yes <input name="ingboo-facebook-like[useCode]" type="radio" value="yes"<?php checked('yes', $options['useCode']); ?> /></label>
    <label>No <input name="ingboo-facebook-like[useCode]" type="radio" value="no"<?php checked('no', $options['useCode']); ?> /></label>
</td>
</tr>
  <tr valign="top">
    <td colspan="2">Setting Use Ads to Yes means that you agree to the <a href="http://www.ingboo.com/terms/ad_terms.html">terms and conditions</a>.</td>
  </tr>
<tr valign="top" class="options">
<th scope="row" title="Embed Facebook Like into a new frame with Ads.">Use Ads?</th>
<td>
    <label>Yes <input name="ingboo-facebook-like[useIframe]" type="radio" value="yes"<?php checked('yes', $options['useIframe']); ?> /></label>
    <label>No <input name="ingboo-facebook-like[useIframe]" type="radio" value="no"<?php checked('no', $options['useIframe']); ?> /></label>
</td>
</tr>
</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
<input type="submit" name="ingboo-facebook-like[reset]" class="button-primary" value="<?php _e('Reset Settings') ?>" title="Reset settings to default state. You need to re-enter email and password under General Settings"/>
</p>
</form>
</div>