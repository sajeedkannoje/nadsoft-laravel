<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="antialiased">

<div class="container">
    <h1>Members</h1>
    <div class="container">
        <div class="member-list">
            {!! $treeStructurehtml !!}
        </div>
    </div>
</div>


<button type="button" class="btn btn-primary mx-5" data-toggle="modal" data-target="#addMemberModal">
    Add Member
</button>

<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addMemberForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="parent_id">Parent</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">Select Parent</option>
                            @foreach($allMembers as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveMemberButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
  $(document).ready(function () {

    $('#addMemberForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 2, 
                maxlength: 50 
            },
            parent_id: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Name is required.",
                minlength: "Name must be at least {0} characters long.",
                maxlength: "Name cannot exceed {0} characters."
            },
            parent_id:{
                required: "Parent Id is required.",
            }
        },
        errorClass: "text-danger", 
        errorElement: "span",
        highlight: function (element) {
           
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
           
            $(element).removeClass('is-invalid');
        },  
        submitHandler: function (form) {
            $('#saveMemberButton').attr('disabled', true);
            $.ajax({
                url: '{{ route("members.store") }}',
                method: 'POST',
                data: $(form).serialize(), 
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (response) {
                    alert('Member added successfully');
                    $('#addMemberModal').modal('hide');
                    $('.member-list').empty().append(response.data);
                    
                    $('#addMemberForm')[0].reset();
                    $('#addMemberForm').validate().resetForm();
                },
                error: function (error) {
                    alert('Error: ' + error.responseJSON.message);
                },
                complete: function () {
                    $('#saveMemberButton').attr('disabled', false);
                }
            });
        }
    });
    });


</script>

</body>
</html>
