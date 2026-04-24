@extends('admin.layouts.master')
@section('title')
Dashboard
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
       <h2 class="mobile-hide"><i class="home-black"></i>Dashboard</h2>
       <div class="right-title">
         <a href="{{ route('plans.create') }}" class="text-white"><button class="primary-btn blue-button"><i class="icon-plus"></i>New Subscription Plan</button></a>
          <a href ="{{ route('skill-categories.index') }}" class="primary-btn black-button"><i class="icon-eye"></i>Skill Categories</a>
       </div>
    </div>
    <!-- First Row -->
    <div class="row equal-height-row">
       <div class="col-lg-7 col-sm-12">
          <div class="row">
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card blue-card">
                   <i class="trades-tile"></i>
                   <div class="stat-card-text">Registered Tradies</div>
                   <div class="stat-card-number">{{$traders->total()}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card orange-card">
                   <i class="agencies-tile"></i>
                   <div class="stat-card-text">Registered Companies</div>
                   <div class="stat-card-number">{{$agencies->total()}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card green-card">
                   <i class="jobs-tile"></i>
                   <div class="stat-card-text">Jobs Posted</div>
                   <div class="stat-card-number">{{$totaljobs}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card black-card">
                   <i class="skill-tile"></i>
                   <div class="stat-card-text">Skill Categories</div>
                   <div class="stat-card-number">{{$skill_category}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card grey-card">
                   <i class="badge-tile"></i>
                   <div class="stat-card-text">Badges</div>
                   <div class="stat-card-number">{{$badges}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card rust-card">
                   <i class="subscription-tile"></i>
                   <div class="stat-card-text">Subscription</div>
                   <div class="stat-card-number">{{$plans}}</div>
                </div>
             </div>
          </div>
       </div>
       <div class="col-lg-5  col-sm-12 white-backgound">
          <div class="dashboard-table fix-height-table">
             <div class="table-title">
                <b> Registered Companies</b>
                <a class="ms-auto" href="{{ route('agency.index') }}"><button class="transparent-button">View All</button></a>
             </div>
             <div class="table-responsive">
             <table class="table table-no-wrap">
                <thead>
                   <tr>
                      <th scope="col"></th>
                      <th scope="col">Name</th>
                      <th scope="col">Location</th>
                      <th scope="col">Jobs</th>
                      <th scope="col" class="text-center">Rating</th>
                      <th scope="col">Actions</th>
                   </tr>
                </thead>
                <tbody>
                  @foreach($agencies as $_agency)
                  @php
                     $thumbnail= '';
                        if($_agency->logo){
                           $thumbnail = asset($_agency->logo);
                        }else{
                           $thumbnail = asset('/images/icons/brand-logo1.png');
                        }
                     @endphp
                     <tr>
                     <td><img src="{{$thumbnail}}" class="profile-image"/></td>
                        <td>{{$_agency->agency_name}}</td>
                        <td>{{mb_strimwidth(ucfirst($_agency->address),0,15,'...')}}</td>
                        <td class="text-center">{{$_agency->completed_jobs??0}}</td>
                        <td class="text-center">
                           <div id="full-stars-example">
                              <input class="rating"  max="5"  step="0.05" style="--fill:orange;--value:{{$_agency->over_all_rating??0}}" type="range" value="{{$_agency->over_all_rating??0}}">
                           </div>
                        </td>
                        <td><a href="{{route('agency.show', $_agency->id)}}"><i class="fa fa-eye view-entry"></i></a></td>
                     </tr>
                  @endforeach
                </tbody>
             </table>
             </div>
          </div>
       </div>
    </div>
    <!-- Second Row -->
    <div class="row">
               <!--interactive-table-->
               <div class="col-lg-4 col-sm-12">
                  <div class="bar-chart">
                     <div class="table-title">
                        <b> Subscription This Month</b>
                        <span class="chart-total">${{$totalEarnings}}</span>
                     </div>
                     <div id="myChart" width="900" height="600"></div> 
                  </div>
               </div>
               <div class="col-lg-4 col-sm-12">
                  <div class="dashboard-table">
                     <div class="table-title">
                        <b> Registered Tradies</b>
                        <a class="ms-auto" href="{{ route('trader.index') }}"><button class="transparent-button">View All</button></a>
                     </div>
                     <div class="table-responsive">
                     <table class="table table-no-wrap">
                        <thead>
                           <tr>
                              <th scope="col"></th>
                              <th scope="col">Name</th>
                              <th scope="col">Skill</th>
                              <th scope="col" class="text-center">Rating</th>
                           </tr>
                        </thead>
                        <tbody>
                        @foreach($traders as $_trader)
                        @php
                        $thumbnail= '';
                           if($_trader->profile_picture){
                              $thumbnail = asset($_trader->profile_picture);
                           }else{
                              $thumbnail = asset('/images/icons/brand-logo1.png');
                           }
                        @endphp
                           <tr>
                              <th scope="row"><img src="{{$thumbnail}}" class="profile-image"/></th>
                              <td>{{$_trader->first_name}} {{$_trader->last_name}}</td>
                              <td>{{($_trader->SkillCategory)?$_trader->skillCategory->name:'NA'}}</td>
                              <td class="text-center">
                              <div class="full-stars-example">
                              <input class="rating"  max="5"  step="0.05" style="--fill:orange;--value:{{$_trader->over_all_rating??0}}" type="range" value="{{$_trader->over_all_rating??0}}">
                                 </div>
                              </td>
                           </tr>
                           @endforeach
                           
                        </tbody>
                     </table>
                        </div>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-12">
                  <div class="dashboard-listing">
                     <div class="listing-title">
                        <b> Subscription Expired This Month</b>
                        <a class="ms-auto" href="{{ route('subscriber.view',['status'=>'3']) }}"><button class="transparent-button">View All</button></a>
                     </div>
                     @php 
                     $text ='';
                     if(count($subscribers)){
                     @endphp
                        @foreach($subscribers as $_subscribe)
                        <div class="listing-item clearfix">
                        <img src="{{($_subscribe->agency->logo)?asset($_subscribe->agency->logo):'../../images/icons/brand-logo3.png'}}" alt="" class="profile-image">
                        <div style="width:80%">
                           <h4><a href="#">{{$_subscribe->agency->agency_name}}</a></h4>
                           <p>{{date('d M',strtotime($_subscribe->start_date))}}</p>
                        </div>
                        <small>{{date('d M',strtotime($_subscribe->end_date))}}</small>
                     </div>
                        @endforeach
                     @php 
                     }else{
                        $text = 'No Result Found';
                     }
                     @endphp
                    <p class="ms-4"> {{$text}}</P>
                     
                     
                  </div>
               </div>
            </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/apexcharts.min.js') }}"></script>  
<script>      
        fetch('/earnings-data')
        .then(response => response.json())
        .then(({ labels, data }) => {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Earnings',
                    data: data
                }],
                xaxis: {
                    categories: labels
                },
                
                colors: ['#008FFB']
            };

            var chart = new ApexCharts(document.querySelector("#myChart"), options);
            chart.render();
        });

  
 
</script>
@endsection