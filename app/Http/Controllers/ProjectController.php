<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
       function __construct()
    {
        $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index','show']]);
        $this->middleware('permission:project-create', ['only' => ['create','store']]);
        $this->middleware('permission:project-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:project-delete', ['only' => ['destroy']]);
        $this->middleware('permission:project-list', ['only' => ['getProjectsByStatus']]);
    }

    public function index()
    {
        $projects = Project::with(['department', 'manager', 'members'])->get();
        $departments = Department::all();
        $users = User::all();

        return view('projects.index', compact('projects', 'departments', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $users = User::all();

        return view('projects.create', compact('departments', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'priority' => 'required|in:' . implode(',', array_keys(Project::getPriorities())),
            'description' => 'nullable|string',
            'notification_sent' => 'required|in:' . Project::NOTIFICATION_DEPARTMENT_HEAD . ',' . Project::NOTIFICATION_ALL,
            'manager_id' => 'required|exists:users,id',
            'member_ids' => 'array',
            'member_ids.*' => 'exists:users,id',
            'images' => 'array',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:2048'
        ]);

        // Handle file uploads
        $imageAndDocument = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('projects', 'public');
                $imageAndDocument[] = $path;
            }
        }

        $project = Project::create([
            'name' => $validated['name'],
            'department_id' => $validated['department_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'budget' => $validated['budget'] ?? 0,
            'priority' => $validated['priority'],
            'description' => $validated['description'],
            'notification_sent' => $validated['notification_sent'],
            'manager_id' => $validated['manager_id'],
            'image_and_document' => $imageAndDocument,
            'status' => Project::STATUS_PLANNING
        ]);

        // Attach members
        if (!empty($validated['member_ids'])) {
            $project->members()->attach($validated['member_ids'], [
                'role' => 'member',
                'joined_at' => now()
            ]);
        }

        return redirect()->route('projects.index')
                        ->with('success', 'Dự án đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['department', 'manager', 'members']);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $departments = Department::all();
        $users = User::all();
        $project->load(['department', 'manager', 'members']);

        return view('projects.edit', compact('project', 'departments', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'priority' => 'required|in:' . implode(',', array_keys(Project::getPriorities())),
            'status' => 'required|in:' . implode(',', array_keys(Project::getStatuses())),
            'description' => 'nullable|string',
            'notification_sent' => 'required|in:' . Project::NOTIFICATION_DEPARTMENT_HEAD . ',' . Project::NOTIFICATION_ALL,
            'manager_id' => 'required|exists:users,id',
            'member_ids' => 'array',
            'member_ids.*' => 'exists:users,id',
            'images' => 'array',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:2048'
        ]);

        // Handle file uploads
        $imageAndDocument = $project->image_and_document ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('projects', 'public');
                $imageAndDocument[] = $path;
            }
        }

        $project->update([
            'name' => $validated['name'],
            'department_id' => $validated['department_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'budget' => $validated['budget'] ?? 0,
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'description' => $validated['description'],
            'notification_sent' => $validated['notification_sent'],
            'manager_id' => $validated['manager_id'],
            'image_and_document' => $imageAndDocument
        ]);

        // Sync members
        $memberData = [];
        if (!empty($validated['member_ids'])) {
            foreach ($validated['member_ids'] as $memberId) {
                $memberData[$memberId] = [
                    'role' => 'member',
                    'joined_at' => $project->members()->where('user_id', $memberId)->exists()
                                    ? $project->members()->where('user_id', $memberId)->first()->pivot->joined_at
                                    : now()
                ];
            }
        }
        $project->members()->sync($memberData);

        return redirect()->route('projects.index')
                        ->with('success', 'Dự án đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Delete associated files
        if ($project->image_and_document) {
            foreach ($project->image_and_document as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        // Detach members
        $project->members()->detach();

        // Delete project
        $project->delete();

        return redirect()->route('projects.index')
                        ->with('success', 'Dự án đã được xóa thành công!');
    }

    /**
     * Get projects by status for AJAX
     */
    public function getProjectsByStatus($status = null)
    {
        $query = Project::with(['department', 'manager', 'members']);

        if ($status && $status !== 'all') {
            $query->byStatus($status);
        }

        $projects = $query->get();

        return response()->json($projects);
    }
}
