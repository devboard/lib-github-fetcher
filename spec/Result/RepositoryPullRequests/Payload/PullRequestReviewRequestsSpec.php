<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequest;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequests;
use PhpSpec\ObjectBehavior;

class PullRequestReviewRequestsSpec extends ObjectBehavior
{
    public function let(PullRequestReviewRequest $pullRequestReviewRequest)
    {
        $this->beConstructedWith($elements = [$pullRequestReviewRequest]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestReviewRequests::class);
    }

    public function it_exposes_elements(PullRequestReviewRequest $pullRequestReviewRequest)
    {
        $this->toArray()->shouldReturn([$pullRequestReviewRequest]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(PullRequestReviewRequest $anotherPullRequestReviewRequest)
    {
        $this->add($anotherPullRequestReviewRequest);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(PullRequestReviewRequest $pullRequestReviewRequest)
    {
        $pullRequestReviewRequest->getId()->shouldBeCalled()->willReturn(1);
        $this->has(1)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        PullRequestReviewRequest $pullRequestReviewRequest
    ) {
        $pullRequestReviewRequest->getId()->shouldBeCalled()->willReturn(1);
        $this->get(1)->shouldReturn($pullRequestReviewRequest);
    }
}
