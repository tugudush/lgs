console.log('loaded functions.js');

$(document).ready(function () {
    //js_paths();
    login();
    guest_login();
    register();
    change_password();
    date_time_picker();
    filter_status();
    highlight_search();
    submit_log();
    prevent_number_key();
    submit_book();
    submit_student();
    edit_log();    
    edit_book();
    borrow_book();
    student_profile_link();
    edit_student();
    save_log();
    save_book();
    save_student();
    confirm_delete_log();
    confirm_delete_book();
    confirm_delete_student();
    profile_penalties();
    reports();
    print();

    function login() {

        $('#page-login #submit').on('click', function () {
            verify();
        }); // end of $('#page-login #submit').on('click', function()

        $('#page-login #username, #page-login #password').bind('enterKey', function (e) {
            verify();
        }); // end of $('#page-login #username, #page-login #password').bind('enterKey', function(e)

        $('#page-login #username, #page-login #password').keyup(function (e) {
            if (e.keyCode == 13) {
                $(this).trigger("enterKey");
            }
        }); // end of $('#page-login #username, #page-login #password').keyup(function(e)

    } // end of function login()

    function verify() {
        var username = $('#username').val();
        var password = $('#password').val();

        $.post('controller/login-verification.inc.php', {
            username: username,
            password: password
        }, function (response) {
            console.log(response);
            var response_obj = $.parseJSON(response);

            if (response_obj.hasOwnProperty('verified')) {

                var num_users = response_obj.num_users;
                var verified = response_obj.verified;
                var user_role = response_obj.user_role;

                if (num_users == 1 && verified == true) {
                    $('#page-login .message').text('Log-in Successfully!');
                    setTimeout(function () {
                        if (user_role == 'admin') {
                            window.location = 'index.php';
                        } // end of if (user_role == 'admin')
                        else {
                            window.location = 'books.php';
                        }

                    }, 1000);
                } // end of if (num_users == 1 && verified == true)
                else {
                    $('#page-login .message').text('Incorrect username or password!');
                }

            } // end of if (response_obj.hasOwnProperty('verified')) {
            else {
                console.log('Please check "controller/login-verification.inc.php"');
            }

        }); // end of $.post('controller/login-verification.inc.php', {

    } // end of function verify()

    function guest_login() {
        $("#guest-login").change(function () {
            if (this.checked) {
                $('#username').val('guest');
                $('#password').val('test123');
                $('#username').prop('disabled', true);
                $('#password').prop('disabled', true);
            } // end of if(this.checked)
            else {
                $('#username').val('');
                $('#password').val('');
                $('#username').prop('disabled', false);
                $('#password').prop('disabled', false);
            }
        }); // end of $("#guest-login").change(function()
    } // end of function guest_login()
    
    function register() {
        check_username_duplicate();
        validate_name();
        $('#register-form').submit(function(e) {
            e.preventDefault();
            var data = $('#register-form').serialize();
            $.post('controller/register.inc.php', data, function(response) {
                console.log(response);
                var response_obj = $.parseJSON(response);
                var student_on_db = response_obj.student_on_db;
                var is_success = response_obj.is_success;
                var message = response_obj.message;
                console.log('student_on_db: '+student_on_db);
                console.log('is_success: '+is_success);
                $('#register-form .message').text(message);
                if (is_success) {                    
                    setTimeout(function() {
                        window.location = 'login.php';
                    }, 2000);
                } // end of if (is_success)
            }); // end of $.post('controller/register.inc.php', data, function(response) {
        }); // end of $('#register-form').submit(function(e)
    } // end of function register()
    
    function check_username_duplicate() {
        $('#register-form #username').on('change', function() {
            var username = $(this).val();
            check_username_duplicate_process(username);
        }); // end of $('#register-form #username').on('change', function()
        
        $('#register-form #username').on('keyup', function() {
            var username = $(this).val();
            check_username_duplicate_process(username);
        }); // end of $('#register-form #username').on('keyup', function()
    } // end of function check_username_duplicate()
    
    function check_username_duplicate_process(username) {
        $.post('controller/check-username-duplicate.inc.php', {
            username: username
        }, function(response) {
            console.log(response);
            var response_obj = $.parseJSON(response);
            var has_duplicate = response_obj.has_duplicate;
            
            if (has_duplicate) {
                $('#register-form #username')[0].setCustomValidity('This ID has already been registered.');
            } // end of if (has_duplicate)
            else {
                $('#register-form #username')[0].setCustomValidity('');
            }
        }); // end of $.post('controller/check-username-duplicate.inc.php', {
    } // end of function check_username_duplicate_process(username)
    
    function validate_name() {
        $('input#fname').on('change', function() {
            var fname = $(this).val();
            validate_fname_process(fname)
        }); // end of $('input#fname').on('change', function() {
        
        $('input#fname').on('keyup', function() {
            var fname = $(this).val();
            validate_fname_process(fname)
        }); // end of $('input#fname').on('keyup', function() {
        
        $('input#mname').on('change', function() {
            var mname = $(this).val();
            validate_mname_process(mname)
        }); // end of  $('input#mname').on('change', function() {
        
        $('input#mname').on('keyup', function() {
            var mname = $(this).val();
            validate_mname_process(mname)
        }); // end of $('input#mname').on('keyup', function() {
        
         $('input#lname').on('change', function() {
            var lname = $(this).val();
            validate_lname_process(lname)
        }); // end of $('input#lname').on('change', function() {
        
        $('input#lname').on('keyup', function() {
            var lname = $(this).val();
            validate_lname_process(lname)
        }); // end of $('input#lname').on('keyup', function() {
        
        $('input#genre').on('keyup', function() {
            var genre = $(this).val();
            validate_genre_process(genre)
        }); // end of $('input#genre').on('keyup', function() {
        
        $('input#genre').on('change', function() {
            var genre = $(this).val();
            validate_genre_process(genre)
        }); // end of $('input#genre').on('change', function() {
    } // end of function name_validator()
    
    function validate_fname_process(fname) {
        var valid_fname = valid_name(fname);
        if (valid_fname) {
            console.log('Valid fname');
            $('input#fname')[0].setCustomValidity('')
        }
        else {
            console.log('Invalid fname');
            $('input#fname')[0].setCustomValidity('Invalid name!')
        }
    } // end of function validate_fname_process(fname)
    
    function validate_mname_process(mname) {
        var valid_mname = valid_name(mname);
        if (valid_mname) {
            console.log('Valid mname');
            $('input#mname')[0].setCustomValidity('')
        }
        else {
            console.log('Invalid mname');
            $('input#mname')[0].setCustomValidity('Invalid name!')
        }
    } // end of function validate_fname_process(fname)
    
    function validate_lname_process(lname) {
        var valid_lname = valid_name(lname);
        if (valid_lname) {
            console.log('Valid lname');
            $('input#lname')[0].setCustomValidity('')
        }
        else {
            console.log('Invalid lname');
            $('input#lname')[0].setCustomValidity('Invalid name!')
        }
    } // end of function validate_fname_process(fname)
    
    function validate_genre_process(genre) {
        var valid_genre = valid_name(genre);
        if (valid_genre) {
            console.log('Valid category name.');
            $('input#genre')[0].setCustomValidity('')
        }
        else {
            console.log('Invalid category name!');
            $('input#genre')[0].setCustomValidity('Invalid category name!')
        }
    } // end of function validate_fname_process(fname)
    
    function valid_name(name) {
        if (name.match('^[a-zA-Z\u00E0-\u00FC]*$')) {
            return true;
        } else {            
            return false;
        }
    } // end of function validate_name_process(name)
    
    function change_password() {
        $('#change-password').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();            
            $.post('controller/change-password.inc.php', data, function(response) {
                console.log(response);
                var response_obj = $.parseJSON(response);
                var message = response_obj.message;
                $('#change-password-message').text(message);
            }); // end of $.post('controller/change-password', data, function(response) {
        }); // end of $('#change-password').submit(function(e)
    } // end of function change_password()

    function date_time_picker() {
        $('.date-time-picker').datetimepicker();
        $('.date-picker').datetimepicker({
            timepicker: false,
            format: 'Y/m/d'
        });
    } // end of function date_time_picker()

    function filter_status() {
        $('#filter-status').change(function () {
            var status = $(this).val();
            var search = getUrlParameter('search') || '';
            var page = getUrlParameter('page') || '1';
            window.location = document.location.pathname + '?search=' + search + '&page=' + page + '&status=' + status;
        }); // end of $('#filter-status').change(function()
    } // end of function filter_status()

    function highlight_search() {
        var keyword = getUrlParameter('search');

        if ($('#logs').length) {
            if (keyword) {
                $('.id-no, .title, .name, .borrowed-datetime, .returned-datetime').highlight(keyword);
            } // end of if (keyword)
        } // end of if ($('#logs, #books').length)

        if ($('#books').length) {
            if (keyword) {
                $('.title, .author, .genre, .year, .isbn').highlight(keyword);
            } // end of if (keyword)
        } // end of if ($('#logs, #books').length)

        if ($('#students').length) {
            if (keyword) {
                $('.id-no, .fname, .lname, .course').highlight(keyword);
            } // end of if (keyword)
        } // end of if ($('#logs, #books').length)

    } // end of function highlight_search()

    function verify_student() {
        $('#add-log #id-no').on('change', function () {
            var id_no = $(this).val();
            //delay(function () {
            verify_student_process(id_no);
            //}, 500);
        }); // end of $('#add-log #id-no').on('change', function()

        $('#add-log #id-no').on('keyup', function () {
            var id_no = $(this).val();
            //delay(function () {
            verify_student_process(id_no);
            //}, 500);

        }); // end of $('#add-log #id-no').on('change', function()
    } // end of function verify_student()

    function check_id_no_duplicate() {
        $('#add-student #id-no').on('keyup', function () {
            var id_no = $(this).val();
            //delay(function () {
            check_id_no_duplicate_process(id_no);
            //}, 500);
        }); // end of $('#add-log #id-no').on('change', function()

        $('#add-student #id-no').on('change', function () {
            var id_no = $(this).val();
            //delay(function () {
            check_id_no_duplicate_process(id_no);
            //}, 500);
        }); // end of $('#add-log #id-no').on('change', function()
    } // end of function check_idno_duplicate()

    function verify_student_process(id_no) {
        $.post('controller/verify-student.inc.php', {
            id_no: id_no
        }, function (response) {
            //console.log(response);
            var response_obj = $.parseJSON(response);
            var student_id = response_obj.student_id;
            var is_verified = response_obj.is_verified;
            var name = response_obj.name;
            var course = response_obj.course;
            var college = response_obj.college;
            //console.log('is_verified: '+is_verified);

            if (!is_verified) {
                $('#add-log #id-no')[0].setCustomValidity('No student record found!');
                $('#preview-student-name').text('');
                $('#preview-student-course').text('');
                $('#preview-student-college').text('');
            } // end of if (!is_verified)
            else {
                $('#student-id').val(student_id);
                $('#preview-student-name').text(name);
                $('#preview-student-course').text(course);
                $('#preview-student-college').text(college);

                $.post('controller/check-penalties.inc.php', {
                    student_id: student_id
                }, function (response) {
                    console.log(response);
                    var response_obj = $.parseJSON(response);
                    var has_penalty = response_obj.has_penalty;
                    console.log('has_penalty: ' + has_penalty);
                    if (has_penalty) {
                        $('#add-log #id-no')[0].setCustomValidity('This student has unpaid penalty!');
                    } // end of if (has_penalty)
                    else {
                        $('#add-log #id-no')[0].setCustomValidity('');
                    } // end of else if (!has_penalty) {
                }); // end of $.post('controller/check-penalties.inc.php',{                
            } // end of else if (is_verified)
        });
    } // end of function verify_student_process(id_no)

    function check_id_no_duplicate_process(id_no) {
        $.post('controller/check-id-no-duplicate.inc.php', {
            id_no: id_no
        }, function (response) {
            console.log(response);
            var response_obj = $.parseJSON(response);
            var has_duplicate = response_obj.has_duplicate;
            var name = response_obj.name;
            console.log('has_duplicate: ' + true);
            console.log('name: ' + name);

            if (has_duplicate) {
                $('#add-student #id-no')[0].setCustomValidity('ID No. already taken by ' + name + '!');
            } // end of if (has_duplicate)
            else {
                $('#add-student #id-no')[0].setCustomValidity('');
            }
        }); // end of $.post('controller/check-id-no-duplicate.inc.php', {
    } // end of function check_idno_duplicate_process()

    function search_book() {
        $('#search-book').on('keyup', function () {
            var keyword = $(this).val();

            delay(function () {
                search_book_process(keyword);
            }, 500);

        }); // end of $('#search-book').on('keyup', function()

        $('#search-book').on('change', function () {

        }); // end of $('#search-book').on('change', function()
    } // end of function search_book()

    function search_book_process(keyword) {
        $('#search-book-results tr:not(.heading)').remove();
        if (keyword.length >= 2) {
            $.post('controller/search-book.inc.php', {
                keyword: keyword
            }, function (response) {
                //console.log(response);
                var response_obj = $.parseJSON(response);

                var keyword = response_obj.keyword;
                //console.log('keyword: '+keyword);

                var num_books = response_obj.num_books;
                //console.log('num_books: '+num_books);

                if (num_books >= 1) {
                    $('#search-book-results').show();
                    var row = response_obj.row;

                    $.each(row, function (i, object) {

                        //console.log('row: '+i);
                        $('#search-book-results').append('<tr class="row-' + i + '"></tr>');
                        $.each(object, function (property, value) {

                            var display_value = value;
                            if (value == null) {
                                display_value = '';
                            }

                            if (property == 'book_id') {
                                $('.row-' + i).attr('id', 'book-id-' + display_value);
                            } // end of if (property == 'book_id')
                            else {
                                $('.row-' + i).append('<td class="' + property + '">' + display_value + '</td>');
                            }

                        });
                    }); // end of $.each(row, function(i, object)

                    $('#search-book-results tr td').highlight(keyword);
                } // end of if (num_books >= 1)

            }); // end of $.post('controller/search-book.inc.php', {keyword: keyword}, function(response)
        } // end of if (keyword.length >= 3)
    } // end of function search_book_process(keyword)

    function select_book() {
        $('#search-book-results').on('click', 'tr:not(.heading)', function (e) {

            var book_id_string = $(this).attr('id');
            var bookd_id_split = book_id_string.split('-');
            var book_id = bookd_id_split[2]
            var title = $(this).find('td.title').text();
            var author = $(this).find('td.author').text();
            var genre = $(this).find('td.genre').text();
            var year = $(this).find('td.year').text();
            var isbn = $(this).find('td.isbn').text();
            var qty = $(this).find('td.qty').text();
            //console.log('book_id: '+book_id);

            if (qty >= 1) {
                $('#book-id').val(book_id);
                $('#search-book').val(title);
                //$('#preview-book-id').text(book_id);
                $('#preview-book-id').text(book_id);
                $('#preview-book-title').text(title);
                $('#preview-book-author').text(author);
                $('#preview-book-genre').text(genre);
                $('#preview-book-year').text(year);
                $('#preview-book-isbn').text(isbn);
            } // end of if ( qty >= 1)
            else {
                //$('.message').text('No more copies on shelf!');
                alert('No more copies on shelf!');
            } // end of else if (qty == 0)

        });
    } // end of function select_book()    

    function get_current_datetime() {
        var today = new Date();
        var date = today.getFullYear() + '-' + zero_prefix((today.getMonth() + 1)) + '-' + zero_prefix(today.getDate());
        var time = zero_prefix(today.getHours()) + ":" + zero_prefix(today.getMinutes());
        var dateTime = date + ' ' + time;
        return dateTime;
    } // end of function get_current_datetime()

    function get_current_seconds() {
        var now = new Date(Date.now());
        //console.log('now: '+now);
        //var current_seconds = now.getSeconds();
        var current_seconds = 0;
        current_seconds = zero_prefix(current_seconds);
        //console.log('current seconds: '+current_seconds);
        return current_seconds;
    } // end of function get_current_seconds()

    function zero_prefix(current_seconds) {
        current_seconds = ('0' + current_seconds).slice(-2);
        return current_seconds;
    } // end of function zero_prefix(current_seconds)

    function submit_log() {
        verify_student();
        search_book();
        select_book();

        $('#add-log').submit(function (e) {
            var current_seconds = get_current_seconds();
            console.log('current_seconds: ' + current_seconds);

            var book_id = $('#book-id').val();
            $('#book-id').val(book_id);

            if ($('#book-id').val()) {
                var qty = $('#search-book-results').find('#book-id-'+book_id).find('.qty').text();
                qty = parseInt(qty);
                
                var data = $('#add-log').serializeArray();
                data.push({
                    name: 'current_seconds',
                    value: current_seconds
                });

                $.post('controller/insert-log.inc.php', data, function (response) {
                    //console.log(response);
                    var response_obj = $.parseJSON(response);
                    var message = response_obj.message;
                    $('.message').text(message);
                    var is_success = response_obj.is_success;
                    if (is_success) {                        
                        var new_qty = qty - 1;
                        $('#search-book-results').find('#book-id-'+book_id).find('.qty').text(new_qty);
                        //$('#add-log')[0].reset();
                        $('#book-id').val('');
                        $('#search-book').val('');
                        //$('#student-id').val('');
                        $('#log-preview #book-details span[id^="preview-book-"]').text('');
                    } // end of if (is_success)
                }); // end of $.pose('controller/insert-log.inc.php', data, function()
            } // end of if ($('#book-id').val())
            else {
                $('.message').text('Please select a book!');
            }

            return false;
        });
    } // end of function submit_log()

    function submit_student() {
        check_id_no_duplicate();
        validate_name();
        $('#add-student').submit(function (e) {
            e.preventDefault();
            var data = $('#add-student').serialize();
            $.post('controller/insert-student.inc.php', data, function (response) {
                console.log(response);
                var response_obj = $.parseJSON(response);
                var message = response_obj.message;
                var is_success = response_obj.is_success;
                $('.message').text(message);
                if (is_success) {
                    $('#add-student')[0].reset();
                } // end of if (is_success)
            }); // end of $.post('controller/add-student.inc.php', data, function(response)
        }); // end of $('#add-student').submit(function(e)
    } // end of function submit_student()

    function edit_log() {
        $('.edit-log').click(function (e) {
            e.preventDefault();
            $(this).parent().find('.fa').hide();
            $(this).parent().find('.save-log').show();
            $(this).parents('.log-row').find('.borrowed-datetime').hide(0);
            $(this).parents('.log-row').find('.input-borrowed-datetime').show(0);
            $(this).parents('.log-row').find('.returned-datetime').hide(0);
            $(this).parents('.log-row').find('.log-status').hide(0);
            $(this).parents('.log-row').find('.select-status').show(0);
            $(this).parents('.log-row').find('.paid').hide(0);
            $(this).parents('.log-row').find('.select-paid').show(0);
            
            var is_paid = $(this).parents('.log-row').find('.select-paid').val();
            is_paid = is_paid || 'no';
            console.log('is_paid: '+is_paid);
            
            var penalty = $(this).parents('.log-row').find('.col-penalty').text();
            penalty = parseInt(penalty) || 0;
            var has_penalty = false;
            if (penalty > 0) {
                has_penalty = true;
            }            
            console.log('has_penalty: '+has_penalty);
            
            if (has_penalty && is_paid == 'no') {
                $(this).parents('.log-row').find('.select-status option[value="returned"]').hide();
            } // end of if (has_penalty && is_paid == 'no')

            var select_status = $(this).parents('.log-row').find('.select-status').val();
            if (select_status == 'returned') {
                $(this).parents('.log-row').find('.input-returned-datetime').show();
            }
        }); // end of $('.edit-log').click(function(e)
        
        $('.select-paid').change(function() {
            var paid_value = $(this).val();
            if (paid_value == 'yes') {
                $(this).parents('.log-row').find('.select-status option[value="returned"]').show();
            } // end of if (paid_value == 'yes')
        }); // end of $('.select-paid').change(function()

        $('.select-status').change(function () {
            if ($(this).val() == 'returned') {
                var returned_datetime = $(this).parents('.log-row').find('.input-returned-datetime').val();

                if (returned_datetime == '' || returned_datetime == null) {
                    $(this).parents('.log-row').find('.input-returned-datetime').val(get_current_datetime());
                } // end of if (returned_datetime == '' || returned_datetime == null)

                $(this).parents('.log-row').find('.input-returned-datetime').show(0);
            } // end of if($(this).val() == 'returned')
            else {
                $(this).parents('.log-row').find('.input-returned-datetime').val('');
                $(this).parents('.log-row').find('.input-returned-datetime').hide(0);
            }
            console.log('select status: ' + $(this).val());
        });
    } // end of function edit_log()

    function edit_book() {
        $('.edit-book').click(function (e) {
            e.preventDefault();
            $(this).parent().find('.fa').hide();
            $(this).parent().find('.save-book').show();
            $(this).parents('.book-row').find('.row-col-data').hide(0);
            $(this).parents('.book-row').find('.form-control').show(0);
        }); // end of $('.edit-book').click(function(e)
    } // end of function edit_book()

    function borrow_book() {
        $('#page-books .borrow-book').click(function (e) {
            e.preventDefault();

            var book_id_string = $(this).parents('.book-row').attr('id');
            var book_id_string_split = book_id_string.split('-');
            var book_id = book_id_string_split[2];
            var qty = $(this).parents('.book-row').find('.qty').text();

            if (qty <= 0) {
                alert('No more copies left on the shelf!');
            } // end of if (qty <= 0)
            else {
                window.location = 'add-log.php?book_id=' + book_id;
            } // end of else if(qty > 0)
        }); // end of $('.borrow-book').click(function(e)

        $('#page-students .borrow-book').click(function (e) {
            e.preventDefault();
            var student_id_string = $(this).parents('.student-row').attr('id');
            var student_id_string_split = student_id_string.split('-');
            var student_id = student_id_string_split[2];
            var id_no = $(this).parents('.student-row').find('.id-no').text();
            var has_penalty = check_penalties(student_id, id_no, 'students');
            //console.log('has_penalty: '+has_penalty);
            //window.location = 'add-log.php?id_no='+id_no;
        }); // end of $('#page-students .borrow-book').click(function(e)
    } // end of function borrow_book()

    function check_penalties(student_id, id_no, from_page) {
        $.post('controller/check-penalties.inc.php', {
            student_id: student_id
        }, function (response) {
            console.log(response);
            var response_obj = $.parseJSON(response);
            var has_penalty = response_obj.has_penalty;
            console.log('has_penalty: ' + has_penalty);
            if (from_page == 'students') {
                if (has_penalty) {
                    alert('This student has unpaid penalty!');
                } // end of if (has_penalty)
                else {
                    window.location = 'add-log.php?id_no=' + id_no;
                }
            } // end of if (from_page == 'students')
        }); // end of $.post('controller/check-penalties.inc.php',{
    } // end of function check_penalties()
    
    function student_profile_link() {
        $('#logs .id-no, #logs .name, #students .id-no, #students .fname, #students .mname, #students .lname').css('cursor', 'pointer');
        $('#students .id-no, #students .fname, #students .mname, #students .lname').click(function(e) {
            e.preventDefault();
            var id_no = $(this).parents('.student-row').find('.id-no').text();
            window.location = 'student-profile.php?id_no='+id_no;
        }); // end of $('#students .fname, #students .mname, #students .lname').click(function(e)
        
        $('#logs .id-no, #logs .name').click(function(e) {
            e.preventDefault();
            var id_no = $(this).parents('.log-row').find('.id-no').text();
            window.location = 'student-profile.php?id_no='+id_no;
        }); // end of $('#logs .name').click(function(e)
    } // end of function student_profile_link()

    function edit_student() {
        $('.edit-student').click(function (e) {
            e.preventDefault();
            $(this).parent().find('.fa').hide();
            $(this).parent().find('.save-student').show();
            $(this).parents('.student-row').find('.row-col-data').hide(0);
            $(this).parents('.student-row').find('.form-control').show(0);
        }); // end of $('.edit-book').click(function(e)
    } // end of function edit_book()

    function save_log() {
        $('.save-log').click(function (e) {
            e.preventDefault();

            var log_id_string = $(this).parents('.log-row').attr('id');
            var log_id_string_split = log_id_string.split('-');
            var log_id = log_id_string_split[2];

            var book_id = $(this).parents('.log-row').find('.book-id').val();
            console.log('book_id: ' + book_id);

            $(this).hide();
            $(this).siblings().show();

            var borrowed_datetime = $(this).parents('.log-row').find('.input-borrowed-datetime').val();
            $(this).parents('.log-row').find('.borrowed-datetime').text(borrowed_datetime);
            $(this).parents('.log-row').find('.input-borrowed-datetime').hide(0);
            $(this).parents('.log-row').find('.borrowed-datetime').show(0);
            borrowed_datetime += ':' + zero_prefix(0);

            var returned_datetime = $(this).parents('.log-row').find('.input-returned-datetime').val();
            $(this).parents('.log-row').find('.returned-datetime').text(returned_datetime);
            $(this).parents('.log-row').find('.input-returned-datetime').hide(0);
            $(this).parents('.log-row').find('.returned-datetime').show(0);

            var paid = $(this).parents('.log-row').find('.select-paid').val();
            $(this).parents('.log-row').find('.paid').text(paid);
            $(this).parents('.log-row').find('.select-paid').hide(0);
            $(this).parents('.log-row').find('.paid').show(0);

            var current_status = $(this).parents('.log-row').find('.current-status').val();
            var new_status = $(this).parents('.log-row').find('.select-status').val();
            $(this).parents('.log-row').find('.log-status').text(new_status);
            $(this).parents('.log-row').find('.current-status').text(new_status);
            $(this).parents('.log-row').find('.select-status').hide(0);
            $(this).parents('.log-row').find('.log-status').show(0);

            if (new_status != 'returned') {
                returned_datetime = null;
                $(this).parents('.log-row').find('.returned-datetime').text('')
            } // end of if (status != 'returned')
            else {
                returned_datetime += ':' + get_current_seconds();
            }

            //console.log('select_status: '+status);

            $.post('controller/update-log.inc.php', {
                log_id: log_id,
                book_id: book_id,
                borrowed_datetime: borrowed_datetime,
                returned_datetime: returned_datetime,
                current_status: current_status,
                new_status: new_status,
                paid: paid
            }, function (response) {
                console.log(response);
                var response_obj = $.parseJSON(response);
                var is_success = response_obj.is_success;
                var rd_is_null = response_obj.rd_is_null;
                var paid_is_null = response_obj.paid_is_null;
                console.log('rd_is_null: ' + rd_is_null);
                console.log('paid_is_null: ' + paid_is_null);

                console.log('is_success' + is_success);
                if (is_success) {
                    var status = getUrlParameter('status') || '';
                    var search = getUrlParameter('search') || '';
                    var page = getUrlParameter('page') || '1';
                    window.location = document.location.pathname + '?search=' + search + '&page=' + page + '&status=' + status;
                } // end of if (is_success)
                else {
                    $('.message').text(message);
                }

            }); // end of $.post('controller/update-log.inc.php', {}, function()
        }); // end of $('.save-log').click(function(e)
    } // end of function save_log()

    function save_book() {
        $('.save-book').click(function (e) {
            e.preventDefault();

            var book_id_string = $(this).parents('.book-row').attr('id');
            var book_id_string_split = book_id_string.split('-');
            var book_id = book_id_string_split[2];

            var title = $(this).parents('.book-row').find('.input-title').val();
            var author = $(this).parents('.book-row').find('.input-author').val();
            var genre = $(this).parents('.book-row').find('.input-genre').val();
            var year = $(this).parents('.book-row').find('.input-year').val();
            var isbn = $(this).parents('.book-row').find('.input-isbn').val();
            var price = $(this).parents('.book-row').find('.input-price').val();
            var qty = $(this).parents('.book-row').find('.input-qty').val();

            $(this).parents('.book-row').find('.title').text(title);
            $(this).parents('.book-row').find('.author').text(author);
            $(this).parents('.book-row').find('.genre').text(genre);
            $(this).parents('.book-row').find('.year').text(year);
            $(this).parents('.book-row').find('.isbn').text(isbn);
            $(this).parents('.book-row').find('.price').text(price);
            $(this).parents('.book-row').find('.qty').text(qty);

            $(this).parents('.book-row').find('.form-control').hide(0);
            $(this).parents('.book-row').find('.row-col-data').show(0);

            $(this).hide(0);
            $(this).siblings().show(0);

            $.post('controller/update-book.inc.php', {
                book_id: book_id,
                title: title,
                author: author,
                genre: genre,
                year: year,
                isbn: isbn,
                price: price,
                qty: qty
            }, function (response) {
                console.log(response);
                var response_obj = $.parseJSON(response);
                var message = response_obj.message;
                $('.message').text(message);
            }); // end of $.post('controller/update-book.inc.php', {
        }); // end of $('.save-book').click(function(e)
    } // end of function save_book()

    function save_student() {
        $('.save-student').click(function (e) {
            e.preventDefault();

            var student_id_string = $(this).parents('.student-row').attr('id');
            var student_id_string_split = student_id_string.split('-');
            var student_id = student_id_string_split[2];

            var id_no = $(this).parents('.student-row').find('.input-id-no').val();
            var fname = $(this).parents('.student-row').find('.input-fname').val();
            var mname = $(this).parents('.student-row').find('.input-mname').val();
            var lname = $(this).parents('.student-row').find('.input-lname').val();
            var course = $(this).parents('.student-row').find('.select-course').val();

            $(this).parents('.student-row').find('.id-no').text(id_no);
            $(this).parents('.student-row').find('.fname').text(fname);
            $(this).parents('.student-row').find('.mname').text(mname);
            $(this).parents('.student-row').find('.lname').text(lname);
            $(this).parents('.student-row').find('.course').text(course);

            $(this).parents('.student-row').find('.form-control').hide(0);
            $(this).parents('.student-row').find('.row-col-data').show(0);

            $(this).hide(0);
            $(this).siblings().show(0);

            $.post('controller/update-student.inc.php', {
                student_id: student_id,
                id_no: id_no,
                fname: fname,
                mname: mname,
                lname: lname,
                course: course
            }, function (response) {
                console.log(response);
                var response_obj = $.parseJSON(response);
                var message = response_obj.message;
                $('.message').text(message);
            }); // end of $.post('controller/update-book.inc.php', {
        }); // end of $('.save-book').click(function(e)
    } // end of function save_student()

    function confirm_delete_log() {
        $('.delete-log').on('click', function (e) {
            e.preventDefault();
            var log_id_string = $(this).parents('.log-row').attr('id');
            var log_id_string_split = log_id_string.split('-');
            var log_id = log_id_string_split[2];
            //console.log('delete log id: '+log_id);

            $(this).parents('.log-row').css({
                'background-color': '#EAEAEA'
            });

            show_delete_dialog(log_id, 'delete_log', 'Confirm delete?');

        }) // end of $('.delete-product').on('click', function()
    } // end of function confirm_delete_log()

    function confirm_delete_book() {
        $('.delete-book').on('click', function (e) {
            e.preventDefault();
            var book_id_string = $(this).parents('.book-row').attr('id');
            var book_id_string_split = book_id_string.split('-');
            var book_id = book_id_string_split[2];

            $(this).parents('.book-row').css({
                'background-color': '#EAEAEA'
            });

            show_delete_dialog(book_id, 'delete_book', 'Confirm delete?');

        }) // end of $('.delete-product').on('click', function()
    } // end of function confirm_delete_log()

    function confirm_delete_student() {
        $('.delete-student').click(function (e) {
            e.preventDefault();
            var student_id_string = $(this).parents('.student-row').attr('id');
            var student_id_string_split = student_id_string.split('-');
            var student_id = student_id_string_split[2];
            var id_no = $(this).parents('.student-row').find('.id-no').text();

            $(this).parents('.student-row').css({
                'background-color': '#EAEAEA'
            });

            show_delete_dialog(id_no, 'delete_student', 'Confirm delete?');
        }); // end of $('.delete-student').click(function(e)
    } // end of function confirm_delete_student()

    function show_delete_dialog(id, operation, message) {

        $('.dialog').show(); // end of $('#dialog').show(0, function()
        $('.dialog').css('display', 'table');
        $('.dialog').find('.dialog-msg').text(message);

        $('.dialog').find('.btn-no').click(function (e) {
            e.preventDefault();
            $(this).parents('.dialog').hide();
            $('table tr').css('background-color', 'initial');

            var page = getUrlParameter('page');

            var status = getUrlParameter('status') || '';
            var search = getUrlParameter('search') || '';
            var page = getUrlParameter('page') || '1';

            if ($('#page-logs').length) {
                window.location = document.location.pathname + '?search=' + search + '&page=' + page + '&status=' + status;
            } // end of if ($('#page-logs').length)
            else {
                window.location = document.location.pathname + '?search=' + search + '&page=' + page;
            }

        }); // end of $(this).find('.btn-no').click(function(e)

        $('.dialog').find('.btn-yes').click(function (e) {
            e.preventDefault();
            $(this).parents('.dialog').hide();
            $('table tr').css('background-color', 'initial');
            window[operation](id);
        }); // end of $(this).find('.btn-yes').click(function(e)   

    } // end of function show_dialog(id, operation, message)    

    delete_log = function (log_id) {

        $.post('controller/delete-log.inc.php', {
            log_id: log_id
        }, function (response) {
            //console.log(response);
            var response_obj = $.parseJSON(response);
            var is_success = response_obj.is_success;
            var message = response_obj.message;

            if (is_success) {
                var status = getUrlParameter('status') || '';
                var search = getUrlParameter('search') || '';
                var page = getUrlParameter('page') || '1';
                window.location = document.location.pathname + '?search=' + search + '&page=' + page + '&status=' + status;

            } // end of if (response_obj.hasOwnProperty('is_success'))
            else {
                $('.message').text(message);
            }

        }); // end of $.post('controller/delete-product.inc.php', {

    } // end of delete_log = function()

    delete_book = function (book_id) {

        $.post('controller/delete-book.inc.php', {
            book_id: book_id
        }, function (response) {
            console.log(response);
            var response_obj = $.parseJSON(response);
            var is_success = response_obj.is_success;
            var message = response_obj.message;

            if (is_success) {
                var search = getUrlParameter('search') || '';
                var page = getUrlParameter('page') || '1';
                window.location = document.location.pathname + '?search=' + search + '&page=' + page;

            } // end of if (response_obj.hasOwnProperty('is_success'))
            else {
                $('.message').text(message);
            }

        }); // end of $.post('controller/delete-product.inc.php', {

    } // end of delete_log = function()

    delete_student = function (id_no) {
        $.post('controller/delete-student.inc.php', {
            id_no: id_no
        }, function (response) {
            console.log(response);
            var response_obj = $.parseJSON(response);
            var is_success = response_obj.is_success;
            var message = response_obj.message;

            if (is_success) {
                var search = getUrlParameter('search') || '';
                var page = getUrlParameter('page') || '1';
                window.location = document.location.pathname + '?search=' + search + '&page=' + page;

            } // end of if (response_obj.hasOwnProperty('is_success'))
            else {
                $('.message').text(message);
            }

        }); // end of $.post('controller/delete-product.inc.php', {

    } // end of delete_student = function()
    

