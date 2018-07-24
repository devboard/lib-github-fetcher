<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\InstallationRepositories;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubFetcher\Result\GitHubFetcherResult;
use DevboardLib\GitHubFetcher\Result\InstallationRepositories\InstallationRepositoriesResult;
use DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\GitHubRepositoriesPayload;
use PhpSpec\ObjectBehavior;

class InstallationRepositoriesResultSpec extends ObjectBehavior
{
    public function let(InstallationId $installationId, UserId $userId, GitHubRepositoriesPayload $payload)
    {
        $this->beConstructedWith($installationId, $userId, $payload);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(InstallationRepositoriesResult::class);
        $this->shouldImplement(GitHubFetcherResult::class);
    }
}
