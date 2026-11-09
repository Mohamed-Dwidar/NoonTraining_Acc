@extends('layoutmodule::admin.main')

@section('title')
طرق الدفع
@endsection

@section('content')

<div class="content-wrapper container-fluid">
    <div class="content-header">
        <div class="content-header-left mb-2 breadcrumb-new col">
            <h3>
                <a href="{{ route('admin.settings') }}">إعدادات النظام</a>
                &nbsp;::&nbsp;
                طرق الدفع
            </h3>
        </div>
    </div>

    @include('layoutmodule::admin.flash')

    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <form method="POST" action="{{ route('admin.settings.payment_methods.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="طريقة الدفع" required>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <button type="submit" class="btn btn-success round btn-min-width">أضف طريقة دفع</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr class="head">
                                        <th>طريقة الدفع</th>
                                        <th>الحالة</th>
                                        <th>عدد الدفعات</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($methods as $method)
                                        <tr>
                                            <td class="strong">{{ $method->name }}</td>
                                            <td>
                                                @if ($method->is_active)
                                                    <span class="tag tag-success">مفعل</span>
                                                @else
                                                    <span class="tag tag-default">غير مفعل</span>
                                                @endif
                                            </td>
                                            <td>{{ $method->payments_count }}</td>
                                            <td class="action">
                                                <a class="btn btn-warning" href="{{ route('admin.settings.payment_methods.edit', $method->id) }}" role="button">تعديل</a>

                                                <form method="POST" action="{{ route('admin.settings.payment_methods.delete') }}" style="display: inline"
                                                    onsubmit="return confirm('هل انت متأكد انك تريد حذف طريقة الدفع ؟ الدفعات السابقة ستحتفظ بالاسم.')">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $method->id }}">
                                                    <button type="submit" class="btn btn-danger">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">لا توجد طرق دفع بعد</td>
                                        </tr>
                                    @endforelse
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
