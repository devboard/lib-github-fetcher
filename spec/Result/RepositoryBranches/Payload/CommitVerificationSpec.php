<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Commit\Verification\VerificationPayload;
use DevboardLib\GitHub\Commit\Verification\VerificationReason;
use DevboardLib\GitHub\Commit\Verification\VerificationSignature;
use DevboardLib\GitHub\Commit\Verification\VerificationVerified;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitSigner;
use DevboardLib\GitHubFetcher\Result\RepositoryBranches\Payload\CommitVerification;
use PhpSpec\ObjectBehavior;

class CommitVerificationSpec extends ObjectBehavior
{
    public function let(
        VerificationVerified $verified,
        VerificationReason $reason,
        VerificationSignature $signature,
        VerificationPayload $payload,
        EmailAddress $email,
        CommitSigner $signer
    ) {
        $this->beConstructedWith($verified, $reason, $signature, $payload, $email, $signer, $wasSignedByGitHub = false);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CommitVerification::class);
    }

    public function it_exposes_verified(VerificationVerified $verified)
    {
        $this->getVerified()->shouldReturn($verified);
    }

    public function it_exposes_reason(VerificationReason $reason)
    {
        $this->getReason()->shouldReturn($reason);
    }

    public function it_exposes_signature(VerificationSignature $signature)
    {
        $this->getSignature()->shouldReturn($signature);
    }

    public function it_exposes_payload(VerificationPayload $payload)
    {
        $this->getPayload()->shouldReturn($payload);
    }

    public function it_exposes_email(EmailAddress $email)
    {
        $this->getEmail()->shouldReturn($email);
    }

    public function it_exposes_signer(CommitSigner $signer)
    {
        $this->getSigner()->shouldReturn($signer);
    }

    public function it_exposes_is_was_signed_by_git_hub()
    {
        $this->isWasSignedByGitHub()->shouldReturn(false);
    }

    public function it_has_signature()
    {
        $this->hasSignature()->shouldReturn(true);
    }

    public function it_has_payload()
    {
        $this->hasPayload()->shouldReturn(true);
    }

    public function it_has_signer()
    {
        $this->hasSigner()->shouldReturn(true);
    }

    public function it_can_be_serialized(
        VerificationVerified $verified,
        VerificationReason $reason,
        VerificationSignature $signature,
        VerificationPayload $payload,
        EmailAddress $email,
        CommitSigner $signer
    ) {
        $verified->serialize()->shouldBeCalled()->willReturn(true);
        $reason->serialize()->shouldBeCalled()->willReturn('reason');
        $signature->serialize()->shouldBeCalled()->willReturn('signature');
        $payload->serialize()->shouldBeCalled()->willReturn('payload');
        $email->serialize()->shouldBeCalled()->willReturn('someone@example.com');
        $signer->serialize()->shouldBeCalled()->willReturn(
            [
                'userId'    => 1,
                'login'     => 'value',
                'name'      => 'name',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ]
        );
        $this->serialize()->shouldReturn(
            [
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
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
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

        $this->deserialize($input)->shouldReturnAnInstanceOf(CommitVerification::class);
    }
}
