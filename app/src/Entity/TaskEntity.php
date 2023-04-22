<?php
namespace App\Entity;

class TaskEntity
{
  public string $id;
  public string $uid;
  public string $title;
  public int $status;
  public string $createdAt;
  public string $updatedAt;

  public function toJson(): object
  {
    return json_decode((string) json_encode(get_object_vars($this)), false);
  }
}