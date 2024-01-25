<?php

namespace Src\Models;

use Src\Systems\Model;

class Document extends Model
{
    static $table = 'documents',
        $columns = 'id, name, status, mime, createdAt, updatedAt';

    static function count($rules) {
        $query = 'SELECT COUNT(id) AS total FROM ' . self::$table
                    . self::addFilterQuery($rules);

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

        $query .= ' FROM ' . self::$table . self::addFilterQuery($rules)
                    . ' ORDER BY ' . $rules['orderBy'] . ' ' . $rules['orderDirection'] .
                    ' LIMIT ' . $rules['limit'] . ' OFFSET ' . $rules['offset'];

        parent::setQuery($query);

        self::setFilterParameter($rules);

        return parent::getList();
    }

    static function getAll() {
        parent::setQuery('
            SELECT
                id, name, status, mime
            FROM
                ' . self::$table . '
        ');

        return parent::getList();
    }

    private static function addFilterQuery($rules) {
        $query = '';

        $hasBeenFiltered = 0;

        if ($rules['id']) {
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

        if (is_string($rules['status'])) {
            $query .= $hasBeenFiltered
                            ? ' AND status = ' . $rules['status']
                            : ' WHERE status = ' . $rules['status'];

            $hasBeenFiltered = 1;
        }

        if (is_string($rules['keyword'])) {
            $query .= $hasBeenFiltered ? ' AND name LIKE :keyword'
                                    : ' WHERE name LIKE :keyword';

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

    private static function setFilterParameter($rules) {
        if (is_string($rules['keyword'])) {
            parent::setParameter(':keyword', $rules['keyword']);
        }

        if (is_array($rules['id'])) {
            foreach ($rules['id'] as $key => $value) {
                parent::setParameter(':id' . $key, $value);
            }
        }
    }
}
