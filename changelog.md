# Layers Changelog

=======
##2.0.7
### 17 November 2017

* **Enhancement** - Added more detailed class names to the blog single page for easier CSS declaration. *DP*
* **Fix** - Fixed some default WooCommerce styling, taking their new class names into consideration. *DP*

* **Fix** - Fixed "delete_theme_mod" warning when changing themes. *MP*
* **Fix** - Fixed our customized color pickers after the recent WP update has changed the HTML structure (with backwards compatibility). *SOB*

=======
##2.0.6
### 01 September 2017

* **Enhancement** - Added support for RTL in the customizer. *MP*

=======
##2.0.5
### 10 July 2017

* **Enhancement** - Unit Test Styling added. *DP*

=======
##2.0.4
### 16 June 2017

* **Fix** - Attachment pages which weren't showing images. *MP*
* **Fix** - Comments showing up for password protected posts. *MP*
* **Fix** - Full screen slider JS was using the wrong selector. *MP*


=======
##2.0.3
### 12 June 2017

* **Fix** - Brought back the remove and close buttons from the widgets which went missing in WP 4.8. *MP*

=======
##2.0.2
### 06 June 2017

* **Enhancement** - Adjusted Sidebar in V. Customizer to cope with new responsive settings in WP 4.8. *DP*

=======
##2.0.1
### 08 May 2017
* **Fix** - Fixed margin & padding setting in widgets. *MP*

=======
##2.0.0
### 02 May 2017

* **Enhancement** - All widgets now use accorcion interface. *MP*
* **Enhancement** - Framework preparation for Layers Pro 2. *MP*
* **Enhancement** - Updated Web Sans font. *MP*
* **Tweak** - Moved slider Margin & Padding to the layouts tab, inline with the ther widgets. *MP*
* **Fix** - Fixed warning when enabling tags in post lists. *MP*



=======
##1.6.6
### 04 April 2017

* **Enhancement** - WooCommerce 3.0 compatability. *MP*
* **Enhancement** - Selecting a new image inside the image controller now clears the old image. *MP*
* **Enhancement** - Clicking out of the sidebar now closes it. *MP*
* **Enhancement** - Added confirmation modal when removing a widget. *MP*
* **Enhancement** - Added the option to disable the Layers Open Graph tags. *MP*

=======
##1.6.5
### 05 Dec 2016

* **Enhancement** - Added Poppins Google Font. *MP*
* **Enhancement** - Removed underlines from icons in preparation for WordPress 4.7. *DP*
* **Enhancement** - Updated theme to utilize the new Additional CSS block in WordPress 4.7. *DP*

=======
##1.6.4
### 18 Nov 2016

* **Fix** - Layers icon font no longer shows a broken layers logo. *DP*
* **Fix** - Fixed compatability with Endurance Page Cache plugin. *MP*
* **Fix** - Fixed Static Blog page where sidebar would fall below content. *MP*

=======
##1.6.3
### 09 Nov 2016

* **Fix** - Menu fonts now apply to the automatic header menu (page list). *MP*
* **Fix** - When adding a new post-widget and enabling Masonry in the customizer, it no longer breaks. *MP*
* **Fix** - Breadcrumbs bug in category view when static blog page has not been set is now fixed. *MP*
* **Enhancement** - Added a toggle to disable analytics when logged in. *MP*
* **Enhancement** - New icon fonts added to Layers Interface icon set. *DP*
* **Enhancement** - Input type "image" no longer spans 100% of the screen. *DP*

=======
##1.6.2
### 06 Oct 2016

* **Fix** - Fixed sticky header feature. *MP*

=======
##1.6.1
### 04 Oct 2016

* **Fix** - Fixed Header Overlay when adding an anchor to the first slide on a page. *MP*
* **Fix** - Added ImagesLoaded to the slider resize trigger. *MP*
* **Fix** - Updated Marketplace queries. *MP*
* **Fix** - Mobile Sidebar toggle now works in the customizer. *MP*
* **Enhancement** - Added new icon fonts for typography management. *DP*
* **Enhancement** - Updated OG meta to accept featured image and excerpt for pages. *MP*
* **Developer Enhancement** - Added ability to group controls in one Design Bar form area using the `group` option, which accepts any form array args. *MP*


=======
##1.6.0
### 13 Sep 2016

* **Fix** - Full width map no longer has 10px gutters to the left and right of the map. *DP*
* **Fix** - Updated the preset layout, page import and duplicate page nonce actions to be more specific as not to be confused by any other nonce actions. *MP*
* **Enhancement** - Added new Header Sidebar layout option. *MP*
* **Enhancement** - Updated the Waypoints plugin to version 4.0. *MP*
* **Enhancement** - Added the default theme color to the onboarding for Child Themes. *MP*

=======
##1.5.8
### 05 Sep 2016

* **Fix** - Fixed Duplicate button for widgets which have no accordian titles. *MP*
* **Enhancement** - Added a `Header Menu` font selector. *MP*

=======
##1.5.7
### 01 Sep 2016

* **Fix** - Fixed Google Maps API on the front-end of the site. *MP*
* **Fix** - Columns widths from span-4 to span-11 no longer collapse when masonry or video content is in there. *DP*
* **Fix** - Fix repeater titles (Content, Slider, etc) so they dynamically display and dynamically update. *SOB*
* **Tweak** - Tweaked the column width of shop list pages (was previously span-3, now span-4). *DP*
* **Enhancement** - Added accordian duplication feature. *SOB*
* **Enhancement** - Added new Layers Add On listings. *MP*

