<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload;

use DateTime;
use DevboardLib\GitHub\External\ExternalService;
use DevboardLib\GitHub\StatusCheck\StatusCheckContext;
use DevboardLib\GitHub\StatusCheck\StatusCheckCreator;
use DevboardLib\GitHub\StatusCheck\StatusCheckDescription;
use DevboardLib\GitHub\StatusCheck\StatusCheckId;
use DevboardLib\GitHub\StatusCheck\StatusCheckState;
use DevboardLib\GitHub\StatusCheck\StatusCheckTargetUrl;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusCheckSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryBranchStatuses\Payload\StatusCheckTest
 */
class StatusCheck
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

    public function __construct(
        StatusCheckId $id,
        StatusCheckState $state,
        StatusCheckDescription $description,
        StatusCheckTargetUrl $targetUrl,
        StatusCheckContext $context,
        ExternalService $externalService,
        ?StatusCheckCreator $creator,
        DateTime $createdAt
    ) {
        $this->id              = $id;
        $this->state           = $state;
        $this->description     = $description;
        $this->targetUrl       = $targetUrl;
        $this->context         = $context;
        $this->externalService = $externalService;
        $this->creator         = $creator;
        $this->createdAt       = $createdAt;
    }

    public function getId(): StatusCheckId
    {
        return $this->id;
    }

    public function getState(): StatusCheckState
    {
        return $this->state;
    }

    public function getDescription(): StatusCheckDescription
    {
        return $this->description;
    }

    public function getTargetUrl(): StatusCheckTargetUrl
    {
        return $this->targetUrl;
    }

    public function getContext(): StatusCheckContext
    {
        return $this->context;
    }

    public function getExternalService(): ExternalService
    {
        return $this->externalService;
    }

    public function getCreator(): ?StatusCheckCreator
    {
        return $this->creator;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function hasCreator(): bool
    {
        if (null === $this->creator) {
            return false;
        }

        return true;
    }

    public function serialize(): array
    {
        if (null === $this->creator) {
            $creator = null;
        } else {
            $creator = $this->creator->serialize();
        }

        return [
            'id'              => $this->id->serialize(),
            'state'           => $this->state->serialize(),
            'description'     => $this->description->serialize(),
            'targetUrl'       => $this->targetUrl->serialize(),
            'context'         => $this->context->serialize(),
            'externalService' => $this->externalService->serialize(),
            'creator'         => $creator,
            'createdAt'       => $this->createdAt->format('c'),
        ];
    }

    public static function deserialize(array $data): self
    {
        if (null === $data['creator']) {
            $creator = null;
        } else {
            $creator = StatusCheckCreator::deserialize($data['creator']);
        }

        return new self(
            StatusCheckId::deserialize($data['id']),
            StatusCheckState::deserialize($data['state']),
            StatusCheckDescription::deserialize($data['description']),
            StatusCheckTargetUrl::deserialize($data['targetUrl']),
            StatusCheckContext::deserialize($data['context']),
            ExternalService::deserialize($data['externalService']),
            $creator,
            new DateTime($data['createdAt'])
        );
    }
}
