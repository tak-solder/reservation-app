<?php

namespace Domain\Domains\Entities\User;

use Domain\Domains\Entities\EntityInterface;
use Illuminate\Contracts\Auth\Authenticatable;

class User implements EntityInterface, Authenticatable
{
    private int $id;
    private string $lineName;
    private string $lineId;

    public function __construct(int $id, string $lineName, string $lineId)
    {
        $this->id = $id;
        $this->lineName = $lineName;
        $this->lineId = $lineId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLineName(): string
    {
        return $this->lineName;
    }

    public function getLineId(): string
    {
        return $this->lineId;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'lineName' => $this->lineName,
            'lineId' => $this->lineId,
        ];
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getId();
    }

    public function getAuthPassword()
    {
        throw new \ErrorException("実装されていないメソッド");
    }

    public function getRememberToken()
    {
        throw new \ErrorException("実装されていないメソッド");
    }

    public function setRememberToken($value)
    {
        throw new \ErrorException("実装されていないメソッド");
    }

    public function getRememberTokenName()
    {
        throw new \ErrorException("実装されていないメソッド");
    }
}
