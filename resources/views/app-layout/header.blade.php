{{-- @dd($notifications) --}}
<div class="row navbar navbar-expand-lg navbar-light bg-light w-100 px-2">
    <div class="col-3 d-flex">
        <a class="navbar-brand" href="#">SC</a>
        <form>
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        </form>
    </div>
    <div class="col-5">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fa fa-television" aria-hidden="true"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled">Disabled</a>
            </li>
        </ul>
    </div>
    <div class="col-4 d-flex">
        <!--Show profile-->
        <button type="button" class="btn btn-sm p-0" id="btn-show-profile" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <img class="rounded-circle" src="{{ asset('storage/images/'.Auth::user()->profile->avatar) }}" width="40px" height="40px">
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

        <!--Edit profile-->
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
                            <div class="col-12 text-center mt-3">
                                <img
                                    class="shadow-sm rounded-circle"
                                    width="100px"
                                    height="100px"
                                    src="{{ asset('storage/images/'.Auth::user()->profile->avatar) }}"
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
        <a class="text-black w-20 text-decoration-none mt-2" href="{{ route('auth.logout') }}">Logout</a>
        <div class="dropdown mt-2 ms-2">
            <div class="btn dropdown-toggle p-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell"></i> Thông báo ({{ $notifications->count() }})
            </div>
            <ul style="width: 100%;" class="dropdown-menu" data-spy="scroll"  data-offset="0">
                @if (!empty($notifications) && $notifications->count() > 0)
                    @foreach ($notifications as $noti)
                        @if ($noti->action == "accept")
                        <li class="border-bottom p-2">
                            <a class="text text-black text-decoration-none" href="{{ route("relations.myfriend") }}"> {{ $noti->data }} </a>
                        </li>
                        @elseif($noti->action == "require")
                        <li class="border-bottom p-2">
                            <a class="text text-black text-decoration-none" href="{{ route("relations.get_requests") }}"> {{ $noti->data  }} </a>
                        </li>
                        @elseif($noti->action == "comment" || $noti->action == "like")
                        <li class="border-bottom p-2">
                            @if(!empty($noti->idPost) && $noti->idPost->user_id == $noti->user_id_from)
                            <a class="text text-black text-decoration-none" href="{{ route("posts.show", ["post" => $noti->idPost->id ]) }}"> {{ $noti->data }} </a>
                            @endif
                        </li>
                        @else
                        <li class="border-bottom p-2">
                                <a class="text text-black text-decoration-none"> {{ $noti->data }} </a>
                            </li>
                        @endif
                    @endforeach
                @else
                <li>
                    No Notification
                </li>
                @endif
            </ul>
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
