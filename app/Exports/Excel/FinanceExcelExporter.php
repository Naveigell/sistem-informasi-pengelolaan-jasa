<?php

namespace App\Exports\Excel;

use App\Models\Exports\Excel\OrderSparepartModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class FinanceExcelExporter implements FromCollection
{
    /**
     * @var int Represent month and year
     */
    private $month, $year;

    /**
     * FinanceExcelExporter constructor.
     *
     * @param $month
     * @param $year
     */
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $spending = 0;
        $income = 0;

        $order = new OrderSparepartModel();
        $data = $order->collectDataForExports($this->month, $this->year);

        $array = [];
        array_push($array, ["No", "Sparepart", "Jumlah", "Harga asli", "Harga jual"]);
        for ($i = 1; $i < count($data); $i++) {
            $spending += $data[$i]->harga_asli * $data[$i]->jumlah;
            $income += $data[$i]->harga * $data[$i]->jumlah;

            array_push($array, [$i, $data[$i]->nama_spare_part, $data[$i]->jumlah, $data[$i]->harga_asli, $data[$i]->harga]);
        }
        array_push($array, ["Total", "", "", $spending, $income]);

        return collect([$array]);
    }
}
