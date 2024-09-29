@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vaccines</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="GET" action="{{ route('vaccines.index') }}" class="mb-3">
        <div class="form-row">
            <div class="col">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Nome" class="form-control" value="{{ request('name') }}">
            </div>
            <div class="col">
                <label for="batch">Batch</label>
                <input type="text" name="batch" id="batch" placeholder="Batch" class="form-control" value="{{ request('batch') }}">
            </div>
            <div class="col">
                <label for="expiration_date_start">Expiration date start</label>
                <input type="date" name="expiration_date_start" id="expiration_date_start" class="form-control" value="{{ request('expiration_date_start') }}">
            </div>
            <div class="col">
                <label for="expiration_date_end">Expiration date end</label>
                <input type="date" name="expiration_date_end" id="expiration_date_end" class="form-control" value="{{ request('expiration_date_end') }}">
            </div>
            <div class="col">
                <label for="is_active">Status</label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="">All</option>
                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    

    <a href="{{ route('vaccines.create') }}" class="btn btn-success mb-3">Add new vaccine</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Batch</th>
                <th>Expiration date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($vaccines->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No vaccines found.</td>
                </tr>
            @else
                @foreach ($vaccines as $vaccine)
                    <tr>
                        <td>{{ $vaccine->id }}</td>
                        <td>{{ $vaccine->name }}</td>
                        <td>{{ $vaccine->batch }}</td>
                        <td>{{ Carbon::parse($vaccine->expiration_date)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('vaccines.edit', $vaccine->id) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route('vaccines.destroy', $vaccine->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $vaccines->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
@endsection
