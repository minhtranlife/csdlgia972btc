<?php

namespace App\Http\Controllers;

use App\DmHhXnk;
use App\DmLoaiGia;
use App\DmThoiDiem;
use App\GiaHhXnk;
use App\GiaHhXnkDefault;
use App\HsGiaHhXnk;
use App\Nhomxnk;
use App\TtPhongBan;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HsGiaHhXnkController extends Controller
{

    public function thoidiem()
    {
        if(Session::has('admin')){
            $model = DmThoiDiem::where('plbc','Hàng hóa xuất nhập khẩu')
                ->get();
            return view('manage.giahhdv.hhxnk.thoidiem.index')
                ->with('model',$model)
                ->with('pageTitle','Chọn thời điểm nhập báo cáo giá hàng hóa xuất nhập khẩu');
        }else
            return view('errors.notlogin');
    }

    public function index($thoidiem,$nam,$pb)
    {
        if(Session::has('admin')){
            if($pb == 'all')
                $model = HsGiaHhXnk::where('mathoidiem',$thoidiem)
                    ->where('nam',$nam)
                    ->get();
            else
                $model = HsGiaHhXnk::where('mathoidiem',$thoidiem)
                    ->where('nam',$nam)
                    ->where('mahuyen',$pb)
                    ->get();
            $modelpb = TtPhongBan::all();

            foreach($model as $tt){
                $this->getTtPhongBan($modelpb,$tt);
            }
            return view('manage.giahhdv.hhxnk.index')
                ->with('model',$model)
                ->with('modelpb',$modelpb)
                ->with('thoidiem',$thoidiem)
                ->with('nam',$nam)
                ->with('pb',$pb)
                ->with('pageTitle','Thông tin hồ sơ giá hàng hóa xuất nhập khẩu');
        }else
            return view('errors.notlogin');
    }

    public function getTtPhongBan($pbs,$array){
        foreach($pbs as $pb){
            if($pb->ma == $array->mahuyen)
                $array->tenpb = $pb->ten;
        }
    }

    public function create($thoidiem)
    {
        if(Session::has('admin')){
            $loaigia = DmLoaiGia::all();
            $nhomhh = Nhomxnk::where('theodoi','Có')
                ->get();
            $modeldel = GiaHhXnkDefault::where('mahuyen',session('admin')->mahuyen)
                ->delete();
            return view('manage.giahhdv.hhxnk.create')
                ->with('mathoidiem',$thoidiem)
                ->with('loaigia',$loaigia)
                ->with('nhomhh',$nhomhh)
                ->with('pageTitle','Thông tin giá hàng hóa dịch vụ thêm mới');
        }else
            return view('errors.notlogin');

    }

    public function store(Request $request)
    {
        if(Session::has('admin')){
            $insert = $request->all();
            $date = date_create(getDateToDb($insert['tgnhap']));
            $thang = date_format($date,'m');
            $mahs = getdate()[0];

            $model = new HsGiaHhXnk();
            $model->tgnhap = getDateToDb($insert['tgnhap']);
            $model->maloaigia = $insert['maloaigia'];

            if($thang == 1 || $thang == 2 || $thang == 3)
                $model->quy = 1;
            elseif($thang == 4 || $thang == 5 || $thang == 6)
                $model->quy = 2;
            elseif($thang == 7 || $thang == 8 || $thang == 9)
                $model->quy = 3;
            else
                $model->quy = 4;
            $model->thang = date_format($date,'m');
            $model->nam = date_format($date,'Y');
            $model->mahuyen = session('admin')->mahuyen;
            $model->mahs = $mahs;
            $model->mathoidiem = $insert['mathoidiem'];
            if($model->save()){
                $this->createts($mahs);
            }

            return redirect('giahh-xuatnhapkhau/thoidiem='.$insert['mathoidiem'].'/nam='.date_format($date,'Y').'&pb='.session('admin')->mahuyen);

        }else
            return view('errors.notlogin');
    }

    public function createts($mahs){
        $modelts = GiaHhXnkDefault::where('mahuyen',session('admin')->mahuyen)
            ->get();
        if(count($modelts) > 0) {
            foreach ($modelts as $ts) {
                $model = new GiaHhXnk();
                $model->masoloai = $ts->masoloai;
                $model->mahh = $ts->mahh;
                $model->giatu  =$ts->giatu;
                $model->giaden = $ts->giaden;
                $model->soluong = $ts->soluong;
                $model->nguontin = $ts->nguontin;
                $model->gc = $ts->gc;
                $model->mahs = $mahs;
                $model->save();
            }
        }
    }

    public function show($id)
    {
        if(Session::has('admin')){
            $model = HsGiaHhXnk::findOrFail($id);
            $modeltthh = GiaHhXnk::where('mahs',$model->mahs)
                ->get();
            $modeldm = DmHhXnk::all();
            foreach($modeltthh as $tthh){
                $this->gettenhh($modeldm,$tthh);
            }
            $loaigia = DmLoaiGia::all();

            return view('manage.giahhdv.hhxnk.show')
                ->with('model',$model)
                ->with('modeltthh',$modeltthh)
                ->with('loaigia',$loaigia)
                ->with('pageTitle','Thông tin giá hàng hóa xuất nhập khẩu chi tiết');
        }else
            return view('errors.notlogin');
    }

    public function gettenhh($mahh,$array){

        //dd($array);
        foreach($mahh as $tt){

            if($tt->masoloai == $array->masoloai && $tt->mahh == $array->mahh){
                $array->tenhh = $tt->tenhh;
                break;
            }
        }
    }

    public function edit($id)
    {
        if(Session::has('admin')){
            $model = HsGiaHhXnk::findOrFail($id);
            $modeltthh = GiaHhXnk::where('mahs',$model->mahs)
                ->get();
            $modeldm = DmHhXnk::all();
            foreach($modeltthh as $tthh){
                $this->gettenhh($modeldm,$tthh);
            }
            $nhomhh = Nhomxnk::where('theodoi','Có')
                ->get();
            $loaigia = DmLoaiGia::all();
            return view('manage.giahhdv.hhxnk.edit')
                ->with('model',$model)
                ->with('modeltthh',$modeltthh)
                ->with('nhomhh',$nhomhh)
                ->with('loaigia',$loaigia)
                ->with('pageTitle','Thông tin giá hàng hóa xuất nhập khẩu chỉnh sửa');
        }else
            return view('errors.notlogin');
    }

    public function update(Request $request, $id)
    {
        if(Session::has('admin')){
            $insert = $request->all();
            $date = date_create(getDateToDb($insert['tgnhap']));
            $thang = date_format($date,'m');

            $model = HsGiaHhXnk::findOrFail($id);
            $model->tgnhap = getDateToDb($insert['tgnhap']);
            $model->maloaigia = $insert['maloaigia'];

            if($thang == 1 || $thang == 2 || $thang == 3)
                $model->quy = 1;
            elseif($thang == 4 || $thang == 5 || $thang == 6)
                $model->quy = 2;
            elseif($thang == 7 || $thang == 8 || $thang == 9)
                $model->quy = 3;
            else
                $model->quy = 4;
            $model->thang = date_format($date,'m');
            $model->nam = date_format($date,'Y');
            $model->save();

            return redirect('giahh-xuatnhapkhau/thoidiem='.$model->mathoidiem.'/nam='.$model->nam.'&pb='.$model->mahuyen);

        }else
            return view('errors.notlogin');
    }

    public function destroy(Request $request)
    {
        if(Session::has('admin')){
            $input = $request->all();
            $model = HsGiaHhXnk::where('id',$input['iddelete'])
                ->first();
            if($model->delete())
                $modelhh = GiaHhXnk::where('mahs',$model->mahs)
                    ->delete();
            return redirect('giahh-xuatnhapkhau/thoidiem='.$model->mathoidiem.'/nam='.$model->nam.'&pb='.$model->mahuyen);

        }else
            return view('errors.notlogin');
    }

    public function search(){
        if(Session::has('admin')){
            $modelmaloaigia = DmLoaiGia::all();
            $modelhh = DmHhXnk::where('theodoi','Có')->get();
            return view('manage.giahhdv.hhxnk.search.create')
                ->with('modelmaloaigia',$modelmaloaigia)
                ->with('modelhh',$modelhh)
                ->with('pageTitle','Tìm kiếm thông tin giá hàng hóa xuất nhập khẩu');
        }else
            return view('errors.notlogin');
    }

    public function viewsearch(Request $request){
        if(Session::has('admin')){

            $_sql="select hsgiahhxnk.*,
                          giahhxnk.mahh,giahhxnk.masoloai,giahhxnk.giatu,giahhxnk.giaden,giahhxnk.soluong,giahhxnk.nguontin
                                        from hsgiahhxnk, giahhxnk
                                        Where hsgiahhxnk.mahs=giahhxnk.mahs";
            $input=$request->all();

            //Thời gian nhập
            //Từ
            if($input['tgnhaptu']!=null){
                $_sql=$_sql." and hsgiahhxnk.tgnhap >='".date('Y-m-d',strtotime($input['tgnhaptu']))."'";
            }
            //Đến
            if($input['tgnhapden']!=null){
                $_sql=$_sql." and hsgiahhxnk.tgnhap <='".date('Y-m-d',strtotime($input['tgnhapden']))."'";
            }
            //Loại giá (error Không biết vì sao)
            //$_sql=$input['maloaigia']!=null? $_sql." and hsgiahhxnk.maloaigia = ".$input['maloaigia']:$_sql;
            //Tên hàng hóa
            $_sql=$input['mahh']!=null? $_sql." and giahhxnk.mahh = ".$input['mahh']:$_sql;
            //Giá trị tài sản
            //Từ
            if(getDouble($input['giatritu'])>0)
                $_sql=$_sql." and giahhxnk.giatu >= ".getDouble($input['giatritu']);
            //Đến
            if(getDouble($input['giatriden'])>0)
                $_sql=$_sql." and giahhxnk.giaden <= ".getDouble($input['giatriden']);

            $model =  DB::select(DB::raw($_sql));
            //dd($model);

            $modeldm = DmHhXnk::all();
            $modelpb = TtPhongBan::all();

            foreach($model as $tthh){
                $this->gettenhh($modeldm,$tthh);
                $this->getTtPhongBan($modelpb,$tthh);
            }

            return view('manage.giahhdv.hhxnk.search.index')
                ->with('model',$model)
                ->with('pageTitle','Thông tin giá hàng hóa xuất nhập khẩu');
        }else
            return view('errors.notlogin');
    }
}
