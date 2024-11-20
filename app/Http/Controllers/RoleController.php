<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Support\Collection;

class RoleController extends Controller
{
    public function __construct(
        private readonly PermissionService $permissionService,
        private readonly RoleService $roleService,
    ) {}
    public function index()
    {
        $array = [
            'labelOnly'     => __('common.role.only_trashed'),
            'labelNot'     => __('common.role.with_trashed'),
            'labelWith'      => __('common.role.not_trashed'),
        ];
        $filters = [
            'search' => request()->input('q'),
            'trashed' => request()->input('trashed', Role::WITHOUT_TRASH),
        ];
        $roles = Role::search($filters['search'])
            ->ofAccount()
            ->orderBy('id', 'desc')
            ->filterTrash($filters['trashed'])
            ->paginate();

        if (request()->ajax()) {
            return response()->view('pages.role.table_list_role', compact('roles'));
        }

        return view('pages.role.index', [
            'filters' => $filters,
            'roles' => $roles,
            'statusFilters' => Role::TrashFilters($array),
        ]);
    }

    public function create()
    {
        return view('pages.role.create');
    }

    public function store(CreateRoleRequest $request)
    {
        $this->roleService->save($request->validated());

        return to_route('roles.index')->with('success', __('common.role.created'));
    }

    public function edit(Role $role)
    {
        if ('Super Admin' == $role->name) {
            return redirect()->route('roles.index')->with('error', __('messages.role.no_modified'));
        }
        $permissions = $this->formatPermissions($this->permissionService->getAll());

        return view('pages.role.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        // update permission
        if (request()->has('type') && request()->input('type') == 'permission') {
            $role->syncPermissions();

            if (isset($validated['permissions'])) {
                $role->givePermissionTo($this->permissionService->getByIds($validated['permissions']));
            }

            return redirect()->back()->with('success', __('common.permission.updated'));
        }
        // update name
        $role->update($validated);

        return to_route('roles.index')->with('success', __('common.role.updated'));
    }

    public function destroy(Role $role)
    {
        if($role->del()){
            return redirect()->route('roles.index')->with('success', __('messages.permanent_delete.success'));
        }
        
        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
    }

    public function destroyPermanently(Role $role)
    {
        if($role->delP()){
            return redirect()->route('roles.index')->with('success', __('messages.permanent_delete.success'));
        }
        
        return redirect()->back()->with('error', __('messages.soft_delete.exception'));
    }

    public function restore(Role $role) {
        $role->restore();

        return redirect()->route('roles.index')->with('success', __('messages.restore.success'));
    }

    private function formatPermissions(array|Collection $permissions): array
    {
        $keys = [];
        $translationMap  = [
            'update'        => __('common.translation_role.update'),
            'delete'        => __('common.translation_role.delete'),
            'create'        => __('common.translation_role.create'),
            'read'          => __('common.translation_role.read'),
            'users'         => __('common.translation_role.users'),
            'roles'         => __('common.translation_role.roles'),
            'warehouses'    => __('common.translation_role.warehouses'),
            'categories'    => __('common.translation_role.categories'),
            'items'         => __('common.translation_role.items'),
            'transfers'     => __('common.translation_role.transfers'),
            'adjustments'   => __('common.translation_role.adjustments'),
            'checkins'      => __('common.translation_role.checkins'),
            'checkouts'     => __('common.translation_role.checkouts'),
            'import'        => __('common.translation_role.import'),
            'units'        => __('common.translation_role.units'),
            'contacts'        => __('common.translation_role.contacts'),
        ];
        foreach ($permissions as $permission) {
            $path = explode('-', $permission['name']);
            $key = array_pop($path);
            $translatedKey = $translationMap[$key] ?? $key;
            $translatedPermissionName = implode( ' ',array_map(function ($part) use ($translationMap ) {
                return $translationMap[$part] ?? $part;
            }, explode('-', $permission['name'])));
            $keys[$translatedKey][$permission->id] = $translatedPermissionName;
        }

        return $keys;
    }
}
