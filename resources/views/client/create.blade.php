{{-- @extends('layouts.admin') --}}
@extends("layouts.".\Auth::user()->person->department->slug )

@section('css')
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="assets/vendor/modernizr/modernizr.js"></script>
@endsection


@section('body')

    <!-- start: page -->
    <div class="row">
        <div class="col-md-12">
            <form
                action="{{ null == $client ? route('client.store') : route('client.update', ['client' => $client->slug]) }} "
                method="POST" class="form-horizontal">
                @csrf
                @if (null !== $client)
                    <input type="hidden" name="_method" value="PUT">
                @endif
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>

                        <h2 class="panel-title">Register New Client
                            {{-- <a href="{{route('client.create.import')}}" class="btn btn-success"> 
												<i class="fa fa-plus"></i> Import
											</a> --}}
                        </h2>
                    </header>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control" placeholder="eg.: John Doe"
                                        value="{{ null == $client ? old('name') : $client->name }} " required />
                                </div>
                                @if ($errors->has('name'))
                                    <span class="text-danger"> {{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </span>
                                    <input type="text" name="address" class="form-control"
                                        placeholder="68, Molade Okoya Thomas Street. V.I"
                                        value="{{ null == $client ? old('address') : $client->address }}" />
                                </div>
                                @if ($errors->has('address'))
                                    <span class="text-danger"> {{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">State <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </span>
                                    <select id="state" class="form-control" name="state"
                                        value="{{ null == $client ? old('state') : $client->state }}" required>
                                        @if (null == $client)
                                            <option disabled selected> Select a state</option>
                                        @endif
                                        @foreach ($states as $state)
                                            @if (null !== $client)
                                                @if ($state->id == $client->state_id)
                                                    <option value="{{ $state->id }}" selected>{{ $state->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endif
                                            @else
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                    <label class="error" for="state"></label>
                                </div>
                                @if ($errors->has('state'))
                                    <span class="text-danger"> {{ $errors->first('state') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <input type="number" name="phone" class="form-control" placeholder="eg.: 0801000001"
                                        value="{{ null == $client ? old('phone') : $client->phone_num }}" />
                                </div>
                                @if ($errors->has('phone'))
                                    <span class="text-danger"> {{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" placeholder="eg.: email@email.com"
                                        value="{{ null == $client ? old('email') : $client->email }}" />
                                </div>
                                @if ($errors->has('email'))
                                    <span class="text-danger"> {{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">RCN
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-credit-card"></i>
                                    </span>
                                    <input type="text" name="rcn" class="form-control" placeholder="RC Number"
                                        value="{{ null == $client ? old('rcn') : $client->rcn }}" />
                                </div>
                                @if ($errors->has('rcn'))
                                    <span class="text-danger"> {{ $errors->first('rcn') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">TIN
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-credit-card"></i>
                                    </span>
                                    <input type="text" name="tin" class="form-control"
                                        placeholder="(Tax Indentification Number)"
                                        value="{{ null == $client ? old('tin') : $client->tin }}" />
                                </div>
                                @if ($errors->has('tin'))
                                    <span class="text-danger"> {{ $errors->first('tin') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">NOB</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-suitcase"></i>
                                    </span>
                                    <input type="text" name="nob" class="form-control" placeholder="Nature of Business"
                                        value="{{ null == $client ? old('nob') : $client->nature_of_business }}" />
                                </div>
                                @if ($errors->has('nob'))
                                    <span class="text-danger"> {{ $errors->first('nob') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Industry </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-briefcase"></i>
                                    </span>
                                    <input type="text" name="industry" class="form-control" placeholder="eg.: John Doe"
                                        value="{{ null == $client ? old('industry') : $client->industry }}" />
                                </div>
                                @if ($errors->has('industry'))
                                    <span class="text-danger"> {{ $errors->first('industry') }}</span>
                                @endif
                            </div>
                        </div>



                        <div class="col-sm-offset-5">
                            <h4>
                                <p class="btn" type="click" id="deleteContact"> <i class="fa fa-minus"></i></p>
                                Contacts
                                <p class="btn" type="click" id="addContact"> <i class="fa fa-plus"></i></p>
                            </h4>

                            <br>
                        </div>

                        <div class="form-group">
                            <div id="attachContact">
                                @if (null !== old('contact_name'))
                                    <input type="hidden" id="contactCount" value="{{ count(old('contact_name')) }}">
                                    @for ($i = 0; $i < count(old('contact_name')); $i++)
                                        <div class="form-group" id="removeContact{{ $i + 1 }}">

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Name
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </span>
                                                        <input type="text" min="1" max="100" name="contact_name[]"
                                                            class="form-control" placeholder="e.g 100"
                                                            value="{{ old('contact_name')[$i] }}" required />
                                                    </div>
                                                    @if ($errors->has('contact_name'))
                                                        <span class="text-danger">
                                                            {{ $errors->first('contact_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Designation
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </span>
                                                        <input type="text" min="1" max="100" name="contact_designation[]"
                                                            class="form-control" placeholder="e.g 100"
                                                            value="{{ old('contact_designation')[$i] }}" required />
                                                    </div>
                                                    @if ($errors->has('contact_designation'))
                                                        <span class="text-danger">
                                                            {{ $errors->first('contact_designation') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"> Phone
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" name="contact_phone[]" class="form-control"
                                                            placeholder="Contact Phone Number"
                                                            value="{{ old('contact_phone')[$i] }}" required />
                                                    </div>
                                                    @if ($errors->has('contact_phone'))
                                                        <span class="text-danger">
                                                            {{ $errors->first('contact_phone') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"> Email
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                        <input type="text" name="contact_email[]" class="form-control"
                                                            placeholder="Contact Email"
                                                            value="{{ old('contact_email')[$i] }}" />
                                                    </div>
                                                    @if ($errors->has('contact_email'))
                                                        <span class="text-danger">
                                                            {{ $errors->first('contact_email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"> Birthday
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" data-plugin-datepicker id="datepicker"
                                                            name="contact_birthday[]" class="form-control"
                                                            placeholder="Contact's Birthday"
                                                            value="{{ old('contact_birthday')[$i] }}" required />
                                                    </div>
                                                    @if ($errors->has('contact_birthday'))
                                                        <span class="text-danger">
                                                            {{ $errors->first('contact_birthday') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"> Anniversary
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" data-plugin-datepicker id="datepicker"
                                                            name="contact_annivasary[]" class="form-control"
                                                            placeholder="pay before"
                                                            value="{{ old('contact_annivasary')[$i] }}" required />
                                                    </div>
                                                    @if ($errors->has('contact_annivasary'))
                                                        <span class="text-danger">
                                                            {{ $errors->first('contact_annivasary') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                    @endfor
                            </div>
                        @elseif(null!== $client)
                            <input type="hidden" id="contactCount" value="{{ count($client->contacts) }}">
                            @foreach ($client->contacts as $contact)
                                <div class="form-group" id="removeContact{{ $loop->iteration }}">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </span>
                                                <input type="text" min="1" max="100" name="contact_name[]"
                                                    class="form-control" placeholder="e.g 100"
                                                    value="{{ null == $client ? old('contact_name') : $contact->name }}"
                                                    required />
                                            </div>
                                            @if ($errors->has('contact_name'))
                                                <span class="text-danger"> {{ $errors->first('contact_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Designation
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </span>
                                                <input type="text" min="1" max="100" name="contact_designation[]"
                                                    class="form-control" placeholder="e.g 100"
                                                    value="{{ null == $client ? old('contact_designation') : $contact->designation }}" />
                                            </div>
                                            @if ($errors->has('contact_designation'))
                                                <span class="text-danger">
                                                    {{ $errors->first('contact_designation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Phone
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" name="contact_phone[]" class="form-control"
                                                    placeholder="Contact Phone Number"
                                                    value="{{ null == $client ? old('contact_phone') : $contact->phone_num }}" />
                                            </div>
                                            @if ($errors->has('contact_phone'))
                                                <span class="text-danger"> {{ $errors->first('contact_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Email
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                                <input type="text" name="contact_email[]" class="form-control"
                                                    placeholder="Contact Email"
                                                    value=" {{ null == $client ? old('contact_email') : $contact->email }}" />
                                            </div>
                                            @if ($errors->has('contact_email'))
                                                <span class="text-danger"> {{ $errors->first('contact_email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Birthday
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" data-plugin-datepicker id="datepicker"
                                                    name="contact_birthday[]" class="form-control"
                                                    placeholder="Contact's Birthday"
                                                    value="{{ null == $client ? old('contact_birthday') : $contact->birthday }}" />
                                            </div>
                                            @if ($errors->has('contact_birthday'))
                                                <span class="text-danger"> {{ $errors->first('contact_birthday') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Anniversary
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" data-plugin-datepicker id="datepicker"
                                                    name="contact_annivasary[]" class="form-control"
                                                    placeholder="pay before"
                                                    value="{{ null == $client ? old('contact_annivasary') : $contact->anniversary }}" />
                                            </div>
                                            @if ($errors->has('contact_annivasary'))
                                                <span class="text-danger">
                                                    {{ $errors->first('contact_annivasary') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div><br>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <button class="btn btn-success" style="width: 49%">Submit</button>
                    <button type="reset" class="btn btn-default" style="width: 50%">Reset</button>
                </div>
            </div>
        </footer>
        </section>
        </form>
    </div>
    </div>


@endsection

@section('js')
    <!-- Vendor -->
    <script src="assets/vendor/jquery/jquery.js"></script>
    <script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

    <!-- Specific Page Vendor -->
    <script src="assets/vendor/select2/select2.js"></script>
    <script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
    <script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
    <script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="assets/javascripts/theme.js"></script>

    <!-- Theme Custom -->
    <script src="assets/javascripts/theme.custom.js"></script>

    <!-- Theme Initialization Files -->
    <script src="assets/javascripts/theme.init.js"></script>


    <!-- Examples -->
    <script src="assets/javascripts/tables/examples.datatables.default.js"></script>
    <script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
    <script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>
    <script type="text/javascript">
        $('body').on('focus', "#datepicker", function() {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                // startDate : new Date(),
                autoclose: true
            });
        });
        var attachContact = $('#attachContact');
        var contactCount = $('#contactCount').val();
        var count = (contactCount) ? contactCount : 0;
        var arr = [];
        if (contactCount) {
            // --contactCount;
            for (var i = 1; i <= contactCount; i++) {
                arr.push(i);
            }
        }
        var funcAddContact = function() {
            clickCount = ++count;
            arr.push(clickCount);
            var attachContent = `
        <div class="form-group" id="removeContact${clickCount}">


         <div class="form-group">

         <label class="col-sm-2 control-label">Name
          <span class="required">*</span>
         </label>											
          <div class="col-sm-8">
           <div class="input-group">
            <span class="input-group-addon">
             <i class="fa fa-user"></i>
            </span>
            <input type="text" min="1" max="100" name="contact_name[]" class="form-control" placeholder="e.g 100" value ="" required/>
           </div>
           @if ($errors->has('contact_name'))
               <span class="text-danger"> {{ $errors->first('contact_name') }}</span>
           @endif
          </div>
         </div>

         <div class="form-group">
          <label class="col-sm-2 control-label">Designation
          </label>											
           <div class="col-sm-8">
            <div class="input-group">
             <span class="input-group-addon">
              <i class="fa fa-briefcase"></i>
             </span>
             <input type="text" min="1" max="100" name="contact_designation[]" class="form-control" placeholder="e.g 100" value ="" />
            </div>
            @if ($errors->has('contact_designation'))
                <span class="text-danger"> {{ $errors->first('contact_designation') }}</span>
            @endif
           </div>													
         </div>
         <div class="form-group">
          <label class="col-sm-2 control-label"> Phone
          </label>											
           <div class="col-sm-8">
            <div class="input-group">
             <span class="input-group-addon">
              <i class="fa fa-phone"></i>
             </span>
             <input type="text" name="contact_phone[]" class="form-control" placeholder="Contact Phone Number" value ="" />
            </div>
            @if ($errors->has('contact_phone'))
                <span class="text-danger"> {{ $errors->first('contact_phone') }}</span>
            @endif
           </div>													
         </div>
         <div class="form-group">
          <label class="col-sm-2 control-label"> Email
          </label>											
           <div class="col-sm-8">
            <div class="input-group">
             <span class="input-group-addon">
              <i class="fa fa-envelope"></i>
             </span>
             <input type="text" name="contact_email[]" class="form-control" placeholder="Contact email" value ="" />
            </div>
            @if ($errors->has('contact_email'))
                <span class="text-danger"> {{ $errors->first('contact_email') }}</span>
            @endif
           </div>													
         </div>
         <div class="form-group">
          <label class="col-sm-2 control-label"> Birthday
          </label>											
           <div class="col-sm-8">
            <div class="input-group">
             <span class="input-group-addon">
              <i class="fa fa-calendar"></i>
             </span>
             <input type="text" data-plugin-datepicker id="datepicker" name="contact_birthday[]" class="form-control" placeholder="Contact's Birthday" value ="" />
            </div>
            @if ($errors->has('contact_birthday'))
                <span class="text-danger"> {{ $errors->first('contact_birthday') }}</span>
            @endif
           </div>													
         </div>
         <div class="form-group">
          <label class="col-sm-2 control-label"> Anniversary
          </label>											
           <div class="col-sm-8">
            <div class="input-group">
             <span class="input-group-addon">
              <i class="fa fa-calendar"></i>
             </span>
             <input type="text" data-plugin-datepicker id="datepicker" name="contact_annivasary[]" class="form-control" placeholder="Anniversary if Any" value ="" />
            </div>
            @if ($errors->has('contact_annivasary'))
                <span class="text-danger"> {{ $errors->first('contact_annivasary') }}</span>
            @endif
           </div>													
         </div>
         <br>
        </div>`;
            attachContact.append(attachContent);
        }
        $('#addContact').click(function() {
            funcAddContact();
        })
        $('#deleteContact').click(function() {
            var ref = arr[arr.length - 1];
            console.log(ref);
            $('#removeContact' + ref).remove();
            arr.pop();
        })

    </script>

@endsection
