<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload;

use DevboardLib\GitHub\StatusCheck\StatusCheckId;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusCheck;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusChecks;
use PhpSpec\ObjectBehavior;

class StatusChecksSpec extends ObjectBehavior
{
    public function let(StatusCheck $statusCheck)
    {
        $this->beConstructedWith($elements = [$statusCheck]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(StatusChecks::class);
    }

    public function it_exposes_elements(StatusCheck $statusCheck)
    {
        $this->toArray()->shouldReturn([$statusCheck]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(StatusCheck $anotherStatusCheck)
    {
        $this->add($anotherStatusCheck);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(StatusCheck $statusCheck, StatusCheckId $statusCheckId)
    {
        $statusCheck->getId()->shouldBeCalled()->willReturn($statusCheckId);
        $this->has($statusCheckId)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        StatusCheck $statusCheck, StatusCheckId $statusCheckId
    ) {
        $statusCheck->getId()->shouldBeCalled()->willReturn($statusCheckId);
        $this->get($statusCheckId)->shouldReturn($statusCheck);
    }
}
