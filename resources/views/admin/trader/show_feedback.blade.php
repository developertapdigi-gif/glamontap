@extends('admin.layouts.master')
@section('title','Feedback')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2 class="mobile-hide all_post"><i class="bi bi-person-vcard"></i>All Feedback</h2>

    </div>
    
<div class = "row">
    @foreach($model as $_feedback)
    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="job-listing">
                            <div class="d-flex justify-content-between align-items-start">

                                <div class="sub-list">
                                    <h3>{{$_feedback->job->title}}</h3>
                                    <p><input class="rating trader-rating"  max="5"  step="0.05" style="--fill:orange;--value:{{$_feedback->over_all_rating}}" type="range" value="{{$_feedback->over_all_rating}}"></p>
                                    <p>{{$_feedback->comment}}</p>
                                </div>
                                
                            </div>

                        </div>

                    </div>
    
        
    @endforeach
            
</div>
<div class="row">
            <div class="skill-table-pagintion grid-pagintion  d-flex">
                {{ $model->links() }}
            </div>         
    </div>     
@endsection
