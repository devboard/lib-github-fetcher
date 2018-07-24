<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload;

use DateTime;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\CircleCi;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHub\StatusCheck\StatusCheckContext;
use DevboardLib\GitHub\StatusCheck\StatusCheckCreator;
use DevboardLib\GitHub\StatusCheck\StatusCheckDescription;
use DevboardLib\GitHub\StatusCheck\StatusCheckId;
use DevboardLib\GitHub\StatusCheck\StatusCheckState;
use DevboardLib\GitHub\StatusCheck\StatusCheckTargetUrl;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusPayload;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\StatusCheck;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\StatusChecks;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\PullRequestStatusPayload
 * @group  unit
 */
class PullRequestStatusPayloadTest extends TestCase
{
    /** @var PullRequestNumber */
    private $number;

    /** @var CommitSha */
    private $sha;

    /** @var StatusCheckState */
    private $status;

    /** @var StatusChecks */
    private $statusChecks;

    /** @var PullRequestStatusPayload */
    private $sut;

    public function setUp(): void
    {
        $this->number       = new PullRequestNumber(13);
        $this->sha          = new CommitSha('99e0be5323d5e95d6021aa1b28684c600c878528');
        $this->status       = StatusCheckState::Pending();
        $this->statusChecks = new StatusChecks(
            [
                new StatusCheck(
                    new StatusCheckId(1),
                    StatusCheckState::Pending(),
                    new StatusCheckDescription('value'),
                    new StatusCheckTargetUrl('targetUrl'),
                    new StatusCheckContext('ci/circleci'),
                    new CircleCi(new StatusCheckContext('ci/circleci')),
                    new StatusCheckCreator(
                        new AccountId(1),
                        new AccountLogin('value'),
                        AccountType::USER(),
                        new AccountAvatarUrl('avatarUrl'),
                        true
                    ),
                    new DateTime('2018-01-01T00:01:00+00:00')
                ),
            ]
        );
        $this->sut = new PullRequestStatusPayload($this->number, $this->sha, $this->status, $this->statusChecks);
    }

    public function testGetNumber(): void
    {
        self::assertSame($this->number, $this->sut->getNumber());
    }

    public function testGetSha(): void
    {
        self::assertSame($this->sha, $this->sut->getSha());
    }

    public function testGetStatus(): void
    {
        self::assertSame($this->status, $this->sut->getStatus());
    }

    public function testGetStatusChecks(): void
    {
        self::assertSame($this->statusChecks, $this->sut->getStatusChecks());
    }

    public function testSerialize(): void
    {
        $expected = [
            'number'       => 13,
            'sha'          => '99e0be5323d5e95d6021aa1b28684c600c878528',
            'status'       => 'pending',
            'statusChecks' => [
                [
                    'id'              => 1,
                    'state'           => 'pending',
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
                ],
            ],
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, PullRequestStatusPayload::deserialize(json_decode($serialized, true)));
    }
}
