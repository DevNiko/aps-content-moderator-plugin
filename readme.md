**APS Content Moderator Plugin**

This wordpress plugin allows you to filter blog comments for obscene, revealing, ambiguous or offensive content using the APS Content Moderator API.
If the User Comment contains any of the above unwanted data, the comment will automatically be set to "not approved". If none of the content is found, the comment will be released. You can save a lot of time because you don't have to check every comment manually.
The sensitivity of the filtering can be adjusted.

**Installation**

*Local*

Install Docker and use "docker-compose up" to startup the Wordpress Stack. Use "http://localhost:8000" for Wordpress and "http://localhost:8001" for phpMyAdmin. 

*Production*

Upload the folder "aps-content-moderator" into your Wordpress Plugin Directory on your Webhost. Activate the Plugin using the WP-Admin Dashboard. Or use the official Plugin Installer in Wordpress.

*Plugin Settings*

Go to "Settings -> APS Content Moderator"  for Plugin Settings.

![Screenshot](./aps-content-moderator/assets/screenshot-1.png)

**Notice**

The plugin limits the comment text length to 1024 characters. Since the Content Moderator API can handle a maximum of 1024 characters per request. The limitation can be switched off in the plugin settings. Then only the first 1024 of the comment will be checked.
Furthermore, all HTML tags are filtered out of the comment.


**Documentation**

Visit the RapidAPI Page for more details. https://rapidapi.com/dev.nico/api/ai-powered-content-moderator