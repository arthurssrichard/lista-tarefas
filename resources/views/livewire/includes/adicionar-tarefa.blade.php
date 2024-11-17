<div>
    <h2>Incluir nova tarefa</h2>
    <form>
        <div>
            <div class="form-container">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome">
            </div>
            <div class="form-container">
                <label for="custo">Custo:</label>
                <input name="custo" id="custo" type="number" min="0" step="0.01">
            </div>
            <div class="form-container">
                <label for="data-limite">Data Limite:</label>
                <input type="date" id="data-limite" name="data-limite">
            </div>
        </div>
        <button type="submit">Nova tarefa</button>
    </form>
</div>