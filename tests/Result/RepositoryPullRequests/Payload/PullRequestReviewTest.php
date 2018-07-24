<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewBody;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewId;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewState;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewSubmittedAt;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReview;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewAuthor;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReview
 * @group  unit
 */
class PullRequestReviewTest extends TestCase
{
    /** @var PullRequestReviewId */
    private $id;

    /** @var PullRequestReviewBody */
    private $body;

    /** @var PullRequestReviewAuthor */
    private $author;

    /** @var PullRequestReviewState */
    private $state;

    /** @var CommitSha */
    private $commitSha;

    /** @var PullRequestReviewSubmittedAt|null */
    private $submittedAt;

    /** @var PullRequestReview */
    private $sut;

    public function setUp(): void
    {
        $this->id     = new PullRequestReviewId(1);
        $this->body   = new PullRequestReviewBody('value');
        $this->author = new PullRequestReviewAuthor(
            new AccountId(1),
            new AccountLogin('value'),
            'name',
            AccountType::USER(),
            new AccountAvatarUrl('avatarUrl'),
            true
        );
        $this->state       = PullRequestReviewState::APPROVED();
        $this->commitSha   = new CommitSha('sha');
        $this->submittedAt = new PullRequestReviewSubmittedAt('2018-01-01T00:01:00+00:00');
        $this->sut         = new PullRequestReview(
            $this->id, $this->body, $this->author, $this->state, $this->commitSha, $this->submittedAt
        );
    }

    public function testGetId(): void
    {
        self::assertSame($this->id, $this->sut->getId());
    }

    public function testGetBody(): void
    {
        self::assertSame($this->body, $this->sut->getBody());
    }

    public function testGetAuthor(): void
    {
        self::assertSame($this->author, $this->sut->getAuthor());
    }

    public function testGetState(): void
    {
        self::assertSame($this->state, $this->sut->getState());
    }

    public function testGetCommitSha(): void
    {
        self::assertSame($this->commitSha, $this->sut->getCommitSha());
    }

    public function testGetSubmittedAt(): void
    {
        self::assertSame($this->submittedAt, $this->sut->getSubmittedAt());
    }

    public function testHasSubmittedAt(): void
    {
        self::assertTrue($this->sut->hasSubmittedAt());
    }

    public function testSerialize(): void
    {
        $expected = [
            'id'     => 1,
            'body'   => 'value',
            'author' => [
                'userId'    => 1,
                'login'     => 'value',
                'name'      => 'name',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ],
            'state'       => PullRequestReviewState::APPROVED,
            'commitSha'   => 'sha',
            'submittedAt' => '2018-01-01T00:01:00+00:00',
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, PullRequestReview::deserialize(json_decode($serialized, true)));
    }
}
