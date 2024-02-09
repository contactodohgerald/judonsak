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
    <script src="{{asset('assets/css/conversation.min.css')}}"></script>

    <style type="text/css">
.portlet.light.bordered {
    border: 1px solid #e7ecf1!important;
}

.portlet.light {
    padding: 12px 20px 15px;
    background-color: #fff;
}
.portlet {
    box-shadow: 0 2px 3px 2px rgba(0,0,0,.03);
}
.portlet {
    margin-top: 0;
    margin-bottom: 25px;
    padding: 0;
    border-radius: 2px;
}
.portlet.light .portlet-body {
    padding-top: 8px;
}

.portlet>.portlet-body {
    clear: both;
    -webkit-border-radius: 0 0 2px 2px;
    -moz-border-radius: 0 0 2px 2px;
    -ms-border-radius: 0 0 2px 2px;
    -o-border-radius: 0 0 2px 2px;
    border-radius: 0 0 2px 2px;
}
form {
    display: block;
    margin-top: 0em;
}
form {
    display: block;
    margin-top: 0em;
}
.portlet.light>.portlet-title>.caption {
    color: #666;
    padding: 10px 0;
}
.portlet>.portlet-title>.caption {
    float: left;
    display: inline-block;
    font-size: 18px;
    line-height: 18px;
    padding: 10px 0;
}
.portlet.light>.portlet-title>.caption>.caption-subject {
    font-size: 16px;
}

.font-green-sharp {
    color: #2ab4c0!important;
}
.sbold {
    font-weight: 600!important;
}
.portlet.light>.portlet-title>.caption>i {
    color: #777;
    font-size: 15px;
    font-weight: 300;
    margin-top: 3px;
}

.portlet>.portlet-title>.caption>i {
    float: left;
    margin-top: 4px;
    display: inline-block;
    font-size: 13px;
    margin-right: 5px;
    color: #666;
}
.font-green-sharp {
    color: #2ab4c0!important;
}
.conversations {
    margin: -15px 0 0;
    padding: 0;
}

