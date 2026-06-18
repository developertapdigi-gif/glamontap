<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Service ,SkillCategory, User};
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('parent')
            ->latest()
            ->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Service::where('type', 'category')
            ->where('status', 1)
            ->orderBy('service_name')
            ->get();

        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|max:255',
            'type' => 'required|in:category,sub_category',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->all();

        // Category should not have parent_id
        if ($request->type == 'category') {
            $data['parent_id'] = null;
        }

        // Upload Image
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/services'),
                $imageName
            );

            $data['image'] = 'uploads/services/'.$imageName;
        }

        Service::create($data);

        return redirect()
            ->route('service.index')
            ->with('success', 'Record added successfully.');
    }

    public function edit(Service $service)
    {
        $categories = Service::where('type', 'category')
            ->where('status', 1)
            ->where('id', '!=', $service->id)
            ->orderBy('service_name')
            ->get();

        return view(
            'admin.services.edit',
            compact('service', 'categories')
        );
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_name' => 'required|max:255',
            'type' => 'required|in:category,sub_category',
            'image' => 'nullable|image',
        ]);

        $data = $request->all();

        // Category should not have parent_id
        if ($request->type == 'category') {
            $data['parent_id'] = null;
        }

        // Update Image
        if ($request->hasFile('image')) {

            if (
                $service->image &&
                file_exists(public_path($service->image))
            ) {
                unlink(public_path($service->image));
            }

            $image = $request->file('image');

            $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/services'),
                $imageName
            );

            $data['image'] = 'uploads/services/'.$imageName;
        }

        $service->update($data);

        return redirect()
            ->route('service.index')
            ->with('success', 'Record updated successfully.');
    }

    public function destroy(Service $service)
    {
        if (
            $service->image &&
            file_exists(public_path($service->image))
        ) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return redirect()
            ->route('service.index')
            ->with('success', 'Record deleted successfully.');
    }

    public function showByCategorySubCategory($id)
    {
        $skills = SkillCategory::where('status', 1)->get();
        $service = Service::findOrFail($id);
        $subCategories = Service::where('parent_id', $id)->get();
        $company = User::where('user_type', 2)->where('first_name', '!=', '')->where('status',1)->get();

        return view('website.services-shows-categories', compact('service', 'subCategories', 'skills', 'company'));
    }
}
