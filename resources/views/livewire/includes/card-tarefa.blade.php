<div class="bg-light mt-1 p-2">
    <h3>{{$tarefa->nome}}</h3>
    <p><strong>Custo: </strong>R$ {{number_format($tarefa->custo,2,',','.')}}</p>
    <p><strong>Data limite: </strong>{{$tarefa->data_limite}}</p>
    <div>
        <ion-icon title="Apagar registro" name="trash-outline"></ion-icon>
        <ion-icon title="Editar registro" name="create-outline"></ion-icon>
    </div>
</div>