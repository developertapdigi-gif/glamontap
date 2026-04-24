@extends('admin.layouts.master')
@section('title','Feedback Survey')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2 class="desktop-content"><img src="{{ asset('images/icons/feedback.svg')}}" alt=""> Feedback</h2>
        <div class="middle-title job-middle-title">
            <a href="#" class="jobtab primary-btn blue-button {{$text[1]}}" data-status="{{$text[1]}}">{{$text[1]}}</a>
            <a href="#" class="jobtab primary-btn white-button {{$text[2]}}" data-status="{{$text[2]}}">{{$text[2]}}</a>
            <a href="#" class="jobtab primary-btn white-button {{$text[3]}}" data-status="{{$text[3]}}">{{$text[3]}}</a>
             <input type="hidden" name="job_status" id="job_status" value="{{$text[1]}}">
        </div>
        <h2 class="mobile-content"><img src="{{ asset('images/icons/feedback.svg')}}" alt="">Feedback</h2>
        
     <div class="right-filter job-right-filter">
    <div class="page-view">
          
       
      </div> <span id="job_count">Showing <span id="skill_count_value">{{$skill_categories->total()}}</span> Feedback Results</span>
      
    </div>
          
    </div>        
    @if(!request()->mode || request()->mode=='list')
    <div class="skill-table-heading">
    <div class="d-flex">
        
        
    </div>

    <div class="table-responsive-lg">
            <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list" id="ajax_table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    <!--div class="skill-table-pagintion d-flex">       
        {{ $skill_categories->links() }}        
    </div-->   

@endif     
</div>
@endsection
@section('script')
<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true" data-easein="slideDownBigIn">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="client_popupLabel">Feedback</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <!-- <span aria-hidden="true">&times;</span> -->
            </button>
        </div>
        <div class="modal-body">
            
                <div class="row">                   
                    <div class="col-md-8 mb-3">                       
                        <div class="input-group">
                        <label for="rating" class="form-label"><b>Rating :</b>  &nbsp</label>
                        <input
                        class="rating"
                        max="5"
                        step="0.5"
                        style="--value:0"
                        type="range"
                        name="rating"
                        id="rating"
                        required
                        > 
                        </div>                    
                    </div>     
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="comment" class="form-label m-0"><b>Comment :</b> </label>
                        <span id="comment"></span>
                        <div class="invalid-feedback" id="commentError"></div>
                    </div>
                </div>
                <div class="row mt-4">    
                    <div class="col-12 text-end">
                        <button type="button" class="btn bg-primary text-white" data-bs-dismiss="modal" id="filterCloseBtn"> &nbsp OK &nbsp</button>
                    </div> 
                </div>
            
        </div>   
        </div>
    </div>
</div>
<script type="text/javascript">
        var ajax_table;
$(document).ready(function() {
    ajax_table = $('#ajax_table').on('xhr.dt', function (e, settings, json, xhr) {
         $('#skill_count_value').html('');
        $('#skill_count_value').append(JSON.parse(xhr.responseText).iTotalDisplayRecords); 
    }).DataTable({
        "columnDefs": [
                {"className": "text-center", "targets": [4]},
                {"targets": [1,3,4],"orderable": false},
                {"className":"d-none", "targets": [0]},
            ],
         language: {
                'paginate': {
                    'previous': '<i class="bi bi-arrow-left"></i>',
                    'next': '<i class="bi bi-arrow-right"></i>'
                }
            },
          processing: true,
          serverSide: true,
          order: [[0, 'desc']],
          ajax: {
            url:"{{route('fetch.feedback-surveys')}}",
            data: function(data){                
                data.job_status  = $('#job_status').val();                  
            }
          },
          columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'rating' },
            { data: 'message' },
            { data: 'buttons' }
        ]
    });
   // ajax_table.column( 0 ).visible( false );
   $('.jobtab').click(function(){ 
    //alert($(this).attr('data-status'));      
        $('#job_status').val($(this).attr('data-status'));
        $('#acc_button span').empty();
        $('#acc_button span').append($('#job_status').val());
        $('.jobtab').addClass('white-button');
        $(this).removeClass('white-button').addClass('blue-button');
        ajax_table.draw(); 
    });
});

$(document).on('click', '#for_feedback', function () {
    var id = $(this).data('modelid');
    $.ajax({
        method:'GET',
        url: 'feedback-survey/get-feedback/'+id,
        data: id,
        success: function(response){
            if(response.status === 'empty' || !response.data){
                $('#comment').html('<em class="text-muted">No feedback submitted yet.</em>');
                $('#rating').val(0).attr('style','--value:0');
            } else {
                $('#comment').html(response.data.comment);
                $('#rating').val(response.data.rating).attr('style','--value:'+response.data.rating);
            }
        },
        error: function(xhr, status, error) {
            console.log('Error fetching rating:', error);
        }
    });
});


</script>
@endsection