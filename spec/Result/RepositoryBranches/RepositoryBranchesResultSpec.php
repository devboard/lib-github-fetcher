<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubFetcher\Result\GitHubFetcherResult;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchesPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\RepositoryBranchesResult;
use PhpSpec\ObjectBehavior;

class RepositoryBranchesResultSpec extends ObjectBehavior
{
    public function let(
        RepoFullName $fullName, InstallationId $installationId, UserId $userId, BranchesPayload $branchResults
    ) {
        $this->beConstructedWith($fullName, $installationId, $userId, $branchResults);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RepositoryBranchesResult::class);
        $this->shouldImplement(GitHubFetcherResult::class);
    }
}
