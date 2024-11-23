<div class="col-12 bg-light p-3 border border-dark rounded" style="min-height: 19em;">
    <h2>Incluir nova tarefa</h2>
    <form>
        <div>
            <div class="form-container mb-1">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" wire:model="nome" placeholder="Nome" class="card-nome form-control @error('nome') is-invalid @enderror" @if($editingTarefaId) readonly @endif>
                @error('nome')
                    <small class="text-danger ">{!!$message!!}</small>
                @enderror
            </div>
            <div class="form-container mb-1">
                <label for="custo">Custo:</label>
                <input id="custo" type="number" min="0" step="0.01" wire:model="custo" placeholder="Custo" class="card-custo form-control @error('custo') is-invalid @enderror" @if($editingTarefaId) readonly @endif>
                @error('custo')
                    <small class="text-danger ">{!!$message!!}</small>
                @enderror
            </div>
            <div class="form-container mb-2">
                <label for="data-limite">Data Limite:</label>
                <input type="date" id="data-limite" wire:model="dataLimite" class="card-data form-control @error('dataLimite') is-invalid @enderror" @if($editingTarefaId) readonly @endif>
                @error('dataLimite')
                    <small class="text-danger ">{!!$message!!}</small>
                @enderror
            </div>
        </div>
        @if(!$editingTarefaId) {{-- Desabilita os botão caso alguma tarefa esteja em edição (editingTarefaId setado) --}}
            <button type="submit" wire:click.prevent="create()" class="btn btn-success p-1" readonly>Incluir</button>
        @endif
    </form>
</div>