@extends('layouts.dashboard')
@section('css')
    <link href="{{url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />
    @endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{__('Outstanding Customers Invoices')}}
                    </h3>
                </div>
            </div>
        </div>
            <?php $toolTipsData = $toolTipsData->pluck('data','field')->toArray() ?>

            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" method="POST" action={{(request()->is('*/edit'))  ? route('uploadSupplierInvoice.update',[$company,$uploadSupplierInvoice]): route('uploadSupplierInvoice.store',[$company] )}}   enctype="multipart/form-data">
                @csrf
                {{(request()->is('*/edit'))  ?  method_field('PUT'): ""}}
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                {{__('Inventory Statements')}}
                            </h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <input type="hidden" name="company_id" value="{{$company->id}}">
                            <div class="col-md-6">
                                <label>{{__('Customer Name')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="text" name="customer_name" value="{{$uploadSupplierInvoice->customer_name}}" class="form-control" placeholder="{{__('Customer Name')}}">
                                    <x-tool-tip title=" {{($toolTipsData['customer_name'][lang()] ?? '-')}}"/>
                                </div>

                            </div>
                          
                        </div>
                    </div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                {{__('Invoice Information')}}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label>{{__('Invoice Number')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="text" name="invoice_number" value="{{$salesGathering->invoice_number}}" class="form-control" placeholder="{{__('Invoice Number')}}">
                                    <x-tool-tip title="{{($toolTipsData['invoice_number'][lang()] ?? '-')}}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('Invoice Date')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="date" name="invoice_date" value="{{$salesGathering->invoice_date}}" class="form-control"  placeholder="Select date" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('Due Within')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="number" step="any" name="due_within" value="{{$salesGathering->due_within}}"  min="0" class="form-control" placeholder="{{__('Due Within')}}">
                                    <x-tool-tip title="{{($toolTipsData['due_within'][lang()] ?? '-')}}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('Due Date')}} </label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="date" name="invoice_due_date" value="{{$salesGathering->invoice_due_date}}" class="form-control" placeholder="Select date" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label>{{__('Contract Code/Name')}}</label>
                                <div class="kt-input-icon">
                                    <input type="text" name="contract_code" value="{{$salesGathering->contract_code}}" class="form-control" placeholder="{{__('Contract Code/Name')}}">
                                    <x-tool-tip title="{{($toolTipsData['contract_code'][lang()] ?? '-')}}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('Contract Date')}}</label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="date" name="contract_date" value="{{$salesGathering->contract_date}}" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('Customer Purchase Order Number')}}</label>
                                <div class="kt-input-icon">
                                    <input type="number" step="any" name="purchase_order_number" value="{{$salesGathering->purchase_order_number}}" min="0" class="form-control" placeholder="{{__('Purchase Order Number')}}">
                                    <x-tool-tip title="{{($toolTipsData['purchase_order_number'][lang()] ?? '-')}}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('Purchase Order Date')}}</label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="date" name="purchase_order_date" value="{{$salesGathering->purchase_order_date}}" class="form-control"  placeholder="Select date" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label>{{__('Internal Sales Order Number')}}</label>
                                <div class="kt-input-icon">
                                    <input type="text" name="sales_order_number" value="{{$salesGathering->sales_order_number}}" class="form-control" placeholder="{{__('Internal Sales Order Number')}}">
                                    <x-tool-tip title="{{($toolTipsData['sales_order_number'][lang()] ?? '-')}}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('Internal Sales Order Date')}}</label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="date" name="sales_order_date" value="{{$salesGathering->sales_order_date}}" class="form-control"  placeholder="Select date" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('Sales Person Name')}}</label>
                                <div class="kt-input-icon">
                                    <input type="text" name="sales_person_name" value="{{$salesGathering->sales_person_name}}"  class="form-control" placeholder="{{__('Sales Person Name')}}">
                                    <x-tool-tip title="{{($toolTipsData['sales_person_name'][lang()] ?? '-')}}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('Sales Commission Rate %')}}</label>
                                <div class="kt-input-icon">
                                    <input type="number" step="any" name="sales_person_rate" value="{{$salesGathering->sales_person_rate}}" min="0" class="form-control" placeholder="{{__('Sales Commission Rate %')}}">
                                    <x-tool-tip title="{{($toolTipsData['sales_person_rate'][lang()] ?? '-')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

           
                <x-submitting/>

            </form>

            <!--end::Form-->

        <!--end::Portlet-->
    </div>
</div>
@endsection
@section('js')
    <!--begin::Page Scripts(used by this page) -->
    <script src="{{url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/jquery.repeater/src/lib.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/jquery.repeater/src/jquery.input.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/jquery.repeater/src/repeater.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')}}" type="text/javascript"></script>
    <script>
        $('.deduction_amounts').on('change', function () {
            var total_deductions = deductionAmountTotal();

            $('#total_deduction').val(total_deductions);
        });
        $('.deduction_amounts,#vat_amount,#advance_payment_amount,#invoice_amount').on('change', function () {
            var total_deductions = deductionAmountTotal();
            var invoice_amount =0;
            if ($('#invoice_amount').val() != '') {
                invoice_amount =  parseFloat($('#invoice_amount').val());
            }
            var advance_payment_amount =0;
            if ($('#advance_payment_amount').val() != '') {
                advance_payment_amount =  parseFloat($('#advance_payment_amount').val());
            }
            var vat_amount =0;
            if ($('#vat_amount').val() != '') {
                vat_amount =  parseFloat($('#vat_amount').val());
            }
            invoice_net_amount = (invoice_amount+vat_amount)-total_deductions-advance_payment_amount;
            $('#invoice_net_amount').val(invoice_net_amount);
        });
        function deductionAmountTotal () {
            var total_deductions = 0;
            $('.deduction_amounts').each(function (index, element) {
                var value = element.value;
                if (value != '') { total_deductions +=  parseFloat(value);}
            });
            return total_deductions;
        }
    </script>
    <!--end::Page Scripts -->
@endsection
