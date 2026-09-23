@extends('layouts.admin_layout')

@section('title', "FAQs")

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin-faqs-create') }}" class="btn btn-sm btn-primary">Add Question</a>
        <div class="mt-4">
            <div class="table-responsive">
                <table class="table table-dark-custom table-primary table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faqs as $key => $faq)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $faq->question }}</td>
                                <td>{!!$faq->answer!!}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" id="deleteFaqBtn" data-id="{{ $faq->id }}"><i class="ri-delete-bin-2-line"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#deleteFaqBtn').on("click", function(){
            const id = $(this).data("id");
            $.ajax({
                url: "/faqs/delete/"+id ,
                method:"POST",
                success:function(res){
                    alert(res.message);
                    window.location.href = "/faqs"
                },
                error:function(err){
                    console.log(err)
                }
            })
        })
    })
</script>
@endsection