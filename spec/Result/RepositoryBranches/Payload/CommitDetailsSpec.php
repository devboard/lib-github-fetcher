<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\CommitMessage;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Commit\CommitParentCollection;
use DevboardLib\GitHub\Commit\CommitTree;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitAuthor;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitCommitter;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitDetails;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitVerification;
use PhpSpec\ObjectBehavior;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class CommitDetailsSpec extends ObjectBehavior
{
    public function let(
        CommitSha $sha,
        CommitMessage $message,
        CommitDate $commitDate,
        CommitAuthor $author,
        CommitCommitter $committer,
        CommitTree $tree,
        CommitParentCollection $parents,
        CommitVerification $verification
    ) {
        $this->beConstructedWith($sha, $message, $commitDate, $author, $committer, $tree, $parents, $verification);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CommitDetails::class);
    }

    public function it_exposes_sha(CommitSha $sha)
    {
        $this->getSha()->shouldReturn($sha);
    }

    public function it_exposes_message(CommitMessage $message)
    {
        $this->getMessage()->shouldReturn($message);
    }

    public function it_exposes_commit_date(CommitDate $commitDate)
    {
        $this->getCommitDate()->shouldReturn($commitDate);
    }

    public function it_exposes_author(CommitAuthor $author)
    {
        $this->getAuthor()->shouldReturn($author);
    }

    public function it_exposes_committer(CommitCommitter $committer)
    {
        $this->getCommitter()->shouldReturn($committer);
    }

    public function it_exposes_tree(CommitTree $tree)
    {
        $this->getTree()->shouldReturn($tree);
    }

    public function it_exposes_parents(CommitParentCollection $parents)
    {
        $this->getParents()->shouldReturn($parents);
    }

    public function it_exposes_verification(CommitVerification $verification)
    {
        $this->getVerification()->shouldReturn($verification);
    }

    public function it_has_verification()
    {
        $this->hasVerification()->shouldReturn(true);
    }

    public function it_can_be_serialized(
        CommitSha $sha,
        CommitMessage $message,
        CommitDate $commitDate,
        CommitAuthor $author,
        CommitCommitter $committer,
        CommitTree $tree,
        CommitParentCollection $parents,
        CommitVerification $verification
    ) {
        $sha->serialize()->shouldBeCalled()->willReturn('sha');
        $message->serialize()->shouldBeCalled()->willReturn('message');
        $commitDate->serialize()->shouldBeCalled()->willReturn('2018-01-01T00:01:00+00:00');
        $author->serialize()->shouldBeCalled()->willReturn(
            [
                '__type'     => 'BasicCommitAuthorDetails',
                'name'       => 'Jane Johnson',
                'email'      => 'jane@example.com',
                'commitDate' => '2018-01-02T20:21:22+00:00',
            ]
        );
        $committer->serialize()->shouldBeCalled()->willReturn(
            [
                '__type'     => 'BasicCommitCommitterDetails',
                'name'       => 'Jane Johnson',
                'email'      => 'jane@example.com',
                'commitDate' => '2018-01-02T20:21:22+00:00',
            ]
        );
        $tree->serialize()->shouldBeCalled()->willReturn(['sha' => 'sha']);
        $parents->serialize()->shouldBeCalled()->willReturn([['sha' => 'sha']]);
        $verification->serialize()->shouldBeCalled()->willReturn(
            [
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
            ]
        );
        $this->serialize()->shouldReturn(
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
    }

    public function it_can_be_deserialized()
    {
        $input = [
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
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(CommitDetails::class);
    }
}
