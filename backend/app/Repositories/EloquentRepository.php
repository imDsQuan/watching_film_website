<?php

namespace App\Repositories;

use \Illuminate\Http\Request;

abstract class EloquentRepository{

    protected $_model;

    public function __construct()
    {
        $this->setModel();
    }

    public function getAll()
    {
        return $this->_model->all();
    }

    abstract public function getModel();

    private function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    public function find($id)
    {
        $result = $this->_model->where('id', $id)->first();
        return $result;
    }

    public function create(array $array)
    {
        return $this->_model->create($array);
    }

    public function update($id, array $array)
    {
        $result = $this->_model->find($id);
        if ($result) {
            $result->update($array);
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->_model->where('id', $id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function total()
    {
        return $this->_model->count();
    }

}
