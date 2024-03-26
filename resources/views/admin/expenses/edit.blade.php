@extends('admin.admin')
@section('title','Create Expenses')
@section('content')


<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('expenses.index') }}">Expenses</a>
                        </li> 
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h2 class="card-title font-weight-bold">Edit Expenses</h2>
                        </div>
                        <form method="POST" action=" 
                        {{route('expenses.update',$expenses->id)}}
                        " enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="card-body">
                                <div class="row">
                                    <!-- name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Name">Name</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Enter Expenses Name Here" name="name" value="{{$expenses->name}}" required >
                                            @if ($errors->has('name'))
                                                <x-validation-errors>
                                                    {{ $errors->first('name') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gym_name">Gym Name</label>
                                            <input type="text" class="form-control" id="gym_name"
                                                placeholder="Enter Name Here" name="gym_name" value="{{ $gym->name }}" readonly>
                                            @if ($errors->has('gym_name'))
                                                <x-validation-errors>
                                                    {{ $errors->first('gym_name') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>
                                    <!--  -->



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="costs">Costs</label>

                                            <div class="form-check">
                                                @if(($expenses->type)=='today')
                                                <input type="checkbox" id="today" class="form-check-input" checked />
                                                @else
                                                <input type="checkbox" id="today" class="form-check-input" />
                                                @endif
                                                <label>One-Time Expenses</label>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <input type="number" class="form-control mr-2" id="costs" style="width: 150px;" value="{{$expenses->costs}}"
                                                       name="costs" value="" required>
                                                    <select id="type" style="height: 30px; display: block;" name="type" >
                                                        <option value="" selected>Select Type</option>
                                                        <option value="year" {{ $expenses->type == 'year' ? 'selected' : '' }} >Yearly</option>
                                                        <option value="month"{{ $expenses->type == 'month' ? 'selected' : '' }} >Monthly</option>
                                                        <option value="days" {{ $expenses->type == 'days' ? 'selected' : '' }}>Daily</option>
                                                        <option hidden value="today" {{ $expenses->type == 'today' ? 'selected' : '' }} >Today</option>
                                                    </select>                                                   
                                            </div>
                                            @if ($errors->has('expense_period'))
                                                <x-validation-errors>
                                                    {{ $errors->first('expense_period') }}
                                                </x-validation-errors>
                                            @endif
                                        </div>
                                    </div>
                                                                                                       

                                    <div class="col-md-6">

                                        <div class="form-check" style="display: block;" id="add_date">
                                            <input type="checkbox" id="add_date_checkbox" class="form-check-input" />
                                            <label>Add Date</label>
                                        </div>
                                        <div class="form-row" id="date_fields" style="display: none;">
                                            <div class="row" style="margin-left: 2px;">
                                                <div class="form-group" style="margin-right: 10px;">
                                                    <label for="start_date">Start Date</label>
                                                    <input type="date" class="form-control" id="start_date"  name="start_date" value="{{$expenses->start_date}}" >
                                                    @if ($errors->has('start_date'))
                                                        <x-validation-errors>
                                                            {{ $errors->first('start_date') }}
                                                        </x-validation-errors>
                                                    @endif
                                                </div>
                                            

                                                {{-- <div class="form-group"  style="margin-right: 10px;">
                                                    <label for="end_date">End Date</label>
                                                    <input type="date" class="form-control" id="end_date"  name="end_date" value="{{$expenses->end_date}}">
                                                    @if ($errors->has('end_date'))
                                                        <x-validation-errors>
                                                            {{ $errors->first('end_date') }}
                                                        </x-validation-errors>
                                                    @endif
                                                </div> --}}
                                            </div>   
                                        </div>
                                        

                                   </div>
                                  

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary px-3">Submit</button>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    // Get the checkbox element
    const addDateCheckbox = document.getElementById('add_date_checkbox');
    // Get the date fields container
    const dateFieldsContainer = document.getElementById('date_fields');
    // Get the checkbox element
    const today = document.getElementById('today');
    // Get the date fields container
    const typeSelect = document.getElementById('type');
    const addDate = document.getElementById('add_date');
     // Get the checkbox element
    const DateCheckbox = document.getElementById('add_date_checkbox');
    const todayOptionValue = 'today';

    // Add event listener to checkbox
    addDateCheckbox.addEventListener('change', function() {
        // If checkbox is checked, display the date fields; otherwise, hide them
        if (this.checked) {
            dateFieldsContainer.style.display = 'block';
        } else {
            dateFieldsContainer.style.display = 'none';
        }
    });

    today.addEventListener('change', function() {
        // If checkbox is checked, display the date fields; otherwise, hide them
        if (this.checked) {
            typeSelect.style.display = 'none';
            dateFieldsContainer.style.display = 'none';
            addDate.style.display = 'none';
            DateCheckbox.checked = false;
            typeSelect.value = todayOptionValue;

        } else {
            typeSelect.style.display = 'block';
            addDate.style.display = 'block';
            typeSelect.value = 'null';
        }
    });

</script>

@endsection

