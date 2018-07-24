<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchesPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchPayload;
use PhpSpec\ObjectBehavior;

class BranchesPayloadSpec extends ObjectBehavior
{
    public function let(BranchPayload $branchResult)
    {
        $this->beConstructedWith($elements = [$branchResult]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BranchesPayload::class);
    }

    public function it_exposes_elements(BranchPayload $branchResult)
    {
        $this->toArray()->shouldReturn([$branchResult]);
    }

    public function it_exposes_number_of_elements_in_collection()
    {
        $this->count()->shouldReturn(1);
    }

    public function it_supports_add_new_element(BranchPayload $anotherBranchPayload)
    {
        $this->add($anotherBranchPayload);
        $this->count()->shouldReturn(2);
    }

    public function it_knows_if_element_is_in_collection(BranchPayload $branchResult, BranchName $branchName)
    {
        $branchResult->getName()->shouldBeCalled()->willReturn($branchName);
        $this->has($branchName)->shouldReturn(true);
    }

    public function it_can_return_element_from_collection_by_given_id(
        BranchPayload $branchResult, BranchName $branchName
    ) {
        $branchResult->getName()->shouldBeCalled()->willReturn($branchName);
        $this->get($branchName)->shouldReturn($branchResult);
    }
}