function prevent_number_key() {
        $('#page-add-book #genre, #author').keypress(function (e) {            
            e = e || window.event;
            var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
            var charStr = String.fromCharCode(charCode);
            if (/\d/.test(charStr)) {
                e.preventDefault();
            }
        
        }); // end of $('#page-login #username, #page-login #password').keyup(function(e)
          
            $('#page-add-book #genre').bind('keypress', function(e) {
                if($('#page-add-book #genre').val().length == 0){
                if (e.which == 32){//space bar
                e.preventDefault();
        }
            }
        });
        
        //special_characters
            $('#page-add-book #genre, #add-student, #id-no, #register-form, #username').keyup(function()
            {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
        });//end of special characters
           
              //prevent again spl_chrctr and char  
            $('#add-student').on('keydown', '#id-no', function(e)
            {
                -1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&
            (!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||
            (e.shiftKey||48>e.keyCode||57<e.keyCode)&&
            (96>e.keyCode||105<e.keyCode)&&e.preventDefault()
            });

            $('#register-form').on('keydown', '#username', function(e)
            {
                -1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&
            (!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||
            (e.shiftKey||48>e.keyCode||57<e.keyCode)&&
            (96>e.keyCode||105<e.keyCode)&&e.preventDefault()
            });
            //spl_chrctr and char

            $('#add-student #fname, #lname,#mname').keypress(function (e) {            
            e = e || window.event;
            var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
            var charStr = String.fromCharCode(charCode);
            if (/\d/.test(charStr)) {
                e.preventDefault();
            }
        });//end of spl_chrtr and char
      
        // $('#add-student #lname').keypress(function (e) {            
        //     e = e || window.event;
        //     var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
        //     var charStr = String.fromCharCode(charCode);
        //     if (/\d/.test(charStr)) {
        //         e.preventDefault();
        //     }
        // });
      
        // $('#add-student #mname').keypress(function (e) {            
        //     e = e || window.event;
        //     var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
        //     var charStr = String.fromCharCode(charCode);
        //     if (/\d/.test(charStr)) {
        //         e.preventDefault();
        //     }
        // });
      
        $('#register-form #fname, #mname,#lname').keypress(function (e) {            
            e = e || window.event;
            var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
            var charStr = String.fromCharCode(charCode);
            if (/\d/.test(charStr)) {
                e.preventDefault();
            }
        });
      
        // $('#register-form #mname').keypress(function (e) {            
        //     e = e || window.event;
        //     var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
        //     var charStr = String.fromCharCode(charCode);
        //     if (/\d/.test(charStr)) {
        //         e.preventDefault();
        //     }
        // });
      
        // $('#register-form #lname').keypress(function (e) {            
        //     e = e || window.event;
        //     var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
        //     var charStr = String.fromCharCode(charCode);
        //     if (/\d/.test(charStr)) {
        //         e.preventDefault();
        //     }
        // });// end of function prevent_number_key()
  
        
        // $("#add-student, #id-no").keydown(function(o){
        //             if(o.keyCode == 8){
        //             }
        //             else if($(this).val().length >= 9){
        //                 return false;
        //             }
        // });
            //Only 9 Digit
        $("#register-form #username, #add-student, #id-no").keydown(function(o){
                    if(o.keyCode == 8){
                    }
                    else if($(this).val().length >= 9){
                        return false;
                    }
        });//end of 9 digit

        $("#add-book #isbn").keydown(function(o){
                    if(o.keyCode == 8){
                    }
                    else if($(this).val().length >= 13){
                        return false;
                    }
        });

       }// end of $('#page-login #username, #page-login #password').keyup(function(e)

    function submit_book() {
        check_book_duplicate();
        check_isbn_duplicate();
        $('#add-book').submit(function (e) {
            e.preventDefault();
            var data = $('#add-book').serialize();
            $.post('controller/insert-book.inc.php', data, function (response) {
                console.log(response);
                var response_obj = $.parseJSON(response);
                var is_success = response_obj.is_success;
                var message = response_obj.message;

                $('.message').text(message);

                if (is_success) {
                    $('#add-book')[0].reset();
                } // end of if (is_success)
            }); // end of $.post('controller/add-book.inc.php', data, function(response)            
        }); // end of $('#add-book').submit(function()

    } // end of function submit_book()

    function check_book_duplicate() {
        $('#add-book #title, #add-book #author').on('change', function () {
            var title = $(this).parents('#add-book').find('#title').val();
            var author = $(this).parents('#add-book').find('#author').val();
            console.log('title: ' + title);
            console.log('author: ' + author);
            check_book_duplicate_process(title, author);
        }); // end of $('#add-book #title').on('change', function()

        $('#add-book #title, #add-book #author').on('keyup', function () {
            var title = $(this).parents('#add-book').find('#title').val();
            var author = $(this).parents('#add-book').find('#author').val();
            console.log('title: ' + title);
            console.log('author: ' + author);
            check_book_duplicate_process(title, author);
        }); // end of $('#add-book #title').on('keyup', function()
    } // end of function check_book_duplicate()

    function check_book_duplicate_process(title, author) {
        $.post('controller/check-book-duplicate.inc.php', {
            title: title,
            author: author
        }, function (response) {
            console.log(response);
            var response_obj = $.parseJSON(response);
            var has_duplicate = response_obj.has_duplicate;

            if (has_duplicate) {
                $('#add-book #title')[0].setCustomValidity("There's already a book with the same title and author.");
            } // end of if (has_duplicate)
            else {
                $('#add-book #title')[0].setCustomValidity("");
            } // end of if (!has_duplicate)
        }); // end of $.post('controller/check-book-duplicate.inc.php', {
    } // end of function check_duplicate_book_process()
    
    function check_isbn_duplicate() {
        $('#add-book #isbn').on('change', function() {
            var isbn = $(this).val();
            check_isbn_duplicate_process(isbn);
        }); // end of $('#add-book #isbn').on('change', function() {
        
        $('#add-book #isbn').on('keyup', function() {
            var isbn = $(this).val();
            check_isbn_duplicate_process(isbn);
        }); // end of $('#add-book #isbn').on('keyup', function() {
    } // end of function check_isbn_duplicate()

    function check_isbn_duplicate_process(isbn) {
        $.post('controller/check-isbn-duplicate.inc.php', {
            isbn: isbn
        }, function(response) {
            console.log(response);
            var response_obj = $.parseJSON(response);
            var has_duplicate = response_obj.has_duplicate;
            if (has_duplicate) {
                var title = response_obj.title;
                $('#add-book #isbn')[0].setCustomValidity('ISBN already used by "'+title+'"');
            } // end of if (has_duplicate)
            else {
                $('#add-book #isbn')[0].setCustomValidity('');
            }
        }); // end of $.post('controller/check-isbn-duplicate.inc.php', {
    } // end of function check_isbn_duplicate_process(isbn)
    
    function profile_penalties() {
        if ($('#page-student-profile').length) {
            var total_payables = 0;
            var total_paid = 0;
            var pod = $('#pod').val();
            
            $('.log-row').each(function() {
                var days = $(this).find('.row-col-days').text();
                days = parseInt(days);
                var paid = $(this).find('.row-col-paid').text();
                var penalty = $(this).find('.row-col-penalty').text();
                penalty = parseFloat(penalty);
                
                if (days >= pod && paid == '') {
                    total_payables += penalty;
                } // end of if (days >= pod)
                
                if (paid == 'yes') {
                    total_paid += penalty;
                } // end of if (paid == 'yes')
            }); // end of $('.log-row').each(function()
            
            $('#total-payables').html('&#8369;'+total_payables);
            $('#total-paid').html('&#8369;'+total_paid);
        } // end of if ($('#page-student-profile').length)
    } // end of function profile_penalties()
    
    function reports_penalties() {
        if ($('#page-reports').length) {
            var total_payables = 0;
            var total_paid = 0;
            var combined_penalties = 0;
            var pod = $('#pod').val();
            
            $('.log-row').each(function() {
                var days = $(this).find('.row-col-days').text();
                days = parseInt(days);
                var paid = $(this).find('.row-col-paid').text();
                var penalty = $(this).find('.row-col-penalty').text();
                penalty = parseFloat(penalty);                
                            
                if (days >= pod && paid == '') {
                    total_payables += penalty;
                } // end of if (days >= pod)
                
                if (paid == 'yes') {
                    total_paid += penalty;
                } // end of if (paid == 'yes')
                
                
            }); // end of $('.log-row').each(function()
            
            var combined_penalties = total_payables + total_paid;
            
            $('#total-payables').html('&#8369;'+total_payables);
            $('#total-paid').html('&#8369;'+total_paid);
            $('#combined-penalties').html('&#8369;'+combined_penalties);
            $('#page-reports #total-penalties').show();
        } // end of if ($('#page-student-profile').length)
    } // end of function reports_penalties()
    
    function reports() {
        $('#select-report').change(function () {
            var filter = $(this).val();
            if (filter == 'daily') {
                $('#daily-report-date').addClass('show');
            } // end of if (filter == 'daily')
            else {
                $('#daily-report-date').removeClass('show');
                //$('#daily-report-date').val('');
            } // end of else if (filter != 'daily') {
        }); // end of $('#select-report').change(function()

        $('#report-form').submit(function (e) {
            e.preventDefault();
            var filter = $(this).find('#select-report').val();
            var date = $(this).find('#daily-report-date').val();
            console.log('filter: '+filter);
            console.log('date: '+date);
            
            switch(filter) {
                case 'all':
                    $('#load-report').load('includes/report-all.inc.php', function() {
                        row_counter();
                        reports_penalties();
                    });
                    break;
                case 'borrowed':
                    $('#load-report').load('includes/report-borrowed.inc.php', function() {
                        row_counter();
                        reports_penalties();
                    });
                    break;
                case 'overdue':
                    $('#load-report').load('includes/report-overdue.inc.php', function() {
                        row_counter();
                        reports_penalties();
                    });
                    break;
                case 'returned':
                    $('#load-report').load('includes/report-returned.inc.php', function() {
                        row_counter();
                        reports_penalties();
                    });
                    break;
                case 'daily':
                    $('#load-report').load('includes/report-daily.inc.php', {date: date}, function() {
                        row_counter();
                        reports_penalties();
                    });
                    break;
                case 'lost':
                    $('#load-report').load('includes/report-lost.inc.php', function() {
                        row_counter();
                        reports_penalties();
                    });
                    break;
                case 'lost-unpaid':
                    $('#load-report').load('includes/report-lost-unpaid.inc.php', function() {
                        row_counter();
                        reports_penalties();
                    });
                    break;
                default:
            } // end of switch(filter)
            
            //console.log('filter: '+filter);            
        }); // end of $('#report-form').submit(function(e)
    } // end of function reports()
    
    function row_counter() {
        var row_counter = 0
        $('#page-reports #logs tr').each(function() {
            row_counter++;
        }); // end of $('#page-reports #logs tr').each(function()
        var total_rows = row_counter - 1;
        console.log('total_rows: '+total_rows);
        $('#reports-total-results').text(total_rows);
    } // end of $.fn.row_counter = function()
    
    function print() {
        $(document).on('click', '.print', function(e) {
            window.print();
        }) // end of $(document).on('click', '.print', function(e)
    } // end of function print()

    function js_paths() {
        console.log('document.URL: ' + document.URL);
        console.log('document.location.href: ' + document.location.href);
        console.log('document.location.origin: ' + document.location.origin);
        console.log('document.location.host: ' + document.location.host);
        console.log('document.location.pathname: ' + document.location.pathname);
    } // end of function js_paths()    

    var page = getUrlParameter('page');
    //console.log('page: '+page);

    if (page !== undefined && page !== null) {
        console.log('page: ' + page);
    } else {

    }

    function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    }; // end of var getUrlParameter = function getUrlParameter(sParam)

    var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

}); // end of $(document).ready(function()