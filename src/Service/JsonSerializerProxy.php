<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonSerializerProxy
{
    private Serializer $serializer;

    public function __construct()
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $this->serializer = new Serializer([$normalizer], [$encoder]);
    }

    public function serialize(mixed $data): string
    {
        return $this->serializer->serialize($data, 'json');
    }

    public function deserialize(mixed $data, string $type): mixed
    {
        return $this->serializer->deserialize($data, $type, 'json');
    }
}