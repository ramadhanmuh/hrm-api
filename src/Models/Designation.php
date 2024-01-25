<?php

namespace Src\Models;

use Src\Systems\Model;

class Designation extends Model
{
    static $table = 'designations',
            $columns = 'id, departmentId, name, createdAt, updatedAt';

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

        if (is_array($rules['departmentId'])) {
            $query .= $hasBeenFiltered ? ' AND (' : ' WHERE (';

            foreach ($rules['departmentId'] as $key => $value) {
                if ($key) {
                    $query .= ' OR ' . self::$table . '.departmentId = :departmentId' . $key;
                } else {
                    $query .= self::$table . '.departmentId = :departmentId' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_string($rules['keyword'])) {
            $query .= $hasBeenFiltered ? ' AND (' . self::$table . '.name LIKE :keyword OR departments.name LIKE :keyword)'
                                    : ' WHERE (' . self::$table . '.name LIKE :keyword OR departments.name LIKE :keyword)';

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

    private static function addFilterParameter($rules) {
        if (is_string($rules['keyword'])) {
            $rules['keyword'] = '%' . $rules['keyword'] . '%';
        }

        if (is_array($rules['id'])) {
            foreach ($rules['id'] as $key => $value) {
                parent::setParameter(':id' . $key, $value);
            }
        }

        if (is_array($rules['departmentId'])) {
            foreach ($rules['departmentId'] as $key => $value) {
                parent::setParameter(':departmentId' . $key, $value);
            }
        }
    }

    static function count($rules) {
        $query = '
            SELECT
                COUNT(' . self::$table . '.id) AS total
            FROM
                ' . self::$table . self::addRelationQuery()
                    . self::addFilterQuery($rules);

        parent::setQuery($query);

        self::addFilterParameter($rules);

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
                ' . self::$table . self::addRelationQuery()
                    . self::addFilterQuery($rules);

        $query .= ' ORDER BY ' . $rules['orderBy'] . ' ' . $rules['orderDirection'] .
                    ' LIMIT ' . $rules['limit'] . ' OFFSET ' . $rules['offset'];

        parent::setQuery($query);

        self::addFilterParameter($rules);

        return parent::getList();
    }

    private static function addRelationQuery() {
        return '
            INNER JOIN
                departments
            ON
                ' . self::$table . '.departmentId = departments.id
        ';
    }
}
