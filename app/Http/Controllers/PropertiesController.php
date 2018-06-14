<?php

   namespace App\Http\Controllers;

   use Illuminate\Http\Request;
   use App\Category;
   use App\Product;
   use App\Manufacture;
   use App\ProductProperty;
   use App\ProductCategory;
   use App\CaseType;
   use App\CPUSerie;
   use App\DriverCapacity;
   use App\MbChipset;
   use App\MbSize;
   use App\MntRefreshRate;
   use App\MntResolution;
   use App\MntResponseTime;
   use App\MntScreenSize;
   use App\MntType;
   use App\PSUEE;
   use App\PSUPower;
   use App\RamCapacity;
   use App\RamSpeed;
   use App\RamType;
   use App\Socket;
   use App\SSDFormFactor;
   use App\SSDInterface;
   use App\VGAGPU;
   use App\VGAMemSize;
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\Input;
   use Illuminate\Support\Facades\Session;
   use Illuminate\Support\Facades\Validator;

   class PropertiesController extends Controller
   {
      public function index()
      {
         $mainCategories = DB::table('tbl_categories')
            ->where('parent_id', '=', 0)
            ->orderBy('name', 'asc')
            ->get();

         $case_key = Input::get('q-case');
         $case = getProperties($case_key, 'tbl_case_types', 'case_type');

         $cpu_key = Input::get('q-cpu');
         $cpu = getProperties($cpu_key, 'tbl_cpu_series', 'cpuserie');

         $hdd_key = Input::get('q-hdd');
         $hdd = getPropertiesWithOr($hdd_key, 'tbl_drive_capacities', 'drive_capacity', 'driver_type');

         $mb_key = Input::get('q-mb');
         $mb = getPropertiesWithOr($mb_key, 'tbl_mb_chipsets', 'mb_chipset', 'chipset_manufactur');

         $mb_size_key = Input::get('q-mb-size');
         $mb_size = getProperties($mb_size_key, 'tbl_mb_sizes', 'mb_size');

         $mt_rr_key = Input::get('q-mt-rr');
         $mt_refresh = getProperties($mt_rr_key, 'tbl_mnt_refresh_rates', 'mnt_refresh_rate');

         $mt_res_key = Input::get('q-mt-res');
         $mt_resolution = getProperties($mt_res_key, 'tbl_mnt_resolutions', 'mnt_resolution');

         $mt_res_time_key = Input::get('q-mt-res-time');
         $mt_response = getProperties($mt_res_time_key, 'tbl_mnt_response_times', 'mnt_response_time');

         $mt_size_key = Input::get('q-mt-size');
         $mt_size = getProperties($mt_size_key, 'tbl_mnt_screen_sizes', 'mnt_screen_size');

         $psu_ee_key = Input::get('q-psu-ee');
         $psu_ee = getProperties($psu_ee_key, 'tbl_psu_ees', 'psu_ee');

         $psu_pw_key = Input::get('q-psu-pw');
         $psu_pw = getProperties($psu_pw_key, 'tbl_psu_powers', 'psu_power');

         $ram_ca_key = Input::get('q-ram-ca');
         $ramCapacity = getProperties($ram_ca_key, 'tbl_ram_capacities', 'ram_capacity');

         $ram_speed = Input::get('q-ram-sp');
         $ramSpeed = getProperties($ram_speed, 'tbl_ram_speeds', 'ram_speed');

         $ssdFactor_key = Input::get('q-ssd-ft');
         $ssdFactor = getProperties($ssdFactor_key, 'tbl_ssd_form_factors', 'ssd_form_factor');

         $interface_key = Input::get('q-ssd-if');
         $ssdInterface = getProperties($interface_key, 'tbl_ssd_interfaces', 'ssd_interface');

         $gpu_key = Input::get('q-vga-gpu');
         $vgaGPU = getProperties($gpu_key, 'tbl_vga_gpus', 'vga_gpu');

         $vga_mem_key = Input::get('q-vga-mem');
         $vgaMem = getProperties($vga_mem_key, 'tbl_vga_mem_sizes', 'vga_mem_size');

         return view('admin/properties/index', [
            'AllCase' => $case,
            'AllCpu' => $cpu,
            'AllCategories' => $mainCategories,
            'AllHdd' => $hdd,
            'AllMb' => $mb,
            'AllMb_size' => $mb_size,
            'AllMnt_RR' => $mt_refresh,
            'AllMt_res' => $mt_resolution,
            'AllMt_response' => $mt_response,
            'AllMt_size' => $mt_size,
            'AllPsuEE' => $psu_ee,
            'AllPsuPw' => $psu_pw,
            'AllCapacity' => $ramCapacity,
            'AllSpeed' => $ramSpeed,
            'AllFormFactor' => $ssdFactor,
            'AllInterface' => $ssdInterface,
            'AllGpu' => $vgaGPU,
            'AllMem' => $vgaMem
         ]);
      }

      public function create()
      {
         $mainCategories = DB::table('tbl_categories')
            ->where('parent_id', '=', 0)
            ->orderBy('name', 'asc')
            ->get();
         return view('admin/properties/create', ['AllCategories' => $mainCategories]);
      }

      public function saveCase(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_case_type', 'Case type');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $caseType = $rq->txt_case_type;
            $caseModel = new CaseType();
            $caseModel->case_type = $caseType;
            $check = $caseModel->save();
            if ($check) {
               Session::flash('success', 'Successfully created');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to Create');
               return redirect('/admin/properties');
            }
         }
      }

      public function delCase($id)
      {
         $delCase = CaseType::find($id);
         $check = $delCase->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function editCase($id)
      {
         $editCase = CaseType::find($id);
         return view('admin/properties/editCase', [
            'CurrentCase' => $editCase
         ]);
      }

      public function editSaveCase(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_case_type', 'Case type');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->case_id;
            $caseType = $rq->txt_case_type;
            $caseModel = CaseType::find($id);
            $caseModel->case_type = $caseType;
            $check = $caseModel->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function saveCpu(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_cpu_type', 'Cpu type');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $cpuName = $rq->txt_cpu_type;
            $cpuManu = $rq->sl_cpu_manu;
            $cpuModel = new CPUSerie();
            $cpuModel->cpuserie = $cpuName;
            $cpuModel->cpu_manufacture = $cpuManu;
            $check = $cpuModel->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Model');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editCpu($id)
      {
         $cpuModel = CPUSerie::find($id);
         return view('admin/properties/editCpu', [
            'CurrentCpu' => $cpuModel
         ]);
      }

      public function editSaveCpu(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_cpu_type', 'Cpu type');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->cpu_id;
            $cpuName = $rq->txt_cpu_type;
            $cpuManu = $rq->sl_cpu_manu;
            $cpuModel = CPUSerie::find($id);
            $cpuModel->cpuserie = $cpuName;
            $cpuModel->cpu_manufacture = $cpuManu;
            $check = $cpuModel->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }
      }

      public function delCpu($id)
      {
         $cpuModel = CPUSerie::find($id);
         $check = $cpuModel->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function saveHDD(Request $rq)
      {
         $validator = PropertiesMultipleRules($rq, 'txt_driver', 'sl_drive_type', 'Driver Capacity', 'Driver Type');
         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $DriveCap = $rq->txt_driver;
            $DriveType = $rq->sl_drive_type;
            $Drive = new DriverCapacity();
            $Drive->drive_capacity = $DriveCap;
            $Drive->driver_type = $DriveType;
            $check = $Drive->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Capacity');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editHdd($id)
      {
         $Drive = DriverCapacity::find($id);
         return view('admin/properties/editHdd', [
            'CurrentDrive' => $Drive
         ]);
      }

      public function editSaveHDD(Request $rq)
      {
         $validator = PropertiesMultipleRules($rq, 'txt_driver', 'sl_drive_type', 'Driver Capacity', 'Driver Type');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->drive_id;
            $DriveCap = $rq->txt_driver;
            $DriveType = $rq->sl_drive_type;
            $Drive = DriverCapacity::find($id);
            $Drive->drive_capacity = $DriveCap;
            $Drive->driver_type = $DriveType;
            $check = $Drive->save();
            if ($check) {
               Session::flash('success', 'Successfully Editied');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }
      }

      public function delHdd($id)
      {
         $Drive = DriverCapacity::find($id);
         $check = $Drive->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function saveMb(Request $rq)
      {
         $validator = PropertiesMultipleRules($rq, 'txt_mb_chipset', 'sl_mb_manu', 'Mainboard chipset', 'Mainboard manufacture');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $chipset = $rq->txt_mb_chipset;
            $mb_manufacture = $rq->sl_mb_manu;
            $mb_chipsets = new MbChipset();
            $mb_chipsets->mb_chipset = $chipset;
            $mb_chipsets->chipset_manufacture = $mb_manufacture;
            $check = $mb_chipsets->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Chipset');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editMb($id)
      {
         $mb_chipsets = MbChipset::find($id);
         return view('admin/properties/editMb', [
            'CurrentChipset' => $mb_chipsets
         ]);
      }

      public function editSaveMb(Request $rq)
      {
         $validator = PropertiesMultipleRules($rq, 'txt_mb_chipset', 'sl_mb_manu', 'Mainboard chipset', 'Mainboard manufacture');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->chipset_id;
            $chipset = $rq->txt_mb_chipset;
            $mbManu = $rq->sl_mb_manu;
            $mb_chipsets = MbChipset::find($id);
            $mb_chipsets->mb_chipset = $chipset;
            $mb_chipsets->chipset_manufacture = $mbManu;
            $check = $mb_chipsets->save();
            if ($check) {
               Session::flash('success', 'Successfully Editied');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }
      }

      public function delMb($id)
      {
         $mb_chipsets = MbChipset::find($id);
         $check = $mb_chipsets->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function saveMb_size(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mb_size', 'Mainboard Size');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $mbSize = $rq->txt_mb_size;
            $mainSize = new MbSize();
            $mainSize->mb_size = $mbSize;
            $check = $mainSize->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Mainboard Size');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editMb_size($id)
      {
         $mb_size = MbSize::find($id);
         return view('admin/properties/editMb_size', [
            'CurrentSize' => $mb_size
         ]);
      }

      public function editSaveMb_size(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mb_size', 'Mainboard Size');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->size_id;
            $mbSize = $rq->txt_mb_size;
            $mainSize = MbSize::find($id);
            $mainSize->mb_size = $mbSize;
            $check = $mainSize->save();
            if ($check) {
               Session::flash('success', 'Successfully Editied');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }
      }

      public function delMb_size($id)
      {
         $mainSize = MbSize::find($id);
         $check = $mainSize->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function saveMt_RR(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mt_rr', 'Refresh Rate');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $mtRR = $rq->txt_mt_rr;
            $monitorRR = new MntRefreshRate();
            $monitorRR->mnt_refresh_rate = $mtRR;
            $check = $monitorRR->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Refresh Rate');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editMt_RR($id)
      {
         $mtRR = MntRefreshRate::find($id);
         return view('admin/properties/editMt_RR', ['CurrentMnt_RR' => $mtRR]);
      }

      public function editSaveMt_RR(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mt_rr', 'Refresh Rate');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->mt_rr_id;
            $mtRR = $rq->txt_mt_rr;
            $monitorRR = MntRefreshRate::find($id);
            $monitorRR->mnt_refresh_rate = $mtRR;
            $check = $monitorRR->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delMt_RR($id)
      {
         $monitorRR = MntRefreshRate::find($id);
         $check = $monitorRR->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function saveMt_Res(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mt_res', 'Resolution');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $mtRes = $rq->txt_mt_res;
            $monitorRes = new MntResolution();
            $monitorRes->mnt_resolution = $mtRes;
            $check = $monitorRes->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Resolution');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editMt_Res($id)
      {
         $mtRes = MntResolution::find($id);
         return view('admin/properties/editMt_res', ['CurrentMnt_Res' => $mtRes]);
      }

      public function editSaveMt_Res(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mt_res', 'Resolution');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->mt_res_id;
            $mtRes = $rq->txt_mt_res;
            $monitorRes = MntResolution::find($id);
            $monitorRes->mnt_resolution = $mtRes;
            $check = $monitorRes->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delMt_Res($id)
      {
         $monitorRes = MntResolution::find($id);
         $check = $monitorRes->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function saveMt_time(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mt_time', 'Response Time');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $mtTime = $rq->txt_mt_time;
            $monitorTime = new MntResponseTime();
            $monitorTime->mnt_response_time = $mtTime;
            $check = $monitorTime->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Response Time');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editMt_time($id)
      {
         $mtTime = MntResponseTime::find($id);
         return view('admin/properties/editMt_time', ['CurrentMnt_Time' => $mtTime]);
      }

      public function editSaveMt_time(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mt_time', 'Resolution');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->mt_time_id;
            $mtTime = $rq->txt_mt_time;
            $monitorTime = MntResponseTime::find($id);
            $monitorTime->mnt_response_time = $mtTime;
            $check = $monitorTime->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delMt_time($id)
      {
         $monitorTime = MntResponseTime::find($id);
         $check = $monitorTime->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function saveMt_size(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mt_size', 'Screen size');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $mtSize = $rq->txt_mt_size;
            $monitorSize = new MntScreenSize();
            $monitorSize->mnt_screen_size = $mtSize;
            $check = $monitorSize->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Screen Size');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editMt_size($id)
      {
         $mtSize = MntScreenSize::find($id);
         return view('admin/properties/editMt_size', ['CurrentMnt_Size' => $mtSize]);
      }

      public function editSaveMt_size(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_mt_size', 'Screen size');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->mt_size_id;
            $mtSize = $rq->txt_mt_size;
            $monitorSize = MntScreenSize::find($id);
            $monitorSize->mnt_screen_size = $mtSize;
            $check = $monitorSize->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delMt_size($id)
      {
         $monitorTime = MntScreenSize::find($id);
         $check = $monitorTime->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function savePSU_EE(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_psu_ee', 'Psu type');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $psuType = $rq->txt_psu_ee;
            $psuEE = new PSUEE();
            $psuEE->psu_ee = $psuType;
            $check = $psuEE->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Psu type');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editPSU_EE($id)
      {
         $psuType = PSUEE::find($id);
         return view('admin/properties/editPSU_EE', ['CurrentPSU_EE' => $psuType]);
      }

      public function editSavePSU_EE(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_psu_ee', 'Psu type');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->psu_ee_id;
            $psuEE = $rq->txt_psu_ee;
            $psuType = PSUEE::find($id);
            $psuType->psu_ee = $psuEE;
            $check = $psuType->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delPSU_EE($id)
      {
         $psuType = PSUEE::find($id);
         $check = $psuType->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      public function savePsu_pw(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_psu_pw', 'Psu power');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $psuPw = $rq->txt_psu_pw;
            $psuPW = new PSUPower();
            $psuPW->psu_power = $psuPw;
            $check = $psuPW->save();
            if ($check) {
               Session::flash('success', 'Successfully to insert new Psu power');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to insert');
               return redirect('/admin/properties');
            }
         }
      }

      public function editPsu_pw($id)
      {
         $psuPW = PSUPower::find($id);
         return view('admin/properties/editPsu_pw', ['CurrentPsu_pw' => $psuPW]);
      }

      public function editSavePsu_pw(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_psu_pw', 'Psu power');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->psu_pw_id;
            $PsuPw = $rq->txt_psu_pw;
            $psuPower = PSUPower::find($id);
            $psuPower->psu_power = $PsuPw;
            $check = $psuPower->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delPsu_pw($id)
      {
         $psuPower = PSUPower::find($id);
         $check = $psuPower->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

// ram Capacity
      public function saveRam_ca(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_ram_ca', 'Ram capacity');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $Ram_ca = $rq->txt_ram_ca;
            $ramCapacity = new RamCapacity();
            $ramCapacity->ram_capacity = $Ram_ca;
            $check = $ramCapacity->save();
            if ($check) {
               Session::flash('success', 'Successfully created');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to Create');
               return redirect('/admin/properties');
            }
         }
      }

      public function editRam_ca($id)
      {
         $Ram_ca = RamCapacity::find($id);
         return view('admin/properties/editRam_ca', ['CurrentRam_ca' => $Ram_ca]);
      }

      public function editSaveRam_ca(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_ram_ca', 'Ram capacity');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->ram_ca_id;
            $Ram_ca = $rq->txt_ram_ca;
            $ramCapacity = RamCapacity::find($id);
            $ramCapacity->ram_capacity = $Ram_ca;
            $check = $ramCapacity->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delRam_ca($id)
      {
         $ramCapacity = RamCapacity::find($id);
         $check = $ramCapacity->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

// ram Speed
      public function saveRam_sp(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_ram_sp', 'Ram speed');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $Ram_sp = $rq->txt_ram_sp;
            $ramSpeed = new RamSpeed();
            $ramSpeed->ram_speed = $Ram_sp;
            $check = $ramSpeed->save();
            if ($check) {
               Session::flash('success', 'Successfully created');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to Create');
               return redirect('/admin/properties');
            }
         }
      }

      public function editRam_sp($id)
      {
         $Ram_sp = RamSpeed::find($id);
         return view('admin/properties/editRam_sp', ['CurrentRam_sp' => $Ram_sp]);
      }

      public function editSaveRam_sp(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_ram_sp', 'Ram speed');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->ram_sp_id;
            $Ram_sp = $rq->txt_ram_sp;
            $ramSpeed = RamSpeed::find($id);
            $ramSpeed->ram_speed = $Ram_sp;
            $check = $ramSpeed->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delRam_sp($id)
      {
         $ramSpeed = RamSpeed::find($id);
         $check = $ramSpeed->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

// ssd interface
      public function saveSSD_interface(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_ssd_if', 'SSD Interface');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $ssdIF = $rq->txt_ssd_if;
            $ssdInterface = new SSDInterface();
            $ssdInterface->ssd_interface = $ssdIF;
            $check = $ssdInterface->save();
            if ($check) {
               Session::flash('success', 'Successfully created');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to Create');
               return redirect('/admin/properties');
            }
         }
      }

      public function editSSD_interface($id)
      {
         $ssdInterface = SSDInterface::find($id);
         return view('admin/properties/editSSD_interface', ['CurrentSSD_if' => $ssdInterface]);
      }

      public function editSaveSSD_interface(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_ssd_if', 'SSD Interface');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->ssd_if_id;
            $ssdIF = $rq->txt_ssd_if;
            $ssdInterface = SSDInterface::find($id);
            $ssdInterface->ssd_interface = $ssdIF;
            $check = $ssdInterface->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delSSD_interface($id)
      {
         $ssdInterface = SSDInterface::find($id);
         $check = $ssdInterface->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

// ssd form factor
      public function saveSSD_ff(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_ssd_ff', 'SSD Form factor');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $ssdFF = $rq->txt_ssd_ff;
            $ssdFormfactor = new SSDFormFactor();
            $ssdFormfactor->ssd_form_factor = $ssdFF;
            $check = $ssdFormfactor->save();
            if ($check) {
               Session::flash('success', 'Successfully created');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to Create');
               return redirect('/admin/properties');
            }
         }
      }

      public function editSSD_ff($id)
      {
         $ssdFormfactor = SSDFormFactor::find($id);
         return view('admin/properties/editSSD_formfactor', ['CurrentSSD_ff' => $ssdFormfactor]);
      }

      public function editSaveSSD_ff(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_ssd_ff', 'SSD Form factor');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->ssd_ff_id;
            $ssdFF = $rq->txt_ssd_ff;
            $ssdFormfactor = SSDFormFactor::find($id);
            $ssdFormfactor->ssd_form_factor = $ssdFF;
            $check = $ssdFormfactor->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delSSD_ff($id)
      {
         $ssdFormfactor = SSDFormFactor::find($id);
         $check = $ssdFormfactor->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      // vga GPU
      public function saveVGA_gpu(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_vga_gpu', 'GPU');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $gpu = $rq->txt_vga_gpu;
            $vgaGPU = new VGAGPU();
            $vgaGPU->vga_gpu = $gpu;
            $check = $vgaGPU->save();
            if ($check) {
               Session::flash('success', 'Successfully created');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to Create');
               return redirect('/admin/properties');
            }
         }
      }

      public function editVGA_gpu($id)
      {
         $vgaGPU = VGAGPU::find($id);
         return view('admin/properties/editVga_gpu', ['CurrentVGA_gpu' => $vgaGPU]);
      }

      public function editSaveVGA_gpu(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_vga_gpu', 'GPU');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->vga_gpu_id;
            $gpu = $rq->txt_vga_gpu;
            $vgaGPU = VGAGPU::find($id);
            $vgaGPU->vga_gpu = $gpu;
            $check = $vgaGPU->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delVGA_gpu($id)
      {
         $vgaGPU = VGAGPU::find($id);
         $check = $vgaGPU->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }

      // vga Mem
      public function saveVGA_mem(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_vga_mem', 'GPU Memory');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $mem = $rq->txt_vga_mem;
            $vgaMem = new VGAMemSize();
            $vgaMem->vga_mem_size = $mem;
            $check = $vgaMem->save();
            if ($check) {
               Session::flash('success', 'Successfully created');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to Create');
               return redirect('/admin/properties');
            }
         }
      }

      public function editVGA_mem($id)
      {
         $vgaMem = VGAMemSize::find($id);
         return view('admin/properties/editVga_mem', ['CurrentVGA_mem' => $vgaMem]);
      }

      public function editSaveVGA_mem(Request $rq)
      {
         $validator = PropertiesRules($rq, 'txt_vga_mem', 'GPU Memory');

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $id = $rq->vga_mem_id;
            $mem = $rq->txt_vga_mem;
            $vgaMem = VGAMemSize::find($id);
            $vgaMem->vga_mem_size = $mem;
            $check = $vgaMem->save();
            if ($check) {
               Session::flash('success', 'Successfully Edited');
               return redirect('/admin/properties');
            } else {
               Session::flash('error', 'Failed to edit');
               return redirect('/admin/properties');
            }
         }

      }

      public function delVGA_mem($id)
      {
         $vgaMem = VGAMemSize::find($id);
         $check = $vgaMem->delete();
         if ($check) {
            Session::flash('success', 'Successfully deleted');
            return redirect('/admin/properties');
         } else {
            Session::flash('error', 'Failed to delete');
            return redirect('/admin/properties');
         }
      }


   }
