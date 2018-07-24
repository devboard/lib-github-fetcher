<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\BranchStatusesPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\RepositoryBranchStatusesResult;
use PhpSpec\ObjectBehavior;

class RepositoryBranchStatusesResultSpec extends ObjectBehavior
{
    public function let(
        RepoFullName $fullName,
        InstallationId $installationId,
        UserId $userId,
        BranchStatusesPayload $branchStatusResults
    ) {
        $this->beConstructedWith($fullName, $installationId, $userId, $branchStatusResults);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RepositoryBranchStatusesResult::class);
    }
}
