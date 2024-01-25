<?php

namespace Src\Models;

use Src\Systems\Model;

class WorkHistory extends Model
{
    static $table = 'work_histories',
            $columns = 'id, employeeId, dateOfJoin, createdAt, updatedAt';

    static function get($rules) {
        $orderColumns = [
            'id' => self::$table . '.id',
            'employeeId' => self::$table . '.employeeId',
            'dateOfJoin' => self::$table . '.dateOfJoin',
            'createdAt' => self::$table . '.createdAt',
            'updatedAt' => self::$table . '.updatedAt',
            'employeeName' => Employee::$table . '.name',
            'employeeRegistrationNumber' => Employee::$table . '.registrationNumber',
            'employeeEmail' => Employee::$table . '.email'
        ];

        $query ='SELECT ';

        foreach ($rules['select'] as $key => $value) {
            if ($key) {
                $query .= ', ' . self::$table . '.' . $value;
            } else {
                $query .= self::$table . '.' . $value;
            }
        }

        $query .= ' FROM ' . self::$table . self::addRelationQuery()
                    . self::addFilterQuery($rules)
                    . ' ORDER BY ' . $orderColumns[$rules['orderBy']]
                    . ' ' . $rules['orderDirection']
                    . ' LIMIT ' . $rules['limit'] . ' OFFSET ' . $rules['offset'];

        parent::setQuery($query);

        self::addFilterParams($rules);

        return parent::getList();
    }

    static function count($rules) {
        $query = '
            SELECT
                COUNT(' . self::$table . '.id) AS  total
            FROM
                ' . self::$table
            . self::addRelationQuery()
            . self::addFilterQuery($rules);

        parent::setQuery($query);

        self::addFilterParams($rules);

        return parent::countRow();
    }

    private static function addRelationQuery() {
        return '
            INNER JOIN
                ' . Employee::$table . '
            ON
                ' . self::$table . '.employeeId = ' . Employee::$table . '.id
        ';
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

        if (is_string($rules['keyword'])) {
            $query .= $hasBeenFiltered ? ' AND (employees.name LIKE :keyword OR employees.registrationNumber LIKE :keyword OR employees.email LIKE :keyword OR employees.phone LIKE :keyword)'
                                    : ' WHERE (employees.name LIKE :keyword OR employees.registrationNumber LIKE :keyword OR employees.email LIKE :keyword OR employees.phone LIKE :keyword)';

            $hasBeenFiltered = 1;
        }

        if (is_numeric($rules['startCreatedAt']) && is_numeric($rules['endCreatedAt'])) {
            $query .= $hasBeenFiltered ?
                        ' AND (' . self::$table . '.createdAt BETWEEN ' . $rules['startCreatedAt'] . ' AND ' . $rules['endCreatedAt'] . ')' :
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

        if (is_numeric($rules['startDateOfJoin']) && is_numeric($rules['endDateOfJoin'])) {
            $query .= $hasBeenFiltered ?
                        ' AND (' . self::$table . '.date BETWEEN ' . $rules['startCreatedAt'] . ' AND ' . $rules['endDateOfJoin'] . ')' :
                        ' WHERE (' . self::$table . '.date BETWEEN ' . $rules['startCreatedAt'] . ' AND ' . $rules['endDateOfJoin'] . ')';
                    
            $hasBeenFiltered = 1;
        } else {
            if (is_numeric($rules['startDateOfJoin'])) {
                $query .= $hasBeenFiltered
                            ? ' AND ' . self::$table . '.date >= ' . $rules['startDateOfJoin']
                            : ' WHERE ' . self::$table . '.date >= ' . $rules['startDateOfJoin'];
            }

            if (is_numeric($rules['endDateOfJoin'])) {
                $query .= $hasBeenFiltered
                            ? ' AND ' . self::$table . '.date >= ' . $rules['endDateOfJoin']
                            : ' WHERE ' . self::$table . '.date >= ' . $rules['endDateOfJoin'];
            }
        }

        return $query;
    }

    private static function addFilterParams($rules) {
        if (is_string($rules['keyword'])) {
            parent::setParameter(':keyword', $rules['keyword']);
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
    }
}
