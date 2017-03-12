<?php

namespace Dewadg\KtpParser;

use Illuminate\Support\Collection;

class Province
{
    protected $id;
    protected $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function get()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'regencies' => $this->getRegencies()
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function find($id)
    {
        $data_source = new Collection(DataSource::fetch()['provinces']);
        $province = $data_source->where('id', $id)->all();

        if (empty($province)) {
            throw new \Exception('Requested regency not found');
        }

        return new Province(
            $province[0]['id'],
            $province[0]['name']
        );
    }

    public function getRegencies()
    {
        $data_source = new Collection(DataSource::fetch()['regencies']);
        $regencies = $data_source->where('province_id', $this->id)->all();
        $output = [];

        foreach ($regencies as $regency) {
            array_push($output, new Regency(
                $regency['id'],
                $regency['name'],
                $regency['province_id']
            ));
        }

        return $output;
    }
}
