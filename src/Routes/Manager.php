<?php

namespace Src\Routes;

use Src\Routes\Manager\Application;
use Src\Routes\Manager\Branches;
use Src\Routes\Manager\Departments;
use Src\Routes\Manager\Designations;
use Src\Routes\Manager\Documents;
use Src\Routes\Manager\EmployeeDocuments;
use Src\Routes\Manager\Employees;
use Src\Routes\Manager\DocumentTypes;
use Src\Routes\Manager\Profile;
use Src\Routes\Manager\Promotions;
use Src\Routes\Manager\Resignations;
use Src\Routes\Manager\Terminations;
use Src\Routes\Manager\TerminationTypes;
use Src\Routes\Manager\Transfers;
use Src\Routes\Manager\Users;
use Src\Routes\Manager\WorkHistories;

class Manager
{
    function getList() {
        $list[] = Profile::$list;
        $list[] = Users::$list;
        $list[] = Application::$list;
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
            'path' => 'manager',
            'list' => $list
        ];
    }
}
