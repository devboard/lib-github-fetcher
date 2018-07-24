<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload;

use DateTime;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\CircleCi;
use DevboardLib\GitHub\StatusCheck\StatusCheckContext;
use DevboardLib\GitHub\StatusCheck\StatusCheckCreator;
use DevboardLib\GitHub\StatusCheck\StatusCheckDescription;
use DevboardLib\GitHub\StatusCheck\StatusCheckId;
use DevboardLib\GitHub\StatusCheck\StatusCheckState;
use DevboardLib\GitHub\StatusCheck\StatusCheckTargetUrl;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusCheck;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusChecks;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusChecks
 * @group  unit
 */
class StatusChecksTest extends TestCase
{
    /** @var array */
    private $elements = [];

    /** @var StatusChecks */
    private $sut;

    public function setUp(): void
    {
        $this->elements = [
            new StatusCheck(
                new StatusCheckId(1),
                StatusCheckState::Pending(),
                new StatusCheckDescription('value'),
                new StatusCheckTargetUrl('targetUrl'),
                new StatusCheckContext('description'),
                new CircleCi(new StatusCheckContext('description')),
                new StatusCheckCreator(
                    new AccountId(1),
                    new AccountLogin('value'),
                    AccountType::USER(),
                    new AccountAvatarUrl('avatarUrl'),
                    true
                ),
                new DateTime('2018-01-01T00:01:00+00:00')
            ),
        ];
        $this->sut = new StatusChecks($this->elements);
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
