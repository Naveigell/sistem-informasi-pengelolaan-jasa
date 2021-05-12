<?php

namespace App\Exports\Excel;

use App\Models\Exports\Excel\OrderModel;
use App\Traits\DateTime\DateTimeRepeaterAndSanitizer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinanceExcelExporter implements FromCollection, WithColumnFormatting, WithColumnWidths, WithStyles
{
    use DateTimeRepeaterAndSanitizer;
    /**
     * @var int Represent month and year
     */
    private int $year;
    private int $month;
    private const FORMAT_ACCOUNTING_RP_INDONESIAN = '_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)';
    private const MONTHS = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    private int $count = 1;

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
        $cost = 0;
        $index = 0;

        $id = auth("user")->id();
        $admin = (new \App\Models\User\UserModel)->select(["name"])->where([
            "id_users"  => $id,
            "role"      => "admin"
        ])->first();

        // check if admin is an real admin
        if (is_null($admin)) {
            return collect([["You cannot access this page"]]);
        }

        $order = new OrderModel();
        $data = $order->collectDataForExports($this->month, $this->year)->toArray();

        $gap = 4;
        $array = [];
        $month = self::MONTHS[$this->sanitizeMonth($this->month) - 1];

        $this->createGap(1, $array);
        array_push($array, ["Pendapatan Bulan $month $this->year", "", "", "", "", "", ""]);
        $this->createGap(2, $array);
        array_push($array, ["No", "Order Id", "Sparepart", "Jumlah", "Harga asli", "Harga jual", "Biaya"]);
        foreach ($data as $datum) {
            $spareparts = $datum["spareparts"];
            if (count($spareparts) > 0) {
                for ($i = 0; $i < count($spareparts); $i++) {
                    $sparepart = $spareparts[$i];

                    $index++;
                    $spending += $sparepart["harga_asli"] * $sparepart["jumlah"];
                    $income += $sparepart["harga"] * $sparepart["jumlah"];

                    $arr = [];

                    $arr[] = $index;
                    if ($i == 0) {
                        $arr[] = $datum["unique_id"];
                    } else {
                        $arr[] = "";
                    }

                    $arr[] = $sparepart["nama_spare_part"];
                    $arr[] = $sparepart["jumlah"];
                    $arr[] = $sparepart["harga_asli"];
                    $arr[] = $sparepart["harga"];

                    if ($i == 0) {
                        $arr[] = $datum["service"]["biaya_jasa"];

                        $cost += $datum["service"]["biaya_jasa"];
                    }

                    array_push($array, $arr);
                }
            } else {
                $index++;
                $cost += $datum["service"]["biaya_jasa"];

                array_push($array, [$index, $datum["unique_id"], "-", "-", "-", "-", $datum["service"]["biaya_jasa"]]);
            }
        }
        array_push($array, ["Total", "", "", "", $spending, $income, $cost]);
        $this->createGap(3, $array); // make some space for confirmation
        array_push($array, ["", "", "", "", "Mengetahui", "", ""]);
        $this->createGap(4, $array);
        array_push($array, ["", "", "", "", $admin->name, "", ""]);

        $this->count = $index + $gap + 2;

        return collect([$array]);
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            "E"         => self::FORMAT_ACCOUNTING_RP_INDONESIAN,
            "F"         => self::FORMAT_ACCOUNTING_RP_INDONESIAN,
            "G"         => self::FORMAT_ACCOUNTING_RP_INDONESIAN,
        ];
    }

    public function columnWidths(): array
    {
        return [
            "B"         => 20,
            "C"         => 55,
            "E"         => 20,
            "F"         => 20,
            "G"         => 20
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // A Column Style
        $sheet->getStyle("A")->getAlignment()->setHorizontal("center");

        // B Column Style
        $sheet->getStyle("B")->getAlignment()->setHorizontal("left");
        $sheet->getStyle("B")->getAlignment()->setIndent(1);

        // C Column Style
        $sheet->getStyle("C5")->getAlignment()->setHorizontal("center");
        $sheet->getStyle("C")->getAlignment()->setHorizontal("left");
        $sheet->getStyle("C")->getAlignment()->setIndent(1);
        $sheet->getStyle("C5")->getAlignment()->setIndent(0);

        // D Column Style
        $sheet->getStyle("D")->getAlignment()->setHorizontal("center");

        // 2 Row Style
        try {
            $sheet->mergeCells("A2:G2");
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        $sheet->getStyle(2)->getAlignment()->setVertical("center");
        $sheet->getStyle(2)->getAlignment()->setHorizontal("center");
        $sheet->getStyle(2)->getFont()->setBold(true);
        $sheet->getStyle(2)->getFont()->setSize(14);

        // 5 Row Style
        $sheet->getStyle(5)->getAlignment()->setVertical("center");
        $sheet->getStyle(5)->getAlignment()->setHorizontal("center");
        $sheet->getStyle(5)->getFont()->setBold(true);
        $sheet->getRowDimension(5)->setRowHeight(18);

        // $count Row Style
        $sheet->getStyle($this->count)->getFont()->setBold(true);

        try {
            $sheet->mergeCells("A$this->count:D$this->count");
        } catch (Exception $e) {
            error_log($e->getMessage());
        }

        $confirmationSpace = $this->count + 4;
        // merge some cell for confirmation
        try {
            $sheet->mergeCells("E$confirmationSpace:G$confirmationSpace");
            $sheet->getStyle("E$confirmationSpace")->getAlignment()->setVertical("center");
            $sheet->getStyle("E$confirmationSpace")->getAlignment()->setHorizontal("center");
        } catch (Exception $e) {
            error_log($e->getMessage());
        }

        $confirmationSpace += 5;
        try {
            $sheet->mergeCells("E$confirmationSpace:G$confirmationSpace");
            $sheet->getStyle("E$confirmationSpace")->getAlignment()->setVertical("center");
            $sheet->getStyle("E$confirmationSpace")->getAlignment()->setHorizontal("center");
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    /**
     * Create gap from array
     *
     * @param int $count
     * @param $array
     */
    private function createGap(int $count, &$array)
    {
        for ($i = 0; $i < $count; $i++) {
            array_push($array, ["", "", "", "", "", "", ""]);
        }
    }
}
