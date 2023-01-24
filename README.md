# Docker Toolbar Bundle 

Simple Symfony Bundle to use with Symfony CLI and Docker to easily access Docker services on random port numbers.


How to use
----------

Use Symfony CLI with the Docker Integration as described at the [Symfony Server docs]( https://symfony.com/doc/current/setup/symfony_server.html#docker-integration). Docker will use random port numbers for each service when it's container is started making it difficult to access web based UI's in those containers.

Symfony CLI adds links in the special CLI section of the toolbar for RabbitMQ UI, MailCatcher and Blackfire. Others like phpMyAdmin and Adminer are not (yet) supported. See this [issue](https://github.com/symfony-cli/symfony-cli/issues/197) for more information. Until there is a flexible solution within Symfony CLI, we have created this solution.

These bundle re-uses the environment variables created by Symfony CLI, so no additional configuration is required. If Symfony CLI generated an URL environment variable for a service, that one is ued. If not, it is composed out of the HOST and PORT environment variables. Some services are filtered based on there protocol (only when _URL environment variable is given).


Installation
------------

`composer require webstack/docker-toolbar-bundle --dev`

Example
-------

<img src="https://github.com/webstacknl/docker-toolbar-bundle/raw/main/docs/docker-toolbar.png" />

Contributing
------------

Suggestions for improving and extending functionality of this bundle are welcome.

-----
###### _Note: I am not a Go developer, so sadly I can't help out with writing a implementation within Symfony CLI itself._
