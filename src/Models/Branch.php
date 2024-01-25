<?php

namespace Src\Models;

use Src\Systems\Model;

class Branch extends Model
{
    static $table = 'branches',
            $columns = 'id, name, createdAt, updatedAt';

    static function count($rules) {
        $query ='SELECT COUNT(id) AS total FROM ' . self::$table . '';

        $query .= self::addFilterQuery($rules);

        parent::setQuery($query);

        self::setFilterParameter($rules);

        return parent::countRow();
    }

    static function get($rules) {
        $query ='SELECT ';

        foreach ($rules['select'] as $key => $value) {
            if ($key) {
                $query .= ', ' . $value;
            } else {
                $query .= $value;
            }
        }

        $query .= ' FROM ' . self::$table;

        $query .= self::addFilterQuery($rules);

        $query .= ' ORDER BY ' . $rules['orderBy'] . ' ' . $rules['orderDirection'] .
                    ' LIMIT ' . $rules['limit'] . ' OFFSET ' . $rules['offset'];

        parent::setQuery($query);

        self::setFilterParameter($rules);

        return parent::getList();
    }

    private static function setFilterParameter($rules) {
        if (is_string($rules['keyword'])) {
            parent::setParameter(':keyword', '%' . $rules['keyword'] . '%');
        }

        if (is_array($rules['id'])) {
            foreach ($rules['id'] as $key => $value) {
                parent::setParameter(':id' . $key, $value);
            }
        }
    }

    private static function addFilterQuery($rules) {
        $query = '';

        $hasBeenFiltered = 0;

        if (is_array($rules['id'])) {
            $query .= ' WHERE (';

            foreach ($rules['id'] as $key => $value) {
                if ($key) {
                    $query .= ' OR id = :id' . $key;
                } else {
                    $query .= 'id = :id' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_string($rules['keyword'])) {
            $query .= $hasBeenFiltered ? ' AND (name LIKE :keyword)'
                                    : ' WHERE (name LIKE :keyword)';

            $hasBeenFiltered = 1;
        }

        if (is_numeric($rules['startCreatedAt']) && is_numeric($rules['endCreatedAt'])) {
            $query .= $hasBeenFiltered ?
                        ' AND createdAt BETWEEN ' . $rules['startCreatedAt'] . ' AND ' . $rules['endCreatedAt'] :
                        ' WHERE createdAt BETWEEN ' . $rules['startCreatedAt'] . ' AND ' . $rules['endCreatedAt'];
        } else {
            if (is_numeric($rules['startCreatedAt'])) {
                $query .= $hasBeenFiltered
                            ? ' AND createdAt >= ' . $rules['startCreatedAt']
                            : ' WHERE createdAt >= ' . $rules['startCreatedAt'];
            }

            if (is_numeric($rules['endCreatedAt'])) {
                $query .= $hasBeenFiltered
                            ? ' AND createdAt >= ' . $rules['endCreatedAt']
                            : ' WHERE createdAt >= ' . $rules['endCreatedAt'];
            }
        }

        return $query;
    }
}
