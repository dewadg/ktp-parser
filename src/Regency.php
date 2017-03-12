<?php

namespace Dewadg\KtpParser;

use Illuminate\Support\Collection;

class Regency
{
    protected $id;
    protected $name;
    protected $province_id;

    public function __construct($id, $name, $province_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->province_id = $province_id;
    }

    public function get()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'province' => $this->getProvince(),
            'districts' => $this->getDistricts()
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
        $data_source = new Collection(DataSource::fetch()['regencies']);
        $regency = $data_source->where('id', $id)->all();

        if (empty($regency)) {
            throw new \Exception('Requested regency not found');
        }

        return new Regency(
            $regency[0]['id'],
            $regency[0]['name'],
            $regency[0]['province_id']
        );
    }

    public function getProvince()
    {
        return Province::find($this->province_id);
    }

    public function getDistricts()
    {
        $data_source = new Collection(DataSource::fetch()['districts']);
        $districts = $data_source->where('regency_id', $this->id)->all();
        $output = [];

        foreach ($districts as $district) {
            array_push($output, new District(
                $district['id'],
                $district['name'],
                $district['regency_id']
            ));
        }

        return $output;
    }
}
