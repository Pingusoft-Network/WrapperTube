# WrapperTube
WrapperTube is basically a Mix between Scratch, PenguinMod and YouTube (which yes, means you can also upload Videos, Scratch/TurboWarp/Penguinmod projects, Flash, Images, Audio, and more), which is pretty neat, and what makes WrapperTube different from other Scratch mods. or something along those lines.

## How to set it up:
1. Install Apache, MySQL, and PHP 7.4 on your server (you can try php 8, although it's not tested)
2. Install ffmpeg and ImageMagick (used for thumbnail and video processing)
3. (Optional) Install a mail server for sending password reset emails.
4. Make a MySQL user and a MySQL database.
5. Import the SQL file /get-started/wrappertube.sql in your database.
6. Add the stuff in /get-started/httpdconf.txt in your server's httpd.conf (or whatever config file you're using)
7. Change the files /s/classes/config.inc.php , /static/important/config.inc.php , /d/signup.php , and /email.php (/email.php if you set up an email server for password reset emails)
8. Create an admin user on the database, setting the user's status to "admin".
9. Change each instance where it says "wrappertube.org" to your own domain. (this can be done with a single command btw)
10. You got a basic WrapperTube setup. The admin panel is on the /funny-casablanka/ path, and the mod panel at the /vivat-shuravi/ path. (the reason why the paths are weird because wrappertube was originally closed source)
