@extends('admin.layouts.master')
@section('title')
Endorsement Post Detail
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <div class="page-title post-wall">
                    <h2 class="desktop-content"><i class="endorsments-black"></i>Endorsement Post Detail</h2>

                    <h2 class="mobile-content"><i class="endorsments-black"></i>Endorsement Post Detail</h2>
                    <div class="right-title me-0">
                        @php 
                        if($model->endorsementStatus->status == 1 || $model->endorsementStatus->status == 2){
                       
                        }else{
                            @endphp
                        <button class="primary-btn blue-button" onclick="endroseRecord({{$model->id}},1)"><i class="bi bi-check bi-accept"></i>Accept</button>
                    <button class="primary-btn black-button" onclick="endroseRecord({{$model->id}},2)"><i class="bi bi-ban bi-reject bi-bold"></i>Reject</button>
                        @php 
                        }
                        @endphp
                    </div>
                </div>
                <div class="post-job">
                    <div class="row white-background">
                        <div class="col-md-12 col-lg-7 border-right">
                            <div class="row">
                                <div class="col-md-12 col-lg-5 border-right company-detail">
                                @php   
                                    if($model->author->profile_picture){
                                        $thumbnail = asset($model->author->profile_picture);
                                    }else{
                                        $thumbnail = asset('/images/icons/user.svg');
                                    }                       
                                @endphp
                                    <img class ="m-auto" src="{{$thumbnail}}" />
                                    <h4>{{$model->author->first_name}}</h4>
                                    <p><i class="bi bi-geo-alt-fill me-1"></i>{{$model->author->address}}</p>
                                    
                                </div>
                                <div class="col-md-12 col-lg-7 company-detail-1">
                                    <h4> Detail</h4>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <b>Post Title</b>
                                        <p>{{ $model->title }}</p>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <b>Job Address</b>
                                        <p>{{$model->location}}</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    
                                    <div class="col-md-12">
                                    <b>Post Address</b>
                                    <p>{{$model->location}}</p>
                                    </div>
                                </div>
                                
                            </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-5 job-desc">
                            <h4> Post Description</h4>
                            <p>{{$model->content}}</p>
                        </div>
                    </div>
                    <div class="row white-background" style="margin-top:10px; border-top:1px #f2f3f8 solid; padding-top:20px;">
                    <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="row bg-white border border-neutral-200 rounded-lg lg:rounded-2xl p-4 mb-8 image_size">
                                @foreach($model->gallery as $_gallery)
                                <div data-swg data-swg-page class="col-md-3 gap-4 m-auto">
                                    @php 
                                    if($_gallery->type == 2){
                                    @endphp
                                    <video class="aspect-square object-cover w-full cursor-pointer" width="640" height="360" controls>
                                        <source src="{{asset($_gallery->path)}}" type="video/mp4">
                                    </video>
                                    @php 
                                    }else{
                                    @endphp
                                    <img class="aspect-square object-cover w-full cursor-pointer" style="width:100%;"src="{{asset($_gallery->path)}}" />
                                    @php
                                    }
                                    @endphp
                                    
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                

@endsection
<script src="{{ asset('js/tailwind.js') }}"></script>
@section('script')

<script type="text/javascript">
    function endroseRecord(id,status) {
        if(status == 1){
            popMessage = "Do you want to accept this post?";
        }else if(status == 2){
            popMessage = "Do you want to reject this post?";
        }
    if (id) {
        Swal.fire({
            text: popMessage,
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('endrosement-post.endrose') }}";
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "POST",
                    data: {id:id,status:status},
                    success: function(response) {
                        location.reload();
                        if (response.status==true) {
                            Swal.fire("Done!", "Endrosed status changed successfully.", "success");
                           
                        } else {
                            Swal.fire("Error!", "This cannot be Endrosed",
                                "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error!", "Error, Please Try Again", "error");
                    }
                });
            }
        });
    }
}

</script>
@endsection