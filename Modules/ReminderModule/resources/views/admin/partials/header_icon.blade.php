{{-- Bell icon in layoutmodule::admin.header. $unreadCount + $reminders come from the view composer in ReminderModuleServiceProvider --}}
@php $portal = Auth::getDefaultDriver(); @endphp
<li class="dropdown nav-item header-reminders"
    data-latest-url="{{ route($portal . '.reminders.latest') }}"
    data-read-url="{{ route($portal . '.reminders.read') }}">
    <a href="#" data-toggle="dropdown" class="nav-link header-reminders-icon" title="الأشعارات" aria-label="الأشعارات">
        <i class="fa fa-bell"></i>
        <span class="reminders-count" @if ($unreadCount == 0) style="display: none" @endif>{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
    </a>
    <div class="dropdown-menu reminders-menu">
        <div class="reminders-list">
            @include('remindermodule::admin.partials.header_list')
        </div>
        <div class="reminders-footer">
            <a href="{{ route($portal . '.reminders') }}">عرض كل الأشعارات</a>
            <a href="{{ route($portal . '.reminders.add') }}"><i class="fa fa-plus"></i> أضف إشعار جديد</a>
        </div>
    </div>
</li>

@push('scripts')
    <script src="{{ asset('admin-assets/js/reminders.js') }}" type="text/javascript"></script>
@endpush
