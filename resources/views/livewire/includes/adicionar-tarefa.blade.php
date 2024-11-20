<div class="col-10 bg-light p-3 border border-dark rounded">
    <h2>Incluir nova tarefa</h2>
    <form>
        <div>
            <div class="form-container">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" wire:model="nome" placeholder="Nome" class="card-nome form-control mb-1">
            </div>
            <div class="form-container">
                <label for="custo">Custo:</label>

                <input id="custo" type="number" min="0" step="0.01" wire:model="custo" placeholder="Custo" class="card-custo form-control mb-1">
            </div>
            <div class="form-container">
                <label for="data-limite">Data Limite:</label>
                <input type="date" id="data-limite" wire:model="dataLimite" class="card-data form-control mb-2" placeholder="dd-mm-yyyy">
            </div>
        </div>
        <button type="submit" wire:click.prevent="create()" class="btn btn-success p-1">Incluir</button>
    </form>
</div>