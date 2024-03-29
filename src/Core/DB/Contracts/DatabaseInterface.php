<?php

namespace KPZadatak\Core\DB\Contracts;

interface DatabaseInterface
{
    public function create($table, $data);
    public function read($table, $where = null, array $params = []);
    public function readOne($table, $where, array $params = []);
    public function update($table, $data, $where, array $params = []);
    public function delete($table, $where, array $params = []);
}