=======
##1.5.6
### 11 Aug 2016

* **Fix** - Fixed thumbnail body + title spacing. *DP*
* **Fix** - Fixed "logged-in-as" styling (text directly below comment title). *DP*
* **Fix** - Fixed 'Clear' not working on the Customizer Controls colors. *SOB*
* **Fix** - Fixed erroneous map URL sitting in `functions.php`. *MP*
* **Fix** - Fixed Complete Setup in dashboard. Thanks @easterncoder
* **Fix** - Marketplace link overrides Layers Pages link on Dashboard tabs. Thanks @easterncoder
* **Fix** - Fixed `</script>` tag bug in the Discover Photos tab. Thanks @tokkonopapa
* **Fix** - Fixed errant `<a href="">` in the author tags. Thanks @flagsoft
* **Enhancement** - Improved styling of range sliders in the customizer. *SOB*
* **Enhancement** - Improved text strings. Thanks @maheshwaghmare
* **Fix** - Fixed Complete Setup in dashboard. Thanks @easterncoder !
* **Fix** - Marketplace link overrides Layers Pages link on Dashboard tabs. Thanks @easterncoder !
* **Fix** - Fixed `</script>` tag bug in the Discover Photos tab. Thanks @tokkonopapa !
* **Tweak** - Removed the Chrome FOUC fix that would re-apply font-size to the body in the Customizer to prevent FOUC. *SOB*

=======
##1.5.5
### 15 July 2016

* **Enhancement** - Added the Google Maps API Key input, reconfigured the position of the script inputs. *MP*
* **Enhancement** - Added .meta-info-vertical to override inline meta items for the project pages. *DP*
* **Enhancement** - Added .meta-info-vertical to override inline meta items for the project pages. *DP*
* **Enhancement** - Added new WooCommerce My Account Page CSS. *DP*
* **Fix** - Fixed word-wrap issue in `.story` and `.copy` divs. *DP*
* **Tweak** - Nav Pill CSS has slightly more padding for better text alignment. *DP*
* **Tweak** - Change the way we enqueue our slider script and css to rather use the WP register & enqueue functions. Allow us to enqueue wherever needed. *SOB*
* **Tweak** - Change the way we enqueue our masonry script, same as above. *SOB*

=======
##1.5.4
### 22 June 2016

* **Enhancement** - Updated Font Awesome to version 4.6.3 *MP*
* **Enhancement** - Enable WordPress Selective Widget Refresh - widgets update much faster by sending changes via JS, no page refresh required. *SOB*
* **Enhancement** - Fade-in the Slider only after it has been initialized. *SOB*
* **Fix** - Fixed sub-menus when header menu is not yet set. *MP*
* **Fix** - Bring back shift-click to edit Layers widgets in the Customizer. This was removed by changes in the widget container format in a recent WP update. *SOB*
* **Fix** - off-canvas cart buttons are no longer breaking. *DP*
* **Fix** - Gallery captions now display correctly in blog posts. *DP*
* **Fix** - Images in posts are no longer display: block which was forcing them onto a new line. *DP*


=======
##1.5.3
### 30 May 2016

* **Fix** - WooCommerce grid update during checkout. *DP*

=======
##1.5.2
### 30 May 2016

* **Fix** - Fixed sub-category listing pages. *MP*
* **Fix** - Updated Layers Pro upsell links.*MP*
* **Fix** - Added conditional statements around `Layers_Widget_Migrator` where needed. *MP*
* **Tweak** - Added a check to make sure that we never output two main titles on one page - Blank Page template. *SOB*


=======
##1.5.1
### 26 Apr 2016

* **Fix** - Changed some legacy references from `plugins_url()` to `LAYERS_TEMPLATE_URI`. *SOB*
* **Fix** - Fixed standard widget layout on Layers pages. *MP*
* **Tweak** - Changed `get_the_permalink()` to `get_permalink()`. *SOB*

=======
##1.5.0
### 22 Apr 2016

* **Fix** - Added `"` marks around fonts when using Google fonts, so that now fonts with a space in the name load without issue. *MP*
* **Fix** - Fixed multiple maps on one page. *MP*
* **Fix** - Fixed post widget button color selection. *MP*
* **Fix** - Full width footer no longer touches sides, padding left-right has been added. *DP*
* **Fix** - Fixed Image-botton icon. *DP*
* **Fix** - Onboarding typo's. *DP*
* **Fix** - `get_currentuserinfo()` warning in 4.5 is gone. *MP*
* **Fix** - Fixed aligncenter bug in blog posts which stopped images from centering. *DP*
* **Fix** - Last item in in horizontal design bar Drop down now opens right: 0 to avoid overflow bug. *DP*
* **Tweak** - Replaced all `<section />` containers with `<div />` in order to reverse engineer better SEO as Layers progresses. *DP*
* **Tweak** - Fixed associated CSS where section[class] was used. *DP*
* **Tweak** - Show Address and Show Form are now defaulted to on in the conact widget. *MP*
* **Tweak** - Fixed WooCommerce tab alignment issue in responsive mode. *DP*
* **Tweak** - .story img changed from 98% to 100% width. *DP*
* **Tweak** - Re-added product quantity in the mobile cart view. *MP*
* **Tweak** - Change how `layers-interface-init` Javascript event is triggered so it can be used to initialize not only the Widgets but also the Customizer Controls. *SOB*
* **Tweak** - Remove `layer_enqueue_init()` function - it's no longer needed now that the Customizer only loads Widget forms when needed, not all at once resulting in Firefox hanging. *SOB*
* **Enhancement** - Entirely new grid code which allows for different columns in the same content widget, using flexbox and calc(). *DP*
* **Enhancement** - Added subtle animation to .sub-menu drop down. *DP*
* **Enhancement** - Added Open Graph meta support. *MP*
* **Enhancement** - Added margin and padding (top and bottom) to the Content widget columns (See design-bar > advanced). *SOB*
* **Enhancement** - Added 6 new icons to the Layers back end font family h1-h6 to cater for new SEO features. *DP*
* **Enhancement** - Darken now works on all widgets. *DP*
* **Enhancement** - Feature list (tick/cross) added to components CSS as part of new cheat-sheet CSS. *DP*
* **Developer** - 'show_trash' declaration in the design bar now requires an explicit TRUE flag. *MP*
* **Developer** - `id="post-<?php the_ID(); ?>"` now applies to the `<article>` wrapper in single posts & pages. *MP*
* **Developer** - Added `id="post-list"` to post archive containers. *MP*
* **Developer** - Changed Off-canvas sidebar from a `section` to `div`. *MP*

