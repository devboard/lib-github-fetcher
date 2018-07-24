<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignee;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignees;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestAssignees
 * @group  unit
 */
class PullRequestAssigneesTest extends TestCase
{
    /** @var array */
    private $elements = [];

    /** @var PullRequestAssignees */
    private $sut;

    public function setUp(): void
    {
        $this->elements = [
            new PullRequestAssignee(
                new AccountId(1),
                new AccountLogin('value'),
                AccountType::USER(),
                new AccountAvatarUrl('avatarUrl'),
                true
            ),
        ];
        $this->sut = new PullRequestAssignees($this->elements);
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
