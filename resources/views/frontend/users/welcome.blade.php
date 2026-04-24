@extends('frontend.layouts.master')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
       <h2 class="mobile-hide"><i class="home-black"></i>Dashboard</h2>
       <div class="right-title">
          <a href="{{ route('job.create') }}"><button class="primary-btn blue-button"><i class="icon-plus"></i>New Jobs</button></a>
          <a href="{{ route('job.index') }}"><button class="primary-btn black-button"><i class="icon-eye"></i>Jobs</button></a>
       </div>
    </div>
    <!-- First Row -->
    <div class="row equal-height-row">
       <div class="col-lg-7 col-sm-12">
          <div class="row">
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card blue-card">
                   <i class="trades-tile"></i>
                   <div class="stat-card-text">Total Jobs</div>
                   <div class="stat-card-number">1305</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card orange-card">
                   <i class="agencies-tile"></i>
                   <div class="stat-card-text">Ongoing Jobs</div>
                   <div class="stat-card-number">50</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card green-card">
                   <i class="jobs-tile"></i>
                   <div class="stat-card-text">Upcoming Jobs</div>
                   <div class="stat-card-number">43</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card black-card">
                   <i class="skill-tile"></i>
                   <div class="stat-card-text">New Jobs</div>
                   <div class="stat-card-number">15</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card grey-card">
                   <i class="badge-tile"></i>
                   <div class="stat-card-text">Endrosement posts</div>
                   <div class="stat-card-number">03</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card rust-card">
                   <i class="subscription-tile"></i>
                   <div class="stat-card-text">Subscription Limits</div>
                   <div class="stat-card-number">15</div>
                </div>
             </div>
          </div>
       </div>
       <div class="col-lg-5  col-sm-12 white-backgound">
          <div class="table-responsive dashboard-table fix-height-table">
             <div class="table-title">
                <b> Ongoing Jobs</b>
                <button class="transparent-button">View All</button>
             </div>
             <table class="table ">
                <thead>
                   <tr>
                      <th scope="col"></th>
                      <th scope="col">Name</th>
                      <th scope="col">Location</th>
                      <th scope="col">Requirement</th>
                      <th scope="col">Rating</th>
                      <th scope="col">Actions</th>
                   </tr>
                </thead>
                <tbody>
                   <tr>
                      <th scope="row"><img src="../../images/icons/brand-logo1.png" /></th>
                      <td>Steelbird</td>
                      <td>800 Howard Ave, New Haven,..</td>
                      <td>101</td>
                      <td>
                         <div id="full-stars-example">
                            <div class="rating-group">
                               <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-1" value="1"
                                  type="radio">
                               <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-2" value="2"
                                  type="radio">
                               <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-3" value="3"
                                  type="radio" checked>
                               <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-4" value="4"
                                  type="radio">
                               <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-5" value="5"
                                  type="radio">
                            </div>
                         </div>
                      </td>
                      <td><i class="fa fa-eye view-entry active"></i></td>
                   </tr>
                   <tr>
                      <th scope="row"><img src="../../images/icons/brand-logo2.png" /></th>
                      <td>Brick & Mortar</td>
                      <td>c1/210 Willoughby Rd, St Leonards...</td>
                      <td>20</td>
                      <td>
                         <div id="full-stars-example">
                            <div class="rating-group">
                               <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-1" value="1"
                                  type="radio">
                               <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-2" value="2"
                                  type="radio">
                               <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-3" value="3"
                                  type="radio" checked>
                               <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-4" value="4"
                                  type="radio">
                               <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-5" value="5"
                                  type="radio">
                            </div>
                         </div>
                      </td>
                      <td><i class="fa fa-eye view-entry"></i></td>
                   </tr>
                   <tr>
                      <th scope="row"><img src="../../images/icons/brand-logo1.png" /></th>
                      <td>Solid Solutions</td>
                      <td>Grand Commercial Tower, ...</td>
                      <td>50</td>
                      <td>
                         <div id="full-stars-example">
                            <div class="rating-group">
                               <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-1" value="1"
                                  type="radio">
                               <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-2" value="2"
                                  type="radio">
                               <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-3" value="3"
                                  type="radio" checked>
                               <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-4" value="4"
                                  type="radio">
                               <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-5" value="5"
                                  type="radio">
                            </div>
                         </div>
                      </td>
                      <td><i class="fa fa-eye view-entry"></i></td>
                   </tr>
                   <tr>
                      <th scope="row"><img src="../../images/icons/brand-logo1.png" /></th>
                      <td>Ironworks</td>
                      <td>4650 Harrison Blvd, Ogden, UT...</td>
                      <td>10</td>
                      <td>
                         <div id="full-stars-example">
                            <div class="rating-group">
                               <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-1" value="1"
                                  type="radio">
                               <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-2" value="2"
                                  type="radio">
                               <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-3" value="3"
                                  type="radio" checked>
                               <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-4" value="4"
                                  type="radio">
                               <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-5" value="5"
                                  type="radio">
                            </div>
                         </div>
                      </td>
                      <td><i class="fa fa-eye view-entry"></i></td>
                   </tr>
                   <tr>
                      <th scope="row"><img src="../../images/icons/brand-logo4.png" /></th>
                      <td>Rock Solid Builders</td>
                      <td>03/251 Oxford St, Bondi Junction..</td>
                      <td>5</td>
                      <td>
                         <div id="full-stars-example">
                            <div class="rating-group">
                               <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-1" value="1"
                                  type="radio">
                               <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-2" value="2"
                                  type="radio">
                               <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-3" value="3"
                                  type="radio" checked>
                               <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-4" value="4"
                                  type="radio">
                               <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-5" value="5"
                                  type="radio">
                            </div>
                         </div>
                      </td>
                      <td><i class="fa fa-eye view-entry"></i></td>
                   </tr>
                   <tr>
                      <th scope="row"><img src="../../images/icons/brand-logo3.png" /></th>
                      <td>Larry the Bird</td>
                      <td>4650 Harrison Blvd, Ogden, UT...</td>
                      <td>80</td>
                      <td>
                         <div id="full-stars-example">
                            <div class="rating-group">
                               <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-1" value="1"
                                  type="radio">
                               <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-2" value="2"
                                  type="radio">
                               <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-3" value="3"
                                  type="radio" checked>
                               <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-4" value="4"
                                  type="radio">
                               <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                  class="rating__icon rating__icon--star fa fa-star"></i></label>
                               <input class="rating__input" name="rating" id="rating-5" value="5"
                                  type="radio">
                            </div>
                         </div>
                      </td>
                      <td><i class="fa fa-eye view-entry"></i></td>
                   </tr>
                </tbody>
             </table>
          </div>
       </div>
    </div>
    <!-- Second Row -->
    <div class="row">
               <!--interactive-table-->
               <div class="col-lg-4 col-sm-12">
                  <div class="bar-chart">
                     <div class="table-title">
                        <b> Job Status</b>
                        <button class="transparent-button">View All</button>
                     </div>
                     <canvas id="myChart" width="900" height="600"></canvas>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-12">
                  <div class="table-responsive dashboard-table">
                     <div class="table-title">
                        <b> Upcoming Jobs</b>
                        <button class="transparent-button">View All</button>
                     </div>
                     <table class="table">
                        <thead>
                           <tr>
                              <th scope="col"></th>
                              <th scope="col">Name</th>
                              <th scope="col">Skill</th>
                              <th scope="col">Rating</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <th scope="row"><img src="../../images/icons/brand-logo1.png" /></th>
                              <td>Steelbird</td>
                              <td>800 Howard Ave, New Haven,..</td>
                              <td>
                                 <div id="full-stars-example">
                                    <div class="rating-group">
                                       <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-1" value="1"
                                          type="radio">
                                       <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-2" value="2"
                                          type="radio">
                                       <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-3" value="3"
                                          type="radio" checked>
                                       <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-4" value="4"
                                          type="radio">
                                       <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-5" value="5"
                                          type="radio">
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row"><img src="../../images/icons/brand-logo2.png" /></th>
                              <td>Brick & Mortar</td>
                              <td>Wall Paintiong</td>
                              <td>
                                 <div id="full-stars-example">
                                    <div class="rating-group">
                                       <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-1" value="1"
                                          type="radio">
                                       <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-2" value="2"
                                          type="radio">
                                       <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-3" value="3"
                                          type="radio" checked>
                                       <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-4" value="4"
                                          type="radio">
                                       <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-5" value="5"
                                          type="radio">
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row"><img src="../../images/icons/brand-logo2.png" /></th>
                              <td>Brick & Mortar</td>
                              <td>Auto Mechanic</td>
                              <td>
                                 <div id="full-stars-example">
                                    <div class="rating-group">
                                       <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-1" value="1"
                                          type="radio">
                                       <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-2" value="2"
                                          type="radio">
                                       <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-3" value="3"
                                          type="radio" checked>
                                       <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-4" value="4"
                                          type="radio">
                                       <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-5" value="5"
                                          type="radio">
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row"><img src="../../images/icons/brand-logo1.png" /></th>
                              <td>Solid Solutions</td>
                              <td>Plumber</td>
                              <td>
                                 <div id="full-stars-example">
                                    <div class="rating-group">
                                       <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-1" value="1"
                                          type="radio">
                                       <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-2" value="2"
                                          type="radio">
                                       <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-3" value="3"
                                          type="radio" checked>
                                       <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-4" value="4"
                                          type="radio">
                                       <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-5" value="5"
                                          type="radio">
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row"><img src="../../images/icons/brand-logo1.png" /></th>
                              <td>Ironworks</td>
                              <td>Solar Technician</td>
                              <td>
                                 <div id="full-stars-example">
                                    <div class="rating-group">
                                       <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-1" value="1"
                                          type="radio">
                                       <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-2" value="2"
                                          type="radio">
                                       <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-3" value="3"
                                          type="radio" checked>
                                       <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-4" value="4"
                                          type="radio">
                                       <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-5" value="5"
                                          type="radio">
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row"><img src="../../images/icons/brand-logo4.png" /></th>
                              <td>Sanitation Worker</td>
                              <td>Electrition</td>
                              <td>
                                 <div id="full-stars-example">
                                    <div class="rating-group">
                                       <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-1" value="1"
                                          type="radio">
                                       <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-2" value="2"
                                          type="radio">
                                       <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-3" value="3"
                                          type="radio" checked>
                                       <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-4" value="4"
                                          type="radio">
                                       <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-5" value="5"
                                          type="radio">
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <th scope="row"><img src="../../images/icons/brand-logo3.png" /></th>
                              <td>Larry the Bird</td>
                              <td>Sanitation Worker</td>
                              <td>
                                 <div id="full-stars-example">
                                    <div class="rating-group">
                                       <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-1" value="1"
                                          type="radio">
                                       <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-2" value="2"
                                          type="radio">
                                       <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-3" value="3"
                                          type="radio" checked>
                                       <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-4" value="4"
                                          type="radio">
                                       <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                          class="rating__icon rating__icon--star fa fa-star"></i></label>
                                       <input class="rating__input" name="rating" id="rating-5" value="5"
                                          type="radio">
                                    </div>
                                 </div>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-12">
                  <div class="dashboard-listing">
                     <div class="listing-title">
                        <b> Recently Activity</b>
                        <button class="transparent-button">View All</button>
                     </div>
                     <div class="listing-item clearfix">
                        <img src="../../images/icons/brand-logo3.png" alt="">
                        <div style="width:80%">
                           <h4><a href="#">Ironworks Subscription Nearing Expiry</a></h4>
                           <p>40 E 7th St, New York, NY 10003, USA.</p>
                        </div>
                        <small>23 may</small>
                     </div>
                     <div class="listing-item clearfix">
                        <img src="../../images/icons/brand-logo3.png" alt="">
                        <div style="width:80%">
                           <h4><a href="#">Blueprint Subscription Nearing Expiry</a></h4>
                           <p>40 E 7th St, New York, NY 10003, USA.</p>
                        </div>
                        <small>13 may</small>
                     </div>
                     <div class="listing-item clearfix">
                        <img src="../../images/icons/brand-logo3.png" alt="">
                        <div style="width:80%">
                           <h4><a href="#">Ironworks Subscription Nearing Expiry</a></h4>
                           <p>40 E 7th St, New York, NY 10003, USA.</p>
                        </div>
                        <small>23 may</small>
                     </div>
                     <div class="listing-item clearfix">
                        <img src="../../images/icons/brand-logo3.png" alt="">
                        <div style="width:80%">
                           <h4><a href="#">Homesmiths Subscription Nearing Expiry</a></h4>
                           <p>40 E 7th St, New York, NY 10003, USA.</p>
                        </div>
                        <small>8 may</small>
                     </div>
                     <div class="listing-item clearfix">
                        <img src="../../images/icons/brand-logo4.png" alt="">
                        <div style="width:80%">
                           <h4><a href="#">Homesmiths Subscription Nearing Expiry</a></h4>
                           <p>40 E 7th St, New York, NY 10003, USA.</p>
                        </div>
                        <small>8 may</small>
                     </div>
                  </div>
               </div>
            </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/charts.js') }}"></script>
<script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb" , "March" , "April", "March", "April","May", "June" , "July" , "Aug", "Sep", "Oct","Nov", "Dec"],
        datasets: [
            {
                label: '# of students',
                data: [105,124,78,91,62,56,105,124,78,91,62,56,62,56],
                backgroundColor :['rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
                ],

                borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
                ],
                borderWidth : 1
            }
        ]
    },
    options: {
        scales: {
            yAxes: [
                {
                    ticks: {
                        beginAtZero:true
                    }
                }
            ]
        }
    }
});
</script>
@endsection
