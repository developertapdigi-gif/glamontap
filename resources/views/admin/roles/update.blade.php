@extends('admin.layouts.master')
@section('title')
    {{$page_heading}}
@endsection
@section('content')
@php
$hidecheck_arr = [];
$assignedPermissions = [];
$role_has_permissions = DB::table('role_has_permissions')->where('role_id',$model->id)->get();
foreach($role_has_permissions as $rp){
    $assignedPermissions[] = $rp->permission_id;
}
@endphp
<div class="page_content container-fluid middle-content">
   <form action="{{ route('role.update',$model->id) }}" method="POST" enctype="multipart/form-data">
       @csrf
        @method('PUT')
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body text-list">
                  <div class="form-group col-md-12 search-bar">
                     <label for="name">Name<span class="text-red">*</span></label>
                     <input name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" type="text" value="{{ old('name') ?? $model->name }}" >
                     @error('name')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>  
                   <div class="row mt-4">
                            <?php
                            foreach($permissionLists as $key=>$val){
                                $group_name = $key;
                                $group_heading = ucwords(str_replace('_', ' ', $key));                                
                                $hide_maincheck = false;
                                if(in_array($group_name, $hidecheck_arr)) $hide_maincheck = true;

                                $group_id = (!$hide_maincheck) ? $val['manage'] : '';                               
                                $this_str = '<div class="col-md-6 job-list">
                                    <div class="card card-closest elevation-5 border box-outer">
                                    <div class="card-header bg-default job-header">
                                        <div class="custom-control custom-control-alternative custom-checkbox job-text">';
                                            if(!$hide_maincheck) $this_str .= '<input type="checkbox" class="custom-control-input" name="prev['.$group_name.'.manage]" id="prev_'.$group_name.'_manage" value="'.$group_id.'"'.( in_array($group_id, $assignedPermissions) ? ' checked' : '' ).' />';
                                            $this_str .= '<label class="'.( !$hide_maincheck ? 'custom-control-label ' : '' ).'text-white" for="prev_'.$group_name.'_manage">'.$group_heading.'</label>
                                        </div>
                                    </div>
                                    <div class="card-body text-list">
                                        <div class="row">';
                                            foreach($val as $tpk=>$tpr){
                                                $permission_name = $tpk;
                                                $permission_heading = ucwords(str_replace('_', ' ', $tpk));
                                                $permission_id = $tpr;
                                                if($permission_name!='manage'){
                                                    $this_str .= '<div class="col-lg-3 col-sm-6 my-2">
                                                        <div class="custom-control custom-control-alternative custom-checkbox job-text">
                                                            <input type="checkbox" class="custom-control-input" id="prev_'.$group_name.'_'.$permission_name.'" name="prev['.$group_name.'.'.$permission_name.']" value="'.$permission_id.'"'.( in_array($permission_id, $assignedPermissions) ? ' checked' : '' ).' />
                            
                                                            <label class="custom-control-label" for="prev_'.$group_name.'_'.$permission_name.'">'.$permission_heading.'</label>
                                                        </div>
                                                    </div>';
                                                }
                                            }
                                        $this_str .= '</div>
                                    </div>
                                </div>
                                </div>';

                                echo $this_str;
                            }
                            ?>

                        
                    </div>          
                  <div class="button-bottom float-right mt-3">
                     <a href="{{route('role.index')}}" class="btn btn-secondary btn-primary">Cancel</a>
                     <button type="submit" class="btn btn-primary">save</button>
                  </div>
               </div>
            </div>
         </div>
      </div>     
   </form>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(function(){
    $('.card-closest .card-body input[type="checkbox"]').click(function(e){
        $(this).closest('.card-closest').find('.card-header input[type="checkbox"]').prop('checked', true);
    });

    $('.card-closest .card-header input[type="checkbox"]').click(function(e){
        var is_checked = $(this).prop('checked');
        $(this).closest('.card-closest').find('.card-body input[type="checkbox"]').prop('checked', is_checked);
    });
});
</script>
<style>
    .job-header {
        background-color: #e2f0ff;
        padding: 20px 16px;
    }
    .job-text {
        position: relative;
        padding-left: 28px;
    }
    .job-text input {
        position: absolute;
        left: 0px;
        width: 16px;
        height: 16px;
        top: 4px;
        z-index: -1;
    }
    .job-text input:checked~label:before {
        content: "";
        position: absolute;
        background-color: #034bad;
        width: 16px;
        height: 16px;
        left: 0px;
        top: 4px;
        box-shadow: 0 4px 6px #32325d1c;
        border-radius: .25rem;
    }
    .search-bar {
        margin-bottom: 24px;
    }
    .job-list {
        margin-bottom: 30px;
    }
    .box-outer {
        box-shadow: 0px 0px 2rem #8898aa30;
        border-radius: 0.375rem;
    }
    .box-outer .text-list {
    padding: 24px 16px;
    }
    .save-btn .btn-secondary, .btn-primary {
        padding: 8px 30px;
        margin-right: 15px;
    }
    .job-text label:before {
    content: "";
    position: absolute;
    background-color: #ffffff;
    width: 16px;
    height: 16px;
    left: 0px;
    top: 4px;
    box-shadow: 0 1px 3px rgba(50, 50, 93, .15);
    border-radius: .25rem;
    border: 0px;
    transition: all .15s cubic-bezier(.68,-.55,.265,1.55);
}
</style>
@endsection