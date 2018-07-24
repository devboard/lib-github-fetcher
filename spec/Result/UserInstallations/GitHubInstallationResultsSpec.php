<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\UserInstallations;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResult;
use DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResults;
use PhpSpec\ObjectBehavior;

class GitHubInstallationResultsSpec extends ObjectBehavior
{
    public function let(GitHubInstallationResult $gitHubInstallationResult)
    {
        $this->beConstructedWith($elements = [$gitHubInstallationResult]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(GitHubInstallationResults::class);
    }

    public function it_exposes_elements(GitHubInstallationResult $gitHubInstallationResult)
    {
        $this->toArray()->shouldReturn([$gitHubInstallationResult]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(GitHubInstallationResult $anotherGitHubInstallationResult)
    {
        $this->add($anotherGitHubInstallationResult);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(
        GitHubInstallationResult $gitHubInstallationResult, InstallationId $installationId
    ) {
        $gitHubInstallationResult->getInstallationId()->shouldBeCalled()->willReturn($installationId);
        $this->has($installationId)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        GitHubInstallationResult $gitHubInstallationResult, InstallationId $installationId
    ) {
        $gitHubInstallationResult->getInstallationId()->shouldBeCalled()->willReturn($installationId);
        $this->get($installationId)->shouldReturn($gitHubInstallationResult);
    }
}
