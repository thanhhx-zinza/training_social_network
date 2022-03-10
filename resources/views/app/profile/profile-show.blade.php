<?php
    $avatarPath = '';
    if (Auth::user()->profile->avatar) {
        $avatarPath = asset('storage/images/'.Auth::user()->profile->avatar);
    }
?>
<button type="button" class="btn btn-sm p-0" id="btn-show-profile" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <img
        class="rounded-circle"
        src="{{ $avatarPath }}"
        width="40px"
        height="40px"
    >
</button>
<div class="modal fade" id="show-profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row">
                    <div class="col-12 text-center mt-3">
                        <img
                            class="shadow-sm rounded-circle"
                            width="100px"
                            height="100px"
                            src=""
                            alt="Avatar"
                        >
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <label class="col-3 text-end">Last Name:</label>
                            <div class="col-8">
                                <p class="fw-bold" id="last-name-text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-3 text-end">First Name:</label>
                            <div class="col-8">
                                <p class="fw-bold" id="first-name-text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-3 text-end">Address:</label>
                            <div class="col-8">
                                <p class="fw-bold" id="address-text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-3 text-end">Gender:</label>
                            <div class="col-8">
                                <p class="fw-bold" id="gender-text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-3 text-end">Birthday:</label>
                            <div class="col-8">
                                <p class="fw-bold" id="birthday-text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-3 text-end">Phone:</label>
                            <div class="col-8">
                                <p class="fw-bold" id="phone-text"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var path = "{{ asset('storage/images/') }}" + "/"
    $("#btn-show-profile").click(function() {
        $.ajax({
            url: "{{ route('profile.get_profile') }}",
            type: 'GET',
            success: function(res) {
                $('#show-profile #last-name-text').text(res.last_name)
                $('#show-profile #first-name-text').text(res.first_name)
                $('#show-profile #address-text').text(res.address)
                $('#show-profile #gender-text').text(res.gender)
                $('#show-profile #birthday-text').text(res.birthday)
                $('#show-profile #phone-text').text(res.phone_number)
                $('#show-profile img').attr("src", path + res.avatar)
                $("#show-profile").modal('show')
            },
            error: function(request, error) {
                alert('false')
            }
        })
    })
})
</script>
