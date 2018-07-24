<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DateTime;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergedBy;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergeDetails;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestMergeDetails
 * @group  unit
 */
class PullRequestMergeDetailsTest extends TestCase
{
    /** @var PullRequestMergedBy */
    private $mergedBy;

    /** @var DateTime */
    private $mergedAt;

    /** @var PullRequestMergeDetails */
    private $sut;

    public function setUp(): void
    {
        $this->mergedBy = new PullRequestMergedBy(
            new AccountId(1),
            new AccountLogin('value'),
            'name',
            AccountType::USER(),
            new AccountAvatarUrl('avatarUrl'),
            true
        );
        $this->mergedAt = new DateTime('2018-01-01T00:01:00+00:00');
        $this->sut      = new PullRequestMergeDetails($this->mergedBy, $this->mergedAt);
    }

    public function testGetMergedBy(): void
    {
        self::assertSame($this->mergedBy, $this->sut->getMergedBy());
    }

    public function testGetMergedAt(): void
    {
        self::assertSame($this->mergedAt, $this->sut->getMergedAt());
    }

    public function testSerialize(): void
    {
        $expected = [
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

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, PullRequestMergeDetails::deserialize(json_decode($serialized, true)));
    }
}
