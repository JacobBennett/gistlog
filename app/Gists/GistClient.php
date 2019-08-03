<?php

namespace App\Gists;

use Exception;
use App\CachesGitHubResponses;
use Github\Client as GitHubClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Exceptions\GistNotFoundException;
use Github\HttpClient\Message\ResponseMediator;

class GistClient
{
    use CachesGitHubResponses;

    /**
     * @var GitHubClient
     */
    private $github;

    public function __construct(GitHubClient $github)
    {
        $this->github = $github;
    }

    public function getGitHubClient()
    {
        return $this->github;
    }

    /**
     * @param $gistId
     * @return array
     * @throws GistNotFoundException
     */
    public function getGist($gistId)
    {
        return Cache::remember(self::cacheKey(__METHOD__, $gistId), $this->cacheLength, function () use ($gistId) {
            try {
                return $this->github->api('gists')->show($gistId);
            } catch (Exception $e) {
                throw new GistNotFoundException($gistId, $e->getMessage());
            }
        });
    }

    /**
     * @param $gistId
     * @return array
     */
    public function getGistComments($gistId)
    {
        return Cache::remember(self::cacheKey(__METHOD__, $gistId), $this->cacheLength, function () use ($gistId) {
            return ResponseMediator::getContent(
                $this->github->getHttpClient()->get("gists/{$gistId}/comments")
            );
        });
    }

    /**
     * @param $gistId
     * @param $comment
     * @return array
     */
    public function postGistComment($gistId, $comment)
    {
        $this->github->authenticate(Auth::user()->token, GitHubClient::AUTH_HTTP_TOKEN);
        $response = $this->github->getHttpClient()->post("gists/{$gistId}/comments", json_encode(['body' => $comment]));

        return ResponseMediator::getContent($response);
    }
}
