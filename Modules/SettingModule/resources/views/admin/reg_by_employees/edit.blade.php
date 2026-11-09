@extends('layoutmodule::admin.main')

@section('title')
تعديل اسم
@endsection

@section('content')

<div class="content-wrapper container-fluid">
    <div class="content-header">
        <div class="content-header-left mb-2 breadcrumb-new col">
            <h3>
                <a href="{{ route('admin.settings.reg_by_employees') }}">قائمة "تم التسجيل عن طريق"</a>
                &nbsp;::&nbsp;
                تعديل :: {{ $employee->name }}
            </h3>
        </div>
    </div>

    @include('layoutmodule::admin.flash')

    <div class="content-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <form class="card-form side-form" method="POST" action="{{ route('admin.settings.reg_by_employees.update') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $employee->id }}">

                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-xs-12 col-6">
                                    <label for="name">الاسم</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-xs-12 col-6">
                                    <label>الحالة</label>
                                    <div class="input-group">
                                        <label class="display-inline-block custom-control custom-radio ml-1">
                                            <input type="radio" name="is_active" class="custom-control-input" value="1" @checked(old('is_active', $employee->is_active) == 1)>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description ml-0">مفعل (يظهر في القائمة)</span>
                                        </label>
                                        <label class="display-inline-block custom-control custom-radio">
                                            <input type="radio" name="is_active" class="custom-control-input" value="0" @checked(old('is_active', $employee->is_active) == 0)>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description ml-0">غير مفعل</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
