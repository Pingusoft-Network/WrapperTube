# WrapperTube
WrapperTube is basically a Mix between Scratch, PenguinMod and YouTube (which yes, means you can also upload Videos, Scratch/TurboWarp/Penguinmod projects, Flash, Images, Audio, and more), which is pretty neat, and what makes WrapperTube different from other Scratch mods. or something along those lines.

## How to set it up:
1. Install Apache, MySQL, and PHP 7.4 on your server (you can try php 8, although it's not tested)
2. Install ffmpeg and ImageMagick (used for thumbnail and video processing)
3. Make a MySQL user and a MySQL database.
4. Import the SQL file called "wrappertube.sql" on the database in the "get-started" folder.
5. Add the .htaccess stuff in your server's httpd.conf (if using a vps, which is recommended since this hasn't been tested on shared hosting)
6. Change the files /s/classes/config.inc.php and /static/important/config.inc.php
7. Create an admin user on the database, setting the user's status to "admin".
8. Change each instance where it says "wrappertube.org" to your own domain.
9. You got a basic WrapperTube setup. The admin panel is on the /funny-casablanka/ path, and the mod panel at the /vivat-shuravi/ path.
