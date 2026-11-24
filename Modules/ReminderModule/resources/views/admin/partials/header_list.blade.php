{{-- Latest reminders in the header icon menu; also returned by AJAX ({portal}.reminders.latest / .read) --}}
@php $portal = Auth::getDefaultDriver(); @endphp
@forelse ($reminders as $reminder)
    <div class="reminder-item @if ($reminder->read_status == 'unread') unread @endif">
        <a href="{{ route($portal . '.reminders.show', $reminder->id) }}">
            <span class="reminder-title">{{ $reminder->title }}</span>
            <span class="reminder-date">
                <i class="fa fa-clock-o"></i>
                <span class="reminder-dt">{{ $reminder->remind_at->format('Y-m-d H:i') }}</span>
            </span>
        </a>
        @if ($reminder->read_status == 'unread')
            <button type="button" class="btn btn-sm btn-success reminder-read-btn" data-id="{{ $reminder->id }}">مقروء</button>
        @endif
    </div>
@empty
    <div class="reminder-empty">لا توجد أشعارات</div>
@endforelse
