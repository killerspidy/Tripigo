<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Admin: all tasks. Employee: only tasks assigned to them.
     */
    public function index()
    {
        $query = Task::with(['assignee', 'creator'])->latest();

        if (auth()->user()->hasRole('employee')) {
            $query->where('assigned_to', auth()->id());
        }

        $tasks = $query->paginate(15);
        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Only admin can create tasks. Assignable users = employees only.
     */
    public function create()
    {
        $users = User::role('employee')->orderBy('name')->get(['id', 'name', 'email']);
        return view('admin.tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $assignee = User::find($request->assigned_to);
        if (!$assignee->hasRole('employee')) {
            return back()->withInput()->withErrors(['assigned_to' => 'You can only assign tasks to users with the employee role.']);
        }

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created and assigned successfully.');
    }

    /**
     * Admin: edit any task, assign to employees only. Employee: edit only their assigned task (e.g. status).
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        if (auth()->user()->hasRole('employee')) {
            if ($task->assigned_to !== auth()->id()) {
                abort(403, 'You can only edit tasks assigned to you.');
            }
        }

        $users = User::role('employee')->orderBy('name')->get(['id', 'name', 'email']);
        return view('admin.tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if (auth()->user()->hasRole('employee')) {
            if ($task->assigned_to !== auth()->id()) {
                abort(403, 'You can only update tasks assigned to you.');
            }
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        if (auth()->user()->hasRole('admin')) {
            $assignee = User::find($request->assigned_to);
            if (!$assignee->hasRole('employee')) {
                return back()->withInput()->withErrors(['assigned_to' => 'You can only assign tasks to users with the employee role.']);
            }
        } else {
            $request->merge(['assigned_to' => $task->assigned_to]);
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Admin: delete any task. Employee: delete only their assigned task (if allowed by permission).
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if (auth()->user()->hasRole('employee')) {
            if ($task->assigned_to !== auth()->id()) {
                abort(403, 'You can only delete tasks assigned to you.');
            }
        }

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
