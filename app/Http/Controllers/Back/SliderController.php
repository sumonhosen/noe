<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Repositories\MediaRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('position')->get();

        return view('back.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'text_1' => 'max:255',
            'text_2' => 'max:255',
            'text_3' => 'max:255',
            'button_1_text' => 'max:255',
            'button_1_url' => 'max:255',
            'button_2_text' => 'max:255',
            'button_2_url' => 'max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif',
            'video' => 'mimes:mp4',
            'slider_type' => 'required|not_in:0|numeric',
        ])->validate();
        $data = $request->except(['image','video']);

        if($request->file('image')){
            $uploaded_file = MediaRepo::upload($request->file('image'));
            $data +=[
                'image'=>$uploaded_file['file_name'],
                'image_path'=>$uploaded_file['file_path'],
                'media_id'=>$uploaded_file['media_id'],
            ];
            /*$slider->image = $uploaded_file['file_name'];
            $slider->image_path = $uploaded_file['file_path'];
            $slider->media_id = $uploaded_file['media_id'];*/
        }
        if ($request->file('video')){
            $file = $request->file('video');
            $fileName = time().'_'.$request->file('video')->getClientOriginalName();

            $destination = public_path('uploads/blog/video');
            $file->move($destination, $fileName);
            $data +=[
                'video'=>$fileName,
            ];
        }
        try {
            Slider::create($data);
            return response()->json(['status'=>'success','message'=>'Successfully created'],200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','message'=>'Invalid request'],404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('back.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'text_1' => 'max:255',
            'text_2' => 'max:255',
            'text_3' => 'max:255',
            'button_1_text' => 'max:255',
            'button_1_url' => 'max:255',
            'button_2_text' => 'max:255',
            'button_2_url' => 'max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif',
            'video' => 'mimes:mp4',
            'slider_type' => 'required|not_in:0|numeric',
        ]);
        $data = $request->except(['image','video']);
        if($request->file('image')){
            $uploaded_file = MediaRepo::upload($request->file('image'));
            $data +=[
                'image'=>$uploaded_file['file_name'],
                'image_path'=>$uploaded_file['file_path'],
                'media_id'=>$uploaded_file['media_id'],
            ];
        }
        if ($request->file('video')){
            $file = $request->file('video');
            $fileName = time().'_'.$request->file('video')->getClientOriginalName();

            $destination = public_path('uploads/blog/video');
            $file->move($destination, $fileName);
            $data +=[
                'video'=>$fileName,
            ];
        }
        try {
            $slider->update($data);
            return redirect()->back()->with('success-alert', 'Slider updated successfully.');
        }catch (\Exception $e){
            return redirect()->back()->with('error-alert', 'Slider can\'t updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect()->back()->with('success-alert', 'Slider deleted successfully.');
    }

    public function position(Request $request){
        foreach ($request->position as $i => $data) {
            $query = Slider::find($data);
            $query->position = $i;
            $query->save();
        }

        return redirect()->back()->with('success-alert', 'Position updated successfully.');
    }
}
