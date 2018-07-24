<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubFetcher\Result\GitHubFetcherResult;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusesPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\RepositoryPullRequestStatusesResult;
use PhpSpec\ObjectBehavior;

class RepositoryPullRequestStatusesResultSpec extends ObjectBehavior
{
    public function let(
        RepoFullName $fullName, InstallationId $installationId, UserId $userId, PullRequestStatusesPayload $payload
    ) {
        $this->beConstructedWith($fullName, $installationId, $userId, $payload);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RepositoryPullRequestStatusesResult::class);
        $this->shouldImplement(GitHubFetcherResult::class);
    }
}
