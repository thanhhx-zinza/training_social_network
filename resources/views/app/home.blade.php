@extends('app-layout.layout')

@section('title', 'Social Network')

@section('main')
<div id="home-content" class="pb-4">
    <div id="home-post"></div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var currentPage = 1
    var disable = false
    getFriendPosts(currentPage)

    $(window).scroll(function() {
        if (!disable) {
            let position = Math.floor($(document).innerHeight() - $(window).scrollTop() - $(window).innerHeight())
            if (position <= 0) {
                currentPage++
                getFriendPosts(currentPage)
                disable = true
            }
        }
    })

    function getFriendPosts(currentPage) {
        $.ajax({
            url: "{{ route('post.get_friend_posts') }}" + "?page=" + currentPage,
            type: 'GET',
            success: function(res) {
                if (res.message == null) {
                    $('#home-content #home-post').append(res)
                    disable = false
                }
            },
            error: function(request, error) {
                alert('false')
            }
        })
    }
})
</script>
@endsection