=======
##1.2.14
### 16 Feb 2016

* **Fix** - Removed all custom CSS being output from `the_content();` in Layers Pages. *MP*
* **Fix** - Fixed Google Maps API warning when using the contact widget. *MP*
* **Fix** - Fixed Image-Bottom icon. *DP*
* **Fix** - CSS Class hiding customizer panel titles. *MP*
* **Enchancement** - Added the Kanit Google font to the font list. *MP*
* **Enchancement** - Updated WooCommerce template override versions. *MP*
* **Enchancement** - Limited Messenger to administrators for sites, to avoid editors & subscribers from getting an Messenger popup. *MP*
* **Enchancement** - Added device width to viewport meta. *MP*

=======
##1.2.13
### 18 Feb 2016

* **Fix** - Custom classes inside widgets now work correctly. *MP*

=======
##1.2.12
### 17 Feb 2016

* **Fix** - Fixed `layers_get_builder_pages()` so that it gets all possible post_status, especially auto_draft. *SOB*
* **Fix** - Fixed Layers Marketplace price in the modal. *MP*
* **Fix** - Fixed T_PAAMAYIM_NEKUDOTAYIM error. *MP*
* **Fix** - Pagination is now fixed when your blog page is set as the home page. *MP*
* **Fix** - Invalid characters in the CSS description. *MP*
* **Tweak** - CSS now loads mainly in the site's header, core widgets have CSS blocks beneath them, avoiding FOUC. *MP*
* **Tweak** - When adding a new page, we no longer prefill the page title block, we simply use a placeholder. *MP*
* **Enhancement** - Implemented new Linking Interface in widgets: link to existing content (pages, posts, etc) using search functionality + enables 'open-in-new-tab' functionality *SOB*

=======
##1.2.11
### 04 Feb 2016

* **Fix** - Fixed the custom widget anchors. *MP*
* **Fix** - Removed Google Analytics when users are in the customizer. *MP*
* **Fix** - Fixed page title when front page is set to static page to display the shop. *MP*
* **Fix** - Fixed margin-right bug in tablet mode on rows that span full width. *DP*
* **Fix** - Fixed author `<a href />` for Portuguese translations. *MP*
* **Fix** - Fixed Top/Right/Bottom/Left labels in design bar. *DP*
* **Fix** - Transparent Overlay containing background image now works. *DP*
* **Fix** - Fixed word-wrap issue in RTE when text is pasted in. *DP*
* **Fix** - Fixed pagination not working when `Blog` page is set as `Front page` (`Settings > Front page`). *SOB*
* **Fix** - Fixed tabbed navigation in the WP Dash. *DP*
* **Tweak** - .header-secondary left/right padding was out on large screens - fixed. *DP*
* **Tweak** - Removed width 100% from .media-body. *DP*
* **Tweak** - .nav-tabs colors now more dynamic for better background color/image handling. *DP*
* **Tweak** - .header-site nav-horizontal link spacing (padding/margin) has been adjusted to cater for Layers Pro customization. *DP*
* **Tweak** - Removed opacity: 0.x settings and replaced with rgba on .invert classes. *DP*
* **Tweak** - Fixed menu verticle alignment quirks in header-center layout. *DP*
* **Tweak** - Split admin.css into three separate files for easier management and distinction between dashboard, customizer and global css. *DP* *SOB*
* **Tweak** - Move plugin .js and .css files to `core/assets/plugins/`. *SOB*
* **Tweak** - Don't load Google Analytics in the Customizer. *SOB*
* **Tweak** - Added the `show-if-operator` functionality: `==`(defaults) or `!=` or `>=` or `<=` or `<` or `>`. *SOB*
* **Tweak** - Added the `show-if` logic to the Post Widget meta information when selecting overlay. *MP*
* **Tweak** - Post widget defaults now include "on" for pagination and `posts_per_page` mimmics WP settings. *MP*
* **Enhancement** - Updated marketplace filters. *MP*
* **Enhancement** - Added an extra level of depth to the widget `get_custom_field_name()` and `get_custom_field_name()` functions. *MP*
* **Enhancement** - Implemented the new Layers Page Revision feature. *MP*

=======
##1.2.10
### 08 Dec 2015

