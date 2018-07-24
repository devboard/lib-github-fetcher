<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload;

use DateTime;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\External\ExternalService;
use DevboardLib\GitHub\StatusCheck\StatusCheckContext;
use DevboardLib\GitHub\StatusCheck\StatusCheckCreator;
use DevboardLib\GitHub\StatusCheck\StatusCheckDescription;
use DevboardLib\GitHub\StatusCheck\StatusCheckId;
use DevboardLib\GitHub\StatusCheck\StatusCheckState;
use DevboardLib\GitHub\StatusCheck\StatusCheckTargetUrl;
use DevboardLib\GitHubFetcher\Result\RepositoryPullRequestStatuses\Payload\StatusCheck;
use PhpSpec\ObjectBehavior;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class StatusCheckSpec extends ObjectBehavior
{
    public function let(
        StatusCheckId $id,
        StatusCheckState $state,
        StatusCheckDescription $description,
        StatusCheckTargetUrl $targetUrl,
        StatusCheckContext $context,
        ExternalService $externalService,
        StatusCheckCreator $creator,
        DateTime $createdAt
    ) {
        $this->beConstructedWith(
            $id, $state, $description, $targetUrl, $context, $externalService, $creator, $createdAt
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(StatusCheck::class);
    }

    public function it_exposes_id(StatusCheckId $id)
    {
        $this->getId()->shouldReturn($id);
    }

    public function it_exposes_state(StatusCheckState $state)
    {
        $this->getState()->shouldReturn($state);
    }

    public function it_exposes_description(StatusCheckDescription $description)
    {
        $this->getDescription()->shouldReturn($description);
    }

    public function it_exposes_target_url(StatusCheckTargetUrl $targetUrl)
    {
        $this->getTargetUrl()->shouldReturn($targetUrl);
    }

    public function it_exposes_context(StatusCheckContext $context)
    {
        $this->getContext()->shouldReturn($context);
    }

    public function it_exposes_external_service(ExternalService $externalService)
    {
        $this->getExternalService()->shouldReturn($externalService);
    }

    public function it_exposes_creator(StatusCheckCreator $creator)
    {
        $this->getCreator()->shouldReturn($creator);
    }

    public function it_exposes_created_at(DateTime $createdAt)
    {
        $this->getCreatedAt()->shouldReturn($createdAt);
    }

    public function it_has_creator()
    {
        $this->hasCreator()->shouldReturn(true);
    }

    public function it_can_be_serialized(
        StatusCheckId $id,
        StatusCheckState $state,
        StatusCheckDescription $description,
        StatusCheckTargetUrl $targetUrl,
        StatusCheckContext $context,
        ExternalService $externalService,
        StatusCheckCreator $creator,
        DateTime $createdAt
    ) {
        $id->serialize()->shouldBeCalled()->willReturn(123455567);
        $state->serialize()->shouldBeCalled()->willReturn('success');
        $description->serialize()->shouldBeCalled()->willReturn('value');
        $targetUrl->serialize()->shouldBeCalled()->willReturn('targetUrl');
        $context->serialize()->shouldBeCalled()->willReturn('ci/circleci');
        $externalService->serialize()->shouldBeCalled()->willReturn(
            [
                'context'   => 'ci/circleci',
                'className' => 'DevboardLib\GitHub\External\Service\ContinuousIntegration\CircleCi',
            ]
        );
        $creator->serialize()->shouldBeCalled()->willReturn(
            [
                'userId'    => 1,
                'login'     => 'value',
                'type'      => AccountType::USER,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ]
        );
        $createdAt->format('c')->shouldBeCalled()->willReturn('2018-01-01T00:01:00+00:00');
        $this->serialize()->shouldReturn(
            [
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
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
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

        $this->deserialize($input)->shouldReturnAnInstanceOf(StatusCheck::class);
    }
}
