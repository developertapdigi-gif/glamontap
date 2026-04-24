@extends('admin.layouts.master')
@section('title','Jobs')
@section('content')

<div class="container-fluid middle-content dashboard-content">
                <div class="page-title mobile-page-title">
                    <h2 class="desktop-content"><i class="jobs-black"></i>Jobs</h2>
                    <div class="middle-title job-middle-title">
                        <button class="primary-btn blue-button">New</button>
                        <button class="primary-btn white-button">Ongoing</button>
                        <button class="primary-btn white-button">Upcoming</button>
                        <button class="primary-btn white-button">Completed</button>
                    </div>
                    <h2 class="mobile-content"><i class="jobs-black"></i>Jobs</h2>
                    <div class="right-filter job-right-filter">
            <a data-bs-toggle="collapse" href="#collapseExample" class="filter-text" aria-expanded="false" aria-controls="collapseExample"><i class="bi bi-sliders"></i>
<b>Filter</b></a> | &nbsp;
                        Showing {{$count}} Results
                     
                        <ul id="collapseExample" class="collapse dropdown-menu dropdown-menu-end  dropdown-menu-left-arrow notifications">
                            <li class="dropdown-header">
                                <div class="form-check filter-block">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                      List View
                                    </label>
                                </div>
                                <div class="form-check filter-block">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Grid View
                                    </label>
                                </div>
                               
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="notification-item">
                                <div>
                                    <b>Skill Category</b>
                                    <select class="form-select mt-1">
                                        <option>Painter</option>
                                      </select>
                                      
                                </div>
                            </li>
                        </ul>
                    
                    </div>
                </div>
                <div class="row">
                  @foreach($model as $detail)
                    
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="job-listing">
                            <div class="d-flex justify-content-between align-items-start">
            
                                <div>
                                    <h3>{{$detail->title}}</h3>
                                    <p>Start Date - <b>{{date('d M Y',strtotime($detail->start_date))}}</b></p>
                                    <p>End Date - <b>{{date('d M Y',strtotime($detail->end_date))}}</b></p>
                                </div>
                                <img title="job logo" src="../images/icons/job-list1.png" />
                            </div>

                            <div class="amount">${{$detail->minimum_price}} - ${{$detail->maximum_price}}</div>
                            <p>No of employees - <b>{{ $detail->number_of_employees}} employess</b></p>
                            <div class="address"><img src="../images/icons/address.png" />{{$detail->location}}</div>
                            <p class="job-rating">Rating - &nbsp;
                            <div id="full-stars-example" class="d-inline-block">
                                <div class="rating-group">
                                    <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating-1" value="1" type="radio">
                                    <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating-2" value="2" type="radio">
                                    <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating-3" value="3" type="radio"
                                    checked>
                                    <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating-4" value="4" type="radio">
                                    <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating-5" value="5" type="radio">
                                </div>
                            </div>
                            </p>
                            <hr />
                            <div class="d-flex justify-content-between align-items-center view-detail">
                                <div><i class="bi bi-map-fill"></i><a> View Map</a></div>
                                <i class="bi bi-arrow-down-right-circle-fill"></i>
                            </div>
                        </div>

                    </div>
                    @endforeach
                   
                    
                    
                    
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                          <li class="page-item"><a class="page-link" href="#"><i class="bi bi-arrow-left"></i></a></li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link active" href="#">2</a></li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item"><a class="page-link" href="#"><i class="bi bi-arrow-right"></i></a></li>
                        </ul>
                      </nav>
                </div>

@endsection