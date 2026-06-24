<?php

declare(strict_types=1);

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\GitHub\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getConnectionConfig(string|null $name = null)
 * @method static \GrahamCampbell\GitHub\GitHubFactory getFactory()
 * @method static object connection(string|null $name = null)
 * @method static object reconnect(string|null $name = null)
 * @method static void disconnect(string|null $name = null)
 * @method static string getDefaultConnection()
 * @method static void setDefaultConnection(string $name)
 * @method static void extend(string $name, callable $resolver)
 * @method static array getConnections()
 * @method static \Illuminate\Contracts\Config\Repository getConfig()
 * @method static \Github\Api\CurrentUser currentUser()
 * @method static \Github\Api\CurrentUser me()
 * @method static \Github\Api\Copilot\Usage copilotUsage()
 * @method static \Github\Api\Deployment deployment()
 * @method static \Github\Api\Deployment deployments()
 * @method static \Github\Api\Enterprise ent()
 * @method static \Github\Api\Enterprise enterprise()
 * @method static \Github\Api\Miscellaneous\CodeOfConduct codeOfConduct()
 * @method static \Github\Api\Miscellaneous\Emojis emojis()
 * @method static \Github\Api\Miscellaneous\Licenses licenses()
 * @method static \Github\Api\GitData git()
 * @method static \Github\Api\GitData gitData()
 * @method static \Github\Api\Gists gist()
 * @method static \Github\Api\Gists gists()
 * @method static \Github\Api\Miscellaneous\Gitignore gitignore()
 * @method static \Github\Api\Apps apps()
 * @method static \Github\Api\Issue issue()
 * @method static \Github\Api\Issue issues()
 * @method static \Github\Api\Markdown markdown()
 * @method static \Github\Api\Notification notification()
 * @method static \Github\Api\Notification notifications()
 * @method static \Github\Api\Organization organization()
 * @method static \Github\Api\Organization organizations()
 * @method static \Github\Api\Organization\Projects orgProject()
 * @method static \Github\Api\Organization\Projects orgProjects()
 * @method static \Github\Api\Organization\Projects organizationProject()
 * @method static \Github\Api\Organization\Projects organizationProjects()
 * @method static \Github\Api\Organization\Members member()
 * @method static \Github\Api\Organization\Members members()
 * @method static \Github\Api\Organization\OutsideCollaborators outsideCollaborators()
 * @method static \Github\Api\PullRequest pr()
 * @method static \Github\Api\PullRequest pullRequest()
 * @method static \Github\Api\PullRequest pullRequests()
 * @method static \Github\Api\RateLimit rateLimit()
 * @method static \Github\Api\Repo repo()
 * @method static \Github\Api\Repo repos()
 * @method static \Github\Api\Repo repository()
 * @method static \Github\Api\Repo repositories()
 * @method static \Github\Api\Search search()
 * @method static \Github\Api\Organization\Teams team()
 * @method static \Github\Api\Organization\Teams teams()
 * @method static \Github\Api\User user()
 * @method static \Github\Api\User users()
 * @method static \Github\Api\Authorizations authorization()
 * @method static \Github\Api\Authorizations authorizations()
 * @method static \Github\Api\Meta meta()
 * @method static \Github\Api\GraphQL graphql()
 * @method static \Github\Api\AbstractApi api(string $name)
 * @method static void authenticate(string $tokenOrLogin, string|null $password = null, string|null $authMethod = null)
 * @method static void setEnterpriseUrl(string $enterpriseUrl)
 * @method static string getApiVersion()
 * @method static void addCache(\Psr\Cache\CacheItemPoolInterface $cachePool, array $config = [])
 * @method static void removeCache()
 * @method static \Psr\Http\Message\ResponseInterface|null getLastResponse()
 * @method static \Http\Client\Common\HttpMethodsClientInterface getHttpClient()
 *
 * @see \GrahamCampbell\GitHub\GitHubManager
 */
class GitHub extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'github';
    }
}
