<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebSiteElementRequest;
use App\Models\WebSiteElements;
use App\Traits\CommonFunctions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class WebSiteElementsController extends Controller
{
    
    use CommonFunctions;
    const ELEMENTS = [
        "Logo",
        "Address",
        "mail",
        "mobile",
        "whatsapp_number",
        "Map_link",
        "facebook_link",
        "youtube_link",
        "instagram_link",
        "twitter",
        "linkedin",
        "banner_title",
        "banner_content",
        "active_clients_number",
        "team_advisor_number",
        "project_done_number",
        "glorious_years_no",       
        "testimonial_heading",
        "testimonial_content",
        "packages_heading",
        "packages_short_description",
        "blog_heading",
        "blog_short_description",
        'seo_image',
        'contact_timing',
        'service_banner',
        'service_banner_content',
        'blog_banner',
        'blog_banner_content',
        'international_address',
        'footer_content',
    ];
    public function addWebSiteElements()
    {
        $titles = self::ELEMENTS;
        return view("Dashboard.Pages.webSiteElements", compact("titles"));
    }

    public function saveWebSiteElement(WebSiteElementRequest $request)
    {
        try {
            $requestData = $request->all();
            if ($requestData["action"] == "insert") {
                $return = $this->insertWebSiteElement($requestData, $request);
            } else if ($request["action"] == "update") {
                $return = $this->updateWebSiteElement($requestData, $request);
            } else if ($request["action"] == "disable") {
                $check = WebSiteElements::where(WebSiteElements::ID, $requestData[WebSiteElements::ID])->first();
                $check->{WebSiteElements::UPDATED_BY} = Auth::user()->id;
                $check->{WebSiteElements::STATUS} = 0;
                $check->save();
                $this->forgetWebSiteElements();
                $return = ["status" => true, "message" => "Details updated", "data" => null];
            } else if ($request["action"] == "enable") {
                $check = WebSiteElements::where(WebSiteElements::ID, $requestData[WebSiteElements::ID])->first();
                $check->{WebSiteElements::UPDATED_BY} = Auth::user()->id;
                $check->{WebSiteElements::STATUS} = 1;
                $check->save();
                $this->forgetWebSiteElements();
                $return = ["status" => true, "message" => "Details updated", "data" => null];
            } else {
                $return = ["status" => false, "message" => "Invalid action", "data" => null];
            }
        } catch (Exception $exception) {
            $return = ["status" => false, "message" => "Exception occurred  : " . $exception->getMessage(), "data" => null];
        }
        return response()->json($return);
    }

    public function updateWebSiteElement($requestData, WebSiteElementRequest $request)
    {
        $check = WebSiteElements::where(WebSiteElements::ID, $requestData[WebSiteElements::ID])->first();
        if ($check) {
            if ($this->checkDuplicateElement($requestData[WebSiteElements::ELEMENT], $requestData[WebSiteElements::ID])) {
                $return = ["status" => false, "message" => "Element already found", "data" => null];
            } else {
                $check->{WebSiteElements::ELEMENT} = $requestData[WebSiteElements::ELEMENT];
                $check->{WebSiteElements::ELEMENT_TYPE} = $requestData[WebSiteElements::ELEMENT_TYPE];
                if ($requestData[WebSiteElements::ELEMENT_TYPE] == "Image") {
                    $fileUpload = $this->uploadLocalFile($request, "element_details_image", "/images/WesiteElements/");
                    if ($fileUpload["status"]) {
                        $check->{WebSiteElements::ELEMENT_DETAILS} = $fileUpload["data"];
                    } else {
                        return $fileUpload;
                    }
                } else {
                    $check->{WebSiteElements::ELEMENT_DETAILS} = $requestData["element_details_text"];
                }
                $check->save();
                $this->forgetWebSiteElements();
                $return = ["status" => true, "message" => "Details updated", "data" => null];
            }
        } else {
            $return = ["status" => false, "message" => "Details not found", "data" => null];
        }
        return $return;
    }

    public function checkDuplicateElement($element, $existingId = null)
    {
        $check = WebSiteElements::where(WebSiteElements::ELEMENT, $element);
        if ($existingId) {
            $check->where(WebSiteElements::ID, "!=", $existingId);
        }
        return $check->exists();
    }
    public function insertWebSiteElement($requestData, WebSiteElementRequest $request)
    {
        $check = WebSiteElements::where([
            [WebSiteElements::ELEMENT, $requestData[WebSiteElements::ELEMENT]],
            [WebSiteElements::ELEMENT_TYPE, $requestData[WebSiteElements::ELEMENT_TYPE]]
        ])->first();
        if ($this->checkDuplicateElement($requestData[WebSiteElements::ELEMENT])) {
            $return = ["status" => false, "message" => "Element already found", "data" => null];
        } else {
            $check = new WebSiteElements();
            $check->{WebSiteElements::ELEMENT} = $requestData[WebSiteElements::ELEMENT];
            $check->{WebSiteElements::ELEMENT_TYPE} = $requestData[WebSiteElements::ELEMENT_TYPE];
            if ($requestData[WebSiteElements::ELEMENT_TYPE] == "Image") {
                $fileUpload = $this->uploadLocalFile($request, "element_details_image", "/images/WesiteElements/");
                if ($fileUpload["status"]) {
                    $check->{WebSiteElements::ELEMENT_DETAILS} = $fileUpload["data"];
                } else {
                    return $fileUpload;
                }
            } else {
                $check->{WebSiteElements::ELEMENT_DETAILS} = $requestData["element_details_text"];
            }
            $this->forgetWebSiteElements();
            $check->save();
            $return = ["status" => true, "message" => "Saved successfully.", "data" => null];
        }
        return $return;
    }


    public function getWebElementsData()
    {
        $data = WebSiteElements::select(
            WebSiteElements::ID,
            WebSiteElements::ELEMENT,
            WebSiteElements::ELEMENT_TYPE,
            WebSiteElements::ELEMENT_DETAILS,
            WebSiteElements::STATUS
        );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a data-row="' . base64_encode(json_encode($row)) . '" href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                if ($row->{WebSiteElements::STATUS} == 1) {
                    $btn .= '<a href="javascript:void(0)" onclick="Disable(\''.$row->{WebSiteElements::ID}.'\')" class="btn btn-danger btn-sm">Disable</a>';
                } else {
                    $btn .= '<a href="javascript:void(0)" onclick="Enable(\''.$row->{WebSiteElements::ID}.'\')" class="btn btn-info btn-sm">Enable</a>';
                }
                return $btn;
            })
            ->rawColumns(['action',WebSiteElements::ELEMENT_DETAILS])
            ->make(true);
    }


    public function homeElements()
    {
       
        $elements = WebSiteElements::where('status','1')->get();
        $elementData = $elements->pluck('element_details', 'element')->toArray();
        $data = [
            'status' => true,
            'success' => true,
            'elements' => $elementData,
        ];
        return response()->json($data, 200);
    }

    public function socialMedia()
    {
        $elements = WebSiteElements::where('status','1')->whereIn('element',['facebook_link','youtube_link','instagram_link','twitter','linkedin','whatsapp_number'])->get();
        $elementData = $elements->pluck('element_details', 'element')->toArray();
        $data = [
            'status' => true,
            'success' => true,
            'elements' => $elementData,
        ];
        return response()->json($data, 200);
    }

    public function footerContent()
    {
        $footerContent = WebSiteElements::where('status','1')->where('element','footer_content')->value('element_details');
        $data = [
            'status' => true,
            'success' => true,
            'footerContent' => $footerContent,
        ];
        return response()->json($data, 200);

    }
}
