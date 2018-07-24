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
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviews;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviews
 * @group  unit
 */
class PullRequestReviewsTest extends TestCase
{
    /** @var array */
    private $elements = [];

    /** @var PullRequestReviews */
    private $sut;

    public function setUp(): void
    {
        $this->elements = [
            new PullRequestReview(
                new PullRequestReviewId(1),
                new PullRequestReviewBody('value'),
                new PullRequestReviewAuthor(
                    new AccountId(1),
                    new AccountLogin('value'),
                    'name',
                    AccountType::USER(),
                    new AccountAvatarUrl('avatarUrl'),
                    true
                ),
                PullRequestReviewState::APPROVED(),
                new CommitSha('sha'),
                new PullRequestReviewSubmittedAt('2018-01-01T00:01:00+00:00')
            ),
        ];
        $this->sut = new PullRequestReviews($this->elements);
    }

    public function testGetElements(): void
    {
        self::assertSame($this->elements, $this->sut->toArray());
    }

    public function testSerializeAndDeserialize(): void
    {
        $serialized     = $this->sut->serialize();
        $serializedJson = json_encode($serialized);
        self::assertEquals($this->sut, $this->sut::deserialize(json_decode($serializedJson, true)));
    }
}
