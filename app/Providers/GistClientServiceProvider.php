<?php

namespace Gistlog\Providers;

use Gistlog\Gists\GistClient;
use Github\Client as GitHubClient;
use Illuminate\Support\ServiceProvider;
use Github\HttpClient\CachedHttpClient as CachedGitHubClient;

class GistClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(GistClient::class, function ($app) {
            $githubClient = new GitHubClient;

            // We're only making public API requests, so we don't *need* to
            // authenticate, but doing so significantly increases the rate
            // limit. So here we authenticate if credentials are provided,
            // but if they aren't, no big deal.
            if (config('services.github.token')) {
                $githubClient->authenticate(
                    config('services.github.client_id'),
                    config('services.github.client_secret'),
                    GitHubClient::AUTH_URL_CLIENT_ID
                );
            }

            return new GistClient($githubClient);
        });
    }
}
