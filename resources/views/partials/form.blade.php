<form action="/" method="get" class="">
    <div class="form-group">
        <label for="searchform-country">Country</label>
        <select class="form-control" name="SearchForm[country]" id="searchform-country">
            <option value="">Please select</option>
            @foreach ($countries as $country)
                <option {{ $country->id == $model->country ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-success" type="submit">Search</button>
</form>
