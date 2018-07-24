<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\StatusCheck\StatusCheckState;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\BranchStatusPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusChecks;
use PhpSpec\ObjectBehavior;

class BranchStatusPayloadSpec extends ObjectBehavior
{
    public function let(BranchName $name, CommitSha $sha, StatusCheckState $status, StatusChecks $statusChecks)
    {
        $this->beConstructedWith($name, $sha, $status, $statusChecks);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BranchStatusPayload::class);
    }

    public function it_exposes_name(BranchName $name)
    {
        $this->getName()->shouldReturn($name);
    }

    public function it_exposes_sha(CommitSha $sha)
    {
        $this->getSha()->shouldReturn($sha);
    }

    public function it_exposes_status(StatusCheckState $status)
    {
        $this->getStatus()->shouldReturn($status);
    }

    public function it_exposes_status_checks(StatusChecks $statusChecks)
    {
        $this->getStatusChecks()->shouldReturn($statusChecks);
    }

    public function it_can_be_serialized(
        BranchName $name, CommitSha $sha, StatusCheckState $status, StatusChecks $statusChecks
    ) {
        $name->serialize()->shouldBeCalled()->willReturn('feature-branch');
        $sha->serialize()->shouldBeCalled()->willReturn('99e0be5323d5e95d6021aa1b28684c600c878528');
        $status->serialize()->shouldBeCalled()->willReturn('pending');
        $statusChecks->serialize()->shouldBeCalled()->willReturn(
            [
                [
                    'id'              => 1,
                    'state'           => 'pending',
                    'description'     => 'value',
                    'targetUrl'       => 'targetUrl',
                    'context'         => 'ci/circleci',
                    'externalService' => [
                        'context'   => 'ci/circleci',
                        'className' => 'DevboardLib\GitHub\External\Service\ContinuousIntegration\CircleCi',
                    ],
                    'creator' => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                    'createdAt' => '2018-01-01T00:01:00+00:00',
                ],
            ]
        );
        $this->serialize()->shouldReturn(
            [
                'name'         => 'feature-branch',
                'sha'          => '99e0be5323d5e95d6021aa1b28684c600c878528',
                'status'       => 'pending',
                'statusChecks' => [
                    [
                        'id'              => 1,
                        'state'           => 'pending',
                        'description'     => 'value',
                        'targetUrl'       => 'targetUrl',
                        'context'         => 'ci/circleci',
                        'externalService' => [
                            'context'   => 'ci/circleci',
                            'className' => 'DevboardLib\GitHub\External\Service\ContinuousIntegration\CircleCi',
                        ],
                        'creator' => [
                            'userId'    => 1,
                            'login'     => 'value',
                            'type'      => AccountType::USER,
                            'avatarUrl' => 'avatarUrl',
                            'siteAdmin' => true,
                        ],
                        'createdAt' => '2018-01-01T00:01:00+00:00',
                    ],
                ],
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
            'name'         => 'feature-branch',
            'sha'          => '99e0be5323d5e95d6021aa1b28684c600c878528',
            'status'       => 'pending',
            'statusChecks' => [
                [
                    'id'              => 1,
                    'state'           => 'pending',
                    'description'     => 'value',
                    'targetUrl'       => 'targetUrl',
                    'context'         => 'ci/circleci',
                    'externalService' => [
                        'context'   => 'ci/circleci',
                        'className' => 'DevboardLib\GitHub\External\Service\ContinuousIntegration\CircleCi',
                    ],
                    'creator' => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                    'createdAt' => '2018-01-01T00:01:00+00:00',
                ],
            ],
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(BranchStatusPayload::class);
    }
}
