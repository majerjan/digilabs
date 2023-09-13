<?php
declare(strict_types=1);

namespace App\Components;

use Ublaboo\DataGrid\DataSource\IDataSource;

interface IDataGridFactory {

    public function create(
        IDataSource $dataSource
    ): DataGrid;
}