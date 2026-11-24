@extends('layoutmodule::admin.main')

@section('title')
الأشعارات
@endsection

@section('content')

@php $portal = Auth::getDefaultDriver(); @endphp

<div class="content-wrapper container-fluid">
    <div class="content-header">
        <div class="content-header-left mb-2 breadcrumb-new col">
            <h3>
                <i class="fa fa-bell"></i>
                &nbsp;
                الأشعارات
            </h3>
        </div>
    </div>

    @include('layoutmodule::admin.flash')

    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12">
                                <form method="GET" action="{{ route($portal . '.reminders') }}" class="reminder-filters">
                                    <select name="sts" class="form-control" onchange="this.form.submit()" aria-label="الحالة">
                                        <option value="">كل الحالات</option>
                                        <option value="unread" @selected(request('sts') == 'unread')>غير مقروء</option>
                                        <option value="read" @selected(request('sts') == 'read')>مقروء</option>
                                        <option value="upcoming" @selected(request('sts') == 'upcoming')>قادم</option>
                                    </select>

                                    @if (Auth::guard('admin')->check() && count($creators))
                                        <select name="usr" class="form-control" onchange="this.form.submit()" aria-label="المستخدم">
                                            <option value="">كل المستخدمين</option>
                                            @foreach ($creators as $value => $name)
                                                <option value="{{ $value }}" @selected(request('usr') == $value)>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </form>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <a class="btn btn-success round btn-min-width mr-1 mb-1" href="{{ route($portal . '.reminders.add') }}" role="button">أضف إشعار جديد</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="reminder-cards">
                            @forelse ($reminders as $reminder)
                                <div class="reminder-card @if ($reminder->read_status == 'unread') reminder-unread @endif" data-reminder="{{ $reminder->id }}">
                                    <div class="reminder-card-head">
                                        <a class="reminder-card-title" href="{{ route($portal . '.reminders.show', $reminder->id) }}">{{ $reminder->title }}</a>
                                        <span class="reminder-card-date">
                                            <i class="fa fa-clock-o"></i>
                                            <span class="reminder-dt">{{ $reminder->remind_at->format('Y-m-d H:i') }}</span>
                                        </span>
                                    </div>

                                    <div class="reminder-card-body">
                                        @if ($reminder->details)
                                            <p class="reminder-excerpt">{{ Str::limit($reminder->details, 120) }}</p>
                                        @endif
                                        <ul class="reminder-card-info">
                                            <li><i class="fa fa-bell-o"></i> {{ $reminder->times->pluck('label')->implode('، ') }}</li>
                                            <li><i class="fa fa-user-o"></i> {{ $reminder->creator->name ?? '---' }}</li>
                                            <li><i class="fa fa-eye"></i> {{ $reminder->audience_label }}</li>
                                        </ul>
                                    </div>

                                    <div class="reminder-card-foot">
                                        <div>@include('remindermodule::admin.partials.read_status')</div>
                                        <div class="reminder-card-actions">@include('remindermodule::admin.partials.actions')</div>
                                    </div>
                                </div>
                            @empty
                                <div class="reminder-empty">لا توجد أشعارات</div>
                            @endforelse
                        </div>
                        {{ $reminders->appends(request()->query())->links('layoutmodule::admin.custom_pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
