<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Commit\Verification\VerificationPayload;
use DevboardLib\GitHub\Commit\Verification\VerificationReason;
use DevboardLib\GitHub\Commit\Verification\VerificationSignature;
use DevboardLib\GitHub\Commit\Verification\VerificationVerified;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitSigner;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitVerification;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @covers \DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitVerification
 * @group  unit
 */
class CommitVerificationTest extends TestCase
{
    /** @var VerificationVerified */
    private $verified;

    /** @var VerificationReason */
    private $reason;

    /** @var VerificationSignature|null */
    private $signature;

    /** @var VerificationPayload|null */
    private $payload;

    /** @var EmailAddress */
    private $email;

    /** @var CommitSigner|null */
    private $signer;

    /** @var bool */
    private $wasSignedByGitHub;

    /** @var CommitVerification */
    private $sut;

    public function setUp(): void
    {
        $this->verified  = new VerificationVerified(true);
        $this->reason    = new VerificationReason('reason');
        $this->signature = new VerificationSignature('signature');
        $this->payload   = new VerificationPayload('payload');
        $this->email     = new EmailAddress('someone@example.com');
        $this->signer    = new CommitSigner(
            new AccountId(1),
            new AccountLogin('value'),
            'name',
            AccountType::USER(),
            new AccountAvatarUrl('avatarUrl'),
            true
        );
        $this->wasSignedByGitHub = false;
        $this->sut               = new CommitVerification(
            $this->verified,
            $this->reason,
            $this->signature,
            $this->payload,
            $this->email,
            $this->signer,
            $this->wasSignedByGitHub
        );
    }

    public function testGetVerified(): void
    {
        self::assertSame($this->verified, $this->sut->getVerified());
    }

    public function testGetReason(): void
    {
        self::assertSame($this->reason, $this->sut->getReason());
    }

    public function testGetSignature(): void
    {
        self::assertSame($this->signature, $this->sut->getSignature());
    }

    public function testGetPayload(): void
    {
        self::assertSame($this->payload, $this->sut->getPayload());
    }

    public function testGetEmail(): void
    {
        self::assertSame($this->email, $this->sut->getEmail());
    }

    public function testGetSigner(): void
    {
        self::assertSame($this->signer, $this->sut->getSigner());
    }

    public function testIsWasSignedByGitHub(): void
    {
        self::assertSame($this->wasSignedByGitHub, $this->sut->isWasSignedByGitHub());
    }

    public function testHasSignature(): void
    {
        self::assertTrue($this->sut->hasSignature());
    }

    public function testHasPayload(): void
    {
        self::assertTrue($this->sut->hasPayload());
    }

    public function testHasSigner(): void
    {
        self::assertTrue($this->sut->hasSigner());
    }

    public function testSerialize(): void
    {
        $expected = [
            'verified'  => true,
            'reason'    => 'reason',
            'signature' => 'signature',
            'payload'   => 'payload',
            'email'     => 'someone@example.com',
            'signer'    => [
                'userId'    => 1,
                'login'     => 'value',
                'name'      => 'name',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ],
            'wasSignedByGitHub' => false,
        ];

        self::assertSame($expected, $this->sut->serialize());
    }

    public function testDeserialize(): void
    {
        $serialized = json_encode($this->sut->serialize());
        self::assertEquals($this->sut, CommitVerification::deserialize(json_decode($serialized, true)));
    }
}
