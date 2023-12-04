# Prime number multiplication table generator

## Installation & Execution

### Requirements

This project requires PHP 8.2+ with the PDO extension and Composer 2+

The application is deployed as a composer package. You can install it globally using:
```shell
composer global require mihailvd/prime-multiplication-table
```
You can also run the CLI directly by navigating to the project's root directory and executing:
```shell
./bin/primes-table
```

### Testing

The application has a single test suite preset and configured. You can run the unit tests by navigating to the project root and executing:
```shell
./vendor/bin/phpunit
```

## Usage

The CLI takes the dimensions of the generated matrix as the first argument. Additionally, you can provide an option to define the math expression to be applied on x and y instead of multiplication.

The first argument has a default value of 10, which results in a matrix of prime numbers up to 7 (4x4).

The math expression formula defaults to "x&ast;y" if none other is supplied.

### Example usages

Generate a prime numbers multiplication table matrix up to 20:
```shell
primes-table generate 20
```

Generate a prime numbers up to 50 table, but perform addition instead of multiplication:
```shell
primes-table generate 50 -f "x+y"
```

The simple math expressions must be written with no spaces, and support simple operations: &ast;, /, +, -.
The variables "x" and "y" are both optional, can appear multiple times, and can be combined with any numbers, e.g. "x&ast;x+y/0.5"

You can persist the generated matrix to a SQLite database using the option:
```shell
primes-table generate 30 -p
```

## Implementation details

### Prime number generator

The [Sieve of Atkin](https://en.wikipedia.org/wiki/Sieve_of_Atkin) algorithm is chosen to perform the generation of prime numbers up to the desired limit.

The reasoning behind the choice is that being relatively new, it's optimised for performance with the tradeoff of a bit more complicated implementation.
The algorithm is dominated by the first nested couple of loops both running √N times, which results in an √N x √N, simplified to N total of runs.
This approximates the time complexity of the algorithm to O(N). 

