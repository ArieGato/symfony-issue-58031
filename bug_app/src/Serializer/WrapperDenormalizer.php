<?php

namespace App\Serializer;

use App\Dto\Wrapper;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class WrapperDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    /**
     * regex to match all classes matching: Wrapper<MyDto>
     * @var string
     */
    private string $wrapperRegex;

    public function __construct()
    {
        $this->wrapperRegex = "/^" . str_replace("\\", "\\\\", Wrapper::class) . "<(.*)>$/";
    }

    /** {@inheritDoc} */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        preg_match($this->wrapperRegex, $type, $matches);

        $data['dto'] = $this->denormalizer->denormalize($data['dto'], $matches[1], $format, $context);

        return $this->denormalizer->denormalize($data, Wrapper::class, $format, $context);
    }

    /** {@inheritDoc} */
    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        $isMatch = preg_match($this->wrapperRegex, $type);

        return $isMatch > 0;
    }

    public function getSupportedTypes(?string $format = null): array
    {
        return ['object' => null, '*' => false];
    }
}
