<div class="modal fade" id="calendario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modalForm">
        <h1 class="modal-title fs-5" id="loginModalTitle">
          <?php echo isUserLoggedIn() ? "Book an appointment" : "Check available times and Login!"; ?>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modalForm">
        <form id="bookingForm" method="POST">
          <input type="hidden" name="action" value="bookDate">
          <input type="hidden" name="orario" id="boki">
          <input type="hidden" name="servizio" id="servizio" required>

          <div class="step step-1">
            <div class="mb-3">
              <label for="dataScelta" class="form-label text-white fs-6">Choose the day</label>
              <input type="date" class="form-control" name="data" id="dataScelta">
            </div>
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-primary next-step">Next</button>
            </div>
          </div>

          <div class="step step-2 d-none">
            <label class="form-label text-white fs-6">Choose the time</label>
            <div class="container text-center mb-3">
              <div class="row" id="timeButtons">
                <?php
                $array = [
                  1 => "08:00", 2 => "09:00", 3 => "10:00", 4 => "11:00",
                  5 => "12:00", 6 => "13:00", 7 => "14:00", 8 => "15:00",
                  9 => "16:00", 10 => "17:00", 11 => "18:00", 12 => "19:00",
                ];
                for ($i = 1; $i <= 12; $i++) {
                  echo '<input type="button" id="btnOra' . $i . '" class="col m-2 btn rounded-pill btnCalenda" value="' . $array[$i] . '">';
                }
                ?>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary prev-step">Back</button>
              <button type="button" class="btn btn-primary next-step">Next</button>
            </div>
          </div>

          <div class="step step-3 d-none">
            <label class="form-label text-white fs-6">Choose your service</label>
            <div class="row g-3 text-center mt-3" id="serviceOptions">
              <div class="col-4">
                <div class="service-option card bg-dark border-0 text-white" data-value="1">
                  <img src="img/capelli.jpg" alt="Haircut" class="card-img-top imgServiceOption">
                  <div class="card-body p-2">
                    <p class="card-text">Haircut</p>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="service-option card bg-dark border-0 text-white" data-value="2">
                  <img src="img/barba.jpg" alt="Beard" class="card-img-top imgServiceOption">
                  <div class="card-body p-2">
                    <p class="card-text">Beard</p>
                  </div>
                </div>
              </div>
              <div class="col-4"> 
                <div class="service-option card bg-dark border-0 text-white" data-value="3">
                  <img src="img/barba_capelli.jpg" alt="Both" class="card-img-top imgServiceOption">
                  <div class="card-body p-2">
                    <p class="card-text">Both</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-4">
              <button type="button" class="btn btn-secondary prev-step">Back</button>
              <button type="submit" id="bookingBtn" class="btn btn-success">Book</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
  .imgServiceOption {
    height: 150px;
    object-fit: cover;
    border-radius: 0.5rem;
    transition: transform 0.2s, border 0.2s;
  }

  .service-option {
    cursor: pointer;
    border: 3px solid transparent;
    border-radius: 0.75rem;
    transition: border-color 0.3s, transform 0.3s;
  }

  .service-option.selected {
    border-color: #198754;
    transform: scale(1.02);
  }
</style>

<script>
  function resetButtons() {
    $(".btnCalenda").removeClass("btn-primary").addClass("btn-danger").attr("disabled", true);
  }

  function activeButtons(ids) {
    resetButtons();
    ids.map(id => $("#btnOra" + id + ".btnCalenda").removeClass("btn-danger").addClass("btn-primary").removeAttr("disabled"));
  }

  function disactiveButtons(ids) {
    activeButtons([1,2,3,4,5,6,7,8,9,10,11,12].filter(id => !ids.includes(id)));
  }

  $('#dataScelta').change(function() {
    $.ajax({
      method: 'GET',
      url: 'api/orariOccupati.php',
      data: { data: $('#dataScelta').val() },
      success: function(data) {
        disactiveButtons(data);
      }
    });
  });

  for (let i = 1; i <= 12; i++) {
    $('#btnOra' + i).click(function(evt) {
      evt.preventDefault();
      let ora = $(this).val();
      $('#boki').val(ora);
      $('.btnCalenda').removeClass("btn-success");
      $(this).addClass("btn-success");
    });
  }

  $('#serviceOptions .service-option').click(function() {
    $('#serviceOptions .service-option').removeClass('selected');
    $(this).addClass('selected');
    const selectedService = $(this).data('value');
    $('#servizio').val(selectedService);
  });

  $('#bookingForm').submit(function(evt) {
    evt.preventDefault();
    if (!$('#servizio').val()) {
      alert("Please select a service before booking.");
      return;
    }
    $.ajax({
      method: 'POST',
      url: 'actions.php',
      data: $(this).serialize(),
      success: function(response) {
        const result = JSON.parse(response);
        alert(result.msg);
        if (result.success) {
          location.href = "index.php";
        }
      }
    });
  });

  let currentStep = 1;
  function showStep(step) {
    $(".step").addClass("d-none");
    $(".step-" + step).removeClass("d-none");
  }

  $(".next-step").click(() => {
    if (currentStep < 3) currentStep++;
    showStep(currentStep);
  });

  $(".prev-step").click(() => {
    if (currentStep > 1) currentStep--;
    showStep(currentStep);
  });
</script>
