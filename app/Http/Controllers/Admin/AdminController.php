<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Advertiser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Inc\CustomPages;
use Illuminate\Support\Facades\DB;
use App\Models\Inc\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;


class AdminController extends Controller
{
    public function toAdminDashboard()
    {
        return view('admin.home.dashboard');
    }


    // ------------------------------------------------------------------------------------------------------------------
    // ----------------------------------------- Basic Settings -------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------


    function toSettings()
    {
        return  view('admin.getSetting.getsetting');
    }

    public function toSettingUpload(Request $request)
    {
        $settings = $request->except('_token');
        foreach ($settings as $type => $value) {
            $businessSetting = BusinessSetting::firstOrNew(['type' => $type]);
            $businessSetting->value = $value;
            $businessSetting->save();
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }


    // ------------------------------------------------------------------------------------------------------------------
    // -----------------------------------------Custom Pages-------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------

    function toCustomPage()
    {
        $custompages = CustomPages::with(['childs', 'parent'])->get();
        return view('admin.custompages.pages', compact('custompages'));
    }

    function toCustom(Request $request)
    {
        $custompages = CustomPages::with(['childs', 'parent'])->orderBy('id', 'Desc')->get();
        return view('admin.custompages.allpages', compact('custompages'));
    }

    function toCustomPageSave(Request $request)
    {
        $request->validate([
            "parent_id" => "required|string",
            "page_name" => "required|string|max:100|unique:custompages,page_name",
            "page_desc" => "required|string",
        ]);

        $custompage = new CustomPages();
        $custompage->page_name = ucfirst($request->page_name);
        $custompage->slug = Str::slug($request->page_name);
        $custompage->parent_id = $request->parent_id;
        $custompage->status = $request->status;
        $custompage->banner = $request->banner;
        $custompage->priority = $request->priority;
        $custompage->page_desc = $request->page_desc;
        $custompage->meta_title = $request->meta_title;
        $custompage->meta_keyword = $request->meta_keyword;
        $custompage->meta_description = $request->meta_description;
        if ($custompage->save()) {
            return redirect()->back()->with('success', 'Page created successfully.');
        }
        return redirect()->back()->with('error', 'Page not created.');
    }

    function toCustomPageEdit($id)
    {
        $custompage = CustomPages::findOrFail($id);
        if (!$custompage) {
            return redirect()->back()->with('error', 'Page not found.');
        }
        $custompages = CustomPages::where('parent_id', 0)->get();
        return view('admin.custompages.edit', compact('custompage', 'custompages'));
    }

    function toCustomPageUpdate(Request $request, $id)
    {

        $request->validate([
            "parent_id" => "required|string",
            "page_name" => "required|string|max:100|unique:custompages,page_name,$id",
            "page_desc" => "required|string",
        ]);
        $custompage = CustomPages::findOrFail($id);
        $custompage->page_name = ucfirst($request->page_name);
        $custompage->slug = Str::slug($request->page_name);
        $custompage->parent_id = $request->parent_id;
        $custompage->status = $request->status;

        $custompage->Show_in = $request->Show_in;

        $custompage->banner = $request->banner;
        $custompage->priority = $request->priority;
        $custompage->page_desc = $request->page_desc;
        $custompage->meta_title = $request->meta_title;
        $custompage->meta_keyword = $request->meta_keyword;
        $custompage->meta_description = $request->meta_description;
        if ($custompage->save()) {
            return redirect()->back()->with('success', 'Page updated successfully.');
        }
        return redirect()->back()->with('error', 'Page not updated.');
    }


    public function toCustomPageDelete($id)
    {
        try {
            // Fetch the CustomPage with its relations
            $customPage = CustomPages::with(['childs', 'parent'])->findOrFail($id);

            // Check if the page has child pages
            if ($customPage->childs->isNotEmpty()) {
                return response()->json(['error' => 'Page cannot be deleted as it has child pages.'], 400);
            }

            // Attempt to delete the page
            if ($customPage->delete()) {
                return response()->json(['success' => 'Item deleted successfully.'], 200);
            }

            // Handle unexpected failure to delete
            return response()->json(['error' => 'Item could not be deleted.'], 500);
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    function toAdminView($id)
    {
        try {
            $company = Advertiser::findOrFail($id);
            if ($company) {
                Auth::guard('advertiser')->login($company);
                return redirect()->route('advertiser.dashboard');
            } else {
                return redirect()->back()->with('error', 'Company not found.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Company not found.');
        }
    }



    function tocompanyimport()
    {
        return view('admin.companies.company_import');
    }

    function tocompanyimportexcel(Request $request)
    {
        $request->validate([
            'import' => 'required|mimes:xlsx,csv'
        ]);
        ini_set('max_execution_time', 3600);
        $the_file = $request->file('import');

        try {
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();

            $row_range    = range(2, $row_limit);
            $column_range = range('h', $column_limit);
            $startcount = 2;
            $data = array();
            foreach ($row_range as $row) {

                if ($sheet->getCell('A' . $row)->getValue()) {
                    $businessName = strip_tags($sheet->getCell('A' . $row)->getValue());
                    $cleanedBusinessName = preg_replace('/[^\x20-\x7E]/', '', $businessName);
                    $city = $sheet->getCell('F' . $row)->getValue() ?? 'N/A';
                    $cleanedCity = preg_replace('/[^\x20-\x7E]/', '', $city);
                    $website = strip_tags($sheet->getCell('B' . $row)->getValue());
                    $websiteName = preg_replace('/[^\x20-\x7E]/', '', $website);
                    if (DB::table('advertisers')->where('company_name', $cleanedBusinessName)->where('address', $sheet->getCell('E' . $row)->getValue())->first()) {
                        continue;
                    } else {
                        $data = array();
                        $data['company_name'] =  $cleanedBusinessName; //ok
                        $data['website'] = $websiteName;
                        $data['phone'] = $sheet->getCell('C' . $row)->getValue();
                        $data['email'] = $sheet->getCell('D' . $row)->getValue();
                        $data['address'] = $sheet->getCell('E' . $row)->getValue() ?? 'N/A';
                        $data['city']  = $cleanedCity;
                        $data['type']  = 2;
                        $data['data_from'] = 'import';
                        $data['state']  = $sheet->getCell('G' . $row)->getValue();
                        $data['zipcode']  = $sheet->getCell('H' . $row)->getValue();
                        $data['timing']  = $sheet->getCell('I' . $row)->getValue();
                        $data['company_slug'] = Str::slug($cleanedBusinessName);
                        DB::table('advertisers')->insert($data);
                        $startcount++;
                    }
                }
            }
        } catch (Exception $e) {
            return back()->withErrors('There was a problem uploading the data!');
        }
        return  redirect()->back()->with('success', 'Plumber Upload Successfully');
    }
}
