<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ApproveJobPost;
use App\Mail\CompleteJob;
use App\Mail\CancelJob;
use App\Mail\RejectJobPost;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\{SkillCategory, Notification};
use App\Models\User;
use App\Models\Badge;
use Carbon\Carbon;

class CustomerJobController extends Controller
{
    /**
     * Display a listing of the jobs for customer.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $currentDate = date('Y-m-d');
        
        // Build query using Eloquent
        $query = Job::where('customer_id', $user->id);
        
        // Search filter
        if($request->has('title') && !empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        
        $text = Job::JOBLABEL;
        $today = date('Y-m-d 00:00:00');
        
        // Tab filtering
        if($request->type == ($text[3] ?? 'Ongoing')) {
            $query->where('is_hired', 1)->where('status', 4);
        } else if($request->type == ($text[2] ?? 'Upcoming')) {
            $query->whereDate('start_date', '>=', $today)
                  ->where('is_hired', 1)
                  ->where('status', '!=', 4)
                  ->where('status', '!=', 3);
        } else if($request->type == ($text[4] ?? 'Completed')) {
            $query->where('status', 6);
        } else if($request->type == ($text[1] ?? 'Open')) {
            $query->whereDate('end_date', '>=', $today)
                  ->whereIn('status', [1, 2])
                  ->where('is_hired', '!=', 1);
        } else if($request->type == ($text[6] ?? 'Featured')) {
            $query->where('status', 7)
                  ->whereDate('start_date', '>=', $today)
                  ->where('status', '!=', 4)
                  ->where('status', '!=', 3);
        } else { // draft
            $query->whereDate('end_date', '>', $today)
                  ->where('is_hired', '!=', 1)
                  ->where('status', 0);
        }
        
        // Skill filter
        if($request->skill_id && $request->skill_id != '-1') {
            $query->where('skill_category', $request->skill_id);
        }
        
        $jobs = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
            
        $skill_categories = SkillCategory::getAllSkillCategory();
        $notfound = "No Result found";
        
        // Debug - log the count
        \Log::info('Customer Jobs Index: Found ' . $jobs->count() . ' jobs for user ' . $user->id);
        
        return view('admin.customer.job.list_n_grid', compact('jobs', 'skill_categories', 'text', 'notfound'));
    }
    
    /**
     * Show the form for creating a new job.
     */
    public function create()
    {
        $user = Auth::user();
        $status = Job::STATUS;
        $categories = SkillCategory::getAllSkillCategoryCreate();
        $experience_range = Badge::getAllBadges();
        
        $company_address = Auth::user()->address ?? '';
        $company_latitude = Auth::user()->latitude ?? '';
        $company_longitude = Auth::user()->longitude ?? '';

        return view('admin.customer.job.create', [
            'experience_range' => $experience_range,
            'status' => $status,
            'categories' => $categories,
            'company_address' => $company_address,
            'company_latitude' => $company_latitude,
            'company_longitude' => $company_longitude
        ]);
    }

    /**
     * Store media for job
     */
    public function storeMedia(Request $request)
    {
        $path = public_path('uploads/jobs');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);

        return response()->json([
            'name' => 'uploads/jobs/' . $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Store a newly created job.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'skill_category' => 'required',
            'experiance_range' => 'required',
            'number_of_employees' => 'required|integer|min:1',
            'location' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'minimum_price' => 'required|numeric|min:0',
            'maximum_price' => 'required|numeric|gt:minimum_price',
            'other_skill' => 'nullable'
        ], [
            'start_date.after_or_equal' => 'Start date must be today or a future date',
            'end_date.after' => 'End date must be after Start Date',
            'maximum_price.gt' => 'Maximum price must be greater than Minimum price'
        ]);

        $input = $request->all();
        $input['start_date'] = date("Y-m-d H:i:s", strtotime($request->start_date));
        $input['end_date'] = date("Y-m-d H:i:s", strtotime($request->end_date));
        $input['customer_id'] = Auth::user()->id;
        $input['agency_id'] = null;
        $input['created_by'] = Auth::user()->id;
        $input['updated_by'] = Auth::user()->id;
        $input['is_hired'] = 0;
        $input['status'] = 0;

