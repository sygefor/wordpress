=== Sygefor3 Viewer ===

Contributors: Conjecto
Tags: sygefor3, urfist

== Description ==

Sygefor3 Viewer give you shortcodes permitting to display sessions list registered in Sygefor3, to display a training and to display a calendar with session events.
It also delivers widgets to display a search form and the training theme list.

== Installation ==

Create 3 pages:
    - One to display the session list. Set the shortcode [sygefor.sessions] in page content.
    - One to display the calendar with session events. Set the shortcode [sygefor.agenda_sessions] in page content.
    - One to display a specific training. Set the shortcode [sygefor.formation] in page content.

These shortcodes can take some parameters:
    - pagination
    - dateDebut
    - dateFin

The pagination parameter display the specified number of item by page. The dateDebut and dateFin parameters add or substract the number of mounth specified.


After that, go to Sygefor3 Viewer params (/wp-admin/admin.php?page=sygefor3-viewer%2FSygefor3Viewer.php)
and set the URFIST, the URL API and the ID of 3 precedents created pages.

You can also add Sygefor3 widgets to your website from widget page management.
Widgets are named "Rechercher une formation dans Sygefor3", "Axes de formation de Sygefor3" and "Tags de Sygefor3".

If templates provided by the plugin doest not satisfy you, you can create your own templates.
For this, create a repository "sygefor" in the actual used theme repository.
If a file is found in this repository with the same name that the template default filename, this file will be used instead of default file.

You can override all plugin's views.