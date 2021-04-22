<?php
namespace App\Interfaces\Exports;

interface ExportGeneratorInterface
{
    /**
     * Create generator for excel
     *
     * @return mixed
     */
    public function excel();

    /**
     * Create generator for pdf
     *
     * @return mixed
     */
    public function pdf();
}
