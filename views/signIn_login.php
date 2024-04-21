<!-- Modal -->
<div class="modal fade" id="LoginSignup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modalForm">
                <h1 class="modal-title fs-5" id="loginModalTitle">Sign-Up</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modalForm">
                <form id="loginSignupForm" method="post">

                    <input type="hidden" id="action" name="action" value="SignUp">


                    <div class="mb-3" class="contTel">
                        <label for="nome" class="form-label contTel">Full name</label>
                        <input type="text" id="nome" class="form-control contTel" aria-describedby="emailHelp" name="nome">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" id="email" class="form-control" aria-describedby="emailHelp" name="email">
                    </div>

                    <div class="mb-3" class="contTel">
                        <label for="number" class="form-label contTel">Phone number</label>
                        <input type="tel" id="numero" class="form-control contTel" aria-describedby="emailHelp" name="numero">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password">
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-brand" id="toggleLogin">Login</a>
                        <button type="button" id="loginSignUpBtn" class="btn btn-brand">Sign-Up</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<script>
    $('#adminAccess').click(function(evt) {
        evt.preventDefault();
        let action = $("#action");
        let modalTitle = $("#loginModalTitle");
        let loginSignUpBtn = $("#loginSignUpBtn");
        let toggleBtnLog = $("#toggleLogin");

        action.val('adminAccess');
        modalTitle.html('Area Admin');
        loginSignUpBtn.html('Accedi');
        $('.contTel').hide();
        toggleBtnLog.hide();


    });

    $('#userAccess').click(function(evt) {

        let action = $("#action");
        let modalTitle = $("#loginModalTitle");
        let loginSignUpBtn = $("#loginSignUpBtn");
        let toggleBtnLog = $("#toggleLogin");

        if (action.val() === 'adminAccess') {
            action.val('signUp');
            modalTitle.html('Sign Up');
            loginSignUpBtn.html('Sign Up');
            toggleBtnLog.show();
            toggleBtnLog.html('Login');
            $('.contTel').show();
        }
    });

    $('#toggleLogin').click(function(evt) {

        let action = $("#action");
        let modalTitle = $("#loginModalTitle");
        let loginSignUpBtn = $("#loginSignUpBtn");
        let toggleBtnLog = $("#toggleLogin");

        evt.preventDefault();


        if (action.val() === 'login') {
            action.val('signUp');
            modalTitle.html('Sign Up');
            loginSignUpBtn.html('Sign Up');
            toggleBtnLog.html('Login');
            $('.contTel').show();
        } else {
            action.val('login');
            modalTitle.html('Login');
            loginSignUpBtn.html('Login');
            toggleBtnLog.html('Sign Up');
            $('.contTel').hide();

        }
    });

    $('#loginSignUpBtn').click(function(evt) {

        evt.preventDefault();


        $.ajax({
            method: 'POST',
            url: 'actions.php',
            data: $('#loginSignupForm').serialize(),
            success: function(data) {
                try {
                    const result = JSON.parse(data);
                    alert(result.msg);

                    if (result['admin'] === 1 && result.success) {
                        location.href = "areaAdmin.php";
                    }

                    if (!result.success) {
                        location.href = "index.php";
                    }
                } catch (error) {
                    console.error('Errore durante il parsing della risposta AJAX:', error);
                }
            },
            error: function(xhr, status, error) {
                console.log('Errore nella richiesta AJAX:', error);
            }
        });
    });



    $("#logout").click(function(evt) {
        evt.preventDefault();

        $.ajax({
            method: 'POST',
            url: 'actions.php',
            data: $('#formLogout').serialize(),

            success: function(data) {
                console.log(data);
                location.href = "index.php";
            },

            failure: function() {
                console.log(data);
            }
        });

    });


    $("#logoutAdmin").click(function(evt) {
        evt.preventDefault();

        $.ajax({
            method: 'POST',
            url: 'actions.php',
            data: $('#adminFormLogout').serialize(),

            success: function(data) {
                console.log(data);
                location.href = "index.php";
            },

            error: function(xhr, status, error) {
                console.log(error);
            }
        });

    });
</script>