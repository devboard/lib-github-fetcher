<?php

declare(strict_types=1);

namespace DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload;

use DevboardLib\GitHub\Label\LabelColor;
use DevboardLib\GitHub\Label\LabelId;
use DevboardLib\GitHub\Label\LabelName;

/**
 * @see \spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabelSpec
 * @see \Tests\DevboardLib\GitHubFetcher\Result\RepositoryPullRequests\Payload\PullRequestLabelTest
 */
class PullRequestLabel
{
    /** @var LabelId */
    private $id;

    /** @var LabelName */
    private $name;

    /** @var LabelColor */
    private $color;

    /** @var bool */
    private $default;

    public function __construct(LabelId $id, LabelName $name, LabelColor $color, bool $default)
    {
        $this->id      = $id;
        $this->name    = $name;
        $this->color   = $color;
        $this->default = $default;
    }

    public function getId(): LabelId
    {
        return $this->id;
    }

    public function getName(): LabelName
    {
        return $this->name;
    }

    public function getColor(): LabelColor
    {
        return $this->color;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }

    public function serialize(): array
    {
        return [
            'id'      => $this->id->serialize(),
            'name'    => $this->name->serialize(),
            'color'   => $this->color->serialize(),
            'default' => $this->default,
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            LabelId::deserialize($data['id']),
            LabelName::deserialize($data['name']),
            LabelColor::deserialize($data['color']),
            $data['default']
        );
    }
}
