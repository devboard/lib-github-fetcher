<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload;

use DevboardLib\GitHub\Repo\RepoId;
use DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\GitHubRepositoriesPayload;
use DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\GitHubRepositoryPayload;
use PhpSpec\ObjectBehavior;

class GitHubRepositoriesPayloadSpec extends ObjectBehavior
{
    public function let(GitHubRepositoryPayload $gitHubRepositoryResult)
    {
        $this->beConstructedWith($elements = [$gitHubRepositoryResult]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(GitHubRepositoriesPayload::class);
    }

    public function it_exposes_elements(GitHubRepositoryPayload $gitHubRepositoryResult)
    {
        $this->toArray()->shouldReturn([$gitHubRepositoryResult]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(GitHubRepositoryPayload $anotherGitHubRepositoryResult)
    {
        $this->add($anotherGitHubRepositoryResult);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(
        GitHubRepositoryPayload $gitHubRepositoryResult, RepoId $repoId
    ) {
        $gitHubRepositoryResult->getId()->shouldBeCalled()->willReturn($repoId);
        $this->has($repoId)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        GitHubRepositoryPayload $gitHubRepositoryResult, RepoId $repoId
    ) {
        $gitHubRepositoryResult->getId()->shouldBeCalled()->willReturn($repoId);
        $this->get($repoId)->shouldReturn($gitHubRepositoryResult);
    }
}
