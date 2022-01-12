@extends('back.layouts.master')
@section('title', 'Create page')

@section('master')
<form action="{{route('back.pages.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="row">
    <div class="col-md-8">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <a href="{{route('back.pages.index')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> View All</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>Title*</b></label>
                            <input type="text" class="form-control form-control-sm" name="title" value="{{old('title')}}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>Short Description</b></label>

                            <textarea class="form-control form-control-sm" name="short_description" cols="30" rows="3">{{old('short_description')}}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>Description</b></label>

                            <textarea id="editor" class="form-control form-control-sm" name="description" cols="30" rows="3">{{old('description')}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-light mt-3 shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <div class="img_group">
                                <img class="img-thumbnail uploaded_img" src="{{asset('img/default-img.png')}}">

                                <div class="form-group text-center">
                                    <label><b>Featured Image</b></label>
                                    <div class="custom-file text-left">
                                        <input type="file" class="custom-file-input image_upload" name="image" accept="image/*">
                                        <label class="custom-file-label">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <img class="img-thumbnail uploaded_img" src="{{asset('img/default-img.png')}}">

                                <div class="form-group text-center">
                                    <label><b>Featured image</b></label>
                                    <div class="custom-file text-left">
                                        <input type="file" class="custom-file-input image_upload" name="image" accept="image/*">
                                        <label class="custom-file-label">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>Meta title</b></label>

                            <input type="text" class="form-control form-control-sm" name="meta_title" value="{{old('meta_title')}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>Meta description</b></label>

                            <input type="text" class="form-control form-control-sm" name="meta_description" value="{{old('meta_description')}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>Meta tags</b></label>

                            <input type="text" class="form-control form-control-sm" name="meta_tags" value="{{old('meta_tags')}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>Page Template</b></label>

                            <select name="template" class="form-control form-control-sm">
                                <option value="">Select Template</option>
                                @foreach (Info::pageTemplates() as $template)
                                    <option value="{{$template['blade']}}">{{$template['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-block">Create</button>
                <small><b>NB: *</b> marked are required field.</small>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@section('footer')
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

    <script>
        // CKEditor
        $(function () {
            CKEDITOR.replace('editor', {
                height: 200,
                filebrowserUploadUrl: "{{route('imageUpload')}}?",
                disableNativeSpellChecker : false,
            });
        });
    </script>
@endsection
