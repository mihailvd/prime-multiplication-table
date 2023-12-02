<?php

namespace Mihailvd\PrimeMultiplicationTable\Test\DataTransformer;

use InvalidArgumentException;
use Mihailvd\PrimeMultiplicationTable\DataTransformer\ExpressionParser;
use Mihailvd\PrimeMultiplicationTable\DataTransformer\MatrixCreator;
use Mihailvd\PrimeMultiplicationTable\DataTransformer\MatrixCreatorInterface;
use Mihailvd\PrimeMultiplicationTable\DataTransformer\Operation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MatrixCreator::class)]
class MatrixCreatorTest extends TestCase
{
    private MatrixCreatorInterface $matrixCreator;

    public static function provideTestMatrices()
    {
        return [
            [
                [1, 2, 3],
                [4, 5, 6],
                'x+y',
                [
                    [5, 6, 7],
                    [6, 7, 8],
                    [7, 8, 9]
                ]
            ],
            [
                [1, 2, 3],
                [4, 5, 6],
                'x-y',
                [
                    [-3.0, -2.0, -1.0],
                    [-4.0, -3.0, -2.0],
                    [-5.0, -4.0, -3.0]
                ]
            ],
            [
                [1, 2, 3],
                [4, 5, 6],
                'x*y',
                [
                    [4.0, 8.0, 12.0],
                    [5.0, 10.0, 15.0],
                    [6.0, 12.0, 18.0]
                ]
            ],
            [
                [1, 2, 3],
                [4, 5, 6],
                'x/y',
                [
                    [0.25, 0.5, 0.75],
                    [0.2, 0.4, 0.6],
                    [0.17, 0.33, 0.5]
                ]
            ],
            [
                [1, 2, 3],
                [4, 5, 6],
                'x+y*3',
                [
                    [13.0, 14.0, 15.0],
                    [16.0, 17.0, 18.0],
                    [19.0, 20.0, 21.0]
                ]
            ],
            [
                [1, 2, 3],
                [4, 5, 6],
                'x*y+3',
                [
                    [7.0, 11.0, 15.0],
                    [8.0, 13.0, 18.0],
                    [9.0, 15.0, 21.0]
                ]
            ]
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->matrixCreator = new MatrixCreator();
    }

    #[DataProvider('provideTestMatrices')]
    public function testMatrix($xAxis, $yAxis, string $expression, array $expectedMatrix): void
    {
        $operation = new Operation(new ExpressionParser(), $expression);

        $actualMatrix = $this->matrixCreator->generate($xAxis, $yAxis, $operation);

        $this->assertEquals($expectedMatrix, $actualMatrix);
    }

    public function testInvalidExpression(): void
    {
        $invalidExpression = 'x*ys;';
        $invalidOperation = new Operation(new ExpressionParser(), $invalidExpression);

        $this->expectException(InvalidArgumentException::class);
        $this->matrixCreator->generate([1], [1], $invalidOperation);
    }

    public function testEmptyExpression(): void
    {
        $emptyOperation = new Operation(new ExpressionParser(), '');

        $this->expectException(InvalidArgumentException::class);
        $this->matrixCreator->generate([1], [1], $emptyOperation);
    }
}
