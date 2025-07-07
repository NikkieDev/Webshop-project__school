<?php

declare(strict_types=1);

require_once "BaseRepository.php";

final class ContactRepository extends BaseRepository
{
    public function create(string $email, string $content)
    {
        $stmt = $this->getConnection()->prepare('
            INSERT INTO ContactRequest (uuid, email, body) VALUES (UUID(), :email, :content)
        ');

        $stmt->execute([':email' => $email, ':content' => $content]);
        return;
    }
}