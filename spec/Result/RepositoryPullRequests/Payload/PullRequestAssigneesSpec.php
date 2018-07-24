<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignee;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignees;
use PhpSpec\ObjectBehavior;

class PullRequestAssigneesSpec extends ObjectBehavior
{
    public function let(PullRequestAssignee $pullRequestAssignee)
    {
        $this->beConstructedWith($elements = [$pullRequestAssignee]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestAssignees::class);
    }

    public function it_exposes_elements(PullRequestAssignee $pullRequestAssignee)
    {
        $this->toArray()->shouldReturn([$pullRequestAssignee]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(PullRequestAssignee $anotherPullRequestAssignee)
    {
        $this->add($anotherPullRequestAssignee);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(
        PullRequestAssignee $pullRequestAssignee, AccountId $accountId
    ) {
        $pullRequestAssignee->getUserId()->shouldBeCalled()->willReturn($accountId);
        $this->has($accountId)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        PullRequestAssignee $pullRequestAssignee, AccountId $accountId
    ) {
        $pullRequestAssignee->getUserId()->shouldBeCalled()->willReturn($accountId);
        $this->get($accountId)->shouldReturn($pullRequestAssignee);
    }
}
