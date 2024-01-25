<?php

namespace Src\Models;

use Src\Systems\Model;

class Department extends Model
{
    static $table = 'departments',
            $columns = 'id, branchId, name, createdAt, updatedAt';

    static function count($rules) {
        $query = '
            SELECT
                COUNT(' . self::$table . '.id) AS total
            FROM
                ' . self::$table . '
            INNER JOIN
                branches
            ON
                ' . self::$table . '.branchId = branches.id
        ';

        $query .= self::addFilterQuery($rules);

        parent::setQuery($query);

        self::setFilterParameter($rules);

        return parent::countRow();
    }

    static function get($rules) {
        $query ='SELECT ';

        foreach ($rules['select'] as $key => $value) {
            if ($key) {
                $query .= ', ' . self::$table . '.' . $value;
            } else {
                $query .= self::$table . '.' . $value;
            }
        }

        $query .= '
            FROM
                ' . self::$table . '
            INNER JOIN
                branches
            ON
                ' . self::$table . '.branchId = branches.id
        ';

        $query .= self::addFilterQuery($rules);

        $query .= ' ORDER BY ' . self::$table . '.' . $rules['orderBy'] . ' ' . $rules['orderDirection'] .
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

        if (is_array($rules['branchId'])) {
            foreach ($rules['branchId'] as $key => $value) {
                parent::setParameter(':branchId' . $key, $value);
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
                    $query .= ' OR ' . self::$table . '.id = :id' . $key;
                } else {
                    $query .= self::$table . '.id = :id' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_array($rules['branchId'])) {
            $query .= $hasBeenFiltered ? ' AND (' : ' WHERE (';

            foreach ($rules['branchId'] as $key => $value) {
                if ($key) {
                    $query .= ' OR ' . self::$table . '.branchId = :branchId' . $key;
                } else {
                    $query .= self::$table . '.branchId = :branchId' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_string($rules['keyword'])) {
            $query .= $hasBeenFiltered ? ' AND (' . self::$table . '.name LIKE :keyword OR branches.name)'
                                    : ' WHERE (' . self::$table . '.name LIKE :keyword OR branches.name)';

            $hasBeenFiltered = 1;
        }

        if (is_numeric($rules['startCreatedAt']) && is_numeric($rules['endCreatedAt'])) {
            $query .= $hasBeenFiltered ?
                        ' AND ' . self::$table . '.createdAt BETWEEN ' . $rules['startCreatedAt'] . ' AND ' . $rules['endCreatedAt'] :
                        ' WHERE ' . self::$table . '.createdAt BETWEEN ' . $rules['startCreatedAt'] . ' AND ' . $rules['endCreatedAt'];
                    
            $hasBeenFiltered = 1;
        } else {
            if (is_numeric($rules['startCreatedAt'])) {
                $query .= $hasBeenFiltered
                            ? ' AND ' . self::$table . '.createdAt >= ' . $rules['startCreatedAt']
                            : ' WHERE ' . self::$table . '.createdAt >= ' . $rules['startCreatedAt'];
            }

            if (is_numeric($rules['endCreatedAt'])) {
                $query .= $hasBeenFiltered
                            ? ' AND ' . self::$table . '.createdAt >= ' . $rules['endCreatedAt']
                            : ' WHERE ' . self::$table . '.createdAt >= ' . $rules['endCreatedAt'];
            }
        }

        return $query;
    }
}
