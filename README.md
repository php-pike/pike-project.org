### Welcome to the *Pike-Project* example application!

This project is supposed to show which features the PiKe library implmenents
and how you use it with simple examples. You could also use this project as a
boilerplate for you new project using composer.

In the next release (1.2) unit-tests will be added and some more examples.

### SYSTEM REQUIREMENTS
PiKe 1.4 is tested on Zend Framework 1.11.1, Doctrine 2.2 and strongly 
relies on jQuery 1.7. Cause of these libraries it requires at least 
PHP 5.3.3. 

### INSTALLATION
First you need to clone this repository:

    git clone git://github.com/php-pike/pike-project.org.git
    cd pike-project.org

Then you install composer to load the dependecies:

    curl -s http://getcomposer.org/installer | php

Then run composer install in the root directory:

    php composer.phar install

After you have run composer and loaded dependecies you add a virtual host. ( 
/etc/apache2/sites-available/local.pike-project.org for Ubuntu):

    <VirtualHost *:80>
        ServerAdmin webmaster@localhost
	ServerName local.pike-project.org

	SetEnv APPLICATION_ENV development

        DocumentRoot /var/www/pike-project.org/public
        ErrorLog ${APACHE_LOG_DIR}/error.log

        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel info

        CustomLog ${APACHE_LOG_DIR}/access.log combined

    </VirtualHost>

Add local.pike-project in your /etc/hosts:

    127.0.0.1       local.pike-project.org

Enable site and reload Apache and it should work!

    sudo a2ensite local.pike-project.org && sudo service apache2 reload

### HELPING US
You can help us by providing bugs, forking this project and try other PiKe 
features, blog, etc. Any help / input is highly appreciated!

With dutch greetings,
Pieter Vogelaar & Kees Schepers