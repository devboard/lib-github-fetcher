<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Branch\BranchName;
use DevboardLib\Git\Commit\Author\AuthorName;
use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\CommitMessage;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\Git\Commit\Committer\CommitterName;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Commit\CommitParent;
use DevboardLib\GitHub\Commit\CommitParentCollection;
use DevboardLib\GitHub\Commit\CommitTree;
use DevboardLib\GitHub\Commit\Verification\VerificationPayload;
use DevboardLib\GitHub\Commit\Verification\VerificationReason;
use DevboardLib\GitHub\Commit\Verification\VerificationSignature;
use DevboardLib\GitHub\Commit\Verification\VerificationVerified;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BasicCommitAuthorDetails;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BasicCommitCommitterDetails;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitDetails;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitSigner;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitVerification;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\BranchPayload
 * @group  unit
 */
class BranchPayloadTest extends TestCase
{
    /** @var BranchName */
    private $name;

    /** @var CommitDetails */
    private $commit;

    /** @var BranchPayload */
    private $sut;

    public function setUp(): void
    {
        $this->name   = new BranchName('name');
        $this->commit = new CommitDetails(
            new CommitSha('sha'),
            new CommitMessage('message'),
            new CommitDate('2018-01-01T00:01:00+00:00'),
            new BasicCommitAuthorDetails(
                new AuthorName('Jane Johnson'),
                new EmailAddress('jane@example.com'),
                new CommitDate('2018-01-02T20:21:22+00:00')
            ),
            new BasicCommitCommitterDetails(
                new CommitterName('Jane Johnson'),
                new EmailAddress('jane@example.com'),
                new CommitDate('2018-01-02T20:21:22+00:00')
            ),
            new CommitTree(new CommitSha('sha')),
            new CommitParentCollection([new CommitParent(new CommitSha('sha'))]),
            new CommitVerification(
                new VerificationVerified(true),
                new VerificationReason('reason'),
                new VerificationSignature('signature'),
                new VerificationPayload('payload'),
                new EmailAddress('value'),
                new CommitSigner(
                    new AccountId(1),
                    new AccountLogin('value'),
                    'name',
                    AccountType::USER(),
                    new AccountAvatarUrl('avatarUrl'),
                    true
                ),
                true
            )
        );
        $this->sut = new BranchPayload($this->name, $this->commit);
    }

    public function testGetName(): void
    {
        self::assertSame($this->name, $this->sut->getName());
    }

    public function testGetCommit(): void
    {
        self::assertSame($this->commit, $this->sut->getCommit());
    }

    public function testSerialize(): void
    {
        $expected = [
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

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, BranchPayload::deserialize(json_decode($serialized, true)));
    }
}
