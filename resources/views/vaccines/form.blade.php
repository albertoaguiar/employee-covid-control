@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($vaccine) ? 'Edit Vaccine' : 'Add Vaccine' }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($vaccine) ? route('vaccines.update', $vaccine->id) : route('vaccines.store') }}" method="POST">
        @csrf
        @if(isset($vaccine))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ isset($vaccine) ? $vaccine->name : old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="batch">Batch</label>
            <input type="text" name="batch" id="batch" class="form-control" value="{{ isset($vaccine) ? $vaccine->batch : old('batch') }}" required>
        </div>

        <div class="form-group">
            <label for="expiration_date">Expiration date</label>
            <input type="date" name="expiration_date" id="expiration_date" class="form-control" value="{{ isset($vaccine) ? $vaccine->expiration_date : old('expiration_date') }}" required>
        </div>

        <div class="form-group">
            <label for="is_active">Is active?</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" {{ isset($vaccine) && $vaccine->is_active ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ isset($vaccine) && !$vaccine->is_active ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            {{ isset($vaccine) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('vaccines.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection