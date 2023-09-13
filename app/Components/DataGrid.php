<?php
declare(strict_types=1);

namespace App\Components;

use Ublaboo\DataGrid\DataSource\IDataSource;

class DataGrid extends \Ublaboo\DataGrid\DataGrid {

    public function __construct(
        IDataSource $dataSource
    ) {
        parent::__construct();
        $this->setDataSource($dataSource);
    }

    public function createGrid(): self {
        $this->addColumnText('name', 'Name');
        $this->addColumnText('firstNumber', 'FirstNumber');
        $this->addColumnText('secondNumber', 'SecondNumber');
        $this->addColumnText('thirdNumber', 'ThirdNumber');
        $this->addColumnText('calculation', 'Calculation');
        $this->addColumnDateTime('createdAt', 'CreatedAt');

        return $this;
    }
}