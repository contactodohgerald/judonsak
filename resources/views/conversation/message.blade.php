{{--@extends('layouts.admin')--}}
@extends("layouts.".\Auth::user()->person->department->slug )
@section('css')
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/magnific-popup/magnific-popup.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css')}}" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/theme.css')}}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/skins/default.css')}}" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/theme-custom.css')}}">

    <!-- Head Libs -->
    <script src="{{asset('assets/vendor/modernizr/modernizr.js')}}"></script>
@endsection
@section('body')
    <!-- start: page -->
        <div class="row">
        <div class="col-md-8">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                    <i class="icon-bubble font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp sbold">CHATS</span>
                    </div>
                    @if(count($partner) > 0)
                    <div style="float: right;">
                        @if(!empty($partner->profile_pic))
                            <img style=" max-width: 45px; max-height: 45px;" alt="" class="img-responsive img-thumbnail img-circle" src="{{ URL::asset('assets/pages/media/profile/'.$partner->profile_pic) }}" /></a>
                        @else
                            <img class="avatar" alt="" src="{{ URL::asset('assets/layouts/layout4/img/avatar.png') }}" /></a>
                        @endif
                    <span>{{$partner->name}}</span>
                    </div>
                    @endif
                </div>
                <div class="portlet-body">
                    <div id="chats" style="overflow:auto; height: 350px;padding: 0px;margin: 0px" data-always-visible="1" data-rail-visible1="1">
                        <ul class="chats" id="chat_card"> 
                        @if(count($chat) > 0)
                        @foreach($chat->chat_messages as $messages)
                            @if(Auth::user()->id != $messages->user->id)
                                <li class="in">
                            @else
                                <li class="out" >
                            @endif
                            @if(!empty($messages->user->profile_pic))
                                <img alt="" class="avatar" src="{{ URL::asset('assets/pages/media/profile/'.$messages->user->profile_pic) }}" /></a>
                            @else
                                <img class="avatar" alt="" src="{{ URL::asset('assets/layouts/layout4/img/avatar.png') }}" /></a>
                            @endif                                
                                <div class="message">
                                    <span class="arrow"> </span>
                                    <a><strong>{{$messages->user->username}}</strong></a>                                    
                                    <span class="datetime"> {{\Permission::timeAgo(strtotime($messages->created_at))}} </span>
                                    <span class="body">
                                    <span class="iamminified" style="word-break: break-word;">
                                    {!! $messages->message !!}</span></span>
                                </div>
                            </li>
                            @endforeach
                            @else
                            <h4 style="margin-top: 50px;">No Chat Selected</h4>
                            @endif
                        </ul>
                    </div>
                </div>
                @if(count($chat) > 0)
                 <form id="chatMsg" class="form-horizontal form-bordered">
                   <div class="form-body">
                            {{ csrf_field() }}
                         <input type="hidden" id="chat_id" value="{{$chat->id}}" />
                        <input type="hidden" id="message_time" value="{{\Permission::timeAgo(strtotime(date ("Y-m-d H:i:s")))}}" />
                        <input type="hidden" id="username" value="{{Auth::user()->username}}" />
                            @if(!empty(Auth::user()->profile_pic))
                                <input type="hidden" id="picture" value="{{ URL::asset('assets/pages/media/profile/'.Auth::user()->profile_pic) }}" />
                                @else
                                <input type="hidden" id="picture" value="{{ URL::asset('assets/layouts/layout4/img/avatar.png') }}" />
                            @endif
                            <div class="chat-form">
                                <div class="input-cont">
                                    <input class="form-control" type="text" id="chat_message" name="message" placeholder="Type a message here..." /> </div>
                                <div class="btn-cont">
                                    <span class="arrow"> </span><button type="submit" class="btn btn-primary" id="chatSubmit"><i class="fa fa-check icon-white"></i></button>
                                </div>
                            </div>                            
                        </div>
                    </form>
                @endif                    
                </div>
            <!-- END PORTLET-->
        </div>
            <div class="inbox">
            <div class="col-md-4">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bubble font-hide hide"></i>
                          <input id="tags" placeholder="Search username" class="form-control">
                        <span class="caption-subject font-hide bold uppercase">Recent</span>
                    </div>
                </div>                
                    <div class="portlet-body inbox-sidebar">
                      <!-- Nav tabs -->
                              <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li role="presentation" class="active"><a href="#recent" aria-controls="recent" role="tab" data-toggle="tab">Recent</a></li>
                                <li role="presentation"><a href="#contacts" aria-controls="contacts" role="tab" data-toggle="tab"> Contacts </a></li>
                              </ul><br>
                    <div class="tab-content">      
                        <div role="tabpanel" class="tab-pane active" id="recent">                              
                        <nav class="list-group navbar-default"> 
                            <div id="dashboard-sidebar" style="background-color: #fff">
                            <ul class="nav">
                            @if(empty($other_user))
                            <h4>No Recent Chat</h4>
                            @else
                            @foreach($other_user as $key => $profile)
                              @if($profile->id == $partner->id)
                                    <li class="active">
                                    <a class="list-group-item active" href="{{ url('l/'.request()->segment(2).'/start-chat/'.$profile->id) }}">
                                        <span class="contact-name">{{ $profile->name }}</span>
                                    </a>
                                </li>
                              @endif    
                            @endforeach
                            @foreach($other_user as $key => $profile)
                              @unless($profile->id == $partner->id)
                                    <li>
                                    <a class="list-group-item" href="{{ url('l/'.request()->segment(2).'/start-chat/'.$profile->id) }}">
                                        <span class="contact-name">{{ $profile->name }}</span>
                                    </a>
                                </li>
                              @endunless    
                            @endforeach
                            @endif
                            </ul>
                            </div>
                        </nav>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="contacts">
                            <nav class="list-group navbar-default"> 
                                <div id="dashboard-sidebar" style="background-color: #fff">
                               <ul class="nav">
                                @foreach($all_user as $user)
                                    @if($user->id != Auth::id())
                                        <li><a href="{{ url('l/'.request()->segment(2).'/start-chat/'.$user->id) }}" class="list-group-item">{{$user->name}} </a> 
                                        </li>
                                    @endif
                               @endforeach
                              </ul>
                                </div><!-- /.navbar-collapse -->
                            </nav>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <!-- END TIMELINE ITEM -->
        <div id="loader" hidden>
            <img src= "{{ URL::asset('assets/layouts/layout4/img/loading.gif') }}" class = "center-block" />
        </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="userId" value="{{ \Auth::user()->id }}">

        </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
