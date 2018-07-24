<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
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
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitAuthor;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitCommitter;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitDetails;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitSigner;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitVerification;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitDetails
 * @group  unit
 */
class CommitDetailsTest extends TestCase
{
    /** @var CommitSha */
    private $sha;

    /** @var CommitMessage */
    private $message;

    /** @var CommitDate */
    private $commitDate;

    /** @var CommitAuthor */
    private $author;

    /** @var CommitCommitter */
    private $committer;

    /** @var CommitTree */
    private $tree;

    /** @var CommitParentCollection */
    private $parents;

    /** @var CommitVerification|null */
    private $verification;

    /** @var CommitDetails */
    private $sut;

    public function setUp(): void
    {
        $this->sha        = new CommitSha('sha');
        $this->message    = new CommitMessage('message');
        $this->commitDate = new CommitDate('2018-01-01T00:01:00+00:00');
        $this->author     = new BasicCommitAuthorDetails(
            new AuthorName('Jane Johnson'),
            new EmailAddress('jane@example.com'),
            new CommitDate('2018-01-02T20:21:22+00:00')
        );
        $this->committer = new BasicCommitCommitterDetails(
            new CommitterName('Jane Johnson'),
            new EmailAddress('jane@example.com'),
            new CommitDate('2018-01-02T20:21:22+00:00')
        );
        $this->tree         = new CommitTree(new CommitSha('sha'));
        $this->parents      = new CommitParentCollection([new CommitParent(new CommitSha('sha'))]);
        $this->verification = new CommitVerification(
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
        );
        $this->sut = new CommitDetails(
            $this->sha,
            $this->message,
            $this->commitDate,
            $this->author,
            $this->committer,
            $this->tree,
            $this->parents,
            $this->verification
        );
    }

    public function testGetSha(): void
    {
        self::assertSame($this->sha, $this->sut->getSha());
    }

    public function testGetMessage(): void
    {
        self::assertSame($this->message, $this->sut->getMessage());
    }

    public function testGetCommitDate(): void
    {
        self::assertSame($this->commitDate, $this->sut->getCommitDate());
    }

    public function testGetAuthor(): void
    {
        self::assertSame($this->author, $this->sut->getAuthor());
    }

    public function testGetCommitter(): void
    {
        self::assertSame($this->committer, $this->sut->getCommitter());
    }

    public function testGetTree(): void
    {
        self::assertSame($this->tree, $this->sut->getTree());
    }

    public function testGetParents(): void
    {
        self::assertSame($this->parents, $this->sut->getParents());
    }

    public function testGetVerification(): void
    {
        self::assertSame($this->verification, $this->sut->getVerification());
    }

    public function testHasVerification(): void
    {
        self::assertTrue($this->sut->hasVerification());
    }

    public function testSerialize(): void
    {
        $expected = [
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

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, CommitDetails::deserialize(json_decode($serialized, true)));
    }
}
