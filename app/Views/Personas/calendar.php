<?= $header ?>
<div class="pc-container my-3">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow-lg border-0">
        <div class="card-body">
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $footer ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const calendario = document.getElementById('calendar');

  const calendar = new FullCalendar.Calendar(calendario, {
    initialView: 'dayGridMonth',
    events: '<?= base_url('personas/calendarData') ?>', // Llama a tu controlador
    eventClick: function(info) {
      alert('Evento: ' + info.event.title + "\nFecha: " + info.event.start.toLocaleDateString());
    }
  });

  calendar.render();
});
</script>