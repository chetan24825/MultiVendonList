<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertiser;
use Illuminate\Support\Str;
use App\Models\Inc\CustomPages;
use App\Models\Inc\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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
}
