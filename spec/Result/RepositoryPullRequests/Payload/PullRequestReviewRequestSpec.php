<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestRequestedReviewer;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequest;
use PhpSpec\ObjectBehavior;

class PullRequestReviewRequestSpec extends ObjectBehavior
{
    public function let(PullRequestRequestedReviewer $requestedReviewer)
    {
        $this->beConstructedWith($id = 2343423423423, $requestedReviewer);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestReviewRequest::class);
    }

    public function it_exposes_id()
    {
        $this->getId()->shouldReturn(2343423423423);
    }

    public function it_exposes_requested_reviewer(PullRequestRequestedReviewer $requestedReviewer)
    {
        $this->getRequestedReviewer()->shouldReturn($requestedReviewer);
    }

    public function it_can_be_serialized(PullRequestRequestedReviewer $requestedReviewer)
    {
        $requestedReviewer->serialize()->shouldBeCalled()->willReturn(
            [
                'userId'    => 1,
                'login'     => 'value',
                'name'      => 'name',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ]
        );
        $this->serialize()->shouldReturn(
            [
                'id'                => 2343423423423,
                'requestedReviewer' => [
                    'userId'    => 1,
                    'login'     => 'value',
                    'name'      => 'name',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
            'id'                => 2343423423423,
            'requestedReviewer' => [
                'userId'    => 1,
                'login'     => 'value',
                'name'      => 'name',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ],
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(PullRequestReviewRequest::class);
    }
}
