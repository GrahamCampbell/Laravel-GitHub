<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\GitHub;

use Illuminate\Support\ServiceProvider;

/**
 * This is the github service provider class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class GitHubServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('graham-campbell/github', 'graham-campbell/github', __DIR__);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->bindShared('github.factory', function ($app) {
            $path = $app['path.storage'].'/github';

            return new Factories\GitHubFactory($path);
        });

        $this->app->alias('github.factory', 'GrahamCampbell\GitHub\Factories\GitHubFactory');
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->bindShared('github', function ($app) {
            $config = $app['config'];
            $factory = $app['github.factory'];

            return new GitHubManager($config, $factory);
        });

        $this->app->alias('github', 'GrahamCampbell\GitHub\GitHubManager');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'github',
            'github.factory',
        ];
    }
}
