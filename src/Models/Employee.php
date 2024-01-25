<?php

namespace Src\Models;

use Src\Systems\Model;

class Employee extends Model
{
    static $table = 'employees',
            $columns = 'id, registrationNumber, designationId,
                name, phone, email, dateOfBirth, gender, address,
                dateOfBirth, bankAccountHolderName, bankAccountNumber,
                bankName, createdAt, updatedAt';

    static function get($rules) {
        $query = 'SELECT ';

        foreach ($rules['select'] as $key => $value) {
            if ($key) {
                $query .= ', ' . self::$table . '.' . $value;
            } else {
                $query .= self::$table . '.' . $value;
            }
        }

        $query .= ' FROM ' . self::$table . self::addRelationQuery()
                    . ' GROUP BY ' . self::$table . '.id ORDER BY '
                    . $rules['orderBy'] . ' ' . $rules['orderDirection']
                    . ' LIMIT ' . $rules['limit'] . ' OFFSET ' . $rules['offset'];

        parent::setQuery($query);

        self::addParameterQuery($rules);

        return parent::getList();
    }

    static function count($rules) {
        $query = 'SELECT ' . self::$table . '.id FROM '
                    . self::$table . self::addRelationQuery()
                    . self::addFilterQuery($rules)
                    . ' GROUP BY ' . self::$table . '.id';

        parent::setQuery($query);

        self::addParameterQuery($rules);

        return parent::executeAndCountRow();
    }

    private static function addRelationQuery() {
        return '
            INNER JOIN
                designations
            ON
                ' . self::$table . '.designationId = designations.id
            LEFT JOIN
                promotions
            ON
                ' . self::$table . '.id = promotions.employeeId
            LEFT JOIN
                resignations
            ON
                ' . self::$table . '.id = resignations.employeeId
            LEFT JOIN
                terminations
            ON
                ' . self::$table . '.id = terminations.employeeId
            LEFT JOIN
                transfers
            ON
                ' . self::$table . '.id = transfers.employeeId
        ';
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

        if (is_numeric($rules['status'])) {
            if ($rules['status'] === '1') {
                $query .= $hasBeenFiltered
                            ? ' AND ((terminations.id IS NULL AND resignations.id IS NULL)
                                OR (transfers.date IS NOT NULL AND ((resignations.date IS NOT NULL AND transfers.date > resignations.date)
                                OR (terminations.date IS NOT NULL AND transfers.date > terminations.date))))'
                            : ' WHERE ((terminations.id IS NULL AND resignations.id IS NULL)
                                OR (transfers.date IS NOT NULL AND ((resignations.date IS NOT NULL AND transfers.date > resignations.date)
                                OR (terminations.date IS NOT NULL AND transfers.date > terminations.date))))';
            } else if ($rules['status'] === '2') {
                $query .= $hasBeenFiltered
                            ? ' AND (terminations.id IS NOT NULL OR resignations.id IS NOT NULL)
                                AND (transfers.date IS NULL OR (transfers.date < terminations.date AND transfers.date < resignations.date))'
                            : ' WHERE (terminations.id IS NOT NULL OR resignations.id IS NOT NULL)
                                AND (transfers.date IS NULL OR (transfers.date < terminations.date AND transfers.date < resignations.date))';
            }
        }


        if (is_string($rules['designationId'])) {
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
            $query .= $hasBeenFiltered
                        ? ' AND (' . self::$table . '.name LIKE :keyword, '
                            . self::$table . '.registrationNumber LIKE :keyword, '
                            . self::$table . '.phone LIKE :keyword, '
                            . self::$table . '.email LIKE :keyword, '
                            . self::$table . '.address LIKE :keyword, '
                            . self::$table . '.bankAccountHolderName LIKE :keyword, '
                            . self::$table . '.bankAccountNumber LIKE :keyword, '
                            . self::$table . '.bankName, designations.name LIKE :keyword)'
                        : ' WHERE (' . self::$table . '.name LIKE :keyword, '
                            . self::$table . '.registrationNumber LIKE :keyword, '
                            . self::$table . '.phone LIKE :keyword, '
                            . self::$table . '.email LIKE :keyword, '
                            . self::$table . '.address LIKE :keyword, '
                            . self::$table . '.bankAccountHolderName LIKE :keyword, '
                            . self::$table . '.bankAccountNumber LIKE :keyword, '
                            . self::$table . '.bankName, designations.name LIKE :keyword)';

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

    private static function addParameterQuery($rules) {
        if (is_string($rules['keyword'])) {
            parent::setParameter(':keyword', '%' . $rules['keyword'] . '%');
        }

        if (is_array($rules['id'])) {
            foreach ($rules['id'] as $key => $value) {
                parent::setParameter(':id' . $key, $value);
            }
        }

        if (is_string($rules['designationId'])) {
            foreach ($rules['designationId'] as $key => $value) {
                parent::setParameter(':designationId' . $key, $value);
            }
        }
    }

    static function insertWithDocuments($data) {
        parent::beginTransaction();

        $employeeData = $data;

        unset($employeeData['employeeDocuments']);

        parent::setQueryByNumber('
            INSERT INTO ' . self::$table. '
            (
                id, designationId, registrationNumber, name,
                phone, email, dateOfBirth, gender, address,
                dateOfJoin, bankAccountHolderName,
                bankAccountNumber, bankName, createdAt, updatedAt
            ) VALUES (
                :id, :designationId, :registrationNumber, :name,
                :phone, :email, :dateOfBirth, :gender, :address,
                :dateOfJoin, :bankAccountHolderName,
                :bankAccountNumber, :bankName, :createdAt, :updatedAt
            )
        ', 1);

        parent::executeByNumber(1, $employeeData);

        $employeeDocumentQuery = '
            INSERT INTO employee_documents
            (
                id, employeeId, documentId,
                file, createdAt, updatedAt
            ) VALUES
        ';

        $employeeDocumentData = $data['employeeDocuments'];

        $index = 0;

        foreach ($employeeDocumentData as $key => $value) {
            $employeeDocumentQuery .= $index ? '
                , (
                    :id' . $key . ', :employeeId' . $key . ',
                    :documentId' . $key . ', :file' . $key . ',
                    ' . $value['createdAt'] . ', ' . $value['updatedAt'] . ' 
                )
            ' : '
                (
                    :id' . $key . ', :employeeId' . $key . ',
                    :documentId' . $key . ', :file' . $key . ',
                    ' . $value['createdAt'] . ', ' . $value['updatedAt'] . ' 
                )   
            ';

            $index++;
        }

        parent::setQueryByNumber($employeeDocumentQuery, 2);

        foreach ($employeeDocumentData as $key => $value) {
            parent::setParameterByQuery(2, ':id' . $key, $value['id']);
            parent::setParameterByQuery(2, ':employeeId' . $key, $value['employeeId']);
            parent::setParameterByQuery(2, ':documentId' . $key, $value['documentId']);
            parent::setParameterByQuery(2, ':file' . $key, $value['file']);
        }

        parent::executeByNumber(2);

        parent::commit();
    }
}
