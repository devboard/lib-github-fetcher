<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\BranchStatusesPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\BranchStatusPayload;
use PhpSpec\ObjectBehavior;

class BranchStatusesPayloadSpec extends ObjectBehavior
{
    public function let(BranchStatusPayload $branchStatusResult)
    {
        $this->beConstructedWith($elements = [$branchStatusResult]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BranchStatusesPayload::class);
    }

    public function it_exposes_elements(BranchStatusPayload $branchStatusResult)
    {
        $this->toArray()->shouldReturn([$branchStatusResult]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(BranchStatusPayload $anotherBranchStatusResult)
    {
        $this->add($anotherBranchStatusResult);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(
        BranchStatusPayload $branchStatusResult, BranchName $branchName
    ) {
        $branchStatusResult->getName()->shouldBeCalled()->willReturn($branchName);
        $this->has($branchName)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        BranchStatusPayload $branchStatusResult, BranchName $branchName
    ) {
        $branchStatusResult->getName()->shouldBeCalled()->willReturn($branchName);
        $this->get($branchName)->shouldReturn($branchStatusResult);
    }
}
