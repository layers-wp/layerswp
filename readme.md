## Synopsis

Layers is a WordPress Theme framework focused on extending the WordPress core functionality to include layout building through the WordPress Visual Customizer. A lightweight set of base options, widgets and theme templates provide a user-friendly, extensible tool for creating beautiful, WordPress-faithful websites

## Download & Install

Layers is available from our GitHub link here, or from layerswp.com and requires a self-hosted WordPress install.

View WordPress installation and server requirements on the [WordPress Codex](https://wordpress.org/download/)

To install Layers, upload the layers zip file to your self-hosted WordPress install under APPEARANCE →THEMES → ADD NEW.

Upon Activation, you will be greeted with a quick overview and be prompted to choose a preset.

Custom page layouts are achieved using the WordPress Customizer in combination with widgets.  You can access Layers customization from APPEARANCE → CUSTOMIZE or through any Layers Page.  These pages are listed under LAYERS → LAYERS PAGES for your convenience.

Customization of these pages and the overall theme is completed in the WordPress Customizer to take advantage of the live view.

For videos, troubleshooting and detailed usage documentation, view the Getting Started  Guide

###Links

* [LayersWP](http://www.layerswp.com/download/layers/)
* Clone here or [Download Master](https://github.com/Obox/layerswp/archive/master.zip)
* *Send us a pull request!*

## Page Builder

The core concept of Layers is to enable the user to build layouts using functionality that is native to WordPress. This page template simply provides a single widget area that is designed to work with the Layers Page Builder Widgets specifically, but can accomodate most any widget with a little custom styling.

[Learn how the page builder works](http://docs.layerswp.com/doc/build-your-home-page/)

## Page Templates

Layers bundles 6 basic page templates to allow sidebar specificity per page, and a standard blog feed which uses the Layers Site Settings sidebar selection.

[View Page Template detail](http://docs.layerswp.com/doc/page-templates/)

## Framework

Layers is built upon a lightweight HTML5 & CSS framework designed for speed, comprehension and efficient building of Child Themes and Extensions. It uses a 12ths grid and includes styling for buttons, forms, content typography, navigation and images.

* Framework Guide with code examples: [Start Here](http://docs.layerswp.com/layers-framework-grids/)
* [Framework Visual Reference](http://docs.layerswp.com/framework/)

## Technical Information

### Browser & Device Support

Layers is built to work best in the latest desktop and mobile browsers, meaning older browsers might display differently styled, and only partially functional, renderings of certain components.

### Supported Browsers

We support the latest versions of webkit browsers and Internet Explorer 11. Note that IE11 still has display issues with WordPress in general, which may affect Layers.

Unofficially, Layers should look and behave well enough in Chromium and Chrome for Linux, Firefox for Linux, and Internet Explorer 10, though they are not officially supported. To see a list of IE bugs WordPress and WordPress themes must contend with, see the [.org list of browser bugs.](https://codex.wordpress.org/CSS_Fixing_Browser_Bugs#Browser_Bugs_and_Hacks)

For general information and troubleshooting of browser issues with WordPress, see [this guide on WordPress.com](https://en.support.wordpress.com/browser-issues/)

### Responsiveness

Layers is fully responsive, supporting most modern smartphone, tablet and laptop screen resolutions. It includes thresholds for 320, 600, and 768 by default.

### Code Libraries & APIs

Layers uses jQuery, JSON, and other libraries pre-bundled with the WordPress platform which you can reference on the [WordPress Codex](http://codex.wordpress.org/Function_Reference/wp_enqueue_script#Default_Scripts_Included_and_Registered_by_WordPress).

Additionally, Layers includes [Swiper](http://www.idangero.us/swiper/get-started/) which you can learn more about extending and cusomizing through their API documentation as part of your child theme or extension.

## 3rd Party Support

While we don't officially support any third-party plugins or extensions other than those we author, we do offer some useful advice to help avoid potential issues in your projects on the Layers Support Site.

Layers has been tested with several popular and widely used WordPress plugins listed on the [Plugin Compatibility](http://docs.layerswp.com/plugin-compatibility/) page. Additionally, Layers offers a growing catalog of free and premium extensions to provide unique and widely used functionality that takes full advantage of the Layers framework and customization control.

## Translations

Layers is coded in international English as the primary language and uses WordPress standard [gettext](http://codex.wordpress.org/I18n_for_WordPress_Developers) to enable quick and easy translation of text elements via plugins or .po file editors. Several professional translations are available from the Layers Extension library for use on your site or in a child theme project, or you may translate Layers yourself using any of the following solutions:

* Codestyling Localization (free plugin)
* WPML (premium plugin) + String Translation (WPML Extension for Theme localization)
* POEdit (desktop tool for creating .po files manually)

Layers includes the following languages (as of 1.1)

ar_SA Arabic/Saudi Arabia العربية/السعودية
de_DE Deutsch/Deutschland
en_US English/United States/Universal (default WP install)
fr_FR Français/France
hi_IN हिन्दी
it_IT Italiano/Italia
ja_JP 日本語
pt_BR Português/Brasil
pt_PT Português/Portugal
ru_RU Русский/Россия
th_TH ไทย/ประเทศไทย
tr_TR Türkçe
zh_CN 中文(中华人民共和国)

See Contributing below for how to contribute languages or How to Translate Layers

## License FAQs

Layers is released under the GPL 2.0 License, which governs how the code can be distributed. It does not govern copyright at the product level or trademark of the brand.

* “Layers for WordPress”, LayersWP and the Layers brand are copyrighted and trademarked by Obox Themes.
* Images and iconfonts are covered by Creative Commons with Attribution.
* Code within Layers is individually copyrighted by the contributing author, or by Obox Themes, and covered by GPL.

Boiled down to smaller chunks, the license sets forth the following conditions:

It allows you to:

* Freely download and use Layers, in whole or in part, for personal, company-internal or commercial purposes
* Build Child Themes or Extensions for use with or based on the Layers framework for personal use or a client project
* Install Layers on as many websites as you wish

It forbids you to:

* Redistribute Layers in whole or part without proper attribution.

It requires you to:

* Include a copy of the license in any redistribution you may make that includes Layers
* Retain all attributions and copyright notices in the original documents

It does not require you to:

* Include the full source of Layers itself, or of any modifications you may have made to it, in any redistribution you may assemble that includes it (such as a child theme or extension)
* Submit changes that you make to Layers back to the Layers project (though you earn extra awesome points for doing so!)


### Can I fork Layers and sell it as my own product?

GPL is a license that allows anyone to freely use, enhance or distribute the code without any requirement of paying for license fees. It is completely within GPL to fork Layers or redistribute it, link to it, or create a derivative (modified) version.

You can sell GPL software, but to do that, you cannot infringe on the copyrights or trademarks of the Layers authors or other attributed contributors.

* You can charge a fee for distributing Layers.
* You can create child themes and extensions for Layers and sell them.
* You can fork Layers, create a modified derivative, and sell it provided a copy of the GPL license is included and all original copyrights are retained. All of the code you add must be clearly attributed to you to differentiate it from the original. Note that your sold copy must be GPL, meaning anyone can take it and redistribute it for free, or modify and sell it in turn.
* Your modified version cannot be resold as “Layers” or “LayersWP” using the Layers brand without it violating copyrights (however you can certainly refer to it as a Layers product or link to Layers in attribution)
* You cannot take Layers and rebrand it or remove the copyright/attribution and sell it as your own product. This is copyright infringement. (The fork must qualify as a derivative work)
* You cannot represent Layers as your own product.

For more information, see the following:

[GPL 3.0 License Full Text](http://www.gnu.org/licenses/gpl.html)

[Selling Other People’s Products](http://chrislema.com/selling-other-peoples-products/) by Chris Lema

[GPL Commercial Info](http://www.gnu.org/licenses/gpl-faq.html#GPLCommercially)

### Can I use Layers on a hosted service and charge for it?

Yes. Layers may be included in a WPMU implementation where you charge for themes or a service built on Layers. However,it must be under the terms of the GNU GPL. Therefore you must make the source code available to the users of the program as described in the GPL, and they must be allowed to redistribute and modify it as described in the GPL. These requirements are the condition for including the GPL-covered code you received in a program of your own. In the context of hosted services, this means you must provide a link to your users for where they can download Layers free of charge to host it themselves.

### Can I sell Layers to a client?

Of course. You are free to use Layers as part of a commercial website or commercial client project. You are even free to direct your clients to our support and documentation, provided the theme was unmodified. If you need to add modifications, we recommend using a Child Theme. If you modify the original, it must comply with the above regarding copyright and representation, and you assume ownership and support of the modified version (otherwise the user may end up updating or reinstalling a new version at our direction that wipes your mods!)

### Commercial Sale of  Child Themes or Extensions for Layers:

You may sell any product created for Layers on your own site or a theme marketplace. You may link to our documentation to help support your customers, but take on all developmental responsibility and support for your product where it is specific to your code. For your own sanity, we recommend you direct your users to download Layers from our official links to ensure they receive the most recent versions, and read through our developer documentation and best practices.

For more information, view the [GPL FAQ](http://www.gnu.org/licenses/gpl-faq.html)

## Theming & Extending

As a framework, Layers is not intended for direct modification. Instead, it allows you to backup pages and widget data to create presets or Style Kits which you can share, sell, or use to seamlessly transfer setups and layouts from one install to another. Layers may also be extended through Child Themes and Plugins (Extensions) via a growing set of hooks, snippets and tips found in our Developer Reference library.

The Layers Docs codex contains a growing reference for custom hooks found in Layers, along with core functions, definitions and child-theming resources.

* [Child Theme Introduction](http://docs.layerswp.com/child-themes-introduction/)
* [Plugin Development Guide](http://docs.layerswp.com/plugin-creation-guide/)
* [Code Reference](http://docs.layerswp.com/reference/)

## Contributing

Layers is an open-source project that depends on the community to help it grow and thrive. We encourage and welcome all contributions, from translations to extensions!

To contribute code or submit themes and extensions, be sure to read our developer guides.

We look for contributions to the Layers core that fix bugs, provide code or security refinement, help in establishing better support for dependencies (WordPress updates, WooCommerce, JetPack or similar) or greatly enhance existing functionality.

If you want us to consider changes to the front-end templates, CSS or Javascript files, please must open an Issue to discuss the change – we cannot merge pull requests containing front-end modifications.

New functionality or features should be submitted as Layers extensions in the form of a plugin. If you are unsure if your changes are features, fixes or enhancements:

### New Feature vs Enhancement

* New widget = new feature
* Adding post type support = new feature
* Adding controls to customizer = new feature
* Adding a language = enhancement
* Adding caching support = enhancement
* Fixing a deprecated tag = fix
* Updating a method to use correct syntax = fix

### Submitting Changes

* Fork layers
* Make a commit.
Separate your commits by task and ensure they are commented thoroughly
* Make a pull request
Your pull request is what notifies us that you have something to add! If the change is appropriate for the core and tests clean, we will merge it.

* For core contribution, [fork the project](https://github.com/Obox/layerswp/fork)
* To report a bug, hit up our[issues list](https://github.com/Obox/layerswp/issues/new?title=Issue%3A%20&body=%23%23%20Description%20of%20issue%0A%0A%0A%23%23%20URL%20of%20page%20exhibiting%20the%20issue%0A%0A%0A%23%23%20Web%20Browsers%20that%20exhibit%20the%20issue%0A%0A%0A%23%23%20Error%20Message%20or%20Steps%20to%20Recreate%0A%0A)
* For development questions or inquiries related to commercial sale of child themes or extensions, email layers@obox.co.za