* **Tweak** - Flexbox header CSS clean and much less hacky. *DP*
* **Tweak** - Updated Envato Marketplace to list themes by last updated by default. *MP*
* **Tweak** - Updated Envato Marketplace to show the filter information as an intro. *MP*
* **Tweak** - Updated the Layers Messenger to show plugin version. *MP*
* **Tweak** - Removed Transparent overlay reliance on the Sticky header setting. *MP*
* **Tweak** - The design bar Background image interface has been redesigned to cater for video backgrounds. *DP*
* **Tweak** - Added `Blog > Archive` & `Blog > Posts & Pages` panels and sections, replaceing `Site Settings > Sidebars`. *MP*
* **Enhancement** - .button-collection has been refined to cater for .button-social and preparation for more inline buttons in original widget. *DP*
* **Enhancement** - Added a new filter to design bar controls in preparation for further Layers Pro features. *MP*
* **Enhancement** - Added a new hooks to the the core Layers widgets, such as `layers_after_slider_widget_inner` . *MP*
* **Enhancement** - Added `layers_get_vimeo_id` and `layers_get_youtube_id` functions to `helpers/template.php`. *MP*
* **Fix** - Fixed the space between title and colon ":" in the slider and content widgets. *MP*
* **Fix** - Fixed dynamic updating of repeater widget item titles. *MP*
* **Fix** - Fixed round image ratio in the posts widget. *MP*
* **Fix** - Fixed round image ratio CSS in the posts widget. *DP*
* **Fix** - Breadcrumbs were throwing an undefined object error in some intances. *MP*
* **Fix** - Fixed slider arrow centering when layout-boxed is chosen. *MP*
* **Fix** - Fixed the presence of an empty div when a post in the archive page has no content. *MP*

=======
##1.2.9
### 20 Nov 2015

* **Fix** - Fixed header alignment in Safari 8. *DP*
* **Fix** - Fixed slider alignment in Safari 8. *MP*

=======
##1.2.8
### 18 Nov 2015

* **Fix** - Removed the menu warning when logging in as a non-admin user. *MP*
* **Fix** - Fixed an `undefined object` error  in `/helpers/extensions.php`. *MP*
* **Enhancement** - Added a new custom anchor function to the widget advanced options in core widgets. *MP*
* **Enhancement** - Adjusted the image ratio logic for the content widget when using a 3 < column layout. *MP*
* **Enhancement** - Added `https://` support for all onboarding videos. *MP*
* **Enhancement** - Added new filters for the design bar components of the slider & content widget repeater items eg `layers_slide_widget_design_bar_components` *SOB*
* **Tweak** - Added price animation in Woo Widget overlay setting. *DP*
* **Tweak** - Changed header tp use flexbox css for *DP*

=======
##1.2.7
### 03 Nov 2015

* **Tweak** - Added a name input to the onboarding process so that we can reference a real person in Layers Messenger. *MP*
* **Fix** - Added https:// support to the onboarding and migrator external urls (videos and images). *MP*
* **Fix** - Adding a new slider threw an error until updated. Now the first add works straight up. *SOB*
* **Fix** - Fixed JS error notice when changing Font select. *SOB*
* **Enhancement** - Header CSS now converted to flexbox for better handling of Layers Pro and general framework modernization. *DP*

=======
##1.2.6
### 28 Oct 2015

* **Tweak** - Created Using Layers icon is 50% smaller *DP*
* **Tweak** - Changed "Preview this Page" to "View this Page" *DP*
* **Tweak** - Changed Customizer headings: 'Layout' becomes 'Styling', 'Logo & Menu Position' becomes 'Header Arrangement', 'Header Style' becomes 'Features'. *SOB*
* **Tweak** - Changed existing Layers Widgets to use the new method to add custom fields or field-groups to the design-bar. (see content, post, contact widgets for example. slider was left using old method to test backward-compatibility) *SOB*
* **Tweak** - Added classnames to the Layers widgets - `layers-contact-widget`, `layers-content-widget`, `layers-post-widget`, `layers-slider-widget`. *SOB*
* **Tweak** - Customizer controls take 'colspan' arg that controls it's column span eg 3 will span 3 of 12 column grid. *SOB*
* **Tweak** - TRBL Customizer control can be limited to use just 'top' and 'bottom' by using the 'fields' setting and passing args array of required fields. *SOB*
* **Tweak** - To set customizer controls classnames use: `class` to add to the the `container` classname, and `input_class` to add to the `input` classname. *SOB*
* **Tweak** - `layers_inline_styles()` now outputs cleaner more human-readable CSS block. *SOB*
* **Tweak** - Move slider height settings to the top of the settings pop menu. *DP*
* **Fix** - Auto-height slide no longer breaks when you only have one slide. *DP*
* **Fix** - Fixed "Powered by Envato" typo in marketplace. *MP*
* **Fix** - Fixed an empty search page. *MP*
* **Fix** - Focus slide fix, when entering the customizer. *MP*
* **Fix** - Auto padding on top of first widget when is unique widgets like slider now also takes into account the custom padding added by user there to start with. *SOB*
* **Enhancement** - All WooCommerce widgets no longer look broken when placed in the footer widget areas. *DP*
* **Enhancement** - Cart quantity color is now dynamic using rgba values. *DP*
* **Enhancement** - General WooCommerce widget clean up. *DP*
* **Enhancement** - Added Range `layers-range` Customizer control. *SOB*
* **Enhancement** - Added Heading Divider `layers-heading-divider` Customizer control. *SOB*
* **Enhancement** - Added TRBL (Top, Right, Bottom, Left for Padding and Margin) `layers-trbl-field` Customizer control. *SOB*
* **Enhancement** - Added Customizer state-remembering to the Panels, Sections and Widgets so position gets remembered across page-refresh (added in off-state till further testing). *SOB*
* **Enhancement** - Added Reset-to-Default button to the controls (added in off-state till further testing). *SOB*
* **Enhancement** - Made Font-Awesome available to the theme front-end - `registered` but not `enqueued` so plugin devs can enqueue it by it's hook `layers-font-awesome`. *SOB*
* **Enhancement** - Added framework method for doing Repeated Content in the Widgets using the following helper functions `register_repeater_defaults()`, `repeater()`, `get_layers_field_name()`, `get_layers_field_id()`. (see extension-boilerplate - coming soon - and the Layers Widget help docs for more information) *SOB*
* **Enhancement** - Added new method to add fields or field-groups to the Layers Design-Bar. (see Design-Bar help docs for more information) *SOB*
* **Enhancement** - Added animations to make deleting items in the widgets (with repeater items) more explanatory and friendly. e.g. Columns and  Slides. *SOB*
* **Enhancement** - Added custom jquery-easing to use with Widgets on front-end - `layersEaseInOut`. *SOB*
* **Enhancement** - Slider CSS completely re-written to work with Flexbox, more reliable centering and auto-heighting. *DP*
* **Enhancement** - Slider CSS has been split between components and responsive.css where relevant to screensize. *DP*
* **Enhancement** - Image-bottom slider setting now available. *DP*
* **Enhancement** - Large font in the slider now resizes to medium in responsive mode. *DP*
* **Enhancement** - Change list Read More button to be rendered by an action 'layers_list_read_more' - allow disabling, and a filter to get the text 'layers_read_more_text' - allow modifying *SOB*
* **Enhancement** - Layers Messenger, now you can chat to Layers team in your dashboard! *MP*

