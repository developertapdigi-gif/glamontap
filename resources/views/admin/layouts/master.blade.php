@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ $model['favicon'] }}" rel="icon" type="image/x-icon">
    <title>@yield('title') | {{$model['name_of_website']}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <META NAME="robots" CONTENT="noindex,nofollow">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-rating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link href="{{ asset('fortawesome/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swg.css') }}">
    @yield('css')
</head>
<body class="index-page">
 <div class="loader" style="display: none;"></div>   
<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
        @include('admin.layouts.leftmenu')
    </nav>
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light">
            @include('admin.layouts.topmenu')
        </nav>
        @include('flash-message')
        @yield('content')
        <div class="footer"> All Rights Reserved by {{$model['name_of_website']}} @ 2024</div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/swg.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-rating.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
@yield('script')<style type="text/css">
    #search-results {
    border: 1px solid #eee;
    max-height: 200px;
    overflow-y: auto;
    padding: 10px;
    display: none;
}
#search-results div {
    padding: 5px 0;
    /* border-bottom: 1px solid #eee; */
}
</style>
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
<script type="text/javascript">
$(document).ready(function(){
  setTimeout(function() { $(".alert").alert('close'); },5000);

  $('#search-input').on('input', function () {
            let query = $(this).val();

            if (query.length > 2) {
                $.ajax({
                    url: "{{ route('global.search') }}",
                    method: "GET",
                    data: { query: query },
                    success: function (response) {
                        let resultsHtml = '';
                        
                        response.agencies.forEach(agency => {
                            if(agency){
                                if (agency.agency_name.toLowerCase().includes(query.toLowerCase())) {
                                    resultsHtml += `<div><a href="/agency/${agency.id}"> ${agency.agency_name} in Agency</a></div>`;
                                }else if(agency.first_name.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/agency/${agency.id}"> ${agency.first_name} in Agency</a></div>`;
                                }else if(agency.last_name.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/agency/${agency.id}"> ${agency.last_name} in Agency</a></div>`;
                                }else if(agency.address.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/agency/${agency.id}"> ${agency.address} in Agency</a></div>`;
                                }else if(agency.email.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/agency/${agency.id}"> ${agency.email} in Agency</a></div>`;
                                }

                            }
                        });
                        response.traders.forEach(trader => {
                            if(trader){
                                if(trader.first_name.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/trader/${trader.id}"> ${trader.first_name} in Trader</a></div>`;
                                }else if(trader.last_name.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/trader/${trader.id}"> ${trader.first_name} in Trader</a></div>`;
                                }
                                else if(trader.address.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/trader/${trader.id}"> ${trader.first_name} in Trader</a></div>`;
                                }else if(trader.email.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/trader/${trader.id}"> ${trader.email} in Trader</a></div>`;
                                }
                            }
                        });
                        response.sub_users.forEach(sub_user => {
                            if(sub_user){
                                if(sub_user.first_name.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/agent/${sub_user.id}"> ${sub_user.first_name} in Sub Users</a></div>`;
                                }else if(sub_user.last_name.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/agent/${sub_user.id}"> ${sub_user.last_name} in Sub Users</a></div>`;
                                }
                                else if(sub_user.address.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/agent/${sub_user.id}"> ${sub_user.address} in Sub Users</a></div>`;
                                }else if(sub_user.email.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/agent/${sub_user.id}"> ${sub_user.email} in Sub Users</a></div>`;
                                }
                            }
                        });
                        response.skills.forEach(skill => {
                            if(skill)
                            resultsHtml += `<div><a href="/skill-categories/${skill.id}"> ${skill.name} in skill category</a></div>`;
                        });
                        response.posts.forEach(post => {
                            if(post){
                                if(post.title.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/job/${post.id}"> ${post.title} in Job Post</a></div>`;
                                }else if(post.location.toLowerCase().includes(query.toLowerCase())){
                                    resultsHtml += `<div><a href="/job/${post.id}"> ${post.location} in Job Post</a></div>`;
                                }
                            }
                        });
                        response.subscription_plan.forEach(plan => {
                            if(plan)
                            resultsHtml += `<div><a href="/plans"> ${plan.name} in Plan</a></div>`;
                        });
                        $('#search-results').show();
                       
                        $('#search-results').html(resultsHtml);
                        
                        if(response.data == 'no')
                        $('#search-results').html('No Result Found');
                    },
                    error: function () {
                        $('#search-results').html('<div>Error occurred.</div>');
                    }
                });
            } else {
                $('#search-results').css('display', 'none');
            }
  });
});
 $('.mark-as-read-btn').on('click', function () {
        const notificationId = $(this).data('id');
        $.ajax({
            url: '{{ route("notifications.markAsRead") }}',
            type: 'POST',
            data: {
                id: notificationId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success ==true) {
                   location.reload();
                }
            }
        });
    });
</script>
</body>
</html>
