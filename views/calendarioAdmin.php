<div class="modal fade" id="mioCalendario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modalForm">
                <h1 class="modal-title fs-5" id="loginModalTitle">Appointments Agenda</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modalForm p-0">
                <table class="table table-bordered table-dark text-center mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Full name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentsBody">
                        <?php
                        if (!empty($appointments['data'])) {
                            foreach ($appointments['data'] as $value) {
                                echo '<tr data-id="' . htmlspecialchars($value['id']) . '">';
                                echo getAllbookings($value);
                                echo '<td><button class="btn btn-sm btn-warning edit-btn" data-id="' . htmlspecialchars($value['id']) . '">Edit</button></td>';
                                echo '<td><button class="btn btn-sm btn-danger delete-btn" data-id="' . htmlspecialchars($value['id']) . '">Delete</button></td>';
                                echo '</tr>';
                            }
                        } else {
                            echo "<tr><td colspan='6'>Nessuna prenotazione trovata {$appointments['msg']}</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editBookingForm" class="modal-content">
            <div class="modal-header modalForm">
                <h5 class="modal-title" id="editModalLabel">Edit Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modalForm">
                <input type="hidden" name="action" value="editBooking">
                <input type="hidden" name="id" id="editId">
                <div class="mb-3">
                    <label class="form-label text-white">Date</label>
                    <input type="date" class="form-control" name="data" id="editData" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-white">Time</label>
                    <input type="time" class="form-control" name="orario" id="editOrario" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function refreshAppointments() {
        $.ajax({
            method: 'POST',
            url: 'actions.php',
            data: {
                action: 'getAppointments'
            },
            success: function(response) {
                let res = JSON.parse(response);
                let tbody = '';
                if (res.success && res.data.length) {
                    res.data.forEach(value => {
                        tbody += `<tr data-id="${value.id}">
                        <td>${value.nome}</td>
                        <td>${value.telefono}</td>
                        <td>${value.data}</td>
                        <td>${value.orario}</td>
                        <td><button class="btn btn-sm btn-warning edit-btn" data-id="${value.id}">Edit</button></td>
                        <td><button class="btn btn-sm btn-danger delete-btn" data-id="${value.id}">Delete</button></td>
                    </tr>`;
                    });
                } else {
                    tbody = `<tr><td colspan="6">Nessuna prenotazione trovata</td></tr>`;
                }
                $('#appointmentsBody').html(tbody);
            }
        });
    }

    $('#mioCalendario').on('shown.bs.modal', refreshAppointments);

    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        if (confirm('Sei sicuro di voler eliminare questo appuntamento?')) {
            $.ajax({
                method: 'POST',
                url: 'actions.php',
                data: {
                    action: 'deleteBooking',
                    id: id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    alert(res.msg);
                    if (res.success) {
                        refreshAppointments();
                    }
                }
            });

        }
    });

    $(document).on('click', '.edit-btn', function() {
        const row = $(this).closest('tr');
        const id = $(this).data('id');
        const data = row.find('td:eq(2)').text().trim();
        const orario = row.find('td:eq(3)').text().trim();

        $('#editId').val(id);
        $('#editData').val(data);
        $('#editOrario').val(orario);
        $('#editModal').modal('show');
    });

    $('#editBookingForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: 'actions.php',
            data: $(this).serialize(),
            success: function(response) {
                let res = JSON.parse(response);
                alert(res.msg);
                if (res.success) {
                    $('#editModal').modal('hide');
                    refreshAppointments();
                }
            }
        });
    });
</script>