<?php

namespace Src\Routes;

use Src\Routes\Owner\Application;
use Src\Routes\Owner\Branches;
use Src\Routes\Owner\Departments;
use Src\Routes\Owner\Designations;
use Src\Routes\Owner\Documents;
use Src\Routes\Owner\EmployeeDocuments;
use Src\Routes\Owner\Employees;
use Src\Routes\Owner\DocumentTypes;
use Src\Routes\Owner\Profile;
use Src\Routes\Owner\Promotions;
use Src\Routes\Owner\Resignations;
use Src\Routes\Owner\Terminations;
use Src\Routes\Owner\TerminationTypes;
use Src\Routes\Owner\Transfers;
use Src\Routes\Owner\Users;
use Src\Routes\Owner\WorkHistories;

class Owner
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
            'path' => 'owner',
            'list' => $list
        ];
    }
}