=======
##1.2.5
### 01 October 2015

* **Tweak** - We have removed the `esc_html()` from widget titles, this allows for the use of basic HTML tags like `strong`, `span` etc. inside headings. *MP*
* **Tweak** - Edit Layout button in the admin-bar now shows on all pages - not just layers pages - as even non Layers pages can have colors, layout, etc Edited. *SOB*
* **Tweak** - .title padding is now set on the parent container to accommodate for future features and better font size control. *DP*
* **Tweak** - .amount color has been moved to the .price wrapper. *DP*
* **Tweak** - Remove 'Edit Layout' from the admin-bar as it is redundant now that WP has added 'Customize' to the admin-bar. *SOB*
* **Fix** - Corrected the widget anchor IDs, also made the input disabled=FALSE so that they're highlightable. *MP*
* **Fix** - Fixed clearing issue with large rows on responsive screens. *DP*
* **Enhancement** - .title line-height is more compliant to font changes. *DP*
* **Enhancement** - Fixed WooCommerce category listings in the shop page. *MP*
* **Enhancement** - Search box no longer brakes to two lines in the footer. *DP*
* **Enhancement** - Transparent background color added to Woo product meta. *DP*
* **Enhancement** - Off canvas pop out has a new close button and the site-wrapper goes 20% darker when pop out is open. *DP*
* **Enhancement** - Introduciton of the in-app Marketplace. If you are a developer and want to disable this feature just add `define( 'LAYERS_DISABLE_MARKETPLACE', true );` to your `wp-config.php` file. *MP*

=======
##1.2.4
### 17 August 2015

* **Fix** - WooCommerce - Products in archive pages now obey the WooCommerce column settings. Thanks @martin_adamko. *MP*
* **Fix** - WooCommerce - Products in the cart page no obey the column settings. *MP*
* **Fix** - Default WooCommerce sites no longer have a forced #f3f3f3 site accent color. *MP*
* **Fix** - 4.3 bug. Added conditions around the code which moves the default customizer sections around. *MP*
* **Fix** - 4.3 customizer styling *DP*
* **Fix** - Fixed  `Undefined index: google_maps_zoom in layerswp/core/widgets/modules/contact.php on line 181` error. *MP*
* **Tweak** - `.form-allowed-tags` .2rem smaller font-size. *DP*
* **Tweak** - Changed Overlay to Transparent Overlay in the customizer.
* **Tweak** - Changed the behaviour of the overlay to be fully transparent or fully opaque - not semi-transparent at any time. *SOB*
* **Enhancement** - Tidy up of some `.sidebar` css code. *DP*
* **Enhancement** - Menu items with sub-menus now have down arrow and right arrows (using Layers Icon font). *DP*
* **Enhancement** - Added a 'grab' cursor to sliders with more than one slide. *DP*
* **Enhancement** - Added demo_store announcement css. *DP*
* **Enhancement** - Header Cart changes - including css tidy and removal of background color on cart-total span. *DP*


=======
##1.2.3
### 07 August 2015

* **Fix** - Re-added the `.container` class to `page.php`, `template-right-sidebar.php`, `template-left-sidebar.php` and `template-both-sidebar.php`.
* **Fix** - Inverted footer menu links now display on dark backgrounds
* **Tweak** - Onsale badge now dynamic with addition of a transparent background color.
* **Enhancement** - Added margin bottom to H6 in .copy and `.story`.
* **Enhancement** - Last menu item sub menu no longer falls off the screen.
* **Enhancement** - Added a zoom level setting to the Contact widget.

