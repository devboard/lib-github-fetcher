<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\UserInstallations;

use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Application\ApplicationId;
use DevboardLib\GitHub\Installation\InstallationAccessTokenUrl;
use DevboardLib\GitHub\Installation\InstallationAccount;
use DevboardLib\GitHub\Installation\InstallationCreatedAt;
use DevboardLib\GitHub\Installation\InstallationEvents;
use DevboardLib\GitHub\Installation\InstallationHtmlUrl;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Installation\InstallationPermissions;
use DevboardLib\GitHub\Installation\InstallationRepositoriesUrl;
use DevboardLib\GitHub\Installation\InstallationRepositorySelection;
use DevboardLib\GitHub\Installation\InstallationUpdatedAt;
use DevboardLib\GitHubFetcher\Result\UserInstallations\GitHubInstallationResult;
use PhpSpec\ObjectBehavior;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class GitHubInstallationResultSpec extends ObjectBehavior
{
    public function let(
        InstallationId $installationId,
        InstallationAccount $installationAccount,
        ApplicationId $applicationId,
        InstallationRepositorySelection $repositorySelection,
        InstallationPermissions $permissions,
        InstallationEvents $events,
        InstallationAccessTokenUrl $accessTokenUrl,
        InstallationRepositoriesUrl $repositoriesUrl,
        InstallationHtmlUrl $htmlUrl,
        InstallationCreatedAt $createdAt,
        InstallationUpdatedAt $updatedAt
    ) {
        $this->beConstructedWith(
            $installationId,
            $installationAccount,
            $applicationId,
            $repositorySelection,
            $permissions,
            $events,
            $accessTokenUrl,
            $repositoriesUrl,
            $htmlUrl,
            $createdAt,
            $updatedAt
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(GitHubInstallationResult::class);
    }

    public function it_exposes_installation_id(InstallationId $installationId)
    {
        $this->getInstallationId()->shouldReturn($installationId);
    }

    public function it_exposes_installation_account(InstallationAccount $installationAccount)
    {
        $this->getInstallationAccount()->shouldReturn($installationAccount);
    }

    public function it_exposes_application_id(ApplicationId $applicationId)
    {
        $this->getApplicationId()->shouldReturn($applicationId);
    }

    public function it_exposes_repository_selection(InstallationRepositorySelection $repositorySelection)
    {
        $this->getRepositorySelection()->shouldReturn($repositorySelection);
    }

    public function it_exposes_permissions(InstallationPermissions $permissions)
    {
        $this->getPermissions()->shouldReturn($permissions);
    }

    public function it_exposes_events(InstallationEvents $events)
    {
        $this->getEvents()->shouldReturn($events);
    }

    public function it_exposes_access_token_url(InstallationAccessTokenUrl $accessTokenUrl)
    {
        $this->getAccessTokenUrl()->shouldReturn($accessTokenUrl);
    }

    public function it_exposes_repositories_url(InstallationRepositoriesUrl $repositoriesUrl)
    {
        $this->getRepositoriesUrl()->shouldReturn($repositoriesUrl);
    }

    public function it_exposes_html_url(InstallationHtmlUrl $htmlUrl)
    {
        $this->getHtmlUrl()->shouldReturn($htmlUrl);
    }

    public function it_exposes_created_at(InstallationCreatedAt $createdAt)
    {
        $this->getCreatedAt()->shouldReturn($createdAt);
    }

    public function it_exposes_updated_at(InstallationUpdatedAt $updatedAt)
    {
        $this->getUpdatedAt()->shouldReturn($updatedAt);
    }

    public function it_can_be_serialized(
        InstallationId $installationId,
        InstallationAccount $installationAccount,
        ApplicationId $applicationId,
        InstallationRepositorySelection $repositorySelection,
        InstallationPermissions $permissions,
        InstallationEvents $events,
        InstallationAccessTokenUrl $accessTokenUrl,
        InstallationRepositoriesUrl $repositoriesUrl,
        InstallationHtmlUrl $htmlUrl,
        InstallationCreatedAt $createdAt,
        InstallationUpdatedAt $updatedAt
    ) {
        $installationId->serialize()->shouldBeCalled()->willReturn(1);
        $installationAccount->serialize()->shouldBeCalled()->willReturn(
            [
                'userId'    => 1,
                'login'     => 'value',
                'type'      => AccountType::ORGANIZATION,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ]
        );
        $applicationId->serialize()->shouldBeCalled()->willReturn(1);
        $repositorySelection->serialize()->shouldBeCalled()->willReturn(
            InstallationRepositorySelection\InstallationRepositoryAll::NAME
        );
        $permissions->serialize()->shouldBeCalled()->willReturn(['data']);
        $events->serialize()->shouldBeCalled()->willReturn(['data']);
        $accessTokenUrl->serialize()->shouldBeCalled()->willReturn('accessTokenUrl');
        $repositoriesUrl->serialize()->shouldBeCalled()->willReturn('installationRepositoriesUrl');
        $htmlUrl->serialize()->shouldBeCalled()->willReturn('installationHtmlUrl');
        $createdAt->serialize()->shouldBeCalled()->willReturn('2018-01-01T00:01:00+00:00');
        $updatedAt->serialize()->shouldBeCalled()->willReturn('2018-01-01T00:01:00+00:00');
        $this->serialize()->shouldReturn(
            [
                'installationId'      => 1,
                'installationAccount' => [
                    'userId'    => 1,
                    'login'     => 'value',
                    'type'      => AccountType::ORGANIZATION,
                    'avatarUrl' => 'avatarUrl',
                    'siteAdmin' => true,
                ],
                'applicationId'       => 1,
                'repositorySelection' => InstallationRepositorySelection\InstallationRepositoryAll::NAME,
                'permissions'         => ['data'],
                'events'              => ['data'],
                'accessTokenUrl'      => 'accessTokenUrl',
                'repositoriesUrl'     => 'installationRepositoriesUrl',
                'htmlUrl'             => 'installationHtmlUrl',
                'createdAt'           => '2018-01-01T00:01:00+00:00',
                'updatedAt'           => '2018-01-01T00:01:00+00:00',
            ]
        );
    }

    public function it_can_be_deserialized()
    {
        $input = [
            'installationId'      => 1,
            'installationAccount' => [
                'userId'    => 1,
                'login'     => 'value',
                'type'      => AccountType::ORGANIZATION,
                'avatarUrl' => 'avatarUrl',
                'siteAdmin' => true,
            ],
            'applicationId'       => 1,
            'repositorySelection' => InstallationRepositorySelection\InstallationRepositoryAll::NAME,
            'permissions'         => ['data'],
            'events'              => ['data'],
            'accessTokenUrl'      => 'accessTokenUrl',
            'repositoriesUrl'     => 'installationRepositoriesUrl',
            'htmlUrl'             => 'installationHtmlUrl',
            'createdAt'           => '2018-01-01T00:01:00+00:00',
            'updatedAt'           => '2018-01-01T00:01:00+00:00',
        ];

        $this->deserialize($input)->shouldReturnAnInstanceOf(GitHubInstallationResult::class);
    }
}
