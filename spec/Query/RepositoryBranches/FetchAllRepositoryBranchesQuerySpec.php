<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Query\RepositoryBranches;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubFetcher\Query\GitHubFetcherQuery;
use DevboardLib\GitHubFetcher\Query\RepositoryBranches\FetchAllRepositoryBranchesQuery;
use PhpSpec\ObjectBehavior;

class FetchAllRepositoryBranchesQuerySpec extends ObjectBehavior
{
    public function let(RepoFullName $fullName, InstallationId $installationId, UserId $userId)
    {
        $this->beConstructedWith($fullName, $installationId, $userId);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FetchAllRepositoryBranchesQuery::class);
        $this->shouldImplement(GitHubFetcherQuery::class);
    }

    public function it_exposes_repo_full_name(RepoFullName $fullName)
    {
        $this->getRepoFullName()->shouldReturn($fullName);
    }

    public function it_exposes_installation_id(InstallationId $installationId)
    {
        $this->getInstallationId()->shouldReturn($installationId);
    }

    public function it_exposes_github_user_id(UserId $userId)
    {
        $this->getUserId()->shouldReturn($userId);
    }

    public function it_exposes_credentials()
    {
        $this->getCredentials()->shouldReturnAnInstanceOf(InstallationCredentials::class);
    }

    public function it_can_be_serialized_for_queue(
        RepoFullName $fullName, InstallationId $installationId, UserId $userId
    ) {
        $fullName->serialize()->shouldBeCalled()->willReturn(['owner' => 'owner', 'repoName' => 'project']);
        $installationId->serialize()->shouldBeCalled()->willReturn(56);
        $userId->serialize()->shouldBeCalled()->willReturn(123);

        $this->serialize()->shouldReturn(
            [
                'repoFullName'   => ['owner' => 'owner', 'repoName' => 'project'],
                'installationId' => 56,
                'userId'         => 123,
            ]
        );
    }

    public function it_can_be_deserialized_from_queue_data()
    {
        $input = [
            'repoFullName'   => ['owner' => 'owner', 'repoName' => 'project'],
            'installationId' => 56,
            'userId'         => 123,
        ];
        $this->deserialize($input)->shouldReturnAnInstanceOf(FetchAllRepositoryBranchesQuery::class);
    }
}
