<div class="modal fade" id="calendario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modalForm">

                <?php if (isUserLoggedIn()) { ?>
                    <h1 class="modal-title fs-5" id="loginModalTitle">Book an appointment</h1>
                <?php } else { ?>
                    <h1 class="modal-title fs-5" id="loginModalTitle">Check available times and Login!</h1>
                <?php } ?>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modalForm">
                <form id="bookingForm" method="GET">

<<<<<<< HEAD
                    <input type="hidden" name="action" value="bookDate">
=======
                    <input type="hidden" id="action" name="action" value="bookDate">
>>>>>>> BarberBook-A-Barber-Appointment-Management-System

                    <div class="mb-3">
                        <label for="nome" class="form-label" style="color:#fff; font-size:18px">Choose the day</label>
                        <input type="date" class="form-control" aria-describedby="emailHelp" name="data" id="dataScelta">
                    </div>

                    <?php if (isUserLoggedIn()) { ?>

                        <div class="mb-3">
                            <label for="nome" class="form-label" style="color:#fff; font-size:18px">Choose the time</label>
                            <input type="text" id="boki" name="orario" class="form-control" aria-describedby="emailHelp" name="boh">
                        </div>

                    <?php } ?>


                    <div class="container text-center">
                        <div class="mb-3 row">
                            <?php

                            $array = array(
                                1 => "08:00",
                                2 => "09:00",
                                3 => "10:00",
                                4 => "11:00",
                                5 => "12:00",
                                6 => "13:00",
                                7 => "14:00",
                                8 => "15:00",
                                9 => "16:00",
                                10 => "17:00",
                                11 => "18:00",
                                12 => "19:00",


                            );

                            $btnClass = " ";
                            $btnFunction = " ";
                            $datascelta = "<script> myFunction();</script>";

                            for ($i = 1; $i < 13; $i++) {

                                echo '
                                        <input type="button" id="btnOra' . $i . '" class="col m-2 btn rounded-pill btnCalenda" value="' . $array[$i] . '">
                                        ';
                            }
                            ?>
                        </div>
                    </div>
                    <?php if (isUserLoggedIn()) { ?>
                        <div class="form-group col-12 mt-4 d-flex justify-content-center">
                            <button type="submit" id="bookingBtn" class=" col-6 btn btn-brand rounded-pill">Book</button>
                        </div>

                    <?php } ?>


                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function resetButtons() {
        $(".btnCalenda").removeClass("btn-primary").addClass("btn-danger").attr("disabled", true);
    }

    function activeButtons(ids) {
        resetButtons();
        ids.map(id => $("#btnOra" + id + ".btnCalenda").removeClass("btn-danger").addClass("btn-primary").removeAttr("disabled"));
    }

    function disactiveButtons(ids) {
        activeButtons([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].filter(id => !(ids.includes(id))));
    }



    $('#dataScelta').change(function(evt) {

        $.ajax({
            method: 'GET',
            url: 'api/orariOccupati.php',
            data: {
                data: $('#dataScelta').val()
            },
            success: (data) => {
                disactiveButtons(data);
            },
            failure: function() {
                console.log(data);
            }
        });



    });

    for (let i = 1; i < 13; i++) {
        $('#btnOra' + i).click(function(evt) {
            evt.preventDefault();

            let ora = $('#btnOra' + i).val();
            $('#boki').val(ora.toString());
        });

    }

    $('#bookingBtn').click(function(evt) {
        evt.preventDefault();

        let poso = $('#bookingForm').serialize();



        $.ajax({
            method: 'POST',
            url: 'actions.php',
            data: $('#bookingForm').serialize(),
            success: function(data) {
                const result = JSON.parse(data);
                alert(result.msg);

                if (result.success) {
                    location.href = "index.php";
                }
            },
            failure: function() {
                console.log(data);
            }
        });

    });
</script>