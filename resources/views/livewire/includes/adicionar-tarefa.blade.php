<div>
    <h2>Incluir nova tarefa</h2>
    <form>
        <div>
            <div class="form-container">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" wire:model="nome">
            </div>
            <div class="form-container">
                <label for="custo">Custo:</label>
                <input id="custo" type="number" min="0" step="0.01" wire:model="custo">
            </div>
            <div class="form-container">
                <label for="data-limite">Data Limite:</label>
                <input type="date" id="data-limite" wire:model="dataLimite">
            </div>
        </div>
        <button type="submit" wire:click.prevent="create()">Nova tarefa</button>
    </form>
</div>