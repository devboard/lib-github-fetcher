<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Label\LabelId;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabel;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabels;
use PhpSpec\ObjectBehavior;

class PullRequestLabelsSpec extends ObjectBehavior
{
    public function let(PullRequestLabel $pullRequestLabel)
    {
        $this->beConstructedWith($elements = [$pullRequestLabel]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestLabels::class);
    }

    public function it_exposes_elements(PullRequestLabel $pullRequestLabel)
    {
        $this->toArray()->shouldReturn([$pullRequestLabel]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(PullRequestLabel $anotherPullRequestLabel)
    {
        $this->add($anotherPullRequestLabel);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(PullRequestLabel $pullRequestLabel, LabelId $labelId)
    {
        $pullRequestLabel->getId()->shouldBeCalled()->willReturn($labelId);
        $this->has($labelId)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        PullRequestLabel $pullRequestLabel, LabelId $labelId
    ) {
        $pullRequestLabel->getId()->shouldBeCalled()->willReturn($labelId);
        $this->get($labelId)->shouldReturn($pullRequestLabel);
    }
}
