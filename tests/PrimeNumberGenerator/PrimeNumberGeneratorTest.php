<?php

namespace Mihailvd\PrimeMultiplicationTable\Test\PrimeNumberGenerator;

use Mihailvd\PrimeMultiplicationTable\PrimeNumberGenerator\PrimeNumberGeneratorInterface;
use Mihailvd\PrimeMultiplicationTable\PrimeNumberGenerator\PrimeNumberGenerator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PrimeNumberGenerator::class)]
final class PrimeNumberGeneratorTest extends TestCase
{
    private PrimeNumberGeneratorInterface $primeNumberGenerator;

    public static function providePrimeNumberSets(): array
    {
        return [
            'Small prime numbers (up to 500)' => [
                [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101,
                    103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199,
                    211, 223, 227, 229, 233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311, 313, 317,
                    331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397, 401, 409, 419, 421, 431, 433, 439, 443,
                    449, 457, 461, 463, 467, 479, 487, 491, 499],
                500,
                false,
            ],
            'Big prime numbers (3000-4000)' => [
                [3001, 3011, 3019, 3023, 3037, 3041, 3049, 3061, 3067, 3079, 3083, 3089, 3109, 3119, 3121, 3137, 3163,
                    3167, 3169, 3181, 3187, 3191, 3203, 3209, 3217, 3221, 3229, 3251, 3253, 3257, 3259, 3271, 3299,
                    3301, 3307, 3313, 3319, 3323, 3329, 3331, 3343, 3347, 3359, 3361, 3371, 3373, 3389, 3391, 3407,
                    3413, 3433, 3449, 3457, 3461, 3463, 3467, 3469, 3491, 3499, 3511, 3517, 3527, 3529, 3533, 3539,
                    3541, 3547, 3557, 3559, 3571, 3581, 3583, 3593, 3607, 3613, 3617, 3623, 3631, 3637, 3643, 3659,
                    3671, 3673, 3677, 3691, 3697, 3701, 3709, 3719, 3727, 3733, 3739, 3761, 3767, 3769, 3779, 3793,
                    3797, 3803, 3821, 3823, 3833, 3847, 3851, 3853, 3863, 3877, 3881, 3889, 3907, 3911, 3917, 3919,
                    3923, 3929, 3931, 3943, 3947, 3967, 3989],
                4000,
                true
            ]
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->primeNumberGenerator = new PrimeNumberGenerator();
    }

    /**
     * @param int[] $numberSet
     */
    #[DataProvider('providePrimeNumberSets')]
    public function testPrimeNumberGroups(array $numberSet, int $limit, bool $areLastNumbers): void
    {
        $primeNumbers = $this->primeNumberGenerator->generate($limit);

        if ($areLastNumbers) {
            $primeNumbers = array_slice($primeNumbers, -count($numberSet));
        }

        $this->assertEquals($numberSet, $primeNumbers);
    }
}
