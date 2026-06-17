<div class="row">

    <div class="col-md-6 mb-3">

        <label>Name</label>

        <input type="text"
               name="service_name"
               class="form-control"
               value="{{ old('service_name',$service->service_name ?? '') }}">

    </div>

    <div class="col-md-6 mb-3">

        <label>Type</label>

        <select name="type"
                id="type"
                class="form-control">

            <option value="category"
                {{ old('type',$service->type ?? '') == 'category' ? 'selected' : '' }}>
                Category
            </option>

            <option value="sub_category"
                {{ old('type',$service->type ?? '') == 'sub_category' ? 'selected' : '' }}>
                Sub Category
            </option>

        </select>

    </div>

    <div class="col-md-6 mb-3 parent-section">

        <label>Category</label>

        <select name="parent_id" class="form-control">

            <option value="">
                Select Category
            </option>

            @foreach($categories as $category)

                <option value="{{ $category->id }}"
                    {{ old('parent_id',$service->parent_id ?? '') == $category->id ? 'selected' : '' }}>

                    {{ $category->service_name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-12 mb-3">

        <label>Description</label>

        <textarea name="description"
                  class="form-control">{{ old('description',$service->description ?? '') }}</textarea>

    </div>

    <div class="col-md-6 mb-3">

        <label>Image</label>

        <input type="file"
               name="image"
               class="form-control">

    </div>

    <div class="col-md-6 mb-3">

        <label>Status</label>

        <select name="status"
                class="form-control">

            <option value="1">Active</option>
            <option value="0">Inactive</option>

        </select>

    </div>

</div>