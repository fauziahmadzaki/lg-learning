<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\Package;

trait HandlesBranchScope
{
    protected function authorizeBranch(Branch $branch, $model): void
    {
        if ($model->branch_id !== $branch->id) {
            abort(403);
        }
    }

    protected function branchPackages(Branch $branch)
    {
        return Package::where('branch_id', $branch->id)->with('branch')->get();
    }

    protected function getGrades()
    {
        return \App\Models\PackageCategory::pluck('name', 'name');
    }
}
