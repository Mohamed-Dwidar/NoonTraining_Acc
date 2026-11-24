{{-- Edit / delete — the creator and admin only --}}
@if ($reminder->canBeManagedBy($person))
    <a class="btn btn-warning" href="{{ route(Auth::getDefaultDriver() . '.reminders.edit', $reminder->id) }}" role="button">تعديل</a>

    <form method="POST" action="{{ route(Auth::getDefaultDriver() . '.reminders.delete') }}" style="display: inline"
        onsubmit="return confirm('هل انت متأكد انك تريد حذف هذا الإشعار ؟')">
        @csrf
        <input type="hidden" name="id" value="{{ $reminder->id }}">
        <button type="submit" class="btn btn-danger">حذف</button>
    </form>
@endif
