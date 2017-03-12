<?php

namespace Dewadg\KtpParser;

use Illuminate\Support\Collection;

class District
{
    protected $id;
    protected $name;
    protected $regency_id;

    public function __construct($id, $name, $regency_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->regency_id = $regency_id;
    }

    public function get()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'regency' => $this->getRegency()
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
        $data_source = new Collection(DataSource::fetch()['districts']);
        $district = $data_source->where('id', $id)->all();

        if (empty($district)) {
            throw new \Exception('Requested district not found');
        }

        return new District(
            $district[0]['id'],
            $district[0]['name'],
            $district[0]['regency_id']
        );
    }

    public function getRegency()
    {
        return Regency::find($this->regency_id);
    }
}
