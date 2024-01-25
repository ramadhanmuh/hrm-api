<?php

namespace Src\Routes;

use Src\Routes\Employee\Branches;
use Src\Routes\Employee\Departments;
use Src\Routes\Employee\Designations;
use Src\Routes\Employee\Documents;
use Src\Routes\Employee\EmployeeDocuments;
use Src\Routes\Employee\Employees;
use Src\Routes\Employee\DocumentTypes;
use Src\Routes\Employee\Profile;
use Src\Routes\Employee\Promotions;
use Src\Routes\Employee\Resignations;
use Src\Routes\Employee\Terminations;
use Src\Routes\Employee\TerminationTypes;
use Src\Routes\Employee\Transfers;
use Src\Routes\Employee\WorkHistories;

class Employee
{
    function getList() {
        $list[] = Profile::$list;
        $list[] = Branches::$list;
        $list[] = TerminationTypes::$list;
        $list[] = Departments::$list;
        $list[] = Designations::$list;
        $list[] = Documents::$list;
        $list[] = Employees::$list;
        $list[] = EmployeeDocuments::$list;
        $list[] = DocumentTypes::$list;
        $list[] = Transfers::$list;
        $list[] = Promotions::$list;
        $list[] = Resignations::$list;
        $list[] = Terminations::$list;
        $list[] = WorkHistories::$list;

        return [
            'path' => 'employee',
            'list' => $list
        ];
    }
}
