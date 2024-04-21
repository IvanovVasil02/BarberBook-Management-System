<div class="modal fade" id="mioCalendario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modalForm">
                <h1 class="modal-title fs-5" id="loginModalTitle">My reservations</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modalForm">

                <table class="table table-bordered table-dark text-center">
                    <thead>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                    </thead>
                    <tbody>
                        <?php
                        if ($appointments['data']) {
                            foreach ($appointments['data'] as $value) {

                                echo getbookingTpl($value);
                            }
                        } else {
                            echo "<p>Nessuna prenotazione trovata $appointments[msg]</p>";
                        }

                        ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>