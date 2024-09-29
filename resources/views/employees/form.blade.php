@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($employee) ? 'Edit Employee' : 'Add Employee' }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}" method="POST">
        @csrf
        @if (isset($employee))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ isset($employee) ? $employee->name : '' }}" required>
        </div>

        <div class="form-group">
            <label for="cpf">CPF</label>
            @php
                $isEdit = isset($employee);

                $cpfValue = $isEdit ? $employee->cpf_prefix . '.***.***-**' : '';
                
                $inputClass = $isEdit ? 'form-control' : 'form-control cpf';

                $inputAttributes = $isEdit ? 'readonly' : 'required';
            @endphp
            <input type="text" name="cpf" id="cpf" class="{{ $inputClass }}" maxlength="14" value="{{ $cpfValue }}" {{ $inputAttributes }}>
        </div>

        <div class="form-group">
            <label for="birth_date">Date of birth</label>
            <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ isset($employee) ? $employee->birth_date : '' }}" required>
        </div>

        <div class="form-group">
            <label for="date_first_dose">First dose date</label>
            <input type="date" name="date_first_dose" id="date_first_dose" class="form-control" value="{{ isset($employee) ? $employee->date_first_dose : '' }}">
        </div>

        <div class="form-group">
            <label for="date_second_dose">Second dose date</label>
            <input type="date" name="date_second_dose" id="date_second_dose" class="form-control" value="{{ isset($employee) ? $employee->date_second_dose : '' }}">
        </div>

        <div class="form-group">
            <label for="date_third_dose">Third dose date</label>
            <input type="date" name="date_third_dose" id="date_third_dose" class="form-control" value="{{ isset($employee) ? $employee->date_third_dose : '' }}">
        </div>

        <div class="form-group">
            <label for="comorbidity">Comorbidity</label>
            <select name="comorbidity" id="comorbidity" class="form-control">
                <option value="1" {{ isset($employee) && $employee->comorbidity ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ isset($employee) && !$employee->comorbidity ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="comorbidity_desc">Comorbidity Description (if applicable)</label>
            <input type="text" name="comorbidity_desc" id="comorbidity_desc" class="form-control" value="{{ isset($employee) ? $employee->comorbidity_desc : '' }}">
        </div>

        <div class="form-group">
            <label for="is_active">Is active?</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" {{ isset($employee) && $employee->is_active ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ isset($employee) && !$employee->is_active ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="vaccine_id">Vaccine</label>
            <select name="vaccine_id" id="vaccine_id" class="form-control" required>
                @foreach ($vaccines as $vaccine)
                    <option value="{{ $vaccine->id }}" {{ isset($employee) && $employee->vaccine_id == $vaccine->id ? 'selected' : '' }}>
                        {{ $vaccine->name }} ({{ $vaccine->batch }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($employee) ? 'Update' : 'Save' }}</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection