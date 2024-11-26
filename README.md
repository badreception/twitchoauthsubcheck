Example for a simple twitch subscription check to verify if a twitch user is subscribed to a specific channel on twitch.

live version: https://twitchv2.badrep.net

step #1:
https://dev.twitch.tv/console
"register your application"

Name: anything
oauth redirect urls: https://your.domain.tld/callback
category: website integration
client type: confidential
im not a robot: are you?

Depending on the a/b test your in, you may not get your client id or secrete key. Just go back to https://dev.twitch.tv/console and click manage next to your app.

Copy client id, and click new secret, then copy the secret.

Step #2:
add the secret to the.htaccess file (your'll see where).

Add the client id and callback URL to callback.php and login.php, you'll see where.

add the twitch channel's broadcast id to callback.php (google it, there are websites that provide this)

Step #2
upload the files, test. If you did it right, you should see "You are subscribed to channelname!"