=======
##1.2.2
### 24 July 2015

* **Fix** - Category and Tag header titles are now correct, no longer relying on the `single_cat_title();` function.
* **Fix** - Post List view in the Post Widget now works correctly obeying the display options too.
* **Fix** - `post_class();` was missing from article wrapper in content-list.php, we've added it in now.
* **Fix** - Author Title missing from Post Author archive page.
* **Fix** - Fixed post image links in the post widget, archive pages and single pages.
* **Enhancement** - Corrected the `$content_width;` in `functions.php`.
* **Enhancement** - Removed html excaping from the footer, so that users can use basic HTML in their footer text.
* **Enhancement** - Changed the Layers Widget constructors in preperation for `WordPress 4.3`.

=======
## 1.2.1
### 03 July 2015

Hotfix for the new RTE feature

* **Fix** - The RTE now allows `script` tags as not to affect existing installs.
* **Fix** - Hiding of the text editor before initialization now uses a less specific class than `.hide`.

=======
## 1.2.0
### 30 June 2015

Security updates, new RTE feature

* **Fix** - Tags in post meta all around the theme are now fixed.
* **Feature** - Introducind the Rich Text Editor!
* **Security** - Added extra checks on the Theme Options partial loader logic.
* **Security** - Decreased the usage of `extract` to avoid $GLOBAL[] overwrites in widget forms.
* **Enhancement** - Changed concat method for echo functions in some files to enhance performance.
* **Enhancement** - Up to 800% speed improvements on the initialization of the customizer.

=======
## 1.1.5
### 05  June 2015

Hotfix

* **Fix** - Layers page imports are fixed for imports with a lot of JSON involved.
* **Fix** - Post widget pagination now works when you're using the Post Widget in a non-front page page. Fixes #130.
* **Fix** - Deleted `partials/portfolio-list.php`, it is unused.
* **Fix** - Corrected the map pin when using Longitude and Latitude. Fixes #128.
* **Fix** - When using just a link and link text in a content widget column, there is no need to enter in a blank excerpt to get the button to show.
* **Fix** - Google Analytics in the Dashboard quick start now saves. Fixes #162.
* **Fix** - Removed duplicate code for loading the the Widgets Initialization files.
* **Tweak** - Moved to MailChimp from Campaign Monitor for the newsletter signup form in the Layers Dash.
* **Tweak** - DevKit and ColorKit mentions added to customizer.
* **Enhancement** - Added bit.ly links to the dashboard marketplace buttons.
* **Enhancement** - Each column in the content widget now gets a class which includes the columns $guid making for better CSS targeting.
* **Enhancement** - Added `layers_before_blog_template` and `layers_after_blog_template` hooks to the `template-blog.php` page template.
* **Enhancement** - Added `layers_after_single_title` hook and moved the `layers_before_single_title_meta` and `layers_after_single_title_meta` hooks inside the post meta if() conditional.
* **Enhancement** - Added `layers_after_list_post_content` hook and moved the `layers_before_list_post_content` inside the content if() condition.
* **Enhancement** - Added `layers_after_list_post_title` hook.
* **Enhancement** - Added `layers_after_list_post_meta` hook.
* **Enhancement** - Added `layers_before/after_site_description` hook.
* **Enhancement** - Added `layers_after_comments` hook and moved comments hook into comments.php.
* **Enhancement** - Moved `layers_before/after_title_heading` inside the `if()` condition which displays the title.
* **Enhancement** - Added `layers_before/after_title_excerpt` in `/partials/header-page-title.php`.
* **Enhancement** - Improved partial doc blocks and fixed up code formatting.
* **Enhancement** - Removed errand ?> at the end of `get_footer();` in all archive and single files.

=======
## 1.1.4
### 15  May 2015

Hotfix

* **Fix** - Leaving the `elements` argument for custom Design Bar items would throw an error, we've created a fallback for it.
* **Fix** - Quotations in text fields are now properly escaped.
* **Fix** - Fixed the post widget which was broken between 1.1.2 and 1.1.3.
* **Fix** - Removed query strings from Layers custom font includes, this fixes the 404 issue some users experienced when loading the customizer.
* **Fix** - WooCommerce column shortcodes no longer break.
* **Enhancement** - Setting content widget to 12 columns no longer forces 745px max width on the excerpt container.
* **Enhancement** - Added a filter to the `layers_inline_styles()` function, developers can now use the `layers_inline_' . $type . '_css` filter to add custom CSS  to the inline style generator.
* **Enhancement** - Improved the instantiation of customizer defaults and color controls.
* **Enhancement** - Added filter on the `layers_post_featured_media();` function to control the output of the HTML.
* **Enhancement** - Better handling of animations in Safari.

=======
## 1.1.3
### 01 May 2015

Post widget hotfix

* **Fix** - Post widget category selection is now fixed.


=======
## 1.1.2
### 29 April 2015

New dashboard links, color helper file and form item support

* **Fix** - Added missing text domain to widget descriptions.
* **Tweak** - Moved color helper functions into their own file, `/core/helpers/color.php`.
* **Enhancement** - Added support for multi select boxes in `/core/helpers/form.php`, developers can use `multi-select` input type.

=======
## 1.1.1
### 23 April 2015

New color controls and much smarter handling of text colors, plus a brand new Layers Dashboard!

* **Tweak** - Dashboard edit.
* **Fix** - Custom font variants now load correctly.

