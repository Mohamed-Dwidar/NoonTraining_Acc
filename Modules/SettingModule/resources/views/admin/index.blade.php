@extends('layoutmodule::admin.main')

@section('title')
إعدادات النظام
@endsection

@section('content')

<div class="content-wrapper container-fluid">
    <div class="content-header">
        <div class="content-header-left mb-2 breadcrumb-new col">
            <h3>
                <i class="fa fa-cogs"></i>
                &nbsp;
                إعدادات النظام
            </h3>
        </div>
    </div>

    @include('layoutmodule::admin.flash')

    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="strong">
                                            <i class="fa fa-id-badge"></i>
                                            قائمة "تم التسجيل عن طريق"
                                        </td>
                                        <td>أسماء الموظفين التي تظهر عند اختيار "تم التسجيل عن طريق" في تسجيل الطالب بالدورة</td>
                                        <td class="action">
                                            <a class="btn btn-primary" href="{{ route('admin.settings.reg_by_employees') }}" role="button">إدارة القائمة</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
