<?php

namespace Src\Models;

use Src\Configurations\Environment;
use Src\Helpers\TimeHelper;
use Src\Systems\Model;

class EmployeeDocument extends Model
{
    static $table = 'employee_documents';

    static function getColumns() {
        return 'id, employeeId, documentId, ' . self::addFileColumn() . ', createdAt, updatedAt';
    }

    private static function addFileColumn() {
        return 'CONCAT("' . Environment::$value['baseURL'] . '", "employee-documents/", id, "/open") AS file';
    }

    static function count($input) {
        $query = 'SELECT COUNT(id) AS total FROM ' . self::$table
                    . self::addFilterQuery($input);

        parent::setQuery($query);

        self::addParameterQuery($input);

        return parent::countRow();
    }

    static function get($input) {
        $query ='SELECT ';

        foreach ($input['select'] as $key => $value) {
            if ($value === 'file') {
                if ($key) {
                    $query .= ', ' . self::addFileColumn();
                } else {
                    $query .= self::addFileColumn();
                }    

                continue;
            }

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

        self::addParameterQuery($input);

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

        if (is_string($input['employeeId'])) {
            $query .= $hasBeenFiltered ? ' AND (' : ' WHERE (';

            foreach ($input['employeeId'] as $key => $value) {
                if ($key) {
                    $query .= ' OR employeeId = :employeeId' . $key;
                } else {
                    $query .= 'employeeId = :employeeId' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_string($input['documentId'])) {
            $query .= $hasBeenFiltered ? ' AND (' : ' WHERE (';

            foreach ($input['documentId'] as $key => $value) {
                if ($key) {
                    $query .= ' OR documentId = :documentId' . $key;
                } else {
                    $query .= 'documentId = :documentId' . $key;
                }
            }

            $query .= ')';
                                        
            $hasBeenFiltered = 1;
        }

        if (is_string($input['keyword'])) {
            $query .= $hasBeenFiltered ? ' AND (id LIKE :keyword OR employeeId LIKE :keyword OR documentId LIKE :keyword)'
                                    : ' WHERE (id LIKE :keyword OR employeeId LIKE :keyword OR documentId LIKE :keyword)';

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

    private static function addParameterQuery($input) {
        if (is_string($input['keyword'])) {
            parent::setParameter(':keyword', '%' . $input['keyword'] . '%');
        }

        if (is_array($input['id'])) {
            foreach ($input['id'] as $key => $value) {
                parent::setParameter(':id' . $key, $value);
            }
        }

        if (is_string($input['employeeId'])) {
            foreach ($input['employeeId'] as $key => $value) {
                parent::setParameter(':employeeId' . $key, $value);
            }
        }

        if (is_string($input['documentId'])) {
            foreach ($input['documentId'] as $key => $value) {
                parent::setParameter(':documentId' . $key, $value);
            }
        }
    }

    static function getWithDocumentById($id) {
        parent::setQuery(
            'SELECT
                ' . self::$table . '.id, ' . self::$table . '.employeeId,
                ' . self::$table . '.documentId, ' . self::$table . '.file,
                ' . Document::$table . '.name, ' . Document::$table . '.mime
            FROM
                ' . self::$table . '
            INNER JOIN
                ' . Document::$table . '
            ON
                ' . self::$table . '.documentId = ' . Document::$table . '.id
            WHERE
                ' . self::$table . '.id = :id
            LIMIT 1'
        );

        parent::setParameter(':id', $id);

        return parent::getOne();
    }

    static function getNotRequiredById($id, $select = 'employee_documents.id') {
        parent::setQuery('
            SELECT
                ' . $select . '
            FROM
                ' . self::$table . '
            INNER JOIN
                documents
            ON
                ' . self::$table . '.documentId = documents.id
            WHERE 
                ' . self::$table . '.id = :id
            AND
                documents.status = 0        
            LIMIT 1
        ');

        parent::setParameter(':id', $id);

        return parent::getOne();
    }

    static function getOneByEmployeeAndDocument($employeeId, $documentId, $select = 'employee_documents.id') {
        parent::setQuery('
            SELECT
                ' . $select . '
            FROM
                ' . self::$table . '
            WHERE 
                employeeId = :employeeId
            AND
                documentId = :documentId
            LIMIT 1
        ');

        parent::setParameter(':employeeId', $employeeId);
        parent::setParameter(':documentId', $documentId);

        return parent::getOne();
    }

    static function getOneByEmployeeAndDocumentWithoutSomeId($employeeId, $documentId, $id, $select = 'employee_documents.id') {
        parent::setQuery('
            SELECT
                ' . $select . '
            FROM
                ' . self::$table . '
            WHERE 
                employeeId = :employeeId
            AND
                documentId = :documentId
            AND id != :id
            LIMIT 1
        ');

        parent::setParameter(':employeeId', $employeeId);
        parent::setParameter(':documentId', $documentId);
        parent::setParameter(':id', $id);

        return parent::getOne();
    }
}
