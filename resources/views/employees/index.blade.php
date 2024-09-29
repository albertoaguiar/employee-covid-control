@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employees</h1>

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

    <form method="GET" action="{{ route('employees.index') }}" class="mb-3">
        <div class="form-row">
            <div class="col-md-2">
                <label for="first_dose_date_start">1st dose date start</label>
                <input type="date" name="first_dose_date_start" id="first_dose_date_start" class="form-control" value="{{ request('first_dose_date_start') }}">
            </div>
            <div class="col-md-2">
                <label for="first_dose_date_end">1st dose date end</label>
                <input type="date" name="first_dose_date_end" id="first_dose_date_end" class="form-control" value="{{ request('first_dose_date_end') }}">
            </div>
            <div class="col-md-2">
                <label for="second_dose_date_start">2nd dose date start</label>
                <input type="date" name="second_dose_date_start" id="second_dose_date_start" class="form-control" value="{{ request('second_dose_date_start') }}">
            </div>
            <div class="col-md-2">
                <label for="second_dose_date_end">2nc dose date end</label>
                <input type="date" name="second_dose_date_end" id="second_dose_date_end" class="form-control" value="{{ request('second_dose_date_end') }}">
            </div>
            <div class="col-md-2">
                <label for="third_dose_date_start">3rd dose date start</label>
                <input type="date" name="third_dose_date_start" id="third_dose_date_start" class="form-control" value="{{ request('third_dose_date_start') }}">
            </div>
            <div class="col-md-2">
                <label for="third_dose_date_end">3rd dose date end</label>
                <input type="date" name="third_dose_date_end" id="third_dose_date_end" class="form-control" value="{{ request('third_dose_date_end') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-3">
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Name" class="form-control" value="{{ request('name') }}">
            </div>
            <div class="col-md-3">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" placeholder="CPF" class="form-control cpf" value="{{ request('cpf') }}">
            </div>
            <div class="col-md-3">
                <label for="vaccine_id">Vaccines</label>
                <select name="vaccine_id" class="form-control">
                    <option value="">Select the vaccine</option>
                    @foreach($vaccines as $vaccine)
                        <option value="{{ $vaccine->id }}" {{ request('vaccine_id') == $vaccine->id ? 'selected' : '' }}>
                            {{ $vaccine->name }}
                        </option>
                    @endforeach
                </select>
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

    <a href="{{ route('employees.create') }}" class="btn btn-success mb-3">Add new employee</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>CPF</th>
                <th>Date of birth</th>
                <th>Vaccine</th>
                <th>Batch</th>
                <th>1tst dose</th>
                <th>2nd dose</th>
                <th>3rd dose</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($employees->isEmpty())
                <tr>
                    <td colspan="10" class="text-center">No employees found.</td>
                </tr>
            @else
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->cpf_prefix }}.***.***-**</td>
                        <td>{{ Carbon::parse($employee->birth_date)->format('d/m/Y') }}</td>
                        <td>{{ $employee->vaccine ? $employee->vaccine->name : '' }}</td>
                        <td>{{ $employee->vaccine ? $employee->vaccine->batch : '' }}</td>
                        <td>{{ $employee->date_first_dose ? Carbon::parse($employee->date_first_dose)->format('d/m/Y') : "" }}</td>
                        <td>{{ $employee->date_second_dose ? Carbon::parse($employee->date_second_dose)->format('d/m/Y') : "" }}</td>
                        <td>{{ $employee->date_third_dose ? Carbon::parse($employee->date_third_dose)->format('d/m/Y') : "" }}</td>
                        <td>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
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
        {{ $employees->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
@endsection