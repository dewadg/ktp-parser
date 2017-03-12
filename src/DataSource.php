<?php

namespace Dewadg\KtpParser;

class DataSource
{
    protected $provinces = [];
    protected $regencies = [];
    protected $districts = [];

    public function __construct()
    {
        $this->loadData();
    }

    private function loadData()
    {
        $data = require '../config/data.php';

        $this->provinces = $data['provinces'];
        $this->regencies = $data['regencies'];
        $this->districts = $data['districts'];
    }

    public function getData()
    {
        return [
            'provinces' => $this->provinces,
            'regencies' => $this->regencies,
            'districts' => $this->districts
        ];
    }

    public static function fetch()
    {
        $data_source = new DataSource;

        return $data_source->getData();
    }
}
