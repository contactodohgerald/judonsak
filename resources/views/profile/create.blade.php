{{-- @extends('layouts.admin') --}}
@extends("layouts.".\Auth::user()->person->department->slug )

@section('css')
    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}" />
    <link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css') }}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/skins/default.css') }}" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css') }}">

    <!-- Head Libs -->
    <script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
@endsection


@section('body')

    <!-- start: page -->
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('profile.store') }} " method="POST" class="form-horizontal"
                enctype="multipart/form-data">
                @csrf
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>

                        <h2 class="panel-title">New Staff</h2>
                    </header>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Firstname
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" name="firstname" class="form-control" placeholder="Firstname"
                                        value="{{ old('firstname') }}" required />
                                </div>
                                @if ($errors->has('firstname'))
                                    <span class="text-danger"> {{ $errors->first('firstname') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lastname
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" name="lastname" class="form-control" placeholder="Lastname"
                                        value="{{ old('lastname') }}" required />
                                </div>
                                @if ($errors->has('lastname'))
                                    <span class="text-danger"> {{ $errors->first('lastname') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                        value="{{ old('email') }}" required />
                                </div>
                                @if ($errors->has('email'))
                                    <span class="text-danger"> {{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        value="{{ old('password') }}" required />
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-danger"> {{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Department
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-building"></i>
                                    </span>
                                    <select name="department" class="form-control" value="{{ old('department') }}"
                                        required>
                                        <option disabled selected>Select department</option>
                                        @if (old('department'))
                                            @foreach ($departments as $department)
                                                @if ($department->id == old('department'))
                                                    <option value="{{ $department->id }}" selected>
                                                        {{ $department->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $department->id }}">
                                                        {{ $department->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                @if ($errors->has('department'))
                                    <span class="text-danger"> {{ $errors->first('department') }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Designation --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Designation
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-level-up"></i>
                                    </span>
                                    <select name="level" class="form-control" value="{{ old('level') }}" required>
                                        <option disabled selected> Select designation</option>
                                        @if (old('level'))
                                            @foreach ($levels as $level)
                                                @if ($level->id == old('level'))
                                                    <option value="{{ $level->id }}" selected>
                                                        {{ $level->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $level->id }}">
                                                        {{ $level->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->id }}">
                                                    {{ $level->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                @if ($errors->has('level'))
                                    <span class="text-danger"> {{ $errors->first('level') }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Staff Id --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Staff Id
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="text" name="staffId" class="form-control" placeholder="Staff Id"
                                        value="{{ old('staffId') }}" required />
                                </div>
                                @if ($errors->has('staffId'))
                                    <span class="text-danger"> {{ $errors->first('staffId') }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Profile Image --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for='profile_image'>Profile Image
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="file" name="profile_image" id="profile_image" class="form-control"
                                        value="{{ old('profile_image') }}" />
                                </div>
                                @if ($errors->has('profile_image'))
                                    <span class="text-danger"> {{ $errors->first('profile_image') }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Phone Number --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone"
                                        value="{{ old('phone') }}" required />
                                </div>
                                @if ($errors->has('phone'))
                                    <span class="text-danger"> {{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-building"></i>
                                    </span>
                                    <input type="text" name="address" class="form-control" placeholder="Address"
                                        value="{{ old('address') }}" required />
                                </div>
                                @if ($errors->has('address'))
                                    <span class="text-danger"> {{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button class="btn btn-success btn-block">Submit</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>
    </div>


@endsection

@section('js')
    <!-- Specific Page Vendor -->
    <script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assets/javascripts/theme.js') }}"></script>

    <!-- Theme Custom -->
    <script src="{{ asset('assets/javascripts/theme.custom.js') }}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{ asset('assets/javascripts/theme.init.js') }}"></script>

    <!-- Examples -->
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.default.js') }}"></script>
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.row.with.details.js') }}"></script>
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.tabletools.js') }}"></script>


@endsection
