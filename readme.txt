=== Facebook Like for Tags ===
Contributors: Tomas Lund @ Ingboo.com
Tags:facebook like,facebook like button,like button,facebook,like,like for tags,RSS, feed, feeds, RSS feed, RSS feeds, ingboo, plugin, social media, social plugin, share, sharing, tag, tags, search
Requires at least: 2.0
Tested up to: 3.0.1
Stable tag: 1.5

Use Facebook Like for Tags for ongoing updates and sharing. Share new posts with users who Liked your tags or categories before and earn money too!

== Description ==

**Power Facebook Like with Search, Tags and Feed Syndication!**

Pack more punch into Facebook Like. Expand from a one-time sharing event, to a permanent connection for ongoing updates and sharing based on post tags or categories. Now with money earning opportunities! Write your WordPress blog posts as you normally would. Define your posting with appropriate tags or categories. Once posted, it will have a Facebook Like button linked to it via the tags/categories you defined. Any reader who clicks the Facebook Like button will share the article but also receive additional updates anytime you write a post specifying the same tags.

**Use Case Example**

A WordPress blogger covers consumer electronics. She writes about the new Apple iPad. She defines this post by tagging it with "Apple", "iPad" and other tags. Readers who like the post and want to share via Facebook, click on the Facebook Like button. A few days later, the blogger writes another post about the next release of the Apple iPhone with the same tags. Shortly after posting the article, those readers who liked the earlier article will automatically receive an update in their Facebook news feed.

**Benefits**

*   ***Continuous sharing*** - This plugin implements a Facebook Like button and adds the IngBoo filtering, change-detect and notification logic to expand the button into a permanent connection for ongoing sharing and updates. 
*   ***Increased reach and revisits*** - Case studies show that this function can increase your page view by 25%-40%. 
*   ***Revenue - Enable advertisement with the Like button (optional) and earn money. This opens a new revenue stream for you via the IngBoo revenue share program.
*   ***Consumer intent*** - Your readers define what they are interested in by pressing the Like button. You define the context via the tags. When the tags provide a well-defined context you and your readers win. They get timely updates of relevant content into their new feeds and you get more revisits. 
*   ***A crowd draws bigger crowd*** - Anytime you post with prior tags, readers will likely see that others had Liked those tags. This attracts even more clicks on the Like button.
 
== Installation ==

Download the plugin archive and drop the contents into the wp-content/plugins directory of your WordPress installation. Activate the plugin from the plugins page and then configure the plugin settings. For detailed instructions, see below. This plugin requires PHP version 5 or higher.

**Detailed Installation Instructions**

Make sure you're WordPress installation is running PHP version 5 or higher.

*Enabling CURL (Apache server installations only)*

If you are running WordPress on an Apache server, you need to first enable CURL. If you use another web server (e.g., Microsoft IIS) or if you know that you already have CURL enabled, you can skip this step and go directly to the installation below. 

1.  Locate all php.ini files in your Apache directory. There may be multiple files with this name, located in bin\apache\apache 2.x.x\bin\php.ini, php\php.ini and php\phpX\php.ini. 
1.  Remove the semi-colon from ";extension=php_curl.dll" in all instances of php.ini. 
1.  Save each file.

*Installation*

1.  Download the plugin archive to a local folder (e.g., c:/temp). 
1.  Login to your WordPress Admin Dashboard. 
1.  Locate "Plugins" in the left column and select "Add New". 
1.  Select "Upload". 
1.  Browse to the folder for the plugin archive (e.g., c:\temp). 
1.  Select the plugin zip-file (like-for-tags.zip) and click "Install Now". 
1.  Select "Activate Plugin". 
1.  Proceed to configure the plugin settings (see below).

**Configure Plugin Settings**

Before using the plugin, you need to configure the plugin settings. Locate "Plugins" in the left column and click "Like for Tags".

