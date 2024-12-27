<?php

namespace App\Database\Contracts;

interface CrudInterface
{

    # create (insert)
    public function create($fields, $values);

    # Read (select) single | multiple
    public function get($id);

    # Update records
    public function update($fields, $values, $id);

    # Delete
    public function delete($id);
}