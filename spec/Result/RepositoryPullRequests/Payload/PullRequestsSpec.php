<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\PullRequest\PullRequestId;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequest;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequests;
use PhpSpec\ObjectBehavior;

class PullRequestsSpec extends ObjectBehavior
{
    public function let(PullRequest $pullRequest)
    {
        $this->beConstructedWith($elements = [$pullRequest]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequests::class);
    }

    public function it_exposes_elements(PullRequest $pullRequest)
    {
        $this->toArray()->shouldReturn([$pullRequest]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(PullRequest $anotherPullRequest)
    {
        $this->add($anotherPullRequest);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(PullRequest $pullRequest, PullRequestId $pullRequestId)
    {
        $pullRequest->getId()->shouldBeCalled()->willReturn($pullRequestId);
        $this->has($pullRequestId)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        PullRequest $pullRequest, PullRequestId $pullRequestId
    ) {
        $pullRequest->getId()->shouldBeCalled()->willReturn($pullRequestId);
        $this->get($pullRequestId)->shouldReturn($pullRequest);
    }
}