=======
## 1.1.0
### 22 April 2015

New color controls and much smarter handling of text colors, plus a brand new Layers Dashboard!

* **Enhancement** - New Dashboard! The Layers Dashboard now has quick setup links, a live documentation search, plugin lists and a news feed.
* **Enhancement** - Added column color support to the Post Widget.
* **Enhancement** - All Widgets now get intelligent text coloring which responds to the light or darkness of your background colors.
* **Enhancement** - Added button color selectors to the Post widget.
* **Enhancement** - Added support for the 'target' attribute to the button form type.
* **Enhancement** - Added .invert styling for headers.
* **Enhancement** - Added 'border' option to the `layers_inline_styles` function.
* **Enhancement** - Added Site Accent color which affects all buttons and links.
* **Enhancement** - Builder pages now obey password protection.
* **Enhancement** - Slider now focusses on which ever slide you are busy editing.
* **Enhancement** - If there is only a map widget on the page, it will sit flush with the header.
* **Enhancement** - Improved support for WooCommerce price filter widget.
* **Enhancement** - Improved default color settings for child themers.
* **Enhancement** - Improved handling of `layers_inline_styles()` which now uses `func_num_args()`.
* **Enhancement** - Added new Button controller to the design bar which affects button background colors along with `layers_inline_button_styles()`.
* **Enhancement** - Added more a dynamic class which handles the use of adding .invert to containers.
* **Enhancement** - Added filters to the Layers sidebar classes.
* **Enhancement** - Improved class handling in Layers widgets, each widget now has a much neater way of creating widget container classes.
* **Fix** - Added better customizer default handling via the `layers_customizer_control_defaults` hook.
* **Fix** - Logo Center with no menu no longer breaks.
* **Fix** - Payment method block alignment no longer has a margin on the left.
* **Fix** - Pagination location on the post widget.
* **Fix** - Clicking the canvas in the customizer now closes widgets using the customizer API.
* **Fix** - Gutter option on all widgets with masonry active now works.
* **Fix** - .pull-right problem where adding it to a .column was not forcing float: right;.
* **Fix** - .upsells now align properly on desktop and mobile.
* **Fix** - Tag archive pages.
* **Fix** - Layers pages set to password protected now require a password to view.
* **Fix** - Slider image-center + text right will now align all text correctly.
* **Fix** - Removing your logo no longer leaves a broken image.
* **Fix** - WooCommerce product tag archives now have the correct styling.
* **Fix** - Slider 'layout-full-screen' not working - if auto height is not checked then slider hard sets height which stops full-screen working.
* **Tweak** - Header cart background color has changed for a hash value to a transparent rgba background color for better handling of different header colors.
* **Tweak** - Improved spacing of the comment form block as well as a font-size decrease for "Leave a Reply".
* **Tweak** - Gave copyright border-color rgba (same reason as header cart).
* **Tweak** - Better .button styling in .story
* **Tweak** - Increased the width of sub menus.
* **Tweak** - Nested comments now clear the .copy div in the parent comment.
* **Tweak** - The 'search' button in the Search Widget is now inline with the input field on screens larger than tablets.
* **Tweak** - Bread crumbs css is now based on RGBA for better handling of container background colors.
* **Tweak** - Bread crumbs css now included in `.invert` class.
* **Tweak** - Removed color from headings in .story and .copy as they are already declared as defaults at the top of the CSS.
* **Tweak** - All color settings (Header and Footer included) are now find under Site Settings > Colors.
* **Tweak** - Escaped `add_query_arg()` as possible security flaw was recently identified.
* **Notice** - Layers 1.0.9 has full WordPress 4.2 compatability.


## 1.0.8
### 02 April 2015

Hotfix for the Slider responsive CSS

* **Fix** - Update 1.0.7 broke sliders in phone view, this fixes that, slides now behave as in 1.0.6.

## 1.0.7
### 02 April 2015

Layers page Import / Export fix

* **Tweak** - Changed the way the Layers customizer menu is constructed in `render_customizer_menu()` to make it more extendible.
* **Tweak** - WooCommerce CSS tweaks on product-single.
* **Tweak** - Slider CSS tweaks.
* **Fix** - When adding a new standard page and selecting the Layers Template without clicking save the customizer would throw a 404, now we force users to click save first.
* **Fix** - Page exports would occasionally cause users to reach a 'Warning: headers already sent by' error, we've fixed this error by moving the export trigger.
* **Fix** - The page import button would fail with a JSON not allowed error, we have added json and JSON to allowed file types to counteract this problem.
* **Fix** - When switching to a Layers child theme, customizer settings are now kept alive and transferred to your child theme.
* **Enhancement** - Widget placeholder text is now translatable.
* **Enhancement** - Added hooks to title container, posts and pages.


## 1.0.6
### 20 March 2015

Patch fix which fixes the order of the custom CSS implementation

* **Fix** - Star ratings no longer bump to the top right of the page on WooCommerce product single pages.
* **Enhancement** - Added four new icons to admin font - desktop, tablet, iphone and tick.
* **Tweak** - Moved `layers-custom-styles` enqueue to it's own action in the footer to make sure it loads last.
* **Tweak** - Bail if no css is generated by `layers_inline_styles()`.
* **Tweak** - Moved `layers_inline_css` filter to `layers_apply_inline_styles()`.

## 1.0.5
### 19 March 2015

Bug fixes and language additions

