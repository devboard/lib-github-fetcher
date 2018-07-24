<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitDetails;
use PhpSpec\ObjectBehavior;

class BranchPayloadSpec extends ObjectBehavior
{
    public function let(BranchName $name, CommitDetails $commit)
    {
        $this->beConstructedWith($name, $commit);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BranchPayload::class);
    }

    public function it_exposes_name(BranchName $name)
    {
        $this->getName()->shouldReturn($name);
    }

    public function it_exposes_commit(CommitDetails $commit)
    {
        $this->getCommit()->shouldReturn($commit);
    }

    public function it_can_be_serialized(BranchName $name, CommitDetails $commit)
    {
        $name->serialize()->shouldBeCalled()->willReturn('name');
        $commit->serialize()->shouldBeCalled()->willReturn(
            [
                'sha'        => 'sha',
                'message'    => 'message',
                'commitDate' => '2018-01-01T00:01:00+00:00',
                'author'     => [
                    '__type'     => 'BasicCommitAuthorDetails',
                    'name'       => 'Jane Johnson',
                    'email'      => 'jane@example.com',
                    'commitDate' => '2018-01-02T20:21:22+00:00',
                ],
                'committer' => [
                    '__type'     => 'BasicCommitCommitterDetails',
                    'name'       => 'Jane Johnson',
                    'email'      => 'jane@example.com',
                    'commitDate' => '2018-01-02T20:21:22+00:00',
                ],
                'tree'         => ['sha' => 'sha'],
                'parents'      => [['sha' => 'sha']],
                'verification' => [
                    'verified'  => true,
                    'reason'    => 'reason',
                    'signature' => 'signature',
                    'payload'   => 'payload',
                    'email'     => 'value',
                    'signer'    => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'name'      => 'name',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                    'wasSignedByGitHub' => true,
                ],
            ]
        );
        $this->serialize()->shouldReturn(
            [
                'name'   => 'name',
                'commit' => [
                    'sha'        => 'sha',
                    'message'    => 'message',
                    'commitDate' => '2018-01-01T00:01:00+00:00',
                    'author'     => [
                        '__type'     => 'BasicCommitAuthorDetails',
                        'name'       => 'Jane Johnson',
                        'email'      => 'jane@example.com',
                        'commitDate' => '2018-01-02T20:21:22+00:00',
                    ],
                    'committer' => [
                        '__type'     => 'BasicCommitCommitterDetails',
                        'name'       => 'Jane Johnson',
                        'email'      => 'jane@example.com',
                        'commitDate' => '2018-01-02T20:21:22+00:00',
                    ],
                    'tree'         => ['sha' => 'sha'],
                    'parents'      => [['sha' => 'sha']],
                    'verification' => [
                        'verified'  => true,
                        'reason'    => 'reason',
                        'signature' => 'signature',
                        'payload'   => 'payload',
                        'email'     => 'value',
                        'signer'    => [
                            'userId'    => 1,
                            'login'     => 'value',
                            'name'      => 'name',
                            'type'      => AccountType::USER,
                            'avatarUrl' => 'avatarUrl',
                            'siteAdmin' => true,
                        ],
                        'wasSignedByGitHub' => true,
                    ],
                ],
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
            'name'   => 'name',
            'commit' => [
                'sha'        => 'sha',
                'message'    => 'message',
                'commitDate' => '2018-01-01T00:01:00+00:00',
                'author'     => [
                    '__type'     => 'BasicCommitAuthorDetails',
                    'name'       => 'Jane Johnson',
                    'email'      => 'jane@example.com',
                    'commitDate' => '2018-01-02T20:21:22+00:00',
                ],
                'committer' => [
                    '__type'     => 'BasicCommitCommitterDetails',
                    'name'       => 'Jane Johnson',
                    'email'      => 'jane@example.com',
                    'commitDate' => '2018-01-02T20:21:22+00:00',
                ],
                'tree'         => ['sha' => 'sha'],
                'parents'      => [['sha' => 'sha']],
                'verification' => [
                    'verified'  => true,
                    'reason'    => 'reason',
                    'signature' => 'signature',
                    'payload'   => 'payload',
                    'email'     => 'value',
                    'signer'    => [
                        'userId'    => 1,
                        'login'     => 'value',
                        'name'      => 'name',
                        'type'      => AccountType::USER,
                        'avatarUrl' => 'avatarUrl',
                        'siteAdmin' => true,
                    ],
                    'wasSignedByGitHub' => true,
                ],
            ],
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(BranchPayload::class);
    }
}
