<div class="navbar navbar-sm navbar-footer sticky-bottom" style="background: rgba(0, 0, 0, 0)" id="chatContent">
    <div class="container-fluid">
        <span></span>

        <ul class="nav">
            <li class="nav-item">
                <div class="card float-end w-100 w-lg-100 chatbox" id="chatbox-<?=$data[0]['user_id']?>" style="display:none">
                    <div class="card-header text-white" style="background: #095C00">
                        <h5 class="mb-0">
                            <?=($data[0]['student_name'] !== NULL) ? $data[0]['student_name'] : (($data[0]['partner_name'] !== NULL) ? $data[0]['partner_name'] : 'Admin')?>
                            <button type="button" class="btn btn-sm float-end fs-1 text-white rounded-pill chatBoxHide" data-popup="popup-<?=$data[0]['user_id']?>"><i class="ph ph-x"></i></button>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="media-chat-scrollable mb-3" style="height: 300px">
                            <div class="media-chat vstack gap-2" id="messages<?=$data[0]['user_id']?>">

                            <?php foreach($chat as $x): ?>
                                <?php if($x['chat_from'] == $_SESSION['user_id']): ?>
                                    <?php if($x['chat_attachments'] !== NULL && $x['chat_message'] == NULL): ?>
                                        <?php $file = in_array($extension = strtolower(pathinfo($x['chat_attachments'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']) ? '<img src="/'.$x['chat_attachments'].'" class="img-fluid"/>' : '<a href="/'.$x['chat_attachments'].'" class="text-decoration-none text-white"><i class="ph ph-paperclip me-2"></i> Attachment</a>';?>
                                        <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                            <div>
                                                <div class="text-break media-chat-message">
                                                    <div class="fs-sm lh-sm">
                                                        <span class="fw-semibold">Me</span>
                                                    </div>
                                                    <?=$file?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif($x['chat_attachments'] == NULL && $x['chat_message'] !== NULL):?>
                                        <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                            <div>
                                                <div class="text-break media-chat-message">
                                                    <div class="fs-sm lh-sm">
                                                        <span class="fw-semibold">Me</span>
                                                    </div>
                                                    <?=$x['chat_message']?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                            <div>
                                                <div class="text-break media-chat-message">
                                                    <div class="fs-sm lh-sm">
                                                        <span class="fw-semibold">Me</span>
                                                    </div>
                                                    <?=$x['chat_message']?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $file = in_array($extension = strtolower(pathinfo($x['chat_attachments'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']) ? '<img src="/'.$x['chat_attachments'].'" class="img-fluid"/>' : '<a href="/'.$x['chat_attachments'].'" class="text-decoration-none text-white"><i class="ph ph-paperclip me-2"></i> Attachment</a>';?>
                                        <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                            <div>
                                                <div class="text-break media-chat-message">
                                                    <div class="fs-sm lh-sm">
                                                        <span class="fw-semibold">Me</span>
                                                    </div>
                                                    <?=$file?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="media-chat-item hstack align-items-start gap-3">
                                        <div>
                                            <div class="text-break media-chat-message">
                                                <div class="fs-sm lh-sm">
                                                    <span class="fw-semibold"><?=($data[0]['student_name'] !== NULL) ? $data[0]['student_name'] : (($data[0]['partner_name'] !== NULL) ? $data[0]['partner_name'] : 'Admin')?></span>
                                                </div>
                                                <?=$x['chat_message']?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($x['chat_attachments'] !== NULL && $x['chat_message'] == NULL): ?>
                                        <?php $file = in_array($extension = strtolower(pathinfo($x['chat_attachments'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']) ? '<img src="/'.$x['chat_attachments'].'" class="img-fluid"/>' : '<a href="/'.$x['chat_attachments'].'" class="text-decoration-none text-white"><i class="ph ph-paperclip me-2"></i> Attachment</a>';?>
                                        <div class="media-chat-item hstack align-items-start gap-3">
                                            <div>
                                                <div class="text-break media-chat-message">
                                                    <div class="fs-sm lh-sm">
                                                        <span class="fw-semibold"><?=($data[0]['student_name'] !== NULL) ? $data[0]['student_name'] : (($data[0]['partner_name'] !== NULL) ? $data[0]['partner_name'] : 'Admin')?></span>
                                                    </div>
                                                    <?=$file?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif($x['chat_attachments'] == NULL && $x['chat_message'] !== NULL):?>
                                        <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                            <div>
                                                <div class="text-break media-chat-message">
                                                    <div class="fs-sm lh-sm">
                                                        <span class="fw-semibold">Me</span>
                                                    </div>
                                                    <?=$x['chat_message']?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                            <div>
                                                <div class="text-break media-chat-message">
                                                    <div class="fs-sm lh-sm">
                                                        <span class="fw-semibold">Me</span>
                                                    </div>
                                                    <?=$x['chat_message']?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $file = in_array($extension = strtolower(pathinfo($x['chat_attachments'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']) ? '<img src="/'.$x['chat_attachments'].'" class="img-fluid"/>' : '<a href="/'.$x['chat_attachments'].'" class="text-decoration-none text-white"><i class="ph ph-paperclip me-2"></i> Attachment</a>';?>
                                        <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                            <div>
                                                <div class="text-break media-chat-message">
                                                    <div class="fs-sm lh-sm">
                                                        <span class="fw-semibold">Me</span>
                                                    </div>
                                                    <?=$file?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                                
                            </div>
                        </div>

                        <div class="form-control form-control-content mb-3" contenteditable="" data-placeholder="Type message here..." id="chat_message"></div>
                        <div class="d-flex align-items-center">
                            <div>
                                <label class="btn btn-light btn-icon border-transparent rounded-pill btn-sm me-1" data-bs-popup="tooltip" aria-label="Send file" data-bs-original-title="Send file" for="chat_attachments">
                                    <i class="ph-paperclip"></i>
                                </label>
                                <input type="file" id="chat_attachments" name="chat_attachments" class="d-none"/>
                                <span class="alert alert-success me-2" id="fileName" style="display: none"></span>
                            </div>

                            <button type="button" class="btn btn-primary ms-auto" id="sendBtn" data-user-id="<?=$data[0]['user_id']?>">
                                Send
                                <i class="ph-paper-plane-tilt ms-2"></i>
                            </button>
                        </div>

                    </div>
                </div>

                <button type="button" class="btn navbar-nav-link rounded text-white" style="background: #095C00" id="popup-<?=$data[0]['user_id']?>" data-chatbox="chatbox-<?=$data[0]['user_id']?>">
                    <div class="d-flex align-items-center mx-md-1">
                        <span class="d-md-inline-block"><?=($data[0]['student_name'] !== NULL) ? $data[0]['student_name'] : (($data[0]['partner_name'] !== NULL) ? $data[0]['partner_name'] : 'Admin')?> </span>
                    </div>
                </button>

            </li>
        </ul>
    </div>
    <script>
        var pusher1 = new Pusher('faac39db04715651483d', {
            cluster: 'ap1'
        });
        var new_message = pusher1.subscribe('new_message-<?=$_SESSION['user_id']?>');
        
        new_message.bind('update', function(data) {
            if(data.message == '' && data.attachment != '') {
                if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'].includes(data.attachment.split('.').pop().toLowerCase())) {
                    var file = `<img src="/${data.attachment}" class="img-fluid"/>`;
                } else {
                    var file = `<a href="/${data.attachment}" class="text-decoration-none text-black"><i class="ph ph-paperclip me-2"></i> Attachment</a>`;
                }
                var html = `
                <div class="media-chat-item hstack align-items-start gap-3">
                    <div>
                        <div class="text-break media-chat-message">
                            <div class="fs-sm lh-sm">
                                <span class="fw-semibold">${data.name}</span>
                            </div>
                            ${file}
                        </div>
                    </div>
                </div>
                `;
            } else if(data.attachment == '' && data.message != '') {
                var html = `
                <div class="media-chat-item hstack align-items-start gap-3">
                    <div>
                        <div class="text-break media-chat-message">
                            <div class="fs-sm lh-sm">
                                <span class="fw-semibold">${data.name}</span>
                            </div>
                            ${data.message}
                        </div>
                    </div>
                </div>
                `;
            } else {
                if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'].includes(data.attachment.split('.').pop().toLowerCase())) {
                    var file = `<img src="/${data.attachment}" class="img-fluid"/>`;
                } else {
                    var file = `<a href="/${data.attachment}" class="text-decoration-none text-black"><i class="ph ph-paperclip me-2"></i> Attachment</a>`;
                }
                var html = `
                <div class="media-chat-item hstack align-items-start gap-3">
                    <div>
                        <div class="text-break media-chat-message">
                            <div class="fs-sm lh-sm">
                                <span class="fw-semibold">${data.name}</span>
                            </div>
                            ${data.message}
                        </div>
                    </div>
                </div>
                <div class="media-chat-item hstack align-items-start gap-3">
                    <div>
                        <div class="text-break media-chat-message">
                            <div class="fs-sm lh-sm">
                                <span class="fw-semibold">${data.name}</span>
                            </div>
                            ${file}
                        </div>
                    </div>
                </div>
                `;
            }
            $("#messages" + data.from).append(html);
        });

        function deleteFile() {
            $("#fileName").fadeOut();
            $("#fileName").html('');
            $("#chat_attachments").val('');
        }

        $("#chat_attachments").on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            if (fileName.length > 15) {
                fileName = fileName.substring(0, 15) + "...";
            }
            $("#fileName").fadeIn();
            $("#fileName").html(fileName + `<i class="ph ph-x mw-5" onclick="deleteFile()"></i>`);
        });

        $("#popup-<?=$data[0]['user_id']?>").click(function() {
            $(this).fadeOut(0, function() {
                $("#" + $(this).data("chatbox")).fadeIn();
            });
        });

        $(".chatBoxHide").click(function() {
            var popup_id = $(this).data("popup");
            $(this).closest(".chatbox").fadeOut(0, function() {
                $("#" + popup_id).fadeIn();
            });
        });

        $('#chat_message').keypress(function(event) {
            if (event.which === 13 && !event.shiftKey && !event.ctrlKey && !event.altKey) {
                event.preventDefault(); 
                $("#sendBtn").trigger('click');
            }
        });

        $("#sendBtn").click(function() {
            var user_id = $(this).data("user-id");
            var chat_message = $("#chat_message").text();
            var fileInput = $('#chat_attachments')[0];

            if(chat_message != '' || fileInput.files.length > 0) {
                $(this).prop('disabled', true);
                var formData = new FormData();

                if (fileInput.files.length > 0) {
                    formData.append('chat_attachments', fileInput.files[0]);
                }

                formData.append('chat_from', <?=$_SESSION['user_id']?>);
                formData.append('chat_to', user_id);
                
                formData.append('chat_message', chat_message);

                $.ajax({
                    url: '/messages/send_message',
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log('pasok1');
                        if(chat_message == '' && data.attachment != '') {
                            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'].includes(data.attachment.split('.').pop().toLowerCase())) {
                                var file = `<img src="/${data.attachment}" class="img-fluid"/>`;
                            } else {
                                var file = `<a href="/${data.attachment}" class="text-decoration-none text-black"><i class="ph ph-paperclip me-2"></i> Attachment</a>`;
                            }
                            var html1 = `
                            <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                <div>
                                    <div class="text-break media-chat-message">
                                        <div class="fs-sm lh-sm">
                                            <span class="fw-semibold">Me</span>
                                        </div>
                                        ${file}
                                    </div>
                                </div>
                            </div>
                            `;
                        } else if(data.attachment == '' && chat_message != '') {
                            console.log('pasok2');
                            var html1 = `
                            <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                <div>
                                    <div class="text-break media-chat-message">
                                        <div class="fs-sm lh-sm">
                                            <span class="fw-semibold">Me</span>
                                        </div>
                                        ${chat_message}
                                    </div>
                                </div>
                            </div>
                            `;
                        } else {
                            console.log('pasok3');
                            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'].includes(data.attachment.split('.').pop().toLowerCase())) {
                                var file = `<img src="/${data.attachment}" class="img-fluid"/>`;
                            } else {
                                var file = `<a href="/${data.attachment}" class="text-decoration-none text-black"><i class="ph ph-paperclip me-2"></i> Attachment</a>`;
                            }
                            var html1 = `
                            <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                <div>
                                    <div class="text-break media-chat-message">
                                        <div class="fs-sm lh-sm">
                                            <span class="fw-semibold">Me</span>
                                        </div>
                                        ${chat_message}
                                    </div>
                                </div>
                            </div>
                            <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                <div>
                                    <div class="text-break media-chat-message">
                                        <div class="fs-sm lh-sm">
                                            <span class="fw-semibold">Me</span>
                                        </div>
                                        ${file}
                                    </div>
                                </div>
                            </div>
                            `;
                        }
                        $("#messages" + user_id).append(html1);
                        $("#chat_message").text('');
                        deleteFile();
                        $("#sendBtn").prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                        $("#sendBtn").prop('disabled', false);
                    }
                });
            }
        });
    </script>
</div>