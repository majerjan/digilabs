<?php
declare(strict_types=1);

namespace App\Presenters;


use App\Components\DataGrid;
use App\Components\IDataGridFactory;
use App\Dto\DataItemDto;
use App\Exceptions\GifCreationException;
use App\Exceptions\InvalidNameException;
use App\Facades\DataFacade;
use App\Helpers\DataLoaderHelper;
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
        $path = '';

        try {
            $path = $this->dataFacade->getJokeImagePath();
        } catch (GifCreationException|\Exception $exception) {
            Debugger::log($exception);
            $this->flashMessage('Došlo k chybě', 'danger');
        }

        $this->template->imageSrc = $path;
    }

    public function createComponentNameGrid(string $name): DataGrid {
        $data = [];

        try {
            $data = $this->dataRepository->getSameFirstLetter(false);
        } catch (InvalidNameException|\Exception $exception) {
            Debugger::log($exception);
            $this->flashMessage('Došlo k chybě', 'danger');
        }

        return $this->createDateGridAndSource($data);
    }

    public function createComponentDivisionGrid(string $name): DataGrid {
        $data = [];

        try {
            $data = $this->dataRepository->getCountEqual();
        } catch (\Exception $exception) {
            Debugger::log($exception);
            $this->flashMessage('Došlo k chybě', 'danger');
        }

        return $this->createDateGridAndSource($data);
    }

    public function createComponentDateGrid(string $name): DataGrid {
        $data = [];

        try {
            $data = $this->dataRepository->getByMonth();
        } catch (\Exception $exception) {
            Debugger::log($exception);
            $this->flashMessage('Došlo k chybě', 'danger');
        }

        return $this->createDateGridAndSource($data);
    }

    public function createComponentCalculationGrid(string $name): DataGrid {
        $data = [];

        try {
            $data = $this->dataRepository->getCalculation();
        } catch (\Exception $exception) {
            Debugger::log($exception);
            $this->flashMessage('Došlo k chybě', 'danger');
        }

        return $this->createDateGridAndSource($data);
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