* **Tweak** - Changed the "Page Builder" page template to "Layers Template".
* **Enhancement** - Added the ability to bypass the built-in Customizer sanitization.
* **Fix** - Unchecking all post meta display not longer causes all of the options to actually display.
* **Enhancement** - Added new dropdown to customizer so that users can easily navigate back to dashboard, create new page and preview page.
* **Enhancement** - Added the "range" option to the `Form->input()` function.
* **Enhancement** - Added Chinese translation files.
* **Enhancement** - Added Turkish translation files.
* **Enhancement** - Added German translation files.
* **Enhancement** - Added Spanish translation files.
* **Fix** - When adding a single top menu, the opposite menu no long defaults to show pages.
* **Fix** - Added license information to `swiper.js`.
* **Fix** - WooCommerce pages no longer have a spacing issue when right sidebar is turned on.
* **Fix** - .sub-menu width in off-canvas menu has been fixed to avoid text-wrapping.
* **Fix** - Dots from payment methods in Woo checkout page have been removed.
* **Fix** - Grouped product styling in WooCommerce has been fixed.
* **Fix** - The large gap appearing above a sticky header when you're logged in on a mobile phone no longer appears.
* **Fix** - Fixed when clicking any widget design bar sub menu would erroneously deselect active states of all the controls visual selectors.
* **Tweak** - Text change 'Editing widget content' slide.
* **Tweak** - Removed unused WooCommerce CSS and placed them in new pro woo extension.
* **Tweak** - `get_theme_mod( 'custom-css' );` no longer uses `layers_inline_style`, this is in preparation of PostMessage support.
* **Tweak** - Clicking anywhere on the page will close any open design bar sub menus.
* **Tweak** - Stop persistent Layers page filtering in page list, choosing all would confusingly show only Layers pages.

## 1.0.4
### 02 March 2015

Security and code quality updates

* **Enhancement** - Added 'range' type to the form options.
* **Enhancement** - Added filtering to the design bar setup per widget (thanks @kevinlangleyjr).
* **Enhancement** - Improved class initiators (thanks @prettyboymp).
* **Enhancement** - Added filters to design bar components (thanks @prettyboymp).
* **Enhancement** - Clicking out of the design bar closes a control (thanks @prettyboymp @jeffstieler).
* **Enhancement** - Added `customizer-preview.js` for scripts executed in the customizer preview iframe only.
* **Fix** - Deleting all slides then adding your first slide again threw an error (thanks @prettyboymp).
* **Fix** - Fix references from i8n to i18n.
* **Fix** - Added `check_ajax_referer()` for Ajax nonceing.
* **Fix** - Removed double `title` tag.
* **Fix** - Improved nonce handling and removed any reference to `$_REQUEST[]` in the code.
* **Fix** - Updated Google maps API link for SSL compatability (thanks @oskapt).
* **Fix** - Improved localization (thanks @tmconnect).
* **Fix** - Added sanitization helpers which we hook into the customizer to clean up the Customizer data.
* **Tweak** - Added Typekit ID field to the Site Settings, this means that getting Typekit into Layers is now even easier and safer.
* **Tweak** - Move hooks and filters outside of their related function_exists closures.
* **Tweak** - Replaced deprecated `get_page()` with `get_post()`.
* **Tweak** - Added version number to all css and js assets being enqueued.
* **Tweak** - Added nonce check and remove unnecessary conditional from to `update_page_builder_meta()`.
* **Tweak** - .media block (used extensively in the content widget html) has been tweaked to behave better on different screensizes and with different column widths.
* **Tweak** - Changed jquery-masonry to masonry v3 not dependent on jquery.
* **Tweak** - Updated hook used for meta box registration.
* **Tweak** - Changed in-line styles and scripts to always use `admin_print_styles` and `admin_print_scripts` hooks.
* **Tweak** - Moved fouc rendering issue fix from in-line to the `customizer-preview.js`.
* **Tweak** - Slider behaves better in responsive mode - no longer image/copy overlap.
* **Tweak** - Apply class to Slider for layout eg slider-layout-full-screen and a unique not-full-screen.
* **Tweak** - Merged color.css typography.css and framework.css so that fewer style sheets are loaded, therefore improved load times.

## 1.0.3
### 23 February 2015

Post-launch bug fixes before settling into a release schedule

* **Fix** - Portfolio preset template now works correctly (thanks @nitinthewiz).
* **Tweak** - Removed `layers_site_title();` function in favor of WordPress built in site title function.
* **Tweak** - Added `<?php get_search_form(); ?>` to the 404 page.
* **Fix** - Product page styling with sidebars is now correct (thanks @luizbills).
* **Tweak** - Added target=_blank on the Built With Layers badge.
* **Fix** - Fixed the Layers dashboard header.


## 1.0.2
### 20 February 2015

Theme Check requirements and url updates

* **Fix** - Added `sprintf()` to any hard coded urls.
* **Fix** - Corrected all Layers Dashboard urls.
* **Fix** - Removed unuses scripts from `/assets/js/`.
* **Fix** - Fixed 404 page styling.

## 1.0.1
### 19 February 2015

Some quick fixes that help improve the overall experience

* **Tweak** - Removed un-needed scripts from loading on the front-end.
* **Fix** - Removed un-used images from the /assets/css/images folder.
* **Tweak** - Added a notice to download the Layers Updater to the Layers Dashboard.
* **Tweak** - Cleaned up third party JS scripts.
* **Fix** - Removed unused WooCommerce Sidebars.
