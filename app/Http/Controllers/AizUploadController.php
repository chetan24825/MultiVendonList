<?php

namespace App\Http\Controllers;

use App\Models\Inc\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AizUploadController extends Controller
{
    public function index(Request $request)
    {
        $all_uploads = Upload::query();
        $search = null;
        $sort_by = null;

        if ($request->search != null) {
            $search = $request->search;
            $all_uploads->where('file_original_name', 'like', '%' . $request->search . '%');
        }

        $sort_by = $request->sort;
        switch ($request->sort) {
            case 'newest':
                $all_uploads->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $all_uploads->orderBy('created_at', 'asc');
                break;
            case 'smallest':
                $all_uploads->orderBy('file_size', 'asc');
                break;
            case 'largest':
                $all_uploads->orderBy('file_size', 'desc');
                break;
            default:
                $all_uploads->orderBy('created_at', 'desc');
                break;
        }

        $all_uploads = $all_uploads->paginate(50)->appends(request()->query());

        return view('uploaded_files.index', compact('all_uploads', 'search', 'sort_by'));
    }

    public function create()
    {
        return view('uploaded_files.create');
    }


    public function show_uploader(Request $request)
    {
        return view('uploader.aiz-uploader');
    }



    public function upload(Request $request)
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );

        if ($request->hasFile('aiz_file')) {
            $upload = new Upload;
            $extension = strtolower($request->file('aiz_file')->getClientOriginalExtension());
            if (isset($type[$extension])) {
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('aiz_file')->getClientOriginalName());
                for ($i = 0; $i < count($arr) - 1; $i++) {
                    if ($i == 0) {
                        $upload->file_original_name .= $arr[$i];
                    } else {
                        $upload->file_original_name .= "." . $arr[$i];
                    }
                }
                $originalName = $request->file('aiz_file')->getClientOriginalName();
                $path1 = $request->file('aiz_file')->storeAs('uploads/products/product_thumbnail', $originalName, 'local');
                $size = $request->file('aiz_file')->getSize();
                $img1 = Image::make($request->file('aiz_file')->getRealPath())->encode();
                $img1->save($path1);
                $path = $request->file('aiz_file')->storeAs('uploads/all', $originalName, 'local');
                $size = $request->file('aiz_file')->getSize();
                if ($type[$extension] == 'image' && 0 != 1) {
                    try {
                        $img = Image::make($request->file('aiz_file')->getRealPath())->encode();
                        $height = $img->height();
                        $width = $img->width();
                        if ($width > $height && $width > 1500) {
                            $img->resize(1500, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        } elseif ($height > 1500) {
                            $img->resize(null, 800, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                        $img1->save($path);
                        clearstatcache();
                        $size = $img->filesize();
                        if (env('FILESYSTEM_DRIVER') == 's3') {
                            Storage::disk('s3')->put($path, file_get_contents($path));
                            unlink($path);
                        }
                    } catch (\Exception $e) {
                        dd($e);
                    }
                }
                $upload->extension = $extension;
                $upload->file_name = $path;
                $upload->user_id = Auth::guard(current_guard())->id();
                $upload->type = $type[$upload->extension];
                $upload->guard = current_guard();
                $upload->file_size = $size;
                $upload->save();
            }
            return '{}';
        }
    }


    public function get_uploaded_files(Request $request)
    {

        $uploads = Upload::where('user_id', Auth::guard(current_guard())->id())->where('guard', current_guard());

        if ($request->search != null) {
            $uploads->where('file_original_name', 'like', '%' . $request->search . '%');
        }
        if ($request->sort != null) {
            switch ($request->sort) {
                case 'newest':
                    $uploads->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $uploads->orderBy('created_at', 'asc');
                    break;
                case 'smallest':
                    $uploads->orderBy('file_size', 'asc');
                    break;
                case 'largest':
                    $uploads->orderBy('file_size', 'desc');
                    break;
                default:
                    $uploads->orderBy('created_at', 'desc');
                    break;
            }
        }
        return $uploads->paginate(60)->appends(request()->query());
    }

    public function destroy(Request $request, $id)
    {

        try {
            if (env('FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->delete(Upload::where('id', $id)->first()->file_name);
            } else {
                unlink(public_path() . '/' . Upload::where('id', $id)->first()->file_name);
                $parts = explode('/', Upload::where('id', $id)->first()->file_name);
                $last = array_pop($parts);
                $parts = array(implode('/', $parts), $last);
                unlink(public_path('uploads/all/image-300x300/' . $parts[1]));
            }
            Upload::destroy($id);
            return redirect()->back()->with('success', 'File deleted successfully');
            //    return flash('File deleted successfully')->success();
        } catch (\Exception $e) {
            Upload::destroy($id);
            return redirect()->back()->with('success', 'File deleted successfully');
        }
        return back();
    }



    public function get_preview_files(Request $request)
    {

        $ids = explode(',', $request->ids);
        $files = Upload::whereIn('id', $ids)->get();
        return $files;
    }

    //Download project attachment
    public function attachment_download($id)
    {
        $project_attachment = Upload::find($id);
        try {
            $file_path = public_path($project_attachment->file_name);
            return Response::download($file_path);
        } catch (\Exception $e) {
            return back();
        }
    }
    //Download project attachment
    public function file_info(Request $request)
    {
        $file = Upload::findOrFail($request['id']);
        return view('uploaded_files.info', compact('file'));
    }
}
