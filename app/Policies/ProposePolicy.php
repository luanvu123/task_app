<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Propose;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProposePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any proposes.
     */
    public function viewAny(User $user): bool
    {
        // Users can view proposes if they have permission or are in management roles
        return $user->hasPermissionTo('view-proposes') ||
            $user->hasRole(['admin', 'manager', 'department_head']);
    }

    /**
     * Determine whether the user can view the propose.
     */
    public function view(User $user, Propose $propose): bool
    {
        // Admin can view all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Users can view their own proposes
        if ($propose->proposed_by === $user->id) {
            return true;
        }

        // Department heads can view proposes from their department
        if (
            $user->hasRole('department_head') &&
            $user->department_id === $propose->department_id
        ) {
            return true;
        }

        // Project managers can view proposes from their projects
        if (
            $user->hasRole('project_manager') &&
            $user->projects()->where('projects.id', $propose->project_id)->exists()
        ) {
            return true;
        }

        // Reviewers and approvers can view proposes they need to act on
        if (
            $user->hasPermissionTo('review-proposes') ||
            $user->hasPermissionTo('approve-proposes')
        ) {
            return in_array($propose->status, [
                Propose::STATUS_SUBMITTED,
                Propose::STATUS_UNDER_REVIEW,
                Propose::STATUS_PENDING_APPROVAL
            ]);
        }

        return false;
    }

    /**
     * Determine whether the user can create proposes.
     */
    public function create(User $user): bool
    {
        // Users with create permission can create proposes
        return $user->hasPermissionTo('create-proposes') ||
            $user->hasRole(['employee', 'team_lead', 'department_head']);
    }

    /**
     * Determine whether the user can update the propose.
     */
    public function update(User $user, Propose $propose): bool
    {
        // Cannot update if propose is already approved, rejected, or completed
        if (
            in_array($propose->status, [
                Propose::STATUS_APPROVED,
                Propose::STATUS_PARTIALLY_APPROVED,
                Propose::STATUS_REJECTED,
                Propose::STATUS_COMPLETED,
                Propose::STATUS_CANCELLED
            ])
        ) {
            return false;
        }

        // Admin can update any propose
        if ($user->hasRole('admin')) {
            return true;
        }

        // Users can update their own proposes in draft or submitted status
        if ($propose->proposed_by === $user->id) {
            return in_array($propose->status, [
                Propose::STATUS_DRAFT,
                Propose::STATUS_SUBMITTED
            ]);
        }

        // Department heads can update proposes from their department
        if (
            $user->hasRole('department_head') &&
            $user->department_id === $propose->department_id &&
            in_array($propose->status, [
                Propose::STATUS_DRAFT,
                Propose::STATUS_SUBMITTED
            ])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the propose.
     */
    public function delete(User $user, Propose $propose): bool
    {
        // Cannot delete if propose has been reviewed or approved
        if (
            !in_array($propose->status, [
                Propose::STATUS_DRAFT,
                Propose::STATUS_SUBMITTED
            ])
        ) {
            return false;
        }

        // Admin can delete any propose
        if ($user->hasRole('admin')) {
            return true;
        }

        // Users can delete their own proposes if in draft status
        if (
            $propose->proposed_by === $user->id &&
            $propose->status === Propose::STATUS_DRAFT
        ) {
            return true;
        }

        // Department heads can delete proposes from their department
        if (
            $user->hasRole('department_head') &&
            $user->department_id === $propose->department_id
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can review the propose.
     */
    public function review(User $user, Propose $propose): bool
    {
        // Cannot review if not in reviewable status
        if (
            !in_array($propose->status, [
                Propose::STATUS_SUBMITTED,
                Propose::STATUS_UNDER_REVIEW
            ])
        ) {
            return false;
        }

        // Admin can review any propose
        if ($user->hasRole('admin')) {
            return true;
        }

        // Users with review permission can review
        if ($user->hasPermissionTo('review-proposes')) {
            return true;
        }

        // Department heads can review proposes from their department
        if (
            $user->hasRole('department_head') &&
            $user->department_id === $propose->department_id
        ) {
            return true;
        }

        // Project managers can review proposes from their projects
        if (
            $user->hasRole('project_manager') &&
            $user->projects()->where('projects.id', $propose->project_id)->exists()
        ) {
            return true;
        }

        // Users cannot review their own proposes
        if ($propose->proposed_by === $user->id) {
            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can approve the propose.
     */
    public function approve(User $user, Propose $propose): bool
    {
        // Cannot approve if not in approvable status
        if ($propose->status !== Propose::STATUS_PENDING_APPROVAL) {
            return false;
        }

        // Admin can approve any propose
        if ($user->hasRole('admin')) {
            return true;
        }

        // Users with approve permission
        if (!$user->hasPermissionTo('approve-proposes')) {
            return false;
        }

        // Check approval limits based on total amount
        $totalAmount = $propose->total_amount;

        // Different approval limits for different roles
        if ($user->hasRole('department_head')) {
            return $totalAmount <= 100000000; // 100M VND limit
        }

        if ($user->hasRole('finance_manager')) {
            return $totalAmount <= 500000000; // 500M VND limit
        }

        if ($user->hasRole('Giám đốc')) {
            return $totalAmount <= 1000000000; // 1B VND limit
        }

        if ($user->hasRole('ceo')) {
            return true; // No limit for CEO
        }

        // Users cannot approve their own proposes
        if ($propose->proposed_by === $user->id) {
            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can submit the propose.
     */
    public function submit(User $user, Propose $propose): bool
    {
        // Can only submit draft proposes
        if ($propose->status !== Propose::STATUS_DRAFT) {
            return false;
        }

        // Must be the proposer or have permission
        return $propose->proposed_by === $user->id ||
            $user->hasRole(['admin', 'department_head']);
    }

    /**
     * Determine whether the user can cancel the propose.
     */
    public function cancel(User $user, Propose $propose): bool
    {
        // Cannot cancel approved or completed proposes
        if (
            in_array($propose->status, [
                Propose::STATUS_APPROVED,
                Propose::STATUS_PARTIALLY_APPROVED,
                Propose::STATUS_COMPLETED,
                Propose::STATUS_CANCELLED
            ])
        ) {
            return false;
        }

        // Admin can cancel any propose
        if ($user->hasRole('admin')) {
            return true;
        }

        // Proposer can cancel their own propose
        if ($propose->proposed_by === $user->id) {
            return true;
        }

        // Department head can cancel proposes from their department
        if (
            $user->hasRole('department_head') &&
            $user->department_id === $propose->department_id
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can export proposes.
     */
    public function export(User $user): bool
    {
        return $user->hasPermissionTo('export-proposes') ||
            $user->hasRole(['admin', 'manager', 'finance_manager']);
    }

    /**
     * Determine whether the user can view propose statistics.
     */
    public function viewStatistics(User $user): bool
    {
        return $user->hasPermissionTo('view-statistics') ||
            $user->hasRole(['admin', 'manager', 'department_head', 'finance_manager']);
    }

    /**
     * Determine whether the user can manage vendors in proposes.
     */
    public function manageVendors(User $user): bool
    {
        return $user->hasPermissionTo('manage-vendors') ||
            $user->hasRole(['admin', 'procurement_manager']);
    }

    /**
     * Determine whether the user can view financial details.
     */
    public function viewFinancials(User $user, Propose $propose): bool
    {
        // Admin and finance roles can view all financial details
        if ($user->hasRole(['admin', 'finance_manager', 'accounting'])) {
            return true;
        }

        // Proposer can view their own propose financials
        if ($propose->proposed_by === $user->id) {
            return true;
        }

        // Department head can view financials for their department
        if (
            $user->hasRole('department_head') &&
            $user->department_id === $propose->department_id
        ) {
            return true;
        }

        // Project manager can view financials for their projects
        if (
            $user->hasRole('project_manager') &&
            $user->projects()->where('projects.id', $propose->project_id)->exists()
        ) {
            return true;
        }

        return false;
    }

    /**
     * Helper method to check if user can perform bulk operations
     */
    public function bulkAction(User $user): bool
    {
        return $user->hasRole(['admin', 'manager']) ||
            $user->hasPermissionTo('bulk-propose-actions');
    }
}
