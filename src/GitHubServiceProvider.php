<?php

/**
 * This file is part of Laravel GitHub by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\GitHub;

use Illuminate\Support\ServiceProvider;

/**
 * This is the github service provider class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-GitHub/blob/master/LICENSE.md> Apache 2.0
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
        $this->app->singleton('github.factory', function ($app) {
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
        $this->app->singleton('github', function ($app) {
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
        return array(
            'github',
            'github.factory',
        );
    }
}
