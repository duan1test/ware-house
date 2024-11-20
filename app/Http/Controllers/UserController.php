<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\WarehouseService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly WarehouseService $warehouseService,
        private readonly RoleService $roleService,
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'search'     => $request->input('q'),
            'trashed'    => $request->input('trashed', User::WITHOUT_TRASH),
        ];
        $users = $this->userService->getAll($filters);
        
        if ($request->ajax()) {
            return response()->view('pages.user.table_list_user', compact('users','filters'));
        }
        return view('pages.user.index', [
            'users' => $users,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        $warehouses = $this->warehouseService->getByAttribute(['active' => 1])->pluck('name', 'id');
        $roles = $this->roleService->getAll()->pluck('name', 'id');

        return view('pages.user.create', compact('warehouses', 'roles'));
    }

    public function store(CreateUserRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userService->save($validated);

        if ($user) {
            $user->assignRole($this->roleService->getById($validated['role']));

            return to_route('users.index')->with('success', __('common.user.created'));
        }

        return redirect()->back()->with('error', __('errors.some_thing_went_wrong'));
    }

    public function show(User $user, Request $request)
    {
        $filters = [
            'q'         => $request->input('q'),
            'trashed'    => $request->input('trashed', User::WITHOUT_TRASH),
        ];
        $warehouses = $this->warehouseService->getByAttribute(['active' => 1])->pluck('name', 'id');
        $roles = $this->roleService->getAll()->pluck('name', 'id');

        return view('pages.user.edit', compact('user', 'roles', 'warehouses','filters'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if ($request->has('type') && $request->input('type') == 'password') {
            $user->update([
                'password' => $validated['password'],
            ]);
        } else {
            unset($validated['password']);
            unset($validated['confirm_password']);

            $user->update($validated);
            $user->syncRoles();
            $user->assignRole($this->roleService->getById($validated['role']));
        }

        return to_route('users.index')->with('success', __('common.user.updated'));
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return back()->with('error', __('errors.can_not_delete_own_account'));
        }

        if ($user->del()) {
            return to_route('users.index')->with('success', __('common.user.deleted'));
        }

        return redirect()->back()->with('error', __('errors.some_thing_went_wrong'));
    }

    public function destroyPermanently(User $user)
    {
        if($user->delP()){
            return redirect()->route('users.index')->with('success', __('messages.permanent_delete.success'));
        }
        
        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
    }

    public function restore(User $user){
        $user->restore();

        return redirect()->route('users.index')->with('success', __('messages.restore.success'));
    }
}
