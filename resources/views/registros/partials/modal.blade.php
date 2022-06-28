<!-- Modal Foto Registro -->
<div class="modal fade" id="modalFotoRegistro" tabindex="-1" role="dialog" aria-labelledby="Foto" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Foto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
            <img id="fotoRegistro" class="rounded img-thumbnail p-3 mt-3" alt="Foto">
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
        // Modal Foto Registro
        $('#modalFotoRegistro').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var modal = $(this)
            var array = recipient.split(',')
            var nome = array[0]
            var foto = array[1]
            modal.find('.modal-title').text(nome)
            $("#fotoRegistro").attr("src", foto.trim().replace(/'/g, ""))
        });
    });
</script>
@endsection