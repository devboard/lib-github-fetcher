<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\PullRequestReview\PullRequestReviewId;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReview;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviews;
use PhpSpec\ObjectBehavior;

class PullRequestReviewsSpec extends ObjectBehavior
{
    public function let(PullRequestReview $pullRequestReview)
    {
        $this->beConstructedWith($elements = [$pullRequestReview]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestReviews::class);
    }

    public function it_exposes_elements(PullRequestReview $pullRequestReview)
    {
        $this->toArray()->shouldReturn([$pullRequestReview]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(PullRequestReview $anotherPullRequestReview)
    {
        $this->add($anotherPullRequestReview);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(
        PullRequestReview $pullRequestReview, PullRequestReviewId $pullRequestReviewId
    ) {
        $pullRequestReview->getId()->shouldBeCalled()->willReturn($pullRequestReviewId);
        $this->has($pullRequestReviewId)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        PullRequestReview $pullRequestReview, PullRequestReviewId $pullRequestReviewId
    ) {
        $pullRequestReview->getId()->shouldBeCalled()->willReturn($pullRequestReviewId);
        $this->get($pullRequestReviewId)->shouldReturn($pullRequestReview);
    }
}
