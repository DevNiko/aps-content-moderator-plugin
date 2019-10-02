**APS Content Moderator Plugin**

The plugin allows you to filter blog comments for obscene, revealing, ambiguous or offensive content using the APS Content Moderator API.
If the User Comment contains any of the above unwanted data, the comment will automatically be set to "not approved". If none of the content is found, the comment will be released. You can save a lot of time because you don't have to check every comment manually.
The sensitivity of the filtering can be adjusted.

**Installation**
Copy the content into your Wordpress Plugin Directory. Activate the Plugin using the WP-Admin Dashboard.

**Notice**

The plugin limits the comment text length to 1024 characters. Since the Content Moderator API can handle a maximum of 1024 characters per request. The limitation can be switched off in the plugin settings. Then only the first 1024 of the comment will be checked.
Furthermore, all HTML tags are filtered out of the comment.


**Documentation**
Visit the RapidAPI for more details. https://rapidapi.com/dev.nico/api/ai-powered-content-moderator