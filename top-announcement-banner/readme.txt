=== Top Announcement Banner ===
Contributors: siddiqurrahman
Tags: announcement, banner, notification, promotion
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Show a campaign or offer announcement banner at the top of your WordPress site.

== Description ==

Top Announcement Banner adds a configurable fixed banner to the top of your site's frontend. Ideal for promotions, announcements, and time-sensitive offers.

Features:

* Custom message text
* Optional call-to-action button with configurable URL
* Custom background and text colors with live admin preview
* Dismissible banner with localStorage persistence
* Fully accessible (keyboard navigable, ARIA-labelled close button)
* Lightweight — no jQuery dependency on the frontend

== Installation ==

1. Upload the `top-announcement-banner` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Go to **Settings → Announcement Banner** to configure the banner.

== Frequently Asked Questions ==

= Will dismissed banners reset when I update the message? =

Not automatically. The dismiss state is stored in the visitor's browser localStorage under a fixed key. Changing the message does not clear existing dismissals. If you need visitors to see a new campaign, consider deactivating and reactivating the plugin, which resets the stored option.

= Does the plugin add any database tables? =

No. Settings are stored as a single WordPress option (`top_announcement_banner`) using the standard options table.

== Changelog ==

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
Initial release.
