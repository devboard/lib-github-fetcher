<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestRequestedReviewer;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequest;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequests;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequests
 * @group  unit
 */
class PullRequestReviewRequestsTest extends TestCase
{
    /** @var array */
    private $elements = [];

    /** @var PullRequestReviewRequests */
    private $sut;

    public function setUp(): void
    {
        $this->elements = [
            new PullRequestReviewRequest(
                1,
                new PullRequestRequestedReviewer(
                    new AccountId(1),
                    new AccountLogin('value'),
                    'name',
                    AccountType::USER(),
                    new AccountAvatarUrl('avatarUrl'),
                    true
                )
            ),
        ];
        $this->sut = new PullRequestReviewRequests($this->elements);
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
