<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload;

use DevboardLib\GitHubFetcher\Result\InstallationRepositories\Payload\UserGitHubRepositoryPermissions;
use PhpSpec\ObjectBehavior;

class UserGitHubRepositoryPermissionsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($admin = true, $pushAllowed = true, $pullAllowed = true);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserGitHubRepositoryPermissions::class);
    }

    public function it_exposes_is_admin()
    {
        $this->isAdmin()->shouldReturn(true);
    }

    public function it_exposes_is_push_allowed()
    {
        $this->isPushAllowed()->shouldReturn(true);
    }

    public function it_exposes_is_pull_allowed()
    {
        $this->isPullAllowed()->shouldReturn(true);
    }

    public function it_can_be_serialized()
    {
        $this->serialize()->shouldReturn(['admin' => true, 'pushAllowed' => true, 'pullAllowed' => true]);
    }

    public function it_can_be_deserialized()
    {
        $input = ['admin' => true, 'pushAllowed' => true, 'pullAllowed' => true];

        $this->deserialize($input)->shouldReturnAnInstanceOf(UserGitHubRepositoryPermissions::class);
    }
}
