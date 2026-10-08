@extends('layouts.admin_layout')

@section('title', "Create New Blog")
@section('styles')
    <style>

        textarea.form-control,
        input.form-control,
        select.form-control {
            background-color: #ffffff0d !important;
            color: #fff !important;
        }

        select.form-control option {
            color: #000 !important;
        }

        .form-control[disabled] {
            background-color: #696969 !important;
            color: #000 !important;
            cursor: not-allowed;
        }

        input[disabled] {
            background-color: #696969 !important;
            color: #000 !important;
            cursor: not-allowed;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid" data-bs-theme="dark">

    @include('include.alert')

    <div class="row justify-content-center">

        <form action="{{ route('admin-blogs-update', $post->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="card bg-dark border-0 shadow-sm">

                <div class="card-header bg-transparent border-bottom">
                    <small class="text-muted">
                        Edit blog content, SEO details & publish settings
                    </small>
                </div>

                <div class="card-body">

                    {{-- Title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            Blog Title
                        </label>

                        <input type="text" name="title" id="title" class="form-control bg-secondary text-light border-0" placeholder="Enter blog title" value="{{ old('title', $post->title) }}" required>
                    </div>


                    {{-- Excerpt --}}
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">
                            Excerpt
                        </label>

                        <textarea name="excerpt" id="excerpt" class="form-control bg-secondary text-light" rows="2">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>


                    {{-- Content --}}
                    <div class="mb-3">
                        <label for="blog_content" class="form-label">
                            Content
                        </label>

                        <textarea name="blog_content" id="blog_content" class="form-control bg-secondary text-light" rows="30">{{ old('blog_content', $post->content) }}</textarea>
                    </div>


                    {{-- Featured Image --}}
                    <div class="mb-3">

                        <label for="featured_image" class="form-label">
                            Featured Image
                        </label>

                        <input type="file" name="featured_image" id="featured_image" class="form-control bg-secondary text-light border-0" accept="image/*" >

                        @if($post->featured_image)
                            <div class="mt-3">
                                <small class="text-muted d-block mb-2">
                                    Current Featured Image
                                </small>

                                <img id="featuredPreview" src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->slug }}" class="img-fluid rounded" style="max-height: 200px;" >
                            </div>
                        @else
                            <img id="featuredPreview" src="#" class="img-fluid mt-2 rounded d-none" style="max-height: 200px;" >
                        @endif

                    </div>


                    {{-- Keywords / Tags --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Keywords / Tags
                        </label>

                        <input type="text" name="keywords" class="form-control" placeholder="study abroad, uk visa, education consultant" value="{{ old('keywords', $post->meta_keywords) }}" >

                        <small class="text-muted">
                            Use comma(,) for each separate keyword
                        </small>

                    </div>


                    {{-- Meta Title --}}
                    <div class="mb-3">

                        <label for="meta_title" class="form-label">
                            Meta Title
                        </label>

                        <input type="text" name="meta_title" id="meta_title" class="form-control bg-secondary text-light border-0" placeholder="SEO Meta Title" value="{{ old('meta_title', $post->meta_title) }}" >

                    </div>


                    {{-- Meta Description --}}
                    <div class="mb-3">

                        <label for="meta_description" class="form-label">
                            Meta Description
                        </label>

                        <textarea name="meta_description" id="meta_description" class="form-control bg-secondary text-light" rows="3" placeholder="SEO Meta Description" >{{ old('meta_description', $post->meta_description) }}</textarea>

                    </div>


                    {{-- Status --}}
                    <div class="mb-3">

                        <label for="status" class="form-label">
                            Status
                        </label>

                        <select name="status"  id="status"  class="form-control bg-secondary text-light border-0"  required >

                            <option  value="draft"  {{ old('status', $post->is_published ? 'published' : 'draft') == 'draft' ? 'selected' : '' }}  >
                                Draft
                            </option>

                            <option  value="published"  {{ old('status', $post->is_published ? 'published' : 'draft') == 'published' ? 'selected' : '' }}  >
                                Published
                            </option>

                        </select>

                    </div>

                </div>


                <div class="card-footer bg-transparent border-top d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('admin-blogs-index') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                    >
                        Update Blog
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
@endsection

@section('scripts')
<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/m03e66aoghs5a2zrlqdcyt1gcvmxg6xpsd1veqrqil819ni9/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: '#blog_content',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Premium features
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'tinymceai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | tinymceai-chat tinymceai-quickactions tinymceai-review | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    tinymceai_token_provider: async () => {
      await fetch(`https://demo.api.tiny.cloud/1/m03e66aoghs5a2zrlqdcyt1gcvmxg6xpsd1veqrqil819ni9/auth/random`, { method: "POST", credentials: "include" });
      return { token: await fetch(`https://demo.api.tiny.cloud/1/m03e66aoghs5a2zrlqdcyt1gcvmxg6xpsd1veqrqil819ni9/jwt/tinymceai`, { credentials: "include" }).then(r => r.text()) };
    },
    uploadcare_public_key: '3adb344debacfd9ce388',
  });
</script>
<textarea>
  Welcome to TinyMCE!
</textarea>
@endsection