*General Settings*
1.  Enter a valid email address and a password that you can remember. For example, use the name of the blog (e.g., myblog@gmail.com). The email address is used to uniquely identify your plugin later. This will also allow you to further configure the plugin in Partner Central (<http://www.ingboo.com/pc>) later (e.g., upload your own brand logo for the news feed updates). 
1. Optional: You can point to a logo that will be used in the Facebook News Feed updates. This logo is ideally 100x100 in lng, gif or jpg format. The logo must reside on a web server and be externally accessible.
1.  Select if you want the Like button to by tags or categories. It is recommended that you use categories since it usually provides the best balance between context and update frequency for users.

*Facebook Settings*

1.  Proceed to configure the look and feel of the Like button itself. For more detail on Facebook Like buttons, visit Facebook Developer Forum.
1. You can fix the width that the Facebook iframe will occupy.

*Location Settings*

1.  Select if you want the Like button to appear above or below your posts (see also custom locations below). 
1.  Decide if you want the Like button to appear on the main blog page for each visible post (most likely "yes"). 
1.  Decide if you want the Like button to appear on individual posts (most likely "yes"). 
1.  You can also enable a Like button on WordPress pages. This will connect the Like button with your RSS feed for unfiltered streaming of all your posts. Examples of pages include about-pages, press-pages, etc.
1.  Decide if you want to show Like buttons in archive pages (most likely "yes"). Many blogs use archives to filter posts by categories or tags.
1.  Decide if you want to show Like buttons in excerpts. Some themes use excerpts on the main/front page of the blog. This will turn on the buttons for the excerpts posted there as well.
1.  If you use Custom Location (see below) for the Like button, you can turn off the default display completely by setting "use by code modification" to "yes" (default is "no").
1.  If you want to participate the revenue share program, you should enable advertisement. The preview will show you what this looks like. By enabling ads, you are also agreeing to the IngBoo terms and conditions for advertisement at http://www.ingboo.com/ad_terms.html.

**Making Changes to Individual Posts**

*Turning OFF the Like Button*

You can turn off the Like button for individual posts by the use of a Custom Field called "like" and set it's value to "false". You can also override the button location by using the same Custom Field. Set it to "above" to place the Like button above a post. Similarly, set it to "below" to place it below the post.

*Custom Locations*

It is possible to pick a custom location for the Like button. This is sometimes desired due to how certain themes display content. When doing this, you should always set the custom field - "like = false" or, you should turn off default location altogether by settings "use by code modification" to "yes". After this, you invoke the function call for the button:

      <?php if (class_exists("IngbooFacebookLike")) {
        echo $IngbooFacebookLike->getLike();
       }
      ?>


**IMPORTANT!** With the email address and password, you can now visit Partner Central (<http://www.ingboo.com/pc>) to further configure your plugin. It is recommended that you at minimum upload your own image (logo, picture, etc.) for your blog before putting the Like button to use (if you did not do this already in step 3 above).

**Installing Plugin Updates**

Every now and then, there will be a new plugin version available. These instructions explain how to install and enable these updates.

If you are running version 1.3 or later of the plugin, you can use the upgrade procedure from within your WordPress Admin Dashboard. For release 1.3 and later, configurations are preserved and will propagate to the upgrade versions. 

If you are using versions before 1.3 you need to follow the instructions here:

1.  Login to the Admin Dashboard for your WordPress blog. 
1.  Locate "Settings" in the left column and click "LikeForTags". 
1.  Note the email address you used for the plugin. If you don"t remember the password, go toPartner Central (<http://www.ingboo.com/pc>) and select "Login". Fill in the email address and select "Forgot Password". A new password will be sent to you. 
1.  Select "Plugins" in the left column, then Deactivate LikeForTags followed by a Delete. 
1.  When prompted click on "Delete These Files". 
1.  Proceed to the instructions for Installation and Configure Plugin Settings.

**IMPORTANT!** If the install fails, you may have to stop and then restart the web server since it may be holding on to the file resources and blocking a new install. This typically happens with Microsoft IIS server. Also remember that you can always configure the plugin further <http://www.ingboo.com/pc>. If you have used your original email address, prior settings in Partner Central are preserved.

**Deactivating/Activating the Plugin**

If you want to change settings, you will need to select "Reset Settings". This will revert settings to default values. If you want to reconnect the button with your earlier configuration, you need to re-enter email address and password.

Deactivating and then reactivating a plugin may reset settings to default (for releases before 1.3). You will need to go back into settings and Like For Tags to re-enter the previously used email address and password before using the Like button again. Any settings done in Partner Central remain intact though.

You can selectively disable the Like button for individual posts by setting a Custom Field "like = false".

== Screenshots ==
1. Like for Tags - Settings Form
1. Partner Central Preferences Form

== Changelog ==

= 1.5 =

* Added support for advertisement
* Added support for archive pages

= 1.4.2 =

* Added a link to the Settings in the Plugin list

= 1.4.1 =

* Move placement of configuration settings to better support Multi User blogs (from Settings tab to Plugins tab)
* Exposing a way for developers to get hold of the Like markup to insert in a post.

= 1.4 New configuration features =

* Make the setting of the height of the iframe configurable
* Adding support to show Like buttons on pages and when using excerpts
* Added help to the settings screen
* Adding more values to the custom field like: Placement of Like can be specific to a post by specifying the values above or below.
* Added box_count as a new layout option

= 1.3.1 Fixing the height of the Like frame =

= 1.3 New configuration features =

* Future upgrades will restore prior settings.
* Hiding fields that are not editble by the user (Partner ID and Topic ID)
* Allow configuration of a custom logo via URL.
* Selectively turn off button via Custom Field - like=false.

= 1.2.2 Adding a FAQ section to the readme.txt =

= 1.2.1 Minor changes in default options. =

= 1.2 Fixing a template issue from initial checkin into wordpress svn. =

= 1.1 First release =

== Upgrade Notice == 

= 1.4.1 =
If you already use the plugin no changes are needed.
= 1.2.1 =
If you already use the plugin no changes are needed.

== Frequently Asked Questions ==

Q: I just published a new post on my blog. How long before it will show in my
readers' Facebook news feeds?

A: It can take up to three(3) hours before the update shows up in the Facebook
news feeds due to a combination of factors, including how Facebook manages news
feeds and updates. IngBoo is currently performing change-detect 8 times per
day, which also impacts the time to publish.

Q: How do I set my own logo in the news feed updates?

A: Go to http://www.ingboo.com/pc and select "login".
Login using the email address and password you used for the plugin.
Select "preferences" and upload a partner image. Use PNG, JPG or GIF, ideally
100x100.

Q: What is Partner ID and Topic ID?

A: These two values uniquely identifies you and your blog to the system. You
can essentially ignore these values. Instead, keep a note of the email address
and password you used for the plugin.

Q: Is this really a Facebook Like button or is it a look-a-like?

A: This is the real thing. The resulting iFrame is a Facebook iframe, calling
Facebook and using Facebook Open Graph. There are no smoke and mirrors here.
IngBoo contributes with its change-detect-notification engine, which automates
the whole syndication process in the background by making Open Graph API calls
and responding to Facebook calls.

Q: I have additional questions. Where do I send them?

A: Feel free to send us questions, feedback or ideas to support@ingboo.com

Q: I want to disable the Like button on a post, how do I do that?

A: You set a Custom Field for the post in question. Set the value to "like = false". This will stop the button for showing for that post.

Q: Does this tool connect the user to my Facebook Fan Page?

A: No, it creates a direct connection between your web site/blog to the Facebook News Feed of your readers. If you already have a Fan Page, you should keep it. It is a complement to your Facebook Fan Page, not a replacement.

Q: I want a Like button for my full RSS feed, can you help me with that?

A: Yes, send us an email to support@ingboo.com with your RSS feed URL and we will send you the HTML code for this.

Q: I don't want to use this service anymore, what do I have to do?

A: You should deactivate and delete the plugin. You do this from the WordPress admin dashboard. Look under plugins and locate "Facebook Like for Tags". The IngBoo service will continue serving updates to those users who are connected to your web site. If you want to stop that as well, please send an email to support [at] ingboo.com.

==Readme Generator== 

This Readme file was generated using <a href = 'http://sudarmuthu.com/wordpress/wp-readme'>wp-readme</a>, which generates readme files for WordPress Plugins.
