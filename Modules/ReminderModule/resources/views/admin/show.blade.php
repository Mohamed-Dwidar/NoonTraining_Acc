@extends('layoutmodule::admin.main')

@section('title')
{{ $reminder->title }}
@endsection

@section('content')

<div class="content-wrapper container-fluid">
    <div class="content-header">
        <div class="content-header-left mb-2 breadcrumb-new col">
            <h3>
                <a href="{{ route(Auth::getDefaultDriver() . '.reminders') }}">الأشعارات</a>
                &nbsp;::&nbsp;
                {{ $reminder->title }}
            </h3>
        </div>
    </div>

    @include('layoutmodule::admin.flash')

    <div class="content-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-body reminder-view">
                        <p class="reminder-details">{{ $reminder->details ?: 'لا توجد تفاصيل' }}</p>

                        <p><strong>الموعد :</strong> <span class="reminder-dt">{{ $reminder->remind_at->format('Y-m-d H:i') }}</span></p>
                        <p>
                            <strong>أنشأه :</strong> {{ $reminder->creator->name ?? '---' }}
                            <small>(<span class="reminder-dt">{{ $reminder->created_at->format('Y-m-d H:i') }}</span>)</small>
                        </p>
                        <p><strong>يظهر لـ :</strong> {{ $reminder->audience_label }}</p>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="head">
                                        <th>وقت التذكير</th>
                                        <th>التاريخ</th>
                                        <th>قرأته في</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reminder->times as $time)
                                        <tr>
                                            <td class="strong">{{ $time->label }}</td>
                                            <td><span class="reminder-dt">{{ $time->show_at->format('Y-m-d H:i') }}</span></td>
                                            <td class="reminder-time-read" @if ($time->show_at->lte(now()) && $time->reads->isEmpty()) data-unread="{{ $reminder->id }}" @endif>
                                                @if ($time->reads->isNotEmpty())
                                                    <span class="reminder-dt">{{ $time->reads->first()->read_at->format('Y-m-d H:i') }}</span>
                                                @else
                                                    {{ $time->show_at->lte(now()) ? 'غير مقروء' : 'لم يحن بعد' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="reminder-actions">
                            @include('remindermodule::admin.partials.read_status')
                            @include('remindermodule::admin.partials.actions')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
