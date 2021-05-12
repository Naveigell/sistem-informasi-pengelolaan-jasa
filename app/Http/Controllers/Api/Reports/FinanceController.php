<?php

namespace App\Http\Controllers\Api\Reports;

use App\Exports\Excel\FinanceExcelExporter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exporter\Excel\FinanceRequestCreate;
use App\Interfaces\Exports\ExportGeneratorInterface;
use App\Models\Exports\Excel\OrderModel;
use App\Models\Exports\Excel\OrderSparepartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller implements ExportGeneratorInterface
{
    private $month, $year;

    /**
     * @param FinanceRequestCreate $request
     * @return mixed
     */
    public function excelConverter(FinanceRequestCreate $request)
    {
        $this->month    = $request->month;
        $this->year     = $request->year;

        return $this->excel();
    }

    /**
     * Create generator for excel
     *
     * @return mixed
     */
    public function excel()
    {
        ob_end_clean();
        ob_start();

        $uuid = Str::uuid();
        $name = "excel-$uuid.xlsx";

        return Excel::download(new FinanceExcelExporter($this->month, $this->year), $name);
    }

    /**
     * Create generator for pdf
     *
     * @return mixed
     */
    public function pdf()
    {

    }
}
