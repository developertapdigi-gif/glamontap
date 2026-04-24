@extends('admin.layouts.master')
@section('title','Trader Posts')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2 class="mobile-hide all_post"><img src="{{(asset('/images/icons/svg/view-post.svg'))}}"> All Posts</h2>

    </div>
    <div class="current-notifications">
<div class = "row post_row">
    
    @if(count($model) == 0)
        No Result Found
    @endif
@foreach($model as $_postwall)
            
    <div id="carouselIndicators_{{$_postwall->id}}" class="carousel slide carousel_img col-lg-3 col-md-6 col-12">
    @if($_postwall)
            <div class="carousel-inner image_carousel">
                
                @if(count($_postwall->gallery))
                    @foreach($_postwall->gallery as $key=>$gallery)
                    @if($key< 5)
                        <div class="carousel-item {{($key == 0) ? 'active':''}}">
                            <a href="{{route('get.post.detail',$_postwall->id)}}">
                                @if($gallery->type == 1)
                                <img src="{{(asset($gallery->path))}}" class="w-100">
                                @elseif($gallery->type == 2)
                                <video width="320" height="240" controls>
                                <source src="{{(asset($gallery->path))}}" type="video/mp4">
                                </video>
                                @endif
                            </a>
                        </div>
                    @endif
                        
                        
                    @endforeach
                    @if(count($_postwall->gallery)>1)
                    
                    <div class="carousel-indicators">
                        @foreach($_postwall->gallery as $key=>$gallery)
                            @if($key< 5)    
                                <button type="button" data-bs-target="#carouselIndicators_{{$_postwall->id}}" data-bs-slide-to="{{$key}}" class="{{($key == 0) ? 'active':''}}" aria-label="Slide {{$key}}" aria-current="true"></button>
                                
                            @endif
                        @endforeach
                    </div>
                    @endif
                    @else
                        <div class="carousel-item active">
                            <a href="{{route('get.post.detail',$_postwall->id)}}">
                                <img src="{{(asset('/images/person1.png'))}}"
                                    class="w-100">
                            </a>
                        </div>
                    @endif
                
                        
            </div>
            <div class ="post-content">
                <span class ="date">{{date('M d, Y' ,strtotime($_postwall->created_at))}}</span>
                <a href="{{route('get.post.detail',$_postwall->id)}}"><h6>{{mb_strimwidth(ucfirst($_postwall->title),0,40,'...')}}</h6></a>
                <p>{{$_postwall->content ? ucfirst($_postwall->content) : ucfirst($_postwall->title)}} </p>
                    <div class ="post-create">
                    @php   
                        if($_postwall->author->logo && (File::exists(public_path($_postwall->author->logo)))){
                            $thumbnail = asset($_postwall->author->logo);
                        }elseif($_postwall->author->profile_picture && (File::exists(public_path($_postwall->author->profile_picture)))){
                            $thumbnail = asset($_postwall->author->profile_picture);
                        }else{
                            $thumbnail = url('/').'/images/icons/Profile.svg';
                        }                       
                    @endphp
                <img src="{{$thumbnail}}"/>
                <span>{{$_postwall->author->first_name }} {{$_postwall->author->last_name}}</span>
            </div>
            </div>
            @endif
        </div>
        @endforeach
        
</div>
<div class="row">
            <div class="skill-table-pagintion grid-pagintion  d-flex">
                {{ $model->links() }}
            </div>         
    </div>     
@endsection
@section('script')


<script type="text/javascript">
function deleteRecord(id) {
    if (id) {
        Swal.fire({
            text: "{{ __('Are you sure you want to delete ?') }}",
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, Delete!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('post-over-wall.destroy', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "DELETE",
                    success: function(response) {
                        $('#delete-' + id).remove();
                        //ajax_table.ajax.reload();
                        //console.log(('#delete-'+id))
                        if (response.data) {
                            Swal.fire("Done!", "Deleted Successfully.", "success");

                        } else {
                            Swal.fire("Error Deleting!", "This row cannot be deleted",
                                "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error Deleting!", "Error, Please Try Again", "error");
                    }
                });
            }
        });
    }
}
</script>
<style>

</style>
@endsection