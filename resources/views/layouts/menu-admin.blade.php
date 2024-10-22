<!-- Menu Admin -->
<a class="nav-link {!! request()->routeIs('project.create') || request()->routeIs('project.list') ? 'active' : '' !!}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseNhiemvu" aria-expanded="false" aria-controls="collapseNhiemvu">
    <div class="nav-link-icon">
        <span class="material-symbols-outlined">assignment</span>
    </div> <?= __('menu.project') ?> <div class="sidenav-collapse-arrow">
        <span class="material-symbols-outlined">chevron_right</span>
    </div>
</a>
<div class="collapse {!! request()->routeIs('project.create') || request()->routeIs('project.list') ? 'show' : '' !!}" id="collapseNhiemvu" data-bs-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavNhiemvuMenu">
        <a class="nav-link {!! request()->routeIs('project.create') ? 'active' : '' !!}" href="{{ route('project.create') }}"><?= __('menu.create_project') ?></a>
        <a class="nav-link {!! request()->routeIs('project.list') ? 'active' : '' !!}" href="{{ route('project.list') }}"><?= __('menu.list_project') ?></a>
    </nav>
</div>