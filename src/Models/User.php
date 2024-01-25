<?php

namespace Src\Models;

use Src\Helpers\TimeHelper;
use Src\Systems\Model;

class User extends Model
{
    static $table = 'users',
        $columns = 'id, email, name, role, status, createdAt, updatedAt';

    static function count($rules) {
        $query ='SELECT COUNT(id) AS total FROM ' . self::$table . '';

        $query .= self::addFilterQuery($rules);

        parent::setQuery($query);

        self::addFilterParams($rules);

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

        $query .= ' FROM ' . self::$table . self::addFilterParams($rules)
                    . ' ORDER BY ' . $rules['orderBy'] . ' ' . $rules['orderDirection'] .
                    ' LIMIT ' . $rules['limit'] . ' OFFSET ' . $rules['offset'];

        $query .= self::addFilterQuery($rules);

        parent::setQuery($query);

        self::addFilterParams($rules);

        return parent::getList();
    }

    static function getWithoutPemilik($rules) {
        $query ='SELECT ';

        foreach ($rules['select'] as $key => $value) {
            if ($key) {
                $query .= ', ' . $value;
            } else {
                $query .= $value;
            }
        }

        $filterQuery = self::addFilterQuery($rules);

        $query .= ' FROM ' . self::$table . $filterQuery
                    . self::addWithoutPemilikQuery($filterQuery === '' ? 0 : 1)
                    . ' ORDER BY ' . $rules['orderBy'] . ' ' . $rules['orderDirection']
                    . ' LIMIT ' . $rules['limit'] . ' OFFSET ' . $rules['offset'];

        $query .= self::addFilterQuery($rules);

        parent::setQuery($query);

        self::addFilterParams($rules);

        return parent::getList();
    }

    private static function addWithoutPemilikQuery($hasBeenFilter) {
        return $hasBeenFilter
                ? ' AND role != "Pemilik" '
                : ' WHERE role != "Pemilik" ';
    }

    private static function addFilterQuery($rules) {
        $query = '';

        $hasBeenFiltered = 0;

        if (is_numeric($rules['status'])) {
            $query .= ' WHERE status = ' . $rules['status'];

            $hasBeenFiltered = 1;
        }

        if (is_array($rules['id'])) {
            $query .= $hasBeenFiltered ? ' AND (' : ' WHERE (';

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

        if (is_string($rules['role'])) {
            $query .= $hasBeenFiltered ? ' AND role = "' . $rules['role'] . '"' :
                                    ' WHERE role = "' . $rules['role'] . '"';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_string($rules['keyword'])) {
            $query .= $hasBeenFiltered ? ' AND (email LIKE :keyword OR name LIKE :keyword)'
                                    : ' WHERE (email LIKE :keyword OR name LIKE :keyword)';

            $hasBeenFiltered = 1;
        }

        if (is_numeric($rules['startCreatedAt']) && is_numeric($rules['endCreatedAt'])) {
            $query .= $hasBeenFiltered ?
                        ' AND createdAt BETWEEN ' . $rules['startCreated_at'] . ' AND ' . $rules['endCreatedAt'] :
                        ' WHERE createdAt BETWEEN ' . $rules['startCreated_at'] . ' AND ' . $rules['endCreatedAt'];
                    
            $hasBeenFiltered = 1;
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

    private static function addFilterParams($rules) {
        if (is_string($rules['keyword'])) {
            $rules['keyword'] = '%' . $rules['keyword'] . '%';
            parent::setParameter(':keyword', $rules['keyword']);
        }

        if (is_array($rules['id'])) {
            foreach ($rules['id'] as $key => $value) {
                parent::setParameter(':id' . $key, $value);
            }
        }
    }

    static function updateProfile($id, $data) {
        $now = TimeHelper::createTimeNow();

        self::updateOne(
            self::$table,
            'email = :email, name = :name, updatedAt = ' . $now,
            'id = :id',
            [
                ':email' => $data['email'],
                ':name' => $data['name'],
                ':id' => $id
            ]
        );

        return $now;
    }

    static function updatePassword($id, $password) {
        $now = TimeHelper::createTimeNow();

        self::updateOne(
            self::$table,
            'password = "' . $password . '", updatedAt = ' . $now,
            'id = :id',
            [
                ':id' => $id
            ]
        );

        return $now;
    }
}
