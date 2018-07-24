<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload;

use DateTime;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\External\ExternalService;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\CircleCi;
use DevboardLib\GitHub\StatusCheck\StatusCheckContext;
use DevboardLib\GitHub\StatusCheck\StatusCheckCreator;
use DevboardLib\GitHub\StatusCheck\StatusCheckDescription;
use DevboardLib\GitHub\StatusCheck\StatusCheckId;
use DevboardLib\GitHub\StatusCheck\StatusCheckState;
use DevboardLib\GitHub\StatusCheck\StatusCheckTargetUrl;
use DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusCheck;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusCheck
 * @group  unit
 */
class StatusCheckTest extends TestCase
{
    /** @var StatusCheckId */
    private $id;

    /** @var StatusCheckState */
    private $state;

    /** @var StatusCheckDescription */
    private $description;

    /** @var StatusCheckTargetUrl */
    private $targetUrl;

    /** @var StatusCheckContext */
    private $context;

    /** @var ExternalService */
    private $externalService;

    /** @var StatusCheckCreator|null */
    private $creator;

    /** @var DateTime */
    private $createdAt;

    /** @var StatusCheck */
    private $sut;

    public function setUp(): void
    {
        $this->id              = new StatusCheckId(123455567);
        $this->state           = StatusCheckState::Success();
        $this->description     = new StatusCheckDescription('value');
        $this->targetUrl       = new StatusCheckTargetUrl('targetUrl');
        $this->context         = new StatusCheckContext('ci/circleci');
        $this->externalService = new CircleCi(new StatusCheckContext('ci/circleci'));
        $this->creator         = new StatusCheckCreator(
            new AccountId(1),
            new AccountLogin('value'),
            AccountType::USER(),
            new AccountAvatarUrl('avatarUrl'),
            true
        );
        $this->createdAt = new DateTime('2018-01-01T00:01:00+00:00');
        $this->sut       = new StatusCheck(
            $this->id,
            $this->state,
            $this->description,
            $this->targetUrl,
            $this->context,
            $this->externalService,
            $this->creator,
            $this->createdAt
        );
    }

    public function testGetId(): void
    {
        self::assertSame($this->id, $this->sut->getId());
    }

    public function testGetState(): void
    {
        self::assertSame($this->state, $this->sut->getState());
    }

    public function testGetDescription(): void
    {
        self::assertSame($this->description, $this->sut->getDescription());
    }

    public function testGetTargetUrl(): void
    {
        self::assertSame($this->targetUrl, $this->sut->getTargetUrl());
    }

    public function testGetContext(): void
    {
        self::assertSame($this->context, $this->sut->getContext());
    }

    public function testGetExternalService(): void
    {
        self::assertSame($this->externalService, $this->sut->getExternalService());
    }

    public function testGetCreator(): void
    {
        self::assertSame($this->creator, $this->sut->getCreator());
    }

    public function testGetCreatedAt(): void
    {
        self::assertSame($this->createdAt, $this->sut->getCreatedAt());
    }

    public function testHasCreator(): void
    {
        self::assertTrue($this->sut->hasCreator());
    }

    public function testSerialize(): void
    {
        $expected = [
            'id'              => 123455567,
            'state'           => 'success',
            'description'     => 'value',
            'targetUrl'       => 'targetUrl',
            'context'         => 'ci/circleci',
            'externalService' => [
                'context'   => 'ci/circleci',
                'className' => 'DevboardLib\GitHub\External\Service\ContinuousIntegration\CircleCi',
            ],
            'creator' => [
                'userId'    => 1,
                'login'     => 'value',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ],
            'createdAt' => '2018-01-01T00:01:00+00:00',
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, StatusCheck::deserialize(json_decode($serialized, true)));
    }
}
