<?php

namespace Src\Models;

use Src\Systems\Model;

class TerminationType extends Model
{
    static $table = 'termination_types',
            $columns = 'id, name, description, createdAt, updatedAt';

    static function count($input) {
        $query = 'SELECT COUNT(id) AS total FROM ' . self::$table
                    . self::addFilterQuery($input);

        parent::setQuery($query);

        self::addFilterParameter($input);

        return parent::countRow();
    }

    static function get($input) {
        $query ='SELECT ';

        foreach ($input['select'] as $key => $value) {
            if ($key) {
                $query .= ', ' . $value;
            } else {
                $query .= $value;
            }
        }

        $query .= ' FROM ' . self::$table . self::addFilterQuery($input)
                    . ' ORDER BY ' . $input['orderBy'] . ' ' . $input['orderDirection']
                    . ' LIMIT ' . $input['limit'] . ' OFFSET ' . $input['offset'];

        parent::setQuery($query);

        self::addFilterParameter($input);

        return parent::getList();
    }

    private static function addFilterQuery($input) {
        $query = '';

        $hasBeenFiltered = 0;

        if (is_array($input['id'])) {
            $query .= ' WHERE (';

            foreach ($input['id'] as $key => $value) {
                if ($key) {
                    $query .= ' OR id = :id' . $key;
                } else {
                    $query .= 'id = :id' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_string($input['keyword'])) {
            $query .= $hasBeenFiltered ? ' AND (description LIKE :keyword OR name LIKE :keyword)'
                                    : ' WHERE (description LIKE :keyword OR name LIKE :keyword)';

            $hasBeenFiltered = 1;
        }

        if (is_numeric($input['startCreatedAt']) && is_numeric($input['endCreatedAt'])) {
            $query .= $hasBeenFiltered ?
                        ' AND createdAt BETWEEN ' . $input['startCreated_at'] . ' AND ' . $input['endCreatedAt'] :
                        ' WHERE createdAt BETWEEN ' . $input['startCreated_at'] . ' AND ' . $input['endCreatedAt'];
                    
            $hasBeenFiltered = 1;
        } else {
            if (is_numeric($input['startCreatedAt'])) {
                $query .= $hasBeenFiltered
                            ? ' AND createdAt >= ' . $input['startCreatedAt']
                            : ' WHERE createdAt >= ' . $input['startCreatedAt'];
            }

            if (is_numeric($input['endCreatedAt'])) {
                $query .= $hasBeenFiltered
                            ? ' AND createdAt >= ' . $input['endCreatedAt']
                            : ' WHERE createdAt >= ' . $input['endCreatedAt'];
            }
        }

        return $query;
    }

    private static function addFilterParameter($input) {
        if (is_string($input['keyword'])) {
            parent::setParameter(':keyword', '%' . $input['keyword'] . '%');
        }

        if (is_array($input['id'])) {
            foreach ($input['id'] as $key => $value) {
                parent::setParameter(':id' . $key, $value);
            }
        }
    }
}
