@extends('layouts.admin.app')
@section('content')
   @include('layouts.admin.sidebar-navbar')
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-sm-6">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ action('PropertiesController@index') }}">Properties</a>
                     </li>
                     <li class="breadcrumb-item active">Properties Created</li>
                  </ol>
               </div>
            </div>
         </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
         @include('admin.messages')
         <ul class="nav nav-pills mb-3" id="myTab" role="tablist">

            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#case" role="tab" aria-controls="case" aria-selected="true">Case</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#cpu" role="tab" aria-controls="cpu"
                  aria-selected="true">CPU</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#hdd" role="tab" aria-controls="hdd"
                  aria-selected="true">HDD</a>
            </li>

            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                  aria-expanded="false">Mainboard</a>
               <div class="dropdown-menu">
                  <a class="dropdown-item link" data-toggle="tab" href="#mainboard_chip">Chipset</a>
                  <a class="dropdown-item link" data-toggle="tab" href="#mainboard_size">Size</a>
               </div>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                  aria-expanded="false">Monitor</a>
               <div class="dropdown-menu">
                  <a class="dropdown-item link" data-toggle="tab" href="#monitor_refresh_rate">Refresh Rate</a>
                  <a class="dropdown-item link" data-toggle="tab" href="#monitor_resolution">Resolution</a>
                  <a class="dropdown-item link" data-toggle="tab" href="#monitor_resolution_time">Response Time</a>
                  <a class="dropdown-item link" data-toggle="tab" href="#monitor_size">Size</a>
               </div>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                  aria-expanded="false">PSU</a>
               <div class="dropdown-menu">
                  <a class="dropdown-item link" data-toggle="tab" href="#psuEE">Energy Efficiency</a>
                  <a class="dropdown-item link" data-toggle="tab" href="#psuPower">Power</a>
               </div>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                  aria-expanded="false">RAM</a>
               <div class="dropdown-menu">
                  <a class="dropdown-item link" data-toggle="tab" href="#ramCapacity">Capacity</a>
                  <a class="dropdown-item link" data-toggle="tab" href="#ramType">Type</a>
               </div>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                  aria-expanded="false">SSD</a>
               <div class="dropdown-menu">
                  <a class="dropdown-item link" data-toggle="tab" href="#ssdFactor">Form Factor</a>
                  <a class="dropdown-item link" data-toggle="tab" href="#ssdInterface">Interface</a>
               </div>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                  aria-expanded="false">VGA</a>
               <div class="dropdown-menu">
                  <a class="dropdown-item link" data-toggle="tab" href="#vgaGpu">GPU</a>
                  <a class="dropdown-item link" data-toggle="tab" href="#vgaMem">Memmory</a>
               </div>
            </li>

         </ul>
         <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="case" role="tabpanel" aria-labelledby="case-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new Case Type</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveCase') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="caseTypeText" class='col-lg-2'>Case Type</label>
                           <div class="col-lg-10">
                              <input id='caseTypeText' type="text" class='form-control' name='txt_case_type'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_case_type') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="cpu" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new CPU Serie</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveCpu') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="cpuTypeText" class='col-lg-2'>CPU Serie</label>
                           <div class="col-lg-10">
                              <input id='cpuTypeText' type="text" class='form-control' name='txt_cpu_type'>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="cpuManuText" class='col-lg-2'>Manufacture</label>
                           <div class="col-lg-10">
                              <select name="sl_cpu_manu" id="cpuManuText" class='form-control'>
                                 <option value="" selected>-- Choose Manufacture</option>
                                 <option value="Intel">Intel</option>
                                 <option value="AMD">AMD</option>
                              </select>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_cpu_type') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="hdd" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new Drive Capacities</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveHDD') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Driver Capacity</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_driver'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_driver') }}</p>
                        <div class="form-group row">
                           <label for="DriverType" class='col-lg-2'>Driver Type</label>
                           <div class="col-lg-10">
                              <select name="sl_drive_type" id="DriverType" class='form-control'>
                                 <option value="" selected>-- Choose Driver Type</option>
                                 <option value="SSD">SSD</option>
                                 <option value="HDD">HDD</option>
                              </select>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('sl_drive_type') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="mainboard_chip" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new Mainboard Chipset</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveMb') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Chipset</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_mb_chipset'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_mb_chipset') }}</p>
                        <div class="form-group row">
                           <label for="DriverType" class='col-lg-2'>Manufacture</label>
                           <div class="col-lg-10">
                              <select name="sl_mb_manu" id="DriverType" class='form-control'>
                                 <option value="" selected>-- Choose Manufacture</option>
                                 <option value="Intel">Intel</option>
                                 <option value="AMD">AMD</option>
                              </select>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('sl_mb_manu') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="mainboard_size" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new Mainboard Size</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveMb_size') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Mainboard Size</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_mb_size'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_mb_size') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="monitor_refresh_rate" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new Refresh Rate</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveMt_RR') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Refresh Rate</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_mt_rr'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_mt_rr') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="monitor_resolution" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new Resolution</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveMt_Res') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Resolution</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_mt_res'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_mt_res') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="monitor_resolution_time" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new Response Time</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveMt_time') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Response Time</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_mt_time'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_mt_time') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="monitor_size" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new Monitor Size</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveMt_size') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Monitor Size</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_mt_size'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_mt_size') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="psuEE" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new PSU Energy Efficiency</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@savePsu_EE') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>PSU Energy Efficiency</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_psu_ee'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_psu_ee') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="psuPower" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new PSU Power</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@savePsu_pw') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Power</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_psu_pw'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_psu_pw') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="ramCapacity" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new RAM Capacity</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveRam_ca') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Capacity</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_ram_ca'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_ram_ca') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="ramType" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new RAM Speed</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveRam_sp') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Speed</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_ram_sp'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_ram_sp') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="ssdFactor" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new SSD Form Factor</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveSSD_ff') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>SSD Form Factor</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_ssd_ff'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_ssd_ff') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="ssdInterface" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new SSD Interface</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveSSD_interface') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>SSD Interface</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_ssd_if'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_ssd_if') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="vgaGpu" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new VGA GPU</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveVGA_gpu') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Vga GPU</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_vga_gpu'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_vga_gpu') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="vgaMem" role="tabpanel" aria-labelledby="cpu-tab">
               <div class="card w-50">
                  <div class="card-header">
                     <h3 class='card-title'>Create new VGA Memory Size</h3>
                  </div>
                  <div class="card-body">
                     <form action="{{ action('PropertiesController@saveVGA_mem') }}" method='post'>
                        @csrf
                        <div class="form-group row">
                           <label for="DriverText" class='col-lg-2'>Vga Memory</label>
                           <div class="col-lg-10">
                              <input id='DriverText' type="text" class='form-control' name='txt_vga_mem'>
                           </div>
                        </div>
                        <p class="font-italic font-weight-bold text-center"
                           style='color:red'>{{ $errors->first('txt_vga_mem') }}</p>
                        <div class="row">
                           <div class="col-lg-5"></div>
                           <div class="text-center col-lg-2">
                              <input type="submit" value='Submit' class='btn btn-success mr-5'>
                           </div>
                           <div class="col-lg-5"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>


      </section>
      <!-- /.content -->
   </div>
   <!-- /.content-wrapper -->

   <!-- Control Sidebar -->
   <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
   </aside>
   <!-- /.control-sidebar -->
@endsection