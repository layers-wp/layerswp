# Layers Changelog

## 1.0.4
### ?? February 2015

Security and code quality updates

* **Enhancement** - Added filters to design bar components (thanks @prettyboymp)
* **Enhancement** - Clicking out of the design bar closes a control (thanks @prettyboymp @jeffstieler)
* **Fix** - Fix references from i8n to i18n
* **Fix** - Added check_ajax_referer() for Ajax nonceing
* **Fix** - Removed double <title> tag
* **Fix** - Improved nonce handling and removed any reference to $_REQUEST[] in the code
* **Fix** - Updated Google maps API link for SSL compatability (thanks @oskapt)
* **Fix** - Improved localization (thanks @tmconnect)
* **Fix** - Added sanitization helpers which we hook into the customizer to clean up the Customizer data
* **Tweak** - Added Typekit ID field to the Site Settings, this means that getting Typekit into Layers is now even easier
* **Tweak** - Move hooks and filters outside of their related function_exists closures
* **Tweak** - Replaced deprecated get_page() with get_post()
* **Tweak** - Added version number to all css and js assets being enqueued
* **Tweak** - Added nonce check and remove unnecessary conditional from to update_page_builder_meta()
* **Tweak** - .media block (used extensively in the content widget html) has been tweaked to behave better on different screensizes and with different column widths
* **Tweak** - Changed jquery-masonry to masonry v3 not dependent on jquery
* **Tweak** - Updated hook used for meta box registration
* **Tweak** - Changed in-line styles and scripts to always use admin_print_styles and admin_print_scripts hooks
* **Enhancement** - Added customizer-preview.js for scripts executed in the customizer preview iframe only
* **Tweak** - Moved fouc rendering issue fix from in-line to the customizer-preview.js
* **Tweak** - Slider behaves better in responsive mode - no longer image/copy overlap

## 1.0.3
### 23 February 2015

Post-launch bug fixes before settling into a release schedule

* **Fix** - Portfolio preset template now works correctly (thanks @nitinthewiz)
* **Tweak** - Removed layers_site_title(); function in favor of WordPress built in site title function
* **Tweak** - Added <?php get_search_form(); ?> to the 404 page
* **Fix** - Product page styling with sidebars is now correct (thanks @luizbills)
* **Tweak** - Added target=_blank on the Built With Layers badge
* **Fix** - Fixed the Layers dashboard header


## 1.0.2
### 20 February 2015

Theme Check requirements and url updates

* **Fix** - Added sprintf() to any hard coded urls
* **Fix** - Corrected all Layers Dashboard urls
* **Fix** - Removed unuses scripts from /assets/js/
* **Fix** - Fixed 404 page styling

## 1.0.1
### 19 February 2015

Some quick fixes that help improve the overall experience

* **Tweak** - Removed un-needed scripts from loading on the front-end
* **Fix** - Removed un-used images from the /assets/css/images folder
* **Tweak** - Added a notice to download the Layers Updater to the Layers Dashboard
* **Tweak** - Cleaned up third party JS scripts
* **Fix** - Removed unused WooCommerce Sidebars
