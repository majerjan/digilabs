<?php
declare(strict_types=1);

namespace App\Presenters;


use App\Components\DataGrid;
use App\Components\IDataGridFactory;
use App\Dto\DataItemDto;
use App\Facades\DataFacade;
use App\Helpers\DataLoaderHelper;
use App\Helpers\PathHelper;
use App\Repositories\DataRepository;
use Nette\Application\UI\Presenter;
use Tracy\Debugger;
use Ublaboo\DataGrid\DataSource\ArrayDataSource;

class ActionPresenter extends Presenter{

    public function __construct(
        private readonly DataRepository $dataRepository,
        private readonly DataLoaderHelper $dataLoaderHelper,
        private readonly DataFacade $dataFacade,
        private readonly IDataGridFactory $dataGridFactory
    ) {
        parent::__construct();
    }

    public function actionJoke(): void {
        $this->template->imageSrc = $this->dataFacade->getJokeImagePath();
    }

    public function createComponentNameGrid($name): DataGrid {
        return $this->createDateGridAndSource($this->dataRepository->getSameFirstLetter(false));
    }

    public function createComponentDivisionGrid($name): DataGrid {
        return $this->createDateGridAndSource($this->dataRepository->getCountEqual());
    }

    public function createComponentDateGrid($name): DataGrid {
        return $this->createDateGridAndSource($this->dataRepository->getByMonth());
    }

    public function createComponentCalculationGrid($name): DataGrid {
        return $this->createDateGridAndSource($this->dataRepository->getCalculation());
    }

    /**
     * @param DataItemDto[] $data
     */
    private function createDateGridAndSource(array $data): DataGrid {
        $source = new ArrayDataSource($this->dataLoaderHelper->convertToArray($data));
        $grid = $this->dataGridFactory->create($source);

        return $grid->createGrid();
    }
}