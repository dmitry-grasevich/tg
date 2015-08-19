<?php
const ROWS = '-m';
const COLUMNS = '-n';

if (!checkArguments($argv)) {
    return;
}

$rows = $argv[1] == ROWS ? $argv[2] : $argv[4];
$columns = $argv[1] == COLUMNS ? $argv[2] : $argv[4];

$matrix = new Matrix($rows, $columns);
$printMatrix = new PrintMatrix($matrix);

echo "Input Matrix:\n";
$printMatrix->all();

echo "Main diagonal:\n";
$printMatrix->mainDiagonal();

echo "Secondary diagonal:\n";
$printMatrix->secondaryDiagonal();

echo "Diagonal sum:\n";
$printMatrix->diagonalSum();

echo "Factorial of diagonal sum:\n";
echo factorial($matrix->diagonalSum()) . "\n";

function factorial($number) {
    if ($number == 0) return 1;
    return $number * factorial($number - 1);
}

class Matrix {
    const MIN = 1;
    const MAX = 10;

    protected $rows;
    protected $columns;
    protected $matrix = array();

    public function __construct($rows = null, $columns = null)
    {
        $this->setRows($rows);
        $this->setColumns($columns);

        if ($this->rows && $this->columns) {
            $this->generate();
        }
    }

    public function generate()
    {
        if (!$this->rows || !$this->columns) {
            throw new Exception("Number of rows or number columns is not set");
        }

        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->columns; $j++) {
                $this->matrix[$i][$j] = rand(self::MIN, self::MAX);
            }
        }
    }

    public function mainDiagonal()
    {
        if (empty($this->matrix)) {
            return null;
        }

        $result = array();
        for ($i = 0; $i < $this->getMiddleColumnNumber(); $i++) {
            $result[] = $this->matrix[$i][$i];
        }
        return $result;
    }

    public function secondaryDiagonal()
    {
        if (empty($this->matrix)) {
            return null;
        }

        $result = array();
        $minCol = $this->getMiddleColumnNumber();
        if ($minCol < $this->columns) {
            for ($i = $this->columns - 1, $row = 0; $i >= $minCol; $i--, $row++) {
                $result[] = $this->matrix[$row][$i];
            }
        }

        return $result;
    }

    protected function getMiddleColumnNumber()
    {
        return intval(round($this->columns / 2));
    }

    public function diagonalSum()
    {
        return array_sum($this->mainDiagonal()) + array_sum($this->secondaryDiagonal());
    }

    public function setRows($rows) {
        $this->rows = intval($rows);
    }

    public function setColumns($columns) {
        $this->columns = intval($columns);
    }

    public function getMatrix()
    {
        return $this->matrix;
    }
}

class PrintMatrix {
    protected $matrix;

    public function __construct(Matrix $matrix)
    {
        $this->matrix = $matrix;
    }

    public function all()
    {
        foreach ($this->matrix->getMatrix() as $rows) {
            foreach ($rows as $col) {
                echo $col . "\t";
            }
            echo "\n";
        }
    }

    public function mainDiagonal()
    {
        $diagonal = $this->matrix->mainDiagonal();
        if ($diagonal !== null) {
            echo implode("\t", $diagonal);
        }
        echo "\n";
    }

    public function secondaryDiagonal()
    {
        $diagonal = $this->matrix->secondaryDiagonal();
        if ($diagonal !== null) {
            echo implode("\t", $diagonal);
        }
        echo "\n";
    }

    public function diagonalSum()
    {
        echo $this->matrix->diagonalSum() . "\n";
    }
}

/**
 * Check input arguments
 *
 * @param $argv
 * @return bool
 */
function checkArguments($argv) {
    $result = false;

    if (count($argv) != 5 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
        echo "Using:\n";
        echo "\tphp $argv[0] " . ROWS . " 5 " . COLUMNS . " 6\n";
        echo "Where:\n";
        echo "\t" . ROWS . " is integer number of rows\n\t" . COLUMNS . " is integer number of columns\n";
    } elseif (!in_array($argv[1], array(ROWS, COLUMNS)) || !in_array($argv[3], array(ROWS, COLUMNS)) || $argv[1] == $argv[2]) {
        echo "Please use '" . ROWS . "' and '" . COLUMNS . "' to set matrix dimension\n";
    } elseif (intval($argv[2]) <= 0 || intval($argv[4]) <= 0) {
        echo "Number of rows and number of columns should be an integer value greater than zero\n";
    } else {
        $result = true;
    }

    return $result;
}