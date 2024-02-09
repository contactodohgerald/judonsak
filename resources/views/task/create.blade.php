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
             <form action="{{ route('submitTask') }} " method="POST" class="form-horizontal">
                 @csrf
                 <section class="panel">
                     <header class="panel-heading">
                         <div class="panel-actions">
                             <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                         </div>
                         <h2 class="panel-title">Create New Task</h2>
                     </header>
                     <div class="panel-body">
                         <div class="form-group">
                             <label class="col-sm-2 control-label"> Client <span class="required">*</span>
                             </label>
                             <div class="col-sm-8">
                                 <div class="input-group">
                                     <span class="input-group-addon">
                                         <i class="fa fa-user"></i>
                                     </span>
                                     <select name="client" id="selectClient" class="form-control" required>
                                         <option disabled selected> Select Client</option>
                                         @foreach ($clients as $client)
                                             <option value="{{ $client->id }}">
                                                 {{ $client->name }}
                                             </option>
                                         @endforeach
                                     </select>
                                     <label class="error" for="selectClient"></label>
                                 </div>
                                 {{-- @if ($errors->has('client'))
                                     <span class="text-danger"> {{ $errors->first('client') }}</span>
                                 @endif --}}
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-sm-2 control-label"> Contract <span class="required">*</span>
                             </label>
                             <div class="col-sm-8">
                                 <div class="input-group">
                                     <span class="input-group-addon">
                                         <i class="fa fa-user"></i>
                                     </span>
                                     <select id="selectContract" name="contract" class="form-control" required>
                                         <option disabled selected> Select Contract</option>
                                     </select>
                                     <label class="error" for="selectContract"></label>
                                 </div>
                                 {{-- @if ($errors->has('contract'))
                                     <span class="text-danger"> {{ $errors->first('contract') }}</span>
                                 @endif --}}
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-sm-2 control-label"> Services
                                 <span class="required">*</span>
                             </label>
                             <div class="col-sm-8">
                                 <div class="input-group">
                                     <span class="input-group-addon">
                                         <i class="fa fa-user"></i>
                                     </span>
                                     <select id="selectService" name="service" class="form-control" required>
                                         <option disabled selected> Select Service</option>
                                     </select>
                                     <label class="error" for="selectService"></label>
                                 </div>
                                 {{-- @if ($errors->has('service'))
                                     <span class="text-danger"> {{ $errors->first('service') }}</span>
                                 @endif --}}
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-sm-2 control-label"> Instruction
                                 <span class="required">*</span>
                             </label>
                             <div class="col-sm-8">
                                 <div class="input-group">
                                     <span class="input-group-addon">
                                         <i class="fa fa-user"></i>
                                     </span>
                                     <select id="selectInstruction" name="instruction" class="form-control" required>
                                         <option disabled selected> Select Instruction</option>
                                     </select>
                                     <label class="error" for="selectInstruction"></label>
                                 </div>
                                 {{-- @if ($errors->has('instruction'))
                                     <span class="text-danger"> {{ $errors->first('instruction') }}</span>
                                 @endif --}}
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-sm-2 control-label">Task
                                 <span class="required">*</span>
                             </label>
                             <div class="col-sm-8">
                                 <div class="input-group">
                                     <span class="input-group-addon">
                                         <i class="fa fa-suitcase"></i>
                                     </span>
                                     <input type="text" name="task" class="form-control" placeholder="Task"
                                         value="{{ old('task') }}" required />
                                 </div>
                                 {{-- @if ($errors->has('task'))
                                     <span class="text-danger"> {{ $errors->first('task') }}</span>
                                 @endif --}}
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-sm-2 control-label">Description
                                 <span class="required">*</span>
                             </label>
                             <div class="col-sm-8">
                                 <div class="input-group">
                                     <span class="input-group-addon">
                                         <i class="fa fa-suitcase"></i>
                                     </span>
                                     <textarea rows="5" class="form-control" placeholder="Task Description"
                                         name="description" required>{{ old('description') }}</textarea>
                                 </div>
                                 {{-- @if ($errors->has('description'))
                                     <span class="text-danger">
                                         {{ $errors->first('description') }}
                                     </span>
                                 @endif --}}
                             </div>
                         </div>

                         {{-- Executor --}}
                         <div class="form-group">
                             <label class="col-sm-2 control-label">Assign To <span class="required">*</span></label>
                             <div class="col-sm-8">
                                 <div class="input-group">
                                     <span class="input-group-addon">
                                         <i class="fa fa-user"></i>
                                     </span>
                                     <select id="executor" name="executor" data-plugin-selectTwo
                                         class="form-control populate" required>
                                         @if (null !== old('executor'))
                                             @foreach ($people as $person)
                                                 <option value="{{ $person->id }}">
                                                     {{ $person->first_name . ' ' . $person->last_name }}
                                                 </option>
                                                 {{-- @if (in_array($person->id, $people)) --}}
                                                 {{-- <option value="{{ $person->id }}" selected>
                                                         {{ $person->first_name . ' ' . $person->last_name }}
                                                     </option> --}}
                                                 {{-- @else --}}
                                                 {{-- <option value="{{ $person->id }}">
                                                         {{ $person->first_name . ' ' . $person->last_name }}
                                                     </option> --}}
                                                 {{-- @endif --}}
                                             @endforeach
                                         @else
                                             <option disabled selected> Add a Staff</option>
                                             @foreach ($people as $person)
                                                 <option value="{{ $person->id }}">
                                                     {{ $person->first_name . ' ' . $person->last_name }}
                                                 </option>
                                             @endforeach
                                         @endif

                                     </select>
                                     <label class="error" for="executor"></label>
                                 </div>
                                 {{-- @if ($errors->has('executor'))
                                     <span class="text-danger"> {{ $errors->first('executor') }}</span>
                                 @endif --}}
                             </div>
                         </div>

                         {{-- Supervisor --}}
                         <div class="form-group">
                             <label class="col-sm-2 control-label">Supervisor<span class="required">*</span></label>
                             <div class="col-sm-8">
                                 <div class="input-group">
                                     <span class="input-group-addon">
                                         <i class="fa fa-user"></i>
                                     </span>
                                     <select id="supervisor" name="supervisor" data-plugin-selectTwo
                                         class="form-control populate" required>
                                         {{-- @if (null !== old('supervisor')) --}}
                                         @foreach ($people as $person)
                                             <option value="{{ $person->id }}">
                                                 {{ $person->first_name . ' ' . $person->last_name }}
                                             </option>
                                             {{-- @if (in_array($person->id, old('supervisor')))
                                                     <option value="{{ $person->id }}" selected>
                                                         {{ $person->first_name . ' ' . $person->last_name }}
                                                     </option>
                                                 @else
                                                     <option value="{{ $person->id }}">
                                                         {{ $person->first_name . ' ' . $person->last_name }}
                                                     </option>
                                                 @endif --}}
                                         @endforeach
                                         {{-- @else
                                             <option disabled selected> Add a Staff</option>
                                             @foreach ($people as $person)
                                                 <option value="{{ $person->id }}">
                                                     {{ $person->first_name . ' ' . $person->last_name }}
                                                 </option>
                                             @endforeach
                                         @endif --}}

                                     </select>
                                     <label class="error" for="supervisor"></label>
                                 </div>
                                 @if ($errors->has('supervisor'))
                                     <span class="text-danger"> {{ $errors->first('supervisor') }}</span>
                                 @endif
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-sm-2 control-label">Deadline <span class="required">*</span></label>
                             <div class="col-sm-8">
                                 <div class="input-group">
                                     <span class="input-group-addon">
                                         <i class="fa fa-suitcase"></i>
                                     </span>
                                     <input type="text" data-plugin-datepicker id="datepicker" name="dead_line"
                                         class="form-control" placeholder="Deadline Date" value="{{ old('dead_line') }}"
                                         required />
                                 </div>
                                 @if ($errors->has('remark'))
                                     <span class="text-danger"> {{ $errors->first('remark') }}</span>
                                 @endif
                             </div>
                         </div>
                     </div>
                     <footer class="panel-footer">
                         <div class="row">
                             <div class="col-sm-8 col-sm-offset-2">
                                 <button class="btn btn-success btn-block" type="submit">Submit</button>
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

     <script type="text/javascript">
         $(document).ready(function() {
             $("#selectClient").change(function() {
                 let attachContract = $('#selectContract');
                 $('#selectContract option').remove();
                 $('#selectService option').remove();
                 $('#selectInstruction option').remove();
                 let clientId = $("#selectClient").val();
                 let selectClientURL = '/admin/instruction/new/select/client/api/' + clientId;
                 let setContract = `<option selected> Select Contract </option>`
                 attachContract.append(setContract);
                 $.ajax({
                     url: selectClientURL,
                     type: 'GET',
                     success: function(res) {
                         for (let attach of res) {
                             let contract =
                                 `<option value="${attach.id}"> ${attach.name}</option>`
                             attachContract.append(contract);
                         }
                     },
                     error: function(res) {
                         console.log(res);
                     }
                 });
             });

             $("#selectContract").change(function() {
                 let selectService = $('#selectService');
                 $('#selectService option').remove();
                 $('#selectInstruction option').remove();
                 let contractId = $("#selectContract").val();
                 let selectContractURL = '/admin/instruction/new/select/contract/api/' + contractId;
                 let setService = `<option selected> Select Service </option>`
                 selectService.append(setService);
                 $.ajax({
                     url: selectContractURL,
                     type: 'GET',
                     success: function(res) {
                         for (let attach of res) {
                             let service =
                                 `<option value="${attach.id}"> ${attach.name}</option>`
                             selectService.append(service);
                         }
                     },
                     error: function(res) {
                         console.log(res);
                     }
                 });
             });

             $("#selectService").change(function() {
                 let selectInstruction = $('#selectInstruction');
                 $('#selectInstruction option').remove();
                 let contractId = $("#selectContract").val();
                 let serviceId = $("#selectService").val();
                 let selectServiceURL = '/admin/instruction/new/service/all/api/' + contractId + '/' +
                     serviceId;
                 let setService = `<option selected> Select Instruction </option>`
                 selectInstruction.append(setService);
                 $.ajax({
                     url: selectServiceURL,
                     type: 'GET',
                     success: function(res) {
                         for (let attach of res) {
                             let instruction =
                                 `<option value="${attach.id}"> ${attach.name}</option>`
                             selectInstruction.append(instruction);
                         }
                     },
                     error: function(res) {
                         console.log(res);
                     }
                 });
             });

         })

     </script>


 @endsection
