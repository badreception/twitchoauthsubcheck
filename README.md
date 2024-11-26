
# twitchoauthsubcheck 
backend for a simple twitch subscription check to verify if a twitch user is subscribed to a specific channel on twitch.

## demo
https://twitchv2.badrep.net

## how-to
#### 1. download files / clone repo
#### 2. register your application on twitch
visit https://dev.twitch.tv/console and "register your application".

name: anything

oauth redirect urls: https://your.domain.tld/callback 

category: website integration 

client type: confidential 

Depending on the a/b test twitch is running, you may not get your client id or secrete key. Just go back to https://dev.twitch.tv/console,click manage next to your app then copy the client id, click new secret, then copy the secret.

#### 3. edit files
add the secret to the .htaccess file.

Add the client id and callback URL to callback.php and login.php.

add the twitch channel's broadcast id to callback.php.

you can get the broadcast id from https://twitchv2.badrep.net

#### 4. test
visit your site and log in with twitch. if you did it right, and you're subscribed, you should see "You are subscribed!" message.
