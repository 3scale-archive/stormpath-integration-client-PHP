# stormpath-integration-client-PHP
This is a sample oAuth client for the 3scale-Stormpath integration Client that is used in this tutorial: [3scale-Stormpath integration](https://support.3scale.net/get-started/quickstarts/stormpath-tutorial)

It is not intended for a production environment. It's main purpose is to be simple and clear enough so that most people can understand how using an oAuth flow, you can:
* develop a client app that authenticates users against Stormpath (that will act as the Authorization Server -AS-)
* is provided with an Access Token (by the AS)
* uses that Token access to resources managed by an API (that will act as the Resource Server -RS-) on behalf of the user
* 3scale gateway manages the data workflow, controlling and monitoring the requests to the RS

Besides this Client, you will also need:

1. the RS app. You can find the Github repo here: [sample RS app](https://github.com/mpguerra/address-book-app-stormpath)
2. Access to a working Nginx server configured to manage the oAuth dance. You can test one here: [sample Nginx config and lua files](https://github.com/3scale/stormpath-integration-Nginx-files), and the tutorial will tell you what are the changes to apply to your Nginx config files.



