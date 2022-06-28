<!-- Modal Foto Monitor -->
<div class="modal fade" id="modalFotoMonitor" tabindex="-1" role="dialog" aria-labelledby="Foto" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Foto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
            <img id="fotoMonitor" class="rounded img-thumbnail p-3" src="" alt="foto">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>

@section('javascripts_bottom')
@parent
<script>
    $(document).ready(function() {
        // Modal Foto Monitor
        $('#modalFotoMonitor').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var modal = $(this)
            var array = recipient.split(',')
            var nome = array[0]
            var foto = array[1]
            modal.find('.modal-title').text(nome)
            $("#fotoMonitor").attr("src", "data:image/png;base64, " + foto)
        });
    });
</script>
@endsection