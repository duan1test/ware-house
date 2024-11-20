<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <a href="/">
                <h4 class="logo-text">{{ get_settings('name') ?? __('common.app_name') }}</h4>
            </a>
        </div>
        <a href="javascript:;" class="toggle-btn ms-auto"> <i class="bx bx-menu"></i>
        </a>
    </div>
    <!--navigation-->
    <ul class="metismenu invisible" id="menu">
        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon icon-color-1 h-6 w-[26px] flex justify-center items-center">
                    <i class='bx bxs-home'></i>
                </div>
                <div class="menu-title">{{ __('common.dashboard.index') }}</div>
            </a>
        </li>

        @if (   auth()->user()->can('read-checkins') ||
                auth()->user()->can('create-checkins')
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1">
                        <i class='bx bx-log-in'></i>
                    </div>
                    <div class="menu-title">{{ __('common.checkin.title') }}</div>
                </a>
                <ul>
                    @can('read-checkins')
                        <li>
                            <a href="{{ route('checkins.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.checkin.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-checkins')
                        <li>
                            <a href="{{ route('checkins.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.checkin.create') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (   auth()->user()->can('read-checkouts') ||
                auth()->user()->can('create-checkouts')
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1">
                        <i class='bx bx-log-out'></i>
                    </div>
                    <div class="menu-title">{{ __('common.checkout.title') }}</div>
                </a>
                <ul>
                    @can('read-checkouts')
                        <li>
                            <a href="{{ route('checkouts.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.checkout.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-checkouts')
                        <li>
                            <a href="{{ route('checkouts.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.checkout.create') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (   auth()->user()->can('read-adjustments') ||
                auth()->user()->can('create-adjustments')
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1"><i class="bx bx-slider-alt"></i></i>
                    </div>
                    <div class="menu-title">{{ __('common.adjustment.title') }}</div>
                </a>
                <ul>
                    @can('read-adjustments')
                        <li>
                            <a href="{{ route('adjustments.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.adjustment.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-adjustments')
                        <li>
                            <a href="{{ route('adjustments.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.adjustment.create') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (   auth()->user()->can('read-transfers') ||
                auth()->user()->can('create-transfers')
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1"><i class='bx bxs-truck'></i>
                    </div>
                    <div class="menu-title">{{ __('common.transfer.title') }}</div>
                </a>
                <ul>
                    @can('read-transfers')
                        <li>
                            <a href="{{ route('transfers.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.transfer.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-transfers')
                        <li>
                            <a href="{{ route('transfers.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.transfer.create') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (   auth()->user()->can('read-items') ||
                auth()->user()->can('create-items')
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1"><i class='bx bxs-store-alt'></i>
                    </div>
                    <div class="menu-title">{{ __('common.items.title') }}</div>
                </a>
                <ul>
                    @can('read-items')
                        <li>
                            <a href="{{ route('items.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.items.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-items')
                        <li>
                            <a href="{{ route('items.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.items.create') }}
                            </a>
                        </li>
                    @endcan

                    @can('import-items')
                    <li>
                        <a href="{{ route('items.import') }}">
                            <i class="bx bx-right-arrow-alt"></i>
                            {{ __('common.items.import') }}
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
        @endif

        @if (   auth()->user()->can('read-contacts') ||
        auth()->user()->can('create-contacts')
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1 h-6 w-[26px] flex justify-center items-center"><i class="fa-solid fa-users"></i>
                    </div>
                    <div class="menu-title">{{ __('common.contact.title') }}</div>
                </a>
                <ul>
                    @can('read-contacts')
                        <li>
                            <a href="{{ route('contacts.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.contact.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-contacts')
                        <li>
                            <a href="{{ route('contacts.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.contact.create') }}
                            </a>
                        </li>
                    @endcan

                    @can('import-contacts')
                    <li>
                        <a href="{{ route('contacts.import') }}">
                            <i class="bx bx-right-arrow-alt"></i>
                            {{ __('common.contact.import') }}
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (   auth()->user()->can('read-categories') ||
                auth()->user()->can('create-categories') || 
                auth()->user()->can('import-categories') 
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1"><i class='bx bx-layer'></i>
                    </div>
                    <div class="menu-title">{{ __('common.category.title') }}</div>
                </a>
                <ul>
                    @can('read-categories')
                        <li>
                            <a href="{{ route('categories.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.category.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-categories')
                        <li>
                            <a href="{{ route('categories.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.category.create') }}
                            </a>
                        </li>
                    @endcan
                    @can('import-categories')
                        <li>
                            <a href="{{ route('categories.import') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.category.import') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif
        
        @if (   auth()->user()->can('read-warehouses') || 
                auth()->user()->can('create-warehouses')
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1"><i class='bx bx-building-house'></i>
                    </div>
                    <div class="menu-title">{{ __('common.warehouse.title') }}</div>
                </a>
                <ul>
                    @can('read-warehouses')
                        <li>
                            <a href="{{ route('warehouses.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.warehouse.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-warehouses')
                        <li>
                            <a href="{{ route('warehouses.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.warehouse.create') }}
                            </a>
                        </li>
                    @endcan
                    @can('import-warehouses')
                        <li>
                            <a href="{{ route('warehouses.import') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.warehouse.import') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif
        
        @if (   auth()->user()->can('read-users') || 
                auth()->user()->can('create-users') || 
                auth()->user()->can('read-roles')
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1"><i class='bx bx-user'></i>
                    </div>
                    <div class="menu-title">{{ __('common.user.title') }}</div>
                </a>
                <ul>
                    @can('read-users')
                        <li>
                            <a href="{{ route('users.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.user.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-users')
                        <li>
                            <a href="{{ route('users.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.user.create') }}
                            </a>
                        </li>
                    @endcan
                    @can('read-roles')
                        <li>
                            <a href="{{ route('roles.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.role.index') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (   auth()->user()->can('read-units') ||
                auth()->user()->can('create-units')
        )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1 h-6 w-[26px] flex justify-center items-center">
                        <i class="fa-solid fa-calculator"></i>
                    </div>
                    <div class="menu-title">{{ __('common.unit.title') }}</div>
                </a>
                <ul>
                    @can('read-units')
                        <li>
                            <a href="{{ route('units.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.unit.index') }}
                            </a>
                        </li>
                    @endcan
                    @can('create-units')
                        <li>
                            <a href="{{ route('units.create') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.unit.create') }}
                            </a>
                        </li>
                    @endcan
                    @can('import-units')
                        <li>
                            <a href="{{ route('units.import') }}">
                                <i class="bx bx-right-arrow-alt"></i>
                                {{ __('common.unit.import') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif
        
        @if (   auth()->user()->can('read-reports') )
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon icon-color-1 h-6 w-[26px] flex justify-center items-center">
                        <i class='bx bx-bar-chart-alt-2'></i>
                    </div>
                    <div class="menu-title">{{ __('common.report.title') }}</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('reports.index') }}">
                            <i class="bx bx-right-arrow-alt"></i>
                            {{ __('common.report.total') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.checkin') }}">
                            <i class="bx bx-right-arrow-alt"></i>
                            {{ __('common.report.checkin') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.checkout') }}">
                            <i class="bx bx-right-arrow-alt"></i>
                            {{ __('common.report.checkout') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.transfer') }}">
                            <i class="bx bx-right-arrow-alt"></i>
                            {{ __('common.report.transfer') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.adjustment') }}">
                            <i class="bx bx-right-arrow-alt"></i>
                            {{ __('common.report.adjustments') }}
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</div>
