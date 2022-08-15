@extends('layout.layout')
@section('content')

<style>
  .dashboard-box {
    padding: 10px !important;
    border-radius: 4px !important;
  }

  .dashboard-box .dashboard-icon {
    font-size: 25px !important;
    height: 40px !important;
  }

  .dashboard-box .dashboard-data .dashboard-title {
    font-size: 13px !important;
  }

  .dashboard-icon {
    background-color: gray !important;
  }
</style>
<div class="card-header py-2 h-body">
  <div class="row">
    <div class="col-md-6 pt-1">
      <h6 class="m-0 font-weight-bold text-primary">Dashboard</h6>
    </div>

  </div>
</div>

<div class="dashboard-container">

  <div class="row">

    <div class="col-md-2">
      <div class="dashboard-box">
        <div class="dashboard-icon icon-4">
          <i class="mdi mdi-note-text"></i>
        </div>
        <div class="dashboard-data">

          <div class="dashboard-title">
            <span>All Follow Up</span>
          </div>
          <div class="dashboard-count">
            <span>{{!empty($followUp->all_follow_up)?$followUp->all_follow_up:0}}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-2">
      <div class="dashboard-box">
        <div class="dashboard-icon icon-1">
          <i class="mdi mdi-note-text"></i>
        </div>
        <div class="dashboard-data">

          <div class="dashboard-title">
            <span>Follow Up</span>
          </div>
          <div class="dashboard-count">
            <span>{{!empty($followUp->follow_up)?$followUp->follow_up:0}}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-2">
      <div class="dashboard-box">
        <div class="dashboard-icon icon-2">
          <i class="mdi mdi-note-text"></i>
        </div>
        <div class="dashboard-data">

          <div class="dashboard-title">
            <span>On Hold</span>
          </div>
          <div class="dashboard-count">
            <span>{{!empty($followUp->on_hold)?$followUp->on_hold:0}}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-2">
      <div class="dashboard-box">
        <div class="dashboard-icon icon-3">
          <i class="mdi mdi-note-text"></i>
        </div>
        <div class="dashboard-data">

          <div class="dashboard-title">
            <span>Completed</span>
          </div>
          <div class="dashboard-count">
            <span>{{!empty($followUp->completed)?$followUp->completed:0}}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-2">
      <div class="dashboard-box">
        <div class="dashboard-icon icon-3">
          <i class="mdi mdi-note-text"></i>
        </div>
        <div class="dashboard-data">

          <div class="dashboard-title">
            <span>Revert</span>
          </div>
          <div class="dashboard-count">
            <span>{{!empty($followUp->revert)?$followUp->revert:0}}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-2">
      <div class="dashboard-box">
        <div class="dashboard-icon icon-3">
          <i class="mdi mdi-note-text"></i>
        </div>
        <div class="dashboard-data">

          <div class="dashboard-title">
            <span>Rejected</span>
          </div>
          <div class="dashboard-count">
            <span>{{!empty($followUp->rejected)?$followUp->rejected:0}}</span>
          </div>
        </div>
      </div>
    </div>

  </div>


  <!-- <div class="row mt-4">
    <div class="col-sm-6 stretch-card grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="card-title"> Customers <small class="d-block text-muted">August 01 - August 31</small>
            </div>
            <div class="d-flex text-muted font-20">
              <i class="mdi mdi-printer mouse-pointer"></i>
              <i class="mdi mdi-help-circle-outline ms-2 mouse-pointer"></i>
            </div>
          </div>
          <h3 class="font-weight-bold mb-0"> 2,409 <span class="text-success h5">4,5%<i class="mdi mdi-arrow-up"></i></span>
          </h3>
          <span class="text-muted font-13">Avg customers/Day</span>
          <div class="line-chart-wrapper">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
            </div>
            <canvas id="linechart" height="176" style="display: block; height: 141px; width: 530px;" width="662" class="chartjs-render-monitor"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 stretch-card grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="card-title"> Conversions <small class="d-block text-muted">August 01 - August 31</small>
            </div>
            <div class="d-flex text-muted font-20">
              <i class="mdi mdi-printer mouse-pointer"></i>
              <i class="mdi mdi-help-circle-outline ms-2 mouse-pointer"></i>
            </div>
          </div>
          <h3 class="font-weight-bold mb-0"> 0.40% <span class="text-success h5">0.20%<i class="mdi mdi-arrow-up"></i></span>
          </h3>
          <span class="text-muted font-13">Avg customers/Day</span>
          <div class="bar-chart-wrapper">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
            </div>
            <canvas id="barchart" height="176" width="662" style="display: block; height: 141px; width: 530px;" class="chartjs-render-monitor"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div> -->





</div>

@endsection