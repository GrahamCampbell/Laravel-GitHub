Laravel GitHub
==============

Laravel GitHub was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell), and is a [PHP GitHub API](https://github.com/KnpLabs/php-github-api) bridge for [Laravel 5](http://laravel.com). It utilises my [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package. Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-GitHub/releases), [license](LICENSE), and [contribution guidelines](CONTRIBUTING.md).

![Laravel GitHub](https://cloud.githubusercontent.com/assets/2829600/4432305/c14a3934-468c-11e4-8371-684e72291139.PNG)

<p align="center">
<a href="https://travis-ci.org/GrahamCampbell/Laravel-GitHub"><img src="https://img.shields.io/travis/GrahamCampbell/Laravel-GitHub/master.svg?style=flat-square" alt="Build Status"></img></a>
<a href="https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-GitHub/code-structure"><img src="https://img.shields.io/scrutinizer/coverage/g/GrahamCampbell/Laravel-GitHub.svg?style=flat-square" alt="Coverage Status"></img></a>
<a href="https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-GitHub"><img src="https://img.shields.io/scrutinizer/g/GrahamCampbell/Laravel-GitHub.svg?style=flat-square" alt="Quality Score"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://github.com/GrahamCampbell/Laravel-GitHub/releases"><img src="https://img.shields.io/github/release/GrahamCampbell/Laravel-GitHub.svg?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

[PHP](https://php.net) 5.5+ or [HHVM](http://hhvm.com) 3.6+, and [Composer](https://getcomposer.org) are required.

To get the latest version of Laravel GitHub, simply add the following line to the require block of your `composer.json` file:

```
"graham-campbell/github": "~4.0"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

Alternatively you can require it directly via your terminal by running `composer require graham-campbell/github` in the project root directory.

Once Laravel GitHub is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `'GrahamCampbell\GitHub\GitHubServiceProvider'`

You can register the GitHub facade in the `aliases` key of your `config/app.php` file if you like.

* `'GitHub' => 'GrahamCampbell\GitHub\Facades\GitHub'`


## Configuration

Laravel GitHub requires connection configuration.

To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish
```

This will create a `config/github.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

There are two config options:

##### Default Connection Name

This option (`'default'`) is where you may specify which of the connections below you wish to use as your default connection for all work. Of course, you may use many connections at once using the manager class. The default value for this setting is `'main'`.

##### GitHub Connections

This option (`'connections'`) is where each of the connections are setup for your application. Example configuration has been included, but you may add as many connections as you would like. Note that the 3 supported authentication methods are: `"application"`, `"password"`, and `"token"`.


## Usage

##### GitHubManager

This is the class of most interest. It is bound to the ioc container as `'github'` and can be accessed using the `Facades\GitHub` facade. This class implements the `ManagerInterface` by extending `AbstractManager`. The interface and abstract class are both part of my [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package, so you may want to go and checkout the docs for how to use the manager class over at [that repo](https://github.com/GrahamCampbell/Laravel-Manager#usage). Note that the connection class returned will always be an instance of `\Github\Client`.

##### Facades\GitHub

This facade will dynamically pass static method calls to the `'github'` object in the ioc container which by default is the `GitHubManager` class.

##### GitHubServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.

##### Real Examples

Here you can see an example of just how simple this package is to use. Out of the box, the default adapter is `main`. After you enter your authentication details in the config file, it will just work:

```php
use GrahamCampbell\GitHub\Facades\GitHub;
// you can alias this in config/app.php if you like

GitHub::me()->organizations();
// we're done here - how easy was that, it just works!

GitHub::repo()->show('GrahamCampbell', 'Laravel-GitHub');
// this example is simple, and there are far more methods available
```

The github manager will behave like it is a `\Github\Client` class. If you want to call specific connections, you can do with the `connection` method:

```php
use GrahamCampbell\GitHub\Facades\GitHub;

// the alternative connection is the other example provided in the default config
GitHub::connection('alternative')->me()->emails()->add('foo@bar.com');

// now we can see the new email address in the list of all the user's emails
GitHub::connection('alternative')->me()->emails()->all();
```

With that in mind, note that:

```php
use GrahamCampbell\GitHub\Facades\GitHub;

// writing this:
GitHub::connection('main')->issues()->show('GrahamCampbell', 'Laravel-GitHub', 2);

// is identical to writing this:
GitHub::issues()->show('GrahamCampbell', 'Laravel-GitHub', 2);

// and is also identical to writing this:
GitHub::connection()->issues()->show('GrahamCampbell', 'Laravel-GitHub', 2);

// this is because the main connection is configured to be the default
GitHub::getDefaultConnection(); // this will return main

// we can change the default connection
GitHub::setDefaultConnection('alternative'); // the default is now alternative
```

If you prefer to use dependency injection over facades like me, then you can easily inject the manager like so:

```php
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Support\Facades\App; // you probably have this aliased already

class Foo
{
    protected $github;

    public function __construct(GitHubManager $github)
    {
        $this->github = $github;
    }

    public function bar()
    {
        $this->github->issues()->show('GrahamCampbell', 'Laravel-GitHub', 2);
    }
}

App::make('Foo')->bar();
```

For more information on how to use the `\Github\Client` class we are calling behind the scenes here, check out the docs at https://github.com/KnpLabs/php-github-api/tree/master/doc, and the manager class at https://github.com/GrahamCampbell/Laravel-Manager#usage.

##### Further Information

There are other classes in this package that are not documented here. This is because they are not intended for public use and are used internally by this package.


## License

Laravel GitHub is licensed under [The MIT License (MIT)](LICENSE).
