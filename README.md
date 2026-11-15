# WrapperTube
WrapperTube is basically a Mix between Scratch, PenguinMod and YouTube (which yes, means you can also upload Videos, Scratch/TurboWarp/Penguinmod projects, Flash, Images, Audio, and more), which is pretty neat, and what makes WrapperTube different from other Scratch mods. or something along those lines.

Live Demo: http://wrappertube.org/

## How to set it up:
1. Install Apache, MySQL, and PHP 7.4 on your server.
2. Make a MySQL user and a MySQL database.
3. Import the SQL file called "wrappertube.sql" on the database in the "get-started" folder.
4. Add the .htaccess stuff in your server's httpd.conf (if using a vps, which is recommended)
5. Change the files /s/classes/config.inc.php and /static/important/config.inc.php
6. You got a basic WrapperTube setup. If you want to make further changes, do it yourself.
