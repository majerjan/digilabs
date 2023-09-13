Digilabs 
=================

Testing project


Requirements
------------

- PHP 8.1
- ext: xml, mbstring, zip, unzip, curl, gd
- composer


Docker use
------------

    cd path/to/project
    make up
    
After building running on localhost:80


Local use
----------------

Apache: 

- copy project to apache html
- add to apache conf


    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    <IfModule dir_module>
        DirectoryIndex index.php index.html
    </IfModule>
    
    <FilesMatch \.php$>
        SetHandler application/x-httpd-php
    </FilesMatch>

enable rewrite mode 

    a2enmod rewrite

restart apache

running on localhost:80

Resource
----------------

it is possible to change data resource

    config/services.neon
