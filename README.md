# covid19stories
Covid-19-stories. This is our submission for the Hackweekend COVID-19 hackthon challenge.

#Requirements
php >=7.1.0
composer
mysql 5.*
php ext-ctype
php ext-dom
php ext-hash
php ext-intl
php ext-json
php ext-mbstring
php ext-session
php ext-simplexml
php ext-tokenizer
php ext-xml
Webserver Eg (Ngnix, Apache2)

#How to install
Copy the included .env.sample to .env and modify the content with your own values. 
Run  `composer install`
Finally navigate to the website to the location you installed it in your browser and go to http://your-installation-url/dev/build

Also go to https://developer.twitter.com/en/apps and register find or register a new twitter app.

Add the following details in your .env file based on your app from twitter
```

################################################################################
# TWITTER
################################################################################
TWITTER_API_KEY="APIHERE"
TWITTER_API_SECRET_KEY="APISECRETHERE"
TWITTER_API_ACCESS_TOKEN="ACCESSTOKENHERE"
TWITTER_API_ACCESS_SECRET="ACCESSSECRETHERE"
```

#How fetch social media data
Go to http://your-installation-url/admin and enter some search terms into the 'MLSearchTerms'. You will find this on the admin page sidebar

Finally, go to http://your-installation-url/dev/tasks/fetch-twitter-data-task
