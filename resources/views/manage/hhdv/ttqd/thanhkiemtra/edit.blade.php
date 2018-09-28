@extends('main')

@section('custom-style')
    <link type="text/css" rel="stylesheet" href="{{ url('vendors/bootstrap-datepicker/css/datepicker.css') }}">
@stop


@section('custom-script')
    <script type="text/javascript" src="{{url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
    <!--cript src="{{url('assets/admin/pages/scripts/form-validation.js')}}"></script-->
    @include('includes.crumbs.script_inputdate')

@stop

@section('content')


    <h3 class="page-title">
        Thông tư quyết định<small> chỉnh sửa</small>
    </h3>
    <!-- END PAGE HEADER-->

    <!-- BEGIN DASHBOARD STATS -->
    <div class="row center">
        <div class="col-md-12 center">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet box blue">
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::model($model, ['method' => 'PATCH', 'url'=>'thanhkiemtra-vegia/'. $model->id, 'class'=>'horizontal-form','id'=>'update_thanhkiemtra','files'=>true]) !!}
                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Ký hiệu văn bản<span class="require">*</span></label>
                                        {!!Form::text('khvb', null, array('id' => 'khvb','class' => 'form-control required','autofocus'))!!}
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Thời điểm</label>
                                        {!!Form::text('thoidiem',date('d/m/Y',  strtotime($model->thoidiem)), array('id' => 'thoidiem','data-inputmask'=>"'alias': 'date'",'class' => 'form-control required'))!!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Đoàn kiểm tra</label>
                                        <input type="text" class="form-control required" name="doankt" id="doankt" value="{{$model->doankt}}">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nội dung<span class="require">*</span></label>
                                        <input type="text" class="form-control" name="noidung" id="noidung" value="{{$model->noidung}}">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">File đính kèm 1</label>
                                        @if(isset($model->tailieu))
                                            <p><a href="{{url('/data/uploads/attack/'.$model->tailieu)}}" target="_blank">{{$model->tailieu}}</a></p>
                                        @endif
                                        <input name="tailieu" id="tailieu" type="file">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">File đính kèm 2</label>
                                        @if(isset($model->tailieu1))
                                            <p><a href="{{url('/data/uploads/attack/'.$model->tailieu1)}}" target="_blank">{{$model->tailieu1}}</a></p>
                                        @endif
                                        <input name="tailieu1" id="tailieu1" type="file">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">File đính kèm 3</label>
                                        @if(isset($model->tailieu2))
                                            <p><a href="{{url('/data/uploads/attack/'.$model->tailieu2)}}" target="_blank">{{$model->tailieu2}}</a></p>
                                        @endif
                                        <input name="tailieu2" id="tailieu2" type="file">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">File đính kèm 4</label>
                                        @if(isset($model->tailieu3))
                                            <p><a href="{{url('/data/uploads/attack/'.$model->tailieu3)}}" target="_blank">{{$model->tailieu3}}</a></p>
                                        @endif
                                        <input name="tailieu3" id="tailieu3" type="file">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">File đính kèm 5</label>
                                        @if(isset($model->tailieu4))
                                            <p><a href="{{url('/data/uploads/attack/'.$model->tailieu4)}}" target="_blank">{{$model->tailieu4}}</a></p>
                                        @endif
                                        <input name="tailieu4" id="tailieu4" type="file">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="col-md-12" style="text-align: center">
                                <button type="submit" class="btn green" onclick="validateForm()"><i class="fa fa-check"></i> Cập nhật</button>
                                <button type="reset" class="btn default"> Huỷ</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
    <script type="text/javascript">
        function validateForm(){

            var validator = $("#update_thanhkiemtra").validate({
                rules: {
                    ten :"required"
                },
                messages: {
                    ten :"Chưa nhập dữ liệu"
                }
            });
        }
    </script>
    <script>
        jQuery(document).ready(function($) {
            $('input[name="khvb"]').change(function(){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'GET',
                    url: '/checkkhvb-tkt',
                    data: {
                        _token: CSRF_TOKEN,
                        khvb:$(this).val()

                    },
                    success: function (respond) {
                        if(respond != 'ok'){
                            toastr.error("Bạn cần nhập lại ký hiệu văn bản", "Ký hiệu văn bản nhập vào đã tồn tại!!!");
                            $('input[name="khvb"]').val('');
                            $('input[name="khvb"]').focus();
                        }else
                            toastr.success("Ký hiệu văn bản sử dụng được!", "Thành công!");
                    }

                });
            })
        }(jQuery));
    </script>
@stop