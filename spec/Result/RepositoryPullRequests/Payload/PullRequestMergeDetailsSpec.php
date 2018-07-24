<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DateTime;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergedBy;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergeDetails;
use PhpSpec\ObjectBehavior;

class PullRequestMergeDetailsSpec extends ObjectBehavior
{
    public function let(PullRequestMergedBy $mergedBy, DateTime $mergedAt)
    {
        $this->beConstructedWith($mergedBy, $mergedAt);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestMergeDetails::class);
    }

    public function it_exposes_merged_by(PullRequestMergedBy $mergedBy)
    {
        $this->getMergedBy()->shouldReturn($mergedBy);
    }

    public function it_exposes_merged_at(DateTime $mergedAt)
    {
        $this->getMergedAt()->shouldReturn($mergedAt);
    }

    public function it_can_be_serialized(PullRequestMergedBy $mergedBy, DateTime $mergedAt)
    {
        $mergedBy->serialize()->shouldBeCalled()->willReturn(
            [
                'userId'    => 1,
                'login'     => 'value',
                'name'      => 'name',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ]
        );
        $mergedAt->format('c')->shouldBeCalled()->willReturn('2018-01-01T00:01:00+00:00');
        $this->serialize()->shouldReturn(
            [
                'mergedBy' => [
                    'userId'    => 1,
                    'login'     => 'value',
                    'name'      => 'name',
                    'type'      => AccountType::USER,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
                'mergedAt' => '2018-01-01T00:01:00+00:00',
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
            'mergedBy' => [
                'userId'    => 1,
                'login'     => 'value',
                'name'      => 'name',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ],
            'mergedAt' => '2018-01-01T00:01:00+00:00',
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(PullRequestMergeDetails::class);
    }
}