</div>
<!-- END CONTENT BODY -->

@stop

@section('scripts')
<script>
var mychatChay = setInterval(myChatRefresh, 1500);

        function myChatRefresh() {
        var chatChat_id = $( '#chat_id' ).val();
        var d = $('#chats');
        var t = 0;
        var x = $('#chat_card li span').last();
        message = x[0].innerText;
//        console.log(x[0].innerText);

                $.ajax({
                    url: '/s/chats/msg/'+ chatChat_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        if (data['status'] == 'success') {
                            if (message == data['message']) {
                                return false;
                            }
                                    $( '#chat_card' ).load(""+ chatChat_id + " #chat_card",function(){
                                            d.scrollTop(d[0].scrollHeight);
                                    });
                        }else{
                            return false;
                        };
                    }
                });
        }
</script>
<script src="{{ URL::asset('assets/pages/scripts/chat.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/plugins/jquery-ui.min.js') }}" type="text/javascript"></script>
<script>
    $(function() {
        var x = []
        $.ajax({
            url: '/chats/search/users',
            type: 'GET',
            dataType: 'json',
            success: function(data){
                if (data['status'] == 'success') {
                    x[0] = data['users'];
                        $( "#tags" ).autocomplete({
                           source: x[0],
                           autoFocus:true,
                           select: function( event, ui ) {
                            window.location.replace("/search/lec/chats/" + ui.item.value);
                          }
                        });

                }
            }
        });
    });
</script>

@stop
