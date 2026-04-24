@extends('admin.layouts.master')

@section('title')
    {{ $model->first_name }} {{ $model->last_name }}
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <div class="page-title">
                    <h2 class="desktop-content"><i class="profile-black"></i>Sub User Profile</h2>

                    <h2 class="mobile-content"><i class="profile-black"></i>Sub User Profile</h2>
                    <div class="right-title me-0">
                        <a href="{{route('agent.edit',$model->id)}}"><button class="primary-btn blue-button"><i class="bi bi-eye bi bi-pencil-square"></i>Edit Profile</button></a>

                    </div>
                </div>
                <div class="post-job">
                    <div class="row ">
                        <div class="col-lg-3 col-md-3">
                            <div class="border-right company-detail profile-detail">
                            @php               
                                if($model->profile_picture && (File::exists(public_path($model->profile_picture)))){
                                    $thumbnail = asset($model->profile_picture);
                                }else{
                                    $thumbnail = url('/').'/images/company-name.png';
                                }                           
                            @endphp
                                <img src="{{ $thumbnail}}" />
                                <h4>{{$model->first_name}}</h4>
                                <!-- <p><a href="#">{{ ($model->user_type == 1)?'Super Admin': 'Construction Company' }}</a></p> -->
                                <div class="row">
                                    <div class="col-md-12 mt-5  mb-4 d-flex center-align">
                                        <i class="bi bi-geo-alt-fill me-1 border-icon "></i> <div class="tradies_profile_text">{{$model->address}}</div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    @if($model->mobile)
                                    <div class="col-md-12  mt-4  mb-3 d-flex center-align"><i class="bi bi-telephone-fill me-1 border-icon "></i> <div class="tradies_profile_text">{{$model->mobile}}</div></div>
                                    @endif
                                    <div class="col-md-12  mt-4  mb-4 d-flex center-align"><i class="bi bi-envelope-fill me-1 border-icon "></i><div class="tradies_profile_text">{{ $model->email }}</div></div>
                                </div>
                                
                            </div>


                           
                        </div>


                    <div class="col-md-9">
                        <div class="row profile-detail-desc">
                            <div class="col-md-12 white-background">
                                <div class="company-detail-1 profile-detail-1">
                                    <h4> Info</h4>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-4">
                                            <b>First Name</b>
                                            <p>{{$model->first_name}}</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <b>Last Name</b>
                                            <p>{{$model->last_name}}</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <b>Address</b>
                                            <p>{{$model->address}}</p>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        
                                        <div class="col-md-4 col-sm-4">
                                        <b>ACN Details</b>
                                        <p>{{$model->abn_acn}}</p>
                                        </div>
                             
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-lg-7 col-xl-8 ps-md-0 ps-lg-0 mt-3">
                                <div class="table-responsive dashboard-table">

                                    <div class="table-title">
                                        <b> Recent Job Posts</b>
                                        <a class = "ms-auto" href="{{route('job.index')}}"><button class="transparent-button">View All</button></a>
                                    </div>
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Job Name</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Wall Painting</td>
                                                <td>06 Sept 2024</td>
                                                <td>800 Howard Ave, New Haven,..</td>
                                                
                                                <td><span class='skill-red-warning'>Pending</span></td>
                                            </tr>
                                            <tr>
                                            <td>Wall Painting</td>
                                                <td>06 Sept 2024</td>
                                                <td>c1/210 Willoughby Rd, St Leonards...</td>
                                                
                                                <td><span class='skill-yellow-warning'>Inprogress</span></td>
                                            </tr>
                                            <tr>
                                            <td>Wall Painting</td>
                                                <td>06 Sept 2024</td>
                                                <td>Grand Commercial Tower, ...</td>
                                                
                                                <td><span class='skill-yellow-warning'>Inprogress</span></td>
                                            </tr>
                                            <tr>
                                            <td>Wall Painting</td>
                                                <td>06 Sept 2024</td>
                                                <td>4650 Harrison Blvd, Ogden, UT...</td>
                                                
                                                <td><span class='skill-red-warning'>Pending</span></td>
                                            </tr>
                                            <tr>
                                            <td>Wall Painting</td>
                                                <td>06 Sept 2024</td>
                                                <td>03/251 Oxford St, Bondi Junction..</td>
                                                
                                                <td><span class='skill-activate'>Completed</span></td>
                                            </tr>
                                            <tr>
                                            <td>Wall Painting</td>
                                                <td>06 Sept 2024</td>
                                                <td>4650 Harrison Blvd, Ogden, UT...</td>
                                                
                                                <td><span class='skill-activate'>Completed</span></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <div class="skill-table-pagintion d-flex">
                                        <span> Showing 5 of 25 records</span>
                                        <nav aria-label="Page navigation example float-right">
                                            <ul class="pagination">
                                                <li class="page-item"><a class="page-link" href="#"><i
                                                            class="bi bi-arrow-left"></i></a></li>
                                                <li class="page-item"><a class="page-link active" href="#">1</a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item"><a class="page-link" href="#"><i
                                                            class="bi bi-arrow-right"></i></a></li>
                                            </ul>
                                        </nav>
                                    </div>


                                </div>
                            </div>

                            <div class="col-md-12 col-lg-5 col-xl-4 mt-3 pe-md-0 pe-lg-0">
                                <div class="dashboard-listing">
                                    <div class="listing-title">
                                        <b>Completed Jobs</b>
                                        <a class = "ms-auto" href="{{route('job.index',['type' => 'Completed'])}}"><button class="transparent-button">View All</button></a>
                                    </div>
                                    <div class="listing-item  clearfix">
                                    <i class="tick-check"><img  src="{{asset('images/icons/tick.jpg')}}" alt=""></i>
                                        <div style="width:90%">
                                            <h4><a href="#">Ironworks Subscription Nearing Expiry</a></h4>
                                            <p>40 E 7th St, New York, NY 10003, USA.</p>
                                        </div>
                                    </div>
                                    <div class="listing-item clearfix">
                                    <i class="tick-check"><img  src="{{asset('images/icons/tick.jpg')}}" alt=""></i>
                                        <div style="width:90%">
                                            <h4><a href="#">Blueprint Subscription Nearing Expiry</a></h4>
                                            <p>40 E 7th St, New York, NY 10003, USA.</p>
                                        </div>
                                    </div>

                                    <div class="listing-item clearfix ">
                                    <i class="tick-check"><img  src="{{asset('images/icons/tick.jpg')}}" alt=""></i>
                                        <div style="width:90%">
                                            <h4><a href="#">Ironworks Subscription Nearing Expiry</a></h4>
                                            <p>40 E 7th St, New York, NY 10003, USA.</p>
                                        </div>
                                    </div>
                                    <div class="listing-item clearfix">
                                    <i class="tick-check"><img  src="{{asset('images/icons/tick.jpg')}}" alt=""></i>
                                        <div style="width:90%">
                                            <h4><a href="#">Homesmiths Subscription Nearing Expiry</a></h4>
                                            <p>40 E 7th St, New York, NY 10003, USA.</p>
                                        </div>
                                    </div>

                                    <div class="listing-item last-item clearfix">
                                    <i class="tick-check"><img  src="{{asset('images/icons/tick.jpg')}}" alt=""></i>
                                        <div style="width:90%">
                                            <h4><a href="#">Homesmiths Subscription Nearing Expiry</a></h4>
                                            <p>40 E 7th St, New York, NY 10003, USA.</p>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>   

@endsection