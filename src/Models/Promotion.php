<?php

namespace Src\Models;

use Src\Systems\Model;

class Promotion extends Model
{
    static $table = 'promotions',
            $columns = 'id, employeeId, designationId, title,
                        date, description, createdAt, updatedAt';

    static function count($rules) {
        $query = '
            SELECT
                COUNT(' . self::$table . '.id) AS total
            FROM '
            . self::$table
            . self::addRelationQuery()
            . self::addFilterQuery($rules);

        parent::setQuery($query);

        self::addFilterParams($rules);

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

        $query .= ' FROM ' . self::$table
                            . self::addRelationQuery()
                            . self::addFilterQuery($rules);

        $orderColumns = [
            'id' => self::$table . '.id',
            'title' => self::$table . '.title',
            'employeeId' => self::$table . '.employeeId',
            'designationId' => self::$table . '.designationId',
            'date' => self::$table . '.date',
            'description' => self::$table . '.description',
            'createdAt' => self::$table . '.createdAt',
            'updatedAt' => self::$table . '.updatedAt',
            'employeeName' => 'employees.name',
            'employeeRegistrationNumber' => 'employees.registrationNumber',
            'employeeEmail' => 'employees.email',
            'designationName' => 'designations.name'
        ];

        $query .= ' ORDER BY ' . $orderColumns[$rules['orderBy']] . ' ' . $rules['orderDirection'] .
                    ' LIMIT ' . $rules['limit'] . ' OFFSET ' . $rules['offset'];

        parent::setQuery($query);

        self::addFilterParams($rules);

        return parent::getList();
    }

    private static function addFilterQuery($rules) {
        $query = '';

        $hasBeenFiltered = 0;

        if (is_array($rules['id'])) {
            $query .= ' WHERE (';

            foreach ($rules['id'] as $key => $value) {
                if ($key) {
                    $query .= ' OR ' . self::$table . 'id = :id' . $key;
                } else {
                    $query .= self::$table . '.id = :id' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_array($rules['employeeId'])) {
            $query .= $hasBeenFiltered ? ' AND (' : ' WHERE (';

            foreach ($rules['employeeId'] as $key => $value) {
                if ($key) {
                    $query .= ' OR ' . self::$table . '.employeeId = :employeeId' . $key;
                } else {
                    $query .= self::$table . '.employeeId = :employeeId' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_array($rules['designationId'])) {
            $query .= $hasBeenFiltered ? ' AND (' : ' WHERE (';

            foreach ($rules['designationId'] as $key => $value) {
                if ($key) {
                    $query .= ' OR ' . self::$table . '.designationId = :designationId' . $key;
                } else {
                    $query .= self::$table . '.designationId = :designationId' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_string($rules['keyword'])) {
            $query .= $hasBeenFiltered ? ' AND (employees.name LIKE :keyword OR employees.registrationNumber LIKE :keyword OR employees.email LIKE :keyword OR employees.phone LIKE :keyword OR designations.name LIKE :keyword OR title LIKE :keyword)'
                                    : ' WHERE (employees.name LIKE :keyword OR employees.registrationNumber LIKE :keyword OR employees.email LIKE :keyword OR employees.phone LIKE :keyword OR designations.name LIKE :keyword OR title LIKE :keyword)';

            $hasBeenFiltered = 1;
        }

        if (is_numeric($rules['startCreatedAt']) && is_numeric($rules['endCreatedAt'])) {
            $query .= $hasBeenFiltered ?
                        ' AND (' . self::$table . '.createdAt BETWEEN ' . $rules['startCreatedAt'] . ' AND ' . $rules['endCreatedAt'] . ')':
                        ' WHERE (' . self::$table . '.createdAt BETWEEN ' . $rules['startCreatedAt'] . ' AND ' . $rules['endCreatedAt'] . ')';
                    
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

        if (is_numeric($rules['startDate']) && is_numeric($rules['endDate'])) {
            $query .= $hasBeenFiltered ?
                        ' AND (' . self::$table . '.date BETWEEN ' . $rules['startDate'] . ' AND ' . $rules['endDate'] . ')':
                        ' WHERE (' . self::$table . '.date BETWEEN ' . $rules['startDate'] . ' AND ' . $rules['endDate'] . ')';
                    
            $hasBeenFiltered = 1;
        } else {
            if (is_numeric($rules['startDate'])) {
                $query .= $hasBeenFiltered
                            ? ' AND ' . self::$table . '.date >= ' . $rules['startDate']
                            : ' WHERE ' . self::$table . '.date >= ' . $rules['startDate'];
            }

            if (is_numeric($rules['endDate'])) {
                $query .= $hasBeenFiltered
                            ? ' AND ' . self::$table . '.date >= ' . $rules['endDate']
                            : ' WHERE ' . self::$table . '.date >= ' . $rules['endDate'];
            }
        }

        return $query;
    }

    private static function addFilterParams($rules) {
        if (is_string($rules['keyword'])) {
            parent::setParameter(':keyword', '%' . $rules['keyword'] . '%');
        }

        if (is_array($rules['id'])) {
            foreach ($rules['id'] as $key => $value) {
                parent::setParameter(':id' . $key, $value);
            }
        }

        if (is_array($rules['employeeId'])) {
            foreach ($rules['employeeId'] as $key => $value) {
                parent::setParameter(':employeeId' . $key, $value);
            }
        }

        if (is_array($rules['designationId'])) {
            foreach ($rules['designationId'] as $key => $value) {
                parent::setParameter(':designationId' . $key, $value);
            }
        }
    }

    private static function addRelationQuery() {
        return '
            INNER JOIN
                employees
            ON
                ' . self::$table . '.employeeId = employees.id
            INNER JOIN
                designations
            ON
                ' . self::$table . '.designationId = designations.id
        ';
    }
}
