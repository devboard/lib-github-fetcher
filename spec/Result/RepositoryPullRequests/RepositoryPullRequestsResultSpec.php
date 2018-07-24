<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequests;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\RepositoryPullRequestsResult;
use PhpSpec\ObjectBehavior;

class RepositoryPullRequestsResultSpec extends ObjectBehavior
{
    public function let(RepoFullName $fullName, InstallationId $installationId, UserId $userId, PullRequests $payload)
    {
        $this->beConstructedWith($fullName, $installationId, $userId, $payload);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RepositoryPullRequestsResult::class);
    }
}
