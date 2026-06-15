<div class="row">

    <div class="col-md-6 mb-3">

        <label>Service Name</label>

        <input type="text"
               name="service_name"
               class="form-control"
               value="{{ old('service_name',$service->service_name ?? '') }}">

        @error('service_name')
            <small class="text-danger">{{ $message }}</small>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label>Price</label>

        <input type="number"
               step="0.01"
               name="price"
               class="form-control"
               value="{{ old('price',$service->price ?? '') }}">

        @error('price')
            <small class="text-danger">{{ $message }}</small>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label>Duration (Minutes)</label>

        <input type="number"
               name="duration"
               class="form-control"
               value="{{ old('duration',$service->duration ?? '') }}">

        @error('duration')
            <small class="text-danger">{{ $message }}</small>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label>Status</label>

        <select name="status" class="form-control">

            <option value="1"
                {{ old('status',$service->status ?? 1)==1 ? 'selected':'' }}>
                Active
            </option>

            <option value="0"
                {{ old('status',$service->status ?? '')==0 ? 'selected':'' }}>
                Inactive
            </option>

        </select>

    </div>

    <div class="col-md-12 mb-3">

        <label>Description</label>

        <textarea
            name="description"
            rows="5"
            class="form-control">{{ old('description',$service->description ?? '') }}</textarea>

    </div>

    <div class="col-md-6 mb-3">

        <label>Service Image</label>

        <input type="file"
               name="image"
               class="form-control">

        @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror

    </div>

    @isset($service)

        @if($service->image)

            <div class="col-md-6">

                <img
                    src="{{ asset('storage/'.$service->image) }}"
                    width="120">

            </div>

        @endif

    @endisset

</div>