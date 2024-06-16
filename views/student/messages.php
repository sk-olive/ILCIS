<div class="sidebar sidebar-end sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Header -->
        <div class="sidebar-section sidebar-section-body d-flex align-items-center d-lg-none pb-2">
            <h5 class="mb-0">Messages</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-end-toggle">
                    <i class="ph-x"></i>
                </button>
            </div>
        </div>
        <div class="sidebar-section sidebar-section-body d-flex align-items-center d-none d-lg-block pb-2">
            <h5 class="mb-0">Messages</h5>
        </div>
        <!-- /header -->


        <!-- Sidebar search -->
        <!-- <div class="sidebar-section">
            <div id="sidebar-search">
                <div class="sidebar-section-body">
                    <div class="form-control-feedback form-control-feedback-end">
                        <input type="search" class="form-control" placeholder="Search" id="messageSearch">
                        <div class="form-control-feedback-icon">
                            <i class="ph-magnifying-glass opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- /sidebar search -->

        <!-- Admins -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Administrators</span>
                <div class="ms-auto">
                    <a href="#sidebar-users" class="text-reset" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse show" id="sidebar-users">
                <div class="sidebar-section-body" id="administrators">
                    
                </div>
            </div>
        </div>
        <!-- /admins -->

    </div>
    <!-- /sidebar content -->

</div>
<script>
    var pusher = new Pusher('faac39db04715651483d', {
        cluster: 'ap1'
    });
    var new_message = pusher.subscribe('new_message-<?=$_SESSION['user_id']?>');

    new_message.bind('update', function(data) {
        var from = data.from;
        var chatBox = $(".chatbox[id='chatbox-"+from+"']");
        if(chatBox.length > 0) {
            if(chatBox.css('display') === 'none') {
                $("button[data-chatbox='chatbox-"+from+"']").trigger('click');
            }
        } else {
            var $existingElement = $('.openChatBox[data-user-id="'+from+'"]');
            if ($existingElement.length > 0) {
                $existingElement.trigger('click');
                if(chatBox.css('display') === 'none') {
                    $("button[data-chatbox='chatbox-"+from+"']").trigger('click');
                }
            }
        }
    });
    

    let adminHTML = '';
    function loadRecepients() {
        adminHTML = '';
        $('#administrators').html('');
        $.ajax({
            url: '/messages/student/recepients',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                for (let d of data.data) {
                    adminHTML += `
                        <div class="d-flex mb-3 openChatBox" data-user-id="${d.user_id}">
                            <span class="me-3">
                                <img src="/public/assets/images/user.png" width="36" height="36" class="rounded-pill" alt="">
                            </span>
                            <div class="flex-fill">
                                <span class="fw-semibold text-black">Admin</span>
                            </div>
                        </div>
                    `;
                }
                $('#administrators').html(adminHTML);
            }
        });
    }

    // function loadRecepients1(search) {
    //     adminHTML = '';
    //     $('#administrators').html('');
    //     $.ajax({
    //         url: '/messages/student/recepients/search',
    //         method: 'POST',
    //         data: {
    //             search: search
    //         },
    //         dataType: 'json',
    //         success: function(data) {
    //             for (let d of data.data) {
    //                 adminHTML += `
    //                     <div class="d-flex mb-3 openChatBox" data-user-id="${d.user_id}">
    //                         <span class="me-3">
    //                             <img src="/public/assets/images/user.png" width="36" height="36" class="rounded-pill" alt="">
    //                         </span>
    //                         <div class="flex-fill">
    //                             <span class="fw-semibold text-black">Admin</span>
    //                         </div>
    //                     </div>
    //                 `;
    //             }
    //             $('#administrators').html(adminHTML);
    //         }
    //     });
    // }

    // $("#messageSearch").on('input', function(){
    //     if($(this).val() == '') {
    //         loadRecepients();
    //     } else {
    //         loadRecepients1($(this).val());
    //     }
    // });

    $(document).on('click', '.openChatBox', function() {
        var user_id = $(this).data("user-id");
        if ($('#chatContent').length) {
            $('#chatContent').remove();
        }
        $.ajax({
            url: '/message/getRecepient/' + user_id,
            method: 'GET',
            success: function(data) {
                $(".content").after(data);
            }
        });
    });

    $(document).ready(function() {
        loadRecepients();
    });
</script>