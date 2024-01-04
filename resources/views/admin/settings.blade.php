@extends('admin.layouts.app')
@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="settings"></i></div>
                            Settings
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card" >
            <div class="card-header border">
                <ul class="nav nav-tabs card-header-tabs " id="dashboardNav" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="services-tab" data-toggle="tab" href="#general" role="tab"
                           aria-controls="general" aria-selected="false">General</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="taxes-tab" data-toggle="tab" href="#taxes" role="tab"
                           aria-controls="taxes" aria-selected="false">Taxes</a>
                    </li>
                    <li class="nav-item mr-1" role="presentation" >
                        <a class="nav-link" id="users-tab" data-toggle="tab" href="#settingLinks" role="tab"
                           aria-controls="settingLinks" aria-selected="true">Social</a>
                    </li>
                </ul>
            </div>
            <div class="card m-3 p-1 ">

                <div class="tab-content">
                    <div id="general" class="tab-pane active p-3">
                        <div class="form-row col-12 ">
                            <form id="save-form" class="p-3 col-12" method="post">
                                @csrf
                                <div class="form-row ">
                                    <div class="form-group col-md-7">
                                        <label class="small mb-1" for="phone">Phone</label>
                                        <input class="form-control" id="phone" type="text" name="phone" placeholder="Phone" value="{{ isset($general->phone) ? $general->phone : '' }}"/>
                                    </div>
                                    <div class="form-group col-md-7">
                                        <label class="small mb-1" for="email">Email</label>
                                        <input class="form-control" id="email" type="text" name="email" placeholder="Email" value="{{ isset($general->email) ? $general->email : '' }}"/>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="saveGeneral()" id="saveGeneralBtn" class="btn btn-success float-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div id="Images" class="tab-pane p-3">
                        <div class="form-row col-12 ">
                        </div>
                    </div> -->
                    <div id="taxes" class="tab-pane   p-3">
                        <form id="save-taxes-form" class="p-3" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="sales_tax">Sales tax</label>
                                    <input class="form-control" id="sales_tax" type="text" name="sales_tax"
                                           placeholder="sales tax" value="{{ isset($taxes->sales_tax) ? $taxes->sales_tax : '' }}"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="excise_tax">Excise tax</label>
                                    <input class="form-control" id="excise_tax" type="text" name="excise_tax"
                                           placeholder="excise tax" value="{{ isset($taxes->excise_tax) ? $taxes->excise_tax : '' }}"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="delivery_fee">Delivery fee</label>
                                    <input class="form-control" id="delivery_fee" type="text" name="delivery_fee"
                                           placeholder="delivery fee" value="{{ isset($taxes->delivery_fee) ? $taxes->delivery_fee : '' }}"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="minimum_order">Minimum order</label>
                                    <input class="form-control" id="minimum_order" type="text" name="minimum_order"
                                           placeholder="minimum order" value="{{ isset($taxes->minimum_order) ? $taxes->minimum_order : '' }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="saveTaxes()" id="saveTaxesBtn" class="btn btn-success float-right">Save</button>
                            </div>
                        </form>
                    </div>
                    <div id="settingLinks" class="tab-pane   p-3">
                        <form id="save-item-form" class="p-3" method="post">
                            @csrf
                            <div class="form-row ">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="facebook">Facebook</label>
                                    <input class="form-control" id="facebook" type="text" name="facebook"
                                           placeholder="Facebook" value="{{ isset($data->facebook) ? $data->facebook : '' }}"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="twitter">Twitter</label>
                                    <input class="form-control" id="twitter" type="text" name="twitter"
                                           placeholder="Twitter" value="{{ isset($data->twitter) ? $data->twitter : '' }}"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="instagram">Instagram</label>
                                    <input class="form-control" id="instagram" type="text" name="instagram"
                                           placeholder="Facebook" value="{{ isset($data->instagram) ? $data->instagram : '' }}"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="pinterest">Pinterest</label>
                                    <input class="form-control" id="pinterest" type="text" name="pinterest"
                                           placeholder="Pinterest" value="{{ isset($data->pinterest) ? $data->pinterest : '' }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="save()" id="saveSocialBtn" class="btn btn-success float-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script>

    function saveGeneral(){
        Loading.add($('#saveGeneralBtn'));
        let data = $('#save-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('updateSettingsGeneral') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
                }
                if (response.status == 1) {
                    toastr['success']('Saved.', 'Success');
                }
                Loading.remove($('#saveGeneralBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveGeneralBtn'));
            }
        });
    }
    function saveTaxes(){
        Loading.add($('#saveTaxesBtn'));
        let data = $('#save-taxes-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('updateSettingsTax') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.errors, 'Error');
                }
                if (response.status == 1) {
                    toastr['success']('Saved.', 'Success');
                }
                Loading.remove($('#saveTaxesBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveTaxesBtn'));
            }
        });
    }
    function save() {
        Loading.add($('#saveItemBtn'));
        var data = $('#save-item-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('updateSettings') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
                }
                if (response.status == 1) {
                    toastr['success']('Saved.', 'Success');
                }
                Loading.remove($('#saveItemBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveGeneralBtn'));
            }
        });
    }
</script>
@endsection

