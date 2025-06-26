@extends('layoutmodule::admin.main')

@section('title')
    اضافه مستخدم جديد
@endsection

@section('content')

    <div class="content-wrapper container-fluid">
        <div class="content-header">
            <div class="content-header-left mb-2 breadcrumb-new col">
                <h3><i class="fa fa-user"></i>
                    اضافه مستخدم جديد
                </h3>
            </div>
        </div>

        @include('layoutmodule::admin.flash')

        <div class="content-body">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <form class="card-form side-form" method="POST"
                                        action='{{ route('admin.user.store') }}' enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12 col-xs-12 col-6">
                                                <label for="name">الاسم</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        value="{{ old('name') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-2 col-sm-12 col-xs-12 col-2">
                                                <label for="branch_id">الفرع <span class="hint">*</span></label>
                                                <div class="form-group">
                                                    <select class="form-control" id="branch_id" name="branch_id">
                                                        @if (!empty($branches))
                                                            @foreach ($branches as $branch)
                                                                <option value="{{ $branch->id }}"
                                                                    @if (old('branch_id') == $branch->id) selected @endif>
                                                                    {{ $branch->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12 col-xs-12 col-6">
                                                <label for="email">البريد الإلكتروني</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        value="{{ old('email') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 12 col-sm-12 col-xs-12 col-6">
                                                <label for="password">كلمة المرور</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="password"
                                                        name="password" value="{{ old('password') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12 col-xs-12 col-6">
                                                <label><b>الصلاحيات</b></label>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        {{-- @foreach ($permissions as $permission) --}}
                                                        <input type="checkbox" name="permissions[]" id="permission_1"
                                                            value="1"
                                                            {{ in_array('Show Reports', old('permissions', [])) ? 'checked' : '' }}>
                                                        <label for="permission_1">استعراض التقارير</label>
                                                        {{-- @endforeach --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">حفظ</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-1 col-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {


            });
        </script>
    @endpush


@endsection
