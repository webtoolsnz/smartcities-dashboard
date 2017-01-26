smartcities-dashboard
=====================

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Smart Cities Dashboard.

Global Composer Configuration
-------------

Yii2 has a dependency on the `fxp/composer-asset-plugin` which must be installed globally. 

```
composer global require "fxp/composer-asset-plugin"
```

Initialization
------------
You can initialize the application by running:
~~~
composer install
~~~

Now all the dependencies have been installed, next step is to configure the development environment.

Development Environment
-------------

### Vagrant

Provision the VM by running:

~~~
vagrant up
~~~ 

Add the hostname to your hosts file by running:

~~~
echo '192.168.99.232 smartcities-dashboard.dev' | sudo tee -a /etc/hosts
~~~

You can now access the dev site by going to http://smartcities-dashboard.dev/

Dev Configuration
-----------------

In the project directory, create a new file called `environment.config.php` with the following contents:

    ```
    return [
        'params' => [
            'google.api.key' => '<google-api-key>',
        ]
    ];    
    ```

    Where `<google-api-key>` is an API key that you have registered for; you may leave this blank.

Database
--------

Apply migrations by running:

~~~
vagrant ssh
cd /vagrant/www
./yii migrate
~~~


Production Environment
----------------------

The Smart Cities Dashboard is designed to be run on a Linux server. It requires:

* PHP 5.4
* MySQL
* Apache

Setup steps are:

1. Provision a LAMP server.
2. Create a new MySQL database and user.
3. Set up a virtualhost rule in Apache for the project.
4. Place this project in the document root for the virtualhost set up in step 3.
5. Ensure the `web` directory has permissions of `755` and that `runtime` and `web/assets` have permissions of `777`.
6. In the project directory, create a new file called `environment.config.php` with the following contents:

    ```
    <?php
    return [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => "mysql:host=localhost;dbname=<dbname>",
                'username' => '<dbuser>',
                'password' => '<dbpass>',
            ],
        ],
        'params' => [
            'google.api.key' => '<google-api-key>',
        ]
    ];
    
    ```

    Where `<dbname>`, `<dbuser>`, and `<dbpass>` are the database name, user, and password you created in step 2. `<google-api-key>` is an API key that you have registered for; you may leave this blank.

7. In the project directory, create a new file called `environment.php` with the following contents:

    ```
    
    <?php return 'prod';
    
    ```

8. Run the following commands in the project directory:

    ```
    
    composer global require "fxp/composer-asset-plugin"
    composer install --no-interaction --no-dev --optimize-autoloader
    
    php yii cache/flush-all
    php yii migrate/up --interactive=0
    php yii scheduler
    
    ```

These should also be run every time you update the project from the repository.


## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
