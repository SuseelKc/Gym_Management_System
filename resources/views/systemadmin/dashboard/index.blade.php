@extends('admin.admin')
@section('title','Dashboard')
@section('content')

<div class="container-fluid pt-2 pd-2">

    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
          <div class="card w-100 shadow">
            <div class="card-body">
              <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Gym Overview</h5>
                </div>
                
              </div>
              <div id="chart">
                <div>
                  {!! $chart->container() !!}
              </div>
          
                {!! $chart->script() !!}
              </div>
            </div>
          </div>
        </div>      
    </div>
</div>    

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection