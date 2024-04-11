<?php

namespace App\Policies;

use App\Models\JobOpportunity;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobOpportunitiesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_job_opportunities")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can("create_job_opportunities")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, JobOpportunity $jobOpportunity): bool
    {
        if ($user->can("edit_job_opportunities")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobOpportunity $jobOpportunity): bool
    {
        if ($user->can("delete_job_opportunities")) {
            return true;
        } else {
            return false;
        }
    }

    public function changeStatus(User $user, JobOpportunity $jobOpportunity): bool
    {
        if ($user->can("change_status_job_opportunities")) {
            return true;
        } else {
            return false;
        }
    }

    public function actions(User $user, JobOpportunity $jobOpportunity): bool
    {
        if ($user->can("actions_job_requests_job_opportunities")) {
            return true;
        } else {
            return false;
        }
    }
}
