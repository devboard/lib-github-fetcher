<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestRequestedReviewer;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestReviewRequest
 * @group  unit
 */
class PullRequestReviewRequestTest extends TestCase
{
    /** @var int */
    private $id;

    /** @var PullRequestRequestedReviewer */
    private $requestedReviewer;

    /** @var PullRequestReviewRequest */
    private $sut;

    public function setUp(): void
    {
        $this->id                = 2343423423423;
        $this->requestedReviewer = new PullRequestRequestedReviewer(
            new AccountId(1),
            new AccountLogin('value'),
            'name',
            AccountType::USER(),
            new AccountAvatarUrl('avatarUrl'),
            true
        );
        $this->sut = new PullRequestReviewRequest($this->id, $this->requestedReviewer);
    }

    public function testGetId(): void
    {
        self::assertSame($this->id, $this->sut->getId());
    }

    public function testGetRequestedReviewer(): void
    {
        self::assertSame($this->requestedReviewer, $this->sut->getRequestedReviewer());
    }

    public function testSerialize(): void
    {
        $expected = [
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

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, PullRequestReviewRequest::deserialize(json_decode($serialized, true)));
    }
}
