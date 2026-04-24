@extends('admin.layouts.master')
@section('title','Subscribers')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title mobile-page-title">
                <h2 class="desktop-content"><i class="subscription-black"></i>Subscribers</h2>
                <h2 class="mobile-content"><i class="subscription-black"></i>Subscribers</h2>
                <div class="middle-title job-middle-title">
                    <button class="subtab primary-btn blue-button 1" data-status="1">All</button>                    
                    <button class="subtab primary-btn white-button 2" data-status="2">Expiring this week</button>
                    <button class="subtab primary-btn white-button 3" data-status="3">Expiring this Month</button>
                    <button class="subtab primary-btn white-button 4" data-status="4">Expired Subscription</button> 
                    <button class="subtab primary-btn white-button 5" data-status="5">Subscribers this month</button> 
                    <input type="hidden" name="expiring" id="expiring" value="1">                     
                    <button class="primary-btn blue-button bg-warning" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-sliders-h"></i>
                    </button>
                </div>            
            </div>
            <div class="table-responsive-lg">
                <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list" id="ajax_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Plan</th>
                            <th>Frequency</th>
                            <th>Organisation</th>
                            <th>Job Posting</th>
                            <th>Talent Match</th>
                            <th>Start Date</th>
                            <th>End Date</th>                           
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<link href="{{ asset('css/flatpickr.min.css') }}" rel="stylesheet">
<script src="{{asset('js/flatpickr.js')}}"></script>
<!-- Modals -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="client_popupLabel">Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="GET" action="" id="filter_form">          
            <div class="row">                   
                <div class="col-md-6 mb-3">                       
                    <div class="input-group">
                        <select class="form-select" name="agency_id" id="agency_id">
                            <option value="-1" selected>--Select Agency--</option> 
                            @foreach ($agencies as $_agency)
                                <option value="{{ $_agency->id}}">{{ ucfirst($_agency->agency_name) }}</option>
                            @endforeach                   
                        </select>
                    </div>                    
                </div> 
                 <div class="col-md-6 mb-3">                       
                    <div class="input-group">
                        <select class="form-select" name="plan_id" id="plan_id">
                            <option value="-1" selected>--Select Plan--</option> 
                            @foreach ($plans as $_plans)
                                <option value="{{ $_plans->id}}">{{ ucfirst($_plans->name) }}</option>
                            @endforeach                   
                        </select>
                    </div>                    
                </div>        
                <div class="col-md-12 mb-3">
                    <label for="payment" class="form-label">Date Range</label>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" placeholder="dd-mm-YYYY" name="from" id="from"  onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                        <div class="col-md-1">To</div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" placeholder="dd-mm-YYYY" name="to" id="to"  onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                    </div>
                </div>          
            </div>
            <div class="row mt-4">    
                <div class="col-12 text-center">
                    <button type="button" class="btn bg-secondary text-white me-4" data-bs-dismiss="modal" id="filterCloseBtn">Cancel</button>
                    <button type="submit" class="btn bg-primary text-white">Submit</button>
                </div> 
            </div>
        </form>
      </div>   
    </div>
  </div>
</div>
<script type="text/javascript">
var ajax_table;
$(document).ready(function() {
    ajax_table = $('#ajax_table').DataTable({
            language: {
                'paginate': {
                    'previous': '<i class="bi bi-arrow-left"></i>',
                    'next': '<i class="bi bi-arrow-right"></i>'
                }
            },
          searching: false,
          processing: true,
          serverSide: true,
          order: [[0, 'desc']],
          ajax: {
            url:"{{route('subscriber.list')}}",
            data: function(data){                
                data.expiring   = $('#expiring').val();    
                data.agency_id  = $('#agency_id').val();   
                data.plan_id    = $('#plan_id').val();     
                data.from           = $('#from').val();               
                data.to             = $('#to').val();          
            }
          },
          columns: [
            { data: 'id' },
            { data: 'plan_id' },
            { data: 'subscription_type' },
            { data: 'agency_id' },
            { data: 'job_limit' },
            { data: 'tradesman_limit' },
            { data: 'start_date' },
            { data: 'end_date' }
        ]
    });  
    $('#filter_form').submit(function(e){
        e.preventDefault();
        ajax_table.draw(); 
        $('#filterCloseBtn').click();
    }); 
    const parsedUrl = new URLSearchParams(window.location.search);
if(parsedUrl.has('status')){
    let jobClass = parsedUrl.get('status');
    $(".subtab."+jobClass).trigger("click");
    $('#expiring').val(parsedUrl.get('status'));
}
});
$('#from').flatpickr({
    maxDate: "today",
    enableTime: false,
    dateFormat: "Y-m-d",
});
$('#to').flatpickr({
    maxDate: "today",
    enableTime: false,
    dateFormat: "Y-m-d",
});
$('.subtab').click(function(){    
    var status = $(this).attr('data-status');    
    $('#expiring').val(status);
    $('.subtab').addClass('white-button');
    $(this).removeClass('white-button').addClass('blue-button');
    if(status==1){
        $('#agency_id,#plan_id,#to,#from').val('');
    }
    ajax_table.draw(); 
});
$('#agency_id,#plan_id').change(function(){
   ajax_table.draw();     
});
</script>
@endsection
