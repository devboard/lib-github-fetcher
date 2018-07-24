<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Query\InstallationRepositories;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubFetcher\Query\GitHubFetcherQuery;
use DevboardLib\GitHubFetcher\Query\InstallationRepositories\FetchAllInstallationRepositoriesQuery;
use PhpSpec\ObjectBehavior;

class FetchAllInstallationRepositoriesQuerySpec extends ObjectBehavior
{
    public function let(InstallationId $installationId, UserId $userId)
    {
        $this->beConstructedWith($installationId, $userId);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FetchAllInstallationRepositoriesQuery::class);
        $this->shouldImplement(GitHubFetcherQuery::class);
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

    public function it_can_be_serialized_for_queue(InstallationId $installationId, UserId $userId)
    {
        $installationId->serialize()->shouldBeCalled()->willReturn(56);
        $userId->serialize()->shouldBeCalled()->willReturn(123);

        $this->serialize()->shouldReturn(['installationId' => 56, 'userId' => 123]);
    }

    public function it_can_be_deserialized_from_queue_data()
    {
        $input = ['installationId' => 56, 'userId' => 123];
        $this->deserialize($input)->shouldReturnAnInstanceOf(FetchAllInstallationRepositoriesQuery::class);
    }
}
