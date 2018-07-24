<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload;

use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusesPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusPayload;
use PhpSpec\ObjectBehavior;

class PullRequestStatusesPayloadSpec extends ObjectBehavior
{
    public function let(PullRequestStatusPayload $pullRequestStatusResult)
    {
        $this->beConstructedWith($elements = [$pullRequestStatusResult]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestStatusesPayload::class);
    }

    public function it_exposes_elements(PullRequestStatusPayload $pullRequestStatusResult)
    {
        $this->toArray()->shouldReturn([$pullRequestStatusResult]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(PullRequestStatusPayload $anotherPullRequestStatusPayload)
    {
        $this->add($anotherPullRequestStatusPayload);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(
        PullRequestStatusPayload $pullRequestStatusResult, PullRequestNumber $pullRequestNumber
    ) {
        $pullRequestStatusResult->getNumber()->shouldBeCalled()->willReturn($pullRequestNumber);
        $this->has($pullRequestNumber)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        PullRequestStatusPayload $pullRequestStatusResult, PullRequestNumber $pullRequestNumber
    ) {
        $pullRequestStatusResult->getNumber()->shouldBeCalled()->willReturn($pullRequestNumber);
        $this->get($pullRequestNumber)->shouldReturn($pullRequestStatusResult);
    }
}