ol, ul {
    margin-bottom: 10px;
}
dl, ol, ul {
    margin-top: 0;
}
*, :after, :before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
user agent stylesheet
ul, menu, dir {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.conversations li {
    font-size: 15px;
    line-height: 40px;
}

.conversations li {
    list-style: none;
    padding: 5px 0;
    margin: 10px auto;
    font-size: 12px;
}
*, :after, :before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
user agent stylesheet
li {
    display: list-item;
    text-align: -webkit-match-parent;
}

.conversations li {
    font-size: 15px;
    line-height: 40px;
}

.conversations li {
    list-style: none;
    padding: 5px 0;
    margin: 10px auto;
    font-size: 12px;
}
*, :after, :before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
user agent stylesheet
li {
    display: list-item;
    text-align: -webkit-match-parent;
}
.conversations li .body {
    display: block;
}
.conversations li.in .message .arrow {
    left: -8px;
    width: 0;
    height: 0;
    border-right: 8px solid #3598dc;
}
.conversations li.in .message .arrow {
    left: -8px;
    width: 0;
    height: 0;
    border-right: 8px solid #1BBC9B;
}

.conversations li.in .message .arrow, .conversations li.out .message .arrow {
    display: block;
    position: absolute;
    top: 5px;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
}

.conversation-form {
    margin-top: 15px;
    padding: 10px;
    background-color: #e9eff3;
    overflow: hidden;
    clear: both;
}

.conversation-form .input-cont {
    margin-right: 40px;
}

.conversation-form .btn-cont {
    margin-top: -41px;
    position: relative;
    float: right;
    width: 44px;
}
.conversation-form .input-cont .form-control {
    border: 1px solid #ddd;
    width: 100%!important;
    margin-top: 0;
    background-color: #fff!important;
}

.form-control {
    outline: 0!important;
    box-shadow: none!important;
}

.conversation-form .btn-cont {
    margin-top: -41px;
    position: relative;
    float: right;
    width: 44px;
}

.conversation-form .btn-cont .arrow {
    position: absolute;
    top: 17px;
    right: 43px;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    border-right: 8px solid #4d90fe;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.conversation-form .btn-cont .btn {
    margin-top: 7px;
}

.btn:not(.btn-sm):not(.btn-lg) {
    line-height: 1.44;
}
.btn:not(.md-skip) {
    font-size: 12px;
    transition: box-shadow .28s cubic-bezier(.4,0,.2,1);
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    -ms-border-radius: 2px;
    -o-border-radius: 2px;
    border-radius: 2px;
    overflow: hidden;
    position: relative;
    user-select: none;
    padding: 8px 14px 7px;
}

.btn:not(.md-skip)>i {
    margin-top: 0;
    margin-left: 3px;
    margin-right: 3px;
}

[class*=" fa-"]:not(.fa-stack), [class*=" glyphicon-"], [class*=" icon-"], [class^=fa-]:not(.fa-stack), [class^=glyphicon-], [class^=icon-] {
    display: inline-block;
    line-height: 14px;
    -webkit-font-smoothing: antialiased;
}
.klogo {
    width: 106px;
    height: 17px;
}

.ms-container {
    width: 100%;
    max-width: 510px;
}

.active-bar {
    border-left: 3px solid #5C9ACF!important;
}

.select2-results__group {
    font-size: 16px !important;
}

a[title="JavaScript charts"] {
    display: none !important;
}

.conversations li {
    font-size: 15px;
    line-height: 40px;
}
.conversations li.out .message {
    border-right: 2px solid  #1BBC9B;;
    margin-right: 65px;
    background: #e3fff9;
    text-align: right;
}
.conversations li.out .message .arrow {
    right: -8px;
    border-left: 8px solid #1BBC9B;
}
.conversations li.in .message {
    text-align: left;
    border-left: 2px solid #3598dc;
    margin-left: 65px;
    background: #e3e7e9;
}
.conversations li.in .message .arrow {
    left: -8px;
    width: 0;
    height: 0;
    border-right: 8px solid #3598dc;
}
.conversations li .name {
    color: #3590c1;
    font-size: 15px;
    font-weight: bold;
}
.conversations li.middle .message {
    text-align: center;
    /*margin-left: 65px;*/
    /*background: #e3fff9;*/
}

[data-toggle="collapse"] .fa:before {   
  content: "\f139";
}

[data-toggle="collapse"].collapsed .fa:before {
  content: "\f13a";
}

.pace.pace-active{
    display: none !important;
}

    </style>
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
                    <span class="caption-subject font-green-sharp sbold">CONVERSATION</span>
                    </div>
                    @if($conversations->count() > 0)
                    <div style="float: right;">
                            <img 
                                style=" max-width: 45px; max-height: 45px;" 
                                alt="profile Picture" 
                                class="img-responsive img-thumbnail img-circle" 
                                src="{{asset('assets/images/!logged-user.jpg')}}"/>
                    <span>
                        {{ showPartnerName(
                            $conversations[0]->people[0]->pivot->person_id, 
                            $conversations[0]->people[0]->pivot->other_id)
                        }}
                    </span>
                    </div>
                    @endif
                </div>
                <div class="portlet-body">
                    <div id="conversations" 
                    style="overflow:auto; height: 350px;padding: 0px;margin: 0px" data-always-visible="1" 
                    data-rail-visible1="1">
                        <ul class="conversations" id="conversation_card"> 
                        @if($conversations->count() > 0)
                        @foreach($conversations[0]->messages as $message)
                            @if(\Auth::id() != $message->person->id)
                                <li class="in">
                            @else
                                <li class="out" >
                            @endif
                                {{--<img 
                                style=" max-width: 45px; max-height: 45px;"
                                class="img-responsive img-thumbnail img-circle" 
                                alt="Profile Picture" 
                                src="{{asset('assets/images/!logged-user.jpg')}}" />--}}
                                <div class="message" style="max-height: 120px">
                                    <a><strong>{{$message->person->first_name.' '.$message->person->last_name}}</strong></a>
                                    <span class="body"><span style="word-break: break-word;">{{$message->message}}</span></span>
                                </div>
                            </li>
                            @endforeach
                            @else
                            <h4 style="margin-top: 50px;">No conversation Selected</h4>
                            @endif
                        </ul>
                    </div>
                </div>
                @if(count($conversations) > 0)
                 <form 
                    id="conversationMsg" 
                    class="form-horizontal form-bordered"
                    action="{{route('conversation.store',['conversation' => $conversations[0]->slug])}}"
                    method="POST">
                   <div class="form-body">
                            {{ csrf_field() }}
                         <input type="hidden" id="conversation_id" value="{{$conversations[0]->id}}" />
                        <input type="hidden" id="message_time" value="" />
                        <input type="hidden" id="username" value="{{Auth::user()->name}}" />
                            @if(!empty(Auth::user()->profile_pic))
                                <input type="hidden" id="picture" value="{{asset('assets/images/!logged-user.jpg')}}" />
                                @else
                                <input type="hidden" id="picture" value="{{asset('assets/images/!logged-user.jpg') }}" />
                            @endif
                            <div class="conversation-form">
                                <div class="input-cont">
                                    <input class="form-control" type="text" id="conversation_message" name="message" placeholder="Type a message here..." /> </div>
                                <div class="btn-cont">
                                    <button 
                                        type="submit" 
                                        class="btn btn-primary" 
                                        id="conversationSubmit">
                                        <i class="fa fa-check icon-white"></i>
                                    </button>
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
                          {{--
                            <input id="tags" placeholder="Search username" class="form-control"
                            --}}
                        <span class="caption-subject font-hide bold uppercase">Recent</span>
                    </div>
                </div>                
                    <div class="portlet-body inbox-sidebar">
                      <!-- Nav tabs -->
                              <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#recent" 
                                        aria-controls="recent" 
                                        role="tab" 
                                        data-toggle="tab">
                                        Recent
                                    </a>
                                </li>
                                {{--
                                <li 
                                    role="presentation">
                                    <a href="#contacts" 
                                        aria-controls="contacts" 
                                        role="tab" 
                                        data-toggle="tab"> 
                                        Contacts 
                                    </a>
                                </li>--}}
                              </ul><br>
                    <div class="tab-content">      
                        <div role="tabpanel" class="tab-pane active" id="recent">
                            <nav class="list-group navbar-default"> 
                                <div id="dashboard-sidebar" style="background-color: #fff">
                                <ul class="nav">
                                @if($conversations->count() < 1)
                                    <h4>No Recent Conversations</h4>
                                @else
                                    @foreach($conversations as $conversation)
                                        <li>
                                            <a 
                                            class="list-group-item" 
                                            href="{{route('conversation.show',['conversation' =>$conversation->slug])}}">
                                                <span class="contact-name">
                                                    {{
                                                        showPartnerName(
                                                        $conversation->people[0]->pivot->person_id, 
                                                        $conversation->people[0]->pivot->other_id)
                                                    }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                </ul>
                                </div>
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
            <img src= "{{asset('assets/images/!logged-user.jpg')}}" class = "center-block" />
        </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="userId" value="{{ \Auth::user()->id }}">

        </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
</div>
<!-- END CONTENT BODY -->

@stop

@section('js')
<script src="{{ URL::asset('assets/pages/scripts/conversation.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/plugins/jquery-ui.min.js') }}" type="text/javascript"></script>
<script>
    // $(function() {
        // var x = []
        // $.ajax({
        //     url: '/conversations/search/users',
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(data){
        //         if (data['status'] == 'success') {
        //             x[0] = data['users'];
        //                 $( "#tags" ).autocomplete({
        //                    source: x[0],
        //                    autoFocus:true,
        //                    select: function( event, ui ) {
        //                     window.location.replace("/search/lec/conversations/" + ui.item.value);
        //                   }
        //                 });
        //         }
        //     }
        // });
    // });
</script>
<script type="text/javascript">
    $(document).on('submit', '#conversationMsgg', function(event) {
    event.preventDefault();
    var input_message = $( '#conversation_message' ).val();
    var conversation_id = $( '#conversation_id' ).val();
    var message_time = $( '#message_time' ).val();
    var username = $( '#username' ).val();
    var picture = $( '#picture' ).val();        
    var token = $('input[name="_token"]').val();
    var d = $('#conversations');
    var mssag = input_message.replace(/&nbsp;/g," ");
    var messg = mssag.replace(/<br><br>/g," ");
    /*remove extra spaces before and after*/
    var msg = messg.replace(/(^\s+|\s+$)/g,"");
    var regex = msg.match(/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-]*)?\??(?:[-\+=&;%@.\w]*)#?(?:[\w]*))?)/g);
    if (regex != null) {
        for (var i = 0; i < regex.length; i++) {            
            var match = regex[i];
            var replace_match = "<a href = http://"+match+" target=\"_blank\">"+match+"</a>";
            var msg = msg.replace(match, replace_match);
             msg = msg.replace(/https:\/\/https:\/\//,"https:\/\/");
             msg = msg.replace(/http:\/\/http:\/\//,"http:\/\/");
            console.log(msg);
        }
        var message = msg;
    }
    else{
        var message = msg;
    }

if (message === "" || message === " ") {
    toastr["warning"]("Input is Empty", "Error");
        return false;
    }else{
        $('#conversation_message').val(" ");
            d.animate({scrollTop: d[0].scrollHeight}, 10);
        $('#conversation_card').append('<li class="out"> <img class="avatar" src="' + picture + ' " /><div class="message" style="max-height:120px;"><a class="name" href="javascript:;">' + username + '  </a><span class="datetime"> ' + message_time + '</span><span class="body"><span class="iamminified" style="word-break: break-word;">' + message + '</span></div></li>');
        $.ajax({
            url: '/conversations/'+ conversation_id,
            type: 'POST',
            dataType: 'json',
            data: {
                message: $.trim(message),
                username: $.trim(username),
                _token: token,
            },
            success: function(data){
                if (data['status'] == 'success') {
                    console.log(data);
                    $( '#conversation_card' ).load("/show/conversation/"+ conversation_id + " #conversation_card",function(){
                            miniMize();
                    }).animate({scrollTop: d[0].scrollHeight}, 10);
                }else{
                };
            }
        });
        
    }

});

/*conversation conversation scroll*/
// $(document).ready(function() {
//     var d = $('#conversations');
// d.scrollTop(d[0].scrollHeight);
/*d.animate({
  scrollTop: d[0].scrollHeight
}, 2000);*/
// });

</script>
@stop
