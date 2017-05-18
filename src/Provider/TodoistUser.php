<?php
namespace Wisembly\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class TodoistUser implements ResourceOwnerInterface
{
    private $id;
    private $email;
    private $fullName;
    private $avatarSmall;

    public function __construct(array $response)
    {
        $this->id = $response['id'];
        $this->email = $response['email'];
        $this->fullName = $response['full_name'];
        $this->avatarSmall = $response['avatar_small'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getAvatarSmall()
    {
        return $this->avatarSmall;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->fullName,
            'avatarSmall' => $this->avatarSmall,
        ];
    }
}