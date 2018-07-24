<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\UserInstallations;

namespace DevboardLib\GitHubFetcher\Result\UserInstallations;

use DevboardLib\GitHubFetcher\Result\GitHubFetcherResult;
use PhpSpec\ObjectBehavior;

class UserGitHubInstallationsResultSpec extends ObjectBehavior
{
    public function let(UserId $userId, GitHubInstallationResults $gitHubInstallationCollection)
    {
        $this->beConstructedWith($userId, $gitHubInstallationCollection);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserGitHubInstallationsResult::class);
        $this->shouldImplement(GitHubFetcherResult::class);
    }
}
