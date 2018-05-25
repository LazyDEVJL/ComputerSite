<!doctype html>
<html lang="en">
  <head>
    <title>Quản lý cửa hàng máy tính</title>
    <base href="http://localhost/PHP/Advanced PHP/ComputerSite/">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!--Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <!-- Date  Picker -->
    <link rel="stylesheet" href="resources\assets\bower_components\datetimepicker\css\daterangepicker.css">
  </head>
  <body>
    <h3 class="text-center mt-5">Thêm mới danh mục</h3> <hr>
    <p class="text-center">
        <a href="<?=action('ProductController@index')?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Trở lại danh sách danh mục</a>
    </p>
    <div class=row>
        <form action="<?=action('ProductController@createSave')?>" method="post" enctype="multipart/form-data" class="w-50 col-lg-6 offset-lg-3">
        {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-lg-6">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" name="txt_name" id="product_name">
                </div>
                <div class="form-group col-lg-3">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="txt_price" id="price">
                </div>
                <div class="form-group col-lg-3">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="txt_quantity" id="quantity">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-2">
                    <label for="discount">Discount (100%)</label>
                    <input type="number" class="form-control" name="txt_discount" id="discount">
                </div>
                <div class="form-group col-lg-4">
                    <label for="discount_range">Discount Range</label>
                    <input type="text" name="discount_range" class="form-control" id="discount_range">
                </div>
                <div class="form-group col-lg-6">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" name="txt_slug" id="slug">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-3">
                    <label for="categories">Main Categories</label>
                    <select multiple class="form-control" name="sl_manufacture_id" id="categories">
                        <?php foreach($categories as $category) :?>
                        <option value="<?=$category->id?>">
                            <?= $category->name?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="subcategories">Sub Categories</label>
                    <select multiple class="form-control" name="sl_manufacture_id" id="subcategories">
                        <?php foreach($subCategories as $subCategory) :?>
                        <option value="<?=$subCategory->id?>">
                            <?=$subCategory->name?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="form-group col-lg-12 mb-1">
                            <label for="manufactures">Manufacture</label>
                            <select class="form-control" name="sl_manufacture_id" id="manufactures">
                                <?php foreach($manufactures as $manufacture) :?>
                                <option value="<?=$manufacture->id?>">
                                    <?=$manufacture->name?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="product_image">Image</label>
                            <input type="file" name="product_image" id="product_image">
                        </div>
                        <div class="form-group col-lg-6 text-right">
                            Show: <input type="radio" value="1" name="rd_active">
                            Hide: <input type="radio" value="0" name="rd_active">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-12 accordion" id="product_properties">
                    <!-- Mainboard Properties-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#mbCollapse" aria-expanded="true" aria-controls="mbCollapse">
                            Mainboard Properties
                            </button>
                        </h5>
                        </div>
                    
                        <div id="mbCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#product_properties">
                            <div class="card-body">
                                <select class="form-control mb-2" name="sl_mbchipset_id">
                                    <option value="">-- Choose type of chipset</option>
                                    <?php foreach($mbchipsets as $mbchipset) :?>
                                        <option value="<?=$mbchipset->id?>">
                                        <?= $mbchipset->mb_chipset?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control mb-2" name="sl_mbsize_id">
                                    <option value="">-- Choose mainboard size</option>
                                    <?php foreach($mbsizes as $mbsize) :?>
                                        <option value="<?=$mbsize->id?>">
                                        <?= $mbsize->mb_size?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control" name="sl_mb_socket_id">
                                    <option value="">-- Choose socket type</option>
                                    <?php foreach($sockets as $socket) :?>
                                        <option value="<?=$socket->id?>">
                                        <?= $socket->socket_type?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- CPU Properties-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#cpuCollapse" aria-expanded="true" aria-controls="cpuCollapse">
                            CPU Properties
                            </button>
                        </h5>
                        </div>
                    
                        <div id="cpuCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#product_properties">
                            <div class="card-body">
                                <select class="form-control mb-2" name="sl_cpuserie_id">
                                    <option value="">-- Choose CPU serie</option>
                                    <?php foreach($cpuseries as $cpuserie) :?>
                                        <option value="<?=$cpuserie->id?>">
                                        <?= $cpuserie->cpuserie?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control" name="sl_cpu_socket_id">
                                    <option value="">-- Choose socket type</option>
                                    <?php foreach($sockets as $socket) :?>
                                        <option value="<?=$socket->id?>">
                                        <?= $socket->socket_type?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- RAM Properties-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#ramCollapse" aria-expanded="true" aria-controls="ramCollapse">
                            RAM Properties
                            </button>
                        </h5>
                        </div>
                    
                        <div id="ramCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#product_properties">
                            <div class="card-body">
                                <select class="form-control mb-2" name="sl_ramcapacity_id">
                                    <option value="">-- Choose RAM capacity</option>
                                    <?php foreach($ramcapacities as $ramcapacity) :?>
                                        <option value="<?=$ramcapacity->id?>">
                                        <?= $ramcapacity->ram_capacity?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control mb-2" name="sl_ramspeed_id">
                                    <option value="">-- Choose RAM speed</option>
                                    <?php foreach($ramspeeds as $ramspeed) :?>
                                        <option value="<?=$ramspeed->id?>">
                                        <?= $ramspeed->ram_speed?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control" name="sl_ramtype_id">
                                    <option value="">-- Choose RAM type</option>
                                    <?php foreach($ramtypes as $ramtype) :?>
                                        <option value="<?=$ramtype->id?>">
                                        <?= $ramtype->ram_type?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- HDD Properties-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#hddCollapse" aria-expanded="true" aria-controls="hddCollapse">
                            HDD Properties
                            </button>
                        </h5>
                        </div>
                    
                        <div id="hddCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#product_properties">
                            <div class="card-body">
                                <select class="form-control" name="sl_HDDdrivercapacity_id">
                                    <option value="">-- Choose HDD driver capacity</option>
                                    <?php foreach($HDDcapacities as $HDDcapacity) :?>
                                    <option value="<?=$HDDcapacity->id?>">
                                    <?= $HDDcapacity->drive_capacity?>
                                    </option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- SSD Properties-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#ssdCollapse" aria-expanded="true" aria-controls="ssdCollapse">
                            SSD Properties
                            </button>
                        </h5>
                        </div>
                    
                        <div id="ssdCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#product_properties">
                            <div class="card-body">
                                <select class="form-control mb-2" name="sl_SSDdrivercapacity_id">
                                    <option value="">-- Choose SSD driver capacity</option>
                                    <?php foreach($SSDcapacities as $SSDcapacity) :?>
                                        <option value="<?=$SSDcapacity->id?>">
                                        <?= $SSDcapacity->drive_capacity?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control mb-2" name="sl_SSDformfactor_id">
                                    <option value="">-- Choose SSD form factor</option>
                                    <?php foreach($SSDformfactors as $SSDformfactor) :?>
                                        <option value="<?=$SSDformfactor->id?>">
                                        <?= $SSDformfactor->ssd_form_factor?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control" name="sl_SSDinterface_id">
                                    <option value="">-- Choose SSD interface</option>
                                    <?php foreach($SSDinterfaces as $SSDinterface) :?>
                                        <option value="<?=$SSDinterface->id?>">
                                        <?= $SSDinterface->ssd_interface?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- VGA Properties-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#vgaCollapse" aria-expanded="true" aria-controls="vgaCollapse">
                            VGA Properties
                            </button>
                        </h5>
                        </div>
                    
                        <div id="vgaCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#product_properties">
                            <div class="card-body">
                                <select class="form-control mb-2" name="sl_vgagpu_id">
                                    <option value="">-- Choose VGA GPU</option>
                                    <?php foreach($vgagpus as $vgagpu) :?>
                                        <option value="<?=$vgagpu->id?>">
                                        <?= $vgagpu->vga_gpu?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control" name="sl_vgamemsize_id">
                                    <option value="">-- Choose VGA memory size</option>
                                    <?php foreach($vgamemsizes as $vgamemsize) :?>
                                        <option value="<?=$vgamemsize->id?>">
                                        <?= $vgamemsize->vga_mem_size?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Case Properties-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#caseCollapse" aria-expanded="true" aria-controls="caseCollapse">
                            Case Properties
                            </button>
                        </h5>
                        </div>
                    
                        <div id="caseCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#product_properties">
                            <div class="card-body">
                                <select class="form-control" name="sl_casetype_id">
                                    <option value="">-- Choose Case type</option>
                                    <?php foreach($casetypes as $casetype) :?>
                                        <option value="<?=$casetype->id?>">
                                        <?= $casetype->case_type?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- PSU Properties-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#psuCollapse" aria-expanded="true" aria-controls="psuCollapse">
                            PSU Properties
                            </button>
                        </h5>
                        </div>
                    
                        <div id="psuCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#product_properties">
                            <div class="card-body">
                                <select class="form-control mb-2" name="sl_psuee_id">
                                    <option value="">-- Choose PSU energy efficient</option>
                                    <?php foreach($psuees as $psuee) :?>
                                        <option value="<?=$psuee->id?>">
                                        <?= $psuee->psu_ee?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control" name="sl_psupower_id">
                                    <option value="">-- Choose PSU power</option>
                                    <?php foreach($psupowers as $psupower) :?>
                                        <option value="<?=$psupower->id?>">
                                        <?= $psupower->psu_power?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Monitor Properties-->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#mntCollapse" aria-expanded="true" aria-controls="mntCollapse">
                            Monitor Properties
                            </button>
                        </h5>
                        </div>
                    
                        <div id="mntCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#product_properties">
                            <div class="card-body">
                                <select class="form-control mb-2" name="sl_mnt_refreshrate_id">
                                    <option value="">-- Choose Monitor refresh rate</option>
                                    <?php foreach($mntrefreshrates as $mntrefreshrate) :?>
                                        <option value="<?=$mntrefreshrate->id?>">
                                        <?= $mntrefreshrate->mnt_refresh_rate?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control mb-2" name="sl_mnt_response_time_id">
                                    <option value="">-- Choose Monitor response time</option>
                                    <?php foreach($mntresponsetimes as $mntresponsetime) :?>
                                        <option value="<?=$mntresponsetime->id?>">
                                        <?= $mntresponsetime->mnt_response_time?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control mb-2" name="sl_mnt_resolution_id">
                                    <option value="">-- Choose Monitor resolution</option>
                                    <?php foreach($mntresolutions as $mntresolution) :?>
                                        <option value="<?=$mntresolution->id?>">
                                        <?= $mntresolution->mnt_resolution?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control mb-2" name="sl_mnt_screensize_id">
                                    <option value="">-- Choose Monitor screen size</option>
                                    <?php foreach($mntscreensizes as $mntscreensize) :?>
                                        <option value="<?=$mntscreensize->id?>">
                                        <?= $mntscreensize->mnt_screen_size?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control" name="sl_mnt_type_id">
                                    <option value="">-- Choose Monitor type</option>
                                    <?php foreach($mnttypes as $mnttype) :?>
                                        <option value="<?=$mnttype->id?>">
                                        <?= $mnttype->mnt_type == 1 ? 'Curve' : 'Flat'?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row text-center">
                <div class="col-lg-8">
                    <input type="submit" value="Add" class="btn btn-primary w-100">
                </div>
                <div class="col-lg-4">
                    <input type="reset" value="Reset" class="btn btn-secondary w-100">
                </div>
            </div>
        </form>
    </div>
    
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="resources/assets/bower_components/datetimepicker/js/moment.min.js"></script>
    <script src="resources/assets/bower_components/datetimepicker/js/daterangepicker.js"></script>
    <script src="resources/assets/dist/js/script.js"></script>
  </body>
</html>