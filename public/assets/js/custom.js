/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */
const swalInit = swal.mixin({
    buttonsStyling: false,
    customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-light',
        denyButton: 'btn btn-light',
        input: 'form-control',
        popup: 'custom-width'
    },
});

const swalInit1 = swal.mixin({
    buttonsStyling: false,
    customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-light',
        denyButton: 'btn btn-light',
        input: 'form-control',
        popup: 'customSwal'
    },
});

$.extend($.fn.dataTable.defaults, {
    autoWidth: false,
    columnDefs: [{ 
        orderable: false,
        width: 100
    }],
    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    language: {
        search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
        searchPlaceholder: 'Type to filter...',
        lengthMenu: '<span class="me-3">Show:</span> _MENU_',
        paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
    }
});

$(document).ready(function() {
    $("#confirm_password, #user_password").on('input', function(){
        var password = $('#user_password').val();
        var confirmPassword = $('#confirm_password').val();
        var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&.])[A-Za-z\d@$!%*#?&.]{8,}$/;

        if (!regex.test(password)) {
            $("#registerBtn").prop("disabled", true);
            $('#user_password').removeClass('is-valid').addClass('is-invalid');
            $('#passwordHelp').text('Password must be at least 8 characters long and include at least one letter, one number, and one special character.').addClass('text-danger');
        } else {
            $('#user_password').removeClass('is-invalid').addClass('is-valid');
            $('#passwordHelp').text('').removeClass('text-danger');
        }

        if (password !== confirmPassword || password === '' || !regex.test(password)) {
            $("#registerBtn").prop("disabled", true);
            $('#confirm_password').removeClass('is-valid').addClass('is-invalid');
        } else {
            $("#registerBtn").prop("disabled", false);
            $('#confirm_password').removeClass('is-invalid').addClass('is-valid');
        }
        
    });

    $('#partner_telephone').on('input', function() {
        var telephone = $(this).val();
        var regex = /^\d{3}-\d{4}-\d{4}$/;

        if (!regex.test(telephone)) {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $(".registerBtn1").prop("disabled", true);
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(".registerBtn1").prop("disabled", false);
        }
    });

    $('#partner_contact').on('input', function() {
        var contact = $(this).val();
        var regex = /^09\d{9}$/;

        if (!regex.test(contact)) {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $(".registerBtn1").prop("disabled", true);
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(".registerBtn1").prop("disabled", false);
        }
    });

    $('#user_email').on('input', function() {
        var email = $(this).val();
        var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!regex.test(email)) {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $("#registerBtnS").prop("disabled", true);
            $(".registerBtn1").prop("disabled", true);
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $("#registerBtnS").prop("disabled", false);
            $(".registerBtn1").prop("disabled", false);
        }
    });

});