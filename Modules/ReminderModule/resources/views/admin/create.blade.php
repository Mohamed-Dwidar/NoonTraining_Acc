@extends('layoutmodule::admin.main')

@section('title')
إشعار جديد
@endsection

@section('content')

<div class="content-wrapper container-fluid">
    <div class="content-header">
        <div class="content-header-left mb-2 breadcrumb-new col">
            <h3>
                <a href="{{ route(Auth::getDefaultDriver() . '.reminders') }}">الأشعارات</a>
                &nbsp;::&nbsp;
                إشعار جديد
            </h3>
        </div>
    </div>

    @include('layoutmodule::admin.flash')

    <div class="content-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <form class="card-form side-form" method="POST" action="{{ route(Auth::getDefaultDriver() . '.reminders.store') }}">
                            @csrf
                            @include('remindermodule::admin.partials.form', ['reminder' => null])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
