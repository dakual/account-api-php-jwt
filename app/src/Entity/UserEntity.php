<?php
namespace App\Entity;

class UserEntity
{
    private int $id;
    private string $email;
    private string $password;

    public function toJson(): object
    {
      return json_decode((string) json_encode(get_object_vars($this)), false);
    }

    public function getId(): int
    {
      return $this->id;
    }

    public function getEmail(): string
    {
      return $this->email;
    }

    public function updateEmail(string $email): self
    {
      $this->email = $email;

      return $this;
    }

    public function getPassword(): string
    {
      return $this->password;
    }

    public function updatePassword(string $password): self
    {
      $this->password = $password;

      return $this;
    }
}