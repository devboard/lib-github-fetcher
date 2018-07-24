<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\GitHub\Commit\Verification\VerificationPayload;
use DevboardLib\GitHub\Commit\Verification\VerificationReason;
use DevboardLib\GitHub\Commit\Verification\VerificationSignature;
use DevboardLib\GitHub\Commit\Verification\VerificationVerified;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitVerificationSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitVerificationTest
 */
class CommitVerification
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

    public function __construct(
        VerificationVerified $verified,
        VerificationReason $reason,
        ?VerificationSignature $signature,
        ?VerificationPayload $payload,
        EmailAddress $email,
        ?CommitSigner $signer,
        bool $wasSignedByGitHub
    ) {
        $this->verified          = $verified;
        $this->reason            = $reason;
        $this->signature         = $signature;
        $this->payload           = $payload;
        $this->email             = $email;
        $this->signer            = $signer;
        $this->wasSignedByGitHub = $wasSignedByGitHub;
    }

    public function getVerified(): VerificationVerified
    {
        return $this->verified;
    }

    public function getReason(): VerificationReason
    {
        return $this->reason;
    }

    public function getSignature(): ?VerificationSignature
    {
        return $this->signature;
    }

    public function getPayload(): ?VerificationPayload
    {
        return $this->payload;
    }

    public function getEmail(): EmailAddress
    {
        return $this->email;
    }

    public function getSigner(): ?CommitSigner
    {
        return $this->signer;
    }

    public function isWasSignedByGitHub(): bool
    {
        return $this->wasSignedByGitHub;
    }

    public function hasSignature(): bool
    {
        if (null === $this->signature) {
            return false;
        }

        return true;
    }

    public function hasPayload(): bool
    {
        if (null === $this->payload) {
            return false;
        }

        return true;
    }

    public function hasSigner(): bool
    {
        if (null === $this->signer) {
            return false;
        }

        return true;
    }

    public function serialize(): array
    {
        if (null === $this->signature) {
            $signature = null;
        } else {
            $signature = $this->signature->serialize();
        }

        if (null === $this->payload) {
            $payload = null;
        } else {
            $payload = $this->payload->serialize();
        }

        if (null === $this->signer) {
            $signer = null;
        } else {
            $signer = $this->signer->serialize();
        }

        return [
            'verified'          => $this->verified->serialize(),
            'reason'            => $this->reason->serialize(),
            'signature'         => $signature,
            'payload'           => $payload,
            'email'             => $this->email->serialize(),
            'signer'            => $signer,
            'wasSignedByGitHub' => $this->wasSignedByGitHub,
        ];
    }

    public static function deserialize(array $data): self
    {
        if (null === $data['signature']) {
            $signature = null;
        } else {
            $signature = VerificationSignature::deserialize($data['signature']);
        }

        if (null === $data['payload']) {
            $payload = null;
        } else {
            $payload = VerificationPayload::deserialize($data['payload']);
        }

        if (null === $data['signer']) {
            $signer = null;
        } else {
            $signer = CommitSigner::deserialize($data['signer']);
        }

        return new self(
            VerificationVerified::deserialize($data['verified']),
            VerificationReason::deserialize($data['reason']),
            $signature,
            $payload,
            EmailAddress::deserialize($data['email']),
            $signer,
            $data['wasSignedByGitHub']
        );
    }
}
