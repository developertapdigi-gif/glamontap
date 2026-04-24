@php
use App\Models\Notification;

@endphp
@extends('admin.layouts.master')
@section('title')
Dashboard
@endsection
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
                <div class="stat-card black-card">
                   <i class="totaljob-grey"></i>
                   <div class="stat-card-text">Total Jobs</div>
                   <div class="stat-card-number">{{$totaljobs}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card blue-card">
                   <i class="ongoingjob-grey"></i>
                   <div class="stat-card-text">Ongoing Jobs</div>
                   <div class="stat-card-number">{{$ongoingJobs->total()}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card green-card">
                   <i class="upcomingjob-grey"></i>
                   <div class="stat-card-text">Upcoming Jobs</div>
                   <div class="stat-card-number">{{$upcomingJobs->total()}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card rust-card">
                   <i class="newjob-grey"></i>
                   <div class="stat-card-text">Opened Jobs</div>
                   <div class="stat-card-number">{{$asignedJobs->total()}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card orange-card">
                   <i class="jobs-grey"></i>
                   <div class="stat-card-text">Completed Jobs</div>
                   <div class="stat-card-number">{{$completedJobs->total()}}</div>
                </div>
             </div>
             <div class="col-lg-4 col-sm-12">
                <div class="stat-card grey-card">
                   <i class="endorsment-grey"></i>
                   <div class="stat-card-text">Endrosement Posts</div>
                   <div class="stat-card-number">{{count($endrosementposts)}}</div>
                </div>
             </div>
          </div>
       </div>
       <div class="col-lg-5  col-sm-12 white-backgound">
          <div class="dashboard-table fix-height-table">
             <div class="table-title">
                <b> Ongoing Jobs</b>
                <a class="ms-auto" href="{{ route('job.index',['status' =>4,'type' => 'Ongoing']) }}"><button  class="transparent-button">View All</button></a>
             </div>
             <div class="table-responsive">
             <table class="table table-no-wrap">
                <thead>
                   <tr>
                      <th scope="col">Job Name</th>
                      <th scope="col">Start Date</th>
                      <th scope="col">End Date</th>
                      <th scope="col">Actions</th>
                   </tr>
                </thead>
                <tbody>
                 
                  @foreach($ongoingJobs as $_ongoing_job)
                   <tr>
                      <td>{{$_ongoing_job->title}}</td>
                      <td>{{date('d M Y',strtotime($_ongoing_job->start_date))}}</td>
                      <td>{{date('d M Y',strtotime($_ongoing_job->end_date))}}</td>
                      <td><a href="{{route('job.show', $_ongoing_job->id)}}"><i class="fa fa-eye view-entry"></i></a></td>
                   </tr>
                   @endforeach
                  
                </tbody>
             </table>

             <p class="no-result">
         @php
         $text = '';
         if($ongoingJobs->total() == 0)
         $text = 'No Result Found';
         @endphp   
         {{$text}}   
         </p>   
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
                        <b> Job Status</b>
                        <a class="ms-auto" href="{{ route('job.index') }}"><button class="transparent-button">View All</button></a>
                        <!--span class="chart-total">$25,000</span-->
                     </div>
                     <div id="myChart" width="900" height="600"></div>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-12">
                  <div class="dashboard-table">
                     <div class="table-title">
                        <b> Upcoming Jobs</b>
                        <a class="ms-auto" href="{{ route('job.index',['status' =>5,'type' => 'Upcoming']) }}"><button class="transparent-button">View All</button></a>
                     </div>
                     <div class="table-responsive">
                     <table class="table table-no-wrap">
                <thead>
                   <tr>
                      <th scope="col">Job Name</th>
                      <th scope="col">Start Date</th>
                      <th scope="col">End Date</th>
                      <th scope="col">Actions</th>
                   </tr>
                </thead>
                <tbody>
                  @foreach($upcomingJobs as $_upcoming)
                  <tr>
                  <td>{{$_upcoming->title}}</td>
                      <td>{{date('d M Y',strtotime($_upcoming->start_date))}}</td>
                      <td>{{date('d M Y',strtotime($_upcoming->end_date))}}</td>
                      <td><a href="{{route('job.show', $_upcoming->id)}}"><i class="fa fa-eye view-entry"></i></a></td>
                   </tr>
                  @endforeach
                   
                </tbody>
             </table>
             @php
         $text = '';
         if($upcomingJobs->total() == 0)
         $text = 'No Result Found';
         @endphp   
         <p class="no-result">{{$text}}  </p>
         </div>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-12">
               <div class="dashboard-table">
                     <div class="table-title">
                        <b> Completed Jobs</b>
                        <a class="ms-auto" href="{{ route('job.index',['status' =>5,'type' => 'Completed']) }}"><button class="transparent-button">View All</button></a>
                     </div>
                     <div class="table-responsive">
                     <table class="table table-no-wrap">
                <thead>
                   <tr>
                      <th scope="col">Job Name</th>
                      <th scope="col">Start Date</th>
                      <th scope="col">End Date</th>
                      <th scope="col">Actions</th>
                   </tr>
                </thead>
                <tbody>
                  @foreach($completedJobs as $_completed)
                  <tr>
                  <td>{{$_completed->title}}</td>
                      <td>{{date('d M Y',strtotime($_completed->start_date))}}</td>
                      <td>{{date('d M Y',strtotime($_completed->end_date))}}</td>
                      <td><a href="{{route('job.show', $_completed->id)}}"><i class="fa fa-eye view-entry"></i></a></td>
                   </tr>
                  @endforeach
                   
                </tbody>
             </table>
            
             @php
         $text = '';
         if($completedJobs->total() == 0)
         $text = 'No Result Found';
         @endphp   
         <p class="no-result">{{$text}}  </p>
         </div>
                  </div>
               </div>
            </div>
</div>
<button type="button" id="feedback_survey_id" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Feedback Survey
</button>
@endsection
@section('script')


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title feedback-header" id="exampleModalLabel">Feedback Survey</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form id="filter_form">   
                @csrf
                <div class="row">                   
                    <div class="col-md-8 mb-3">                       
                        <div class="input-group survey">
                        <label for="rating" class="form-label">Share your experience with us !</label>
                        <input
                        class="rating rating-loading feedback_survey"
                        max="5"
                        step="0.5"
                        id="input-1"
                        required
                        > 
                        </div>                    
                    </div> 
                    <input type="hidden" name="rating"  id="rating-value" />       
                </div>
                <div class="row">
                    <div class="col-md-12 survey">
                        <label for="comment" class="form-label">Got any suggestion? We’d love to hear from you !</label>
                        <textarea class="form-control" id="comment" name="comment" rows="6\4" required>{{ old('comment') }}</textarea>
                        <div class="invalid-feedback" id="commentError"></div>
                    </div>
                </div>
      </div>
      <div class="modal-footer border-0">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
         <div class="row m-0">    
                    <div class="col-12 text-end px-0 pb-2">
                        <!-- <button type="button" class="btn bg-secondary text-white me-4" data-bs-dismiss="modal" id="filterCloseBtn">Cancel</button> -->
                        <button type="submit" class="btn bg-primary text-white">Submit</button>
                    </div> 
                </div>
         </form>
      </div>
    </div>
  </div>
</div>
<style>
   .rating-container {
  .rating-stars {
    position: relative;
    cursor: pointer;
    vertical-align: middle;
    display: inline-block;
    overflow: hidden;
    white-space: nowrap;
  }
  .rating-input {
     position: absolute;
    cursor: pointer;
    width: 100%;
    height: 1px;
    bottom: 0;
    left: 0;
    font-size: 1px;
    border: none;
    background: 0 0;
    padding: 0;
    margin: 0;
    color: #fff;
    outline: unset;
  }
}

.rating-disabled {
  .rating-input, .rating-stars {
    cursor: not-allowed;
  }
}

.rating-container {
  .star {
    display: inline-block;
    margin: 0 3px;
    text-align: center;
    font-size: 26px;
  }
  .empty-stars {
    color: #aaa;
  }
  .filled-stars {
    position: absolute;
    left: 0;
    top: 0;
    margin: auto;
    color: #fde16d;
    white-space: nowrap;
    overflow: hidden;
    -webkit-text-stroke: 1px #777;
    text-shadow: 1px 1px #999;
  }
}

.rating-rtl {
  float: right;
}

.rating-animate .filled-stars {
  transition: width .25s ease;
  -o-transition: width .25s ease;
  -moz-transition: width .25s ease;
  -webkit-transition: width .25s ease;
}

.rating-rtl {
  .filled-stars {
    left: auto;
    right: 0;
    -moz-transform: matrix(-1, 0, 0, 1, 0, 0) translate3d(0, 0, 0);
    -webkit-transform: matrix(-1, 0, 0, 1, 0, 0) translate3d(0, 0, 0);
    -o-transform: matrix(-1, 0, 0, 1, 0, 0) translate3d(0, 0, 0);
    transform: matrix(-1, 0, 0, 1, 0, 0) translate3d(0, 0, 0);
  }
  &.is-star .filled-stars {
    right: .06em;
  }
  &.is-heart .empty-stars {
    margin-right: .07em;
  }
}

.rating-lg {
  font-size: 3.91em;
}

.rating-md {
  font-size: 3.13em;
}

.rating-sm {
  font-size: 2.5em;
}

/* .rating-xs {
  font-size: 2em;
} */

.rating-xl {
  font-size: 4.89em;
}

.rating-container .clear-rating {
  color: #aaa;
  cursor: not-allowed;
  display: inline-block;
  vertical-align: middle;
  font-size: 60%;
  padding-right: 5px;
}

.clear-rating-active {
  cursor: pointer !important;
  &:hover {
    color: #843534;
  }
}

.rating-container .caption {
  color: #999;
  display: inline-block;
  vertical-align: middle;
  font-size: 60%;
  margin-top: -.6em;
  margin-left: 5px;
  margin-right: 0;
}

.rating-rtl .caption {
  margin-right: 5px;
  margin-left: 0;
}

@media print {
  .rating-container .clear-rating {
    display: none;
  }
}
.empty-star{
  color:#dee2e6;
}
.rating-container .filled-stars {
    -webkit-text-stroke: 0; 
    text-shadow: none; 
    color:#ffca00;
}
.progress{
    margin-top: 1rem;
    border-radius: 0; 
}
.progress-bar {
    background-color: #ffca00;
}
</style>
<script src="{{ asset('js/apexcharts.min.js') }}"></script> 
<script>
   var feedback_survey = <?php echo json_encode($feedback_survey_value); ?>;
   $(window).on('load',function(){
      if (feedback_survey) {
         $('#feedback_survey_id').trigger('click');
      }
        
    }); 
  // Calculate series data
  var seriesData = [{{$ongoingJobs->total()}}, {{$upcomingJobs->total()}}, {{$completedJobs->total()}}, {{$asignedJobs->total()}}];
  
  // Check if all values are zero
  var isChartEmpty = seriesData.every(value => value === 0);

  // Set data for empty chart
  if (isChartEmpty) {
    seriesData = [1]; // Placeholder value for empty chart
  }

  var options = {
    series: seriesData,
    chart: {
      type: 'donut',
    },
    labels: isChartEmpty ? ['No Data Available'] : ['Ongoing', 'Upcoming', 'Completed', 'Open'],
    dataLabels: {
      enabled: false
    },
    responsive: [{
      breakpoint: 320,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }],
    legend: {
      position: 'bottom',
      offsetY: 0,
      height: 100,
    },
    colors: isChartEmpty ? ['#e2e5ec'] : ['#034bad', '#0ab39c', '#f6b84b', '#f06548'],
    states: {
      hover: {
        filter: {
          type: isChartEmpty ? 'darken' : 'lighten',
          value: isChartEmpty ? 0.4 : 0.35, // Apply a light hover effect even for empty chart
        }
      }
    },
    tooltip: {
      enabled: true,
      y: {
        formatter: function (value, { seriesIndex, w }) {
          if (isChartEmpty) {
            return 'N/A';
          }
          return value;
        }
      }
    }
  };

  var chart = new ApexCharts(document.querySelector("#myChart"), options);
  chart.render();

  
  //submit rating
  $('#filter_form').submit(function(e){
    e.preventDefault();
    var comment = $('#comment').val();
    $('.loader').show();
    $.ajax({
        type: "POST",
        url: "user-feedback-survey",
        data:{
            "_token": "{{ csrf_token() }}",
            "rating": $('#rating-value').val(),
            "comment": comment
        }
    }).done(function( response ) {
        $('.loader').hide();
       $('#feedback_survey_id').trigger('click');
        if (response.status==true) {
            Swal.fire("Done!", "Feedback added Successfully.", "success");
           // window.reload();
        }else {
            Swal.fire("Error!", "Feedback cannot be added","error");
        }
        if(response.status === 422) {
            var errors = $.parseJSON(response.responseText).errors;
            Object.keys(errors).forEach(function (key) {                
                $("#" + key + "Input").addClass("is-invalid");
                $("#" + key + "Error").text(errors[key][0]);
            });
        }
                    
    });
});

! function(e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? module.exports = e(require("jquery")) : e(window.jQuery)
}(function(e) {
    "use strict";
    e.fn.ratingLocales = {}, e.fn.ratingThemes = {};
    var t, a;
    t = {
        NAMESPACE: ".rating",
        DEFAULT_MIN: 0,
        DEFAULT_MAX: 5,
        DEFAULT_STEP: .5,
        isEmpty: function(t, a) {
            return null === t || void 0 === t || 0 === t.length || a && "" === e.trim(t)
        },
        getCss: function(e, t) {
            return e ? " " + t : ""
        },
        addCss: function(e, t) {
            e.removeClass(t).addClass(t)
        },
        getDecimalPlaces: function(e) {
            var t = ("" + e).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            return t ? Math.max(0, (t[1] ? t[1].length : 0) - (t[2] ? +t[2] : 0)) : 0
        },
        applyPrecision: function(e, t) {
            return parseFloat(e.toFixed(t))
        },
        handler: function(e, a, n, r, i) {
            var l = i ? a : a.split(" ").join(t.NAMESPACE + " ") + t.NAMESPACE;
            r || e.off(l), e.on(l, n)
        }
    }, a = function(t, a) {
        var n = this;
        n.$element = e(t), n._init(a)
    }, a.prototype = {
        constructor: a,
        _parseAttr: function(e, a) {
            var n, r, i, l, s = this,
                o = s.$element,
                c = o.attr("type");
            if ("range" === c || "number" === c) {
                switch (r = a[e] || o.data(e) || o.attr(e), e) {
                    case "min":
                        i = t.DEFAULT_MIN;
                        break;
                    case "max":
                        i = t.DEFAULT_MAX;
                        break;
                    default:
                        i = t.DEFAULT_STEP
                }
                n = t.isEmpty(r) ? i : r, l = parseFloat(n)
            } else l = parseFloat(a[e]);
            return isNaN(l) ? i : l
        },
        _parseValue: function(e) {
            var t = this,
                a = parseFloat(e);
            return isNaN(a) && (a = t.clearValue), !t.zeroAsNull || 0 !== a && "0" !== a ? a : null
        },
        _setDefault: function(e, a) {
            var n = this;
            t.isEmpty(n[e]) && (n[e] = a)
        },
        _initSlider: function(e) {
            var a = this,
                n = a.$element.val();
            a.initialValue = t.isEmpty(n) ? 0 : n, a._setDefault("min", a._parseAttr("min", e)), a._setDefault("max", a._parseAttr("max", e)), a._setDefault("step", a._parseAttr("step", e)), (isNaN(a.min) || t.isEmpty(a.min)) && (a.min = t.DEFAULT_MIN), (isNaN(a.max) || t.isEmpty(a.max)) && (a.max = t.DEFAULT_MAX), (isNaN(a.step) || t.isEmpty(a.step) || 0 === a.step) && (a.step = t.DEFAULT_STEP), a.diff = a.max - a.min
        },
        _initHighlight: function(e) {
            var t, a = this,
                n = a._getCaption();
            e || (e = a.$element.val()), t = a.getWidthFromValue(e) + "%", a.$filledStars.width(t), a.cache = {
                caption: n,
                width: t,
                val: e
            }
        },
        _getContainerCss: function() {
            var e = this;
            return "rating-container" + t.getCss(e.theme, "theme-" + e.theme) + t.getCss(e.rtl, "rating-rtl") + t.getCss(e.size, "rating-" + e.size) + t.getCss(e.animate, "rating-animate") + t.getCss(e.disabled || e.readonly, "rating-disabled") + t.getCss(e.containerClass, e.containerClass)
        },
        _checkDisabled: function() {
            var e = this,
                t = e.$element,
                a = e.options;
            e.disabled = void 0 === a.disabled ? t.attr("disabled") || !1 : a.disabled, e.readonly = void 0 === a.readonly ? t.attr("readonly") || !1 : a.readonly, e.inactive = e.disabled || e.readonly, t.attr({
                disabled: e.disabled,
                readonly: e.readonly
            })
        },
        _addContent: function(e, t) {
            var a = this,
                n = a.$container,
                r = "clear" === e;
            return a.rtl ? r ? n.append(t) : n.prepend(t) : r ? n.prepend(t) : n.append(t)
        },
        _generateRating: function() {
            var a, n, r, i = this,
                l = i.$element;
            n = i.$container = e(document.createElement("div")).insertBefore(l), t.addCss(n, i._getContainerCss()), i.$rating = a = e(document.createElement("div")).attr("class", "rating-stars").appendTo(n).append(i._getStars("empty")).append(i._getStars("filled")), i.$emptyStars = a.find(".empty-stars"), i.$filledStars = a.find(".filled-stars"), i._renderCaption(), i._renderClear(), i._initHighlight(), n.append(l), i.rtl && (r = Math.max(i.$emptyStars.outerWidth(), i.$filledStars.outerWidth()), i.$emptyStars.width(r)), l.appendTo(a)
        },
        _getCaption: function() {
            var e = this;
            return e.$caption && e.$caption.length ? e.$caption.html() : e.defaultCaption
        },
        _setCaption: function(e) {
            var t = this;
            t.$caption && t.$caption.length && t.$caption.html(e)
        },
        _renderCaption: function() {
            var a, n = this,
                r = n.$element.val(),
                i = n.captionElement ? e(n.captionElement) : "";
            if (n.showCaption) {
                if (a = n.fetchCaption(r), i && i.length) return t.addCss(i, "caption"), i.html(a), void(n.$caption = i);
                n._addContent("caption", '<div class="caption">' + a + "</div>"), n.$caption = n.$container.find(".caption")
            }
        },
        _renderClear: function() {
            var a, n = this,
                r = n.clearElement ? e(n.clearElement) : "";
            if (n.showClear) {
                if (a = n._getClearClass(), r.length) return t.addCss(r, a), r.attr({
                    title: n.clearButtonTitle
                }).html(n.clearButton), void(n.$clear = r);
                n._addContent("clear", '<div class="' + a + '" title="' + n.clearButtonTitle + '">' + n.clearButton + "</div>"), n.$clear = n.$container.find("." + n.clearButtonBaseClass)
            }
        },
        _getClearClass: function() {
            var e = this;
            return e.clearButtonBaseClass + " " + (e.inactive ? "" : e.clearButtonActiveClass)
        },
        _toggleHover: function(e) {
            var t, a, n, r = this;
            e && (r.hoverChangeStars && (t = r.getWidthFromValue(r.clearValue), a = e.val <= r.clearValue ? t + "%" : e.width, r.$filledStars.css("width", a)), r.hoverChangeCaption && (n = e.val <= r.clearValue ? r.fetchCaption(r.clearValue) : e.caption, n && r._setCaption(n + "")))
        },
        _init: function(t) {
            var a, n = this,
                r = n.$element.addClass("rating-input");
            return n.options = t, e.each(t, function(e, t) {
                n[e] = t
            }), (n.rtl || "rtl" === r.attr("dir")) && (n.rtl = !0, r.attr("dir", "rtl")), n.starClicked = !1, n.clearClicked = !1, n._initSlider(t), n._checkDisabled(), n.displayOnly && (n.inactive = !0, n.showClear = !1, n.showCaption = !1), n._generateRating(), n._initEvents(), n._listen(), a = n._parseValue(r.val()), r.val(a), r.removeClass("rating-loading")
        },
        _initEvents: function() {
            var e = this;
            e.events = {
                _getTouchPosition: function(a) {
                    var n = t.isEmpty(a.pageX) ? a.originalEvent.touches[0].pageX : a.pageX;
                    return n - e.$rating.offset().left
                },
                _listenClick: function(e, t) {
                    return e.stopPropagation(), e.preventDefault(), e.handled === !0 ? !1 : (t(e), void(e.handled = !0))
                },
                _noMouseAction: function(t) {
                    return !e.hoverEnabled || e.inactive || t && t.isDefaultPrevented()
                },
                initTouch: function(a) {
                    var n, r, i, l, s, o, c, u, d = e.clearValue || 0,
                        p = "ontouchstart" in window || window.DocumentTouch && document instanceof window.DocumentTouch;
                    p && !e.inactive && (n = a.originalEvent, r = t.isEmpty(n.touches) ? n.changedTouches : n.touches, i = e.events._getTouchPosition(r[0]), "touchend" === a.type ? (e._setStars(i), u = [e.$element.val(), e._getCaption()], e.$element.trigger("change").trigger("rating.change", u), e.starClicked = !0) : (l = e.calculate(i), s = l.val <= d ? e.fetchCaption(d) : l.caption, o = e.getWidthFromValue(d), c = l.val <= d ? o + "%" : l.width, e._setCaption(s), e.$filledStars.css("width", c)))
                },
                starClick: function(t) {
                    var a, n;
                    e.events._listenClick(t, function(t) {
                        return e.inactive ? !1 : (a = e.events._getTouchPosition(t), e._setStars(a), n = [e.$element.val(), e._getCaption()], e.$element.trigger("change").trigger("rating.change", n), void(e.starClicked = !0))
                    })
                },
                clearClick: function(t) {
                    e.events._listenClick(t, function() {
                        e.inactive || (e.clear(), e.clearClicked = !0)
                    })
                },
                starMouseMove: function(t) {
                    var a, n;
                    e.events._noMouseAction(t) || (e.starClicked = !1, a = e.events._getTouchPosition(t), n = e.calculate(a), e._toggleHover(n), e.$element.trigger("rating.hover", [n.val, n.caption, "stars"]))
                },
                starMouseLeave: function(t) {
                    var a;
                    e.events._noMouseAction(t) || e.starClicked || (a = e.cache, e._toggleHover(a), e.$element.trigger("rating.hoverleave", ["stars"]))
                },
                clearMouseMove: function(t) {
                    var a, n, r, i;
                    !e.events._noMouseAction(t) && e.hoverOnClear && (e.clearClicked = !1, a = '<span class="' + e.clearCaptionClass + '">' + e.clearCaption + "</span>", n = e.clearValue, r = e.getWidthFromValue(n) || 0, i = {
                        caption: a,
                        width: r,
                        val: n
                    }, e._toggleHover(i), e.$element.trigger("rating.hover", [n, a, "clear"]))
                },
                clearMouseLeave: function(t) {
                    var a;
                    e.events._noMouseAction(t) || e.clearClicked || !e.hoverOnClear || (a = e.cache, e._toggleHover(a), e.$element.trigger("rating.hoverleave", ["clear"]))
                },
                resetForm: function(t) {
                    t && t.isDefaultPrevented() || e.inactive || e.reset()
                }
            }
        },
        _listen: function() {
            var a = this,
                n = a.$element,
                r = n.closest("form"),
                i = a.$rating,
                l = a.$clear,
                s = a.events;
            return t.handler(i, "touchstart touchmove touchend", e.proxy(s.initTouch, a)), t.handler(i, "click touchstart", e.proxy(s.starClick, a)), t.handler(i, "mousemove", e.proxy(s.starMouseMove, a)), t.handler(i, "mouseleave", e.proxy(s.starMouseLeave, a)), a.showClear && l.length && (t.handler(l, "click touchstart", e.proxy(s.clearClick, a)), t.handler(l, "mousemove", e.proxy(s.clearMouseMove, a)), t.handler(l, "mouseleave", e.proxy(s.clearMouseLeave, a))), r.length && t.handler(r, "reset", e.proxy(s.resetForm, a), !0), n
        },
        _getStars: function(e) {
            var t, a = this,
                n = '<span class="' + e + '-stars">';
            for (t = 1; t <= a.stars; t++) n += '<span class="star">' + a[e + "Star"] + "</span>";
            return n + "</span>"
        },
        _setStars: function(e) {
            var t = this,
                a = arguments.length ? t.calculate(e) : t.calculate(),
                n = t.$element,
                r = t._parseValue(a.val);

            return n.val(r), t.$filledStars.css("width", a.width), t._setCaption(a.caption), t.cache = a, n
        },
        showStars: function(e) {
            var t = this,
                a = t._parseValue(e);
            return t.$element.val(a), t._setStars()
        },
        calculate: function(e) {
            var a = this,
                n = t.isEmpty(a.$element.val()) ? 0 : a.$element.val(),
                r = arguments.length ? a.getValueFromPosition(e) : n,
                i = a.fetchCaption(r),
                l = a.getWidthFromValue(r);

            return l += "%", {
                caption: i,
                width: l,
                val: r
            }
        },
        getValueFromPosition: function(e) {
            var a, n, r = this,
                i = t.getDecimalPlaces(r.step),
                l = r.$rating.width();
          
            return n = r.diff * e / (l * r.step), n = r.rtl ? Math.floor(n) : Math.ceil(n), a = t.applyPrecision(parseFloat(r.min + n * r.step), i), a = Math.max(Math.min(a, r.max), r.min), r.rtl ? r.max - a : a
        },
        getWidthFromValue: function(e) {
            var t, a, n = this,
                r = n.min,
                i = n.max,
                l = n.$emptyStars;
            return !e || r >= e || r === i ? 0 : (a = l.outerWidth(), t = a ? l.width() / a : 1, e >= i ? 100 : (e - r) * t * 100 / (i - r))
        },
        fetchCaption: function(e) {
            var a, n, r, i, l, s = this,
                o = parseFloat(e) || s.clearValue,
                c = s.starCaptions,
                u = s.starCaptionClasses;
            return o && o !== s.clearValue && (o = t.applyPrecision(o, t.getDecimalPlaces(s.step))), i = "function" == typeof u ? u(o) : u[o], r = "function" == typeof c ? c(o) : c[o], n = t.isEmpty(r) ? s.defaultCaption.replace(/\{rating}/g, o) : r, a = t.isEmpty(i) ? s.clearCaptionClass : i, l = o === s.clearValue ? s.clearCaption : n, '<span class="' + a + '">' + l + "</span>"
        },
        destroy: function() {
            var a = this,
                n = a.$element;
            return t.isEmpty(a.$container) || a.$container.before(n).remove(), e.removeData(n.get(0)), n.off("rating").removeClass("rating rating-input")
        },
        create: function(e) {
            var t = this,
                a = e || t.options || {};
            return t.destroy().rating(a)
        },
        clear: function() {
            var e = this,
                t = '<span class="' + e.clearCaptionClass + '">' + e.clearCaption + "</span>";
            return e.inactive || e._setCaption(t), e.showStars(e.clearValue).trigger("change").trigger("rating.clear")
        },
        reset: function() {
            var e = this;
            return e.showStars(e.initialValue).trigger("rating.reset")
        },
        update: function(e) {
            var t = this;
            return arguments.length ? t.showStars(e) : t.$element
        },
        refresh: function(t) {
            var a = this,
                n = a.$element;
            return t ? a.destroy().rating(e.extend(!0, a.options, t)).trigger("rating.refresh") : n
        }
    }, e.fn.rating = function(n) {
        var r = Array.apply(null, arguments),
            i = [];
        switch (r.shift(), this.each(function() {
            var l, s = e(this),
                o = s.data("rating"),
                c = "object" == typeof n && n,
                u = c.theme || s.data("theme"),
                d = c.language || s.data("language") || "en",
                p = {},
                h = {};
            o || (u && (p = e.fn.ratingThemes[u] || {}), "en" === d || t.isEmpty(e.fn.ratingLocales[d]) || (h = e.fn.ratingLocales[d]), l = e.extend(!0, {}, e.fn.rating.defaults, p, e.fn.ratingLocales.en, h, c, s.data()), o = new a(this, l), s.data("rating", o)), "string" == typeof n && i.push(o[n].apply(o, r))
        }), i.length) {
            case 0:
                return this;
            case 1:
                return void 0 === i[0] ? this : i[0];
            default:
                return i
        }
    }, e.fn.rating.defaults = {
        theme: "",
        language: "en",
        stars: 5,
        filledStar: '<i class="fas fa-star"></i>',
        emptyStar: '<i class="fas fa-star empty-star"></i>',
        //emptyStar: '<i class="far fa-star"></i>',
        containerClass: "",
        size: "xs",
        animate: !0,
        displayOnly: !1,
        rtl: !1,
        showClear: !1,
        showCaption: !1,
        starCaptionClasses: {
            .5: "label label-danger",
            1: "label label-danger",
            1.5: "label label-warning",
            2: "label label-warning",
            2.5: "label label-info",
            3: "label label-info",
            3.5: "label label-primary",
            4: "label label-primary",
            4.5: "label label-success",
            5: "label label-success"
        },
        clearButton: '<i class="fas fa-minus"></i>',
        clearButtonBaseClass: "clear-rating",
        clearButtonActiveClass: "clear-rating-active",
        clearCaptionClass: "label label-default",
        clearValue: null,
        captionElement: null,
        clearElement: null,
        hoverEnabled: !0,
        hoverChangeCaption: !0,
        hoverChangeStars: !0,
        hoverOnClear: !0,
        zeroAsNull: !0
    }, e.fn.ratingLocales.en = {
        defaultCaption: "{rating} Stars",
        starCaptions: {
            .5: "0.5",
            1: "1",
            1.5: "1.5",
            2: "2",
            2.5: "2.5",
            3: "3",
            3.5: "3.5",
            4: "4",
            4.5: "4.5",
            5: "5"
        },
        clearButtonTitle: "Clear",
        clearCaption: "Not Rated"
    }, e.fn.rating.Constructor = a, e(document).ready(function() {
        var t = e("input.rating");
        t.length && t.removeClass("rating-loading").addClass("rating-loading").rating()
    })
});

$(document).ready(function() {
    $('input.rating').on('rating.change', function(event, value, caption) {
        console.log('User selected rating:', value);
        $('#rating-value').val(value);
    });
});
</script>
@endsection
