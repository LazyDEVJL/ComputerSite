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
                     <li class="breadcrumb-item"><a href="{{ action('PropertiesController@index') }}">Properties</a></li>
                     <li class="breadcrumb-item active">Properties List</li>
                  </ol>
               </div>
            </div>
         </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
         @include('admin.messages')
         <div class="row">
            <div class="col-lg-6">
                <a href="{{ action('PropertiesController@create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Create new Properties
                </a>
            </div>
        </div>
         <ul class="nav nav-pills mb-3" id="myTab" role="tablist">

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#case" role="tab" aria-controls="case" aria-selected="true">Case</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#cpu" role="tab" aria-controls="cpu" aria-selected="true">CPU</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#hdd" role="tab" aria-controls="hdd" aria-selected="true">HDD</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Mainboard</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item link" data-toggle="tab" href="#mainboard_chip">Chipset</a>
                    <a class="dropdown-item link" data-toggle="tab" href="#mainboard_size">Size</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Monitor</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item link" data-toggle="tab" href="#monitor_refresh_rate">Refresh Rate</a>
                    <a class="dropdown-item link" data-toggle="tab" href="#monitor_resolution">Resolution</a>
                    <a class="dropdown-item link" data-toggle="tab" href="#monitor_resolution_time">Response Time</a>
                    <a class="dropdown-item link" data-toggle="tab" href="#monitor_size">Size</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">PSU</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item link" data-toggle="tab" href="#psuType">PSU Type</a>
                    <a class="dropdown-item link" data-toggle="tab" href="#psuPower">Power</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">RAM</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item link" data-toggle="tab" href="#ramCapacity">Capacity</a>
                    <a class="dropdown-item link" data-toggle="tab" href="#ramType">Speed</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">SSD</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item link" data-toggle="tab" href="#ssdFactor">Factor</a>
                    <a class="dropdown-item link" data-toggle="tab" href="#ssdInterface">Interface</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">VGA</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item link" data-toggle="tab" href="#vgaGpu">GPU</a>
                    <a class="dropdown-item link" data-toggle="tab" href="#vgaMem">Memmory</a>
                </div>
            </li>

        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="case" role="tabpanel" aria-labelledby="case-tab">
                @include('layouts.properties.master2')
                   Case Type List
                @include('layouts.properties.master3')
                    <input type="text" name="q-case" placeholder="Search by case name" class="form-control">
                @include('layouts.properties.master4')
                        <table class="table table-hover table-valign-middle text-center">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Case Type</th>
                                    <th colspan="2">Action</th>
                                </tr>
                                @foreach($AllCase as $case)
                                <tr>
                                    <td>{{ $case -> id }}</td>
                                    <td>{{ $case -> case_type }}</td>
                                    <td>
                                        <a href="{{action('PropertiesController@editCase',['id'=>$case->id])}}" class="btn btn-default">
                                            <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                        <a href="{{action('PropertiesController@delCase',['id'=>$case->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                            <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                @include('layouts.properties.master5')
                {{$AllCase->links()}}
            </div>
            <div class="tab-pane fade" id="cpu" role="tabpanel" aria-labelledby="cpu-tab">
                @include('layouts.properties.master2')
                    Cpu Type List
                @include('layouts.properties.master3')
                    <input type="text" name="q-cpu" placeholder="Search by cpu name" class="form-control">
                @include('layouts.properties.master4')
                            <table class="table table-hover table-valign-middle text-center">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cpu Type</th>
                                        <th>Cpu Manufacture</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    @foreach($AllCpu as $cpu)
                                    <tr>
                                        <td>{{$cpu->id}}</td>
                                        <td>{{$cpu->cpuserie}}</td>
                                        <td>{{$cpu->cpu_manufacture}}</td>
                                        <td>
                                            <a href="{{action('PropertiesController@editCpu',['id'=>$cpu->id])}}" class="btn btn-default">
                                                <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                            <a href="{{action('PropertiesController@delCpu',['id'=>$cpu->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                                <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                @include('layouts.properties.master5')
                {{$AllCpu->links()}}
            </div>
            <div class="tab-pane fade" id="hdd" role="tabpanel" aria-labelledby="hdd-tab">
                @include('layouts.properties.master2')
                    Driver Capacity
                @include('layouts.properties.master3')
                    <input type="text" name="q-hdd" placeholder="Search by drive" class="form-control">
                @include('layouts.properties.master4')
                            <table class="table table-hover table-valign-middle text-center">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Drive Capacities</th>
                                        <th>Drive Type</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    @foreach($AllHdd as $hdd)
                                    <tr>
                                        <td>{{$hdd->id}}</td>
                                        <td>{{$hdd->drive_capacity}}</td>
                                        <td>{{$hdd->driver_type}}</td>
                                        <td>
                                            <a href="{{action('PropertiesController@editHdd',['id'=>$hdd->id])}}" class="btn btn-default">
                                                <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                            <a href="{{action('PropertiesController@delHdd',['id'=>$hdd->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                                <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                @include('layouts.properties.master5')
                {{$AllHdd->links()}}
            </div>
            <div class="tab-pane fade" id="mainboard_chip" role="tabpanel" aria-labelledby="mb_chip-tab">
                @include('layouts.properties.master2')
                    Mainboard Chipset
                @include('layouts.properties.master3')
                    <input type="text" name="q-mb" placeholder="Search by Chipset or Manufacture" class="form-control">
                @include('layouts.properties.master4')
                            <table class="table table-hover table-valign-middle text-center">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Chipset</th>
                                        <th>Manufacture</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    @foreach($AllMb as $mb)
                                    <tr>
                                        <td>{{$mb->id}}</td>
                                        <td>{{$mb->mb_chipset}}</td>
                                        <td>{{$mb->chipset_manufactur}}</td>
                                        <td>
                                            <a href="{{action('PropertiesController@editMb',['id'=>$mb->id])}}" class="btn btn-default">
                                                <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                            <a href="{{action('PropertiesController@delMb',['id'=>$mb->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                                <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                @include('layouts.properties.master5')
                {{$AllMb->links()}}
            </div>
            <div class="tab-pane fade" id="mainboard_size" role="tabpanel" aria-labelledby="mb_size-tab">
                @include('layouts.properties.master2')
                    Mainboard Size
                @include('layouts.properties.master3')
                    <input type="text" name="q-mb-size" placeholder="Search by Size" class="form-control">
                @include('layouts.properties.master4')
                            <table class="table table-hover table-valign-middle text-center">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mainboard Size</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    @foreach($AllMb_size as $mb_size)
                                    <tr>
                                        <td>{{$mb_size->id}}</td>
                                        <td>{{$mb_size->mb_size}}</td>
                                        <td>
                                            <a href="{{action('PropertiesController@editMb_size',['id'=>$mb_size->id])}}" class="btn btn-default">
                                                <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                            <a href="{{action('PropertiesController@delMb_size',['id'=>$mb_size->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                                <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                @include('layouts.properties.master5')
                {{$AllMb->links()}}
            </div>
            <div class="tab-pane fade" id="monitor_refresh_rate" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                Moniter Refresh Rate
                @include('layouts.properties.master3')
                <input type="text" name="q-mt-rr" placeholder="Search by Refresh Rate" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Refresh Rate</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllMnt_RR as $mt_rr)
                        <tr>
                            <td>{{$mt_rr->id}}</td>
                            <td>{{$mt_rr->mnt_refresh_rate}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editMt_RR',['id'=>$mt_rr->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delMt_RR',['id'=>$mt_rr->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllMb->links()}}
            </div>
            <div class="tab-pane fade" id="monitor_resolution" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                Monitor Resolution
                @include('layouts.properties.master3')
                <input type="text" name="q-mt-res" placeholder="Search by Resolution" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Resolution</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllMt_res as $mt_res)
                        <tr>
                            <td>{{$mt_res->id}}</td>
                            <td>{{$mt_res->mnt_resolution}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editMt_Res',['id'=>$mt_res->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delMt_Res',['id'=>$mt_res->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllMb->links()}}
            </div>
            <div class="tab-pane fade" id="monitor_resolution_time" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                Monitor Response Time
                @include('layouts.properties.master3')
                <input type="text" name="q-mt-res-time" placeholder="Search by Resolution Time" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Response Time</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllMt_response as $mt_time)
                        <tr>
                            <td>{{$mt_time->id}}</td>
                            <td>{{$mt_time->mnt_response_time}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editMt_time',['id'=>$mt_time->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delMt_time',['id'=>$mt_time->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllMb->links()}}
            </div>
            <div class="tab-pane fade" id="monitor_size" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                Monitor Screen Size
                @include('layouts.properties.master3')
                <input type="text" name="q-mt-size" placeholder="Search by Size" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Screen Size</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllMt_size as $mt_size)
                        <tr>
                            <td>{{$mt_size->id}}</td>
                            <td>{{$mt_size->mnt_screen_size}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editMt_size',['id'=>$mt_size->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delMt_size',['id'=>$mt_size->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllMb->links()}}
            </div>
            <div class="tab-pane fade" id="psuType" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                PSU Type
                @include('layouts.properties.master3')
                <input type="text" name="q-psu-type" placeholder="Search by Type" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>PSU Type</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllPsuType as $psu_type)
                        <tr>
                            <td>{{$psu_type->id}}</td>
                            <td>{{$psu_type->psu_ee}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editPsu_type',['id'=>$psu_type->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delPsu_type',['id'=>$psu_type->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllPsuType->links()}}
            </div>
            <div class="tab-pane fade" id="psuPower" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                PSU Power
                @include('layouts.properties.master3')
                <input type="text" name="q-psu-pw" placeholder="Search box" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Power</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllPsuPw as $psu_pw)
                        <tr>
                            <td>{{$psu_pw->id}}</td>
                            <td>{{$psu_pw->psu_power}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editPsu_pw',['id'=>$psu_pw->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delPsu_pw',['id'=>$psu_pw->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllPsuPw->links()}}
            </div>
            <div class="tab-pane fade" id="ramCapacity" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                Ram Capacity
                @include('layouts.properties.master3')
                <input type="text" name="q-ram-ca" placeholder="Search ram capacity" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Capacity</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllCapacity as $ram_ca)
                        <tr>
                            <td>{{$ram_ca->id}}</td>
                            <td>{{$ram_ca->ram_capacity}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editRam_ca',['id'=>$ram_ca->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delRam_ca',['id'=>$ram_ca->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllCapacity->links()}}
            </div>
            <div class="tab-pane fade" id="ramType" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                Ram Speed
                @include('layouts.properties.master3')
                <input type="text" name="q-ram-sp" placeholder="Search box" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Speed</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllSpeed as $speed)
                        <tr>
                            <td>{{$speed->id}}</td>
                            <td>{{$speed->ram_speed}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editRam_sp',['id'=>$speed->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delRam_sp',['id'=>$speed->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllSpeed->links()}}
            </div>
            <div class="tab-pane fade" id="ssdFactor" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                SSD Form Factor
                @include('layouts.properties.master3')
                <input type="text" name="q-ssd-ft" placeholder="Search box" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Factor</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllFormFactor as $factor)
                        <tr>
                            <td>{{$factor->id}}</td>
                            <td>{{$factor->ssd_form_factor}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editSSD_ff',['id'=>$factor->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delSSD_ff',['id'=>$factor->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllFormFactor->links()}}
            </div>
            <div class="tab-pane fade" id="ssdInterface" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                SSD Interface
                @include('layouts.properties.master3')
                <input type="text" name="q-ssd-if" placeholder="Search box" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Interface</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllInterface as $interface)
                        <tr>
                            <td>{{$interface->id}}</td>
                            <td>{{$interface->ssd_interface}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editSSD_interface',['id'=>$interface->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delSSD_interface',['id'=>$interface->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllInterface->links()}}
            </div>
            <div class="tab-pane fade" id="vgaGpu" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                Vga GPU
                @include('layouts.properties.master3')
                <input type="text" name="q-vga-gpu" placeholder="Search GPU" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Vga GPU</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllGpu as $gpu)
                        <tr>
                            <td>{{$gpu->id}}</td>
                            <td>{{$gpu->vga_gpu}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editVGA_gpu',['id'=>$gpu->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delVGA_gpu',['id'=>$gpu->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllGpu->links()}}
            </div>
            <div class="tab-pane fade" id="vgaMem" role="tabpanel" aria-labelledby="mt_rr-tab">
                @include('layouts.properties.master2')
                Vga Memory Size
                @include('layouts.properties.master3')
                <input type="text" name="q-vga-mem" placeholder="Search memory" class="form-control">
                @include('layouts.properties.master4')
                <table class="table table-hover table-valign-middle text-center">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Memory</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($AllMem as $mem)
                        <tr>
                            <td>{{$mem->id}}</td>
                            <td>{{$mem->vga_mem_size}}</td>
                            <td>
                                <a href="{{action('PropertiesController@editVGA_mem',['id'=>$mem->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                                <a href="{{action('PropertiesController@delVGA_mem',['id'=>$mem->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('layouts.properties.master5')
                {{$AllMem->links()}}
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