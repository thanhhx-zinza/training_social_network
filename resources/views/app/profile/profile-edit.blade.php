<button type="button" class="btn" id="btn-edit-profile">Edit</button>
<div class="modal fade" id="edit-profile" tabindex="-1"aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="get">
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row">
                    <?php
                        $avatarPath = '';
                        if (Auth::user()->profile->avatar) {
                            $avatarPath = asset('storage/images/'.Auth::user()->profile->avatar);
                        }
                    ?>
                    <div class="col-12 text-center mt-3">
                        <img
                            class="shadow-sm rounded-circle"
                            width="100px"
                            height="100px"
                            src="{{$avatarPath}}"
                            alt="Avatar"
                            id="avatar"
                        >
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <input type="file" name="avatar" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <label class="col-3 text-end">Last Name:</label>
                            <div class="col-8">
                                <input type="text" name="lastname" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row">
                            <label class="col-3 text-end">First Name:</label>
                            <div class="col-8">
                                <input type="text" name="firstname" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row">
                            <label class="col-3 text-end">Address:</label>
                            <div class="col-8">
                                <input type="text" name="address" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row">
                            <label class="col-3 text-end">Gender:</label>
                            <div class="col-8">
                                <input type="text" name="gender" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row">
                            <label class="col-3 text-end">Birthday:</label>
                            <div class="col-8">
                                <input type="text" name="birthday" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row">
                            <label class="col-3 text-end">Phone:</label>
                            <div class="col-8">
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var path = "{{ asset('storage/images/') }}" + "/"
    $("#btn-edit-profile").click(function() {
        $.ajax({
            url: "{{ route('profile.get_profile') }}",
            type: 'GET',
            success: function(res) {
                $("#edit-profile input[name='lastname']").val(res.last_name)
                $("#edit-profile input[name='firstname']").val(res.first_name)
                $("#edit-profile input[name='address']").val(res.address)
                $("#edit-profile input[name='gender']").val(res.gender)
                $("#edit-profile input[name='birthday']").val(res.birthday)
                $("#edit-profile input[name='phone']").val(res.phone_number)
                $('#edit-profile img').attr("src", path + res.avatar)
                $("#edit-profile").modal('show')
            },
            error: function(request, error) {
                alert('false')
            }
        })
    })
    $("#edit-profile form").submit(function(event) {
        event.preventDefault()
        var formData = new FormData(this)
        $.ajax({
            url: "{{ route('profile.update') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                $('#btn-show-profile img').attr("src", path + res.avatar)
                $("#edit-profile").modal('hide')
                alert(res.message)
            },
            error: function(request, error) {
                alert('Update fail')
            }
        })
    })
})
</script>
