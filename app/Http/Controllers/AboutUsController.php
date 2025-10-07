<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonFunctions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AboutRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\AboutUs;

class AboutUsController extends Controller
{
    use CommonFunctions;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAboutUs()
    {
        
        return view("Dashboard.Pages.manageAboutUs");
    }

    public function saveAboutUs(AboutRequest $request)
    {
        Cache::forget("about_us");
        switch ($request->input("action")) {
            case "insert":
                $return = $this->insertData($request);
                break;
            case "update":
                $return = $this->updateData($request);
                break;
            case "enable":
                $return = $this->enableRow($request);
                break;
            case "disable":
                $return = $this->disableRow($request);
                break;
            default:
                $return = ["status" => false, "message" => "Unknown action.", "data" => null];
        }
        return response()->json($return);
    }

    public function ImageUpload(AboutRequest $request)
    {
        $maxId = AboutUs::max(AboutUs::ID);
        $maxId += 1;
        $timeNow = strtotime($this->timeNow());
        $maxId .= "_$timeNow";
        return $this->uploadLocalFile($request, 'image', "/images/about_us/", "about_us_$maxId");
    }

    public function insertData(AboutRequest $request)
    {
            $image_url = "";
            $bannerImage = $this->ImageUpload($request);

            if ($bannerImage["status"]) {
                $image_url = $bannerImage["data"];
            } else {
                return $bannerImage;
            }           
            
            $createNewRow = new AboutUs();
            $createNewRow->title = $request->title;
            $createNewRow->image = $image_url;
            $createNewRow->description = $request->description;
            $createNewRow->status = $request->status;
            $createNewRow->save();
            $return = $this->returnMessage("Saved successfully.", true);
        
        return $return;
    }

    public function updateData(AboutRequest $request)
    {
        
            $updateModel = AboutUs::find($request->id);
        if($updateModel){
            $image_url = $updateModel->image;
            if($request->file('image')){
                $aboutImage = $this->ImageUpload($request);
                if ($aboutImage["status"]) {
                    $image_url = $aboutImage["data"];
                } else {
                    return $aboutImage;
                }
            }  
            
            $updateModel->title = $request->title;
            $updateModel->image = $image_url;
            $updateModel->description = $request->description;
            $updateModel->status = 1;
            $updateModel->save();
            $return = $this->returnMessage("Saved successfully.", true);
        }else{
                $return = ["status"=>false,"message"=>"Details not found.","data"=>null];
            }
        return $return;
    }

    public function enableRow(AboutRequest $request)
    {
        $check = AboutUs::where('id', $request->id)->first();
        if ($check) {
            $check->status = 1;
            $check->save();
            $return = $this->returnMessage("Enabled successfully.", true);
        } else {
            $return = $this->returnMessage("Details not found.");
        }
        return $return;
    }

    public function disableRow(AboutRequest $request)
    {
        $check = AboutUs::where('id', $request->id)->first();
        if ($check) {
            $check->status = 0;
            $check->save();
             
            $return = $this->returnMessage("Disabled successfully.", true);
        } else {
            $return = $this->returnMessage("Details not found.");
        }
        return $return;
    }

    public function aboutData()
    {

        $query = AboutUs::select(
            'title' ,'description' ,'image' ,'status','id'
        );
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn_edit = '<a data-row="' . base64_encode(json_encode($row)) . '" href="javascript:void(0)" class="edit btn btn-primary btn-sm mt-2">Edit</a>';

                $btn_disable = ' <a   href="javascript:void(0)" onclick="Disable(' . $row->id . ')" class="btn btn-danger btn-sm mt-2">Disable</a>';
                $btn_enable = ' <a   href="javascript:void(0)" onclick="Enable(' . $row->id . ')" class="btn btn-primary btn-sm mt-2">Enable</a>';
                if ($row->status == 1) {
                    return $this->addDiv($btn_edit . $btn_disable);
                } else {
                    return $this->addDiv($btn_edit . $btn_enable);
                }
            })
            ->rawColumns(['action','service_details'])
            ->make(true);
    }


    public function getAbout()
    {
        $abouts = AboutUs::where('status', 1)->orderBy('updated_at', 'desc')->first();
        $data = [
            'status' => true,
            'success' => true,
            'aboutus' => $abouts,
        ];

        return response()->json($data, 200);
    }

    public function aboutDetails($id)
    {
        $about = AboutUs::where('id',$id)->first();
        $data = [
            'status' => true,
            'success' => true,
            'about' => $about,
        ];

        return response()->json($data, 200);
    }
}
