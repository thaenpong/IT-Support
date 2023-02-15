<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

use App\Models\registration;
use App\Models\property_key;
use App\Models\employee;
use App\Models\unregistration;
use App\Models\registration_user_log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;




class registration_ctl extends Controller
{
    protected $fpdf;


    public function index($key, Request $request)
    {
        if ($key == 'all') {
            $registration = registration::all();
        } else {
            $registration = registration::where('property_id', $key)->get();
        }
        $property_key = property_key::all();
        $property_defualt = property_key::all()->where('id', $key);
        $employee = employee::all();
        return view('registration.index', compact('property_key', 'registration', 'property_defualt'));
        //------------------------------------------------------------------------------------------
        /**$articles = registration::when($request->has("property_code"), function ($q) use ($request) {
            return $q->where("property_code", "like", "%" . $request->get("property_code") . "%");
        })->paginate(5);
        if ($request->ajax()) {
            return view('registration.test', ['articles' => $articles]);
        }
        return view('registration.test', ['articles' => $articles]);**/
        //------------------------------------------------------------------------------------------

    }
    public function new()
    {
        $employee = employee::all();
        $property_key = property_key::all();
        return view('registration.new', compact('property_key', 'employee'));
    }
    public function new_post(Request $request)
    {
        $request->validate([
            'property_code' => 'required|max:8'
        ]);

        $registration = new registration;
        $registration->property_id = $request->property_id;
        $registration->property_code = $request->property_code;
        $registration->serial_number = $request->serial_number;
        $registration->brand = $request->brand;
        $registration->type = $request->type;
        $registration->spec = $request->spec;
        $registration->color = $request->color;
        $registration->refer = $request->refer;
        $registration->user_id = $request->user_id;
        $registration->admin_id = Auth::user()->id;
        $registration->save();
        return redirect()->route('registration', ['key' => 'all']);
    }

    public function edit($id)
    {
        $registration = registration::withTrashed()->find($id);
        $employee = employee::all();
        $property_key = property_key::all();

        return view('registration.edit', compact('property_key', 'employee', 'registration'));
    }

    public function update(Request $request, $id)
    {
        //$registration = registration::withTrashed()->find($id);
        //if ($request->user_id != $registration->user_id) {
        $logupdate = new registration_user_log;
        $logupdate->registration_id = $id;
        $logupdate->user_id = $request->user_id;
        $logupdate->in_admin = Auth::user()->id;
        $logupdate->save();
        //}
        $update = registration::find($id)->update([
            'property_id' => $request->property_id,
            'property_code' => $request->property_code,
            'serial_number' => $request->serial_number,
            'brand' => $request->brand,
            'type' => $request->type,
            'spec' => $request->spec,
            'color' => $request->color,
            'refer' => $request->refer,
            'user_id' => $request->user_id
        ]);
        return redirect()->route('registration', ['key' => 'all']);
    }

    public function detail($id)
    {
        $registration = registration::withTrashed()->find($id);
        return view('registration.detail', compact('registration'));
    }

    public function unregis(Request $request, $id)
    {

        registration::find($id)->update([
            'user_id' => '1',
            'refer' => $request->refer
        ]);

        $unregis = new unregistration;
        $unregis->registration_id = $id;
        $unregis->user_id = Auth::user()->id;
        $unregis->cause = $request->refer;
        $unregis->save();

        //echo $fpdf_d;
        registration::find($id)->delete();
        return redirect()->route('registration_detail', ['id' => $id]);
    }

    public function unregistration($key)
    {

        if ($key == 'all') {
            $registration = registration::onlyTrashed()->get();
        } else {
            $registration = registration::onlyTrashed()->get()->where('property_id', $key);
        }
        $property_key = property_key::all();
        $property_defualt = property_key::all()->where('id', $key);
        $employee = employee::all();
        //dd($employee->id);
        return view('registration.unregistration', compact('property_key', 'registration', 'property_defualt'));
    }

    public function unregispdf($id)
    {
        $data = unregistration::all()->where('registration_id', $id)->first();
        //dd($data->registration->id);

        //echo $data->id;
        define('FPDF_FONTPATH', public_path('fonts/'));

        $fpdf = new FPDF('P', 'mm', 'A4');
        $fpdf->AddPage();
        $fpdf->Image(storage_path('file\IT-P001 F06.jpg'), 0, 0, 210, 297);
        $fpdf->SetX(75);
        $fpdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $fpdf->SetFont('THSarabunNew', '', 16);
        $fpdf->Cell(250, 58, $data->created_at);
        $fpdf->SetX(75);
        $fpdf->Cell(250, 80, $data->registration->property_key->key . "" . $data->registration->property_code);
        $fpdf->SetX(75);
        $fpdf->Cell(250, 102, $data->registration->brand);
        $fpdf->SetX(75);
        $fpdf->Cell(250, 123, $data->registration->spec);
        $fpdf->SetX(75);
        $fpdf->Cell(250, 146, $data->registration->serial_number);
        $fpdf->SetX(75);
        $fpdf->Cell(250, 168, iconv('UTF-8', 'cp874', $data->cause));
        $fpdf->SetX(40);
        $fpdf->Cell(250, 207, iconv('UTF-8', 'cp874', $data->user->name));
        $fpdf->Output();
        //$fpdf->Output('D', 'Test.pdf');
        exit;
    }
}