        // Handle other skill
        $other_skill = $request->other_skill;
        if ($other_skill) {
            $skillcategoryfind = SkillCategory::where('name', $other_skill)->first();
            if ($skillcategoryfind) {
                $input['skill_category'] = $skillcategoryfind->id;
            } else {
                $other_id = SkillCategory::create([
                    'name' => $other_skill,
                    'status' => 1
                ]);
                $input['skill_category'] = $other_id->id;
            }
        }
        unset($input['other_skill']);

        $model = Job::create($input);

        return redirect()->route('customer.jobs.index')->with('success', 'Job has been created successfully!');
    }

    /**
     * Preview job before publishing
     */
    public function preview(Request $request)
    {
        $user = Auth::user();

        $data = [
            'image' => $request->image,
            'title' => $request->title,
            'skill_category' => $request->skill_category,
            'experiance_range' => $request->experiance_range,
            'number_of_employees' => $request->number_of_employees,
            'status' => 'Draft',
            'company_address' => $request->company_address,
            'company_latitude' => $request->company_latitude,
            'company_longitude' => $request->company_longitude,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'minimum_price' => $request->minimum_price,
            'maximum_price' => $request->maximum_price,
            'note' => $request->note,
            'customer_name' => $user->first_name . ' ' . $user->last_name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone ?? '',
            'customer_address' => $user->address ?? '',
            'customer_rating' => $user->over_all_rating ?? 0,
            'profile_image' => $user->profile_image ?? ''
        ];

        $request->session()->put($data);
        return response()->json(['status' => 200, 'message' => '']);
    }

    /**
     * Show preview data
     */
    public function previewdata(Request $request)
    {
        $data = $request->session()->all();
        return view('admin.customer.job.preview')->with('data', $data);
    }

    /**
     * Display the specified job.
     */
    public function show(string $id)
    {
        $model = Job::with(['agency', 'skillCategory', 'applications', 'notificationAgency'])
            ->where('customer_id', Auth::user()->id)
            ->find($id);

        if (!$model) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Job not found'], 404);
            }
            abort(404, 'Job not found or you do not have permission to view it.');
        }

        $today = date('Y-m-d 00:00:00');
        return view('admin.customer.job.show')->with(['model' => $model, 'today' => $today]);
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(string $id)
    {
        $model = Job::where('customer_id', Auth::user()->id)->find($id);

        if (!$model) {
            abort(404, 'Job not found or you do not have permission to edit it.');
        }

        if (count($model->applications) > 0) {
            return redirect()->back()->with('error', 'You are not allowed to edit this job because it has applications!');
        }

        $status = Job::STATUS;
        $experience_range = Badge::getAllBadges();
        $categories = SkillCategory::getAllSkillCategoryCreate();

        return view('admin.customer.job.update', [
            'model' => $model,
            'experience_range' => $experience_range,
            'status' => $status,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified job.
     */
    public function update(Request $request, string $id)
    {
        $model = Job::where('customer_id', Auth::user()->id)->find($id);

        if (!$model) {
            abort(404, 'Job not found or you do not have permission to update it.');
        }

        $request->validate([
            'title' => 'required',
            'skill_category' => 'required',
            'experiance_range' => 'required',
            'number_of_employees' => 'required|integer|min:1',
            'location' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'minimum_price' => 'required|numeric|min:0',
            'maximum_price' => 'required|numeric|gt:minimum_price',
            'other_skill' => 'nullable'
        ], [
            'end_date.after' => 'End date must be after Start Date',
            'maximum_price.gt' => 'Maximum price must be greater than Minimum price'
        ]);

        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        // Handle other skill
        $other_skill = $request->other_skill;
        if ($other_skill) {
            $skillcategoryfind = SkillCategory::where('name', $other_skill)->first();
            if ($skillcategoryfind) {
                $input['skill_category'] = $skillcategoryfind->id;
            } else {
                $other_id = SkillCategory::create([
                    'name' => $other_skill,
                    'status' => 1
                ]);
                $input['skill_category'] = $other_id->id;
            }
        }
        unset($input['other_skill']);

        $model->update($input);

        if ($request->ajax()) {
            return response()->json(['status' => 200, 'message' => '', 'url' => route("customer.jobs.show", $model->id)]);
        }

        return redirect()->route('customer.jobs.index')->with('success', 'Job has been updated successfully!');
    }

    /**
     * Remove the specified job.
     */
    public function destroy(string $id)
    {
        $model = Job::where('customer_id', Auth::user()->id)->find($id);

        if (!$model) {
            return response()->json(['data' => false, 'message' => 'Job not found'], 404);
        }

        DB::table('task_applications')->where('task_id', $model->id)->delete();
        $model->delete();

        return response()->json(['data' => true]);
    }

    /**
     * Approve job (submit for approval)
     */
    public function approveJob(Request $request)
    {
        $model = Job::where('customer_id', Auth::user()->id)->find($request->id);

        if (!$model) {
            return response()->json(['status' => 404, 'message' => 'Job not found'], 404);
        }

        $model->update(['status' => 1]);

        return response()->json(['status' => 200, 'message' => 'Job submitted for approval']);
    }

    /**
     * Approve hired employee
     */
    public function approveEmployee(Request $request)
    {
        $model = JobApplication::find($request->id);
        
        if (!$model) {
            return response()->json(['status' => false, 'message' => 'Application not found'], 404);
        }
        
        $job = Job::where('customer_id', Auth::user()->id)->find($model->task_id);

        if (!$job) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $model->status = 1;
        $model->customer_id = Auth::user()->id;
        $model->save();

        $job->update(['is_hired' => 1]);
        $today = date('Y-m-d 00:00:00');

        $count = JobApplication::where('task_id', $model->task_id)->where('status', 1)->count();
        if ($job->status != 4 && $job->start_date == $today && $count == $job->number_of_employees) {
            $job->update(['status' => 4]);
        }

        $this->sendEmployeeNotification($model, $job, 'accepted');

        return response()->json(['status' => true]);
    }

    /**
     * Reject hired employee
     */
    public function rejectEmployee(Request $request)
    {
        $model = JobApplication::find($request->id);
        
        if (!$model) {
            return response()->json(['status' => false, 'message' => 'Application not found'], 404);
        }
        
        $job = Job::where('customer_id', Auth::user()->id)->find($model->task_id);

        if (!$job) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $model->status = 2;
        $model->customer_id = Auth::user()->id;
        $model->save();

        $jobapp = JobApplication::where('task_id', $model->task_id)->get();
        if (count($jobapp) <= 1) {
            $job->update(['is_hired' => 0]);
        }

        $this->sendEmployeeNotification($model, $job, 'rejected');

        return response()->json(['status' => true]);
    }

    /**
     * Send employee notification
     */
    private function sendEmployeeNotification($model, $job, $type)
    {
        $user = Auth::user();
        $customer_name = $user->first_name . ' ' . $user->last_name;

        $notification = new \App\Models\Notification();

        if ($type == 'accepted') {
            $message = ucfirst($customer_name) . ' has accepted your request for work at ' . $job->location . '.';
            $title = 'Application Accepted';
            $type_text = 'customer_job_accept';
            $notification_type = 3;
        } else {
            $message = ucfirst($customer_name) . ' has rejected your request for work at ' . $job->location . '.';
            $title = 'Application Rejected';
            $type_text = 'customer_job_cancel';
            $notification_type = 4;
        }

        $savedNotification = $notification->saveNotification([
            'type' => $notification_type,
            'type_text' => $type_text,
            'sender_id' => Auth::user()->id,
            'receiver_id' => $model->bidder_id,
            'reference_id' => $job->id,
            'message' => $message
        ]);

        if ($model->trader && $model->trader->device_token && $model->trader->notification == 1) {
            $notification->sendNotification([
                'message' => [
                    'token' => $model->trader->device_token,
                    'notification' => [
                        'title' => $title,
                        'body' => $message
                    ],
                    'data' => [
                        'notification_id' => (string)$savedNotification->id,
                        'type' => $type_text,
                        'id' => (string)$job->id
                    ]
                ]
            ]);
        }
    }

    /**
     * Complete job
     */
    public function completeJob(Request $request)
    {
        $job = Job::where('customer_id', Auth::user()->id)->find($request->id);

        if (!$job) {
            return response()->json(['status' => 404, 'message' => 'Job not found'], 404);
        }

        $job->status = 6;
        $job->update();

        $traders = JobApplication::where('task_id', $request->id)->get();
        $user = Auth::user();
        $customer_name = $user->first_name . ' ' . $user->last_name;

        if (count($traders)) {
            foreach ($traders as $_trader) {
                $notification = new \App\Models\Notification();
                $savedNotification = $notification->saveNotification([
                    'type' => 8,
                    'type_text' => 'customer_job_complete',
                    'sender_id' => Auth::user()->id,
                    'receiver_id' => $_trader->bidder_id,
                    'reference_id' => $request->id,
                    'message' => ucfirst($customer_name) . ' has marked the job as completed.'
                ]);

                $trader_user = User::find($_trader->bidder_id);
                if ($trader_user && $trader_user->device_token && $trader_user->notification == 1) {
                    $notification->sendNotification([
                        'message' => [
                            'token' => $trader_user->device_token,
                            'notification' => [
                                'title' => 'Completed Job',
                                'body' => ucfirst($customer_name) . ' has marked the job as completed.'
                            ],
                            'data' => [
                                'notification_id' => (string)$savedNotification->id,
                                'type' => 'customer_job_complete',
                                'id' => (string)$job->id
                            ]
                        ]
                    ]);
                }

                if ($_trader->trader) {
                    $name = $_trader->trader->first_name;
                    $trader_email = $_trader->trader->email;
                    $data = [
                        'customer' => $customer_name,
                        'name' => $name,
                        'job_name' => $job->title,
                        'start_date' => date('d-m-Y', strtotime($job->start_date))
                    ];

                    try {
                        Mail::to($trader_email)->send(new CompleteJob($data));
                    } catch (\Exception $e) {
                        // Log email error
                    }
                }
            }
            return response()->json(['status' => 200, 'message' => 'Job Completed Successfully.']);
        }

        return response()->json(['status' => 200, 'message' => 'Job Completed Successfully.']);
    }

    /**
     * Cancel job
     */
    public function cancelJob(Request $request)
    {
        $job = Job::where('customer_id', Auth::user()->id)->find($request->id);

        if (!$job) {
            return response()->json(['status' => 404, 'message' => 'Job not found'], 404);
        }

        $today = date('Y-m-d 00:00:00');
        $added_hours = date('Y-m-d H:i:s', strtotime($today . ' +48 hours'));

        $job->status = 3;
        $job->update();

        $traders = JobApplication::where('task_id', $request->id)->get();
        $user = Auth::user();
        $customer_name = $user->first_name . ' ' . $user->last_name;

        if (count($traders)) {
            if ($job->start_date < $added_hours) {
                $customer = User::find(Auth::user()->id);
                if ($customer && $customer->over_all_rating) {
                    $customer->over_all_rating = max(0, $customer->over_all_rating - 0.5);
                    $customer->update();
                }
            }

            foreach ($traders as $_trader) {
                $notification = new \App\Models\Notification();
                $savedNotification = $notification->saveNotification([
                    'type' => 9,
                    'type_text' => 'customer_job_cancel',
                    'sender_id' => Auth::user()->id,
                    'receiver_id' => $_trader->bidder_id,
                    'reference_id' => $request->id,
                    'message' => 'The job ' . $job->title . ' is cancelled by ' . $customer_name . '.'
                ]);

                $trader_user = User::find($_trader->bidder_id);
                if ($trader_user && $trader_user->device_token && $trader_user->notification == 1) {
                    $notification->sendNotification([
                        'message' => [
                            'token' => $trader_user->device_token,
                            'notification' => [
                                'title' => 'Cancel Job',
                                'body' => 'The job ' . $job->title . ' is cancelled by ' . $customer_name . '.'
                            ],
                            'data' => [
                                'notification_id' => (string)$savedNotification->id,
                                'type' => 'customer_job_cancel',
                                'id' => (string)$job->id
                            ]
                        ]
                    ]);
                }

                if ($_trader->trader) {
                    $name = $_trader->trader->first_name;
                    $trader_email = $_trader->trader->email;
                    $data = [
                        'customer' => $customer_name,
                        'name' => $name,
                        'job_name' => $job->title,
                        'start_date' => date('d-m-Y', strtotime($job->start_date))
                    ];

                    try {
                        Mail::to($trader_email)->send(new CancelJob($data));
                    } catch (\Exception $e) {
                        // Log email error
                    }
                }
            }
        }

        return response()->json(['status' => 200, 'message' => 'Job cancelled successfully.']);
    }

    /**
     * Fetch data for datatable - FIXED VERSION
     */
    public function fetchData(Request $request)
    {
            try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'draw' => intval($request->get('draw', 1)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => []
                ]);
            }

            $draw = intval($request->get('draw', 1));
            $start = intval($request->get("start", 0));
            $rowperpage = intval($request->get("length", 10));
            
            $columnIndex_arr = $request->get('order', []);
            $columnName_arr = $request->get('columns', []);
            $order_arr = $request->get('order', []);
            $search_arr = $request->get('search', []);
            
            $columnIndex = isset($columnIndex_arr[0]['column']) ? intval($columnIndex_arr[0]['column']) : 0;
            $columnName = isset($columnName_arr[$columnIndex]['data']) ? $columnName_arr[$columnIndex]['data'] : 'id';
            $columnSortOrder = isset($order_arr[0]['dir']) ? $order_arr[0]['dir'] : 'desc';
            $searchValue = isset($search_arr['value']) ? $search_arr['value'] : '';
            
            $today = date('Y-m-d 00:00:00');
            $text = Job::JOBLABEL;

            // Start query builder - ONLY GET JOBS FOR THIS CUSTOMER
            $query = Job::with('skillCategory')
                ->where('customer_id', $user->id);

            // Search filter
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('title', 'like', '%' . $searchValue . '%')
                    ->orWhere('location', 'like', '%' . $searchValue . '%');
                });
            }

            // Job Tab filter
            $jobStatus = $request->job_status ?? ($text[5] ?? 'Draft');
            
            if ($jobStatus == ($text[3] ?? 'Ongoing')) {
                $query->where('is_hired', 1)->where('status', 4);
            } else if ($jobStatus == ($text[2] ?? 'Upcoming')) {
                $query->whereDate('start_date', '>=', $today)
                    ->where('is_hired', 1)
                    ->where('status', '!=', 4)
                    ->where('status', '!=', 3);
            } else if ($jobStatus == ($text[4] ?? 'Completed')) {
                $query->where('status', 6);
            } else if ($jobStatus == ($text[1] ?? 'Open')) {
                $query->whereDate('end_date', '>=', $today)
                    ->whereIn('status', [1, 2])
                    ->where('is_hired', '!=', 1);
            } else if ($jobStatus == ($text[6] ?? 'Featured')) {
                $query->where('status', 7)
                    ->whereDate('start_date', '>=', $today)
                    ->where('status', '!=', 4)
                    ->where('status', '!=', 3);
            } else { // draft
                $query->whereDate('end_date', '>', $today)
                    ->where('is_hired', '!=', 1)
                    ->where('status', 0);
            }

            // Skill filter
            if ($request->filter_skill && $request->filter_skill != '-1') {
                $query->where('skill_category', intval($request->filter_skill));
            }

            // Get total records before pagination
            $totalRecords = $query->count();

            // Get paginated data
            $collection = $query->orderBy($columnName, $columnSortOrder)
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = [];
            foreach ($collection as $value) {
                $buttons = '';

                // Location button
                $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" target="_blank" data-toggle="tooltip" data-placement="top" title="Location" href="http://maps.google.com/maps?q=' . urlencode($value->location) . '"><i class="skill-table-action bi bi-geo-alt-fill"></i></a>';

                // View button
                $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" data-toggle="tooltip" data-placement="top" title="View" href="' . route("customer.jobs.show", $value->id) . '"><i class="skill-table-action fas fa-eye"></i></a>';

                // Approve/Submit button (only if status is draft)
                if ($value->status == 0) {
                    $buttons .= ' <button class="btn btn-icon btn-sm btn-color-dark" onclick="approveJob(' . $value->id . ', ' . $user->user_type . ')"><i class="skill-table-action fas fa-check"></i></button>';
                }

                // Edit button (only if no applications and not cancelled/completed)
                $applicationsCount = $value->applications ? count($value->applications) : 0;
                if ($applicationsCount < 1 && $value->status != 3 && $value->status != 6 && $value->status != 1) {
                    $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("customer.jobs.edit", $value->id) . '"><i class="skill-table-action fas fa-edit"></i></a>';
                }

                // Delete button
                $buttons .= ' <button class="btn btn-icon btn-sm btn-color-dark" onclick="deleteRecord(' . $value->id . ')"><i class="skill-table-action fas fa-trash"></i></button>';

                // Checkbox status
                $isChecked = ($value->home_seen_job ?? 0) ? 'checked' : '';

                // Get skill category name
                $skillName = 'NA';
                if ($value->skillCategory) {
                    $skillName = $value->skillCategory->name;
                }

                $data_arr[] = [
                    "id" => $value->id,
                    "checkbox" => '<input type="checkbox" class="item-checkbox" name="home_seen_job" data-id="' . $value->id . '" ' . $isChecked . '>',
                    "title" => ucfirst($value->title),
                    "start_date" => date('d/m/Y', strtotime($value->start_date)),
                    "end_date" => date('d/m/Y', strtotime($value->end_date)),
                    "location" => mb_strimwidth($value->location, 0, 30, '...'),
                    "number_of_employees" => $value->number_of_employees,
                    "skill_category" => $skillName,
                    "minimum_price" => '$' . number_format($value->minimum_price, 2) . ' - $' . number_format($value->maximum_price, 2),
                    "buttons" => $buttons
                ];
            }

            return response()->json([
                "draw" => $draw,
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $data_arr
            ]);

        } catch (\Exception $e) {
            \Log::error('fetchData ERROR: ' . $e->getMessage());
            
            return response()->json([
                'draw' => intval($request->get('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Fetch hired employees for datatable
     */
    public function hiredEmployee(Request $request)
    {
        $data_arr = array();
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        
        $columnIndex = isset($columnIndex_arr[0]['column']) ? $columnIndex_arr[0]['column'] : 0;
        $columnName = isset($columnName_arr[$columnIndex]['data']) ? $columnName_arr[$columnIndex]['data'] : 'id';
        $columnSortOrder = isset($order_arr[0]['dir']) ? $order_arr[0]['dir'] : 'desc';
        
        $condition = "task_id = '$request->job_id'";

        $job = Job::where('customer_id', Auth::user()->id)->find($request->job_id);
        if (!$job) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($request->employee_status == 'Hired') {
            $condition .= " and status=1";
        } else if ($request->employee_status == 'Applicant') {
            $condition .= " and status=0";
        }

        $totalRecords = JobApplication::select('count(*) as allcount')
            ->whereRaw($condition)
            ->whereHas('trader')
            ->count();

        $totalRecordswithFilter = JobApplication::select('count(*) as allcount')
            ->whereRaw($condition)
            ->whereHas('trader')
            ->count();

        $collection = JobApplication::orderBy($columnName, $columnSortOrder)
            ->whereRaw($condition)
            ->whereHas('trader')
            ->select('task_applications.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        foreach ($collection as $key => $value) {
            $buttons = '';

            if ($value->status != 2) {
                $buttons .= '<button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="rejectEmployee(' . $value->id . ',' . $value->status . ')"><i class="skill-table-action fas fa-ban"></i></button>';
            }

            if ($value->status != 1 && $value->job->status != 6) {
                $buttons .= '<button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="approveEmployee(' . $value->id . ',' . $value->status . ')"><i class="skill-table-action fas fa-check"></i></button>';
            }

            $buttons .= '<button class="primary-btn blue-button" id="for_rating" data-bs-toggle="modal" data-bs-target="#filterModal" data-userId="' . $value->id . '">
                <i class="fa fa-star unchecked me-0"></i>
            </button>';

            $messageUrl = route("home") . '/messages/' . $value->bidder_id;
            $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . $messageUrl . '" target="_blank"><i class="bi bi-chat-left-text"></i></a>';

            $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("trader.show", $value->bidder_id) . '?job_id=' . $request->job_id . '" target="_blank"><i class="skill-table-action fas fa-eye"></i></a>';

            $data_arr[] = array(
                "id" => $value->id,
                "name" => '<a href="' . route("trader.show", $value->bidder_id) . '">' . ($value->trader ? $value->trader->first_name : 'N/A') . "</a>",
                "start_date" => date('d M Y', strtotime($value->start_date)),
                "end_date" => date('d M Y', strtotime($value->end_date)),
                "payment" => $value->bid_amount ?? 0,
                "buttons" => $buttons
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    /**
     * Rate employee
     */
    public function ratingEmployee(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'required|string',
        ], [
            'rating.required' => 'Please enter rating',
            'comment.required' => 'Please enter comment',
        ]);

        $model = JobApplication::findOrFail($request->task_id);
        
        $job = Job::where('customer_id', Auth::user()->id)->find($model->task_id);
        if (!$job) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $model->rating = $request->rating;
        $model->comment = $request->comment;
        $model->customer_id = Auth::user()->id;
        $model->save();

        $bidderUser = User::find($model->bidder_id);
        if ($bidderUser) {
            if ($bidderUser->over_all_rating == 0) {
                $bidderUser->over_all_rating = $request->rating;
            } else {
                $bidderUser->over_all_rating = ($bidderUser->over_all_rating + $request->rating) / 2;
            }
            $bidderUser->save();
        }

        return response()->json(['status' => true]);
    }

    /**
     * Get rating for employee
     */
    public function getRating($id)
    {
        $job_application = JobApplication::find($id);
        
        if ($job_application) {
            $job = Job::where('customer_id', Auth::user()->id)->find($job_application->task_id);
            if (!$job) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
            }
        }

        $data = [
            'rating' => $job_application ? $job_application->rating : 0,
            'comment' => $job_application ? $job_application->comment : '',
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Get withdraw reason
     */
    public function getWithdraw($id)
    {
        $job_application = JobApplication::find($id);
        
        if ($job_application) {
            $job = Job::where('customer_id', Auth::user()->id)->find($job_application->task_id);
            if (!$job) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
            }
        }

        $data = [
            'withdraw_reason' => $job_application ? $job_application->withdraw_reason : '',
            'withdraw_date' => $job_application ? date('d-m-Y', strtotime($job_application->withdraw_date)) : '',
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Extension for employee
     */
    public function extensionEmployee(Request $request)
    {
        $job_application = JobApplication::find($request->application_id);
        
        if (!$job_application) {
            return response()->json(['status' => false, 'message' => 'Application not found']);
        }
        
        $job = Job::where('customer_id', Auth::user()->id)->find($job_application->task_id);
        if (!$job) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $job_application->extended_date = $request->extension_date;
        $job_application->customer_id = Auth::user()->id;
        $job_application->is_extended = 1;
        $job_application->save();
        
        $notification = new Notification();
        $savedNotification = $notification->saveNotification([
            'type' => 13,
            'type_text' => 'customer_extend_date',
            'sender_id' => Auth::user()->id,
            'receiver_id' => $job_application->bidder_id,
            'reference_id' => $job_application->task_id,
            'message' => ucfirst(Auth::user()->first_name . ' ' . Auth::user()->last_name) . ' has extended the work at ' . $job->location . ' to ' . date("d-m-Y", strtotime($request->extension_date)) . '.'
        ]);
        
        if ($job_application->trader && $job_application->trader->device_token && $job_application->trader->notification == 1) {
            $notification->sendNotification([
                'message' => [
                    'token' => $job_application->trader->device_token,
                    'notification' => [
                        'title' => 'Extended Job Date',
                        'body' => ucfirst(Auth::user()->first_name . ' ' . Auth::user()->last_name) . ' has extended the work at ' . $job->location . ' to ' . date("d-m-Y", strtotime($request->extension_date)) . '.'
                    ],
                    'data' => [
                        'notification_id' => (string)$savedNotification->id,
                        'type' => 'customer_extend_date',
                        'id' => (string)$job_application->task_id
                    ]
                ]
            ]);
        }
        
        return response()->json(['status' => true]);
    }
}