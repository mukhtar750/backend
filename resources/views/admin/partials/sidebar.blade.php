<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management
    </div>

    <!-- Nav Item - User Management -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.user-management') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>User Management</span></a>
    </li>

    <!-- Nav Item - Mentorship Forms -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.mentorship.forms.admin_dashboard') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Mentorship Forms</span></a>
    </li>

    <!-- Nav Item - Training Programs -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.training_programs') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Training Programs</span></a>
    </li>

    <!-- Nav Item - Mentorship Sessions -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.mentorship_sessions') }}">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Mentorship Sessions</span></a>
    </li>

    <!-- Nav Item - Pitch Events -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.pitch-events.index') }}">
            <i class="fas fa-fw fa-microphone"></i>
            <span>Pitch Events</span></a>
    </li>

    <!-- Nav Item - Content Management -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.content_management') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Content Management</span></a>
    </li>

    <!-- Nav Item - Feedback -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.feedback') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Feedback</span></a>
    </li>

    <!-- Nav Item - Learning Resources -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.resources') }}">
            <i class="fas fa-fw fa-lightbulb"></i>
            <span>Learning Resources</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>