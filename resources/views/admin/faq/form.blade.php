@extends('layouts.admin_layout')

@section('title', "Create FAQ")

@section('content')
    <div class="container-fluid" data-bs-theme="dark">
        <h2>Add FAQ</h2>
        <hr>
        <div class="py-2">

            {{-- Question --}}
            <div class="mb-3">
                <label for="question" class="form-label">Question:</label>
                <input type="text" id="question" class="form-control" required>
            </div>

            {{-- Answer --}}
            <div class="mb-3">
                <label for="answer" class="form-label">Answer:</label>
                <textarea id="answer" class="form-control" required></textarea>
            </div>

            <button id="addFaqBtn" class="btn btn-primary">Add FAQ</button>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#answer'), {
                toolbar: ["undo", "redo", "link", "bold", "italic", "bulletedList"],
                link: {
                    decorators: {
                        openInNewTab: {
                            mode: 'manual',
                            label: 'Open in new tab',
                            attributes: { target: '_blank', rel: 'noopener noreferrer' }
                        }
                    }
                }
            })
            .then(editor => {
                faqEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Adding FAQ to DB
        $('#addFaqBtn').on("click", function(){
            let question = $('#question').val();
            let answer = faqEditor.getData();

            if(!question || !answer) {alert("Both Question and Answer are required!");return;};

            $.ajax({
                url:"/faqs/store",
                method:"POST",
                data:{
                    question: question,
                    answer: answer,
                },
                success:function(res){
                    alert(res.message);
                    window.location.href = "/faqs"
                },
                error:function(xhr){
                    alert("Error Adding FAQ");
                    console.error(xhr.responseText);
                }
            })
        })
    </script>
@endsection