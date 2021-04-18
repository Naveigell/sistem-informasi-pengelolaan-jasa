<?php
namespace App\Interfaces\Graph;

interface GraphDataInterface
{
    /**
     * Create labels for graph
     *
     * @return mixed
     */
    public function labels(): array;

    /**
     * Create datasets for graph
     *
     * @return mixed
     */
    public function datasets(): array;
}
