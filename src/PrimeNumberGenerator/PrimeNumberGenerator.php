<?php

namespace Mihailvd\PrimeMultiplicationTable\PrimeNumberGenerator;

class PrimeNumberGenerator implements PrimeNumberGeneratorInterface
{
    /**
     * @return int[]
     */
    public function generate(int $limit): array
    {
        if ($limit <= 1) {
            return [];
        } elseif ($limit <= 2) {
            return [2];
        } elseif ($limit <= 3) {
            return [2, 3];
        }

        $primes = [2, 3];

        $sieve = array_fill(1, $limit, false);
        $squareRootLimit = sqrt($limit);

        for ($x = 1; $x < $squareRootLimit; $x++) {
            for ($y = 1; $y < $squareRootLimit; $y++) {
                $n = (4 * $x * $x) + ($y * $y);
                if ($n <= $limit && ($n % 12 === 1 || $n % 12 === 5)) {
                    $sieve[$n] ^= true;
                }

                $n = (3 * $x * $x) + ($y * $y);
                if ($n <= $limit && $n % 12 === 7) {
                    $sieve[$n] ^= true;
                }

                $n = (3 * $x * $x) - ($y * $y);
                if ($x > $y && $n <= $limit && $n % 12 === 11) {
                    $sieve[$n] ^= true;
                }
            }
        }

        // Mark all multiples of square as non-prime
        for ($r = 5; $r < $squareRootLimit; $r++) {
            if ($sieve[$r]) {
                for ($i = $r * $r; $i <= $limit; $i += $r * $r) {
                    $sieve[$i] = false;
                }
            }
        }

        for ($a = 1; $a <= $limit; $a++) {
            if ($sieve[$a]) {
                $primes[] = $a;
            }
        }

        return $primes;
    }
}
